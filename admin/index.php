
<?php
require_once '../verify_token.php';

// Verify the token and get the user data.
$userData = verify_token();

// Check if the user has the 'Admin' role.
if ($userData['role'] !== 'Admin') {
    // If not, redirect to the login page.
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to the Admin Dashboard</h1>
    <p>This is a protected page for Admins only.</p>
    <p>Your Staff ID is: <?php echo htmlspecialchars($userData['staffid']); ?></p>
    <p>Your role is: <?php echo htmlspecialchars($userData['role']); ?></p>
</body>
</html>
