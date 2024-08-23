<?php
// Include database connection file
include_once "db.php";

// Initialize variables
$sub_admin_email = $sub_admin_password = "";
$error = "";

// Check if ID parameter is provided in URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $sub_admin_id = $_GET['id'];

    // Retrieve sub-admin details from the database
    $stmt = $conn->prepare("SELECT email FROM sub_admins WHERE id = ?");
    $stmt->bind_param("i", $sub_admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sub_admin_email = $row['email'];
    } else {
        // Sub-admin not found, redirect to manage_sub_admins.php
        header("Location: manage_sub_admins.php");
        exit;
    }

    // Close statement
    $stmt->close();
} else {
    // ID parameter is not provided, redirect to manage_sub_admins.php
    header("Location: manage_sub_admins.php");
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $sub_admin_email = trim($_POST['sub_admin_email']);

    // Update sub-admin email in the database
    $stmt = $conn->prepare("UPDATE sub_admins SET email = ? WHERE id = ?");
    $stmt->bind_param("si", $sub_admin_email, $sub_admin_id);
    
    if ($stmt->execute()) {
        // Redirect to manage_sub_admins.php after successful update
        header("Location: manage_sub_admins.php");
        exit;
    } else {
        $error = "Error occurred while updating sub admin.";
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sub Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Edit Sub Admin</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $sub_admin_id; ?>" method="post">
            <div class="form-group">
                <label for="sub_admin_email">Email:</label>
                <input type="email" class="form-control" id="sub_admin_email" name="sub_admin_email" value="<?php echo $sub_admin_email; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Sub Admin</button>
            <a href="manage_sub_admins.php" class="btn btn-secondary">Cancel</a>
        </form>

        <!-- Display Error Message -->
        <?php
        if (!empty($error)) {
            echo "<p class='error-message'>$error</p>";
        }
        ?>
    </div>
</body>
</html>
