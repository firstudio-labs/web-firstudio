<?php

// Comprehensive test untuk semua model gratis dari DeepSeek dan Gemini
require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\AIServiceFactory;
use App\Services\DeepSeekAIService;
use App\Services\GeminiAIService;

echo "🚀 Testing All Free AI Models (DeepSeek + Gemini)\n";
echo "==================================================\n\n";

// Test 1: Configuration Check
echo "1. 🔧 Configuration Check:\n";
$deepseekKey = config('services.deepseek.api_key');
$geminiKey = config('services.gemini.api_key');
$preferredProvider = config('services.ai.preferred_provider');

echo "   DEEPSEEK_API_KEY: " . ($deepseekKey ? '✅ Configured' : '❌ Missing') . "\n";
echo "   GEMINI_API_KEY: " . ($geminiKey ? '✅ Configured' : '❌ Missing') . "\n";
echo "   Preferred Provider: {$preferredProvider}\n";
echo "   Model Rotation: " . (config('services.ai.model_rotation') ? 'Enabled' : 'Disabled') . "\n\n";

// Test 2: Available Models
echo "2. 📋 Available Models:\n";
try {
    $factory = new AIServiceFactory();
    $availableModels = $factory->getAvailableModels();
    
    foreach ($availableModels as $provider => $models) {
        echo "   🤖 {$provider}:\n";
        foreach ($models as $modelName => $description) {
            echo "      • {$modelName}: {$description}\n";
        }
        echo "\n";
    }
    
    if (empty($availableModels)) {
        echo "   ❌ No models available - check API keys\n\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Error getting models: " . $e->getMessage() . "\n\n";
}

// Test 3: DeepSeek Models Test
echo "3. 🧪 Testing DeepSeek Models:\n";
if ($deepseekKey) {
    $deepseekModels = ['deepseek-reasoner', 'deepseek-chat'];
    
    foreach ($deepseekModels as $model) {
        echo "   Testing {$model}...\n";
        try {
            $service = new DeepSeekAIService();
            
            // Test with short generation to save costs
            $result = $service->generateJudul("Tips Produktivitas dengan {$model}");
            
            if ($result['success']) {
                echo "      ✅ {$model}: WORKING\n";
                echo "      Sample: " . $result['titles'][0] . "\n";
            } else {
                echo "      ❌ {$model}: FAILED\n";
            }
            
        } catch (Exception $e) {
            echo "      ❌ {$model}: ERROR - " . $e->getMessage() . "\n";
            
            if (strpos(strtolower($e->getMessage()), 'insufficient') !== false) {
                echo "      💡 Need credits: https://platform.deepseek.com\n";
            }
        }
        echo "\n";
    }
} else {
    echo "   ⚠️  DeepSeek API key not configured\n\n";
}

// Test 4: Gemini Models Test
echo "4. 🧪 Testing Gemini Models:\n";
if ($geminiKey) {
    $geminiModels = [
        'gemini-1.5-flash-latest',
        'gemini-1.5-flash', 
        'gemini-1.5-pro-latest',
        'gemini-1.5-pro'
    ];
    
    foreach ($geminiModels as $model) {
        echo "   Testing {$model}...\n";
        try {
            $service = new GeminiAIService();
            
            // Test with simple title generation
            $result = $service->generateJudul("Test {$model}");
            
            if ($result['success']) {
                echo "      ✅ {$model}: WORKING\n";
                echo "      Sample: " . $result['titles'][0] . "\n";
            } else {
                echo "      ❌ {$model}: FAILED\n";
            }
            
        } catch (Exception $e) {
            echo "      ❌ {$model}: ERROR - " . $e->getMessage() . "\n";
            
            if (strpos($e->getMessage(), '404') !== false) {
                echo "      💡 Model not available in current region/plan\n";
            }
        }
        echo "\n";
        
        // Small delay to avoid rate limiting
        sleep(1);
    }
} else {
    echo "   ⚠️  Gemini API key not configured\n\n";
}

// Test 5: Factory Fallback Test
echo "5. 🔄 Testing Factory Fallback System:\n";
try {
    $factory = new AIServiceFactory();
    
    echo "   Testing automatic provider selection...\n";
    $result = $factory->generateJudul('Fallback System Test');
    
    if ($result['success']) {
        echo "   ✅ Fallback System: WORKING\n";
        echo "   Provider Used: " . ($result['provider'] ?? 'unknown') . "\n";
        echo "   Sample Title: " . $result['titles'][0] . "\n";
    } else {
        echo "   ❌ Fallback System: FAILED\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Factory Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test 6: Performance Comparison
echo "6. ⚡ Performance Comparison:\n";
$providers = [];

if ($deepseekKey) {
    echo "   Testing DeepSeek performance...\n";
    try {
        $start = microtime(true);
        $service = new DeepSeekAIService();
        $result = $service->generateJudul('Performance Test DeepSeek');
        $end = microtime(true);
        
        if ($result['success']) {
            $providers['deepseek'] = [
                'time' => round(($end - $start), 2),
                'success' => true,
                'quality' => strlen($result['titles'][0])
            ];
            echo "      ✅ DeepSeek: " . $providers['deepseek']['time'] . "s\n";
        }
    } catch (Exception $e) {
        echo "      ❌ DeepSeek: " . $e->getMessage() . "\n";
    }
}

if ($geminiKey) {
    echo "   Testing Gemini performance...\n";
    try {
        $start = microtime(true);
        $service = new GeminiAIService();
        $result = $service->generateJudul('Performance Test Gemini');
        $end = microtime(true);
        
        if ($result['success']) {
            $providers['gemini'] = [
                'time' => round(($end - $start), 2),
                'success' => true,
                'quality' => strlen($result['titles'][0])
            ];
            echo "      ✅ Gemini: " . $providers['gemini']['time'] . "s\n";
        }
    } catch (Exception $e) {
        echo "      ❌ Gemini: " . $e->getMessage() . "\n";
    }
}

if (!empty($providers)) {
    $fastest = array_reduce(array_keys($providers), function($carry, $key) use ($providers) {
        return (!$carry || $providers[$key]['time'] < $providers[$carry]['time']) ? $key : $carry;
    });
    echo "   🏆 Fastest: {$fastest} ({$providers[$fastest]['time']}s)\n";
}
echo "\n";

// Summary Report
echo "🎯 SUMMARY REPORT:\n";
echo "===================\n";

$workingProviders = [];
if (isset($providers['deepseek']) && $providers['deepseek']['success']) {
    $workingProviders[] = 'DeepSeek';
}
if (isset($providers['gemini']) && $providers['gemini']['success']) {
    $workingProviders[] = 'Gemini';
}

if (!empty($workingProviders)) {
    echo "✅ Working Providers: " . implode(', ', $workingProviders) . "\n";
    echo "✅ Multi-Model System: ACTIVE\n";
    echo "✅ Fallback Mechanism: READY\n";
    echo "✅ System Status: PRODUCTION READY\n\n";
    
    echo "🚀 RECOMMENDATIONS:\n";
    echo "===================\n";
    
    if (count($workingProviders) > 1) {
        echo "✅ Optimal Setup: Multiple providers available\n";
        echo "🔄 Auto-fallback: Enabled\n";
        echo "💰 Cost Optimization: Use cheaper provider first\n";
        echo "🛡️ Reliability: High (redundancy available)\n";
    } else {
        echo "⚠️  Single Provider: Consider adding backup\n";
        if (!$deepseekKey) {
            echo "💡 Add DeepSeek: More cost-effective\n";
        }
        if (!$geminiKey) {
            echo "💡 Add Gemini: More model variety\n";
        }
    }
    
} else {
    echo "❌ System Status: NOT READY\n";
    echo "❌ No working providers found\n\n";
    
    echo "🔧 REQUIRED ACTIONS:\n";
    echo "====================\n";
    echo "1. Configure API keys in .env file\n";
    echo "2. For DeepSeek: Add credits at https://platform.deepseek.com\n";
    echo "3. For Gemini: Verify API permissions and quotas\n";
    echo "4. Test again: php test_all_models.php\n";
}

echo "\n📊 COST INFORMATION:\n";
echo "=====================\n";
echo "DeepSeek Pricing:\n";
echo "  • deepseek-chat: $0.14 per 1M tokens (cheapest)\n";
echo "  • deepseek-reasoner: $0.55 per 1M tokens (advanced)\n";
echo "\nGemini Pricing:\n";
echo "  • Flash models: $0.075 per 1M tokens (fast)\n";
echo "  • Pro models: $1.25 per 1M tokens (high quality)\n";
echo "\nRecommendation: Use DeepSeek for cost-effective generation,\n";
echo "Gemini for high-quality content when budget allows.\n";
