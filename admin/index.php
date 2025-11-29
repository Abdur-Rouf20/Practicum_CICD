<?php
session_start();
require_once "app/helpers/auth.php";
?>
<?php include "app/views/partials/header.php"; ?>

<div class="container mt-5">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">

            <h1 class="fw-bold mb-3">Welcome to NextGen Electronics</h1>
            <p class="lead text-muted">
                This is your new e-commerce platform.  
                Use the admin login to manage categories, products, and users.
            </p>

            <a href="/admin/login.php" class="btn btn-primary btn-lg mt-3">Admin Login</a>
        </div>
    </div>
</div>

<?php include "app/views/partials/footer.php"; ?>
