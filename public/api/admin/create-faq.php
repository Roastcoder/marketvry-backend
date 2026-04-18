<?php
require_once __DIR__ . '/../../cors.php';
require_once __DIR__ . '/../../helpers.php';

$user = requireAdmin();
$data = json_decode(file_get_contents("php://input"));

if (empty($data->question) || empty($data->answer)) {
    http_response_code(400);
    echo json_encode(['message' => 'Question and answer are required']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO faqs (question, answer, category, status, sort_order) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([
    $data->question,
    $data->answer,
    $data->category ?? 'General',
    $data->status ?? 'active',
    $data->sort_order ?? 0
]);

$id = $conn->lastInsertId();

echo json_encode([
    'message' => 'FAQ created successfully',
    'id' => $id
]);
