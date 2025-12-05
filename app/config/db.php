<?php
// Load config
$config = require __DIR__ . '/config.php';
$db = $config['db'];

// PDO DSN
$dsn = "mysql:host={$db['host']};dbname={$db['name']};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $db['user'], $db['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('DB Connection failed: ' . $e->getMessage());
}

// Return PDO object
return $pdo;
