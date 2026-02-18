<?php
require_once __DIR__ . '/../helpers.php';

$user = requireAuth();

if (!isset($_FILES['avatar'])) {
    http_response_code(400);
    echo json_encode(['message' => 'No file uploaded']);
    exit();
}

$file = $_FILES['avatar'];
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $user['id'] . '_' . time() . '.' . $ext;
$uploadPath = '../../uploads/avatars/' . $filename;

if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    $avatarUrl = '/uploads/avatars/' . $filename;
    $stmt = $conn->prepare("UPDATE users SET avatar_url = ? WHERE id = ?");
    $stmt->execute([$avatarUrl, $user['id']]);
    echo json_encode(['message' => 'Avatar uploaded', 'avatar_url' => $avatarUrl]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Upload failed']);
}
