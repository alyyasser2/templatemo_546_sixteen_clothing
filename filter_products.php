<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brandType = $_POST['brand_type'];
    $sql = "SELECT * FROM Products";
    if ($brandType != '*') {
        $sql .= " WHERE brand_type = '" . $brandType . "'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-lg-4 col-md-4 all des">';
            echo '    <div class="product-item">';
            echo '        <a href="#"><img src="' . $row["image_url"] . '" alt="' . $row["name"] . '"></a>';
            echo '        <div class="down-content">';
            echo '            <a href="#"><h4>' . $row["name"] . '</h4></a>';
            echo '            <h6>$' . $row["price"] . '</h6>';
            echo '            <p>' . $row["description"] . '</p>';
            echo '            <div class="form-group">';
            echo '                <label for="size-select-' . $row["product_id"] . '">Select Size:</label>';
            echo '                <select class="form-control size-select" id="size-select-' . $row["product_id"] . '">';
            $size_sql = "SELECT size FROM product_sizes WHERE product_id = " . $row["product_id"];
            $size_result = $conn->query($size_sql);
            if ($size_result->num_rows > 0) {
                while ($size_row = $size_result->fetch_assoc()) {
                    echo '                    <option value="' . $size_row["size"] . '">' . $size_row["size"] . '</option>';
                }
            }
            echo '                </select>';
            echo '            </div>';
            echo '            <ul class="stars">';
            echo '                <li><i class="fa fa-star"></i></li>';
            echo '                <li><i class="fa fa-star"></i></li>';
            echo '                <li><i class="fa fa-star"></i></li>';
            echo '                <li><i class="fa fa-star"></i></li>';
            echo '                <li><i class="fa fa-star"></i></li>';
            echo '            </ul>';
            echo '            <span class="badge badge-warning">' . $row["brand_type"] . '</span>';
            echo '            <div class="mt-2">';
            echo "<button class='btn btn-primary' onclick='addToCart(" . $row["product_id"] . ", \"" . $row["name"] . "\", \"" . $row["image_url"] . "\", " . $row["price"] . ")'>Add to Cart</button>";
            echo '            </div>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        echo 'No products found.';
    }
}
?>
