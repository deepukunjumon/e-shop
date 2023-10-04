<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/css/portal.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
  <?php
    include('../include/connection.php');
    $userId = mysqli_real_escape_string($conn, $_SESSION['id']);

    $sql = "SELECT * FROM users WHERE user_id = '$userId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        $name = $row['name'];
        $profile_pic = $row['profile_pic'];
    }


  echo '<div class="container">
    <nav>
      <ul>
        <li><a href="viewprofile.php" class="logo">
          <img src="../'.$profile_pic.'">
          <span class="nav-item">'.$name.'
          <h6>ADMINISTRATOR</h6>
          </span>
        </a></li>
        <li><a href="adminhome.php">
          <i class="fas fa-laptop"></i>
          <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="users.php">
          <i class="fas fa-users"></i>
          <span class="nav-item">Users</span>
        </a></li>
        <li><a href="products.php">
          <i class="fas fa-database"></i>
          <span class="nav-item">Products</span>
        </a></li>
        <li><a href="addproduct.php">
          <i class="fas fa-box"></i>
          <span class="nav-item">Add New Product</span>
        </a></li>



        <li><a href="../logout.php" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>
  </div>
</body>';
?>
</html>