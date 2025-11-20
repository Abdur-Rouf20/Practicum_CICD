<?php include "includes/auth_check.php"; ?>
<?php 
$title = "Admin Dashboard";
include "includes/admin_header.php";
include "includes/admin_sidebar.php";
?>

<div class="admin-content">

    <div class="topbar">
        <h2>Dashboard Overview</h2>
        <span>Welcome, <?php echo $_SESSION['admin_name']; ?></span>
    </div>

    <div class="grid grid-3">
        <div class="card">
            <h3>Total Products</h3>
            <p><?php echo getCount("products"); ?></p>
        </div>

        <div class="card">
            <h3>Total Orders</h3>
            <p><?php echo getCount("orders"); ?></p>
        </div>

        <div class="card">
            <h3>Total Users</h3>
            <p><?php echo getCount("users"); ?></p>
        </div>
    </div>

    <h3 style="margin-top: 40px;">Recent Orders</h3>

    <table class="table" cellpadding="12" cellspacing="0" border="1" style="width:100%; margin-top:15px; background:#fff;">
        <tr>
            <th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Date</th>
        </tr>

        <?php
        include "../config/db.php";
        $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT 5";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
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

<?php include "includes/admin_footer.php"; ?>
