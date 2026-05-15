<?php
echo "PHP is working. Version: " . PHP_VERSION . "\n";
echo "open_basedir: " . ini_get('open_basedir') . "\n";
echo "Current dir: " . __DIR__ . "\n";
$vendorPath = realpath(__DIR__ . '/../../vendor/autoload.php');
echo "Checking vendor path: " . (__DIR__ . '/../../vendor/autoload.php') . "\n";
echo "Real path: " . ($vendorPath ?: 'Not found or restricted') . "\n";
if ($vendorPath && file_exists($vendorPath)) {
    echo "Vendor file exists!\n";
} else {
    echo "Vendor file NOT found or access denied.\n";
}
?>
