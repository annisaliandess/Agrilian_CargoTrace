<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Siapkan direktori storage writable di /tmp Vercel
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

// 2. Salin database sqlite lokal ke /tmp agar writable oleh Vercel Serverless
$sqliteSource = __DIR__ . '/../database/database.sqlite';
$sqliteDest = '/tmp/database.sqlite';
if (file_exists($sqliteSource) && !file_exists($sqliteDest)) {
    @copy($sqliteSource, $sqliteDest);
}

// 3. Autoload & Bootstrap Laravel 12
require __DIR__ . '/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->useStoragePath($storagePath);

// 4. Handle HTTP Request sesuai standar Laravel 12
$app->handleRequest(Request::capture());
