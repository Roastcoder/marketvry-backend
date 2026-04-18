<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../helpers.php';

$user = requireAdmin();
$data = json_decode(file_get_contents("php://input"));
$id = $_GET['id'] ?? null;

if (!$id || empty($data->title) || empty($data->description) || empty($data->slug)) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit();
}

$stmt = $conn->prepare("UPDATE services SET title = ?, slug = ?, description = ?, icon = ?, image_url = ?, features = ?, content = ?, category = ?, status = ? WHERE id = ?");
$stmt->execute([
    $data->title,
    $data->slug,
    $data->description,
    $data->icon ?? 'Briefcase',
    $data->image_url ?? '',
    $data->features ?? '[]',
    $data->content ?? '',
    $data->category ?? 'General',
    $data->status ?? 'active',
    $id
]);

echo json_encode(['message' => 'Service updated successfully']);
