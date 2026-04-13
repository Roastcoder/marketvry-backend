<?php
require_once __DIR__ . '/../helpers.php';

requireAdmin();

$data = json_decode(file_get_contents("php://input"));

$stmt = $conn->prepare("UPDATE contact_submissions SET is_read = ?, status = ? WHERE id = ?");
$stmt->execute([$data->is_read ?? 1, $data->status ?? 'read', $_GET['id']]);

echo json_encode(['message' => 'Contact updated']);
