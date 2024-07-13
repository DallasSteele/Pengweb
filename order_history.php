<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'php/config.php';

$sql = "SELECT orders.id, orders.quantity, orders.order_date, products.name, products.price
        FROM orders
        JOIN products ON orders.product_id = products.id
        WHERE orders.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['admin_id']);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
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
        <h2>Order History</h2>
        <?php if (!empty($orders)) { ?>
    <ul class="order-list">
        <?php foreach ($orders as $order) { ?>
            <li>
                <p><strong>Product:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
                <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
                <p><strong>Price:</strong> $<?php echo $order['price']; ?></p>
                <p><strong>Date:</strong> <?php echo $order['order_date']; ?></p>
            </li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>No orders found.</p>
<?php } ?>
    </div>
</body>
</html>
