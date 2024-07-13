<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'php/config.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
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
        <h2>Shop</h2>
        <div class="product-list">
            <?php foreach ($products as $product) { ?>
            <div class="product-item">
                <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <p class="price">$<?php echo $product['price']; ?></p>
                <a href="product_detail.php?id=<?php echo $product['id']; ?>">View Details</a>
                <button class="add-to-cart" data-product-id="<?php echo $product['id']; ?>">Add to Cart</button>
            </div>
            <?php } ?>
        </div>
    </div>
    <script>
        const products = <?php echo json_encode($products); ?>;
    </script>
    <script src="js/scripts.js"></script>
</body>
</html>
