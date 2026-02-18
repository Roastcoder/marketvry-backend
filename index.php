<?php
// Root index.php - Routes all requests to public/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Route to public directory
$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace('/api', '', $uri); // Remove /api prefix if exists

if (file_exists(__DIR__ . '/public' . $uri)) {
    require __DIR__ . '/public' . $uri;
} else {
    require __DIR__ . '/public/api/index.php';
}
