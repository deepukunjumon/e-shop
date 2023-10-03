<?php
    include 'include/connection.php';
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
                <img src="assets/images/success.png" id="icon" alt="e-shop" />
                <h3>Account created successfully !</h3>
                <br>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 1700);
    </script>
</body>
</html>


