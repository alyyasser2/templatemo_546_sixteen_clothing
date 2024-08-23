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

// Check if ID parameter is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and bind the DELETE statement
    $deleteSql = "DELETE FROM users WHERE user_id=?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Customer deleted successfully.";
    } else {
        echo "Error deleting customer: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "ID parameter not set.";
    exit;
}

// Close database connection
$conn->close();
?>
