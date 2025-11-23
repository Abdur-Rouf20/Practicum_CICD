<?php
require_once __DIR__ . '/includes/seller_auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/utils.php';

include __DIR__ . '/../includes/header.php';
?>

<div class="container mt-4">
    <h3>Earnings</h3>

    <?php
    // total earnings from order_items where order is delivered or confirmed
    $sql = "SELECT IFNULL(SUM(oi.subtotal),0) as total_earnings
            FROM order_items oi
            JOIN orders o ON o.id = oi.order_id
            WHERE oi.seller_id = ? AND o.order_status IN ('delivered','confirmed')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $seller_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $total = $res['total_earnings'];
    ?>

    <div class="card p-3">
        <h4>Total Earnings: <?= number_format($total,2) ?> BDT</h4>
    </div>

    <h4 class="mt-4">Earnings by Month</h4>
    <table class="table">
        <thead><tr><th>Month</th><th>Earnings (BDT)</th></tr></thead>
        <tbody>
        <?php
        $sql2 = "SELECT DATE_FORMAT(o.created_at, '%Y-%m') as month, IFNULL(SUM(oi.subtotal),0) as msum
                 FROM order_items oi
                 JOIN orders o ON o.id = oi.order_id
                 WHERE oi.seller_id = ? AND o.order_status IN ('delivered','confirmed')
                 GROUP BY month ORDER BY month DESC LIMIT 12";
        $s2 = $conn->prepare($sql2);
        $s2->bind_param('i', $seller_id);
        $s2->execute();
        $r2 = $s2->get_result();
        while ($row = $r2->fetch_assoc()):
        ?>
            <tr>
                <td><?= $row['month'] ?></td>
                <td><?= number_format($row['msum'],2) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
