<?php
require_once __DIR__ . '/../helpers.php';

$user = authenticateAdmin($conn);
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Blog ID is required']);
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['message' => 'Blog deleted successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to delete blog', 'error' => $e->getMessage()]);
}
