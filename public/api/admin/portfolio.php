<?php
require_once __DIR__ . '/../helpers.php';
$user = authenticateAdmin($conn);

try {
    $stmt = $conn->prepare("SELECT * FROM portfolio ORDER BY created_at DESC");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to fetch portfolio']);
}
