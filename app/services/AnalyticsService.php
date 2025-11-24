<?php
// Placeholder: AnalyticsService.php
<?php

class AnalyticsService
{
    public static function dailySales()
    {
        global $conn;
        $sql = "SELECT DATE(created_at) AS day, SUM(total_amount) AS total 
                FROM orders GROUP BY DATE(created_at)";
        return mysqli_query($conn, $sql);
    }

    public static function topProducts()
    {
        global $conn;
        $sql = "SELECT p.name, COUNT(o.id) as total 
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                JOIN orders o ON oi.order_id = o.id
                GROUP BY oi.product_id ORDER BY total DESC LIMIT 5";
        return mysqli_query($conn, $sql);
    }
}
