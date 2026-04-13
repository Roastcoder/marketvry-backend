<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../helpers.php';

$user = requireAuth();

$stmt = $conn->prepare("SELECT id, email, full_name, phone, address, avatar_url, role FROM users WHERE id = ?");
$stmt->execute([$user['id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'profile' => $profile,
    'role' => $profile['role']
]);
