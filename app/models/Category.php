
// Placeholder: Category.php

<?php

class Category
{
    private $conn;
    private $table = "categories";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($name, $description)
    {
        $query = "INSERT INTO {$this->table} (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':name' => $name,
            ':description' => $description
        ]);
    }

    public function all()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
public function hasProducts($id)
{
    $query = "SELECT COUNT(*) FROM products WHERE category_id = :id OR subcategory_id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([':id' => $id]);
    return $stmt->fetchColumn() > 0;
}

public function deleteCategory($id)
{
    $query = "DELETE FROM {$this->table} WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}
public function getCategories($limit, $offset, $search = null, $parentFilter = null)
{
    $sql = "SELECT c.*, p.name AS parent_name
            FROM categories c
            LEFT JOIN categories p ON p.id = c.parent_id
            WHERE 1 ";

    $params = [];

    if ($search) {
        $sql .= " AND c.name LIKE :search ";
        $params[':search'] = "%$search%";
    }

    if ($parentFilter) {
        $sql .= " AND c.parent_id = :parentFilter ";
        $params[':parentFilter'] = $parentFilter;
    }

    $sql .= " ORDER BY c.id DESC LIMIT :limit OFFSET :offset";

    $stmt = $this->conn->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countCategories($search = null, $parentFilter = null)
{
    $sql = "SELECT COUNT(*) FROM categories WHERE 1 ";
    $params = [];

    if ($search) {
        $sql .= " AND name LIKE :search ";
        $params[':search'] = "%$search%";
    }

    if ($parentFilter) {
        $sql .= " AND parent_id = :parentFilter ";
        $params[':parentFilter'] = $parentFilter;
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

public function getParents()
{
    $query = "SELECT id, name FROM categories WHERE parent_id IS NULL ORDER BY name ASC";
    return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

<?php
require_once __DIR__ . '/../config/db.php';

class Category
{
    public static function getAllParents()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($name, $slug, $parent_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO categories (name, slug, parent_id) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $slug, $parent_id]);
    }

    public static function exists($slug)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM categories WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
}
public static function countAll($search = null, $parent = null)
{
    global $pdo;
    $sql = "SELECT COUNT(*) FROM categories WHERE 1";

    $params = [];

    if ($search) {
        $sql .= " AND name LIKE ?";
        $params[] = "%$search%";
    }

    if ($parent !== null && $parent !== "") {
        if ($parent == "parent") {
            $sql .= " AND parent_id IS NULL";
        } else {
            $sql .= " AND parent_id = ?";
            $params[] = $parent;
        }
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

public static function getPaginated($limit, $offset, $search = null, $parent = null)
{
    global $pdo;

    $sql = "SELECT c.*, 
            (SELECT name FROM categories WHERE id = c.parent_id) AS parent_name
            FROM categories c WHERE 1";

    $params = [];

    if ($search) {
        $sql .= " AND c.name LIKE ?";
        $params[] = "%$search%";
    }

    if ($parent !== null && $parent !== "") {
        if ($parent == "parent") {
            $sql .= " AND c.parent_id IS NULL";
        } else {
            $sql .= " AND c.parent_id = ?";
            $params[] = $parent;
        }
    }

    $sql .= " ORDER BY c.id DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
