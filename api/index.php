<?php

// Pastikan direktori writable sementara di /tmp tersedia untuk Vercel Serverless
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Forward request Vercel ke index aplikasi Laravel
require __DIR__ . '/../public/index.php';
