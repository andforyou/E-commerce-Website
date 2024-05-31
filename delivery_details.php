<?php
session_start(); // Start the session at the very top of the file
include('includes/connect.php');
include('functions/common_function.php');

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stock_check = check_cart_stock();  // Assume this function returns null if all is good, otherwise returns error message

    if ($stock_check === null) {
        // All items in stock
        update_stock();  // Function to update stock

        // Fetch cart details
        $ip_add = getIPAddress();
        $cart_items = [];
        $total_price = 0;
        $cart_query = "SELECT * FROM cart_details JOIN products ON cart_details.product_id = products.product_id WHERE ip_address='$ip_add'";
        $result = mysqli_query($con, $cart_query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row;
            $total_price += $row['quantity'] * $row['product_price'];
        }

        // Store delivery and cart details in session
        $_SESSION['delivery_details'] = [
            'recipientName' => $_POST['recipientName'],
            'streetAddress' => $_POST['streetAddress'],
            'citySuburb' => $_POST['citySuburb'],
            'state' => $_POST['state'],
            'mobileNumber' => $_POST['mobileNumber'],
            'emailAddress' => $_POST['emailAddress']
        ];
        $_SESSION['cart_items'] = $cart_items;
        $_SESSION['total_price'] = $total_price;
        // Redirect to confirmation page
        header('Location: confirmation.php');

        clear_cart();  // Clear the cart

        
        exit;
    } else {
        // Some items not in stock, redirect to cart with an error message
        echo "<script>alert('$stock_check');</script>";
        echo "<script>window.location.href='cart.php';</script>";
        exit;
    }
}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Details</title>
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
                        <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
                        <li class="nav-item">
                        
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

<div class="container mt-5">
    <h2>Enter Delivery Details</h2>
    <?php if (!empty($validation_error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $validation_error; ?>
        </div>
    <?php endif; ?>
    
    <!-- <form id="deliveryForm" method="post" onsubmit="return validateForm()"> -->
    <form id="deliveryForm" method="post" action="" onsubmit="return validateForm()">


        <div class="mb-3">
            <label for="recipientName" class="form-label">Recipient's Name:</label>
            <input type="text" class="form-control" id="recipientName" name="recipientName" required>
        </div>
        <div class="mb-3">
            <label for="streetAddress" class="form-label">Street Address:</label>
            <input type="text" class="form-control" id="streetAddress" name="streetAddress" required>
        </div>
        <div class="mb-3">
            <label for="citySuburb" class="form-label">City/Suburb:</label>
            <input type="text" class="form-control" id="citySuburb" name="citySuburb" required>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State:</label>
            <select class="form-select" id="state" name="state" required>
                <option value="">Select a state</option>
                <option value="NSW">NSW</option>
                <option value="VIC">VIC</option>
                <option value="QLD">QLD</option>
                <option value="WA">WA</option>
                <option value="SA">SA</option>
                <option value="TAS">TAS</option>
                <option value="ACT">ACT</option>
                <option value="NT">NT</option>
                <option value="Others">Others</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="mobileNumber" class="form-label">Mobile Number:</label>
            <input type="tel" class="form-control" id="mobileNumber" name="mobileNumber" required pattern="^04\d{8}$" title="Mobile number must start with 04 and have 10 digits in total.">
        </div>

        <div class="mb-3">
            <label for="emailAddress" class="form-label">Email Address:</label>
            <input type="email" class="form-control" id="emailAddress" name="emailAddress" required>
        </div>
        
        <button type="submit" class="btn btn-bright-orange my-3" id="submitButton">Submit</button>

    </form>
</div>

<script>
function validateForm() {
    // Example of further client-side validation if needed
    return true;
}
</script>

<!-- last child -->
<div class="bg-light-orange p-3 text-center">
        <p>
            All rights reserved.
        </p>
    </div>


 <!-- bootstrap js link -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- js file -->

<script>
function validateForm() {
    return true; // You can add actual validation logic here
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('deliveryForm');
    var submitButton = document.getElementById('submitButton');

    function updateSubmitButtonState() {
        // Disable the button unless the form is valid
        submitButton.disabled = !form.checkValidity();
    }

    // Attach an input event listener to all form elements
    Array.from(form.elements).forEach(input => {
        input.addEventListener('input', updateSubmitButtonState);
    });

    // Call the function initially to set the correct state of the button
    updateSubmitButtonState();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('deliveryForm');

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault(); // Stop submission if the form is not valid
            form.classList.add('was-validated'); // Bootstrap validation styles
        }
    }, false);
});
</script>






</body>

</html>