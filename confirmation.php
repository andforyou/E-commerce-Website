<?php
include('includes/connect.php');
include('functions/common_function.php');

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retrieve delivery and cart details from session
$delivery_details = $_SESSION['delivery_details'] ?? [];
$cart_items = $_SESSION['cart_items'] ?? [];
$total_price = $_SESSION['total_price'] ?? 0;

$recipientName = $delivery_details['recipientName'] ?? 'Not specified';
$streetAddress = $delivery_details['streetAddress'] ?? 'Not specified';
$citySuburb = $delivery_details['citySuburb'] ?? 'Not specified';
$state = $delivery_details['state'] ?? 'Not specified';
$mobileNumber = $delivery_details['mobileNumber'] ?? 'Not specified';
$emailAddress = $delivery_details['emailAddress'] ?? 'Not specified';
?>
<!DOCTYPE html>
<html lang="en">
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
    <h1>Order Confirmation</h1>
    <h2>Delivery Details</h2>
    <ul>
        <li>Name: <?php echo htmlspecialchars($recipientName); ?></li>
        <li>Address: <?php echo htmlspecialchars($streetAddress); ?>, <?php echo htmlspecialchars($citySuburb); ?>, <?php echo htmlspecialchars($state); ?></li>
        <li>Mobile: <?php echo htmlspecialchars($mobileNumber); ?></li>
        <li>Email: <?php echo htmlspecialchars($emailAddress); ?></li>
    </ul>

    <h2>Cart Details</h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($cart_items as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['product_title']); ?></td>
            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
            <td>$<?php echo number_format($item['product_price'], 2); ?></td>
            <td>$<?php echo number_format($item['quantity'] * $item['product_price'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Total Price</td>
            <td>$<?php echo number_format($total_price, 2); ?></td>
        </tr>
    </table>
    <h6 class="my-2">A confirmation email has already sent to your email</h6>
    <form class="d-flex" action="index.php" method="get">
    <button type="submit" class="btn btn-bright-orange my-3" id="submitButton">Continue shopping</button>
    </form>
</body>
</html>
