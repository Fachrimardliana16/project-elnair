<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$token = $_GET['token'] ?? '';
if ($token !== 'ISI_TOKEN_BARU_DI_SINI') {
    http_response_code(403);
    exit('Forbidden');
}

$projectPath = '/home/USERNAME/elnair'; // ganti dengan root Laravel asli

if (!is_dir($projectPath)) {
    http_response_code(500);
    exit('Project path not found: ' . $projectPath);
}

chdir($projectPath);

echo "<pre>";
echo "Current dir: " . getcwd() . "\n";

if (!file_exists('.env')) {
    if (!file_exists('.env.example')) {
        http_response_code(500);
        exit('.env.example not found');
    }

    if (!copy('.env.example', '.env')) {
        http_response_code(500);
        exit('Failed to create .env from .env.example');
    }

    echo ".env created from .env.example\n";
} else {
    echo ".env already exists, skipping copy\n";
}

$envContent = file_get_contents('.env');
if ($envContent === false) {
    http_response_code(500);
    exit('Failed to read .env');
}

if (strpos($envContent, 'APP_KEY=') === false || preg_match('/^APP_KEY=\s*$/m', $envContent)) {
    echo "APP_KEY missing, generating...\n";
    passthru('php artisan key:generate --force 2>&1', $keyExitCode);
    echo "key:generate exit code: " . $keyExitCode . "\n";

    if ($keyExitCode !== 0) {
        http_response_code(500);
        exit("Failed to generate APP_KEY");
    }
} else {
    echo "APP_KEY already exists, skipping key generation\n";
}

echo "Running migrations...\n";
passthru('php artisan migrate --force 2>&1', $migrateExitCode);
echo "migrate exit code: " . $migrateExitCode . "\n";

if ($migrateExitCode !== 0) {
    http_response_code(500);
    exit("Migration failed");
}

echo "Caching config...\n";
passthru('php artisan config:cache 2>&1', $configExitCode);
echo "config:cache exit code: " . $configExitCode . "\n";

echo "Caching routes...\n";
passthru('php artisan route:cache 2>&1', $routeExitCode);
echo "route:cache exit code: " . $routeExitCode . "\n";

echo "Caching views...\n";
passthru('php artisan view:cache 2>&1', $viewExitCode);
echo "view:cache exit code: " . $viewExitCode . "\n";

echo "\nDeployment tasks completed.\n";
echo "</pre>";