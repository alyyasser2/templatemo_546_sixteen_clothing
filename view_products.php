<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: trail_login.php");
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ecommercedb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Barlow', sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            background-color: #fff;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        td {
            word-wrap: break-word;
        }
        .action-links a {
            margin-right: 5px;
            color: #007bff;
            text-decoration: none;
        }
        .action-links a:hover {
            color: #0056b3;
        }
        .product-image {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Products</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Description</th>
                        <th>Brand_type</th>
                        <th>Section</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["product_id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td><img src='" . $row["image_url"] . "' alt='Product Image' class='product-image'></td>";
                            echo "<td>" . $row["description"] . "</td>";
                            echo "<td>" . $row["brand_type"] . "</td>";
                            echo "<td>" . $row["section"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td>" . $row["stock"] . "</td>";
                            echo "<td class='action-links'><a href='update_product.php?id=" . $row["product_id"] . "'>Edit</a> | <a href='delete_product.php?id=" . $row["product_id"] . "'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No products found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
