<?php
require_once __DIR__ . '/includes/seller_auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/utils.php';
include __DIR__ . '/../includes/header.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if ($name === '') $errors[] = "Name required.";

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE users SET name=?, phone=?, address=?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param('sssi', $name, $phone, $address, $seller_id);
        $stmt->execute();
        set_flash("Profile updated", "success");
        header("Location: profile.php");
        exit;
    }
}

// fetch current seller info
$stmt = $conn->prepare("SELECT name, email, phone, address FROM users WHERE id = ?");
$stmt->bind_param('i', $seller_id);
$stmt->execute();
$seller = $stmt->get_result()->fetch_assoc();
?>

<div class="container mt-4">
    <h3>Profile</h3>

    <?php if ($errors): ?>
        <div class="alert alert-error"><ul><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul></div>
    <?php endif; ?>

    <?php if ($msg = get_flash()): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" value="<?= htmlspecialchars($seller['name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Email (readonly)</label>
            <input class="form-control" readonly value="<?= htmlspecialchars($seller['email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone" class="form-control" value="<?= htmlspecialchars($seller['phone'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control"><?= htmlspecialchars($seller['address'] ?? '') ?></textarea>
        </div>

        <button class="btn btn-primary">Save Profile</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
