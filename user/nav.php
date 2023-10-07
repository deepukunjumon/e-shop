<?php
include('../include/connection.php');
session_start();
$_GET['user_id'] = $_SESSION['id'];
$sql = "SELECT * FROM users where user_id =" . $_SESSION['id'];
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result); // Use mysqli_fetch_assoc to fetch a single user's data
    $name = $user['name'];
    $profile_pic = $user['profile_pic'];
} else {
    $name = ""; // Set a default name or handle the case when no user is found
    $profile_pic = ""; // Set a default profile pic or handle the case when no user is found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/nav.css">
    <style>
        .pro_pic {
            cursor: pointer;
        }
        .logout-link {
            display: none;
        }
    </style>
    <title>E-Shop | User Home</title>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="../assets/images/logo/e-shop_logo.png" alt="Logo">
        </div>
        <ul class="nav-links">
            <li><a href="userhome.php">Home</a></li>
            <li><a href="cart.php">Cart</a></li>
            <?php if ($_SESSION['login'] == 'true') { ?>
                <li>
                    <img src='../<?php echo $profile_pic; ?>' alt="Profile Pic" class="pro_pic" onclick="toggleLogoutLink()">
                    <a href="../logout.php" class="logout-link">Logout</a>
                </li>
            <?php } else { ?>
                <li><a href="#">Login</a></li>
            <?php } ?>
        </ul>
    </nav>

    <script>
        function toggleLogoutLink() {
            var logoutLink = document.querySelector('.logout-link');
            if (logoutLink.style.display === 'block') {
                logoutLink.style.display = 'none';
            } else {
                logoutLink.style.display = 'block';
            }
        }
    </script>
</body>
</html>
