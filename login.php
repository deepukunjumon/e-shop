<?php
session_start(); 
include("include/connection.php");

if(isset($_POST["submit"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $email = mysqli_real_escape_string($conn, $email);

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0){
        if($password == $row["password"]){
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["user_id"];
            if ($row["type"] == 1) {
                header("Location: admin/adminhome.php");
            } else {
                header("Location: user/userhome.php");
            }
            exit();
        }
        else{
            echo "<script>alert('Wrong Password')</script>";
        }
    }
    else{
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>

<!DOCTYPE html>
<head>
    <title>E-Shop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="fadeIn first">
                <br>
                <img src="assets/images/logo/e-shop_logo.png" id="icon" alt="e-shop" />
                <h3>Login</h3>
            </div>
            <form action="" method="POST">
                <input type="text" id="email" class="fadeIn second" name="email" placeholder="username"><br>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="password"><br>
                <input type="submit" name="submit" class="fadeIn fourth" value="Log In">
            </form>

            <div id="formFooter">
                <a class="underlineHover" href="register.php">Create an account</a>
            </div>
        </div>
    </div>
</body>
</html>


