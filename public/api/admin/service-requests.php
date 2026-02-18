<?php
require_once __DIR__ . '/../helpers.php';

requireAdmin();

$stmt = $conn->query("SELECT * FROM service_requests ORDER BY created_at DESC");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($requests);
