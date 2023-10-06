<?php
include("../include/connection.php");
session_start();

if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
    exit; 
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    $checkcart = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $check_cart_result = mysqli_query($conn, $checkcart);

    if (mysqli_num_rows($check_cart_result) > 0) {
        $updatecart = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
        $updatecartresult = mysqli_query($conn, $updatecart);
        header('location:cart.php');
    } else {
        $insert_cart_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
        if (mysqli_query($conn, $insert_cart_query)) {
            header('location:cart.php');
        } else {
            echo "Error adding product to cart: " . mysqli_error($conn);
        }
    }
} else {
    echo "Product ID is missing.";
}
?>