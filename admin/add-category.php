<?php
session_start();
require_once "../app/helpers/auth.php";
require_admin(); // ensure only admin can access

require_once "../app/helpers/utils.php";
require_once "../app/controllers/CategoryController.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CategoryController();
    $controller->store($_POST);
}
?>

<?php include "includes/admin_header.php"; ?>
<?php include "includes/admin_sidebar.php"; ?>

<div class="content-wrapper p-4">

    <h2 class="mb-4">Add New Category</h2>

    <?php if ($flash = get_flash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= $flash['msg'] ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group mb-3">
            <label>Category Name</label>
            <input type="text" name="name" class="form-control" required />
        </div>

        <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Create Category</button>
    </form>

</div>

<?php include "includes/admin_footer.php"; ?>
