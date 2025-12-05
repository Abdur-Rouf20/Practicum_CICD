<?php
session_start();
require_once "auth_check.php";

require_once "../app/helpers/utils.php";
require_once "../app/controllers/CategoryController.php";

$controller = new CategoryController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->store($_POST);
}

$parents = $controller->listPage()['parents'];

include "includes/admin_header.php";
include "includes/admin_sidebar.php";
?>

<div class="content-wrapper p-4">
    <h2>Add New Category</h2>

    <?php if ($flash = get_flash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>"><?= $flash['msg'] ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group mb-3">
            <label>Category Name</label>
            <input type="text" name="name" id="categoryName" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group mb-3">
            <label>Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="">No Parent</option>
                <?php foreach ($parents as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-primary">Create Category</button>
    </form>
</div>

<?php include "includes/admin_footer.php"; ?>
