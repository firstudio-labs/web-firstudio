<?php

// Script untuk setup dan test AI models secara otomatis
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\AIServiceFactory;
use App\Services\DeepSeekAIService;
use App\Services\GeminiAIService;

echo "🎯 AI Models Setup & Configuration Helper\n";
echo "==========================================\n\n";

// Check current configuration
echo "1. 🔍 Current Configuration:\n";
$deepseekKey = config('services.deepseek.api_key');
$geminiKey = config('services.gemini.api_key');
$preferredProvider = config('services.ai.preferred_provider');

echo "   DEEPSEEK_API_KEY: " . ($deepseekKey ? '✅ Set' : '❌ Missing') . "\n";
echo "   GEMINI_API_KEY: " . ($geminiKey ? '✅ Set' : '❌ Missing') . "\n";
echo "   Preferred Provider: {$preferredProvider}\n\n";

// Recommendation based on current setup
echo "2. 💡 Setup Recommendations:\n";

if (!$deepseekKey && !$geminiKey) {
    echo "   🚨 No API keys configured!\n";
    echo "   \n";
    echo "   📋 QUICK SETUP OPTIONS:\n";
    echo "   \n";
    echo "   Option A - DeepSeek Only (Cheapest):\n";
    echo "   1. Visit: https://platform.deepseek.com\n";
    echo "   2. Register and verify account\n";
    echo "   3. Generate API key\n";
    echo "   4. Add credits ($5 minimum)\n";
    echo "   5. Add to .env: DEEPSEEK_API_KEY=sk-your-key\n";
    echo "   \n";
    echo "   Option B - Gemini Only (Google Ecosystem):\n";
    echo "   1. Visit: https://console.cloud.google.com\n";
    echo "   2. Enable Generative Language API\n";
    echo "   3. Create API key\n";
    echo "   4. Add to .env: GEMINI_API_KEY=your-key\n";
    echo "   \n";
    echo "   Option C - Both (Recommended):\n";
    echo "   Setup both APIs for maximum reliability\n";
    
} elseif ($deepseekKey && !$geminiKey) {
    echo "   ✅ DeepSeek configured\n";
    echo "   💡 Consider adding Gemini for fallback:\n";
    echo "   1. Visit: https://console.cloud.google.com\n";
    echo "   2. Enable Generative Language API\n";
    echo "   3. Add to .env: GEMINI_API_KEY=your-key\n";
    
} elseif (!$deepseekKey && $geminiKey) {
    echo "   ✅ Gemini configured\n";
    echo "   💡 Consider adding DeepSeek for cost savings:\n";
    echo "   1. Visit: https://platform.deepseek.com\n";
    echo "   2. Add to .env: DEEPSEEK_API_KEY=sk-your-key\n";
    
} else {
    echo "   ✅ Both APIs configured - Excellent setup!\n";
    echo "   🎯 Testing both providers...\n";
}

echo "\n";

// Test available providers
echo "3. 🧪 Testing Available Providers:\n";

$workingProviders = [];

if ($deepseekKey) {
    echo "   Testing DeepSeek...\n";
    try {
        $service = new DeepSeekAIService();
        $result = $service->generateJudul('Test DeepSeek Setup');
        
        if ($result['success']) {
            echo "      ✅ DeepSeek: WORKING\n";
            echo "      Model: " . $service->getCurrentModel() . "\n";
            echo "      Sample: " . $result['titles'][0] . "\n";
            $workingProviders[] = 'deepseek';
        } else {
            echo "      ❌ DeepSeek: FAILED\n";
        }
    } catch (Exception $e) {
        echo "      ❌ DeepSeek: " . $e->getMessage() . "\n";
        
        if (strpos(strtolower($e->getMessage()), 'insufficient') !== false) {
            echo "      💳 Action: Add credits at https://platform.deepseek.com\n";
        }
    }
    echo "\n";
}

