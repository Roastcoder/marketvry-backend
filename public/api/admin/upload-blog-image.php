<?php
require_once __DIR__ . '/../helpers.php';

$user = authenticateAdmin($conn);

// Debug: log what we receive
error_log('FILES: ' . print_r($_FILES, true));
error_log('POST: ' . print_r($_POST, true));

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    $error = isset($_FILES['image']) ? $_FILES['image']['error'] : 'No file';
    echo json_encode(['message' => 'No image file provided', 'error' => $error, 'files' => $_FILES]);
    exit;
}

$file = $_FILES['image'];
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($file['type'], $allowedTypes)) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid file type. Only JPG, PNG, GIF, and WebP allowed', 'type' => $file['type']]);
    exit;
}

if ($file['size'] > 5 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(['message' => 'File too large. Maximum 5MB']);
    exit;
}

$uploadDir = __DIR__ . '/../../../uploads/blogs/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid('blog_') . '.' . $extension;
$filepath = $uploadDir . $filename;

if (move_uploaded_file($file['tmp_name'], $filepath)) {
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    $imageUrl = $baseUrl . '/uploads/blogs/' . $filename;
    echo json_encode(['message' => 'Image uploaded successfully', 'url' => $imageUrl]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to upload image', 'error' => error_get_last()]);
}
