<?php

class Category
{
    private $conn;
    private $table = "categories";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Create category
     */
    public function create($name, $description, $parent_id, $slug)
    {
        $query = "INSERT INTO {$this->table} (name, slug, parent_id, description)
                  VALUES (:name, :slug, :parent_id, :description)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':name'        => $name,
            ':slug'        => $slug,
            ':parent_id'   => $parent_id,
            ':description' => $description
        ]);
    }

    /**
     * Check if category has products
     */
    public function hasProducts($id)
    {
        $query = "SELECT COUNT(*) FROM products 
                  WHERE category_id = :id OR subcategory_id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Delete category
     */
    public function deleteCategory($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt  = $this->conn->prepare($query);

        return $stmt->execute([':id' => $id]);
    }

    /**
     * Pagination + Search + Filter
     */
    public function getCategories($limit, $offset, $search = null, $parent = null)
    {
        $sql = "SELECT c.*, 
                (SELECT name FROM categories WHERE id = c.parent_id) AS parent_name
                FROM categories c WHERE 1";

        $params = [];

        if ($search) {
            $sql .= " AND c.name LIKE :search";
            $params[':search'] = "%$search%";
        }

        if ($parent !== null && $parent !== "") {
            if ($parent == "parent") {
                $sql .= " AND c.parent_id IS NULL";
            } else {
                $sql .= " AND c.parent_id = :parent";
                $params[':parent'] = $parent;
            }
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

    /**
     * Count categories
     */
    public function countCategories($search = null, $parent = null)
    {
        $sql = "SELECT COUNT(*) FROM categories WHERE 1";
        $params = [];

        if ($search) {
            $sql .= " AND name LIKE :search";
            $params[':search'] = "%$search%";
        }

        if ($parent !== null && $parent !== "") {
            if ($parent == "parent") {
                $sql .= " AND parent_id IS NULL";
            } else {
                $sql .= " AND parent_id = :parent";
                $params[':parent'] = $parent;
            }
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn();
    }

    /**
     * Get only parent categories
     */
    public function getParents()
    {
        $stmt = $this->conn->query(
            "SELECT id, name FROM categories WHERE parent_id IS NULL ORDER BY name ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
