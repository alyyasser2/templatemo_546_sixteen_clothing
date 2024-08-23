<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "ecommercedb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch customer purchases from the database
$sql = "SELECT 
            up.purchase_id,
            up.user_id,
            up.purchase_date,
            up.total_price,
            p.name AS product_name, 
            p.price AS product_price, 
            p.parent_category AS product_category,
            u.username AS customer_name,
            u.address AS customer_address,
            upd.quantity
        FROM 
            user_purchases up
        LEFT JOIN 
            users u ON up.user_id = u.id
        LEFT JOIN
            user_purchase_details upd ON up.purchase_id = upd.purchase_id
        LEFT JOIN 
            products p ON upd.product_id = p.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Purchases</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5 mb-4">Customer Purchases</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Purchase ID</th>
                        <th>Customer Name</th>
                        <th>Customer Address</th>
                        <th>Product Name</th>
                        <th>Product Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Date of Purchase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["purchase_id"] . "</td>";
                            echo "<td>" . $row["customer_name"] . "</td>";
                            echo "<td>" . $row["customer_address"] . "</td>";
                            echo "<td>" . ($row["product_name"] ?? "N/A") . "</td>";
                            echo "<td>" . ($row["product_category"] ?? "N/A") . "</td>";
                            echo "<td>$" . ($row["product_price"] ?? "N/A") . "</td>";
                            echo "<td>" . ($row["quantity"] ?? "N/A") . "</td>";
                            echo "<td>$" . ($row["total_price"] ?? "N/A") . "</td>";
                            echo "<td>" . $row["purchase_date"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No purchases found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
