<?php
require_once __DIR__ . '/../helpers.php';

$user = authenticateAdmin($conn);

try {
    $stmt = $conn->prepare("SELECT * FROM blogs ORDER BY created_at DESC");
    $stmt->execute();
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($blogs);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to fetch blogs', 'error' => $e->getMessage()]);
}
