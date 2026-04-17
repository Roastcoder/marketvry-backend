<?php
require_once __DIR__ . '/../../cors.php';
require_once __DIR__ . '/../../helpers.php';

$user = requireAdmin();

$stmt = $conn->prepare("SELECT id, review_text, status, created_at, updated_at FROM reviews ORDER BY created_at DESC");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($reviews);
