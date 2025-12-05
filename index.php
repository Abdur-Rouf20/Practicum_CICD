<?php
require_once __DIR__ . "/app/helpers/db.php";
require_once __DIR__ . "\app\config\config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NextGen Electronics</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/main.css">
</head>
<body>

<h1>Welcome to NextGen Electronics</h1>

<a href="<?= BASE_URL ?>\admin\login.php" class="btn btn-primary">Admin Login</a>
<a href="<?= BASE_URL ?>/buyer/login.php" class="btn btn-secondary">Buyer Login</a>
<a href="<?= BASE_URL ?>/seller/login.php" class="btn btn-success">Seller Login</a>

</body>
</html>
