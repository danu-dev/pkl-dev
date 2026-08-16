<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Setup dynamic SQLite database in /tmp for serverless environments (Vercel)
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $dbPath = '/tmp/database.sqlite';
    if (!file_exists($dbPath)) {
        touch($dbPath);
        // Copy pre-seeded database if exists or trigger migration
        if (file_exists(__DIR__.'/../database/database.sqlite')) {
            copy(__DIR__.'/../database/database.sqlite', $dbPath);
        }
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
