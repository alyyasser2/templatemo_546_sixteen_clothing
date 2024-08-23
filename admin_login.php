<?php
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
