<?php
require_once __DIR__ . '/../helpers.php';
$user = authenticateAdmin($conn);
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'ID is required']);
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM portfolio WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['message' => 'Portfolio item deleted']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to delete portfolio item']);
}
