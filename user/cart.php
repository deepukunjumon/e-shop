<?php
include '../include/connection.php';
include 'nav.php';

if (!isset($_SESSION['id'])) {
    header("location: ../login.php");
    exit;
}

$user_id = $_SESSION['id'];

// Function to update cart quantity
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];

    // Ensure that quantity is not less than 1
    $new_quantity = max(1, $new_quantity);

    $update_query = "UPDATE cart SET quantity = $new_quantity WHERE user_id = $user_id AND product_id = $product_id";
    mysqli_query($conn, $update_query);
}

// Function to remove item from cart
if (isset($_GET['remove_product_id'])) {
    $product_id = $_GET['remove_product_id'];
    $remove_query = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    mysqli_query($conn, $remove_query);
}

$sql = "SELECT p.product_id, p.product_name, p.product_desc, p.product_price, p.product_image, c.quantity 
        FROM cart c
        INNER JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = $user_id";

$result = mysqli_query($conn, $sql);

$totalAmount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<section class="bg-light my-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <div class="card border shadow-0">
          <div class="m-4">
            <h4 class="card-title mb-4">Your shopping cart</h4>
            <?php
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $productTotal = $row['product_price'] * $row['quantity'];
                    $totalAmount += $productTotal;
                    $formattedPPrice = number_format($row['product_price'], 2);
                    $formattedProductTotal = number_format($productTotal, 2);
            ?>
            <div class="row gy-3 mb-4">
              <div class="col-lg-5">
                <div class="me-lg-5">
                  <div class="d-flex">
                    <img src="<?php echo $row['product_image']; ?>" class="border rounded me-3" style="width: 96px; height: 96px;" />
                    <div class="">
                      <a href="#" class="nav-link"><?php echo $row['product_name']; ?></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                <div class="">
                  <form action="cart.php" method="POST" class="update-quantity-form">
                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                    <input type="number" name="new_quantity" class="form-control" value="<?php echo $row['quantity']; ?>" min="1" max="10">
                    <input type="submit" name="update_quantity" value="Update" class="btn btn-primary btn-sm mt-2">
                  </form>
                </div>
                <div class="">
                  <text class="h6 product-price">Price: $<?php echo $formattedProductTotal; ?></text> <br />
                  <small class="text-muted text-nowrap">Unit Price: $<?php echo $formattedPPrice; ?> </small>
                </div>
              </div>
              <div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                <div class="float-md-end">
                  <a href="cart.php?remove_product_id=<?php echo $row['product_id']; ?>" class="btn btn-light border text-danger"> Remove</a>
                </div>
              </div>
            </div>
            <?php
                }
            } else {
                echo "Your cart is empty.";
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card shadow-0 border">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <p class="mb-2">Total price:</p>
              <p class="mb-2 total-amount">$<?php echo number_format($totalAmount, 2); ?></p>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
              <p class="mb-2">Total price:</p>
              <p class="mb-2 fw-bold">$<?php echo number_format($totalAmount, 2); ?></p>
            </div>
            <div class="mt-3">
              <a href="#" class="btn btn-success w-100 shadow-0 mb-2"> Checkout </a>
              <a href="userhome.php" class="btn btn-light w-100 border mt-2"> Back to shop </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
