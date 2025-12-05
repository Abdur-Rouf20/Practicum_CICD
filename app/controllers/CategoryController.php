<?php

require_once __DIR__ . '/../helpers/utils.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $category;

    public function __construct()
    {
        $db = require __DIR__ . '/../config/db.php';
        $this->category = new Category($db);
    }

    public function store($data)
    {
        $name        = sanitize($data['name']);
        $description = sanitize($data['description'] ?? null);
        $parent_id   = !empty($data['parent_id']) ? intval($data['parent_id']) : null;

        if (!$name) {
            set_flash("Category name is required!", "danger");
            redirect("add-category.php");
        }

        $slug = $this->slugify($name);

        if ($this->category->create($name, $description, $parent_id, $slug)) {
            set_flash("Category created successfully!", "success");
        } else {
            set_flash("Failed to create category.", "danger");
        }

        redirect("categories.php");
    }

    public function delete($id)
    {
        $id = (int)$id;

        if ($this->category->hasProducts($id)) {
            set_flash("Cannot delete category because products exist!", "danger");
            redirect("categories.php");
        }

        $this->category->deleteCategory($id);
        set_flash("Category deleted!", "success");

        redirect("categories.php");
    }

    public function listPage()
    {
        $search = $_GET['search'] ?? "";
        $parent = $_GET['parent'] ?? "";

        $limit = 10;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $limit;

        return [
            "categories" => $this->category->getCategories($limit, $offset, $search, $parent),
            "parents"    => $this->category->getParents(),
            "total"      => $this->category->countCategories($search, $parent),
            "limit"      => $limit,
            "page"       => $page
        ];
    }

    private function slugify($text)
    {
        $text = trim(strtolower($text));
        return preg_replace("/[^a-z0-9]+/", "-", $text);
    }
}
