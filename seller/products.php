<?php
require_once __DIR__ . '/includes/seller_auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/utils.php';

include __DIR__ . '/../includes/header.php';
?>

<div class="container mt-4">
    <h3>Your Products</h3>

    <?php if ($msg = get_flash()): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <a href="add-product.php" class="btn btn-primary mb-3">+ Add Product</a>

    <table class="table table-bordered">
        <thead><tr><th>#</th><th>Title</th><th>Price</th><th>Qty</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php
        $sql = "SELECT p.*, pi.file_path
                FROM products p
                LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
                WHERE p.seller_id = ?
                ORDER BY p.id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $seller_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $i = 1;
        while ($row = $res->fetch_assoc()):
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= ucfirst($row['product_status']) ?></td>
                <td>
                    <a class="btn btn-sm btn-warning" href="edit-product.php?id=<?= $row['id'] ?>">Edit</a>
                    <a class="btn btn-sm btn-danger" href="delete-product.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete product?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
