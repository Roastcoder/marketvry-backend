<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../helpers.php';

$user = requireAdmin();
$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"));

if (!$id) {
    http_response_code(400);
    echo json_encode(['message' => 'Review ID is required']);
    exit();
}

$reviewText = trim($data->review_text ?? '');
$status = $data->status ?? null;
$sheetRow = isset($data->sheet_row) && $data->sheet_row !== '' ? (int)$data->sheet_row : null;

if ($reviewText === '' || !$status) {
    http_response_code(400);
    echo json_encode(['message' => 'Review text and status are required']);
    exit();
}

if (!in_array($status, ['uploaded', 'non_uploaded'], true)) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid status']);
    exit();
}

if ($sheetRow !== null && $sheetRow < 1) {
    http_response_code(400);
    echo json_encode(['message' => 'Sheet row must be a positive integer']);
    exit();
}

try {
    $stmt = $conn->prepare("UPDATE reviews SET review_text = ?, status = ?, sheet_row = ? WHERE id = ?");
    $stmt->execute([$reviewText, $status, $sheetRow, $id]);

    echo json_encode(['message' => 'Review updated successfully']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()]);
}
