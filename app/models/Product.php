<?php
// Placeholder: Product.php
<?php
require_once __DIR__ . "/../../config/db.php";

class Product
{
    public static function all()
    {
        global $conn;
        $sql = "SELECT * FROM products ORDER BY id DESC";
        return mysqli_query($conn, $sql);
    }

    public static function find($id)
    {
        global $conn;
        $sql = "SELECT * FROM products WHERE id=$id";
        return mysqli_fetch_assoc(mysqli_query($conn, $sql));
    }

    public static function create($data)
    {
        global $conn;
        $name = $data['name'];
        $slug = $data['slug'];
        $price = $data['price'];
        $stock = $data['stock'];
        $seller_id = $data['seller_id'];
        $category_id = $data['category_id'];

        $sql = "INSERT INTO products (name, slug, price, stock, seller_id, category_id)
                VALUES ('$name', '$slug', '$price', '$stock', '$seller_id', '$category_id')";
        return mysqli_query($conn, $sql);
    }

    public static function update($id, $data)
    {
        global $conn;

        $name = $data['name'];
        $slug = $data['slug'];
        $price = $data['price'];
        $stock = $data['stock'];
        $category_id = $data['category_id'];

        $sql = "UPDATE products SET name='$name', slug='$slug', price='$price', stock='$stock',
                category_id='$category_id' WHERE id=$id";
        return mysqli_query($conn, $sql);
    }

    public static function delete($id)
    {
        global $conn;
        $sql = "DELETE FROM products WHERE id=$id";
        return mysqli_query($conn, $sql);
    }
}
