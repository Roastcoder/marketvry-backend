<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    die();
}

require_once __DIR__ . '/../../config/database.php';

$_ENV = parse_ini_file(__DIR__ . '/../../.env');

$db = new Database();
$conn = $db->connect();

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/api/index.php', '', $path);
$path = str_replace('/api', '', $path);

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
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Route not found']);
}
