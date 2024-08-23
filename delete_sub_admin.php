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

    // Delete customer from the database
    $deleteSql = "DELETE FROM sub_admins WHERE id=$id";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Sub-Admin deleted successfully.";
    } else {
        echo "Error deleting Sub_Admin: " . $conn->error;
    }
} else {
    echo "ID parameter not set.";
    exit;
}

// Close database connection
$conn->close();
?>
