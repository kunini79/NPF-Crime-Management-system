
<?php
require_once '../verify_token.php';

// Verify the token and get the user data.
$userData = verify_token();

// Check if the user has the 'NCO' role.
if ($userData['role'] !== 'NCO') {
    // If not, redirect to the login page.
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Officer Dashboard</title>
</head>
<body>
    <h1>Welcome to the Officer Dashboard</h1>
    <p>This is a protected page for Officers only.</p>
    <p>Your Staff ID is: <?php echo htmlspecialchars($userData['staffid']); ?></p>
    <p>Your role is: <?php echo htmlspecialchars($userData['role']); ?></p>
</body>
</html>
