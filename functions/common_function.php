<?php
// including connect file
include('./includes/connect.php');

//getting products
function getproducts(){
  global $con;

  if(!isset($_GET['category'])){
      $select_query="SELECT * FROM products";
      $result_query=mysqli_query($con,$select_query);
      while($row=mysqli_fetch_assoc($result_query)) {
          $product_id=$row['product_id'];
          $product_title=$row['product_title'];
          $product_description=$row['product_description'];
          $product_image=$row['product_image'];
          $product_price=$row['product_price'];
          $stock=$row['stock'];  // Fetch stock of the product

          $button = $stock > 0 ? "<a href='index.php?add_to_cart=$product_id' class='btn btn-bright-orange'>Add to cart</a>" 
                                : "<button class='btn btn-secondary' disabled>Add to cart</button>";  // Use button for out of stock

          echo "<div class ='col-md-4 mb-2'>
          <div class='card card_style'>
              <img src='./images/product/$product_image' class='card-img-top' alt=''>
              <div class='card-body'>
                  <h5 class='card-title'>$$product_price</h5>
                  <p class='card-text'>$product_title<br>$product_description<br>in stock: $stock</p>
                  $button
              </div>
          </div>
        </div>";
      }
  }
}

//displaying categories in sidenav
function getcategories(){
  global $con;
  $select_categories = "SELECT * FROM categories";
  $result_categories = mysqli_query($con, $select_categories);
  while($row_data = mysqli_fetch_assoc($result_categories)){
      $category_title = $row_data['category_title'];
      $category_id = $row_data['category_id'];
      echo "<li class='nav-item'>
            <a href='#' class='nav-link bg-light-orange category-link' data-category-id='$category_id'>$category_title</a>
            <ul class='sub-category-list' id='sub-category-$category_id' style='display:none;'></ul>
            </li>";
  }
}


// //get unique categories
function get_unique_categories(){
  global $con;

  if(isset($_GET['category'])){
      $category_id=$_GET['category'];
      $select_query="SELECT * FROM products WHERE category_id=$category_id";
      $result_query=mysqli_query($con,$select_query);
      while($row=mysqli_fetch_assoc($result_query)) {
          $product_id=$row['product_id'];
          $product_title=$row['product_title'];
          $product_description=$row['product_description'];
          $product_image=$row['product_image'];
          $product_price=$row['product_price'];
          $stock=$row['stock'];  // Fetch stock of the product

          $button = $stock > 0 ? "<a href='index.php?add_to_cart=$product_id' class='btn btn-bright-orange'>Add to cart</a>" 
                                : "<button class='btn btn-secondary' disabled>Add to cart</button>";  // Use button for out of stock

          echo "<div class ='col-md-4 mb-2'>
          <div class='card card_style'>
              <img src='./images/product/$product_image' class='card-img-top' alt=''>
              <div class='card-body'>
                  <h5 class='card-title'>$$product_price</h5>
                  <p class='card-text'>$product_title<br>$product_description<br>in stock: $stock</p>
                  $button
              </div>
          </div>
        </div>";
      }
  }
}



// searching products function
function search_product(){
    global $con;
    if (isset($_GET['search_data_product'])) {
        $search_data_value=$_GET['search_data'];
    $search_query="Select * from products where product_keywords like '%$search_data_value%'";
    $result_query = mysqli_query($con,$search_query);
    $num_of_row=mysqli_num_rows($result_query);
    if($num_of_row==0){
        echo "<h2 class='text-center text danger'>Not available now</h2>";
    }
        
        while($row=mysqli_fetch_assoc($result_query)) {
          $product_id=$row['product_id'];
          $product_title=$row['product_title'];
          $product_description=$row['product_description'];
          $product_image=$row['product_image'];
          $product_price=$row['product_price'];
          echo "<div class ='col-md-4 mb-2'>
          <div class='card card_style'>
            <img src='./images/product/$product_image' class='card-img-top' alt=''>
              <div class='card-body'>
                <h5 class='card-title'>$$product_price</h5>
                <p class='card-text'>$product_title<br>$product_description<br>in stock</p>
                <a href='index.php?add_to_cart=$product_id' class='btn btn-bright-orange'>Add to cart</a>
              </div>
          </div>
        </div>";
        }
    }
}




//get ip address

    function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  
// $ip = getIPAddress();  
// echo 'User Real IP Address - '.$ip;  

// cart function
function cart() {
  if(isset($_GET['add_to_cart'])) {
      global $con;
      $get_ip_add = getIPAddress();
      $get_product_id = $_GET['add_to_cart'];
      
      $select_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_add' AND product_id='$get_product_id'";
      $result_query = mysqli_query($con, $select_query);
      $num_of_row = mysqli_num_rows($result_query);

      if($num_of_row > 0) {
          $row = mysqli_fetch_assoc($result_query);
          $new_quantity = $row['quantity'] + 1;
          $update_query = "UPDATE cart_details SET quantity='$new_quantity' WHERE ip_address='$get_ip_add' AND product_id='$get_product_id'";
          mysqli_query($con, $update_query);
      } else {
          $insert_query = "INSERT INTO cart_details (product_id, ip_address, quantity) VALUES ('$get_product_id', '$get_ip_add', 1)";
          mysqli_query($con, $insert_query);
      }
      echo "<script>window.open('cart.php','_self')</script>";
  }
}




