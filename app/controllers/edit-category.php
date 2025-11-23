<?php
session_start();

require_once "../app/helpers/auth.php";
require_admin();

require_once "../app/helpers/utils.php";
require_once "../app/config/db.php";
require_once "../app/models/Category.php";
require_once "../app/controllers/CategoryController.php";

$db = (new Database())->connect();
$categoryModel = new Category($db);

if (!isset($_GET['id'])) {
    redirect("categories.php");
}

$id = (int) $_GET['id'];
$category = $categoryModel->find($id);

if (!$category) {
    set_flash("Category not found!", "danger");
    redirect("categories.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CategoryController();
    $controller->update($_POST);
}
?>

<?php include "includes/admin_header.php"; ?>
<?php include "includes/admin_sidebar.php"; ?>

<div class="content-wrapper p-4">

    <h2 class="mb-4">Edit Category</h2>

    <?php if ($flash = get_flash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= $flash['msg'] ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $category['id'] ?>">

        <div class="form-group mb-3">
            <label>Category Name</label>
            <input type="text" name="name" class="form-control"
                   value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>

        <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($category['description']) ?></textarea>
        </div>

        <button class="btn btn-primary">Update Category</button>
        <a href="categories.php" class="btn btn-secondary">Back</a>
    </form>

</div>

<?php include "includes/admin_footer.php"; ?>