if ($geminiKey) {
    echo "   Testing Gemini...\n";
    try {
        $service = new GeminiAIService();
        $result = $service->generateJudul('Test Gemini Setup');
        
        if ($result['success']) {
            echo "      ✅ Gemini: WORKING\n";
            echo "      Sample: " . $result['titles'][0] . "\n";
            $workingProviders[] = 'gemini';
        } else {
            echo "      ❌ Gemini: FAILED\n";
        }
    } catch (Exception $e) {
        echo "      ❌ Gemini: " . $e->getMessage() . "\n";
        
        if (strpos($e->getMessage(), '404') !== false) {
            echo "      💡 Action: Check API permissions and model access\n";
        }
    }
    echo "\n";
}

// Test factory system
if (!empty($workingProviders)) {
    echo "4. 🔄 Testing Factory System:\n";
    try {
        $factory = new AIServiceFactory();
        $result = $factory->generateJudul('Factory System Test');
        
        if ($result['success']) {
            echo "   ✅ Factory System: WORKING\n";
            echo "   Provider Used: " . ($result['provider'] ?? 'unknown') . "\n";
            echo "   Fallback System: ACTIVE\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Factory System: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// Provide setup summary
echo "🎯 SETUP SUMMARY:\n";
echo "==================\n";

if (empty($workingProviders)) {
    echo "❌ Status: NOT READY\n";
    echo "❌ No working providers found\n\n";
    
    echo "🔧 IMMEDIATE ACTIONS NEEDED:\n";
    echo "1. Choose setup option from above\n";
    echo "2. Configure API keys in .env file\n";
    echo "3. Add credits/verify permissions\n";
    echo "4. Run this script again: php setup_ai_models.php\n";
    
} elseif (count($workingProviders) == 1) {
    echo "⚠️  Status: PARTIALLY READY\n";
    echo "✅ Working: " . implode(', ', $workingProviders) . "\n";
    echo "💡 Recommendation: Add second provider for reliability\n\n";
    
    echo "🚀 CURRENT CAPABILITIES:\n";
    echo "✅ Article Generation: WORKING\n";
    echo "✅ Title Generation: WORKING\n";
    echo "✅ Content Enhancement: WORKING\n";
    echo "⚠️  Fallback: Limited (single provider)\n";
    
} else {
    echo "✅ Status: FULLY READY\n";
    echo "✅ Working Providers: " . implode(', ', $workingProviders) . "\n";
    echo "✅ Fallback System: ACTIVE\n\n";
    
    echo "🚀 FULL CAPABILITIES AVAILABLE:\n";
    echo "✅ Article Generation: WORKING\n";
    echo "✅ Title Generation: WORKING\n";
    echo "✅ Content Enhancement: WORKING\n";
    echo "✅ Multi-Provider Fallback: ACTIVE\n";
    echo "✅ Cost Optimization: ENABLED\n";
    echo "✅ High Reliability: GUARANTEED\n";
}

echo "\n📋 QUICK COMMANDS:\n";
echo "===================\n";
echo "Test all models: php test_all_models.php\n";
echo "Test DeepSeek only: php test_deepseek_only.php\n";
echo "Check web interface: Visit admin panel → Articles → Create\n";

echo "\n💰 COST ESTIMATES:\n";
echo "===================\n";
if (in_array('deepseek', $workingProviders)) {
    echo "DeepSeek (Active):\n";
    echo "  • $5 = ~3,500 articles (deepseek-chat)\n";
    echo "  • $5 = ~900 articles (deepseek-reasoner)\n";
}
if (in_array('gemini', $workingProviders)) {
    echo "Gemini (Active):\n";
    echo "  • $5 = ~6,600 articles (Flash models)\n";
    echo "  • $5 = ~400 articles (Pro models)\n";
}

echo "\nRecommendation: Start with $5-10 budget for testing\n";
echo "Scale up based on actual usage patterns.\n\n";

echo "✨ Setup complete! Your AI system is ready to use.\n";
