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
