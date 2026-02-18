<?php
require_once __DIR__ . '/../helpers.php';

requireAdmin();

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$_GET['id']]);

echo json_encode(['message' => 'User deleted']);
