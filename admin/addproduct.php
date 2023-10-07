<?php
include('../include/connection.php');
session_start();

if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $product_desc = mysqli_real_escape_string($conn, $_POST["product_desc"]);
    $product_price = number_format((float)$_POST["product_price"], 2, '.', ''); // Format to 2 decimal places

    $cleaned_product_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $product_name);

    $upload_dir = "../images/products/$cleaned_product_name/";

    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            die("Failed to create directory: $upload_dir");
        }
    }

    if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] === UPLOAD_ERR_OK) {
        $image_name = $_FILES["product_image"]["name"];
        $image_tmp_name = $_FILES["product_image"]["tmp_name"];
        $image_path = $upload_dir . $image_name;

        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $image_path = mysqli_real_escape_string($conn, $image_path);

            $sql = "INSERT INTO products (product_name, product_desc, product_price, product_image) VALUES ('$product_name', '$product_desc', '$product_price', '$image_path')";

            if (mysqli_query($conn, $sql)) {
                header("location:products.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('Error uploading image. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Error in registering. Please try again.');</script>";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>E-Shop | Add Product</title>
  <link rel="stylesheet" href="../assets/css/form.css" />
</head>
<body>
  <div class="container">
    <?php
    include('common.php');
    ?>
    <section class="main">
    <br><br>
        <div class="form-style-5">
            <form action="" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Product Details</legend><br>
                    <label for="product_name">Name:</label>
                    <input type="text" name="product_name" id="product_name" placeholder="" required="required" />
                    <label for="product_desc">Description:</label>
                    <textarea name="product_desc" id="product_desc" placeholder="" required="required"></textarea>
                    <label for="product_price">Price:</label>
                    <input type="text" name="product_price" id="product_price" placeholder="" required="required" />
                    <label for="product_image">Image:</label>
                    <input type="file" name="product_image" id="product_image" placeholder="" required="required" />
                </fieldset>
                <input type="submit" value="ADD PRODUCT"/>
            </form>
        </div>
    </section>
  </div>
</body>
</html>
