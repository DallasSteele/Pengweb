<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
            <h1>My E-Commerce</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Shop</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="order_history.php">Order History</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Cart</h2>
        <div class="cart-items"></div>
        <button id="checkout-button">Checkout</button>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>
