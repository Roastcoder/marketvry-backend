<?php

function ensureReviewsTable($conn) {
    $conn->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        review_text TEXT NOT NULL,
        status ENUM('uploaded', 'non_uploaded') NOT NULL DEFAULT 'non_uploaded',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
}
