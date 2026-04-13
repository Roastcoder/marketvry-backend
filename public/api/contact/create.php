<?php
require_once __DIR__ . '/../cors.php';
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['email']) || !isset($data['message'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Name, email, and message are required']);
    exit;
}

try {
    $stmt = $conn->prepare("
        INSERT INTO contact_submissions (name, email, company, service, message)
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $data['name'],
        $data['email'],
        $data['company'] ?? null,
        $data['service'] ?? null,
        $data['message']
    ]);

    http_response_code(201);
    echo json_encode(['message' => 'Contact submission created successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to create contact submission', 'error' => $e->getMessage()]);
}
