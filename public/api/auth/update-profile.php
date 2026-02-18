<?php
require_once __DIR__ . '/../helpers.php';

$user = requireAuth();
$data = json_decode(file_get_contents("php://input"));

$updates = [];
$params = [];

if (isset($data->full_name)) {
    $updates[] = "full_name = ?";
    $params[] = $data->full_name;
}
if (isset($data->phone)) {
    $updates[] = "phone = ?";
    $params[] = $data->phone;
}
if (isset($data->address)) {
    $updates[] = "address = ?";
    $params[] = $data->address;
}

if (empty($updates)) {
    echo json_encode(['message' => 'No updates provided']);
    exit();
}

$params[] = $user['id'];
$sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute($params);

echo json_encode(['message' => 'Profile updated']);
