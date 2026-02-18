<?php
require_once __DIR__ . '/../helpers.php';

requireAdmin();

$stmt = $conn->prepare("DELETE FROM service_requests WHERE id = ?");
$stmt->execute([$_GET['id']]);

echo json_encode(['message' => 'Request deleted']);
