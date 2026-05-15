<?php

if (!isset($_GET['token']) || $_GET['token'] !== 'elnair_2026_token_rahasia_123') {
    http_response_code(403);
    exit('Forbidden');
}

use Illuminate\Contracts\Console\Kernel;

// Menyesuaikan path agar sama dengan index.php yang sudah berhasil
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

header('Content-Type: text/plain');

echo "== optimize:clear ==\n";
$kernel->call('optimize:clear');
echo $kernel->output() . "\n";

echo "== migrate --force ==\n";
$kernel->call('migrate', ['--force' => true]);
echo $kernel->output() . "\n";
