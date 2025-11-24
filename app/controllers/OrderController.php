<?php
// Placeholder: OrderController.php
<?php
require_once __DIR__ . "/../helpers/db.php";
require_once __DIR__ . "/../helpers/auth.php";

class OrderController
{
    public static function sellerOrders()
    {
        auth_require_role('seller');

        include __DIR__ . "/../views/seller/orders/order-list.php";
    }

    public static function buyerOrders()
    {
        auth_require_role('buyer');

        include __DIR__ . "/../views/buyer/orders/order-history.php";
    }

    public static function adminOrders()
    {
        auth_require_role('admin');

        include __DIR__ . "/../views/admin/orders/orders.php";
    }

    public static function updateStatus()
    {
        auth_require_role(['admin', 'seller']);
        include __DIR__ . "/../models/Order.php";

        Order::updateStatus($_POST['order_id'], $_POST['status']);

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
