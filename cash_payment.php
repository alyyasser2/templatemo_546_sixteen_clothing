<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['paymentMethod'])) {
        $paymentMethod = $_POST['paymentMethod'];
        if ($paymentMethod === 'visa') {
            // Redirect to Visa checkout page
            header('Location: visa_checkout.php');
            exit();
        } elseif ($paymentMethod === 'cash') {
            // Proceed with cash payment
            handleCashPayment();
        }
    }
}

function handleCashPayment() {
    // Place your database connection details here
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "database";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Create a new order in the orders table
        $insertOrderQuery = "INSERT INTO orders (user_id, order_date, status) VALUES (?, NOW(), 'pending')";
        $stmtOrder = $conn->prepare($insertOrderQuery);
        $stmtOrder->bind_param("i", $userId);

        if ($stmtOrder->execute()) {
            $orderId = $stmtOrder->insert_id; // Get the ID of the newly inserted order

            // Insert order items into the orderitems table
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $productId => $product) {
                    $productQuantity = $product['quantity'];
                    $productPrice = $product['price'];

                    $insertOrderItemQuery = "INSERT INTO orderitems (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                    $stmtOrderItem = $conn->prepare($insertOrderItemQuery);
                    $stmtOrderItem->bind_param("iiid", $orderId, $productId, $productQuantity, $productPrice);

                    if (!$stmtOrderItem->execute()) {
                        echo "Error: " . $conn->error;
                        exit();
                    }
                }

                // Clear the cart after the order is placed
                unset($_SESSION['cart']);

                // Redirect to a thank you page or any other page as needed
                header('Location: thank_you.php');
                exit();
            } else {
                echo "Error: Cart is empty.";
                exit();
            }
        } else {
            echo "Error: " . $conn->error;
            exit();
        }

        $stmtOrder->close();
    } else {
        echo "Error: User not logged in.";
        exit();
    }

    $conn->close();
}
?>
