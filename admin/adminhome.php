<?php
include('../include/connection.php');
session_start();
if (!isset($_SESSION['id']) && $_SESSION['login'] !== 'true') {
    header("location: ../login.php");
    exit();
}

$sql = "SELECT * FROM users where type=0";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $users = array(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/css/portal.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
  <div class="container">
  <?php
    include('common.php');
  ?>
    <section class="main">
      <div class="main-top">
        <h1>Recently Registered Users</h1>
        <i class="fas fa-user-cog"></i>
      </div>
      <div class="users">
        <?php
        foreach ($users as $user) {
            $user_id = $user['user_id'];
            $name = $user['name'];
            $email = $user['email'];
            $phone = $user['phone'];
            $profile_pic = $user['profile_pic'];
        ?>
        <div class="card">
          <img src="../<?php echo $profile_pic; ?>">
          <h4><?php echo $name; ?></h4>
          <p><?php echo $email; ?></p>
          <p>Mobile: <?php echo $phone; ?></p>
          <a href="viewprofile.php?user_id=<?php  echo $user_id; ?>">
            <button>View Profile</button>
        </a>
          
        </div>
        <?php
        }
        ?>
      </div>
      <!-- Rest of your HTML code -->
    </section>
  </div>
</body>
</html>
