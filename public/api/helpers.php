<?php
function getAuthToken() {
    $auth = '';
    
    // 1. Try getallheaders() case-insensitively
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'authorization') {
                $auth = $value;
                break;
            }
        }
    }
    
    // 2. Try $_SERVER variables
    if (empty($auth) && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $auth = $_SERVER['HTTP_AUTHORIZATION'];
    } else if (empty($auth) && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
        $auth = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
    }

    if (!empty($auth) && stripos($auth, 'Bearer ') === 0) {
        return substr($auth, 7);
    }
    return null;
}

function verifyToken($token) {
    $secret = $_ENV['JWT_SECRET'] ?? 'your-secret-key';
    try {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;
        
        $payload = json_decode(base64_decode($parts[1]), true);
        if (!$payload || $payload['exp'] < time()) return null;
        
        return $payload;
    } catch (Exception $e) {
        return null;
    }
}

function createToken($userId, $email, $role) {
    $secret = $_ENV['JWT_SECRET'] ?? 'your-secret-key';
    $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    $payload = base64_encode(json_encode([
        'id' => $userId,
        'email' => $email,
        'role' => $role,
        'exp' => time() + (7 * 24 * 60 * 60)
    ]));
    $signature = base64_encode(hash_hmac('sha256', "$header.$payload", $secret, true));
    return "$header.$payload.$signature";
}

function requireAuth() {
    $token = getAuthToken();
    if (!$token) {
        error_log("Auth Failed: No token found. Headers: " . print_r(getallheaders(), true) . " SERVER: " . print_r($_SERVER, true));
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        exit();
    }
    
    $user = verifyToken($token);
    if (!$user) {
        error_log("Auth Failed: Invalid token -> $token");
        http_response_code(401);
        echo json_encode(['message' => 'Invalid token']);
        exit();
    }
    
    return $user;
}

function requireAdmin() {
    $user = requireAuth();
    if ($user['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(['message' => 'Admin access required']);
        exit();
    }
    return $user;
}

function authenticateAdmin($conn) {
    return requireAdmin();
}
