<?php
$token = $_GET['token'] ?? '';
if ($token !== '20850ba12d0f486dac9a913a0da2db237cc1ef622e6fd4cc') {
    http_response_code(403);
    exit('Forbidden');
}

$possiblePaths = [
    realpath(__DIR__ . '/../..'),
    realpath(__DIR__ . '/..'),
    '/home/chim6544/elnair',
];

$projectPath = null;
foreach ($possiblePaths as $path) {
    if ($path && is_dir($path) && file_exists($path . '/artisan')) {
        $projectPath = $path;
        break;
    }
}

if (!$projectPath) {
    exit('Error: Laravel project root not found.');
}

chdir($projectPath);
$php = PHP_BINARY;

echo "<pre>";
echo "Project: $projectPath\n\n";

passthru("$php artisan cache:clear 2>&1");
passthru("$php artisan config:cache 2>&1");
passthru("$php artisan route:cache 2>&1");
passthru("$php artisan view:cache 2>&1");
passthru("$php artisan optimize 2>&1");

echo "\nDone.</pre>";
