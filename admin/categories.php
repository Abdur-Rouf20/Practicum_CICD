<?php  
session_start();
require_once "../app/helpers/auth.php";
require_admin();

require_once "../app/config/db.php";
require_once "../app/models/Category.php";
require_once "../app/controllers/CategoryController.php";
require_once "../partials/header.php";

$controller = new CategoryController();
$data = $controller->listPage();

$categories = $data['categories'];
$parents = $data['parents'];
$total = $data['total'];
$page = $data['page'];
$limit = $data['limit'];

$pages = ceil($total / $limit);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Categories</h3>
        <a href="add-category.php" class="btn btn-primary">Add Category</a>
    </div>

    <!-- Search + Filter -->
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="<?= $_GET['search'] ?? '' ?>"
                   class="form-control" placeholder="Search by name">
        </div>

        <div class="col-md-4">
            <select name="parent" class="form-control">
                <option value="">Filter by Parent</option>
                <?php foreach ($parents as $p): ?>
                    <option value="<?= $p['id'] ?>"
                        <?= (($_GET['parent'] ?? '') == $p['id']) ? 'selected' : '' ?>>
                        <?= $p['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-secondary w-100">Apply</button>
        </div>

        <div class="col-md-2">
            <a href="categories.php" class="btn btn-light w-100">Reset</a>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Parent</th>
                <th>Created</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= $c['name'] ?></td>
                <td><?= $c['slug'] ?></td>
                <td><?= $c['parent_name'] ?? '-' ?></td>
                <td><?= $c['created_at'] ?></td>
                <td>
                    <a href="edit-category.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Edit</a>

                    <a onclick="return confirmDelete();" 
                       href="category-delete.php?id=<?= $c['id'] ?>"
                       class="btn btn-sm btn-danger">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= $_GET['search'] ?? '' ?>&parent=<?= $_GET['parent'] ?? '' ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

</div>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this category?");
}
</script>

<?php require_once "../partials/footer.php"; ?>
