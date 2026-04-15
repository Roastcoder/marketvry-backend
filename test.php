<?php
require_once 'public/api/helpers.php';
$token = createToken(1, 'admin@marketvry.com', 'admin');
echo "Token: $token\n";
var_dump(verifyToken($token));
