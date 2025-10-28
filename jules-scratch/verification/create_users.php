
<?php
include('dbconnect.php');

// Add the google2fa_secret column to the userlogin table.
mysqli_query($dbcon, "ALTER TABLE userlogin ADD COLUMN google2fa_secret VARCHAR(255) DEFAULT NULL");

// Create a non-admin user.
$username = 'NCO001';
$password = 'password';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$role = 'NCO';

mysqli_query($dbcon, "INSERT INTO userlogin (staffid, password, status) VALUES ('$username', '$hashedPassword', '$role')");

// Create an admin user.
$username = 'admin';
$password = 'password';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$role = 'Admin';

mysqli_query($dbcon, "INSERT INTO userlogin (staffid, password, status) VALUES ('$username', '$hashedPassword', '$role')");

echo "Users created successfully.";
?>
