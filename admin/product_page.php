<?php
include("../include/connection.php");
session_start();
if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
}
if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];

    $sql = "SELECT * FROM products WHERE product_id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $product_name = $row['product_name'];
        $product_desc = $row['product_desc'];
        $product_image = $row['product_image'];
        $product_price = $row['product_price'];
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID is missing.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Users</title>
  <link rel="stylesheet" href="../assets/css/product_page1.css" />
</head>
<body>
  <div class="container">
  <?php
    include('common.php');
  ?>
    <section class="main">
      <div class="product-view-container">
        <div class="product-image"><br><br><br>
          <img src="<?php echo $product_image; ?>" alt="Product Image">
        </div>
        <div class="product-details">
          <h1><?php echo $product_name; ?></h1>
          <p>Description: <?php echo $product_desc; ?></p>
          <p class='price'>Price: ₹ <?php echo $product_price; ?></p>
          <a href="editproduct.php?edit_id=<?php echo $id; ?>" class="editbtn">Edit</a>
          <a href="deleteproduct.php?deleteid=<?php echo $id; ?>" class="deletebtn">Delete</a>
        </div>
      </div>
    </section>
</body>
</html>
