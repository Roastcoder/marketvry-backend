<?php

function ensureReviewsTable($conn) {
    $existsStmt = $conn->query("SHOW TABLES LIKE 'reviews'");
    if ($existsStmt && $existsStmt->fetch()) {
        return;
    }

    try {
        $conn->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        review_text TEXT NOT NULL,
        status ENUM('uploaded', 'non_uploaded') NOT NULL DEFAULT 'non_uploaded',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    } catch (PDOException $e) {
        throw new RuntimeException(
            "Reviews table is missing and could not be auto-created. Please run create_reviews_table.sql on the production database. DB error: " . $e->getMessage()
        );
    }
}
