<?php
require_once __DIR__ . '/../helpers.php';
$user = authenticateAdmin($conn);
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['title']) || !isset($data['description'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Title and description are required']);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO portfolio (title, description, category, client, image_url, project_url, technologies) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['title'],
        $data['description'],
        $data['category'] ?? null,
        $data['client'] ?? null,
        $data['image_url'] ?? null,
        $data['project_url'] ?? null,
        $data['technologies'] ?? null
    ]);
    http_response_code(201);
    echo json_encode(['message' => 'Portfolio item created', 'id' => $conn->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to create portfolio item']);
}