// function to get cart item numbers
function cart_item(){
  if(isset($_GET['add_to_cart'])){
    global $con;
    $get_ip_add = getIPAddress(); 
    
    $select_query= "Select * from cart_details where ip_address='$get_ip_add'";
    $result_query = mysqli_query($con,$select_query);
    $count_cart_items=mysqli_num_rows($result_query);
  }else{
    global $con;
    $get_ip_add = getIPAddress(); 
    
    $select_query= "Select * from cart_details where ip_address='$get_ip_add'";
    $result_query = mysqli_query($con,$select_query);
    $count_cart_items=mysqli_num_rows($result_query);
    }
    echo $count_cart_items;
  }

// total price function
function total_cart_price(){
  global $con;
  $get_ip_add = getIPAddress();
  $total_price=0;
  $cart_query="Select * from cart_details where ip_address='$get_ip_add'";
  $result=mysqli_query($con,$cart_query);
  while ($row=mysqli_fetch_array($result)){
    $product_id=$row['product_id'];
    $select_products="Select * from products where product_id='$product_id'";
    $result_products=mysqli_query($con,$select_products);
    while ($row_product_price=mysqli_fetch_array($result_products)){
      $product_price=array($row_product_price['product_price']);
      $product_values=array_sum($product_price);
      $total_price+=$product_values;
    }
  }
  echo $total_price;
}

// remove item
function remove_cart_item(){
  global $con;
  if(isset($_POST['remove_cart'])){
    foreach($_POST['removeitem'] as $remove_id){
      echo $remove_id;
      $delete_query="Delete from cart_details where product_id='$remove_id'";
      $run_delete=mysqli_query($con,$delete_query);
      if($run_delete){
        echo "<script>window.open('cart.php','_self')</script>";
      }
    }
  }
}


// selecting cart items
function select_cart_items(){
  global $con;
  $get_ip_add = getIPAddress();
  $select_cart_items="Select * from cart_details where ip_address='$get_ip_add'";
  $result_cart=mysqli_query($con,$select_cart_items);
  $rows_count=mysqli_num_rows($result_cart);
  if($rows_count>0){
    echo "<script>window.open('checkout.php','_self')</script>";
  }
}

function remove_all_item(){
  global $con;
  $get_ip_add = getIPAddress();  // Get the user's IP address
  if(isset($_POST['clear_all'])){  // Check if the 'Clear All' button was pressed
      $delete_query = "DELETE FROM cart_details WHERE ip_address='$get_ip_add'";  // Prepare the delete query
      $run_delete = mysqli_query($con, $delete_query);  // Execute the query
      if($run_delete){
          echo "<script>window.open('cart.php','_self')</script>";  // Refresh the page
      }
  }
}

function check_cart_stock() {
  global $con;
  $ip_address = getIPAddress();
  $cart_query = "SELECT cart_details.product_id, cart_details.quantity AS cart_quantity, products.stock, products.product_title
                 FROM cart_details
                 JOIN products ON cart_details.product_id = products.product_id
                 WHERE cart_details.ip_address = '$ip_address'";
  $cart_result = mysqli_query($con, $cart_query);
  $out_of_stock_products = [];

  while ($cart_item = mysqli_fetch_assoc($cart_result)) {
      if ($cart_item['cart_quantity'] > $cart_item['stock']) {
          $out_of_stock_products[] = $cart_item['product_title'];
      }
  }

  if (!empty($out_of_stock_products)) {
      return "The following products are out of stock or not available in the desired quantity: " . implode(", ", $out_of_stock_products);
  }
  return null;
}


// clear cart after submit
function clear_cart() {
  global $con;
  $ip_add = getIPAddress();  // Get the user's IP address

  $delete_query = "DELETE FROM cart_details WHERE ip_address='$ip_add'";  // Prepare the delete query
  $run_delete = mysqli_query($con, $delete_query);  // Execute the query

  if ($run_delete) {
      echo "Cart has been cleared successfully.";  // Success message
  } else {
      echo "Error: " . mysqli_error($con);  // Display error message if query fails
  }
}

// decrement the stock for each product that's been purchased
function update_stock() {
  global $con;
  $ip_address = getIPAddress();
  $cart_query = "SELECT product_id, quantity FROM cart_details WHERE ip_address = '$ip_address'";
  $cart_result = mysqli_query($con, $cart_query);

  while ($cart_item = mysqli_fetch_assoc($cart_result)) {
      $product_id = $cart_item['product_id'];
      $quantity_purchased = $cart_item['quantity'];

      // Decrement the stock
      $update_stock_query = "UPDATE products SET stock = stock - $quantity_purchased WHERE product_id = $product_id";
      $update_stock_result = mysqli_query($con, $update_stock_query);
      
      if (!$update_stock_result) {
          echo "Error updating stock for product ID $product_id: " . mysqli_error($con);
      }
  }
}
