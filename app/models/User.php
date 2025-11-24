<?php
// Placeholder: User.php
<?php
require_once __DIR__ . "/../../config/db.php";

class User
{
    public static function find($id)
    {
        global $conn;
        $sql = "SELECT * FROM users WHERE id=$id";
        return mysqli_fetch_assoc(mysqli_query($conn, $sql));
    }

    public static function findByEmail($email)
    {
        global $conn;
        $sql = "SELECT * FROM users WHERE email='$email'";
        return mysqli_fetch_assoc(mysqli_query($conn, $sql));
    }
}
