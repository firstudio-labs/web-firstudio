# AI Configuration - DeepSeek Only

## 🎯 Current Configuration

Sistem sekarang dikonfigurasi untuk menggunakan **DeepSeek AI saja** sebagai provider AI.

### ✅ Why DeepSeek Only?

1. **Cost Effective**: Lebih murah dari Gemini
2. **High Performance**: Response time yang cepat
3. **Reliable**: Stable service dengan uptime tinggi
4. **Consistent Quality**: Output berkualitas tinggi
5. **Better Rate Limits**: Quota yang lebih generous

## 🔧 Setup Configuration

### Environment Variables Required

**Minimal setup - hanya perlu 1 variable:**

```bash
# File: .env
DEEPSEEK_API_KEY=sk-your-deepseek-api-key-here
```

### Optional Variables

```bash
# Optional - system sudah default ke DeepSeek
AI_PREFERRED_PROVIDER=deepseek
```

## 📋 How to Get DeepSeek API Key

### Step 1: Register
1. Go to [DeepSeek Platform](https://platform.deepseek.com)
2. Sign up with email/Google account
3. Verify your email address

### Step 2: Generate API Key
1. Login to dashboard
2. Navigate to **API Keys** section
3. Click **"Create New API Key"**
4. Give it a name (e.g., "Laravel Article Generator")
5. Copy the generated key (starts with `sk-`)

### Step 3: Add to Laravel
```bash
# Add to .env file
DEEPSEEK_API_KEY=sk-your-actual-api-key-here
```

### Step 4: Test
```bash
# Test the configuration
php test_deepseek.php
```

## 🚀 Features Available

### Article Generation
- **Generate Artikel**: Full article content
- **Generate Judul**: SEO-friendly titles
- **Enhance Content**: Improve existing content
- **Custom Prompts**: User-specific instructions

### Quality Features
- **Smart Formatting**: Proper HTML structure
- **SEO Optimization**: Search-friendly content
- **Responsive Design**: Mobile-friendly output
- **Consistent Style**: Professional article format

## 🔍 Testing & Verification

### Quick Test
```bash
# Run comprehensive test
php test_deepseek.php
```

### Via Laravel Tinker
```bash
php artisan tinker
```

```php
// Test DeepSeek service
$service = new \App\Services\DeepSeekAIService();
var_dump($service->isAvailable()); // Should return true

// Test via factory
$factory = new \App\Services\AIServiceFactory();
$providers = $factory->getAvailableProviders();
var_dump($providers); // Should show ['deepseek']

// Generate test article
$result = $factory->generateArtikel('Test Artikel', null, 200);
echo $result['provider']; // Should show 'deepseek'
```

### Browser Test
1. Login ke admin panel
2. Go to Articles → Create New
3. Try "Generate Judul" button
4. Try "Generate dengan AI" button
5. Check browser console for provider info

## 📊 System Architecture

```
User Request → ArtikelController → AIServiceFactory → DeepSeekAIService → DeepSeek API
```

### Previous vs Current:

**Before (Multi-Provider):**
```
Gemini (Primary) → DeepSeek (Fallback) → Error
```

**Now (DeepSeek Only):**
```
DeepSeek Only → Error (if DeepSeek fails)
```

## ⚡ Performance Optimizations

### DeepSeek Model Settings
```php
'model' => 'deepseek-chat'
'max_tokens' => 4000        // For long articles
'temperature' => 0.7        // Balanced creativity
'timeout' => 45             // 45 second timeout
```

### Retry Mechanism
- **3 retries** with exponential backoff
- **2s, 4s, 8s** wait times
- **Automatic rate limit handling**

## 🛠️ Troubleshooting

### Common Issues

#### 1. API Key Not Working
```
Error: DeepSeek API Error: Invalid API key
```

**Solution:**
- Check API key in DeepSeek dashboard
- Verify key is not expired
- Ensure no typos in .env file

#### 2. Rate Limit Reached
```
Error: DeepSeek API rate limit exceeded
```

**Solution:**
- System automatically retries with backoff
- Check usage in DeepSeek dashboard
- Wait a few minutes before trying again

#### 3. Network/Connection Issues
```
Error: Gagal menghubungi DeepSeek API
```

**Solution:**
- Check internet connection
- Verify DeepSeek service status
- Try again in a few minutes

### Debug Commands

```bash
# Clear config cache
php artisan config:clear
php artisan config:cache

# Check logs
tail -f storage/logs/laravel.log | grep -i deepseek

# Test API directly
curl -X POST https://api.deepseek.com/v1/chat/completions \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{"model":"deepseek-chat","messages":[{"role":"user","content":"test"}]}'
```

## 📈 Cost & Usage Monitoring

### DeepSeek Pricing Benefits
- **Lower cost per token** vs Gemini
- **Higher free tier** quota
- **Transparent pricing** structure

### Usage Tracking
- Monitor di DeepSeek dashboard
- Check Laravel logs for usage patterns
- Daily token limits still apply (6 tokens/day)

## 🔐 Security Best Practices

### API Key Security
- Never commit API keys to git
- Use `.env` file only
- Rotate keys periodically
- Monitor for unusual usage

### Rate Limiting
- System enforces daily limits (6 tokens)
- Per-user rate limiting active
- Automatic abuse prevention

## 📋 System Status

### Current Status: ✅ Active
- **Provider**: DeepSeek AI only
- **Fallback**: Disabled (no Gemini)
- **Daily Limit**: 6 tokens per user
- **Rate Limiting**: 30s between requests
- **Retry Logic**: 3 attempts with backoff

### Health Check
```php
// Add this route for monitoring
Route::get('/admin/ai-health', function() {
    $factory = new \App\Services\AIServiceFactory();
    return response()->json([
        'status' => 'healthy',
        'provider' => $factory->getCurrentProvider(),
        'available_providers' => $factory->getAvailableProviders(),
        'timestamp' => now()
    ]);
});
```

## 🎯 Next Steps

1. **Monitor Performance**: Track response times and error rates
2. **Usage Analytics**: Monitor token consumption patterns  
3. **Cost Optimization**: Adjust parameters based on usage
4. **Backup Planning**: Consider secondary API key for redundancy

**System is now optimized for DeepSeek AI only! 🚀**
