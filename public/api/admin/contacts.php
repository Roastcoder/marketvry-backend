<?php
require_once __DIR__ . '/../helpers.php';

requireAdmin();

$stmt = $conn->query("SELECT * FROM contact_submissions ORDER BY created_at DESC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($contacts);
