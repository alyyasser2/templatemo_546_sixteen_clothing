<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: trail_login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'ecommercedb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: view_products.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid product ID.";
    exit;
}

$conn->close();
?>
