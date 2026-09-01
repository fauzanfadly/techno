<?php

/*
|--------------------------------------------------------------------------
| Front controller PRODUKSI (cPanel split-public)
|--------------------------------------------------------------------------
| File ini menggantikan public/index.php di server, diletakkan di dalam
| folder web root aktif (laravel_public/ yang di-rename jadi public_html/).
| Semua path menunjuk ke /home/techno/laravel_app (sibling folder, stabil).
|
| __DIR__ = folder web root aktif (public_html ATAU laravel_public); keduanya
| sibling langsung laravel_app di bawah /home/techno, jadi '/../laravel_app'
| selalu benar apa pun nama folder ini (rename-safe).
|
| JANGAN pakai file ini di lokal — pakai public/index.php bawaan.
| Lihat docs/DEPLOY-CPANEL.md bagian 2.5.
*/

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../laravel_app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../laravel_app/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../laravel_app/bootstrap/app.php')
    ->handleRequest(Request::capture());
