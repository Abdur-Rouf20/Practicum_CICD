<?php
// Placeholder: AdminController.php
<?php
require_once __DIR__ . "/../helpers/db.php";
require_once __DIR__ . "/../helpers/auth.php";

class AdminController
{
    public function loginPage()
    {
        include __DIR__ . "/../views/auth/auth.php";
    }

    public function login()
    {
        global $db;

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin' LIMIT 1");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin;
            header("Location: /admin/dashboard");
            exit;
        }

        $_SESSION['error'] = "Invalid admin credentials";
        header("Location: /login.php");
    }

    public function dashboard()
    {
        auth_admin_required();
        include __DIR__ . "/../views/pages/admin_dashboard.php";
    }

    public function logout()
    {
        unset($_SESSION['admin']);
        session_destroy();
        header("Location: /login.php");
    }
}
