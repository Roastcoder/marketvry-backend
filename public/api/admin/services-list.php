<?php
require_once __DIR__ . '/../../cors.php';
require_once __DIR__ . '/../../helpers.php';

$user = requireAdmin();

$stmt = $conn->prepare("SELECT * FROM services ORDER BY created_at DESC");
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($services);
