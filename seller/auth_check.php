<?php
// seller/includes/seller_auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user is not logged in or not a seller, redirect to auth or login
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'seller') {
    header("Location: /auth"); // adapt if your auth route is different
    exit;
}

// convenience
$seller_id = $_SESSION['user_id'];
