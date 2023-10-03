<?php
    include('../include/connection.php');
    session_start();
    if (!isset($_SESSION['id'])) {
        header("location: ../login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>E-Shop | Users</title>
  <link rel="stylesheet" href="../assets/css/portal.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
  <div class="container">
  <?php
    include('common.php');
  ?>
    <section class="main">

      <section class="users">
        <div class="users-list"><br>
          <h1>ALL USERS</h1><br>
          <table class="table">
            <thead>
              <tr>
                <th>Sl No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT * FROM users where type =0";
                $result = mysqli_query($conn, $sql);

                if($result){
                  $sino = 0;
                    while($row=mysqli_fetch_assoc($result)){
                        // $user_id = $row['user_id'];
                        $sino++;
                        $name = $row['name'];
                        $email = $row['email'];
                        $phone = $row['phone'];
                        $address = $row['address'];
                        echo '<tr>
                            <td>'.$sino.'</td>
                            <td>'.$name.'</td>
                            <td>'.$email.'</td>
                            <td>'.$phone.'</td>
                            <td>'.$address.'</td>
                            <td><button>View</button></td>
                        </tr>';
                }
            }
            ?>
            </tbody>
          </table>
        </div>
      </section>
    </section>
  </div>

</body>
</html>
