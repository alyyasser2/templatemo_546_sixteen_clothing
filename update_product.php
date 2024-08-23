<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: trail_login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'ecommercedb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Invalid product ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $brand_type = $_POST['brand_type'];
    $section = $_POST['section'];
    $stock = $_POST['stock'];
    $image_url = $product['image_url']; // Use the existing image URL by default

    // Handle image upload if a new image is provided
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $sql = "UPDATE products SET name = ?, description = ?, price = ?, brand_type = ?, section = ?, stock = ?, image_url = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssisi", $name, $description, $price, $brand_type, $section, $stock, $image_url, $product_id);

    if ($stmt->execute()) {
        header("Location: view_products.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Edit Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required><?php echo $product['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
        </div>
        <div class="form-group">
            <label for="brand_type">Brand Type</label>
            <select class="form-control" id="brand_type" name="brand_type" required>
                <option value="International" <?php if ($product['brand_type'] == 'International') echo 'selected'; ?>>International</option>
                <option value="Local" <?php if ($product['brand_type'] == 'Local') echo 'selected'; ?>>Local</option>
            </select>
        </div>
        <div class="form-group">
            <label for="section">Section</label>
            <input type="text" class="form-control" id="section" name="section" value="<?php echo $product['section']; ?>" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $product['stock']; ?>" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <img src="<?php echo $product['image_url']; ?>" alt="Current Image" class="img-thumbnail mt-2" style="max-width: 150px;">
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>
