<?php
require_once __DIR__ . '/../cors.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Review ID is required']);
    exit();
}

try {
    $stmt = $conn->prepare("UPDATE reviews SET status = 'uploaded' WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['message' => 'Review marked as uploaded']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to update review status']);
}
