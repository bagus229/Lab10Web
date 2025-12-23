<?php
session_start();
session_destroy();
echo "<script>alert('Logout berhasil'); window.location='index.php?page=auth/login';</script>";
?>
<link rel="stylesheet" href="assets/style.css">