<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : "NextGen Electronics"; ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/main.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- JS -->
    <script defer src="<?= BASE_URL ?>/assets/js/main.js"></script>
</head>
<body>

<header class="header">
    <div class="container navbar">

        <div class="logo">
            <a href="<?= BASE_URL ?>/index.php">NextGen Electronics</a>
        </div>

        <ul>
            <li><a href="<?= BASE_URL ?>/index.php">Home</a></li>
            <li><a href="<?= BASE_URL ?>/products.php">Products</a></li>
            <li><a href="<?= BASE_URL ?>/cart.php">Cart</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="<?= BASE_URL ?>/profile.php">Profile</a></li>
                <li><a href="<?= BASE_URL ?>/logout.php" class="btn">Logout</a></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL ?>/login.php" class="btn">Login</a></li>
            <?php endif; ?>
        </ul>

        <i class="fa fa-bars" id="menu-btn"></i>
    </div>
</header>

<main class="container" style="margin-top: 25px;">
