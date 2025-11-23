<?php session_start(); ?>
<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php if (!isset($_SESSION['user_id'])) header("Location: login.php"); ?>

<h2>Checkout</h2>

<form method="POST">
    <label>Shipping Address</label>
    <textarea name="address" required></textarea>

    <button type="submit" name="place_order">Place Order</button>
</form>

<?php
if (isset($_POST['place_order'])) {
    $uid = $_SESSION['user_id'];
    $address = $_POST['address'];
    $total = 0;

    foreach ($_SESSION['cart'] as $id=>$qty) {
        $p = $conn->query("SELECT price FROM products WHERE id=$id")->fetch_assoc();
        $total += $p['price'] * $qty;
    }

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, address) VALUES (?,?,?)");
    $stmt->bind_param("ids", $uid,$total,$address);
    $stmt->execute();

    $_SESSION['cart'] = [];
    header("Location: orders.php?success=1");
}
?>

<?php include "includes/footer.php"; ?>
