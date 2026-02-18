<?php
require_once __DIR__ . '/config/database.php';

$_ENV = parse_ini_file(__DIR__ . '/.env');

$db = new Database();
$conn = $db->connect();

// Delete existing admin if exists
$stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
$stmt->execute(['admin@marketvry.com']);

// Create new admin with password: admin123
$password = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (email, password, full_name, role) VALUES (?, ?, ?, ?)");
$stmt->execute(['admin@marketvry.com', $password, 'Admin User', 'admin']);

echo "Admin user created successfully!\n";
echo "Email: admin@marketvry.com\n";
echo "Password: admin123\n";
echo "Password Hash: " . $password . "\n";
