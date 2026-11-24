<?php

// 1. Arahkan semua cache file ke /tmp yang writable
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 2. Siapkan direktori storage writable di /tmp Vercel
$storagePath = '/tmp/storage';
$directories = [
    $storagePath . '/app',
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    '/tmp/bootstrap/cache',
];

foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        @mkdir($directory, 0755, true);
    }
}

// 3. Salin database sqlite lokal ke /tmp agar writable oleh Vercel Serverless
$sqliteSource = __DIR__ . '/../database/database.sqlite';
$sqliteDest = '/tmp/database.sqlite';
if (file_exists($sqliteSource)) {
    if (!file_exists($sqliteDest) || filesize($sqliteDest) !== filesize($sqliteSource)) {
        @copy($sqliteSource, $sqliteDest);
    }
}

// 4. Salin manifest packages jika ada (sudah diproteksi dari dev provider)
if (file_exists(__DIR__ . '/../bootstrap/cache/packages.php') && !file_exists('/tmp/packages.php')) {
    @copy(__DIR__ . '/../bootstrap/cache/packages.php', '/tmp/packages.php');
}

// 5. Autoload & Bootstrap Laravel 12
require __DIR__ . '/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->useStoragePath($storagePath);

// 6. Handle HTTP Request sesuai standar Laravel 12
$app->handleRequest(Request::capture());
