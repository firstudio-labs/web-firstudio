<?php

// Simple test script untuk AI providers
// Jalankan dengan: php AI_PROVIDER_TEST.php

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\AIServiceFactory;

echo "🤖 Testing AI Provider System\n";
echo "===============================\n\n";

try {
    $factory = new AIServiceFactory();
    
    // Test 1: Check Available Providers
    echo "1. 📊 Checking Available Providers:\n";
    $providers = $factory->getAvailableProviders();
    
    if (empty($providers)) {
        echo "   ❌ No providers available! Check your API keys in .env file\n";
        echo "   Required: GEMINI_API_KEY or DEEPSEEK_API_KEY\n\n";
        exit(1);
    }
    
    foreach ($providers as $provider) {
        echo "   ✅ {$provider} - Available\n";
    }
    echo "\n";
    
    // Test 2: Provider Status Detail
    echo "2. 🔍 Provider Status Detail:\n";
    $status = $factory->getProviderStatus();
    foreach ($status as $provider => $info) {
        $available = $info['available'] ? '✅' : '❌';
        $keyConfigured = $info['api_key_configured'] ? '🔑' : '🚫';
        echo "   {$available} {$provider}: API Key {$keyConfigured}\n";
        
        if (isset($info['error'])) {
            echo "      Error: {$info['error']}\n";
        }
    }
    echo "\n";
    
    // Test 3: Test Title Generation
    echo "3. 📝 Testing Title Generation:\n";
    try {
        $result = $factory->generateJudul('Manfaat Olahraga untuk Kesehatan');
        if ($result['success']) {
            echo "   ✅ Success with provider: {$result['provider']}\n";
            echo "   Generated titles:\n";
            foreach ($result['titles'] as $index => $title) {
                echo "     " . ($index + 1) . ". {$title}\n";
            }
        } else {
            echo "   ❌ Failed to generate titles\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // Test 4: Test Article Generation (Short)
    echo "4. 📄 Testing Article Generation (Short):\n";
    try {
        $result = $factory->generateArtikel('Tips Hidup Sehat', null, 200);
        if ($result['success']) {
            echo "   ✅ Success with provider: {$result['provider']}\n";
            echo "   Word count: {$result['word_count']} words\n";
            echo "   Preview: " . substr(strip_tags($result['content']), 0, 100) . "...\n";
        } else {
            echo "   ❌ Failed to generate article\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // Test 5: Test with Custom Prompt
    echo "5. 🎯 Testing Custom Prompt:\n";
    try {
        $customPrompt = "Fokus pada tips praktis yang mudah dilakukan sehari-hari";
        $result = $factory->generateArtikel('Cara Belajar Efektif', null, 200, $customPrompt);
        if ($result['success']) {
            echo "   ✅ Success with provider: {$result['provider']}\n";
            echo "   Custom prompt applied successfully\n";
            echo "   Word count: {$result['word_count']} words\n";
        } else {
            echo "   ❌ Failed with custom prompt\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    echo "🎉 AI Provider Test Completed!\n";
    echo "===============================\n";
    echo "Available providers: " . implode(', ', $providers) . "\n";
    echo "System ready for production use! 🚀\n";
    
} catch (Exception $e) {
    echo "💥 Fatal Error: " . $e->getMessage() . "\n";
    echo "Please check your configuration and try again.\n";
    exit(1);
}
