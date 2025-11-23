<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/auth_check.php"; ?>

<h2>Your Orders</h2>

<?php
$uid = $_SESSION['user_id'];
$r = $conn->query("SELECT * FROM orders WHERE user_id=$uid ORDER BY id DESC");

while($o=$r->fetch_assoc()){
    echo "<p>Order #{$o['id']} - {$o['total_amount']} BDT - {$o['status']}</p>";
}
?>

<?php include "includes/footer.php"; ?>
