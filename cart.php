<?php
error_reporting(E_ERROR | E_PARSE); // Suppress warnings
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantities'] as $productId => $quantity) {
            if ($quantity == 0) {
                unset($_SESSION['cart'][$productId]);
            } else {
                $_SESSION['cart'][$productId]['quantity'] = $quantity;
            }
        }
    }

    if (isset($_POST['remove'])) {
        $productId = $_POST['remove'];
        unset($_SESSION['cart'][$productId]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Shopping Cart</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Your Cart</h2>
        <form method="POST" action="cart.php">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        $total = 0;
                        foreach ($_SESSION['cart'] as $productId => $product) {
                            $productName = isset($product['name']) ? $product['name'] : 'Product Name Not Found';
                            $productImage = isset($product['image']) ? $product['image'] : 'image-not-found.jpg';
                            $productPrice = isset($product['price']) ? $product['price'] : 0;
                            $productQuantity = isset($product['quantity']) ? $product['quantity'] : 0;

                            $subtotal = $productPrice * $productQuantity;
                            $total += $subtotal;

                            echo '<tr>';
                            echo '<td>' . $productName . '</td>';
                            echo '<td><img src="' . $productImage . '" width="50" height="50"></td>';
                            echo '<td>$' . $productPrice . '</td>';
                            echo '<td><input type="number" name="quantities[' . $productId . ']" value="' . $productQuantity . '" min="0"></td>';
                            echo '<td>$' . $subtotal . '</td>';
                            echo '<td><button type="submit" name="remove" value="' . $productId . '" class="btn btn-danger">Remove</button></td>';
                            echo '</tr>';
                        }
                        echo '<tr>';
                        echo '<td colspan="4" align="right"><strong>Total</strong></td>';
                        echo '<td>$' . $total . '</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    } else {
                        echo '<tr>';
                        echo '<td colspan="6" align="center">Your cart is empty</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
           

            <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
            <a href="index.php" class="btn btn-primary">Back</a>

        </form>

    </div>
    <?php
session_start();

// Check if the cart array has values
if (!empty($_SESSION['cart'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Method Selection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Select Payment Method</h3>
        <form action="checkout.php" method="POST">
            <div class="form-group">
                <label for="paymentMethod">Select Payment Method:</label>
                <select class="" id="paymentMethod" name="paymentMethod">
                    <option value="visa">Visa</option>
                    <option value="cash">Cash</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
        </form>
    </div>
</body>
</html>
<?php
}
?>

</body>
</html>
