<?php
try {
    $stmt = $conn->prepare("SELECT * FROM portfolio ORDER BY created_at DESC");
    $stmt->execute();
    $portfolio = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($portfolio);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to fetch portfolio']);
}
