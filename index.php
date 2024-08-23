<?php
session_start();
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">

    <title>Luxe Allure</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <h2>Luxe <em>Allure</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php">Our Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact Us</a>
                        </li>
                        <?php
                            if (isset($_SESSION['user'])) {
                                echo '<li class="nav-item"><a class="nav-link" href="your_orders.php"><i class="fas fa-shopping-cart"></i> Your Orders</a></li>';
                            }
                            ?>
                        <?php
    if (isset($_SESSION['user'])) {
        // User is logged in, show the regular "Cart" link
        echo '<li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>';
    }
?>
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

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner header-text">
        <div class="owl-banner owl-carousel">
            <div class="banner-item-01">
                <div class="text-content">
                    <h4>Best Offer</h4>
                    <h2>New Arrivals On Sale</h2>
                </div>
            </div>
            <div class="banner-item-02">
                <div class="text-content">
                    <h4>Flash Deals</h4>
                    <h2>Get your best products</h2>
                </div>
            </div>
            <div class="banner-item-03">
                <div class="text-content">
                    <h4>Last Minute</h4>
                    <h2>Grab last minute deals</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Ends Here -->

    <div class="latest-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Latest Products</h2>
                        <a href="products.php">view all products <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
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

    <div class="best-features">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>About Luxe Allure</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="left-content">
                        <h4>Looking for the best products?</h4>
                        <p>Experience the elegance and allure that comes from the perfect blend of fashion and fragrance. At Luxe Allure, we believe that love is in the details—from the cut of a garment to the subtlety of a scent. Embrace your unique style and let your individuality shine through every piece you wear.</p>
                        <ul class="featured-list">
                            <li><a href="#">Latest Fashion Trends</a></li>
                            <li><a href="#">High-Quality Materials</a></li>
                            <li><a href="#">Affordable Prices</a></li>
                            <li><a href="#">Excellent Customer Service</a></li>
                            <li><a href="#">Fast Shipping</a></li>
                        </ul>
                        <a href="about.php" class="filled-button">Read More</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-image">
                        <img src="assets/images/feature-image.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Creative &amp; Unique <em>Luxe Allure</em> Products</h4>
                                <p>Discover the perfect fusion of creativity and elegance with Luxe Allure. Our products are crafted with passion, designed to celebrate your individuality. From bespoke fashion pieces to exclusive fragrances, every item tells a story of love, care, and artistry. Embrace the extraordinary with Luxe Allure, where every creation is as unique as you are.</p>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="filled-button">Purchase Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <p>Copyright &copy; 2018 Luxe Allure Co.
                            
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/accordions.js"></script>

    <script>
        function addToCart(productId) {
            // You can add the AJAX code here to add the product to the cart
        }
    </script>

</body>

</html>
