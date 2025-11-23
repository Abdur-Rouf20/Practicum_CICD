<?php
session_start();

require_once "app/helpers/utils.php";
require_once "app/controllers/AuthController.php";

$auth = new AuthController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $auth->login($_POST);
}
?>

<?php include "app/views/partials/header.php"; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Admin Login</h4>
                </div>

                <div class="card-body">
                    <?php if (has_flash()): ?>
                        <div class="alert alert-danger"><?= get_flash(); ?></div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control" 
                                placeholder="admin@example.com"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                class="form-control"
                                required>
                        </div>

                        <button class="btn btn-primary w-100 mt-2">Login</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include "app/views/partials/footer.php"; ?>
