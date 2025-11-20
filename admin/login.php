<?php
session_start();
require_once "../config/db.php";  // Your database connection file

$message = "";

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin_users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);

        // Verify hashed password
        if (password_verify($password, $admin['password'])) {

            // set session values
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_email'] = $admin['email'];

            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="/assets/css/main.css">

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
        <div class="error"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required placeholder="admin@admin.com">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="*******">
        </div>

        <button class="btn-login">Login</button>

    </form>
</div>

</body>
</html>
