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
<?php include '../../includes/header.php'; ?>
<?php include '../../controllers/CategoryController.php'; ?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Add New Category</h4>
        </div>

        <div class="card-body">

            <!-- Success Message -->
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <!-- Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $err): ?>
                            <li><?= $err ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="" method="POST">

                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control" 
                        id="categoryName"
                        placeholder="Enter category name"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Auto Slug</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="categorySlug"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Parent Category (optional)</label>
                    <select name="parent_id" class="form-control">
                        <option value="">No Parent</option>
                        <?php foreach ($parents as $parent): ?>
                            <option value="<?= $parent['id'] ?>"><?= $parent['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-primary">Add Category</button>
            </form>
        </div>
    </div>
</div>

<script>
    function slugify(text) {
        return text
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
    }

    document.getElementById("categoryName").addEventListener("keyup", function () {
        document.getElementById("categorySlug").value = slugify(this.value);
    });
</script>

<?php include '../../includes/footer.php'; ?>
