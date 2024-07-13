<?php
include 'php/config.php';

// Sample user data
$username = 'admin';
$password = password_hash('adminpass', PASSWORD_BCRYPT);

$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

echo "Sample user inserted successfully.";

$stmt->close();
$conn->close();
?>
