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
  <title>E-Shop | Products</title>
  <link rel="stylesheet" href="../assets/css/portal.css" />
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/> -->
</head>
<body>
  <div class="container">
  <?php
    include('common.php');
  ?>
    <section class="main">
      <section class="users">
        <div class="users-list"><br>
          <h1>PRODUCTS</h1>
          <a href="addproduct.php" class="add-product-btn">Add Product</a>
          <table class="table">
            <thead>
              <tr>
                <th>Sl No.</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT * FROM products";
                $result = mysqli_query($conn, $sql);

                if($result){
                  $sino =0;
                    while($row=mysqli_fetch_assoc($result)){
                        $product_id = $row['product_id'];
                        $product_name = '<a href="product_page.php?product_id='.$product_id.'">' . $row['product_name'] . '</a>';
                        $product_desc = $row['product_desc'];
                        $product_image = $row['product_image'];
                        $product_price = $row['product_price'];
                        $sino++;
                        ?>
                        <tr>
                            <td><?php echo $sino; ?></td>
                            <td><?php echo $product_name; ?></td>
                            <td><?php echo $product_desc; ?></td>
                            <td>₹ <?php echo $product_price; ?></td>
                            <td><img class="preview" src="<?php echo $product_image; ?>" alt="Product Image"></td>
                            <td>
                            <div class="button-container">
                              <div class="button-wrapper">
                                <a href="editproduct.php?edit_id=<?php echo $product_id; ?>" class="editbtn">
                                  <button class="btn btn-edit" id="edit">Edit</button>
                                </a>
                              </div>
                              <div class="button-wrapper">
                                <a href="deleteproduct.php?deleteid=<?php echo $product_id; ?>" class="deletebtn">
                                  <button class="btn btn-delete" id="delete">Delete</button>
                                </a>
                              </div>
                            </div>
                          </td>

                        </tr>
                        <?php
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
