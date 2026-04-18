<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../helpers.php';

$user = requireAdmin();
$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit();
}

$conn->beginTransaction();

try {
    $stmt = $conn->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
    
    foreach ($data as $key => $value) {
        $stmt->execute([$key, $value, $value]);
    }
    
    $conn->commit();
    echo json_encode(['message' => 'Settings updated successfully']);
} catch (Exception $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode(['message' => 'Failed to update settings', 'error' => $e->getMessage()]);
}
