<!-- connect file -->
<?php
include('includes/connect.php');
include('functions/common_function.php');
if(isset($_GET['get_sub_categories'])) {
  $category_id = intval($_GET['get_sub_categories']);
  $query = "SELECT * FROM sub_categories WHERE category_id=$category_id";
  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_assoc($result)) {
      echo "<li><a href='#' class='sub-category-link' data-sub-category-id='{$row['sub_category_id']}'>{$row['sub_category_name']}</a></li>";
  }
  exit;
}

// Backend PHP to Fetch Products by Sub-Category
if(isset($_GET['get_products_by_sub_category'])) {
  $sub_category_id = intval($_GET['get_products_by_sub_category']);
  $query = "SELECT * FROM products WHERE sub_category_id=$sub_category_id";
  $result = mysqli_query($con, $query);
  while($row = mysqli_fetch_assoc($result)) {
      echo "<div class ='col-md-4 mb-2'><div class='card card_style'><img src='./images/product/{$row['product_image']}' class='card-img-top' alt=''><div class='card-body'><h5 class='card-title'>\${$row['product_price']}</h5><p class='card-text'>{$row['product_title']}<br>{$row['product_description']}<br>in stock</p><a href='index.php?add_to_cart={$row['product_id']}' class='btn btn-bright-orange'>Add to cart</a></div></div></div>";
  }
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <!-- font awesome link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <!-- css file -->
   <link rel="stylesheet" href="style.css">



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
      <form class="d-flex" action="search_product.php" method="get">
        <input class="form-control me-2" type="search" placeholder="Search products" aria-label="Search" name="search_data">
        
        <input type="submit" value="Search" class="btn btn-bright-orange" name="search_data_product">
      </form>
    </div>
  </div>
</nav>
<!-- calling cart function-->
<?php
  cart();
?>

<div class="container-fluid">
  <div class="row px-3">
  <!-- Main Content Area for Products -->
  <div class="col-md-10 card-1">
    <div class="row">
  <!-- fetching products -->
      <?php
      // calling function
        getproducts();
        get_unique_categories();
       
      ?> 
    </div>
  </div>


    <!-- Sidebar Navigation -->
    <div class="col-md-2 bg-light-orange p-0 fixed-sidebar ">
      <ul class="navbar-nav me-auto text-center">
       
        <li class="nav-item bg-info">
          <a href="#" class="nav-link bg-light-orange"><h4>Categories</h4></a>
        </li>
        <?php
          
          getcategories();
          
        ?>
        
        
      </ul>
    </div>

  </div>
</div>




<!-- last child -->

    <div class="bg-light-orange p-3 text-center">
        <p>
            All rights reserved.
        </p>
    </div>

    </div>


 <!-- bootstrap js link -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


<!-- JavaScript for dynamic sidebar navigation -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Handles category clicks to toggle sub-categories
    const categoryLinks = document.querySelectorAll('.category-link');

    categoryLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const categoryId = this.getAttribute('data-category-id');
            const subCategoryList = document.getElementById('sub-category-' + categoryId);

            // Fetch sub-categories if not already loaded
            if (subCategoryList.innerHTML == "") {
                fetch('index.php?get_sub_categories=' + categoryId)
                .then(response => response.text())
                .then(data => {
                    subCategoryList.innerHTML = data;
                    subCategoryList.style.display = 'block';
                });
            } else {
                // Toggle display
                subCategoryList.style.display = subCategoryList.style.display == 'none' ? 'block' : 'none';
            }
        });
    });

    // Handles sub-category clicks to load products
    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('sub-category-link')) {
            e.preventDefault();
            const subCategoryId = e.target.getAttribute('data-sub-category-id');
            const productDisplayArea = document.querySelector('.col-md-10 .row'); // Main content area where products are displayed

            fetch('index.php?get_products_by_sub_category=' + subCategoryId)
            .then(response => response.text())
            .then(data => {
                productDisplayArea.innerHTML = data; // Update only the product display area
            });
        }
    });
});
  
</script>
</body>
</html>
