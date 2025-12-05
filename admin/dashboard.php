<?php
session_start();

// Auth check
require_once __DIR__ . "/auth_check.php";

// Load config and PDO
require_once __DIR__ . "/../app/config/config.php"; // BASE_URL
$pdo = require __DIR__ . "/../app/helpers/db.php";

// Function to get total counts
function getCount($table) {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM $table");
    $row = $stmt->fetch();
    return $row['total'] ?? 0;
}

// Page title
$title = "Admin Dashboard";

// Include header & sidebar
?>

<div class="admin-content">

    <div class="topbar">
        <h2>Dashboard Overview</h2>
        <span>Welcome, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
    </div>

    <!-- ======= DASHBOARD STAT CARDS ======= -->
    <div class="grid grid-3">

        <div class="card">
            <h3>Total Products</h3>
            <p><?= getCount("products") ?></p>
        </div>

        <div class="card">
            <h3>Total Orders</h3>
            <p><?= getCount("orders") ?></p>
        </div>

        <div class="card">
            <h3>Total Users</h3>
            <p><?= getCount("users") ?></p>
        </div>

    </div>

    <!-- ======= CATEGORY MANAGEMENT SHORTCUT ======= -->
    <h3 style="margin-top: 40px;">Category Management</h3>

    <div class="grid grid-2" style="margin-top: 20px;">

        <div class="card">
            <h3>View Categories</h3>
            <p>Manage all product categories</p>
            <a href="categories.php" class="btn btn-primary">Go to Categories</a>
        </div>

        <div class="card">
            <h3>Add Category</h3>
            <p>Create a new category</p>
            <a href="add-category.php" class="btn btn-success">+ Add Category</a>
        </div>

    </div>

    <!-- ======= RECENT ORDERS TABLE ======= -->
    <h3 style="margin-top: 40px;">Recent Orders</h3>

    <table class="table" cellpadding="12" cellspacing="0" border="1" 
           style="width:100%; margin-top:15px; background:#fff;">
        <tr>
            <th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Date</th>
        </tr>

        <?php
        $stmt = $pdo->query("SELECT * FROM orders ORDER BY id DESC LIMIT 5");
        $orders = $stmt->fetchAll();

        foreach ($orders as $row) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['user_id'] ?></td>
                <td><?= $row['total_amount'] ?> BDT</td>
                <td><?= ucfirst($row['status']) ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php } ?>
    </table>

</div>
