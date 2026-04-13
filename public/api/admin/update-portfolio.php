<?php
require_once __DIR__ . '/../helpers.php';
$user = authenticateAdmin($conn);
$data = json_decode(file_get_contents('php://input'), true);
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'ID is required']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE portfolio SET title = ?, description = ?, category = ?, client = ?, image_url = ?, project_url = ?, technologies = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([
        $data['title'],
        $data['description'],
        $data['category'] ?? null,
        $data['client'] ?? null,
        $data['image_url'] ?? null,
        $data['project_url'] ?? null,
        $data['technologies'] ?? null,
        $id
    ]);
    echo json_encode(['message' => 'Portfolio item updated']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to update portfolio item']);
}
