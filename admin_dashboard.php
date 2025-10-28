
<?php
require_once 'verify_token.php';

// Verify the token and get the user data.
$userData = verify_token();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to the Admin Dashboard</h1>
    <p>This is a protected page.</p>
    <p>Your Staff ID is: <?php echo htmlspecialchars($userData['staffid']); ?></p>
    <p>Your role is: <?php echo htmlspecialchars($userData['role']); ?></p>
</body>
</html>
