<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AIServiceFactory
{
    const PROVIDER_GEMINI = 'gemini';
    const PROVIDER_DEEPSEEK = 'deepseek';
    const PROVIDER_OPENROUTER = 'openrouter';
    
    private $providers;
    private $currentProvider;

    public function __construct()
    {
        // Define providers - Hanya OpenRouter sesuai permintaan
        $this->providers = [
            self::PROVIDER_OPENROUTER => OpenRouterAIService::class,
        ];
        
        // Determine current provider based on config or availability
        $this->currentProvider = $this->determineProvider();
    }

    /**
     * Get the appropriate AI service instance
     * 
     * @return DeepSeekAIService|GeminiAIService
     */
    public function getService()
    {
        $provider = $this->getCurrentProvider();
        $serviceClass = $this->providers[$provider];
        
        Log::info("Using AI provider: {$provider}");
        return new $serviceClass();
    }

    /**
     * Get available AI service with fallback
     * 
     * @return DeepSeekAIService|GeminiAIService
     * @throws \Exception
     */
    public function getAvailableService()
    {
        // Try each provider in order until we find one that works
        foreach ($this->providers as $providerName => $serviceClass) {
            try {
                // Check if API key is configured first
                $apiKey = $this->getApiKey($providerName);
                if (empty($apiKey)) {
                    Log::info("Skipping {$providerName}: No API key configured");
                    continue;
                }
                
                $service = new $serviceClass();
                Log::info("Attempting to use AI provider: {$providerName}");
                $this->currentProvider = $providerName;
                return $service;
                
            } catch (\Exception $e) {
                Log::warning("Failed to initialize AI provider {$providerName}: " . $e->getMessage());
                continue;
            }
        }
        throw new \Exception('Layanan AI tidak tersedia. Pastikan OpenRouter API Key sudah dikonfigurasi di menu Pengaturan API.');
    }

    /**
     * Generate artikel using available AI service
     * 
     * @param string $judul
     * @param string|null $kategori
     * @param int $minWords
     * @param string|null $customPrompt
     * @return array
     */
    public function generateArtikel($judul, $kategori = null, $minWords = 500, $customPrompt = null)
    {
        return $this->executeWithFallback(function($service) use ($judul, $kategori, $minWords, $customPrompt) {
            return $service->generateArtikel($judul, $kategori, $minWords, $customPrompt);
        });
    }

    /**
     * Generate titles using available AI service
     * 
     * @param string $topik
     * @param string|null $kategori
     * @return array
     */
    public function generateJudul($topik, $kategori = null)
    {
        return $this->executeWithFallback(function($service) use ($topik, $kategori) {
            return $service->generateJudul($topik, $kategori);
        });
    }

    /**
     * Enhance content using available AI service
     * 
     * @param string $content
     * @param string $enhanceType
     * @param string|null $judul
     * @return array
     */
    public function enhanceContent($content, $enhanceType = 'improve', $judul = null)
    {
        return $this->executeWithFallback(function($service) use ($content, $enhanceType, $judul) {
            return $service->enhanceContent($content, $enhanceType, $judul);
        });
    }

    /**
     * Generate deskripsi produk using available AI service
     * 
     * @param string $judul
     * @param string|null $kategori
     * @param string|null $customPrompt
     * @return array
     */
    public function generateDeskripsiProduk($judul, $kategori = null, $customPrompt = null)
    {
        return $this->executeWithFallback(function($service) use ($judul, $kategori, $customPrompt) {
            return $service->generateDeskripsiProduk($judul, $kategori, $customPrompt);
        });
    }

    /**
     * Execute AI operation with automatic fallback between providers
     * 
     * @param callable $operation
     * @return array
     * @throws \Exception
     */
    private function executeWithFallback(callable $operation)
    {
        $exceptions = [];
        
        // Cek jika provider sudah diset secara eksplisit, prioritaskan
        $forcedProvider = $this->getCurrentProvider();
        if ($forcedProvider && array_key_exists($forcedProvider, $this->providers)) {
            try {
                // Check if API key is configured
                $apiKey = $this->getApiKey($forcedProvider);
                if (empty($apiKey)) {
                    Log::warning("Forced provider {$forcedProvider} has no API key, will try fallbacks");
                } else {
                    $serviceClass = $this->providers[$forcedProvider];
                    $service = new $serviceClass();
                    Log::info("Using forced provider: {$forcedProvider}");
                    
                    $result = $operation($service);
                    
                    // Add provider info to result
                    if (is_array($result)) {
                        $result['provider'] = $forcedProvider;
                    }
                    
                    Log::info("AI operation successful with forced provider: {$forcedProvider}");
                    return $result;
                }
            } catch (\Exception $e) {
                $exceptions[$forcedProvider] = $e->getMessage();
                Log::warning("Forced provider {$forcedProvider} failed: " . $e->getMessage());
                
                // Jika ini OpenRouter dan error rate limit, coba lagi dengan backoff
                if ($forcedProvider === 'openrouter' && 
                    (strpos(strtolower($e->getMessage()), 'too many requests') !== false ||
                     strpos(strtolower($e->getMessage()), '429') !== false)) {
                    
                    Log::info("OpenRouter rate limited, trying with exponential backoff...");
                    
                    // Coba lagi dengan backoff
                    for ($attempt = 1; $attempt <= 3; $attempt++) {
                        $waitTime = pow(2, $attempt);
                        Log::info("OpenRouter backoff attempt {$attempt}, waiting {$waitTime}s");
                        sleep($waitTime);
                        
                        try {
                            $serviceClass = $this->providers[$forcedProvider];
                            $service = new $serviceClass();
                            $result = $operation($service);
                            
                            if (is_array($result)) {
                                $result['provider'] = $forcedProvider;
                            }
                            
                            Log::info("OpenRouter successful after backoff");
                            return $result;
                        } catch (\Exception $retryE) {
                            Log::warning("OpenRouter backoff attempt {$attempt} failed: " . $retryE->getMessage());
                        }
                    }
                }
            }
        }
        
        // Jika provider yang dipaksa gagal atau tidak ada, coba provider lain
        foreach ($this->providers as $providerName => $serviceClass) {
            // Skip jika ini provider yang sudah dicoba dipaksa
            if ($providerName === $forcedProvider) {
                continue;
            }
            
            try {
                // Check if API key is configured first
                $apiKey = $this->getApiKey($providerName);
                if (empty($apiKey)) {
                    Log::info("Skipping {$providerName}: No API key configured");
                    continue;
                }
                
                $service = new $serviceClass();
                Log::info("Attempting AI operation with provider: {$providerName}");
                
                $result = $operation($service);
                
                // Add provider info to result
                if (is_array($result)) {
                    $result['provider'] = $providerName;
                }
                
                Log::info("AI operation successful with provider: {$providerName}");
                return $result;
                
            } catch (\Exception $e) {
                $exceptions[$providerName] = $e->getMessage();
                Log::warning("AI operation failed with provider {$providerName}: " . $e->getMessage());
                
                // If this is DeepSeek balance issue, continue to next provider
                if (strpos(strtolower($e->getMessage()), 'insufficient balance') !== false ||
                    strpos(strtolower($e->getMessage()), 'kuota') !== false) {
                    Log::info("DeepSeek balance issue, trying fallback provider...");
                    continue;
                }
                
                // Continue to next provider for other errors too
                continue;
            }
        }
        
        // If we get here, all providers failed
        $errorDetails = implode('; ', array_map(function($provider, $error) {
            return "{$provider}: {$error}";
        }, array_keys($exceptions), $exceptions));
        
        // Provide specific guidance for common issues
        if (strpos($errorDetails, 'insufficient') !== false || strpos($errorDetails, 'kuota') !== false) {
            throw new \Exception("OpenRouter API kehabisan kredit. Silakan periksa dashboard akun Anda. Detail: {$errorDetails}");
        }
        
        if (strpos($errorDetails, 'not found') !== false || strpos($errorDetails, '404') !== false) {
            throw new \Exception("Model AI tidak tersedia. Sistem akan mencoba model alternatif secara otomatis. Detail: {$errorDetails}");
        }
        
        throw new \Exception("Semua layanan AI gagal. Periksa API keys dan koneksi internet. Detail: {$errorDetails}");
    }

    /**
     * Determine which provider to use based on configuration and availability
     * 
     * @return string
     */
    private function determineProvider()
    {
        // Check if specific provider is configured, default to DeepSeek
        $configuredProvider = config('services.ai.preferred_provider', self::PROVIDER_DEEPSEEK);
        
        if (array_key_exists($configuredProvider, $this->providers)) {
            return $configuredProvider;
        }
        
        // Default to first available provider (DeepSeek)
        return array_key_first($this->providers);
    }

    /**
     * Get current provider name
     * 
     * @return string
     */
    public function getCurrentProvider()
    {
        return $this->currentProvider;
    }

    /**
     * Get available models for all providers
     * 
     * @return array
     */
    public function getAvailableModels()
    {
        $models = [];
        
        foreach ($this->providers as $providerName => $serviceClass) {
            try {
                $apiKey = $this->getApiKey($providerName);
                if (!empty($apiKey)) {
                    $service = new $serviceClass();
                    
                    if ($providerName === self::PROVIDER_DEEPSEEK) {
                        $models[$providerName] = [
                            'deepseek-reasoner' => 'Advanced reasoning model (complex tasks)',
                            'deepseek-chat' => 'General purpose chat model (simple tasks)'
                        ];
                    } elseif ($providerName === self::PROVIDER_GEMINI) {
                        $models[$providerName] = [
                            'gemini-1.5-flash-latest' => 'Latest Flash model (fast, versatile)',
                            'gemini-1.5-flash' => 'Stable Flash model (reliable)',
                            'gemini-1.5-pro-latest' => 'Latest Pro model (high quality)',
                            'gemini-1.5-pro' => 'Stable Pro model (multimodal)',
                            'gemini-2.0-flash' => 'Next-gen Flash (experimental)',
                            'gemini-2.5-flash' => 'Latest generation (experimental)'
                        ];
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Failed to get models for {$providerName}: " . $e->getMessage());
            }
        }
        
        return $models;
    }

    /**
     * Set preferred provider
     * 
     * @param string $provider
     * @throws \Exception
     */
    public function setProvider($provider)
    {
        if (!array_key_exists($provider, $this->providers)) {
            throw new \Exception("Unknown AI provider: {$provider}");
        }
        
        $this->currentProvider = $provider;
    }

    /**
     * Get list of available providers
     * 
     * @return array
     */
    public function getAvailableProviders()
    {
        $available = [];
        
        foreach ($this->providers as $providerName => $serviceClass) {
            try {
                // Check if API key is configured
                $apiKey = $this->getApiKey($providerName);
                if (!empty($apiKey)) {
                    $available[] = $providerName;
                }
            } catch (\Exception $e) {
                // Provider not available
                continue;
            }
        }
        
        return $available;
    }

    /**
     * Get provider status information
     * 
     * @return array
     */
    public function getProviderStatus()
    {
        $status = [];
        
        foreach ($this->providers as $providerName => $serviceClass) {
            try {
                $service = new $serviceClass();
                $isAvailable = $service->isAvailable();
                
                $status[$providerName] = [
                    'available' => $isAvailable,
                    'class' => $serviceClass,
                    'api_key_configured' => !empty($this->getApiKey($providerName))
                ];
            } catch (\Exception $e) {
                $status[$providerName] = [
                    'available' => false,
                    'class' => $serviceClass,
                    'error' => $e->getMessage(),
                    'api_key_configured' => !empty($this->getApiKey($providerName))
                ];
            }
        }
        
        return $status;
    }

    /**
     * Get API key for specific provider
     * 
     * @param string $provider
     * @return string|null
     */
    private function getApiKey($provider)
    {
        switch ($provider) {
            case self::PROVIDER_GEMINI:
                return \App\Models\Setting::where('key', 'gemini_api_key')->value('value') ?: config('services.gemini.api_key');
            case self::PROVIDER_DEEPSEEK:
                return \App\Models\Setting::where('key', 'deepseek_api_key')->value('value') ?: config('services.deepseek.api_key');
            case self::PROVIDER_OPENROUTER:
                return \App\Models\Setting::where('key', 'openrouter_api_key')->value('value') ?: config('services.openrouter.api_key');
            default:
                return null;
        }
    }
}
