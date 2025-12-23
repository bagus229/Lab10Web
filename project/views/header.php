<?php
// Pastikan sesi sudah aktif (tidak double-start)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modular CRUD</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<h1>PHP Modular - Praktikum OOP</h1>

<nav>
    <?php if (isset($_SESSION['login'])): ?>
        
        <a href="index.php">Dashboard</a>
        <a href="index.php?page=user/list">Daftar Barang</a>
        <a href="index.php?page=user/add">Tambah Barang</a>
        <a href="index.php?page=auth/logout">Logout</a>

    <?php else: ?>
        
        <a href="index.php?page=auth/login">Login</a>

    <?php endif; ?>
</nav>

<hr>
