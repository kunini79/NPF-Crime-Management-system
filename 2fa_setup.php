
<?php
require_once 'vendor/autoload.php';
use PragmaRX\Google2FA\Google2FA;

// In a real application, you would get the user's ID from the session.
// For this example, we'll use a hardcoded user ID.
$userId = 'admin';

// Generate a new secret key.
$google2fa = new Google2FA();
$secretKey = $google2fa->generateSecretKey();

// In a real application, you would save the secret key to the database.
// For this example, we'll just display it.
echo "Secret Key: " . $secretKey . "<br>";

// Generate the QR code URL.
$qrCodeUrl = $google2fa->getQRCodeUrl(
    'My Awesome App',
    $userId,
    $secretKey
);

// Display the QR code.
echo '<img src="' . $qrCodeUrl . '" alt="QR Code">';
?>
