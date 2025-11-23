<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>

<h2>Create Account</h2>

<form method="POST">

<label>Name</label>
<input type="text" name="name" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Password</label>
<input type="password" name="password" required>

<button type="submit" name="register">Register</button>
</form>

<?php
if (isset($_POST['register'])) {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=password_hash($_POST['password'],PASSWORD_BCRYPT);

    $stmt=$conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss",$name,$email,$pass);

    if($stmt->execute()){
        header("Location: login.php");
    }
}
?>

<?php include "includes/footer.php"; ?>
