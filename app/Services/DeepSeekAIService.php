<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class DeepSeekAIService
{
    private $client;
    private $apiKey;
    private $baseUrl;
    private $models;
    private $currentModel;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.deepseek.api_key');
        $this->baseUrl = 'https://api.deepseek.com/v1/chat/completions';
        
        // Available DeepSeek models with their characteristics
        $this->models = [
            'deepseek-reasoner' => [
                'name' => 'deepseek-reasoner',
                'description' => 'Advanced reasoning model for complex tasks',
                'best_for' => ['analysis', 'reasoning', 'complex_content']
            ],
            'deepseek-chat' => [
                'name' => 'deepseek-chat', 
                'description' => 'General purpose chat model',
                'best_for' => ['general', 'chat', 'simple_content']
            ]
        ];
        
        $this->currentModel = 'deepseek-chat'; // Default to faster chat model
    }

    /**
     * Generate artikel content menggunakan DeepSeek AI
     * 
     * @param string $judul
     * @param string $kategori
     * @param int $minWords
     * @param string|null $customPrompt
     * @return array
     */
    public function generateArtikel($judul, $kategori = null, $minWords = 500, $customPrompt = null)
    {
        try {
            if (empty($this->apiKey)) {
                throw new \Exception('DeepSeek API key tidak ditemukan. Pastikan DEEPSEEK_API_KEY sudah diset di file .env');
            }

            // Smart model selection based on complexity
            $this->selectOptimalModel($minWords, $customPrompt);

            $prompt = $this->buildPrompt($judul, $kategori, $minWords, $customPrompt);
            
            Log::info("Using DeepSeek AI for article generation");
            return $this->executeWithRetry(function() use ($prompt, $judul, $minWords) {
                $response = $this->client->post($this->baseUrl, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                    'json' => [
                        'model' => $this->currentModel,
                        'messages' => [
                            [
                                'role' => 'user',
                                'content' => $prompt
                            ]
                        ],
                        'max_tokens' => $this->getOptimalMaxTokens($minWords),
                        'temperature' => 0.5,  // More focused = faster
                        'stream' => false,
                        'top_p' => 0.8,        // More focused sampling
                        'frequency_penalty' => 0.3,  // Reduce repetition
                        'presence_penalty' => 0.1     // Encourage conciseness
                    ],
                    'timeout' => 75,  // Faster timeout
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
                        'provider' => 'deepseek'
                    ];
                } else {
                    Log::error('DeepSeek API response tidak valid', ['response' => $data]);
                    throw new \Exception('Response dari DeepSeek API tidak valid');
                }
            });

        } catch (\Exception $e) {
            Log::error('DeepSeek service error: ' . $e->getMessage());
            
            // Provide user-friendly error messages
            $userMessage = $this->getUserFriendlyErrorMessage($e->getMessage());
            throw new \Exception($userMessage);
        }
    }

    /**
     * Build prompt untuk generate artikel
     * 
     * @param string $judul
     * @param string|null $kategori
     * @param int $minWords
     * @param string|null $customPrompt
     * @return string
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
     * Format konten yang dihasilkan AI
     * 
     * @param string $content
     * @param string|null $judul
     * @return string
     */
    private function formatContent($content, $judul = null)
    {
        // Step 1: Clean up markdown code blocks and language indicators
        $content = preg_replace('/^```html\s*/i', '', $content); // Remove ```html at start
        $content = preg_replace('/^```\s*/m', '', $content); // Remove ``` markers
        $content = preg_replace('/\s*```\s*$/m', '', $content); // Remove closing ``` markers
        
        // Step 2: Remove any duplicate/unnecessary HTML document structure
        $content = preg_replace('/<\?xml[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<!DOCTYPE[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<\/?html[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<\/?head[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<\/?body[^>]*>\s*/i', '', $content);
        $content = preg_replace('/<title[^>]*>.*?<\/title>\s*/i', '', $content);
        $content = preg_replace('/<meta[^>]*>\s*/i', '', $content);
        
        // Step 3: Remove markdown headers that might duplicate the title
        $content = preg_replace('/^#+\s+.*$/m', '', $content); // Remove all markdown headers
        
        // Step 4: Clean up markdown formatting and convert to HTML
        $content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $content); // Bold
        $content = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $content); // Italic
        $content = preg_replace('/`(.*?)`/', '<code>$1</code>', $content); // Inline code
        
        // Step 5: Handle lists - convert markdown lists to HTML with proper formatting
        // Handle numbered lists (1., 2., 3., etc.)
        $content = preg_replace('/^\s*(\d+)\.\s+(.*)$/m', '<li>$2</li>', $content);
        // Handle bullet points (-, *, +)
        $content = preg_replace('/^\s*[-\*\+]\s+(.*)$/m', '<li>$1</li>', $content);
        
        // Step 6: Wrap consecutive <li> tags with appropriate list tags
        // For numbered lists (detect if first item looks like it should be numbered)
        $content = preg_replace_callback('/(<li>.*?<\/li>)(\s*<li>.*?<\/li>)+/s', function($matches) {
            $listContent = $matches[0];
            // Check if this should be a numbered list (look for step indicators, sequence words)
            if (preg_match('/\b(langkah|step|tahap|cara|urutan|pertama|kedua|ketiga)\b/i', $listContent)) {
                return "<ol>\n" . $listContent . "\n</ol>";
            } else {
                return "<ul>\n" . $listContent . "\n</ul>";
            }
        }, $content);
        
        // Clean up list formatting
        $content = str_replace('<ul><li>', "<ul>\n<li>", $content);
        $content = str_replace('<ol><li>', "<ol>\n<li>", $content);
        $content = str_replace('</li></ul>', "</li>\n</ul>", $content);
        $content = str_replace('</li></ol>', "</li>\n</ol>", $content);
        $content = preg_replace('/<\/li>\s*<li>/', "</li>\n<li>", $content);
        
        // Step 7: Remove common AI-generated prefixes and suffixes
        $content = preg_replace('/^(berikut|ini|artikel|konten|tulisan)(\s+(adalah|ini|berikut|tentang))*[:\.]?\s*/i', '', $content);
        $content = preg_replace('/^(berdasarkan|sesuai dengan|untuk).*?(berikut|adalah)[:\.]?\s*/i', '', $content);
        $content = preg_replace('/semoga.*?(bermanfaat|membantu)\.?\s*$/i', '', $content);
        
        // Step 7.5: Remove title duplication if judul is provided
        if ($judul) {
            // Remove exact title matches (case insensitive)
            $content = preg_replace('/^' . preg_quote($judul, '/') . '\s*/i', '', $content);
            // Remove title wrapped in h1-h6 tags
            $content = preg_replace('/<h[1-6][^>]*>\s*' . preg_quote($judul, '/') . '\s*<\/h[1-6]>\s*/i', '', $content);
            // Remove title-like patterns at the beginning
            $titleWords = explode(' ', $judul);
            if (count($titleWords) >= 2) {
                $firstTwoWords = implode('\s+', array_slice($titleWords, 0, 2));
                $content = preg_replace('/^.*?' . $firstTwoWords . '.*?\n/i', '', $content);
            }
        }
        
        // Step 8: Clean up extra whitespace and normalize line breaks
        $content = preg_replace('/\n{3,}/', "\n\n", $content); // Max 2 consecutive newlines
        $content = trim($content);
        
        // Step 9: Split into paragraphs and format properly with enhanced spacing
        $lines = explode("\n", $content);
        $formattedContent = [];
        $currentParagraph = '';
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // Empty line - end current paragraph if any
            if (empty($line)) {
                if (!empty($currentParagraph)) {
                    $formattedContent[] = $this->wrapParagraph($currentParagraph);
                    $currentParagraph = '';
                }
                continue;
            }
            
            // Check if line is a heading or list
            if (preg_match('/^<(h[1-6]|ul|ol|\/ul|\/ol)/i', $line)) {
                // End current paragraph if any
                if (!empty($currentParagraph)) {
                    $formattedContent[] = $this->wrapParagraph($currentParagraph);
                    $currentParagraph = '';
                }
                
                // Add the heading/list with proper spacing
                $formattedContent[] = $line;
                continue;
            }
            
            // Check if line is a list item
            if (preg_match('/^<li>/i', $line)) {
                $formattedContent[] = $line;
                continue;
            }
            
            // Regular content line - add to current paragraph
            if (!empty($currentParagraph)) {
                $currentParagraph .= ' ' . $line;
            } else {
                $currentParagraph = $line;
            }
        }
        
        // Don't forget the last paragraph
        if (!empty($currentParagraph)) {
            $formattedContent[] = $this->wrapParagraph($currentParagraph);
        }
        
        // Join with proper spacing - add extra line break before headings and after lists
        $result = [];
        for ($i = 0; $i < count($formattedContent); $i++) {
            $current = $formattedContent[$i];
            $prev = $i > 0 ? $formattedContent[$i-1] : '';
            
            // Add extra spacing before headings (except first item)
            if ($i > 0 && preg_match('/^<h[1-6]/i', $current)) {
                $result[] = '';
            }
            
            $result[] = $current;
            
            // Add extra spacing after lists
            if (preg_match('/^<\/(ul|ol)>/i', $current) && $i < count($formattedContent) - 1) {
                $result[] = '';
            }
        }
        
        return implode("\n", $result);
    }

    /**
     * Wrap content in paragraph tags if needed
     * 
     * @param string $content
     * @return string
     */
    private function wrapParagraph($content)
    {
        $content = trim($content);
        
        // Skip if already has block-level HTML tags
        if (preg_match('/^<(h[1-6]|div|ul|ol|li|blockquote|pre|table|p)/i', $content)) {
            return $content;
        }
        
        // Skip if ends with block-level HTML tags
        if (preg_match('/<\/(h[1-6]|div|ul|ol|li|blockquote|pre|table|p)>$/i', $content)) {
            return $content;
        }
        
        // Wrap with paragraph tags
        return '<p>' . $content . '</p>';
    }

    /**
     * Generate judul artikel berdasarkan topik
     * 
     * @param string $topik
     * @param string|null $kategori
     * @return array
     */
    public function generateJudul($topik, $kategori = null)
    {
        try {
            if (empty($this->apiKey)) {
                throw new \Exception('DeepSeek API key tidak ditemukan');
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

CONTOH:
Cara Mudah Belajar Programming untuk Pemula
Tips Jitu Menguasai Coding dalam 30 Hari
Panduan Lengkap Belajar Programming dari Nol
Rahasia Sukses Belajar Coding untuk Newbie
Belajar Programming: Dari Pemula hingga Mahir

Mulai generate 5 judul sekarang:";

            Log::info("Using DeepSeek AI for title generation");
            $response = $this->client->post($this->baseUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 300,   // Optimize for titles
                    'temperature' => 0.7,  // More focused
                    'stream' => false,
                    'top_p' => 0.9
                ],
                'timeout' => 60  // Increase timeout for reliability
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            if (isset($data['choices'][0]['message']['content'])) {
                $titlesText = $data['choices'][0]['message']['content'];
                
                // Parse titles dari response
                $lines = explode("\n", $titlesText);
                $titles = [];
                
                foreach ($lines as $line) {
                    $line = trim($line);
                    // Skip empty lines dan numbering
                    if (empty($line) || preg_match('/^\d+\.?\s*$/', $line)) continue;
                    
                    // Clean up numbering dan bullet points
                    $line = preg_replace('/^\d+\.\s*/', '', $line);
                    $line = preg_replace('/^[-\*]\s*/', '', $line);
                    $line = trim($line);
                    
                    if (!empty($line) && strlen($line) > 10) {
                        $titles[] = $line;
                    }
                }
                
                return [
                    'success' => true,
                    'titles' => array_slice($titles, 0, 5), // Maksimal 5 judul
                    'provider' => 'deepseek'
                ];
            } else {
                throw new \Exception('Response dari DeepSeek API tidak valid');
            }

        } catch (\Exception $e) {
            Log::error('DeepSeek title generation error: ' . $e->getMessage());
            
            // Provide user-friendly error messages
            $userMessage = $this->getUserFriendlyErrorMessage($e->getMessage());
            throw new \Exception($userMessage);
        }
    }

    /**
     * Enhance existing content
     * 
     * @param string $content
     * @param string $enhanceType
     * @param string|null $judul
     * @return array
     */
    public function enhanceContent($content, $enhanceType = 'improve', $judul = null)
    {
        try {
            if (empty($this->apiKey)) {
                throw new \Exception('DeepSeek API key tidak ditemukan');
            }

            $prompt = $this->buildEnhancePrompt($content, $enhanceType, $judul);
            
            Log::info("Using DeepSeek AI for content enhancement");
            return $this->executeWithRetry(function() use ($prompt, $enhanceType, $judul) {
                $response = $this->client->post($this->baseUrl, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
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
                    'timeout' => 75,  // Faster timeout
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
                        'provider' => 'deepseek'
                    ];
                } else {
                    Log::error('DeepSeek API response tidak valid untuk enhance', ['response' => $data]);
                    throw new \Exception('Response dari DeepSeek API tidak valid');
                }
            });

        } catch (\Exception $e) {
            Log::error('DeepSeek enhance service error: ' . $e->getMessage());
            
            // Provide user-friendly error messages
            $userMessage = $this->getUserFriendlyErrorMessage($e->getMessage());
            throw new \Exception($userMessage);
        }
    }

    /**
     * Build prompt untuk enhance content
     * 
     * @param string $content
     * @param string $enhanceType
     * @param string|null $judul
     * @return string
     */
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
     * Execute request dengan retry mechanism
     * 
     * @param callable $request
     * @param int $maxRetries
     * @return mixed
     */
    private function executeWithRetry(callable $request, $maxRetries = 3)
    {
        $attempt = 0;
        
        while ($attempt < $maxRetries) {
            try {
                return $request();
                
            } catch (RequestException $e) {
                $attempt++;
                
                if ($e->hasResponse()) {
                    $errorBody = $e->getResponse()->getBody()->getContents();
                    $errorData = json_decode($errorBody, true);
                    
                    // Check jika error adalah rate limit atau server error
                    if (isset($errorData['error']['message'])) {
                        $errorMessage = $errorData['error']['message'];
                        
                        // Handle rate limit errors
                        if (strpos(strtolower($errorMessage), 'rate limit') !== false ||
                            strpos(strtolower($errorMessage), 'too many requests') !== false) {
                            
                            if ($attempt < $maxRetries) {
                                // Exponential backoff: 2s, 4s, 8s
                                $waitTime = pow(2, $attempt);
                                Log::warning("DeepSeek API rate limited, retry attempt {$attempt}/{$maxRetries} in {$waitTime}s");
                                sleep($waitTime);
                                continue;
                            } else {
                                throw new \Exception("DeepSeek API rate limit exceeded. Silakan coba lagi dalam beberapa menit.");
                            }
                        } else {
                            // Error lain yang tidak bisa di-retry
                            throw new \Exception('DeepSeek API Error: ' . $errorMessage);
                        }
                    }
                }
                
                // Jika tidak ada response body atau error tidak dikenali
                if ($attempt < $maxRetries) {
                    $waitTime = pow(2, $attempt);
                    Log::warning("DeepSeek API error, retry attempt {$attempt}/{$maxRetries} in {$waitTime}s: " . $e->getMessage());
                    sleep($waitTime);
                    continue;
                } else {
                    throw new \Exception('Gagal menghubungi DeepSeek API setelah ' . $maxRetries . ' percobaan: ' . $e->getMessage());
                }
            }
        }
        
        throw new \Exception('Unexpected error in retry logic');
    }

    /**
     * Get user-friendly error message
     * 
     * @param string $errorMessage
     * @return string
     */
    private function getUserFriendlyErrorMessage($errorMessage)
    {
        $lowerError = strtolower($errorMessage);
        
        if (strpos($lowerError, 'api key') !== false || strpos($lowerError, 'unauthorized') !== false) {
            return 'API key DeepSeek tidak valid. Silakan periksa konfigurasi DEEPSEEK_API_KEY di file .env';
        }
        
        if (strpos($lowerError, 'rate limit') !== false) {
            return 'Terlalu banyak permintaan ke DeepSeek API. Silakan tunggu beberapa menit sebelum mencoba lagi.';
        }
        
        if (strpos($lowerError, 'quota') !== false || strpos($lowerError, 'insufficient') !== false) {
            return 'Kuota DeepSeek API telah habis. Silakan periksa dashboard DeepSeek atau upgrade plan Anda.';
        }
        
        if (strpos($lowerError, 'timeout') !== false || strpos($lowerError, 'connection') !== false) {
            return 'Koneksi ke DeepSeek API gagal. Silakan periksa koneksi internet dan coba lagi.';
        }
        
        if (strpos($lowerError, 'model') !== false && strpos($lowerError, 'not found') !== false) {
            return 'Model DeepSeek tidak tersedia. Silakan hubungi administrator sistem.';
        }
        
        // Default error message
        return 'Terjadi kesalahan pada layanan DeepSeek AI. Silakan coba lagi dalam beberapa menit atau hubungi administrator.';
    }

    /**
     * Select optimal model based on task complexity
     * 
     * @param int $minWords
     * @param string|null $customPrompt
     * @return void
     */
    private function selectOptimalModel($minWords, $customPrompt = null)
    {
        // More aggressive preference for faster chat model
        if ($minWords > 1500 || // Increased threshold for speed
            ($customPrompt && (
                stripos($customPrompt, 'analisis mendalam') !== false ||
                stripos($customPrompt, 'research detail') !== false ||
                stripos($customPrompt, 'teknis kompleks') !== false ||
                stripos($customPrompt, 'sangat detail') !== false
            ))) {
            $this->currentModel = 'deepseek-reasoner';
            Log::info("Selected deepseek-reasoner for complex task (words: {$minWords})");
        } else {
            $this->currentModel = 'deepseek-chat'; // Default to faster model
            Log::info("Selected deepseek-chat for fast generation (words: {$minWords})");
        }
    }

    /**
     * Get optimal max tokens based on word count
     * 
     * @param int $minWords
     * @return int
     */
    private function getOptimalMaxTokens($minWords)
    {
        // More efficient token calculation for faster generation
        $estimatedTokens = (int)($minWords * 1.2); // Slightly lower estimate
        
        // Reduced buffer for faster generation
        $maxTokens = $estimatedTokens + 500; // Smaller buffer
        
        // More aggressive limits for speed
        return min(max($maxTokens, 1500), 4000); // Between 1.5K-4K tokens
    }

    /**
     * Set model yang akan digunakan
     * 
     * @param string $model
     * @return void
     */
    public function setModel($model)
    {
        if (array_key_exists($model, $this->models)) {
            $this->currentModel = $model;
            Log::info("DeepSeek model changed to: {$model}");
        } else {
            throw new \Exception("Model {$model} tidak tersedia di DeepSeek");
        }
    }

    /**
     * Get current model
     * 
     * @return string
     */
    public function getCurrentModel()
    {
        return $this->currentModel;
    }

    /**
     * Get available models
     * 
     * @return array
     */
    public function getAvailableModels()
    {
        return $this->models;
    }

    /**
     * Generate deskripsi produk menggunakan DeepSeek AI
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
                throw new \Exception('DeepSeek API key tidak ditemukan');
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

            Log::info("Using DeepSeek AI for product description generation");
            $response = $this->client->post($this->baseUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
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
                    'stream' => false,
                    'top_p' => 0.9
                ],
                'timeout' => 60
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            if (isset($data['choices'][0]['message']['content'])) {
                $content = trim($data['choices'][0]['message']['content']);
                
                // Parse multiple descriptions
                $descriptions = $this->parseMultipleDescriptions($content);
                
                Log::info("DeepSeek AI product descriptions generated successfully", ['count' => count($descriptions)]);
                
                return [
                    'success' => true,
                    'descriptions' => $descriptions,
                    'provider' => 'deepseek',
                    'model' => $this->currentModel
                ];
            } else {
                Log::error('DeepSeek AI response format unexpected', ['response' => $data]);
                throw new \Exception('Format response AI tidak sesuai');
            }

        } catch (RequestException $e) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 0;
            
            Log::error("DeepSeek API request failed: {$errorMessage}", [
                'status_code' => $statusCode,
                'judul' => $judul,
                'kategori' => $kategori
            ]);
            
            // Handle specific error cases
            if ($statusCode === 401) {
                throw new \Exception('DeepSeek API key tidak valid');
            } elseif ($statusCode === 429) {
                throw new \Exception('Rate limit DeepSeek API terlampaui, coba lagi nanti');
            } elseif ($statusCode === 402) {
                throw new \Exception('DeepSeek API kehabisan kredit, silakan top up');
            } elseif ($statusCode === 0) {
                throw new \Exception('Tidak dapat terhubung ke DeepSeek API, periksa koneksi internet');
            } else {
                throw new \Exception("DeepSeek API error: {$errorMessage}");
            }
        } catch (\Exception $e) {
            Log::error("DeepSeek AI product description generation failed: " . $e->getMessage());
            throw $e;
        }
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

    /**
     * Check apakah service tersedia
     * 
     * @return bool
     */
    public function isAvailable()
    {
        if (empty($this->apiKey)) {
            return false;
        }
        
        // Test connection dengan simple request
        try {
            $response = $this->client->post($this->baseUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => 'Test connection'
                        ]
                    ],
                    'max_tokens' => 10,
                    'temperature' => 0.1
                ],
                'timeout' => 10
            ]);
            
            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            Log::warning('DeepSeek API connection test failed: ' . $e->getMessage());
            return false;
        }
    }
}
