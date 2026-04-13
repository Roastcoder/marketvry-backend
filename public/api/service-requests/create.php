<?php
require_once __DIR__ . '/../cors.php';
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->name) || !isset($data->email) || !isset($data->service_type)) {
    http_response_code(400);
    echo json_encode(['message' => 'Required fields missing']);
    exit();
}

try {
    $stmt = $conn->prepare("INSERT INTO service_requests (user_id, name, email, phone, service_type, budget, timeline, description, status, is_read) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', 0)");
    $stmt->execute([
        $data->user_id ?? null,
        $data->name,
        $data->email,
        $data->phone ?? null,
        $data->service_type,
        $data->budget ?? null,
        $data->timeline ?? null,
        $data->description ?? null
    ]);

    http_response_code(201);
    echo json_encode(['message' => 'Request submitted successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to submit request', 'error' => $e->getMessage()]);
}
