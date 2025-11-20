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
    }
    .sidebar h2 {
        margin-bottom: 30px;
        text-align: center;
    }
    .sidebar a {
        display: block;
        padding: 12px;
        margin-bottom: 10px;
        color: #fff;
        border-radius: 5px;
    }
    .sidebar a:hover {
        background: #007bff;
    }
    .admin-content {
        margin-left: 270px;
        padding: 30px;
        width: 100%;
    }
    .topbar {
        display: flex;
        justify-content: space-between;
        margin-bottom: 25px;
    }
    .card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        text-align: center;
    }
    .grid-3 { grid-template-columns: repeat(3, 1fr); }
</style>

</head>
<body>

<div class="admin-wrapper">
