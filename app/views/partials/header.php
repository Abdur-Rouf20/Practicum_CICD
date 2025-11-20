<!-- nav </nav> 
 <!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>NextGen E-Commerce</title>
<link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
<header>
<nav>
</header>
<main>
-->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : "Electronics Shop"; ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- JS -->
    <script defer src="/assets/js/main.js"></script>
</head>
<body>

<header class="header">
    <div class="container navbar">

        <div class="logo">
            <a href="/index.php">ElectroShop</a>
        </div>

        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/products.php">Products</a></li>
            <li><a href="/cart.php">Cart</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/profile.php">Profile</a></li>
                <li><a href="/logout.php" class="btn">Logout</a></li>
            <?php else: ?>
                <li><a href="/login.php" class="btn">Login</a></li>
            <?php endif; ?>
        </ul>

        <i class="fa fa-bars" id="menu-btn"></i>
    </div>
</header>

<div class="container" style="margin-top: 25px;">

