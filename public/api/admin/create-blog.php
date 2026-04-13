<?php
require_once __DIR__ . '/../helpers.php';

$user = authenticateAdmin($conn);
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['title']) || !isset($data['excerpt']) || !isset($data['content'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Title, excerpt, and content are required']);
    exit;
}

try {
    $stmt = $conn->prepare("
        INSERT INTO blogs (title, excerpt, content, image_url, category, author, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
    ");
    
    $stmt->execute([
        $data['title'],
        $data['excerpt'],
        $data['content'],
        $data['image_url'] ?? null,
        $data['category'] ?? null,
        $data['author'] ?? 'Admin'
    ]);

    http_response_code(201);
    echo json_encode(['message' => 'Blog created successfully', 'id' => $conn->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to create blog', 'error' => $e->getMessage()]);
}
