<?php
require_once __DIR__ . '/../cors.php';
$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Blog ID is required']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$blog) {
        http_response_code(404);
        echo json_encode(['message' => 'Blog not found']);
        exit;
    }
    
    echo json_encode($blog);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to fetch blog', 'error' => $e->getMessage()]);
}
