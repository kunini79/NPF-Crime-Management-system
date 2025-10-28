
<?php
require_once 'vendor/autoload.php';
use PragmaRX\Google2FA\Google2FA;
use Firebase\JWT\JWT;

define('JWT_SECRET_KEY', 'your-secret-key');
session_start();

// In a real application, you would get the user's secret key from the database.
// For this example, we'll use a hardcoded secret key.
$secretKey = 'YOUR_SECRET_KEY';

if (isset($_POST['verify'])) {
    $google2fa = new Google2FA();
    $otp = $_POST['otp'];
    $user = $_SESSION['user'];

    if ($google2fa->verifyKey($secretKey, $otp)) {
        // OTP is correct. Log the user in.
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
        unset($_SESSION['user']);
        header('Location: admin/');
        exit;
    } else {
        $_SESSION['error'] = 'Invalid OTP';
        header('Location: 2fa.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify 2FA</title>
</head>
<body>
    <h1>Verify 2FA</h1>
    <form action="2fa.php" method="post">
        <label for="otp">Enter your OTP:</label>
        <input type="text" name="otp" id="otp" required>
        <button type="submit" name="verify">Verify</button>
    </form>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>
</body>
</html>
