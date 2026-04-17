<?php
require_once __DIR__ . '/../../cors.php';
require_once __DIR__ . '/../../helpers.php';
require_once __DIR__ . '/../reviews/ensure-table.php';

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

try {
    ensureReviewsTable($conn);
    $stmt = $conn->prepare("UPDATE reviews SET review_text = ?, status = ? WHERE id = ?");
    $stmt->execute([$reviewText, $status, $id]);

    echo json_encode(['message' => 'Review updated successfully']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()]);
}
