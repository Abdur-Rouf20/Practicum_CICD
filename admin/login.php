<?php
session_start();
require_once __DIR__ . "\..\app\config\config.php";  // BASE_URL defined here
$pdo = require __DIR__ . "\..\app\helpers\db.php";    // PDO connection

$message = "";

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch admin user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin' LIMIT 1");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        // Set session values
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['admin_email'] = $admin['email'];

        // Redirect to dashboard
        header("Location: " . BASE_URL . "/admin/dashboard.php");
        exit;
    } else {
        $message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/main.css">

    <style>
        body {
            background: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            width: 380px;
            padding: 35px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.1);
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { font-weight: bold; }
        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            border-radius: 5px;
            border: 0;
            margin-top: 15px;
            cursor: pointer;
        }
        .btn-login:hover { background: #0056d6; }
        .error {
            background: #ffdddd;
            padding: 10px;
            border-left: 4px solid red;
            margin-bottom: 15px;
            color: #c00;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>

    <?php if ($message != ""): ?>
        <div class="error"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required placeholder="admin@example.com">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="*******">
        </div>

        <button type="submit" class="btn-login">Login</button>

    </form>
</div>

</body>
</html>
