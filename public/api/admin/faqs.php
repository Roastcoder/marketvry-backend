<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../helpers.php';

$user = requireAdmin();

$stmt = $conn->prepare("SELECT * FROM faqs ORDER BY sort_order ASC, created_at DESC");
$stmt->execute();
$faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($faqs);
