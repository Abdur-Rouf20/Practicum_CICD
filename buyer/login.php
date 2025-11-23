<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>

<h2>Login</h2>

<form method="POST">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit" name="login">Login</button>
</form>

<?php
if (isset($_POST['login'])) {
    $email=$_POST['email'];
    $pass=$_POST['password'];

    $u = $conn->prepare("SELECT * FROM users WHERE email=?");
    $u->bind_param("s",$email);
    $u->execute();
    $user = $u->get_result()->fetch_assoc();

    if ($user && password_verify($pass,$user['password'])) {
        $_SESSION['user_id']=$user['id'];
        $_SESSION['user_name']=$user['name'];
        $_SESSION['user_email']=$user['email'];
        header("Location: index.php");
    } else {
        echo "<p>Invalid login!</p>";
    }
}
?>

<?php include "includes/footer.php"; ?>
