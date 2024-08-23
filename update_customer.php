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

    // Fetch customer data from the database
    $sql = "SELECT * FROM users WHERE user_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $email = $row['email'];
        $address = $row['address'];
    } else {
        echo "Customer not found.";
        exit;
    }
} else {
    echo "ID parameter not set.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST["username"];
    $newEmail = $_POST["email"];
    $newAddress = $_POST["address"];

    // Update customer information in the database
    $updateSql = "UPDATE users SET username='$newUsername', email='$newEmail', address='$newAddress' WHERE user_id=$id";

    if ($conn->query($updateSql) === TRUE) {
        echo "Customer information updated successfully.";
    } else {
        echo "Error updating customer information: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5 mb-4">Update Customer Information</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
