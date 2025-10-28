
<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Define the secret key.
define('JWT_SECRET_KEY', 'your-secret-key');

function verify_token() {
    if (!isset($_COOKIE['jwt'])) {
        header('Location: ../login.php');
        exit;
    }

    $jwt = $_COOKIE['jwt'];

    try {
        $decoded = JWT::decode($jwt, new Key(JWT_SECRET_KEY, 'HS256'));
        return (array) $decoded->data;
    } catch (Exception $e) {
        header('Location: ../login.php');
        exit;
    }
}
?>
