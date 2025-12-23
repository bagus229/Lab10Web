<?php
// Pastikan variabel login tersedia
$is_logged_in = isset($_SESSION['login']);
?>

<link rel="stylesheet" href="assets/css/style.css">

<div class="card">
    <h2>Selamat Datang di Website Barang Management</h2>

    <?php if ($is_logged_in): ?>
        <p>Anda berhasil login sebagai <b><?= $_SESSION['username'] ?? 'User'; ?></b>.</p>
        <p>Silakan gunakan menu di atas untuk mengelola data barang.</p>
    <?php else: ?>
        <p>Silakan <a href="index.php?page=auth/login">Login</a> untuk memulai sesi.</p>
    <?php endif; ?>
</div>
