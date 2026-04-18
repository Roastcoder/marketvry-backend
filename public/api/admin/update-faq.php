<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../helpers.php';

$user = requireAdmin();
$data = json_decode(file_get_contents("php://input"));
$id = $_GET['id'] ?? null;

if (!$id || empty($data->question) || empty($data->answer)) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit();
}

$stmt = $conn->prepare("UPDATE faqs SET question = ?, answer = ?, category = ?, status = ?, sort_order = ? WHERE id = ?");
$stmt->execute([
    $data->question,
    $data->answer,
    $data->category ?? 'General',
    $data->status ?? 'active',
    $data->sort_order ?? 0,
    $id
]);

echo json_encode(['message' => 'FAQ updated successfully']);
