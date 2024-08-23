<?php
// Include database connection file
include_once "db.php";

// Initialize variables
$sub_admin_email = $sub_admin_password = "";
$error = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $sub_admin_email = trim($_POST['sub_admin_email']);
    $sub_admin_password = trim($_POST['sub_admin_password']);
    $sub_admin_name=trim($_POST['sub_admin_name']);
    // Check if sub admin email is not empty
    if (empty($sub_admin_email)) {
        $error = "Email is required.";
    } else {
        // Check if sub admin already exists in database
        $stmt = $conn->prepare("SELECT id FROM sub_admins WHERE email = ?");
        $stmt->bind_param("s", $sub_admin_email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = "Sub admin with this email already exists.";
        } else {
            // Insert new sub admin into database
            $hashed_password = password_hash($sub_admin_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO sub_admins (email, password, name) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $sub_admin_email, $hashed_password, $sub_admin_name);

            if ($stmt->execute()) {
                // Redirect to this page to refresh the sub admin list
                header("Location: manage_sub_admins.php");
                exit;
            } else {
                $error = "Error occurred while adding sub admin.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sub Admins</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"], input[type="password"], button[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            margin-left: 10px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Sub Admins</h2>
        <p>Here you can manage sub admins/sellers.</p>

        <!-- Add Sub Admin Form -->
        <h3>Add Sub Admin</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="sub_admin_email">Email:</label>
            <input type="email" id="sub_admin_email" name="sub_admin_email" required>
            <label for="sub_admin_email">Name:</label>
            <input type="text" id="sub_admin_name" name="sub_admin_name" required>
            <label for="sub_admin_password">Password:</label>
            <input type="password" id="sub_admin_password" name="sub_admin_password" required>
            <button type="submit">Add Sub Admin</button>
        </form>

        <!-- Display Existing Sub Admins -->
        <h3>Existing Sub Admins</h3>
        <?php
        // Retrieve existing sub admins from database
        $sql = "SELECT id, email FROM sub_admins";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "<span>Email: " . $row["email"] . "</span>";
                echo "<a href='edit_sub_admin.php?id=" . $row["id"] . "'>Edit</a>";
                echo "<a href='delete_sub_admin.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this sub admin?\")'>Delete</a>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "No sub admins found.";
        }
        ?>

        <!-- Display Error Message -->
        <?php
        if (!empty($error)) {
            echo "<p class='error-message'>$error</p>";
        }
        ?>
    </div>
</body>
</html>
