<?php
require_once __DIR__ . '/../helpers.php';

$user = authenticateAdmin($conn);
$data = json_decode(file_get_contents('php://input'), true);
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Blog ID is required']);
    exit;
}

try {
    $stmt = $conn->prepare("
        UPDATE blogs 
        SET title = ?, excerpt = ?, content = ?, image_url = ?, category = ?, author = ?, updated_at = NOW()
        WHERE id = ?
    ");
    
    $stmt->execute([
        $data['title'],
        $data['excerpt'],
        $data['content'],
        $data['image_url'] ?? null,
        $data['category'] ?? null,
        $data['author'] ?? 'Admin',
        $id
    ]);

    echo json_encode(['message' => 'Blog updated successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to update blog', 'error' => $e->getMessage()]);
}
