<?php
require_once __DIR__ . '/includes/seller_auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/utils.php';

include __DIR__ . '/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['action'])) {
    $order_id = intval($_POST['order_id']);
    $action = $_POST['action']; // e.g., 'delivered' or 'shipped' or 'rejected'
    // Update order status for this seller's items only by adding a note and optionally changing global order status.
    $stmt = $conn->prepare("INSERT INTO order_notes (order_id, user_id, role, note, action, created_at) VALUES (?, ?, 'seller', ?, ?, NOW())");
    $note = "Seller marked as: " . $action;
    $stmt->bind_param('iiss', $order_id, $seller_id, $note, $action);
    $stmt->execute();
    set_flash("Order updated.");
    header("Location: orders.php");
    exit;
}
?>

<div class="container mt-4">
    <h3>Orders Including Your Products</h3>

    <?php if ($msg = get_flash()): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <table class="table table-striped">
        <thead><tr><th>#</th><th>Order #</th><th>Buyer</th><th>Items (yours)</th><th>Total</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        <?php
        $sql = "SELECT DISTINCT o.id, o.order_number, o.total_amount, o.order_status, u.name as buyer_name
                FROM orders o
                JOIN order_items oi ON oi.order_id = o.id
                LEFT JOIN users u ON u.id = o.user_id
                WHERE oi.seller_id = ?
                ORDER BY o.id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $seller_id);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_assoc()):
            // fetch items for this seller in the order
            $sql2 = "SELECT product_id, unit_price, quantity FROM order_items WHERE order_id = ? AND seller_id = ?";
            $s2 = $conn->prepare($sql2);
            $s2->bind_param('ii', $row['id'], $seller_id);
            $s2->execute();
            $items = $s2->get_result();
        ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['order_number'] ?></td>
                <td><?= htmlspecialchars($row['buyer_name']) ?></td>
                <td>
                    <ul>
                        <?php while ($it = $items->fetch_assoc()): ?>
                            <li>Product #<?= $it['product_id'] ?> — <?= $it['quantity'] ?> × <?= $it['unit_price'] ?></li>
                        <?php endwhile; ?>
                    </ul>
                </td>
                <td><?= $row['total_amount'] ?></td>
                <td><?= ucfirst($row['order_status']) ?></td>
                <td>
                    <form method="POST" style="display:inline-block">
                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                        <select name="action" required>
                            <option value="">Change status</option>
                            <option value="shipped">Mark Shipped</option>
                            <option value="delivered">Mark Delivered</option>
                            <option value="seller_rejected">Reject</option>
                        </select>
                        <button class="btn btn-sm btn-primary" type="submit">Save</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
