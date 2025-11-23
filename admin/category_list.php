<?php include '../../includes/header.php'; ?>
<?php include '../../controllers/CategoryController.php'; ?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4 class="mb-0">Category List</h4>
            <a href="add.php" class="btn btn-light btn-sm">+ Add Category</a>
        </div>

        <div class="card-body">

            <!-- Filters Row -->
            <form method="GET" class="row mb-4">

                <div class="col-md-4">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control"
                        placeholder="Search category..."
                        value="<?= $search ?>">
                </div>

                <div class="col-md-4">
                    <select name="parent" class="form-control">
                        <option value="">All Categories</option>
                        <option value="parent" <?= $parent == "parent" ? "selected" : "" ?>>Only Parent Categories</option>

                        <?php foreach ($parents as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= $parent == $p['id'] ? "selected" : "" ?>>
                                <?= $p['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>

                <div class="col-md-2">
                    <a href="list.php" class="btn btn-secondary w-100">Reset</a>
                </div>

            </form>

            <!-- Category Table -->
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-danger">No categories found</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($categories as $index => $cat): ?>
                        <tr>
                            <td><?= $offset + $index + 1 ?></td>
                            <td><?= $cat['name'] ?></td>
                            <td><?= $cat['slug'] ?></td>
                            <td><?= $cat['parent_name'] ?: '<span class="badge bg-info">Parent</span>' ?></td>

                            <td>
                                <a href="edit.php?id=<?= $cat['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $cat['id'] ?>" 
                                   onclick="return confirm('Delete this category?')"
                                   class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav class="mt-3">
                <ul class="pagination justify-content-center">

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>&parent=<?= $parent ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                </ul>
            </nav>

        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
