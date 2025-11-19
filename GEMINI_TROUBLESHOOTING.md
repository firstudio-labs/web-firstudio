# Troubleshooting Gemini API Issues

## Error yang Umum Terjadi

### 1. Model Not Found Error
```
Publisher Model `projects/generativelanguage-ga/locations/us-central1/publishers/google/models/gemini-1.5-flash-002` was not found
```

**Penyebab:**
- Menggunakan model endpoint yang salah
- Model yang diminta tidak tersedia di region Anda
- API key tidak memiliki akses ke model tertentu

**Solusi yang Diterapkan:**
1. **Fallback Models**: Sistem akan otomatis mencoba model berikut secara berurutan:
   - `gemini-pro` (v1)
   - `gemini-pro` (v1beta) 
   - `gemini-1.5-flash` (v1beta)

2. **Automatic Model Switching**: Jika satu model gagal, sistem otomatis beralih ke model berikutnya

### 2. API Key Issues
**Gejala:**
- 401 Unauthorized
- 403 Forbidden

**Solusi:**
1. Pastikan `GEMINI_API_KEY` sudah diset di file `.env`
2. Verifikasi API key di Google AI Studio
3. Pastikan API key memiliki akses ke Gemini API

### 3. Rate Limiting
**Gejala:**
- "Rate limit exceeded"
- "Too many requests"

**Solusi:**
- Sistem memiliki retry mechanism dengan exponential backoff
- Tunggu beberapa menit sebelum mencoba lagi

## Cara Mendapatkan API Key yang Valid

1. **Kunjungi Google AI Studio:**
   ```
   https://makersuite.google.com/app/apikey
   ```

2. **Create New API Key:**
   - Klik "Create API Key"
   - Pilih existing project atau buat baru
   - Copy API key yang dihasilkan

3. **Setup di Laravel:**
   ```bash
   # Di file .env
   GEMINI_API_KEY=your_api_key_here
   ```

## Testing API Connection

Gunakan perintah artisan untuk test koneksi:

```bash
php artisan tinker
```

```php
$service = new \App\Services\GeminiAIService();
$available = $service->isAvailable();
var_dump($available); // Should return true if working
```

## Model Endpoints yang Tersedia

### Stable Models (Recommended):
1. **gemini-pro** (v1):
   ```
   https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent
   ```

2. **gemini-pro** (v1beta):
   ```
   https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent
   ```

### Beta Models:
1. **gemini-1.5-flash** (v1beta):
   ```
   https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent
   ```

## Debugging Tips

1. **Check Logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Enable Debug Mode:**
   ```bash
   # Di .env
   APP_DEBUG=true
   ```

3. **Test dengan cURL:**
   ```bash
   curl -X POST \
     'https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=YOUR_API_KEY' \
     -H 'Content-Type: application/json' \
     -d '{
       "contents": [
         {
           "parts": [
             {
               "text": "Test message"
             }
           ]
         }
       ]
     }'
   ```

## Error Codes dan Solusi

| Error Code | Meaning | Solution |
|------------|---------|----------|
| 400 | Bad Request | Check request format |
| 401 | Unauthorized | Verify API key |
| 403 | Forbidden | Check API permissions |
| 404 | Not Found | Model tidak tersedia |
| 429 | Rate Limited | Wait and retry |
| 500 | Server Error | Google server issue |

## Langkah Troubleshooting

1. **Verifikasi API Key:**
   - Pastikan API key valid dan aktif
   - Test dengan cURL atau Postman

2. **Check Model Availability:**
   - Sistem akan otomatis mencoba fallback models
   - Monitor logs untuk melihat model mana yang berhasil

3. **Monitor Rate Limits:**
   - Implementasi daily token limit (6 tokens/day)
   - Rate limiting per user

4. **Contact Support:**
   - Jika semua model gagal, kemungkinan ada masalah regional
   - Hubungi Google AI support atau administrator sistem
