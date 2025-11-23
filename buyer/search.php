<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php $q = $_GET['q'] ?? ""; ?>

<h2>Search Results for "<?= $q ?>"</h2>

<div class="products">
<?php
$stmt = $conn->prepare("SELECT * FROM products WHERE title LIKE ?");
$like = "%".$q."%";
$stmt->bind_param("s",$like);
$stmt->execute();
$r = $stmt->get_result();

while($p=$r->fetch_assoc()){
?>
<div class="product-card">
    <a href="product.php?id=<?= $p['id'] ?>">
        <img src="../uploads/<?= $p['image'] ?>">
        <h3><?= $p['title'] ?></h3>
        <p><?= $p['price'] ?> BDT</p>
    </a>
</div>
<?php } ?>
</div>

<?php include "includes/footer.php"; ?>
