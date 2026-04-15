<?php
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/../config/database.php';
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $_ENV = array_merge($_ENV, parse_ini_file($envPath));
}

try {
    $db = new Database();
    $conn = $db->connect();

    // Delete existing admin if exists
    $stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
    $stmt->execute(['admin@marketvry.com']);

    // Create new admin
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (email, password, full_name, role) VALUES (?, ?, ?, ?)");
    $stmt->execute(['admin@marketvry.com', $password, 'Admin User', 'admin']);

    echo "<h1>Admin account has been forcefully created!</h1>";
    echo "<p>Email: admin@marketvry.com</p>";
    echo "<p>Password: admin123</p>";
    echo "<p style='color:red;'>SECURITY WARNING: Let me know so I can delete this file now.</p>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
