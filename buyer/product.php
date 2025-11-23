<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php 
$id = $_GET['id'];
$p = $conn->prepare("SELECT * FROM products WHERE id=?");
$p->bind_param("i",$id);
$p->execute();
$product = $p->get_result()->fetch_assoc();
?>

<h2><?= $product['title'] ?></h2>

<img src="../uploads/<?= $product['image'] ?>" width="300">

<p><b>Price:</b> <?= $product['price'] ?> BDT</p>

<form method="POST" action="cart.php?action=add&id=<?= $product['id'] ?>">
    <input type="number" name="qty" value="1" min="1">
    <button type="submit">Add to Cart</button>
</form>

<p><?= $product['description'] ?></p>

<?php include "includes/footer.php"; ?>
