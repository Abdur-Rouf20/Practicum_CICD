<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php 
$slug = $_GET['slug'] ?? '';

$cat = $conn->prepare("SELECT id,name FROM categories WHERE slug=?");
$cat->bind_param("s",$slug);
$cat->execute();
$c = $cat->get_result()->fetch_assoc();

if (!$c) { echo "Category Not Found"; exit; }

?>

<h2><?= $c['name'] ?></h2>

<div class="products">
<?php
$p = $conn->prepare("SELECT * FROM products WHERE category_id=?");
$p->bind_param("i",$c['id']);
$p->execute();
$products = $p->get_result();
while ($prod = $products->fetch_assoc()) {
?>
    <div class="product-card">
        <a href="product.php?id=<?= $prod['id'] ?>">
            <img src="../uploads/<?= $prod['image'] ?>">
            <h3><?= $prod['title'] ?></h3>
            <p><?= $prod['price'] ?> BDT</p>
        </a>
    </div>
<?php } ?>
</div>

<?php include "includes/footer.php"; ?>
