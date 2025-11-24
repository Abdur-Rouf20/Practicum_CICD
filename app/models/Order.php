<?php
// Placeholder: Order.php
<?php
require_once __DIR__ . "/../../config/db.php";

class Order
{
    public static function create($user_id, $total)
    {
        global $conn;
        $sql = "INSERT INTO orders (user_id, total_amount, status) 
                VALUES ('$user_id', '$total', 'pending')";
        mysqli_query($conn, $sql);

        return mysqli_insert_id($conn);
    }

    public static function getByUser($user_id)
    {
        global $conn;
        $sql = "SELECT * FROM orders WHERE user_id=$user_id ORDER BY id DESC";
        return mysqli_query($conn, $sql);
    }
}
