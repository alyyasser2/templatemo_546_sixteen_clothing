<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Luxe Allure Products</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <style>
        /* Chatbot CSS */
        .chat-bot-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            border-radius: 50%;
            padding: 15px;
            color: #fff;
            cursor: pointer;
            z-index: 1000;
        }
        .chat-box {
            display: none;
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 300px;
            max-width: 100%;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .chat-box-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .chat-box-body {
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
        }
        .chat-box-input {
            display: flex;
            border-top: 1px solid #ccc;
        }
        .chat-box-input input {
            width: 100%;
            padding: 10px;
            border: none;
            outline: none;
        }
        .chat-box-input button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .chat-box-input button:hover {
            background-color: #0056b3;
        }
        .chat-message {
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
        }
        .chat-message.user {
            align-items: flex-end;
        }
        .chat-message.bot {
            align-items: flex-start;
        }
        .chat-message .message-content {
            max-width: 80%;
            padding: 10px;
            border-radius: 5px;
        }
        .chat-message.user .message-content {
            background-color: #007bff;
            color: #fff;
        }
        .chat-message.bot .message-content {
            background-color: #f1f1f1;
            color: #333;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <h2>Luxe <em>Allure</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Our Products
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="products.php">All Products</a>
                                <a class="dropdown-item" href="#" onclick="filterProducts('International')">International Brands</a>
                                <a class="dropdown-item" href="#" onclick="filterProducts('Local')">Local Brands</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact Us</a>
                            <?php
                            if (isset($_SESSION['user'])) {
                                echo '<li class="nav-item"><a class="nav-link" href="your_orders.php"><i class="fas fa-shopping-cart"></i> Your Orders</a></li>';
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['user'])) {
                                echo '<li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>';
                            }
                            ?>
                        </li>
                        <?php
                        if (isset($_SESSION['user'])) {
                            echo '<a href="logout.php" class="nav-item nav-link">Logout</a>';
                        } else {
                            echo '<a href="trail_login.php" class="nav-item nav-link">Login</a>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-heading products-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>new arrivals</h4>
                        <h2>Luxe Allure</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="filters">
                        <ul>
                            <li><a href="#" class="active" onclick="filterProducts('*')">All Products</a></li>
                            <li><a href="#" onclick="filterProducts('International')">International Brands</a></li>
                            <li><a href="#" onclick="filterProducts('Local')">Local Brands</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="filters-content">
                        <div class="row grid">
                            <?php
                            $sql = "SELECT * FROM Products";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="col-lg-4 col-md-4 all des">';
                                    echo '    <div class="product-item">';
                                    echo '        <a href="#"><img src="' . $row["image_url"] . '" alt="' . $row["name"] . '"></a>';
                                    echo '        <div class="down-content">';
                                    echo '            <a href="#"><h4>' . $row["name"] . '</h4></a>';
                                    echo '            <h6>$' . $row["price"] . '</h6>';
                                    echo '            <p>' . $row["description"] . '</p>';
                                    echo '            <div class="form-group">';
                                    echo '                <label for="size-select-' . $row["product_id"] . '">Select Size:</label>';
                                    echo '                <select class="form-control size-select" id="size-select-' . $row["product_id"] . '">';
                                    $size_sql = "SELECT size FROM product_sizes WHERE product_id = " . $row["product_id"];
                                    $size_result = $conn->query($size_sql);
                                    if ($size_result->num_rows > 0) {
                                        while ($size_row = $size_result->fetch_assoc()) {
                                            echo '                    <option value="' . $size_row["size"] . '">' . $size_row["size"] . '</option>';
                                        }
                                    }
                                    echo '                </select>';
                                    echo '            </div>';
                                    echo '            <ul class="stars">';
                                    echo '                <li><i class="fa fa-star"></i></li>';
                                    echo '                <li><i class="fa fa-star"></i></li>';
                                    echo '                <li><i class="fa fa-star"></i></li>';
                                    echo '                <li><i class="fa fa-star"></i></li>';
                                    echo '                <li><i class="fa fa-star"></i></li>';
                                    echo '            </ul>';
                                    echo '            <span class="badge badge-warning">' . $row["brand_type"] . '</span>';
                                    echo '            <div class="mt-2">';
                                    if (isset($_SESSION['user'])) {
                                        echo "<button class='btn btn-primary' onclick='addToCart(" . $row["product_id"] . ", \"" . $row["name"] . "\", \"" . $row["image_url"] . "\", " . $row["price"] . ")'>Add to Cart</button>";
                                    } else {
                                        echo "<button class='btn btn-primary' onclick='alert(\"You must be logged in to add products to your cart.\")'>Add to Cart</button>";
                                    }
                                    echo '            </div>';
                                    echo '        </div>';
                                    echo '    </div>';
                                    echo '</div>';
                                }
                            } else {
                                echo 'No products found.';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/accordions.js"></script>

    <script>
        function addToCart(productId, productName, productImage, productPrice) {
            var sizeSelect = document.getElementById('size-select-' + productId);
            var size = sizeSelect.value;
            if (!size) {
                alert('Please select a size.');
                return;
            }
            $.ajax({
                url: 'add_to_cart.php',
                method: 'POST',
                data: {
                    product_id: productId,
                    product_name: productName,
                    product_image: productImage,
                    product_price: productPrice,
                    quantity: 1 // Default quantity to 1
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        alert('Product added to cart successfully!');
                    } else {
                        alert('Failed to add product to cart. Please try again.');
                    }
                }
            });
        }

        function filterProducts(brandType) {
            $.ajax({
                url: 'filter_products.php',
                method: 'POST',
                data: {
                    brand_type: brandType
                },
                success: function(response) {
                    $('.grid').html(response);
                }
            });
        }

      
</body>
</html>
