<?php
require_once __DIR__ . '/config/database.php';

$_ENV = parse_ini_file(__DIR__ . '/.env');

$db = new Database();
$conn = $db->connect();

try {
    $sql = "CREATE TABLE IF NOT EXISTS jobs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        department VARCHAR(100),
        location VARCHAR(100),
        type VARCHAR(50),
        experience VARCHAR(50),
        salary_range VARCHAR(100),
        description TEXT,
        requirements TEXT,
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $conn->exec($sql);
    echo "✓ Jobs table created successfully!\n";
    
    // Insert sample job
    $stmt = $conn->prepare("INSERT INTO jobs (title, department, location, type, experience, salary_range, description, requirements) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        'Full Stack Developer',
        'Engineering',
        'Remote',
        'Full-time',
        '3+ years',
        '₹12L - ₹25L PA',
        'We are looking for a passionate Full Stack Developer to join our core team. You will be responsible for building high-quality, scalable web applications using React, Node.js, and PHP.',
        'Proficiency in React, TypeScript, and Node.js. Experience with PHP/Laravel is a plus. Strong problem-solving skills.'
    ]);
    
    echo "✓ Sample job inserted successfully!\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
