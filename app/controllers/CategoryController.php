$search = $_GET['search'] ?? "";
$parent = $_GET['parent'] ?? "";
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$total = Category::countAll($search, $parent);
$totalPages = ceil($total / $limit);

$categories = Category::getPaginated($limit, $offset, $search, $parent);
$parents = Category::getAllParents();

<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $db;
    private $categoryModel;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        $this->categoryModel = new Category($this->db);
    }

    public function store($data)
    {
        $name = sanitize($data['name']);
        $description = sanitize($data['description']);

        if (empty($name)) {
            set_flash("Name is required", "danger");
            redirect("../add-category.php");
        }

        $this->categoryModel->create($name, $description);

        set_flash("Category created successfully", "success");
        redirect("../categories.php");
    }
}
public function delete($id)
{
    $id = (int)$id;

    // Check if category is used
    if ($this->categoryModel->hasProducts($id)) {
        set_flash("Cannot delete! Products exist under this category.", "danger");
        redirect("../categories.php");
    }

    $this->categoryModel->deleteCategory($id);

    set_flash("Category deleted successfully", "success");
    redirect("../categories.php");
}
public function listPage()
{
    $search = $_GET['search'] ?? null;
    $parentFilter = $_GET['parent'] ?? null;

    $limit = 10;
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $limit;

    $total = $this->categoryModel->countCategories($search, $parentFilter);
    $categories = $this->categoryModel->getCategories($limit, $offset, $search, $parentFilter);
    $parents = $this->categoryModel->getParents();

    return [
        "categories" => $categories,
        "parents" => $parents,
        "total" => $total,
        "limit" => $limit,
        "page" => $page
    ];
}

<?php
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../helpers/slugify.php';

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : null;
    $slug = slugify($name);

    if (!$name) {
        $errors[] = "Category name is required.";
    }

    if (Category::exists($slug)) {
        $errors[] = "Category already exists.";
    }

    if (empty($errors)) {
        $saved = Category::insert($name, $slug, $parent_id);

        if ($saved) {
            $success = "Category added successfully!";
        } else {
            $errors[] = "Failed to save category. Try again.";
        }
    }
}

$parents = Category::getAllParents();
