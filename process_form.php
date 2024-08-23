<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommercedb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Execute SQL statement
    if ($stmt->execute() === TRUE) {
        echo "<div class='alert alert-success'>Your message has been sent successfully!</div>";
        // Redirect to index.php after displaying the message for a few seconds
        header("refresh:1;url=index.php"); // Redirect after 3 seconds
        exit(); // Prevent further execution
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
