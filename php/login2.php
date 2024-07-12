<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($username) || empty($password)) {
        echo 'Please fill out all fields.';
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = MD5(?)");
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: ../index.php");
    } else {
        echo 'Invalid username or password.';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request method.';
}
?>
