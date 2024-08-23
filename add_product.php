<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: trail_login.php");
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ecommercedb');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $photo = $_FILES['photo']['name'];
    $photo_temp = $_FILES['photo']['tmp_name'];
    $brand = $_POST['brand_type'];
    $section = $_POST['section'];
    $price = $_POST['price'];
    $stock = $_POST['quantity'];

    // // Ensure the uploads directory exists
    // $target_dir = "uploads/";
    // if (!is_dir($target_dir)) {
    //     mkdir($target_dir, 0777, true);
    // }

    // Move uploaded file to the desired directory
    $target_file = $target_dir . basename($photo);
    if (move_uploaded_file($photo_temp, $target_file)) {
        // Insert product into database
        $sql = "INSERT INTO products (name, description, price, brand_type, section, stock, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdssis", $name, $description, $price, $brand, $section, $stock, $photo);

        if ($stmt->execute()) {
            echo "<p class='success-message'>Product added successfully by admin.</p>";
        } else {
            echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='error-message'>Error: Failed to upload image.</p>";
    }
}

// Handle adding sizes to a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_size'])) {
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];

    // Insert size into database
    $sql = "INSERT INTO product_sizes (product_id, size) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $product_id, $size);

    if ($stmt->execute()) {
        echo "<p class='success-message'>Size added successfully to product.</p>";
    } else {
        echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch all products
$products_result = $conn->query("SELECT product_id, name FROM products");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Add Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="add_product" value="1">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="photo">Photo:</label>
                <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" required onchange="validatePhoto(this)">
                <div id="photo_error" style="color: red;"></div>
            </div>
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" class="form-control" id="brand" name="brand_type" required>
            </div>
            <div class="form-group">
                <label for="section">Section:</label>
                <input type="text" class="form-control" id="section" name="section" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>

        <h2 class="mt-5">Add Sizes to Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="add_size" value="1">
            <div class="form-group">
                <label for="product_id">Product:</label>
                <select class="form-control" id="product_id" name="product_id" required>
                    <?php
                    if ($products_result->num_rows > 0) {
                        while($row = $products_result->fetch_assoc()) {
                            echo "<option value='" . $row['product_id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="size">Size:</label>
                <input type="text" class="form-control" id="size" name="size" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Size</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validatePhoto(input) {
            var photo = input.files[0];
            var photoType = photo.type.split('/')[0];
            
            if (photoType !== 'image') {
                document.getElementById("photo_error").innerHTML = "Please select an image file.";
                input.value = ''; // Clear the file input
            } else {
                document.getElementById("photo_error").innerHTML = "";
            }
        }
    </script>
</body>
</html>
