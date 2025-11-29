<?php
// Placeholder: CartController.php
<?php
require_once __DIR__ . "/../models/Product.php";

class CartController
{
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];
        include __DIR__ . "/../views/pages/cart.php";
    }

    public function add($id)
    {
        $product = Product::find($id);

        if (!$product) return;

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                "id" => $id,
                "name" => $product['name'],
                "price" => $product['price'],
                "qty" => 1
            ];
        } else {
            $_SESSION['cart'][$id]['qty']++;
        }

        header("Location: /cart");
    }

    public function remove($id)
    {
        unset($_SESSION['cart'][$id]);
        header("Location: /cart");
    }

    public function clear()
    {
        unset($_SESSION['cart']);
        header("Location: /cart");
    }
}
