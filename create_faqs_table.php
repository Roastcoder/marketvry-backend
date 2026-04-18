<?php
require_once __DIR__ . '/config/database.php';

try {
    $database = new Database();
    $db = $database->connect();

    $sql = "CREATE TABLE IF NOT EXISTS faqs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question TEXT NOT NULL,
        answer TEXT NOT NULL,
        category VARCHAR(100) DEFAULT 'General',
        status ENUM('active', 'inactive') DEFAULT 'active',
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    $db->exec($sql);
    echo "FAQs table created successfully!\n";

    // Add some sample data if empty
    $check = $db->query("SELECT COUNT(*) FROM faqs")->fetchColumn();
    if ($check == 0) {
        $seed = "INSERT INTO faqs (question, answer, category, sort_order) VALUES 
            ('What services do you offer?', 'We offer a comprehensive range of digital solutions including Digital Marketing, Web Development, SEO, and AI Agent services.', 'Services', 1),
            ('How long does a typical project take?', 'Project timelines vary depending on complexity. A typical website development project takes 4-8 weeks, while digital marketing campaigns are ongoing.', 'Process', 2),
            ('Do you provide custom AI solutions?', 'Yes, we specialize in building custom AI agents for customer support, lead qualification, and business automation.', 'AI Solutions', 3)";
        $db->exec($seed);
        echo "Sample FAQs seeded successfully!\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
