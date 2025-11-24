<?php

class Route
{
    private static $routes = [];

    public static function get($uri, $action)
    {
        self::$routes['GET'][$uri] = $action;
    }

    public static function post($uri, $action)
    {
        self::$routes['POST'][$uri] = $action;
    }

    public static function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset(self::$routes[$method][$uri])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        list($controller, $function) = explode('@', self::$routes[$method][$uri]);

        $controllerFile = __DIR__ . "/../controllers/" . $controller . ".php";

        if (!file_exists($controllerFile)) {
            die("Controller $controller not found.");
        }

        require_once $controllerFile;

        $controllerObj = new $controller();
        return $controllerObj->$function();
    }
}
