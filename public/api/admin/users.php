<?php
require_once __DIR__ . '/../helpers.php';

requireAdmin();

$stmt = $conn->query("SELECT id, email, full_name, phone, role, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
