<?php
// Placeholder: ProductController.php
<?php
require_once __DIR__ . "/../helpers/db.php";
require_once __DIR__ . "/../helpers/auth.php";

class ProductController
{
    public static function listSellerProducts()
    {
        auth_require_role('seller');

        include __DIR__ . "/../views/seller/products/product-list.php";
    }

    public static function addProductPage()
    {
        auth_require_role('seller');

        include __DIR__ . "/../views/seller/products/add-product.php";
    }

    public static function saveProduct()
    {
        auth_require_role('seller');
        include __DIR__ . "/../models/Product.php";

        Product::create($_POST, $_FILES);

        header("Location: /seller/products.php?success=1");
        exit;
    }

    public static function editProductPage($id)
    {
        auth_require_role('seller');
        include __DIR__ . "/../models/Product.php";

        $product = Product::find($id);
        include __DIR__ . "/../views/seller/products/edit-product.php";
    }

    public static function updateProduct($id)
    {
        auth_require_role('seller');
        include __DIR__ . "/../models/Product.php";

        Product::update($id, $_POST, $_FILES);

        header("Location: /seller/products.php?updated=1");
        exit;
    }

    public static function delete($id)
    {
        auth_require_role('seller');
        include __DIR__ . "/../models/Product.php";

        Product::delete($id);

        header("Location: /seller/products.php?deleted=1");
        exit;
    }
}
