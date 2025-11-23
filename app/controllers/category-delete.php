<?php
session_start();

require_once "../app/helpers/auth.php";
require_admin();

require_once "../app/helpers/utils.php";
require_once "../app/config/db.php";
require_once "../app/models/Category.php";
require_once "../app/controllers/CategoryController.php";

if (!isset($_GET['id'])) {
    redirect("categories.php");
}

$controller = new CategoryController();
$controller->delete($_GET['id']);
