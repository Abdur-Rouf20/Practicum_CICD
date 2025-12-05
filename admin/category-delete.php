<?php
session_start();
require_once "auth_check.php";

require_once "../app/controllers/CategoryController.php";

$controller = new CategoryController();

if (!isset($_GET['id'])) {
    redirect("categories.php");
}

$controller->delete($_GET['id']);
