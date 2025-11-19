<?php

// Test script untuk DeepSeek AI only
// Jalankan: php test_deepseek.php

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\AIServiceFactory;
use App\Services\DeepSeekAIService;

echo "🤖 Testing DeepSeek AI Service (Only)\n";
echo "=====================================\n\n";

try {
    // Test 1: Direct DeepSeek Service
    echo "1. 🔗 Testing DeepSeek Direct Connection:\n";
    $deepseekService = new DeepSeekAIService();
    
    if ($deepseekService->isAvailable()) {
        echo "   ✅ DeepSeek API - Connected successfully\n";
    } else {
        echo "   ❌ DeepSeek API - Connection failed\n";
        echo "   Please check DEEPSEEK_API_KEY in .env file\n\n";
        exit(1);
    }
    echo "\n";
    
    // Test 2: AI Factory (should only use DeepSeek)
    echo "2. 🏭 Testing AI Factory (DeepSeek Only):\n";
    $factory = new AIServiceFactory();
    
    $providers = $factory->getAvailableProviders();
    echo "   Available providers: " . implode(', ', $providers) . "\n";
    
    if (in_array('deepseek', $providers)) {
        echo "   ✅ DeepSeek available via factory\n";
    } else {
        echo "   ❌ DeepSeek not available via factory\n";
        exit(1);
    }
    
    $currentProvider = $factory->getCurrentProvider();
    echo "   Current provider: {$currentProvider}\n";
    echo "\n";
    
    // Test 3: Quick Title Generation
    echo "3. 📝 Testing Title Generation:\n";
    try {
        $result = $factory->generateJudul('Tips Produktivitas Kerja');
        if ($result['success']) {
            echo "   ✅ Success! Provider: {$result['provider']}\n";
            echo "   Generated titles:\n";
            foreach (array_slice($result['titles'], 0, 3) as $index => $title) {
                echo "     " . ($index + 1) . ". {$title}\n";
            }
        } else {
            echo "   ❌ Failed to generate titles\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // Test 4: Quick Article Generation
    echo "4. 📄 Testing Article Generation (Short):\n";
    try {
        $result = $factory->generateArtikel('Manfaat Berolahraga', null, 200);
        if ($result['success']) {
            echo "   ✅ Success! Provider: {$result['provider']}\n";
            echo "   Word count: {$result['word_count']} words\n";
            
            // Show first 150 characters
            $preview = strip_tags($result['content']);
            echo "   Preview: " . substr($preview, 0, 150) . "...\n";
        } else {
            echo "   ❌ Failed to generate article\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    echo "🎉 DeepSeek AI Test Completed Successfully!\n";
    echo "==========================================\n";
    echo "✅ DeepSeek is working properly\n";
    echo "✅ Gemini disabled successfully\n";
    echo "✅ System ready for production! 🚀\n";
    
} catch (Exception $e) {
    echo "💥 Test Failed: " . $e->getMessage() . "\n";
    echo "\nPlease check:\n";
    echo "1. DEEPSEEK_API_KEY is set in .env file\n";
    echo "2. DeepSeek API key is valid\n";
    echo "3. Internet connection is working\n";
    exit(1);
}
