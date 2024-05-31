<!-- connect file -->
<?php
include('includes/connect.php');
include('functions/common_function.php');


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Details</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <!-- font awesome link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <!-- css file -->
   <link rel="stylesheet" href="style.css">
   <script>
function updateSubtotal() {
    var inputs = document.querySelectorAll('input[name^="qty"]');
    var total = 0;
    inputs.forEach(input => {
        var row = input.closest('tr');
        var price = parseFloat(row.querySelector('.product-price').textContent.replace('$', ''));
        total += input.value * price;
    });
    document.getElementById('subtotal').textContent = '$' + total.toFixed(2);
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    updateSubtotal(); // Calculate subtotal on page load
});
</script>



</head>
<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg bg-light-orange">
            <div class="container-fluid">
                <img src="./images/logo.png" alt="logo" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link bg-light-orange" aria-current="page" href="index.php">Home</a>
                        </li>
                        
                        <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- table -->
    <div class="container">
        <div class="row">
            <form action="" method="post">
            <table class="table table-bordered text-center">
                
                <tbody>
                    <!-- php code to dispaly dynamic data -->
                    <?php
                        global $con;
                        $get_ip_add = getIPAddress();
                        $total_price=0;
                        $cart_query="Select * from cart_details where ip_address='$get_ip_add'";
                        $result=mysqli_query($con,$cart_query);
                        $result_count=mysqli_num_rows($result);
                        if($result_count>0){
                            echo "<thead>
                            <tr>
                                <th>Product Title</th>
                                <th>Product Image</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Remove</th>
                                <th colspan='2'>Operations</th>
                            </tr>
                        </thead>";
                       
                        while ($row=mysqli_fetch_array($result)){
                          $product_id=$row['product_id'];
                          $select_products="Select * from products where product_id='$product_id'";
                          $result_products=mysqli_query($con,$select_products);
                          while ($row_product_price=mysqli_fetch_array($result_products)){
                            $product_price=array($row_product_price['product_price']);
                            $price_table=$row_product_price['product_price'];
                            $product_title=$row_product_price['product_title'];
                            $product_image=$row_product_price['product_image'];
                            $product_values=array_sum($product_price);
                            $total_price+=$product_values;
                         

                    ?>
                    <tr>
                        <td><?php echo $product_title;?></td>
                        <td><img src="./images/product/<?php echo $product_image;?>" alt="" class="cart_img"></td>
                        <td><input type="text" name="qty[<?php echo $product_id; ?>]" value="<?php echo $row['quantity']; ?>" class="form-input w-50" oninput="updateSubtotal()"></td>
                        <td class="product-price">$<?php echo $price_table; ?></td>

                        <?php
                        $get_ip_add = getIPAddress();
                        if(isset($_POST['update_cart'])){
                            $quantities = $_POST['qty'];
                            $total_price = 0;
                            foreach ($quantities as $id => $qty) {
                                $update_cart = "UPDATE cart_details SET quantity='$qty' WHERE ip_address='$get_ip_add' AND product_id='$id'";
                                mysqli_query($con, $update_cart);

                                // Fetch the latest price for the product and calculate the subtotal
                                $price_query = "SELECT product_price FROM products WHERE product_id='$id'";
                                $price_result = mysqli_query($con, $price_query);
                                if($row_price = mysqli_fetch_assoc($price_result)) {
                                    $total_price += $row_price['product_price'] * $qty;
                                }
                            }
                            echo "<script>window.open('cart.php','_self')</script>";  // Refresh the page with updated subtotal
                        }

                        ?>
                        <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id; ?>"></td>
                        <td>
                            <input type="submit" value="Update Cart" class="btn btn-bright-orange" name="update_cart">
                            <input type="submit" value="Remove Cart" class="btn btn-bright-orange" name="remove_cart">
                            
                        </td>
                    </tr>
                    <?php }}}
                    else{
                        echo "<h2 class='text-center text-danger'=>Cart is empty</h2>";
                    }
                    ?>
                </tbody>
            </table>
            <!-- subtotal -->
            <div class="d-flex mb-3">
                <?php
                    $get_ip_add = getIPAddress();
                    
                    $cart_query="Select * from cart_details where ip_address='$get_ip_add'";
                    $result=mysqli_query($con,$cart_query);
                    $result_count=mysqli_num_rows($result);
                    if($result_count>0){
                        echo "<h4 id='subtotal' class='px-3'>Subtotal:<strong>$0</strong></h4>

                        
                        <input type='submit' value='Place an order' class='btn btn-bright-orange mx-1' name='checkout'> 
                        
                        <input type='submit' value='Clear All' class='btn btn-danger mx-1' name='clear_all'>

                        
                        
                        ";


                        
                    }else{
                        echo"<input type='submit' value='Continue Shopping' class='btn btn-bright-orange' name='continue_shopping'>";
                    }
                    if(isset($_POST['continue_shopping'])){
                        echo "<script>window.open('index.php','_self')</script>";
                    }
                    if(isset($_POST['checkout'])){
                        echo "<script>window.open('delivery_details.php','_self')</script>";
                    }

                    if (isset($_POST['clear_all'])) {
                        remove_all_item();
                    }
                ?>
                
            </div>
            </form>
        </div>
    </div>
<!-- function to remove item -->
<?php

remove_cart_item();


?>


<!-- last child -->
<div class="bg-light-orange p-3 text-center">
        <p>
            All rights reserved.
        </p>
    </div>


 <!-- bootstrap js link -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>