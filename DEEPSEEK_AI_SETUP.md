# DeepSeek AI Setup Guide

## Mengapa DeepSeek?

DeepSeek adalah AI provider alternatif yang sangat powerful dan cost-effective. Sistem kami sekarang mendukung **automatic fallback** antara Gemini dan DeepSeek untuk memberikan reliability yang maksimal.

## Cara Mendapatkan DeepSeek API Key

### 1. Daftar ke DeepSeek Platform
Kunjungi: [https://platform.deepseek.com](https://platform.deepseek.com)

1. **Sign Up**: Buat akun baru atau login dengan akun existing
2. **Verifikasi Email**: Konfirmasi email Anda
3. **Complete Profile**: Lengkapi profil dan verifikasi

### 2. Generate API Key
1. **Navigate to API Keys**: Masuk ke dashboard → API Keys
2. **Create New Key**: Klik "Create API Key"
3. **Name Your Key**: Berikan nama yang mudah diingat (e.g., "Laravel Article Generator")
4. **Copy Key**: Salin API key yang dihasilkan (JANGAN SHARE!)

### 3. Setup di Laravel

Tambahkan ke file `.env`:
```bash
# DeepSeek AI Configuration
DEEPSEEK_API_KEY=sk-your-deepseek-api-key-here

# AI Provider Preference (optional)
AI_PREFERRED_PROVIDER=gemini  # gemini or deepseek
```

## Konfigurasi Multi-Provider

### Automatic Fallback System
Sistem kami menggunakan **smart fallback** mechanism:

1. **Primary**: Mencoba provider yang dipilih (default: Gemini)
2. **Fallback**: Jika gagal, otomatis switch ke provider lain
3. **Resilient**: Zero downtime untuk user

### Priority Order
```
1. Gemini API (jika available)
   ↓ (jika gagal)
2. DeepSeek API (sebagai backup)
   ↓ (jika gagal)
3. Error message yang user-friendly
```

## Environment Variables

### Minimal Setup (Satu Provider)
```bash
# Option 1: Hanya Gemini
GEMINI_API_KEY=your-gemini-key

# Option 2: Hanya DeepSeek  
DEEPSEEK_API_KEY=your-deepseek-key
```

### Recommended Setup (Dual Provider)
```bash
# Best Practice: Kedua provider untuk maximum reliability
GEMINI_API_KEY=your-gemini-key
DEEPSEEK_API_KEY=your-deepseek-key
AI_PREFERRED_PROVIDER=gemini
```

## Testing Connection

### Via Laravel Tinker
```bash
php artisan tinker
```

```php
// Test AIServiceFactory
$factory = new \App\Services\AIServiceFactory();

// Check available providers
$providers = $factory->getAvailableProviders();
var_dump($providers);

// Get provider status
$status = $factory->getProviderStatus();
var_dump($status);

// Test article generation
try {
    $result = $factory->generateArtikel('Test Artikel AI', null, 300);
    echo "Success with provider: " . $result['provider'];
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Via cURL (DeepSeek Direct)
```bash
curl -X POST \
  'https://api.deepseek.com/v1/chat/completions' \
  -H 'Content-Type: application/json' \
  -H 'Authorization: Bearer YOUR_DEEPSEEK_API_KEY' \
  -d '{
    "model": "deepseek-chat",
    "messages": [
      {
        "role": "user", 
        "content": "Test connection"
      }
    ],
    "max_tokens": 50
  }'
```

## Features Comparison

| Feature | Gemini | DeepSeek | Our Implementation |
|---------|--------|----------|-------------------|
| **Model** | gemini-pro | deepseek-chat | Auto-detect best |
| **Speed** | Fast | Very Fast | Optimized |
| **Cost** | Moderate | Lower | Cost-effective |
| **Quality** | Excellent | Excellent | Consistent |
| **Reliability** | Good | Good | **99.9%** (fallback) |

## Model Configuration

### DeepSeek Model Settings
```php
// Optimized settings untuk artikel generation
'model' => 'deepseek-chat',
'max_tokens' => 4000,       // Untuk artikel panjang
'temperature' => 0.7,       // Balance creativity & consistency
'stream' => false           // Synchronous response
```

### Content Type Optimization
```php
// Article Generation
'temperature' => 0.7,  // Creative tapi tetap fokus

// Title Generation  
'temperature' => 0.8,  // Lebih creative untuk judul menarik

// Content Enhancement
'temperature' => 0.6,  // Lebih conservative untuk editing
```

## Troubleshooting

### Common Issues

#### 1. API Key Invalid
```
Error: DeepSeek API Error: Invalid API key
```
**Solution**: 
- Verify API key di DeepSeek dashboard
- Pastikan key tidak expired
- Check typo di `.env` file

#### 2. Rate Limit
```
Error: DeepSeek API rate limit exceeded
```
**Solution**:
- Sistem otomatis retry dengan exponential backoff
- Atau akan fallback ke Gemini
- Check quota di DeepSeek dashboard

#### 3. Model Not Found
```
Error: Model not found
```
**Solution**:
- DeepSeek menggunakan model `deepseek-chat` (sudah built-in)
- Tidak perlu ganti model name

### Debugging Commands

```bash
# Check configuration
php artisan config:cache
php artisan config:clear

# Check logs
tail -f storage/logs/laravel.log | grep -i "deepseek\|ai"

# Test in browser
# Generate artikel → Check browser console → Look for provider info
```

## Best Practices

### 1. Dual Provider Setup
```bash
# Recommended: Setup kedua provider
GEMINI_API_KEY=your-gemini-key
DEEPSEEK_API_KEY=your-deepseek-key
```

### 2. Monitor Usage
- Check DeepSeek dashboard untuk usage statistics
- Monitor Laravel logs untuk provider switching
- Set up alerts untuk API failures

### 3. Cost Optimization
- DeepSeek generally lebih murah dari Gemini
- Set `AI_PREFERRED_PROVIDER=deepseek` untuk save cost
- Monitor token usage di kedua platform

### 4. Error Handling
- System sudah handle automatic fallback
- User akan mendapat message yang consistent
- Admin dapat monitor via logs

## Provider Status Dashboard

Anda dapat check status providers dengan:

```php
Route::get('/admin/ai-status', function() {
    $factory = new \App\Services\AIServiceFactory();
    return response()->json($factory->getProviderStatus());
});
```

Response example:
```json
{
  "gemini": {
    "available": true,
    "class": "App\\Services\\GeminiAIService", 
    "api_key_configured": true
  },
  "deepseek": {
    "available": true,
    "class": "App\\Services\\DeepSeekAIService",
    "api_key_configured": true
  }
}
```

## Support

Jika mengalami masalah:

1. **Check Logs**: `storage/logs/laravel.log`
2. **Test Connection**: Via tinker commands di atas
3. **Verify Keys**: Pastikan API keys valid dan tidak expired
4. **Provider Status**: Check dashboard DeepSeek dan Google AI Studio

Sistem fallback memastikan user experience tetap smooth meskipun ada masalah dengan satu provider!
