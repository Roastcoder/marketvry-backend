<?php
require_once __DIR__ . '/../../cors.php';
require_once __DIR__ . '/../../helpers.php';

$user = requireAdmin();
$data = json_decode(file_get_contents("php://input"));

$reviewText = trim($data->review_text ?? '');
$status = $data->status ?? 'non_uploaded';
$sheetRow = isset($data->sheet_row) && $data->sheet_row !== '' ? (int)$data->sheet_row : null;

if ($reviewText === '') {
    http_response_code(400);
    echo json_encode(['message' => 'Review text is required']);
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
    $stmt = $conn->prepare("INSERT INTO reviews (review_text, status, sheet_row) VALUES (?, ?, ?)");
    $stmt->execute([$reviewText, $status, $sheetRow]);

    echo json_encode([
        'message' => 'Review created successfully',
        'id' => $conn->lastInsertId()
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()]);
}
