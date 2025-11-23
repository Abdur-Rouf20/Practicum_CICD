<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Electronics Store</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>

<header class="site-header">
    <div class="container">

        <a href="index.php" class="logo">ELECTRONICS</a>

        <nav class="menu">
            <a href="index.php">Home</a>
            <a href="search.php">Search</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="cart.php">Cart</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php">Hello, <?= $_SESSION['user_name']; ?></a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>

    </div>
</header>

<main class="content">
