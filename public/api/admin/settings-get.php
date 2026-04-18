<?php
require_once __DIR__ . '/../cors.php';
require_once __DIR__ . '/../helpers.php';

$user = requireAuth(); // Non-admins might need read access, but this is admin panel so requireAuth is fine or requireAdmin.
// Actually settings config might be public eventually, but for now we'll allow auth'd reading.
// Let's use requireAdmin() for strict admin-only.
$user = requireAdmin();

$stmt = $conn->prepare("SELECT setting_key, setting_value FROM settings");
$stmt->execute();
$settingsRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

$settings = [];
foreach ($settingsRaw as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

echo json_encode($settings);
