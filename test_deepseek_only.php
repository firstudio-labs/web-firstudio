<?php

// Test DeepSeek-only configuration
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\AIServiceFactory;
use App\Services\DeepSeekAIService;

echo "🚀 Testing DeepSeek-Only AI System\n";
echo "===================================\n\n";

// Test 1: Configuration Check
echo "1. 🔧 Configuration Check:\n";
$deepseekKey = config('services.deepseek.api_key');
$preferredProvider = config('services.ai.preferred_provider');
$enabledProviders = config('services.ai.enabled_providers');

if (empty($deepseekKey)) {
    echo "   ❌ DEEPSEEK_API_KEY tidak ditemukan\n";
    echo "   → Tambahkan ke .env: DEEPSEEK_API_KEY=sk-your-key\n\n";
    exit(1);
} else {
    $maskedKey = substr($deepseekKey, 0, 7) . '...' . substr($deepseekKey, -4);
    echo "   ✅ DEEPSEEK_API_KEY: {$maskedKey}\n";
}

echo "   Preferred Provider: {$preferredProvider}\n";
echo "   Enabled Providers: " . implode(', ', $enabledProviders) . "\n\n";

// Test 2: Factory Initialization
echo "2. 🏭 AI Factory Test:\n";
try {
    $factory = new AIServiceFactory();
    
    $currentProvider = $factory->getCurrentProvider();
    echo "   Current Provider: {$currentProvider}\n";
    
    $availableProviders = $factory->getAvailableProviders();
    echo "   Available Providers: " . implode(', ', $availableProviders) . "\n";
    
    if (empty($availableProviders)) {
        echo "   ❌ Tidak ada provider available\n\n";
    } else {
        echo "   ✅ Provider ready\n\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Factory Error: " . $e->getMessage() . "\n\n";
}

// Test 3: Actual AI Operation
echo "3. 🎯 Testing AI Operations:\n";
try {
    $factory = new AIServiceFactory();
    
    // Test title generation
    echo "   Testing generateJudul()...\n";
    $titleResult = $factory->generateJudul('Tips Produktivitas Kerja');
    
    if ($titleResult['success']) {
        echo "   ✅ Title Generation: WORKING\n";
        echo "   Provider Used: " . ($titleResult['provider'] ?? 'unknown') . "\n";
        echo "   Sample Titles:\n";
        foreach (array_slice($titleResult['titles'], 0, 3) as $i => $title) {
            echo "     " . ($i + 1) . ". {$title}\n";
        }
    } else {
        echo "   ❌ Title Generation: FAILED\n";
    }
    echo "\n";
    
    // Test short article generation
    echo "   Testing generateArtikel()...\n";
    $articleResult = $factory->generateArtikel('Manfaat Olahraga Pagi', null, 300);
    
    if ($articleResult['success']) {
        echo "   ✅ Article Generation: WORKING\n";
        echo "   Provider Used: " . ($articleResult['provider'] ?? 'unknown') . "\n";
        echo "   Word Count: " . $articleResult['word_count'] . " words\n";
        
        $preview = strip_tags($articleResult['content']);
        echo "   Preview: " . substr($preview, 0, 100) . "...\n";
    } else {
        echo "   ❌ Article Generation: FAILED\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ AI Operation Error: " . $e->getMessage() . "\n";
    
    // Check if it's a balance issue
    if (strpos(strtolower($e->getMessage()), 'insufficient') !== false ||
        strpos(strtolower($e->getMessage()), 'kuota') !== false) {
        echo "\n   💡 SOLUTION: Top up DeepSeek credits\n";
        echo "   1. Visit: https://platform.deepseek.com\n";
        echo "   2. Login dengan akun DeepSeek\n";
        echo "   3. Go to Billing → Add Credits\n";
        echo "   4. Minimum top up: $5 USD\n";
        echo "   5. Test lagi setelah top up\n";
    }
}

echo "\n";

// Test 4: Error Handling
echo "4. 🛡️ Error Handling Test:\n";
try {
    // Create service directly to test error messages
    $directService = new DeepSeekAIService();
    $testResult = $directService->generateJudul('Test');
    
    if ($testResult['success']) {
        echo "   ✅ Direct service: WORKING\n";
    } else {
        echo "   ❌ Direct service: FAILED\n";
    }
    
} catch (Exception $e) {
    echo "   Error Message: " . $e->getMessage() . "\n";
    
    if (strpos($e->getMessage(), 'platform.deepseek.com') !== false) {
        echo "   ✅ User-friendly error message: WORKING\n";
    } else {
        echo "   ⚠️  Generic error message\n";
    }
}

echo "\n";

// Summary
echo "🎯 SYSTEM STATUS:\n";
echo "==================\n";

if (!empty($availableProviders) && in_array('deepseek', $availableProviders)) {
    echo "✅ Configuration: VALID\n";
    echo "✅ Provider: DeepSeek AVAILABLE\n";
    
    if (isset($titleResult) && $titleResult['success']) {
        echo "✅ AI Features: WORKING\n";
        echo "✅ System Status: READY FOR PRODUCTION\n\n";
        
        echo "🚀 READY TO USE!\n";
        echo "Web interface AI features should work now.\n";
        echo "Go to: Admin Panel → Articles → Create New → Generate AI\n";
        
    } else {
        echo "❌ AI Features: FAILED (Balance issue)\n";
        echo "⚠️  Action Required: Add DeepSeek credits\n\n";
        
        echo "💳 NEXT STEPS:\n";
        echo "1. Visit: https://platform.deepseek.com\n";
        echo "2. Add credits (minimum $5)\n";
        echo "3. Test again: php test_deepseek_only.php\n";
    }
} else {
    echo "❌ Configuration: INVALID\n";
    echo "❌ System Status: NOT READY\n\n";
    
    echo "🔧 REQUIRED ACTIONS:\n";
    echo "1. Check DEEPSEEK_API_KEY in .env\n";
    echo "2. Ensure API key is valid\n";
    echo "3. Add credits to DeepSeek account\n";
}

echo "\n📋 COST INFO:\n";
echo "==============\n";
echo "DeepSeek Pricing: $0.14 per 1M tokens\n";
echo "Article Generation: ~$0.001 per article\n";
echo "$5 credit = ~3,500 articles\n";
echo "Very affordable for most use cases!\n";
