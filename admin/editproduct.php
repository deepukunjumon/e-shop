<?php
include("../include/connection.php");
session_start();
if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
} else {

    if (isset($_GET['edit_id'])) {
        $id = $_GET['edit_id'];

        $sql = "SELECT * FROM `products` WHERE product_id = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $product_name = $row['product_name'];
        $product_desc = $row['product_desc'];
        $product_price = $row['product_price'];
        $product_image = $row['product_image'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
            $product_desc = mysqli_real_escape_string($conn, $_POST["product_desc"]);
            $product_price = mysqli_real_escape_string($conn, $_POST["product_price"]);

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
                    $sql = "UPDATE `products` SET product_name='$product_name', product_desc='$product_desc', product_price='$product_price', product_image='$image_path' WHERE product_id=$id";

                    if (mysqli_query($conn, $sql)) {
                        header("location:editproduct.php?edit_id=$id");
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    echo "<script>alert('Error uploading image. Please try again.');</script>";
                }
            } else {
                $sql = "UPDATE `products` SET product_name='$product_name', product_desc='$product_desc', product_price='$product_price' WHERE product_id=$id";

                if (mysqli_query($conn, $sql)) {
                    header("location:product_page.php?product_id=$id");
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>E-Shop | Edit Product</title>
    <link rel="stylesheet" href="../assets/css/product_page.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
<div class="container">
    <?php
    include('common.php');
    ?>
    <section class="main">
        <div class="product-view-container">
            <div class="product-image">
                <img src="<?php echo $product_image; ?>" alt="Product Image">
            </div>
            <div class="product-details">
                <h1><?php echo $product_name; ?></h1>
                <!-- <p>Description: <?php echo $product_desc; ?></p> -->
                <p class="product_desc" rows="5"><?php echo $product_desc; ?></p>
                <p class='price'>Price: ₹ <?php echo $product_price; ?></p>
                <a href="deleteproduct.php?deleteid=<?php echo $id; ?>" class="deletebtn">DELETE</a>
            </div>
        </div>
    </section>
    <section class="main">
        <div class="form-style-5">
            <form action="" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Product Details</legend><br>
                    <label for="product_name">Name:</label>
                    <input type="text" name="product_name" id="product_name" placeholder=""
                           required="required" value="<?php echo $product_name; ?>"/>
                    <label for="product_desc">Description:</label>
                    <input type="textarea" name="product_desc" id="product_desc" placeholder=""
                              required="required" value="<?php echo $product_desc; ?>"/>
                    <label for="product_price">Price:</label>
                    <input type="text" name="product_price" id="product_price" placeholder=""
                           required="required" value="<?php echo $product_price; ?>"/>
                    <label for="product_image">Image:</label>
                    <input type="file" name="product_image" id="product_image" placeholder=""/>
                </fieldset>
                <input type="submit" value="UPDATE"/>
            </form>
        </div>
    </section>
</div>
</body>
</html>
