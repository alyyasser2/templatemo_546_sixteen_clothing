<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: trail_login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'ecommercedb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update order status if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        $success_message = "Order status updated successfully.";
    } else {
        $error_message = "Error updating order status: " . $conn->error;
    }
}

// Fetch orders from database
$sql = "SELECT orders.order_id, orders.user_id, orders.order_date, orders.status, users.username FROM orders JOIN users ON orders.user_id = users.user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Barlow', sans-serif;
            background-color: #f8f9fa;
        }
        h2 {
            color: #333;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5 mb-4">Customer Orders</h2>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["order_id"] . "</td>";
                            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                            echo "<td>" . $row["order_date"] . "</td>";
                            echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                            echo "<td>";
                            echo "<form action='' method='POST' class='form-inline'>";
                            echo "<input type='hidden' name='order_id' value='" . $row["order_id"] . "'>";
                            echo "<select name='status' class='form-control mr-2'>";
                            echo "<option value='pending'" . ($row["status"] == "pending" ? " selected" : "") . ">Pending</option>";
                            echo "<option value='accepted'" . ($row["status"] == "accepted" ? " selected" : "") . ">Accepted</option>";
                            echo "<option value='shipped'" . ($row["status"] == "shipped" ? " selected" : "") . ">Shipped</option>";
                            echo "<option value='delivered'" . ($row["status"] == "delivered" ? " selected" : "") . ">Delivered</option>";
                            echo "<option value='cancelled'" . ($row["status"] == "cancelled" ? " selected" : "") . ">Cancelled</option>";
                            echo "</select>";
                            echo "<button type='submit' class='btn btn-primary'>Update</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
