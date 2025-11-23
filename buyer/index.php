<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>

<h2>Featured Products</h2>

<div class="products">
<?php
$result = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 12");
while ($p = $result->fetch_assoc()) {
?>
    <div class="product-card">
        <a href="product.php?id=<?= $p['id'] ?>">
            <img src="../uploads/<?= $p['image'] ?>" alt="">
            <h3><?= $p['title'] ?></h3>
            <p><?= $p['price'] ?> BDT</p>
        </a>
    </div>
<?php } ?>
</div>

<?php include "includes/footer.php"; ?>
