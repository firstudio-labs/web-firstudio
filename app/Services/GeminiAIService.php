<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class GeminiAIService
{
    private $client;
    private $apiKey;
    private $baseUrl;
    private $models;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.gemini.api_key');
        
        // Daftar endpoint model Gemini (urutkan dari yang paling direkomendasikan / terbaru)
        // Catatan: model "gemini-1.5-flash" sudah deprecated dan TIDAK lagi digunakan di sini
        $this->models = [
            // Model flash generasi baru (lebih cepat & murah, jika tersedia di project)
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent',
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent',

            // Model pro yang lebih stabil / umum tersedia
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro-latest:generateContent',
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent',
        ];
        
        $this->baseUrl = $this->models[0]; // Default to first model
    }

    /**
     * Extract model name from full endpoint URL
     *
     * @param string $url
     * @return string
     */
    private function extractModelNameFromUrl(string $url): string
    {
        // Contoh URL:
        // https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent
        $parts = explode('/models/', $url);
        if (count($parts) !== 2) {
            return 'unknown';
        }

        $modelAndMethod = $parts[1]; // gemini-2.5-flash:generateContent
        $modelParts = explode(':', $modelAndMethod);

        return $modelParts[0] ?? 'unknown';
    }

    /**
     * Generate artikel content menggunakan Gemini AI
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
                throw new \Exception('Gemini API key tidak ditemukan. Pastikan GEMINI_API_KEY sudah diset di file .env');
            }

            $prompt = $this->buildPrompt($judul, $kategori, $minWords, $customPrompt);
            
            // Retry logic untuk handle overload
            Log::info("Using Gemini model: " . $this->baseUrl);
            return $this->executeWithRetry(function() use ($prompt, $judul) {
                $response = $this->client->post($this->baseUrl . '?key=' . $this->apiKey, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $prompt
                                    ]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'topK' => 40,
                            'topP' => 0.95,
                            'maxOutputTokens' => 2048,
                        ],
                        'safetySettings' => [
                            [
                                'category' => 'HARM_CATEGORY_HARASSMENT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_HATE_SPEECH',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ]
                        ]
                    ],
                    'timeout' => 45 // Increase timeout untuk handle overload
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $generatedContent = $data['candidates'][0]['content']['parts'][0]['text'];
                    $cleanContent = $this->formatContent($generatedContent, $judul);
                    
                    return [
                        'success' => true,
                        'content' => $cleanContent,
                        'raw_content' => $generatedContent,
                        'word_count' => str_word_count(strip_tags($cleanContent))
                    ];
                } else {
                    Log::error('Gemini API response tidak valid', ['response' => $data]);
                    throw new \Exception('Response dari Gemini API tidak valid');
                }
            });

        } catch (\Exception $e) {
            Log::error('Gemini service error: ' . $e->getMessage());
            throw $e;
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
        $kategoriText = $kategori ? " dalam kategori {$kategori}" : "";
        $customPromptText = $customPrompt ? "\n\nINSTRUKSI KHUSUS DARI USER:\n{$customPrompt}\n" : "";
        
        return "Buatkan konten artikel lengkap dan informatif dengan topik '{$judul}'{$kategoriText}.{$customPromptText}

PENTING - INSTRUKSI FORMAT:
- JANGAN tulis ulang judul artikel
- JANGAN gunakan tag <h1> atau heading level 1
- JANGAN mulai dengan 'Berikut artikel...', 'Artikel tentang...', atau pembukaan serupa
- JANGAN gunakan format markdown (```, **, *, #)
- MULAI LANGSUNG dengan paragraf pembuka yang menarik

PERSYARATAN KONTEN:
- Minimal {$minWords} kata
- Struktur artikel yang logis dan mudah dibaca
- Konten berkualitas, informatif, dan engaging
- Gunakan bahasa Indonesia yang baik dan benar
- Sertakan introduction yang langsung to the point
- Buat paragraf yang tidak terlalu panjang (3-5 kalimat per paragraf)
- Akhiri dengan kesimpulan yang kuat dan actionable

KAIDAH PENULISAN ARTIKEL WEBSITE:
- Gunakan spasi kosong antar section untuk readability
- Buat numbered list untuk langkah-langkah atau urutan
- Gunakan bullet points untuk daftar manfaat/fitur
- Setiap paragraf fokus pada satu ide utama
- Gunakan transition words untuk kelancaran alur
- Buat sub-heading yang informatif dan SEO-friendly

FORMAT HTML YANG DIINGINKAN:
- Gunakan <p> untuk paragraf dengan line break antar paragraf
- Gunakan <h2> untuk section heading utama
- Gunakan <h3> untuk sub-section
- Gunakan <strong> untuk penekanan kata penting
- Gunakan <ol> untuk numbered list (langkah-langkah, urutan)
- Gunakan <ul> untuk bullet points (manfaat, fitur, tips)
- Gunakan <em> untuk emphasis ringan
- Berikan spasi kosong antar section dengan line break

STRUKTUR ARTIKEL YANG DIINGINKAN:
<p>Paragraf pembuka yang engaging dan langsung ke poin utama. Jelaskan mengapa topik ini penting.</p>

<h2>Heading Section Utama</h2>
<p>Penjelasan detail tentang section ini dengan informasi yang berguna.</p>

<p>Paragraf kedua dalam section yang melanjutkan pembahasan.</p>

<h3>Sub-heading jika diperlukan</h3>
<p>Detail spesifik untuk sub-topik.</p>

<h2>Manfaat/Keuntungan</h2>
<p>Penjelasan singkat tentang manfaat:</p>
<ul>
<li>Manfaat pertama dengan penjelasan singkat</li>
<li>Manfaat kedua yang spesifik dan jelas</li>
<li>Manfaat ketiga yang relevan</li>
</ul>

<h2>Langkah-langkah/Tips</h2>
<p>Berikut adalah langkah-langkah yang bisa dilakukan:</p>
<ol>
<li>Langkah pertama dengan penjelasan yang jelas</li>
<li>Langkah kedua yang mudah diikuti</li>
<li>Langkah ketiga yang praktis</li>
</ol>

<h2>Kesimpulan</h2>
<p>Ringkasan poin-poin penting dan call-to-action yang mendorong pembaca untuk bertindak.</p>

PASTIKAN:
- Setiap paragraf dipisah dengan line break
- Numbered list untuk urutan/langkah
- Bullet points untuk daftar manfaat/tips
- Heading yang informatif dan menarik
- Konten yang scannable dan mudah dibaca

Mulai generate SEKARANG:";
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
                throw new \Exception('Gemini API key tidak ditemukan');
            }

            $kategoriText = $kategori ? " dalam kategori {$kategori}" : "";
            $prompt = "Buatkan 5 judul artikel yang menarik dan SEO-friendly tentang topik '{$topik}'{$kategoriText}. 

Persyaratan judul:
- Menarik dan clickable
- Menggunakan bahasa Indonesia
- Panjang 50-60 karakter
- SEO-friendly
- Relevan dengan topik

Format output: Berikan hanya list judul tanpa numbering atau bullet point, satu judul per baris.";

            return $this->executeWithRetry(function() use ($prompt) {
                $response = $this->client->post($this->baseUrl . '?key=' . $this->apiKey, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $prompt
                                    ]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.8,
                            'maxOutputTokens' => 512,
                        ]
                    ],
                    'timeout' => 30
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $titles = explode("\n", trim($data['candidates'][0]['content']['parts'][0]['text']));
                    $cleanTitles = array_filter(array_map('trim', $titles));
                    
                    return [
                        'success' => true,
                        'titles' => array_values($cleanTitles)
                    ];
                }

                throw new \Exception('Gagal generate judul');
            });

        } catch (\Exception $e) {
            Log::error('Error generating titles: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $this->getUserFriendlyErrorMessage($e->getMessage())
            ];
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
                throw new \Exception('Gemini API key tidak ditemukan');
            }

            $prompt = $this->buildEnhancePrompt($content, $enhanceType, $judul);
            
            return $this->executeWithRetry(function() use ($prompt, $enhanceType, $judul) {
                $response = $this->client->post($this->baseUrl . '?key=' . $this->apiKey, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $prompt
                                    ]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.6, // Sedikit lebih konservatif untuk enhancement
                            'topK' => 40,
                            'topP' => 0.95,
                            'maxOutputTokens' => 2048,
                        ],
                        'safetySettings' => [
                            [
                                'category' => 'HARM_CATEGORY_HARASSMENT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_HATE_SPEECH',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ]
                        ]
                    ],
                    'timeout' => 45 // Increase timeout untuk handle overload
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $enhancedContent = $data['candidates'][0]['content']['parts'][0]['text'];
                    $cleanContent = $this->formatContent($enhancedContent, $judul);
                    
                    return [
                        'success' => true,
                        'content' => $cleanContent,
                        'raw_content' => $enhancedContent,
                        'word_count' => str_word_count(strip_tags($cleanContent)),
                        'enhancement_type' => $enhanceType
                    ];
                } else {
                    Log::error('Gemini API response tidak valid untuk enhance', ['response' => $data]);
                    throw new \Exception('Response dari Gemini API tidak valid');
                }
            });

        } catch (\Exception $e) {
            Log::error('Gemini enhance service error: ' . $e->getMessage());
            throw $e;
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
     * Execute request dengan retry mechanism untuk handle overload
     * 
     * @param callable $request
     * @param int $maxRetries
     * @return array
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
                    
                    // Check jika error adalah overload/quota/rate limit
                    if (isset($errorData['error']['message'])) {
                        $errorMessage = $errorData['error']['message'];
                        
                       // Handle model not found errors - try fallback models
                       if (strpos(strtolower($errorMessage), 'model') !== false && 
                           strpos(strtolower($errorMessage), 'not found') !== false) {
                           
                           // Try fallback models
                           foreach ($this->models as $index => $modelUrl) {
                               if ($modelUrl === $this->baseUrl) {
                                   // Try next model in the list
                                   if (isset($this->models[$index + 1])) {
                                       Log::info("Trying fallback model: " . $this->models[$index + 1]);
                                       $this->baseUrl = $this->models[$index + 1];
                                       return $request(); // Retry with new model
                                   }
                               }
                           }
                           
                           throw new \Exception('Semua model Gemini tidak tersedia. Silakan coba lagi nanti atau hubungi administrator.');
                       }
                       
                       if (strpos(strtolower($errorMessage), 'overloaded') !== false ||
                           strpos(strtolower($errorMessage), 'quota') !== false ||
                           strpos(strtolower($errorMessage), 'rate limit') !== false ||
                           strpos(strtolower($errorMessage), 'too many requests') !== false) {
                            
                            if ($attempt < $maxRetries) {
                                // Exponential backoff: 2s, 4s, 8s
                                $waitTime = pow(2, $attempt);
                                Log::warning("Gemini API overloaded, retry attempt {$attempt}/{$maxRetries} in {$waitTime}s");
                                sleep($waitTime);
                                continue;
                            } else {
                                throw new \Exception("Gemini API sedang overload. Silakan coba lagi dalam beberapa menit. (Error: {$errorMessage})");
                            }
                        } else {
                            // Error lain yang tidak bisa di-retry
                            throw new \Exception('Gemini API Error: ' . $errorMessage);
                        }
                    }
                }
                
                // Jika tidak ada response body atau error tidak dikenali
                if ($attempt < $maxRetries) {
                    $waitTime = pow(2, $attempt);
                    Log::warning("Gemini API error, retry attempt {$attempt}/{$maxRetries} in {$waitTime}s: " . $e->getMessage());
                    sleep($waitTime);
                    continue;
                } else {
                    throw new \Exception('Gagal menghubungi Gemini API setelah ' . $maxRetries . ' percobaan: ' . $e->getMessage());
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
        $lowerMessage = strtolower($errorMessage);
        
        if (strpos($lowerMessage, 'overloaded') !== false) {
            return 'Gemini AI sedang sibuk melayani banyak permintaan. Silakan coba lagi dalam 1-2 menit.';
        }
        
        if (strpos($lowerMessage, 'quota') !== false) {
            return 'Quota API Gemini sudah tercapai. Silakan coba lagi nanti atau upgrade ke plan berbayar.';
        }
        
        if (strpos($lowerMessage, 'rate limit') !== false) {
            return 'Terlalu banyak permintaan dalam waktu singkat. Silakan tunggu beberapa detik.';
        }
        
        if (strpos($lowerMessage, 'api key') !== false) {
            return 'API key tidak valid. Hubungi administrator untuk memperbaiki konfigurasi.';
        }
        
        return 'Terjadi kesalahan pada layanan AI: ' . $errorMessage;
    }

    /**
     * Generate deskripsi produk menggunakan Gemini AI
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
                throw new \Exception('Gemini API key tidak ditemukan');
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

            return $this->executeWithRetry(function() use ($prompt) {
                $response = $this->client->post($this->baseUrl . '?key=' . $this->apiKey, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $prompt
                                    ]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 200, // Reduced to prevent PostTooLargeException
                            'topK' => 40,
                            'topP' => 0.95,
                        ],
                        'safetySettings' => [
                            [
                                'category' => 'HARM_CATEGORY_HARASSMENT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_HATE_SPEECH',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ],
                            [
                                'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                                'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                            ]
                        ]
                    ],
                    'timeout' => 60
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $content = trim($data['candidates'][0]['content']['parts'][0]['text']);
                    
                    // Parse multiple descriptions
                    $descriptions = $this->parseMultipleDescriptions($content);
                    
                    Log::info("Gemini AI product descriptions generated successfully", ['count' => count($descriptions)]);
                    
                    return [
                        'success' => true,
                        'descriptions' => $descriptions,
                        'provider' => 'gemini',
                        // Ambil nama model dari URL yang sedang dipakai supaya tidak hardcoded
                        'model' => $this->extractModelNameFromUrl($this->baseUrl),
                    ];
                } else {
                    Log::error('Gemini API response format unexpected', ['response' => $data]);
                    throw new \Exception('Format response AI tidak sesuai');
                }
            });

        } catch (\Exception $e) {
            Log::error("Gemini AI product description generation failed: " . $e->getMessage());
            throw $e;
        }
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
            $response = $this->client->post($this->baseUrl . '?key=' . $this->apiKey, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => 'Test connection']
                            ]
                        ]
                    ]
                ],
                'timeout' => 10
            ]);
            
            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            Log::warning('Gemini API connection test failed: ' . $e->getMessage());
            return false;
        }
    }
}
