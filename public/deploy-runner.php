<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$token = $_GET['token'] ?? '';
if ($token !== 'TOKEN_BARU_ANDA') {
    http_response_code(403);
    exit('Forbidden');
}

chdir('/home/chim6544/elnair'); // ganti dengan path root Laravel yang benar

echo "<pre>";
passthru('php artisan migrate --force 2>&1', $exitCode);
echo "\nExit code: " . $exitCode;
echo "</pre>";