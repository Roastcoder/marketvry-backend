<?php
// CORS headers must be set before any output
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Serve uploaded files
if (preg_match('/^\/uploads\//', $_SERVER["REQUEST_URI"])) {
    $file = __DIR__ . '/..' . $_SERVER["REQUEST_URI"];
    if (file_exists($file) && is_file($file)) {
        $mime = mime_content_type($file);
        header("Content-Type: $mime");
        readfile($file);
        exit();
    }
    http_response_code(404);
    exit();
}

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|svg|ico)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}

$_SERVER['SCRIPT_NAME'] = '/api/index.php';
require __DIR__ . '/api/index.php';
