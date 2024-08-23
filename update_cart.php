<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE Cart SET quantity = ? WHERE cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $cart_id);

    if ($stmt->execute()) {
        header("Location: cart.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
