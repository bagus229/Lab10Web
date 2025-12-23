<?php
// Pastikan ID tersedia
$id_barang = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data barang menggunakan class Database
$result = $db->query("SELECT * FROM data_barang WHERE id_barang = $id_barang");
$data = $result->fetch_assoc();

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data barang tidak ditemukan!'); window.location='index.php?page=user/list';</script>";
    exit;
}
?>

<h2>Edit Barang: <?= htmlspecialchars($data['nama']) ?></h2>

<form method="post" enctype="multipart/form-data">

    <label>Nama Barang:</label><br>
    <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>"><br><br>

    <label>Kategori:</label><br>
    <select name="kategori">
        <option value="Komputer"   <?= ($data['kategori'] == 'Komputer')   ? 'selected' : '' ?>>Komputer</option>
        <option value="Elektronik" <?= ($data['kategori'] == 'Elektronik') ? 'selected' : '' ?>>Elektronik</option>
        <option value="Hand Phone" <?= ($data['kategori'] == 'Hand Phone') ? 'selected' : '' ?>>Hand Phone</option>
    </select><br><br>

    <label>Harga Jual:</label><br>
    <input type="number" name="harga_jual" value="<?= htmlspecialchars($data['harga_jual']) ?>"><br><br>

    <label>Harga Beli:</label><br>
    <input type="number" name="harga_beli" value="<?= htmlspecialchars($data['harga_beli']) ?>"><br><br>

    <label>Stok:</label><br>
    <input type="number" name="stok" value="<?= htmlspecialchars($data['stok']) ?>"><br><br>

    <label>Gambar Saat Ini:</label><br>
    <?php if ($data['gambar']): ?>
        <img src="<?= htmlspecialchars($data['gambar']) ?>" width="100"><br>
        <small>Biarkan kosong jika tidak ingin mengubah gambar.</small>
    <?php else: ?>
        <small>Tidak ada gambar.</small>
    <?php endif; ?>
    <br><br>

    <label>Ganti File Gambar:</label><br>
    <input type="file" name="file_gambar"><br><br>

    <button type="submit" name="update">Update</button>
</form>

<?php
// -------------------------------
// PROSES UPDATE DATA
// -------------------------------
if (isset($_POST['update'])) {

    // Escape input pakai class Database
    $nama       = $db->escape($_POST['nama']);
    $kategori   = $db->escape($_POST['kategori']);
    $harga_jual = $db->escape($_POST['harga_jual']);
    $harga_beli = $db->escape($_POST['harga_beli']);
    $stok       = $db->escape($_POST['stok']);

    $gambar_lama = $data['gambar'];
    $gambar_baru = $gambar_lama;

    // Upload gambar baru jika ada
    if ($_FILES['file_gambar']['error'] == 0 && $_FILES['file_gambar']['size'] > 0) {

        if ($gambar_lama && file_exists($gambar_lama)) {
            unlink($gambar_lama);
        }

        $filename = str_replace(" ", "_", $_FILES['file_gambar']['name']);
        $target_path = "gambar/$filename";

        if (move_uploaded_file($_FILES['file_gambar']['tmp_name'], $target_path)) {
            $gambar_baru = $target_path;
        }
    }

    // Query UPDATE OOP
    $update = $db->query("UPDATE data_barang SET
        nama='$nama',
        kategori='$kategori',
        harga_jual='$harga_jual',
        harga_beli='$harga_beli',
        stok='$stok',
        gambar='$gambar_baru'
        WHERE id_barang = $id_barang
    ");

    if ($update) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='index.php?page=user/list';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}
?>
