<?php
// Placeholder: Payment.php
<?php
require_once __DIR__ . "/../../config/db.php";

class Payment
{
    public static function log($order_id, $amount, $method, $status)
    {
        global $conn;
        $sql = "INSERT INTO payments (order_id, amount, method, status)
                VALUES ('$order_id', '$amount', '$method', '$status')";
        return mysqli_query($conn, $sql);
    }
}
