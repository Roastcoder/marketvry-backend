<?php
require_once __DIR__ . '/config/database.php';

$_ENV = parse_ini_file(__DIR__ . '/.env');

$db = new Database();
$conn = $db->connect();

try {
    // Create blogs table
    $sql = "CREATE TABLE IF NOT EXISTS blogs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        excerpt TEXT NOT NULL,
        content LONGTEXT NOT NULL,
        image_url VARCHAR(500),
        category VARCHAR(100),
        author VARCHAR(100) DEFAULT 'Admin',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $conn->exec($sql);
    echo "✓ Blogs table created successfully!\n";
    
    // Insert sample blog
    $stmt = $conn->prepare("INSERT INTO blogs (title, excerpt, content, category, author) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        'Welcome to Our Blog',
        'This is our first blog post. Stay tuned for more updates!',
        'Welcome to our blog! We will be sharing insights, tips, and updates about digital marketing, web development, and more. Stay tuned for exciting content!',
        'General',
        'Admin'
    ]);
    
    echo "✓ Sample blog inserted successfully!\n";
    echo "\nDone! You can now use the blog system.\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
