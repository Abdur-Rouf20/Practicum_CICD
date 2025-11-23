<?php include "../config/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/auth_check.php"; ?>

<h2>Your Profile</h2>

<p>Name: <?= $_SESSION['user_name'] ?></p>
<p>Email: <?= $_SESSION['user_email'] ?></p>

<a href="logout.php" class="btn">Logout</a>

<?php include "includes/footer.php"; ?>
