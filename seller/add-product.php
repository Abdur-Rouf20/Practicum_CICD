<?php
require_once __DIR__ . '/includes/seller_auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/utils.php';

$title = "Add Product";
include __DIR__ . '/../includes/header.php';

// load categories for dropdown
$cats = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_p = trim($_POST['title']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $description = trim($_POST['description']);
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(trim($title_p)));

    if ($title_p === '') $errors[] = "Product title required.";
    if ($price <= 0) $errors[] = "Price should be greater than 0.";
    if ($quantity < 0) $errors[] = "Invalid quantity.";

    // TODO: handle file uploads safely (resize, sanitize filename). Placeholder uses uploaded file name.
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fn = time() . '_' . basename($_FILES['image']['name']);
        $target = $uploadDir . $fn;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = 'uploads/' . $fn;
        } else {
            $errors[] = "Image upload failed.";
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO products (seller_id, category_id, title, slug, description, price, quantity, product_condition, product_status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'new', 'pending', NOW())");
        $stmt->bind_param('iisssdi', $seller_id, $category_id, $title_p, $slug, $description, $price, $quantity);
        $ok = $stmt->execute();
        $product_id = $stmt->insert_id;
        if ($ok) {
            if ($image_path) {
                $stmt2 = $conn->prepare("INSERT INTO product_images (product_id, file_path, is_primary, uploaded_at) VALUES (?, ?, 1, NOW())");
                $stmt2->bind_param('is', $product_id, $image_path);
                $stmt2->execute();
            }
            set_flash("Product added successfully and pending approval.", "success");
            header("Location: products.php");
            exit;
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
    }
}
?>

<div class="container mt-4">
    <h3>Add Product</h3>

    <?php if ($errors): ?>
        <div class="alert alert-error">
            <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <?php if ($msg = get_flash()): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Title</label>
            <input name="title" class="form-control" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">Select category</option>
                <?php while ($c = $cats->fetch_assoc()): ?>
                    <option value="<?= $c['id'] ?>" <?= (($_POST['category_id'] ?? '') == $c['id']) ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Price (BDT)</label>
            <input name="price" type="number" step="0.01" class="form-control" required value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input name="quantity" type="number" class="form-control" required value="<?= htmlspecialchars($_POST['quantity'] ?? '1') ?>">
        </div>

        <div class="form-group">
            <label>Image</label>
            <input name="image" type="file" accept="image/*" class="form-control">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <button class="btn btn-primary">Add Product</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
