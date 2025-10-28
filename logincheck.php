
<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;

include('dbconnect.php');

// Define a secret key for signing the JWT.
// In a real application, this should be stored securely.
define('JWT_SECRET_key', 'your-secret-key');

session_start();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($dbcon, trim($_POST['username']));
    $pwd = mysqli_real_escape_string($dbcon, trim($_POST['pwd']));

    $query = mysqli_query($dbcon, "SELECT * FROM userlogin WHERE staffid='$username'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($pwd, $user['password'])) {
        // Password is correct.
        $_SESSION['user'] = $user;

        if ($user['status'] === 'Admin') {
            // Redirect to 2FA verification page for admin users.
            header('Location: 2fa.php');
            exit;
        }

        // For non-admin users, generate a JWT and redirect.
        $payload = [
            'iat' => time(), // Issued at: time when the token was generated
            'exp' => time() + (60*60), // Expiration time (1 hour)
            'data' => [
                'staffid' => $user['staffid'],
                'role' => $user['status']
            ]
        ];

        $jwt = JWT::encode($payload, JWT_SECRET_KEY, 'HS256');

        // Set the JWT as an HttpOnly cookie.
        setcookie('jwt', $jwt, time() + (60*60), '/', '', false, true);

        // Redirect based on role.
        switch ($user['status']) {
            case 'CID':
                header("Location: cid/");
                break;
            case 'NCO':
                header("Location: officer/");
                break;
            default:
                header("Location: login.php");
                break;
        }
        exit;
    } else {
        $_SESSION['error'] = 'Your Staff ID or password is not valid';
        header('location: login.php');
        exit;
    }
} else {
    header('location: login.php');
    exit;
}
?>
