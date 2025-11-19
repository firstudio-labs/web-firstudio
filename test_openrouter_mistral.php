<?php

require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\AIServiceFactory;
use App\Services\OpenRouterAIService;

echo "\n== Test OpenRouter (Mistral Small 3.2 24B free) ==\n";

// Opsional: paksa provider via env runtime jika .env belum di-set
if (!getenv('AI_PREFERRED_PROVIDER')) {
    putenv('AI_PREFERRED_PROVIDER=openrouter');
}

try {
    // Uji OpenRouter secara langsung terlebih dahulu
    echo "Testing OpenRouter directly...\n";
    $openRouter = new OpenRouterAIService();
    
    // Debug konfigurasi OpenRouter
    $config = $openRouter->debugConfig();
    echo "OpenRouter config:\n";
    echo " - API key exists: " . ($config['api_key_exists'] ? 'yes' : 'no') . "\n";
    echo " - API key prefix: " . $config['api_key_prefix'] . "\n";
    echo " - Base URL: " . $config['base_url'] . "\n";
    echo " - Current model: " . $config['current_model'] . "\n";
    echo " - Headers: " . implode(", ", $config['headers']) . "\n\n";
    
    // Test koneksi OpenRouter langsung
    echo "Testing OpenRouter connection directly...\n";
    $isAvailable = $openRouter->isAvailable();
    echo "OpenRouter direct test: " . ($isAvailable ? "SUCCESSFUL" : "FAILED") . "\n\n";
    
    // Lanjut dengan factory
    $factory = new AIServiceFactory();
    
    // Force provider to OpenRouter
    echo "Setting provider to OpenRouter...\n";
    $factory->setProvider('openrouter');
    
    // Cek status provider
    $status = $factory->getProviderStatus();
    echo "Provider status:\n";
    foreach ($status as $name => $info) {
        $avail = $info['available'] ? 'available' : 'unavailable';
        $cfg = !empty($info['api_key_configured']) ? 'configured' : 'not-configured';
        echo " - {$name}: {$avail}, {$cfg}\n";
    }
    echo "\n";

    // Generate artikel singkat untuk uji
    echo "Memulai request ke OpenRouter (Mistral)...\n";
    $start = microtime(true);
    
    // Tampilkan provider yang aktif
    echo "Provider aktif: " . $factory->getCurrentProvider() . "\n";
    
    // Set timeout lebih tinggi
    ini_set('max_execution_time', 120);
    
    $result = $factory->generateArtikel('Manfaat Teh Hijau untuk Kesehatan', 'Kesehatan', 250);
    $end = microtime(true);

    if (!empty($result['success'])) {
        $time = round(($end - $start), 2);
        $preview = strip_tags($result['content']);
        echo "✅ Sukses\n";
        echo "Provider: " . ($result['provider'] ?? 'unknown') . "\n";
        echo "Durasi: {$time}s\n";
        echo "Kata: " . ($result['word_count'] ?? 0) . "\n";
        echo "Preview: " . substr($preview, 0, 180) . "...\n";
    } else {
        echo "❌ Gagal tanpa detail error.\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    
    // Tampilkan stack trace untuk debugging
    echo "\nStack trace:\n";
    echo $e->getTraceAsString() . "\n";
}


