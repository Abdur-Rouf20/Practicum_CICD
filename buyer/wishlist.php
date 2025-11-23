<?php session_start(); ?>
<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>

<h2>Your Wishlist</h2>

<?php if (empty($_SESSION['wishlist'])): ?>
<p>No items in wishlist.</p>
<?php else: ?>

<div class="products">
<?php
foreach ($_SESSION['wishlist'] as $id):
    $p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
?>
<div class="product-card">
    <a href="product.php?id=<?= $p['id'] ?>">
        <img src="../uploads/<?= $p['image'] ?>">
        <h3><?= $p['title'] ?></h3>
        <p><?= $p['price'] ?> BDT</p>
    </a>
</div>
<?php endforeach; ?>
</div>

<?php endif; ?>

<?php include "includes/footer.php"; ?>
