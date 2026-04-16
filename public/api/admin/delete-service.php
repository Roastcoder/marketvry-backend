<?php
require_once __DIR__ . '/../../cors.php';
require_once __DIR__ . '/../../helpers.php';

$user = requireAdmin();
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Service ID is required']);
    exit();
}

$stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
$stmt->execute([$id]);

echo json_encode(['message' => 'Service deleted successfully']);
