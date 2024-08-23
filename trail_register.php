<?php
// Database connection parameters
include('db.php');

// Function to handle form submission
function handleFormSubmission($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $address = $_POST["address"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $city = $_POST["city"];
        $state = $_POST["state"];
        $postal_code = $_POST["postal_code"];
        $country = $_POST["country"];

        // Check if passwords match (server-side validation)
        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match. Please try again.');</script>";
            echo "<script>window.location = 'register.php';</script>";
            exit(); // Stop further execution
        }

        // Check if email already exists in the database
        $check_sql = "SELECT * FROM users WHERE email=?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "<script>alert('Email is already registered. Please use a different email address.');</script>";
            echo "<script>window.location = 'register.php';</script>";
            exit(); // Stop further execution
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $sql = "INSERT INTO users (address, username, email, phone, password, city, state, postal_code, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $address, $username, $email, $phone, $hashed_password, $city, $state, $postal_code, $country);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!');</script>";
            echo "<script>window.location = 'trail_login.php';</script>";
            exit(); // Stop further execution
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close prepared statements
        $stmt->close();
        $check_stmt->close();
    }
}

// Call the function to handle form submission
handleFormSubmission($conn);

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
    <title>Sixteen Clothing Products</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <style>
        #message {
            font-weight: bold;
            margin-top: 5px;
            display: block;
        }
    </style>
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
    <!-- Registration Form Start -->
    <div class="container">
        <div class="register-form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="register-form">
                <div class="form-group">
                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                </div>
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
                    <span id="message"></span>
                </div>
                <div class="form-group">
                    <input type="text" name="city" class="form-control" placeholder="City" required>
                </div>
                <div class="form-group">
                    <input type="text" name="state" class="form-control" placeholder="State" required>
                </div>
                <div class="form-group">
                    <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" required>
                </div>
                <div class="form-group">
                    <input type="text" name="country" class="form-control" placeholder="Country" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            <p class="text-center mt-3">If you have an account, <a href="trail_login.php">click here</a> to login.</p>
        </div>
    </div>
    <!-- Registration Form End -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <p>Copyright &copy; 2018 Luxe Allure. All rights reserved.</p>
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

    <!-- Live Password Confirmation Script -->
    <script>
        document.getElementById('confirm_password').onkeyup = function () {
            var password = document.getElementById('password').value;
            var confirm_password = document.getElementById('confirm_password').value;
            var message = document.getElementById('message');

            if (password === confirm_password) {
                message.style.color = 'green';
                message.textContent = 'Passwords match';
            } else {
                message.style.color = 'red';
                message.textContent = 'Passwords do not match';
            }
        };
    </script>
</body>
</html>
