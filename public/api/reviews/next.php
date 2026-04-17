<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/ensure-table.php';

try {
    ensureReviewsTable($conn);
    $stmt = $conn->prepare("SELECT id, review_text, status, created_at FROM reviews WHERE status = 'non_uploaded' ORDER BY created_at ASC LIMIT 1");
    $stmt->execute();
    $review = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$review) {
        echo json_encode(null);
        exit();
    }

    echo json_encode($review);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to fetch review']);
}
