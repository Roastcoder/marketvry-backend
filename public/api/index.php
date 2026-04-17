<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    die();
}

// Resolve backend root for both local and deployed layouts
$candidateRoots = [
    realpath(__DIR__ . '/../../'),
    realpath(__DIR__ . '/../'),
    realpath(__DIR__ . '/../../../'),
];

$backendRoot = null;
foreach ($candidateRoots as $root) {
    if ($root && file_exists($root . '/config/database.php')) {
        $backendRoot = $root;
        break;
    }
}

if (!$backendRoot) {
    http_response_code(500);
    echo json_encode(['message' => 'Server configuration error']);
    exit;
}

require_once $backendRoot . '/config/database.php';
require_once __DIR__ . '/helpers.php';

$envPath = $backendRoot . '/.env';
$envData = file_exists($envPath) ? parse_ini_file($envPath) : [];
if (!is_array($envData)) {
    $envData = [];
}
$_ENV = array_merge($_ENV ?? [], $envData);

$db = new Database();
$conn = $db->connect();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['message' => 'Database connection failed']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/api/index.php', '', $path);
$path = str_replace('/api', '', $path);
if ($path !== '/') {
    $path = rtrim($path, '/');
    if ($path === '') {
        $path = '/';
    }
}

// Auth endpoints
if ($path === '/auth/login' && $method === 'POST') {
    require_once 'auth/login.php';
} elseif ($path === '/auth/register' && $method === 'POST') {
    require_once 'auth/register.php';
} elseif ($path === '/auth/profile' && $method === 'GET') {
    require_once 'auth/profile.php';
} elseif ($path === '/auth/profile' && $method === 'PUT') {
    require_once 'auth/update-profile.php';
} elseif ($path === '/auth/avatar' && $method === 'POST') {
    require_once 'auth/upload-avatar.php';
}
// Service requests
elseif ($path === '/service-requests' && $method === 'POST') {
    require_once 'service-requests/create.php';
}
// Contact form
elseif ($path === '/contact' && $method === 'POST') {
    require_once 'contact/create.php';
}
// Public blog endpoints
elseif ($path === '/blogs' && $method === 'GET') {
    require_once 'blogs/list.php';
} elseif (preg_match('/^\/blogs\/([^\/]+)$/', $path, $matches) && $method === 'GET') {
    $_GET['id'] = $matches[1];
    require_once 'blogs/detail.php';
}
// Public review endpoints
elseif ($path === '/reviews/next' && $method === 'GET') {
    try {
        $stmt = $conn->prepare("SELECT id, review_text, status, sheet_row, created_at FROM reviews WHERE status = 'non_uploaded' ORDER BY created_at ASC LIMIT 1");
        $stmt->execute();
        $review = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($review ?: null);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to fetch review: ' . $e->getMessage()]);
    }
} elseif (preg_match('/^\/reviews\/([^\/]+)\/uploaded$/', $path, $matches) && ($method === 'PUT' || $method === 'POST')) {
    try {
        $id = $matches[1];
        $stmt = $conn->prepare("UPDATE reviews SET status = 'uploaded' WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Review marked as uploaded']);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to update review status: ' . $e->getMessage()]);
    }
}
// Admin endpoints
elseif ($path === '/admin/users' && $method === 'GET') {
    require_once 'admin/users.php';
} elseif (preg_match('/^\/admin\/users\/([^\/]+)$/', $path, $matches) && $method === 'DELETE') {
    $_GET['id'] = $matches[1];
    require_once 'admin/delete-user.php';
} elseif (preg_match('/^\/admin\/users\/([^\/]+)\/role$/', $path, $matches) && $method === 'PUT') {
    $_GET['id'] = $matches[1];
    require_once 'admin/update-role.php';
} elseif ($path === '/admin/contacts' && $method === 'GET') {
    require_once 'admin/contacts.php';
} elseif (preg_match('/^\/admin\/contacts\/([^\/]+)$/', $path, $matches) && $method === 'PUT') {
    $_GET['id'] = $matches[1];
    require_once 'admin/update-contact.php';
} elseif (preg_match('/^\/admin\/contacts\/([^\/]+)$/', $path, $matches) && $method === 'DELETE') {
    $_GET['id'] = $matches[1];
    require_once 'admin/delete-contact.php';
} elseif ($path === '/admin/service-requests' && $method === 'GET') {
    require_once 'admin/service-requests.php';
} elseif (preg_match('/^\/admin\/service-requests\/([^\/]+)$/', $path, $matches) && $method === 'PUT') {
    $_GET['id'] = $matches[1];
    require_once 'admin/update-service-request.php';
} elseif (preg_match('/^\/admin\/service-requests\/([^\/]+)$/', $path, $matches) && $method === 'DELETE') {
    $_GET['id'] = $matches[1];
    require_once 'admin/delete-service-request.php';
} elseif ($path === '/admin/reviews' && $method === 'GET') {
    $user = requireAdmin();
    try {
        $stmt = $conn->prepare("SELECT id, review_text, status, sheet_row, created_at, updated_at FROM reviews ORDER BY created_at DESC");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to load reviews: ' . $e->getMessage()]);
    }
} elseif ($path === '/admin/reviews' && $method === 'POST') {
    $user = requireAdmin();
    try {
        $data = json_decode(file_get_contents("php://input"));
        $reviewText = trim($data->review_text ?? '');
        $status = $data->status ?? 'non_uploaded';
        $sheetRow = isset($data->sheet_row) && $data->sheet_row !== '' ? (int)$data->sheet_row : null;
        if ($reviewText === '') {
            http_response_code(400);
            echo json_encode(['message' => 'Review text is required']);
            exit();
        }
        if (!in_array($status, ['uploaded', 'non_uploaded'], true)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid status']);
            exit();
        }
        if ($sheetRow !== null && $sheetRow < 1) {
            http_response_code(400);
            echo json_encode(['message' => 'Sheet row must be a positive integer']);
            exit();
        }
        $stmt = $conn->prepare("INSERT INTO reviews (review_text, status, sheet_row) VALUES (?, ?, ?)");
        $stmt->execute([$reviewText, $status, $sheetRow]);
        echo json_encode(['message' => 'Review created successfully', 'id' => $conn->lastInsertId()]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to create review: ' . $e->getMessage()]);
    }
} elseif (preg_match('/^\/admin\/reviews\/([^\/]+)$/', $path, $matches) && $method === 'PUT') {
    $user = requireAdmin();
    try {
        $id = $matches[1];
        $data = json_decode(file_get_contents("php://input"));
        $reviewText = trim($data->review_text ?? '');
        $status = $data->status ?? null;
        $sheetRow = isset($data->sheet_row) && $data->sheet_row !== '' ? (int)$data->sheet_row : null;
        if ($reviewText === '' || !$status) {
            http_response_code(400);
            echo json_encode(['message' => 'Review text and status are required']);
            exit();
        }
        if (!in_array($status, ['uploaded', 'non_uploaded'], true)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid status']);
            exit();
        }
        if ($sheetRow !== null && $sheetRow < 1) {
            http_response_code(400);
            echo json_encode(['message' => 'Sheet row must be a positive integer']);
            exit();
        }
        $stmt = $conn->prepare("UPDATE reviews SET review_text = ?, status = ?, sheet_row = ? WHERE id = ?");
        $stmt->execute([$reviewText, $status, $sheetRow, $id]);
        echo json_encode(['message' => 'Review updated successfully']);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to update review: ' . $e->getMessage()]);
    }
} elseif (preg_match('/^\/admin\/reviews\/([^\/]+)$/', $path, $matches) && $method === 'DELETE') {
    $user = requireAdmin();
    try {
        $id = $matches[1];
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Review deleted successfully']);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to delete review: ' . $e->getMessage()]);
    }
} elseif ($path === '/admin/reviews/sync-from-sheet' && $method === 'POST') {
    $user = requireAdmin();
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        $sheetScriptUrl = trim($data['sheet_script_url'] ?? '');

        if (!$sheetScriptUrl) {
            http_response_code(400);
            echo json_encode(['message' => 'sheet_script_url is required']);
            exit();
        }

        // Validate it's a Google Apps Script URL
        if (!str_contains($sheetScriptUrl, 'script.google.com')) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid Google Apps Script URL']);
            exit();
        }

        // Fetch list of reviews from the Google Apps Script
        $listUrl = $sheetScriptUrl . (str_contains($sheetScriptUrl, '?') ? '&' : '?') . 'action=list';
        $ctx = stream_context_create([
            'http' => [
                'method'          => 'GET',
                'timeout'         => 15,
                'ignore_errors'   => true,
                'follow_location' => true,
            ],
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ]);

        $raw = @file_get_contents($listUrl, false, $ctx);
        if ($raw === false) {
            http_response_code(502);
            echo json_encode(['message' => 'Could not reach Google Apps Script. Check the URL and ensure the script is deployed as a web app with public access.']);
            exit();
        }

        $rows = json_decode($raw, true);
        if (!is_array($rows)) {
            http_response_code(502);
            echo json_encode(['message' => 'Google Apps Script did not return valid JSON. Make sure the script supports ?action=list and returns [{row, review_text, status},...].', 'raw' => substr($raw, 0, 500)]);
            exit();
        }

        $imported = 0;
        $skipped  = 0;

        foreach ($rows as $row) {
            $rowNum     = isset($row['row']) ? (int)$row['row'] : null;
            $reviewText = trim($row['review_text'] ?? $row['text'] ?? $row['Review'] ?? '');
            $statusRaw  = strtolower(trim($row['status'] ?? $row['Status'] ?? 'non_uploaded'));
            $status     = in_array($statusRaw, ['uploaded'], true) ? 'uploaded' : 'non_uploaded';

            if ($reviewText === '') {
                $skipped++;
                continue;
            }

            // Skip if a review with this sheet_row already exists
            if ($rowNum !== null && $rowNum > 0) {
                $check = $conn->prepare("SELECT id FROM reviews WHERE sheet_row = ? LIMIT 1");
                $check->execute([$rowNum]);
                if ($check->fetch()) {
                    $skipped++;
                    continue;
                }
            }

            $stmt = $conn->prepare("INSERT INTO reviews (review_text, status, sheet_row) VALUES (?, ?, ?)");
            $stmt->execute([$reviewText, $status, ($rowNum > 0 ? $rowNum : null)]);
            $imported++;
        }

        echo json_encode([
            'message'  => "Sync complete. Imported: {$imported}, Skipped (already exist or empty): {$skipped}.",
            'imported' => $imported,
            'skipped'  => $skipped,
        ]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Sync failed: ' . $e->getMessage()]);
    }
}
// Blog endpoints
elseif ($path === '/admin/blogs/upload-image' && $method === 'POST') {
    require_once 'admin/upload-blog-image.php';
} elseif ($path === '/admin/blogs' && $method === 'GET') {
    require_once 'admin/blogs.php';
} elseif ($path === '/admin/blogs' && $method === 'POST') {
    require_once 'admin/create-blog.php';
} elseif (preg_match('/^\/admin\/blogs\/([^\/]+)$/', $path, $matches) && $method === 'PUT') {
    $_GET['id'] = $matches[1];
    require_once 'admin/update-blog.php';
} elseif (preg_match('/^\/admin\/blogs\/([^\/]+)$/', $path, $matches) && $method === 'DELETE') {
    $_GET['id'] = $matches[1];
    require_once 'admin/delete-blog.php';
}
// Portfolio endpoints
elseif ($path === '/portfolio' && $method === 'GET') {
    require_once 'portfolio/list.php';
}
// Services endpoints
elseif ($path === '/services' && $method === 'GET') {
    require_once 'services/list.php';
} elseif ($path === '/admin/portfolio' && $method === 'GET') {
    require_once 'admin/portfolio.php';
} elseif ($path === '/admin/portfolio' && $method === 'POST') {
    require_once 'admin/create-portfolio.php';
} elseif (preg_match('/^\/admin\/portfolio\/([^\/]+)$/', $path, $matches) && $method === 'PUT') {
    $_GET['id'] = $matches[1];
    require_once 'admin/update-portfolio.php';
} elseif (preg_match('/^\/admin\/portfolio\/([^\/]+)$/', $path, $matches) && $method === 'DELETE') {
    $_GET['id'] = $matches[1];
    require_once 'admin/delete-portfolio.php';
}
// Services endpoints
elseif ($path === '/admin/services' && $method === 'GET') {
    require_once 'admin/services-list.php';
} elseif ($path === '/admin/services' && $method === 'POST') {
    require_once 'admin/create-service.php';
} elseif (preg_match('/^\/admin\/services\/([^\/]+)$/', $path, $matches) && $method === 'PUT') {
    $_GET['id'] = $matches[1];
    require_once 'admin/update-service.php';
} elseif (preg_match('/^\/admin\/services\/([^\/]+)$/', $path, $matches) && $method === 'DELETE') {
    $_GET['id'] = $matches[1];
    require_once 'admin/delete-service.php';
}
// Settings endpoints
elseif ($path === '/admin/settings' && $method === 'GET') {
    require_once 'admin/settings-get.php';
} elseif ($path === '/admin/settings' && $method === 'PUT') {
    require_once 'admin/settings-update.php';
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Route not found']);
}
