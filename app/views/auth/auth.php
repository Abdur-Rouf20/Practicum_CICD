<?php
session_start();

// If already logged in → redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: /admin/dashboard.php");
    exit;
}

// Read flashed error message
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/auth/login" method="POST">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required placeholder="admin@example.com">
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required placeholder="********">
        </div>

        <button type="submit" class="btn-primary">Login</button>
    </form>
</div>

</body>
</html>
