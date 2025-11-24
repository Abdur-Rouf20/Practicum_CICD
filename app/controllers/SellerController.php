<?php
// Placeholder: SellerController.php
<?php
require_once __DIR__ . "/../helpers/db.php";
require_once __DIR__ . "/../helpers/auth.php";

class SellerController
{
    public static function dashboard()
    {
        auth_require_role('seller');

        include __DIR__ . "/../views/seller/dashboard.php";
    }

    public static function earnings()
    {
        auth_require_role('seller');

        include __DIR__ . "/../views/seller/earnings.php";
    }

    public static function profile()
    {
        auth_require_role('seller');

        include __DIR__ . "/../views/seller/profile.php";
    }

    public static function updateProfile()
    {
        auth_require_role('seller');
        include __DIR__ . "/../models/User.php";

        User::updateProfile($_SESSION['user_id'], $_POST, $_FILES);

        header("Location: /seller/profile.php?updated=1");
        exit;
    }
}
