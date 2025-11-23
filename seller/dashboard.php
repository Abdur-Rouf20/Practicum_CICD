<?php
require_once __DIR__ . '/includes/seller_auth.php';
require_once __DIR__ . '/../includes/db.php'; // mysqli $conn
require_once __DIR__ . '/../includes/utils.php'; // getCount(), get_flash()

$title = "Seller Dashboard";
include __DIR__ . '/../includes/header.php';
?>

<div class="container mt-4">
    <h2>Seller Dashboard</h2>
    <p>Welcome, <?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['user_name'] ?? 'Seller') ?>.</p>

    <div class="grid grid-3" style="gap:20px; margin-top:20px;">
        <div class="card">
            <h3>Your Products</h3>
            <p><?php
                $sql = "SELECT COUNT(*) as c FROM products WHERE seller_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $seller_id);
                $stmt->execute();
                $res = $stmt->get_result()->fetch_assoc();
                echo $res['c'];
            ?></p>
        </div>

        <div class="card">
            <h3>Orders</h3>
            <p><?php
                $sql = "SELECT COUNT(DISTINCT o.id) as c FROM orders o
                        JOIN order_items oi ON oi.order_id = o.id
                        WHERE oi.seller_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $seller_id);
                $stmt->execute();
                $res = $stmt->get_result()->fetch_assoc();
                echo $res['c'];
            ?></p>
        </div>

        <div class="card">
            <h3>Available Qty</h3>
            <p><?php
                $sql = "SELECT IFNULL(SUM(quantity),0) as totalq FROM products WHERE seller_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $seller_id);
                $stmt->execute();
                $res = $stmt->get_result()->fetch_assoc();
                echo $res['totalq'];
            ?></p>
        </div>
    </div>

    <h3 style="margin-top:30px;">Recent Orders</h3>

    <table class="table" style="width:100%; background:#fff;">
        <tr><th>ID</th><th>Order #</th><th>Buyer</th><th>Total (BDT)</th><th>Status</th><th>Date</th></tr>

        <?php
        $sql = "SELECT DISTINCT o.id, o.order_number, o.total_amount, o.order_status, o.created_at, u.name as buyer_name
                FROM orders o
                JOIN order_items oi ON oi.order_id = o.id
                LEFT JOIN users u ON u.id = o.user_id
                WHERE oi.seller_id = ?
                ORDER BY o.id DESC LIMIT 8";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $seller_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['order_number']) ?></td>
                <td><?= htmlspecialchars($row['buyer_name'] ?: '—') ?></td>
                <td><?= $row['total_amount'] ?></td>
                <td><?= ucfirst($row['order_status']) ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
