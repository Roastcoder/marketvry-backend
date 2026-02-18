<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo json_encode([
    'status' => 'success',
    'message' => 'Marketvry API is running',
    'version' => '1.0',
    'endpoints' => [
        '/api/auth/login',
        '/api/auth/register',
        '/api/contact/create',
        '/api/blogs/list',
        '/api/portfolio/list'
    ]
]);
