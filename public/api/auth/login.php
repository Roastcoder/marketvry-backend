<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../helpers.php';

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->email) || !isset($data->password)) {
    http_response_code(400);
    echo json_encode(['message' => 'Email and password required']);
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$data->email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($data->password, $user['password'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid credentials']);
    exit();
}

$token = createToken($user['id'], $user['email'], $user['role']);

echo json_encode([
    'token' => $token,
    'user' => [
        'id' => $user['id'],
        'email' => $user['email'],
        'full_name' => $user['full_name']
    ]
]);
