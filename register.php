<?php
include("include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $re_password = mysqli_real_escape_string($conn, $_POST['re_password']);

    if ($password !== $re_password) {
        echo "<script>alert('Passwords do not match')</script>";
    } else {
        // Create a folder for each user based on their name
        $folder_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $name);
        $upload_dir = "images/profile_pics/$folder_name/";

        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                die("Failed to create directory: $upload_dir");
            }
        }

        if (isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] === UPLOAD_ERR_OK) {
            $image_name = $_FILES["profile_pic"]["name"];
            $image_tmp_name = $_FILES["profile_pic"]["tmp_name"];
            $image_path = $upload_dir . $image_name;

            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $sql = "INSERT INTO users (name, email, phone, address, password, profile_pic) 
                        VALUES ('$name', '$email', '$phone', '$address', '$password', '$image_path')";

                if (mysqli_query($conn, $sql)) {
                    header("Location: success.php");
                    exit(); 
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Failed to move uploaded file.";
            }
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Shop</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="fadeIn first">
                <br>
                <img src="assets/images/logo/e-shop_logo.png" id="icon" alt="e-shop" />
                <h3>Register</h3>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" id="name" class="fadeIn second" placeholder="Name" required><br>
                <input type="email" name="email" id="email" class="fadeIn second" placeholder="Email" required><br>
                <input type="text" name="phone" id="phone" class="fadeIn second" placeholder="Phone" required><br>
                <input type="text" name="address" id="address" class="fadeIn second" placeholder="Address" required><br>
                <input type="password" name="password" id="password" class="fadeIn third" placeholder="Password" required><br>
                <input type="password" name="re_password" id="re_password" class="fadeIn third" placeholder="Confirm Password" required><br>
                <input type="file" name="profile_pic" id="profile_pic" class="fadeIn third" required><br>
                <input type="submit" name="submit" class="fadeIn fourth" value="Register">
            </form>

            <div id="formFooter">
                <a class="underlineHover" href="login.php">Already have an account</a>
            </div>
        </div>
    </div>
</body>
</html>
