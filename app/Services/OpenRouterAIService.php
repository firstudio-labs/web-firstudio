<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class OpenRouterAIService
{
    private $client;
    private $apiKey;
    private $baseUrl;
    private $models;
    private $currentModel;

    public function __construct()
    {
        $this->client = new Client();
        
        // Coba ambil dari database terlebih dahulu, jika tidak ada fallback ke .env
        $dbApiKey = Setting::where('key', 'openrouter_api_key')->value('value');
        $this->apiKey = !empty($dbApiKey) ? $dbApiKey : config('services.openrouter.api_key');
        
        $this->baseUrl = 'https://openrouter.ai/api/v1/chat/completions';

        // Rekomendasi model di OpenRouter (prioritas kualitas → kecepatan)
        $this->models = [
            'mistralai/mistral-small-3.2-24b-instruct:free' => [
                'name' => 'mistralai/mistral-small-3.2-24b-instruct:free',
                'description' => 'Mistral Small 3.2 24B (free tier)',
                'best_for' => ['general', 'longform', 'speed']
            ],
            'anthropic/claude-3.5-sonnet' => [
                'name' => 'anthropic/claude-3.5-sonnet',
                'description' => 'High-quality reasoning and writing',
                'best_for' => ['analysis', 'reasoning', 'longform']
            ],
            'meta-llama/llama-3.1-405b-instruct' => [
                'name' => 'meta-llama/llama-3.1-405b-instruct',
                'description' => 'Strong general-purpose writing',
                'best_for' => ['general', 'longform']
            ],
            'deepseek/deepseek-chat' => [
                'name' => 'deepseek/deepseek-chat',
                'description' => 'Fast general chat model',
                'best_for' => ['general', 'speed']
            ],
        ];

        // Default menggunakan model Mistral (free tier)
        $this->currentModel = 'mistralai/mistral-small-3.2-24b-instruct:free';
    }

    /**
     * Generate artikel menggunakan OpenRouter (prompt sama seperti DeepSeek)
     *
     * @param string $judul
     * @param string|null $kategori
     * @param int $minWords
     * @param string|null $customPrompt
     * @return array
     */
    public function generateArtikel($judul, $kategori = null, $minWords = 500, $customPrompt = null)
    {
        try {
            if (empty($this->apiKey)) {
                throw new \Exception('OpenRouter API key tidak ditemukan. Pastikan OPENROUTER_API_KEY sudah diset di file .env');
            }

            // Pilih model optimal berdasarkan kompleksitas (mirip DeepSeek)
            $this->selectOptimalModel($minWords, $customPrompt);

            $prompt = $this->buildPrompt($judul, $kategori, $minWords, $customPrompt);

            Log::info("Using OpenRouter AI for article generation");
            return $this->executeWithRetry(function() use ($prompt, $judul, $minWords) {
                $response = $this->client->post($this->baseUrl, [
                    'headers' => $this->buildHeaders(),
                    'json' => [
                        'model' => $this->currentModel,
                        'messages' => [
                            [
                                'role' => 'user',
                                'content' => $prompt
                            ]
                        ],
                        // Parameter OpenAI-compatible
                        'max_tokens' => $this->getOptimalMaxTokens($minWords),
                        'temperature' => 0.6,
                        'top_p' => 0.9,
                        'frequency_penalty' => 0.25,
                        'presence_penalty' => 0.1,
                        'stream' => false
                    ],
                    'timeout' => 75,
                    'connect_timeout' => 10
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                if (isset($data['choices'][0]['message']['content'])) {
                    $generatedContent = $data['choices'][0]['message']['content'];
                    $cleanContent = $this->formatContent($generatedContent, $judul);

                    return [
                        'success' => true,
                        'content' => $cleanContent,
                        'raw_content' => $generatedContent,
                        'word_count' => str_word_count(strip_tags($cleanContent)),
                        'provider' => 'openrouter'
                    ];
                }

                Log::error('OpenRouter API response tidak valid', ['response' => $data]);
                throw new \Exception('Response dari OpenRouter API tidak valid');
            });

        } catch (\Exception $e) {
            Log::error('OpenRouter service error: ' . $e->getMessage());
            throw new \Exception($this->getUserFriendlyErrorMessage($e->getMessage()));
        }
    }

    /**
     * Build prompt sama seperti DeepSeek
     */
    private function buildPrompt($judul, $kategori = null, $minWords = 500, $customPrompt = null)
    {
        $kategoriText = $kategori ? " kategori {$kategori}" : "";
        $customPromptText = $customPrompt ? "\nTambahan: {$customPrompt}" : "";

        return "Tulis artikel {$minWords} kata tentang '{$judul}'{$kategoriText}.{$customPromptText}

FORMAT:
- Langsung mulai paragraf pembuka (JANGAN tulis judul lagi)
- HTML: <p>, <h2>, <h3>, <ul>, <ol>, <strong>
- Struktur: intro → content sections → kesimpulan
- Bahasa Indonesia yang baik

MULAI:";
    }

    /**
     * Format konten seperti DeepSeek
     */
    private function formatContent($content, $judul = null)
    {
        $content = preg_replace('/^```html\s*/i', '', $content);
        $content = preg_replace('/^```\s*/m', '', $content);
        $content = preg_replace('/\s*```\s*$/m', '', $content);

        $content = preg_replace('/<\?xml[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<!DOCTYPE[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<\/?html[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<\/?head[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<\/?body[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<title[^>]*>.*?<\/title>\s*/i', '', $content);
        $content = preg_replace('/<meta[^>]*>\s*/i', '', $content);

        $content = preg_replace('/^#+\s+.*$/m', '', $content);

        $content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $content);
        $content = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $content);
        $content = preg_replace('/`(.*?)`/', '<code>$1</code>', $content);

        $content = preg_replace('/^\s*(\d+)\.\s+(.*)$/m', '<li>$2</li>', $content);
        $content = preg_replace('/^\s*[-\*\+]\s+(.*)$/m', '<li>$1</li>', $content);

        $content = preg_replace_callback('/(<li>.*?<\/li>)(\s*<li>.*?<\/li>)+/s', function($matches) {
            $listContent = $matches[0];
            if (preg_match('/\b(langkah|step|tahap|cara|urutan|pertama|kedua|ketiga)\b/i', $listContent)) {
                return "<ol>\n" . $listContent . "\n</ol>";
            } else {
                return "<ul>\n" . $listContent . "\n</ul>";
            }
        }, $content);

        $content = str_replace('<ul><li>', "<ul>\n<li>", $content);
        $content = str_replace('<ol><li>', "<ol>\n<li>", $content);
        $content = str_replace('</li></ul>', "</li>\n</ul>", $content);
        $content = str_replace('</li></ol>', "</li>\n</ol>", $content);
        $content = preg_replace('/<\/li>\s*<li>/', "</li>\n<li>", $content);

        $content = preg_replace('/^(berikut|ini|artikel|konten|tulisan)(\s+(adalah|ini|berikut|tentang))*[:\.]?\s*/i', '', $content);
        $content = preg_replace('/^(berdasarkan|sesuai dengan|untuk).*?(berikut|adalah)[:\.]?\s*/i', '', $content);
        $content = preg_replace('/semoga.*?(bermanfaat|membantu)\.??\s*$/i', '', $content);

        if ($judul) {
            $content = preg_replace('/^' . preg_quote($judul, '/') . '\s*/i', '', $content);
            $content = preg_replace('/<h[1-6][^>]*>\s*' . preg_quote($judul, '/') . '\s*<\/h[1-6]>\s*/i', '', $content);
            $titleWords = explode(' ', $judul);
            if (count($titleWords) >= 2) {
                $firstTwoWords = implode('\\s+', array_slice($titleWords, 0, 2));
                $content = preg_replace('/^.*?' . $firstTwoWords . '.*?\n/i', '', $content);
            }
        }

        $content = preg_replace('/\n{3,}/', "\n\n", $content);
        $content = trim($content);

        $lines = explode("\n", $content);
        $formattedContent = [];
        $currentParagraph = '';

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                if (!empty($currentParagraph)) {
                    $formattedContent[] = $this->wrapParagraph($currentParagraph);
                    $currentParagraph = '';
                }
                continue;
            }

            if (preg_match('/^<(h[1-6]|ul|ol|\/ul|\/ol)/i', $line)) {
                if (!empty($currentParagraph)) {
                    $formattedContent[] = $this->wrapParagraph($currentParagraph);
                    $currentParagraph = '';
                }
                $formattedContent[] = $line;
                continue;
            }

            if (preg_match('/^<li>/i', $line)) {
                $formattedContent[] = $line;
                continue;
            }

            if (!empty($currentParagraph)) {
                $currentParagraph .= ' ' . $line;
            } else {
                $currentParagraph = $line;
            }
        }

        if (!empty($currentParagraph)) {
            $formattedContent[] = $this->wrapParagraph($currentParagraph);
        }

        $result = [];
        for ($i = 0; $i < count($formattedContent); $i++) {
            $current = $formattedContent[$i];
            if ($i > 0 && preg_match('/^<h[1-6]/i', $current)) {
                $result[] = '';
            }
            $result[] = $current;
            if (preg_match('/^<\/(ul|ol)>/i', $current) && $i < count($formattedContent) - 1) {
                $result[] = '';
            }
        }

        return implode("\n", $result);
    }

    private function wrapParagraph($content)
    {
        $content = trim($content);
        if (preg_match('/^<(h[1-6]|div|ul|ol|li|blockquote|pre|table|p)/i', $content)) {
            return $content;
        }
        if (preg_match('/<\/(h[1-6]|div|ul|ol|li|blockquote|pre|table|p)>$/i', $content)) {
            return $content;
        }
        return '<p>' . $content . '</p>';
    }

    /**
     * Generate 5 judul artikel
     */
    public function generateJudul($topik, $kategori = null)
    {
        try {
            if (empty($this->apiKey)) {
                throw new \Exception('OpenRouter API key tidak ditemukan');
            }

            $kategoriText = $kategori ? " dalam kategori {$kategori}" : "";
            $prompt = "Buatkan 5 judul artikel yang menarik dan SEO-friendly untuk topik '{$topik}'{$kategoriText}. 

PERSYARATAN JUDUL:
- Maksimal 60 karakter untuk SEO
- Menarik dan clickable
- Mengandung kata kunci utama
- Sesuai dengan target audience Indonesia
- Hindari clickbait yang berlebihan

FORMAT RESPONSE:
Berikan dalam format list sederhana, satu judul per baris, tanpa numbering atau bullet points.

Mulai generate 5 judul sekarang:";

            Log::info("Using OpenRouter AI for title generation");
            $response = $this->client->post($this->baseUrl, [
                'headers' => $this->buildHeaders(),
                'json' => [
                    'model' => $this->currentModel,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 300,
                    'temperature' => 0.7,
                    'top_p' => 0.9,
                    'stream' => false
                ],
                'timeout' => 60
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['choices'][0]['message']['content'])) {
                $titlesText = $data['choices'][0]['message']['content'];
                $lines = explode("\n", $titlesText);
                $titles = [];
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line) || preg_match('/^\d+\.?\s*$/', $line)) continue;
                    $line = preg_replace('/^\d+\.\s*/', '', $line);
                    $line = preg_replace('/^[-\*]\s*/', '', $line);
                    $line = trim($line);
                    if (!empty($line) && strlen($line) > 10) {
                        $titles[] = $line;
                    }
                }

                return [
                    'success' => true,
                    'titles' => array_slice($titles, 0, 5),
                    'provider' => 'openrouter'
                ];
            }

            throw new \Exception('Response dari OpenRouter API tidak valid');
        } catch (\Exception $e) {
            Log::error('OpenRouter title generation error: ' . $e->getMessage());
            throw new \Exception($this->getUserFriendlyErrorMessage($e->getMessage()));
        }
    }

    /**
     * Enhancement konten
     */
    public function enhanceContent($content, $enhanceType = 'improve', $judul = null)
    {
        try {
            if (empty($this->apiKey)) {
                throw new \Exception('OpenRouter API key tidak ditemukan');
            }

            $prompt = $this->buildEnhancePrompt($content, $enhanceType, $judul);

            Log::info("Using OpenRouter AI for content enhancement");
            return $this->executeWithRetry(function() use ($prompt, $enhanceType, $judul) {
                $response = $this->client->post($this->baseUrl, [
                    'headers' => $this->buildHeaders(),
                    'json' => [
                        'model' => $this->currentModel,
                        'messages' => [
                            [
                                'role' => 'user',
                                'content' => $prompt
                            ]
                        ],
                        'max_tokens' => 4000,
                        'temperature' => 0.6,
                        'stream' => false
                    ],
                    'timeout' => 75,
                    'connect_timeout' => 10
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                if (isset($data['choices'][0]['message']['content'])) {
                    $enhancedContent = $data['choices'][0]['message']['content'];
                    $cleanContent = $this->formatContent($enhancedContent, $judul);

                    return [
                        'success' => true,
                        'content' => $cleanContent,
                        'raw_content' => $enhancedContent,
                        'word_count' => str_word_count(strip_tags($cleanContent)),
                        'enhancement_type' => $enhanceType,
                        'provider' => 'openrouter'
                    ];
                } else {
                    Log::error('OpenRouter API response tidak valid untuk enhance', ['response' => $data]);
                    throw new \Exception('Response dari OpenRouter API tidak valid');
                }
            });

        } catch (\Exception $e) {
            Log::error('OpenRouter enhance service error: ' . $e->getMessage());
            throw new \Exception($this->getUserFriendlyErrorMessage($e->getMessage()));
        }
    }

    private function buildEnhancePrompt($content, $enhanceType, $judul = null)
    {
        $judulText = $judul ? " dengan topik '{$judul}'" : "";

        $instructions = [
            'improve' => 'Perbaiki grammar, gaya penulisan, dan alur cerita. Pastikan bahasa Indonesia yang digunakan baku dan mudah dipahami.',
            'expand' => 'Perluas konten dengan menambahkan detail, contoh, dan penjelasan yang lebih mendalam. Tambahkan informasi yang relevan dan berguna.',
            'seo' => 'Optimasi untuk SEO dengan menambahkan keyword yang relevan, memperbaiki struktur heading, dan membuat konten lebih search-friendly.',
            'restructure' => 'Restructure format artikel dengan heading yang lebih baik, paragraf yang lebih terorganisir, dan flow yang lebih logical.'
        ];

        $instruction = $instructions[$enhanceType] ?? $instructions['improve'];

        return "Enhance konten artikel berikut{$judulText}. 

INSTRUKSI ENHANCEMENT: {$instruction}

PENTING - ATURAN FORMAT:
- JANGAN tambahkan atau ulangi judul artikel
- JANGAN gunakan tag <h1> atau heading level 1
- JANGAN gunakan format markdown (```, **, *, #)
- JANGAN tambahkan pembukaan seperti 'Berikut hasil enhancement...'
- MULAI LANGSUNG dengan konten yang sudah dienhance

KONTEN ASLI:
{$content}

PERSYARATAN ENHANCEMENT:
- Pertahankan inti dan makna utama artikel
- Gunakan bahasa Indonesia yang baik dan benar
- Format dalam HTML yang bersih dan valid dengan spacing yang proper
- Gunakan <p> untuk paragraf dengan spacing antar paragraf
- Gunakan <h2>/<h3> untuk heading (BUKAN <h1>)
- Gunakan <strong> untuk penekanan, <em> untuk emphasis
- Gunakan <ol> untuk numbered list (langkah-langkah, urutan)
- Gunakan <ul> untuk bullet points (manfaat, fitur, tips)
- Berikan spacing yang cukup antar section untuk readability
- Jangan mengubah fakta atau informasi penting yang sudah ada
- Hasil harus tetap natural, mudah dibaca, dan SEO-friendly
- Perbaiki struktur paragraf agar tidak terlalu panjang (3-5 kalimat per paragraf)
- Pastikan flow artikel logis dan koheren
- Buat konten yang scannable dengan heading dan list yang jelas

KAIDAH FORMATTING YANG HARUS DIIKUTI:
- Setiap paragraf dipisah dengan line break
- Spasi kosong sebelum heading baru
- Spasi kosong setelah list
- Numbered list untuk langkah-langkah/urutan
- Bullet points untuk manfaat/tips/fitur
- Heading yang informatif dan menarik

Mulai SEKARANG dengan konten yang sudah dienhance:";
    }

    /**
     * Retry mechanism
     */
    private function executeWithRetry(callable $request, $maxRetries = 3)
    {
        $attempt = 0;
        $waitTimeBase = 2; // Waktu tunggu dasar dalam detik

        while ($attempt < $maxRetries) {
            try {
                return $request();

            } catch (RequestException $e) {
                $attempt++;
                $errorMessage = $e->getMessage();
                
                // Log detail error untuk debugging
                Log::warning("OpenRouter API error attempt {$attempt}/{$maxRetries}: " . $errorMessage);

                if ($e->hasResponse()) {
                    $statusCode = $e->getResponse()->getStatusCode();
                    $errorBody = $e->getResponse()->getBody()->getContents();
                    $errorData = json_decode($errorBody, true);
                    
                    // Log detail response error
                    Log::warning("OpenRouter API response status: {$statusCode}, body: " . substr($errorBody, 0, 200));

                    // Cek rate limit (429) atau error server (5xx)
                    if ($statusCode == 429 || ($statusCode >= 500 && $statusCode < 600)) {
                        if ($attempt < $maxRetries) {
                            // Exponential backoff dengan jitter (acak +/- 20%)
                            $waitTime = pow($waitTimeBase, $attempt) * (0.8 + 0.4 * mt_rand() / mt_getrandmax());
                            $waitTime = round($waitTime, 1);
                            
                            Log::warning("OpenRouter API rate limited/overloaded, retry attempt {$attempt}/{$maxRetries} in {$waitTime}s");
                            sleep($waitTime);
                            continue;
                        }
                    }
                    
                    // Error message dari response body
                    if (isset($errorData['error']['message'])) {
                        $errorMessage = $errorData['error']['message'];
                        
                        // Cek error rate limit dalam pesan
                        if (stripos($errorMessage, 'rate limit') !== false ||
                            stripos($errorMessage, 'too many requests') !== false ||
                            stripos($errorMessage, 'quota') !== false ||
                            stripos($errorMessage, 'overloaded') !== false) {

                            if ($attempt < $maxRetries) {
                                // Exponential backoff dengan jitter
                                $waitTime = pow($waitTimeBase, $attempt) * (0.8 + 0.4 * mt_rand() / mt_getrandmax());
                                $waitTime = round($waitTime, 1);
                                
                                Log::warning("OpenRouter API rate limited/overloaded, retry attempt {$attempt}/{$maxRetries} in {$waitTime}s");
                                sleep($waitTime);
                                continue;
                            } else {
                                throw new \Exception("OpenRouter API sedang sibuk atau rate limited. Silakan coba lagi dalam beberapa menit.");
                            }
                        }
                    }
                }

                // Retry untuk error lain juga
                if ($attempt < $maxRetries) {
                    $waitTime = pow($waitTimeBase, $attempt);
                    Log::warning("OpenRouter API error, retry attempt {$attempt}/{$maxRetries} in {$waitTime}s");
                    sleep($waitTime);
                    continue;
                } else {
                    throw new \Exception('Gagal menghubungi OpenRouter API setelah ' . $maxRetries . ' percobaan: ' . $errorMessage);
                }
            }
        }

        throw new \Exception('Unexpected error in retry logic');
    }

    private function getUserFriendlyErrorMessage($errorMessage)
    {
        $lower = strtolower($errorMessage);
        if (strpos($lower, 'api key') !== false || strpos($lower, 'unauthorized') !== false) {
            return 'API key OpenRouter tidak valid. Silakan periksa OPENROUTER_API_KEY di file .env';
        }
        if (strpos($lower, 'rate limit') !== false || strpos($lower, 'too many') !== false) {
            return 'Terlalu banyak permintaan ke OpenRouter. Silakan tunggu beberapa menit.';
        }
        if (strpos($lower, 'quota') !== false || strpos($lower, 'insufficient') !== false) {
            return 'Kuota OpenRouter API telah habis. Silakan periksa dashboard OpenRouter atau upgrade plan.';
        }
        if (strpos($lower, 'timeout') !== false || strpos($lower, 'connection') !== false) {
            return 'Koneksi ke OpenRouter API gagal. Periksa internet Anda dan coba lagi.';
        }
        return 'Terjadi kesalahan pada layanan OpenRouter AI. Coba lagi nanti atau hubungi administrator.';
    }

    /**
     * Pilih model optimal (agresif kecepatan → kualitas bila kompleks)
     */
    private function selectOptimalModel($minWords, $customPrompt = null)
    {
        // Selalu gunakan Mistral free sesuai permintaan pengguna
        $this->currentModel = 'mistralai/mistral-small-3.2-24b-instruct:free';
        Log::info("Selected OpenRouter model fixed to: {$this->currentModel}");
    }

    /**
     * Hitung max tokens
     */
    private function getOptimalMaxTokens($minWords)
    {
        $estimatedTokens = (int)($minWords * 1.2);
        $maxTokens = $estimatedTokens + 500;
        return min(max($maxTokens, 1500), 4000);
    }

    /**
     * Generate deskripsi produk menggunakan OpenRouter AI (Mistral)
     * 
     * @param string $judul
     * @param string|null $kategori
     * @param string|null $customPrompt
     * @return array
     */
    public function generateDeskripsiProduk($judul, $kategori = null, $customPrompt = null)
    {
        try {
            if (empty($this->apiKey)) {
                throw new \Exception('OpenRouter API key tidak ditemukan');
            }

            // Validate input
            if (empty($judul) || !is_string($judul)) {
                throw new \Exception('Judul produk harus diisi dan berupa string');
            }

            if (strlen($judul) > 255) {
                throw new \Exception('Judul produk terlalu panjang (maksimal 255 karakter)');
            }

            if ($customPrompt && strlen($customPrompt) > 1000) {
                throw new \Exception('Custom prompt terlalu panjang (maksimal 1000 karakter)');
            }

            $kategoriText = $kategori ? " dalam kategori {$kategori}" : "";
            $customPromptText = $customPrompt ? "\n\nINSTRUKSI KHUSUS: {$customPrompt}" : "";
            
            $prompt = "Buatkan 2 deskripsi produk singkat untuk '{$judul}'{$kategoriText}.

PERSYARATAN:
- Panjang: 100-200 kata per deskripsi
- Bahasa: Indonesia
- Format: HTML sederhana
- Fokus: Keunggulan utama dan manfaat

FORMAT: (1) dan (2) di awal setiap deskripsi.

{$customPromptText}

Generate sekarang:";

            Log::info("Using OpenRouter AI (Mistral) for product description generation");
            $response = $this->client->post($this->baseUrl, [
                'headers' => $this->buildHeaders(),
                'json' => [
                    'model' => $this->currentModel,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 200, // Reduced to prevent PostTooLargeException
                    'temperature' => 0.7,
                    'top_p' => 0.9,
                    'stream' => false
                ],
                'timeout' => 60
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['choices'][0]['message']['content'])) {
                $content = trim($data['choices'][0]['message']['content']);
                
                // Parse multiple descriptions
                $descriptions = $this->parseMultipleDescriptions($content);
                
                Log::info("OpenRouter AI product descriptions generated successfully", ['count' => count($descriptions)]);
                
                return [
                    'success' => true,
                    'descriptions' => $descriptions,
                    'provider' => 'openrouter',
                    'model' => 'mistralai/mistral-small-3.2-24b-instruct:free'
                ];
            } else {
                Log::error('OpenRouter AI response format unexpected', ['response' => $data]);
                throw new \Exception('Format response AI tidak sesuai');
            }

        } catch (RequestException $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 0;
            
            Log::error("OpenRouter API request failed: {$errorMessage}", [
                'status_code' => $statusCode,
                'judul' => $judul,
                'kategori' => $kategori
            ]);
            
            // Handle specific error cases
            if ($statusCode === 401) {
                throw new \Exception('OpenRouter API key tidak valid');
            } elseif ($statusCode === 429) {
                throw new \Exception('Rate limit OpenRouter API terlampaui, coba lagi nanti');
            } elseif ($statusCode === 402) {
                throw new \Exception('OpenRouter API kehabisan kredit, silakan top up');
            } elseif ($statusCode === 0) {
                throw new \Exception('Tidak dapat terhubung ke OpenRouter API, periksa koneksi internet');
            } else {
                throw new \Exception("OpenRouter API error: {$errorMessage}");
            }
        } catch (\Exception $e) {
            Log::error("OpenRouter AI product description generation failed: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Test ketersediaan layanan (lightweight check)
     */
    public function isAvailable()
    {
        if (empty($this->apiKey)) {
            Log::warning('OpenRouter API key is empty');
            return false;
        }

        // Basic validation - check if API key format is correct
        // OpenRouter API keys start with 'sk-or-' followed by alphanumeric characters
        if (!preg_match('/^sk-or-[a-zA-Z0-9\-_]+$/', $this->apiKey)) {
            Log::warning('OpenRouter API key format is invalid: ' . substr($this->apiKey, 0, 10) . '...');
            return false;
        }

        Log::info('OpenRouter service available - API key format valid');
        return true;
    }

    /**
     * Test koneksi API dengan request actual (untuk debugging)
     */
    public function testConnection()
    {
        if (empty($this->apiKey)) {
            return ['success' => false, 'message' => 'API key tidak ditemukan'];
        }

        try {
            $response = $this->client->post($this->baseUrl, [
                'headers' => $this->buildHeaders(),
                'json' => [
                    'model' => $this->currentModel,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => 'Test connection'
                    ]
                ],
                'max_tokens' => 10,
                'temperature' => 0.1
                ],
                'timeout' => 15,
                'connect_timeout' => 10
            ]);

            $statusCode = $response->getStatusCode();
            
            if ($statusCode === 200) {
                return ['success' => true, 'message' => 'Koneksi berhasil', 'status_code' => $statusCode];
            } else {
                return ['success' => false, 'message' => "Status code: {$statusCode}", 'status_code' => $statusCode];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Debug OpenRouter configuration
     * 
     * @return array
     */
    public function debugConfig()
    {
        return [
            'api_key_exists' => !empty($this->apiKey),
            'api_key_prefix' => !empty($this->apiKey) ? substr($this->apiKey, 0, 6) : 'missing',
            'base_url' => $this->baseUrl,
            'current_model' => $this->currentModel,
            'available_models' => array_keys($this->models),
            'headers' => array_keys($this->buildHeaders()),
        ];
    }

    /**
     * Clean HTML response from AI
     * 
     * @param string $content
     * @return string
     */
    private function cleanHtmlResponse($content)
    {
        // Simple and fast HTML cleaning to prevent large responses
        $content = trim($content);
        
        // Remove markdown code blocks
        $content = preg_replace('/```.*?```/s', '', $content);
        $content = preg_replace('/`([^`]+)`/', '$1', $content);
        
        // Convert basic markdown to HTML
        $content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $content);
        $content = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $content);
        
        // Handle simple lists
        $content = preg_replace('/^\s*[-\*\+]\s+(.*)$/m', '<li>$1</li>', $content);
        $content = preg_replace('/^\s*(\d+)\.\s+(.*)$/m', '<li>$2</li>', $content);
        
        // Wrap lists
        if (strpos($content, '<li>') !== false) {
            $content = '<ul>' . $content . '</ul>';
        }
        
        // Clean whitespace
        $content = preg_replace('/\s+/', ' ', $content);
        $content = preg_replace('/>\s+</', '><', $content);
        
        // Wrap in paragraph if not already wrapped
        if (!preg_match('/^<[pul]/', $content)) {
            $content = '<p>' . $content . '</p>';
        }
        
        // Limit length to prevent large responses
        if (strlen($content) > 1500) {
            $content = substr($content, 0, 1500) . '...';
        }
        
        return trim($content);
    }

    /**
     * Parse multiple descriptions from AI response
     * 
     * @param string $content
     * @return array
     */
    private function parseMultipleDescriptions($content)
    {
        $descriptions = [];
        $content = trim($content);
        
        // Method 1: Look for explicit numbered patterns (1), (2), etc.
        if (preg_match_all('/\(\d+\)\s*(.*?)(?=\(\d+\)|$)/s', $content, $matches)) {
            foreach ($matches[1] as $match) {
                $part = trim($match);
                if (!empty($part) && strlen($part) > 30) {
                    $descriptions[] = $this->cleanHtmlResponse($part);
                }
            }
        }
        
        // Method 2: Look for numbered patterns 1., 2., etc.
        if (empty($descriptions) && preg_match_all('/\d+\.\s*(.*?)(?=\d+\.|$)/s', $content, $matches)) {
            foreach ($matches[1] as $match) {
                $part = trim($match);
                if (!empty($part) && strlen($part) > 30) {
                    $descriptions[] = $this->cleanHtmlResponse($part);
                }
            }
        }
        
        // Method 3: Look for bullet points or dashes
        if (empty($descriptions) && preg_match_all('/[-\*\+]\s*(.*?)(?=[-\*\+]|$)/s', $content, $matches)) {
            foreach ($matches[1] as $match) {
                $part = trim($match);
                if (!empty($part) && strlen($part) > 30) {
                    $descriptions[] = $this->cleanHtmlResponse($part);
                }
            }
        }
        
        // Method 4: Split by double newlines and look for substantial content
        if (empty($descriptions)) {
            $parts = preg_split('/\n\s*\n/', $content);
            foreach ($parts as $part) {
                $part = trim($part);
                if (!empty($part) && strlen($part) > 50) {
                    $descriptions[] = $this->cleanHtmlResponse($part);
                }
            }
        }
        
        // Method 5: If still empty, try to split by single newlines
        if (empty($descriptions)) {
            $parts = preg_split('/\n/', $content);
            $currentDesc = '';
            foreach ($parts as $part) {
                $part = trim($part);
                if (!empty($part)) {
                    $currentDesc .= $part . ' ';
                    if (strlen($currentDesc) > 100) {
                        $descriptions[] = $this->cleanHtmlResponse($currentDesc);
                        $currentDesc = '';
                    }
                }
            }
            if (!empty($currentDesc)) {
                $descriptions[] = $this->cleanHtmlResponse($currentDesc);
            }
        }
        
        // Method 6: Last resort - split the content into 2 equal parts
        if (empty($descriptions)) {
            $content = $this->cleanHtmlResponse($content);
            $midPoint = strlen($content) / 2;
            $spacePos = strpos($content, ' ', $midPoint);
            if ($spacePos !== false) {
                $descriptions[] = trim(substr($content, 0, $spacePos));
                $descriptions[] = trim(substr($content, $spacePos));
            } else {
                $descriptions[] = $content;
            }
        }
        
        // Ensure we have at least 2 descriptions
        if (count($descriptions) < 2) {
            if (count($descriptions) == 1) {
                // Duplicate the single description and modify slightly
                $original = $descriptions[0];
                $descriptions[] = $original; // Keep original as second option
            } else {
                // Create fallback descriptions
                $descriptions = [
                    '<p>Deskripsi produk yang menarik dan informatif.</p>',
                    '<p>Pilihan deskripsi alternatif untuk produk ini.</p>'
                ];
            }
        }
        
        // Limit to exactly 2 descriptions for consistency
        return array_slice($descriptions, 0, 2);
    }

    private function buildHeaders()
    {
        $referer = config('services.openrouter.referer');
        $appTitle = config('services.openrouter.app_title', 'Firstudio Starter');
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ];
        // Header opsional yang direkomendasikan oleh OpenRouter
        if (!empty($referer)) {
            $headers['HTTP-Referer'] = $referer;
        }
        if (!empty($appTitle)) {
            $headers['X-Title'] = $appTitle;
        }
        return $headers;
    }
}


