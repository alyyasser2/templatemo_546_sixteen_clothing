<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart_id = $_POST['cart_id'];

    $sql = "DELETE FROM Cart WHERE cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_id);

    if ($stmt->execute()) {
        header("Location: cart.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
