<?php
require_once __DIR__ . '/../helpers.php';

requireAdmin();

$stmt = $conn->prepare("DELETE FROM contact_submissions WHERE id = ?");
$stmt->execute([$_GET['id']]);

echo json_encode(['message' => 'Contact deleted']);
