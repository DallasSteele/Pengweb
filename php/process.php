<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'config.php';

    $name = $_POST['name'];
    $amount = $_POST['amount'];

    // Basic validation
    if (empty($name) || empty($amount)) {
        echo 'Please fill out all fields.';
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO transactions (name, amount) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $amount);

    // Execute the statement
    if ($stmt->execute()) {
        echo 'Transaction recorded successfully: Name = ' . htmlspecialchars($name) . ', Amount = ' . htmlspecialchars($amount);
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request method.';
}
?>
