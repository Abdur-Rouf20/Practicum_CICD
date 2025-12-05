<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>

<link rel="stylesheet" href="/assets/css/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .admin-wrapper { display: flex; }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: #1e1e2d;
        color: #fff;
        padding: 20px;
        position: fixed;
        top: 0;
        left: 0;
    }

    .admin-content, .content-wrapper {
        margin-left: 270px;
        padding: 30px;
        width: calc(100% - 270px);
    }
</style>

</head>

<body>

<div class="admin-wrapper">
