<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: trail_login.php");
    exit;
}

$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Barlow', sans-serif;
            background-color: #f8f9fa;
        }
        h2 {
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        ul li a {
            color: #fff;
            text-decoration: none;
        }
        ul li a:hover {
            color: #fff;
        }
        /* Animation */
        .moving-car {
            position: absolute;
            top: 50%;
            animation: moveCar 5s linear infinite;
        }
        @keyframes moveCar {
            0% { left: -100px; }
            100% { left: calc(100% + 100px); }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-5 mb-4">Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h2>
        <!-- Moving Car -->
        <div class="moving-car">
            <i class="fas fa-car fa-3x"></i>
        </div>
        <ul>
            <!-- View Products Button -->
            <li><a href="view_products.php" class="btn btn-primary"><i class="fas fa-eye"></i> View Products</a></li>
            <!-- Add Product Button -->
            <li><a href="add_product.php" class="btn btn-success"><i class="fas fa-plus"></i> Add Product</a></li>
            <!-- Customer Purchases Button -->
            <li><a href="customer_purchases.php" class="btn btn-info"><i class="fas fa-shopping-cart"></i> Customer Purchases</a></li>
            <!-- Logout Button -->
            <li><a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
