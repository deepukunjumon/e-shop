<?php
include '../include/connection.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("location:../login.php");
    exit;
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['id'];

    $checkcart = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $check_cart_result = mysqli_query($conn, $checkcart);

    if (mysqli_num_rows($check_cart_result) > 0) {
        $delete_cart_query = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
        if (mysqli_query($conn, $delete_cart_query)) {
            header('location:cart.php');
        } else {
            echo "Error adding product to cart: " . mysqli_error($conn);
        }
    }
} else {
    echo "Product ID is missing.";
}
?>