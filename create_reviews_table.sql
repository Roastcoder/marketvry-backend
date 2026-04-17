-- Execute this script to create the reviews table.

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    review_text TEXT NOT NULL,
    status ENUM('uploaded', 'non_uploaded') NOT NULL DEFAULT 'non_uploaded',
    sheet_row INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
