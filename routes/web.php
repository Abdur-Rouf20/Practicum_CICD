// AUTH PAGE
$router->get('/auth', function() { include 'views/auth/auth.php'; });

// AUTH CONTROLLER
$router->post('/auth/login', function() use ($db) {
    require 'controllers/AuthController.php';
    (new AuthController($db))->login();
});

$router->get('/auth/logout', function() use ($db) {
    require 'controllers/AuthController.php';
    (new AuthController($db))->logout();
});
