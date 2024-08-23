<?php
session_start(); // Start the session to access cart items

// Function to remove product from cart
function removeFromCart($productId) {
    if(isset($_SESSION['cart'][$productId])) {
        // Remove the product from the cart
        unset($_SESSION['cart'][$productId]);
    }
}

// Check if the request is POST and has required parameters
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
    // Get product ID from POST request
    $productId = $_POST['productId'];

    // Call removeFromCart function to remove product from cart
    removeFromCart($productId);
}
?>
