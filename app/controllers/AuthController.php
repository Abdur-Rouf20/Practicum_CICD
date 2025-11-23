<?php
class AuthController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
        session_start();
    }

    // ------------------------------
    // LOGIN
    // ------------------------------
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Invalid request!";
            header("Location: /auth");
            exit;
        }

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if ($email === "" || $password === "") {
            $_SESSION['error'] = "Email & Password required!";
            header("Location: /auth");
            exit;
        }

        $stmt = $this->conn->prepare("SELECT id, name, email, password FROM admins WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $_SESSION['error'] = "Invalid email or password!";
            header("Location: /auth");
            exit;
        }

        $admin = $result->fetch_assoc();

        // Verify password
        if (!password_verify($password, $admin['password'])) {
            $_SESSION['error'] = "Incorrect password!";
            header("Location: /auth");
            exit;
        }

        // Store session
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];

        header("Location: /admin/dashboard.php");
        exit;
    }

    // ------------------------------
    // LOGOUT
    // ------------------------------
    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /auth");
        exit;
    }
}
