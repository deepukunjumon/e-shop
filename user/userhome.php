<?php
include 'nav.php';

include("../include/connection.php");
if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <link rel="stylesheet" href="../assets/css/userhome.css">
</head>
<body>

<div class="product-row">
<?php
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($result)) {
        $product_id=$row['product_id'];
        $product_name = $row['product_name'];
        $product_desc = $row['product_desc'];
        $product_image = $row['product_image'];
        $product_price = $row['product_price'];
    ?>
	<div class="product-card">
		<div class="product-tumb">
			<img src="<?php echo $product_image; ?>" alt="">
		</div>
		<div class="product-details">
			<span class="product-catagory"></span>
			<h4><a href="view_product.php?product_id=<?php echo $product_id?>"><?php echo $product_name; ?></a></h4>
			<p><?php echo $product_desc; ?></p>
			<div class="product-bottom-details">
				<div class="product-price"><small>₹ <?php echo $product_price+125; ?></small>₹<?php echo $product_price; ?></div>
				<div class="product-links">
					<a href=""><i class="fa fa-heart"></i></a>
					<a href=""><i class="fa fa-shopping-cart"></i></a>
				</div>
			</div>
		</div>
	</div>
    <?php } ?>
</div>
    
</body>
</html>
