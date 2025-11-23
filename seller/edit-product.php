<?php 
include "../config/db.php";
include "includes/auth_seller.php";

$product_id = $_GET['id'] ?? 0;

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id=? AND seller_id=?");
$stmt->bind_param("ii", $product_id, $_SESSION['seller_id']);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "Invalid Product!";
    exit;
}

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $_POST['description'];

    $update = $conn->prepare("UPDATE products SET title=?, category_id=?, price=?, stock=?, description=? WHERE id=? AND seller_id=?");
    $update->bind_param("sidiisi", $title, $category, $price, $stock, $desc, $product_id, $_SESSION['seller_id']);

    if ($update->execute()) {
        header("Location: product-list.php?updated=1");
    }
}

?>

<?php include "includes/header.php"; ?>
<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Product Title</label>
    <input type="text" name="title" value="<?= $product['title'] ?>" required>

    <label>Category</label>
    <select name="category_id">
        <?php
        $cat = $conn->query("SELECT id,name FROM categories ORDER BY name");
        while($c = $cat->fetch_assoc()) {
            echo "<option value='{$c['id']}' ".($product['category_id']==$c['id']?"selected":"").">{$c['name']}</option>";
        }
        ?>
    </select>

    <label>Price (BDT)</label>
    <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>">

    <label>Stock</label>
    <input type="number" name="stock" value="<?= $product['stock'] ?>">

    <label>Description</label>
    <textarea name="description"><?= $product['description'] ?></textarea>

    <button type="submit">Update Product</button>

</form>

<?php include "includes/footer.php"; ?>
