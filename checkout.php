<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

include 'php/config.php';

$data = json_decode(file_get_contents('php://input'), true);

$admin_id = $_SESSION['admin_id'];
$cart = $data['cart'];

$conn->begin_transaction();

try {
    foreach ($cart as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];

        $sql = "INSERT INTO orders (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $admin_id, $product_id, $quantity);
        $stmt->execute();
    }

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>
