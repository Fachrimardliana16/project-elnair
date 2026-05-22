<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Resolve Laravel root: local dev (../) or cPanel hosting (../../elnair/)
$laravelRoot = file_exists(__DIR__.'/../vendor/autoload.php')
    ? __DIR__.'/..'
    : __DIR__.'/../../elnair';

// Determine if the application is in maintenance mode...
if (file_exists($laravelRoot.'/storage/framework/maintenance.php')) {
    require $laravelRoot.'/storage/framework/maintenance.php';
}

// Register the Composer autoloader...
require $laravelRoot.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $laravelRoot.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
