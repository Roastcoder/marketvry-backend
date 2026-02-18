<?php
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->email) || !isset($data->password) || !isset($data->fullName)) {
    http_response_code(400);
    echo json_encode(['message' => 'All fields required']);
    exit();
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$data->email]);
if ($stmt->fetch()) {
    http_response_code(400);
    echo json_encode(['message' => 'Email already exists']);
    exit();
}

$hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (email, password, full_name, role) VALUES (?, ?, ?, 'customer')");
$stmt->execute([$data->email, $hashedPassword, $data->fullName]);

echo json_encode(['message' => 'Registration successful']);
