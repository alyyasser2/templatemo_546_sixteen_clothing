<?php
// Start session
session_start();

include('db.php');

// Function to handle form submission
function handleFormSubmission($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Retrieve user from database using a prepared statement
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, verify password
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                // Set session variables
                $_SESSION['user'] = $email;
                $_SESSION['user_id'] = $row["user_id"]; // Assuming 'id' is the column name for user ID in your database
                // Redirect to home page
                header("Location: products.php");
                exit();
            } else {
                echo "Invalid password";
            }
        } else {
            echo "<p>User not found</p>";
        }

        // Close prepared statement
        $stmt->close();
    }
}

// Call the function to handle form submission
handleFormSubmission($conn);
// Check if the admin is already logged in, redirect to dashboard if true
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate credentials (replace with your validation logic)
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Example validation: Check if email and password match
    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        // Set admin session
        $_SESSION['admin'] = true;

        // Redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <title>Luxe Allure Products</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="assets/css/owl.css">
</head>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

</body>
</html>

    
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
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item active">
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
    
<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="text-primary text-uppercase">Are You Ready To </h6>
            <h1 class="mb-5">Login</h1>
        </div>
        <div class="row g-4">
</div>
    </div>
</div>
<!-- <div class="container">
        <h2></h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <p>If you don't have an account, <a href="trail_register.php">click here</a> to register.</p>
    </div> -->
    <div class="login-form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <p class="text-center mt-3">If you don't have an account, <a href="trail_register.php">click here</a> to register.</p>
    </div>
</div>
<!-- Team End -->


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <p>Copyright &copy; 2018 Luxe Allure Co.                    </div>
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

    
</body>
</html>