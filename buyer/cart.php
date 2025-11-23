<?php session_start(); ?>
<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>

<h2>Your Cart</h2>

<?php if (empty($_SESSION['cart'])): ?>
<p>No items in cart.</p>
<?php else: ?>

<table class="table">
<tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr>

<?php 
$grand = 0;
foreach ($_SESSION['cart'] as $id => $qty):
    $p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
    $total = $qty * $p['price'];
    $grand += $total;
?>
<tr>
    <td><?= $p['title'] ?></td>
    <td><?= $qty ?></td>
    <td><?= $p['price'] ?></td>
    <td><?= $total ?></td>
</tr>
<?php endforeach; ?>

</table>

<h3>Total: <?= $grand ?> BDT</h3>

<a href="checkout.php" class="btn">Checkout</a>

<?php endif; ?>

<?php include "includes/footer.php"; ?>
