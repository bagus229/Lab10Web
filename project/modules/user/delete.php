<?php
// Ambil ID barang dari parameter URL
$id_barang = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 1. Ambil data barang (khusus gambar)
$result = $db->query("SELECT gambar FROM data_barang WHERE id_barang = $id_barang");
$data = $result->fetch_assoc();

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data barang tidak ditemukan!'); window.location='index.php?page=user/list';</script>";
    exit;
}

$gambar = $data['gambar'];

// 2. Hapus file gambar jika ada di server
if (!empty($gambar) && file_exists($gambar)) {
    unlink($gambar);
}

// 3. Hapus data dari database
$delete = $db->query("DELETE FROM data_barang WHERE id_barang = $id_barang");

if ($delete) {
    echo "<script>alert('Data berhasil dihapus!'); window.location='index.php?page=user/list';</script>";
} else {
    echo "<script>alert('Gagal menghapus data!'); window.location='index.php?page=user/list';</script>";
}
?>
