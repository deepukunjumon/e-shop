<?php
include 'nav.php';
include("../include/connection.php");
if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
}
if (isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];

    $sql = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        $product_name = $row['product_name'];
        $product_desc = $row['product_desc'];
        $product_image = $row['product_image'];
        $product_price = $row['product_price'];
    }
    else{
        echo "Product not found.";
    }

}
else{
    echo "Product ID is missing.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .product-container {
			display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            
        }

        .product-card {
            margin-top:5em;
			max-height: 500px;
            width: 75%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 7px #dfdfdf;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .product-image {
			align-self: center;                 
            max-width: 40%;
            height: 300px;
            border-radius: 8px;
        }

        .product-details {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .product-description {
            font-size: 16px;
            color: #777;
            text-align: center;
        }

        .product-price {
            font-size: 24px;
            font-weight: 600;
            color: #fbb72c;
        }

        .add-to-cart-button {
            text-decoration: none;
            margin-top: 20px;
            background-color: #fbb72c;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px;
            font-size: 18px;
            cursor: pointer;
        }

        .add-to-cart-button:hover {
            background-color: #fca936;
        }
    </style>
</head>
<body>
    <div class="product-container">
        <div class="product-card">
            <img src="<?php echo $product_image?>" alt="Product Image" class="product-image">
            <div class="product-details">
                <span class="product-name"><?php echo $product_name; ?></span>
                <p class="product-description"><?php echo $product_desc; ?></p>
                <span class="product-price"><?php echo $product_price; ?></span>
                <a href="addtocart.php?id=<?php echo $product_id; ?>" class="add-to-cart-button">Add to Cart</a>
            </div>
        </div>
    </div>
</body>
</html>

