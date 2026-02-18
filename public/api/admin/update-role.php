<?php
require_once __DIR__ . '/../helpers.php';

requireAdmin();

$data = json_decode(file_get_contents("php://input"));

$stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
$stmt->execute([$data->role, $_GET['id']]);

echo json_encode(['message' => 'Role updated']);
