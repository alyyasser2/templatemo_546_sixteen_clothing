<?php
session_start();
// Check if the user is logged in

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productImage = $_POST['product_image'];
    $productPrice = $_POST['product_price'];
    $productQuantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $productQuantity;
    } else {
        $_SESSION['cart'][$productId] = array(
            'name' => $productName,
            'image' => $productImage,
            'price' => $productPrice,
            'quantity' => $productQuantity
        );
    }

    echo json_encode(['status' => 'success']);
}

?>
