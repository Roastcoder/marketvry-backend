<?php
require_once __DIR__ . '/../helpers.php';

requireAdmin();

$data = json_decode(file_get_contents("php://input"));

$stmt = $conn->prepare("UPDATE service_requests SET status = ?, is_read = ? WHERE id = ?");
$stmt->execute([$data->status, $data->is_read ?? 1, $_GET['id']]);

echo json_encode(['message' => 'Request updated']);
