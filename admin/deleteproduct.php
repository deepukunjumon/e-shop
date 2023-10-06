<?php
include("../include/connection.php");

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sqlImagePath = "SELECT product_image FROM products WHERE product_id = $id";
    $resultImagePath = mysqli_query($conn, $sqlImagePath);

    if (!$resultImagePath) {
        die("Failed to retrieve image folder path: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($resultImagePath);
    $imageFolder = $row['product_image'];

    if (is_dir($imageFolder)) {
        if (!rrmdir($imageFolder)) {
            die("Failed to delete image folder: $imageFolder");
        }
    }

    $sqlProductDelete = "DELETE FROM products WHERE product_id = $id";
    $resultProductDelete = mysqli_query($conn, $sqlProductDelete);

    if (!$resultProductDelete) {
        die("Product deletion failed: " . mysqli_error($conn));
    }

    header('location:products.php');
}

function rrmdir($dir) {
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file)) {
            rrmdir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dir);
    return true;
}
?>
