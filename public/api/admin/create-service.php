<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../helpers.php';

$user = requireAdmin();
$data = json_decode(file_get_contents("php://input"));

if (empty($data->title) || empty($data->description) || empty($data->slug)) {
    http_response_code(400);
    echo json_encode(['message' => 'Title, slug, and description are required']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO services (title, slug, description, icon, image_url, features, content, category, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([
    $data->title,
    $data->slug,
    $data->description,
    $data->icon ?? 'Briefcase',
    $data->image_url ?? '',
    $data->features ?? '[]',
    $data->content ?? '',
    $data->category ?? 'General',
    $data->status ?? 'active'
]);

$id = $conn->lastInsertId();

echo json_encode([
    'message' => 'Service created successfully',
    'id' => $id
]);
