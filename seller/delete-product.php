<?php
include "../config/db.php";
include "includes/auth_seller.php";

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM products WHERE id=? AND seller_id=?");
$stmt->bind_param("ii", $id, $_SESSION['seller_id']);
$stmt->execute();

header("Location: product-list.php?deleted=1");
exit;
?>
