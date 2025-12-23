<?php
session_start();


require 'libraries/database.php';
require 'libraries/Form.php';

$db = new Database();
$conn = $db->getConnection();

$is_logged_in = isset($_SESSION['login']);

require 'views/header.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'auth/login';

$protected_pages = [
    'dashboard',
    'user/list',
    'user/add',
    'user/edit',
    'user/delete'
];

if (in_array($page, $protected_pages) && !$is_logged_in) {
    echo "<script>alert('Login dulu bro!'); window.location='index.php?page=auth/login';</script>";
    exit;
}

switch ($page) {

    case 'user/list':
        require 'modules/user/list.php';
        break;

    case 'user/add':
        require 'modules/user/add.php';
        break;

    case 'user/edit':
        require 'modules/user/edit.php';
        break;

    case 'user/delete':
        require 'modules/user/delete.php';
        break;

    case 'auth/login':
        require 'modules/auth/login.php';
        break;

    case 'auth/logout':
        require 'modules/auth/logout.php';
        break;

    default:
        $username = $_SESSION['username'] ?? 'User';
        require 'views/dashboard.php';
        break;
}

require "views/footer.php";
?>
