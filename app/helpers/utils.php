<?php
// Placeholder: utils.php

function redirect($path)
{
    header("Location: $path");
    exit;
}

function set_flash($msg, $type = "success")
{
    $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
}

function get_flash()
{
    if (isset($_SESSION['flash'])) {
        $msg = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $msg;
    }
    return null;
}

function sanitize($str)
{
    return htmlspecialchars(trim($str));
}
