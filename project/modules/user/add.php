<link rel="stylesheet" href="assets/css/style.css">

<h2>Tambah Barang</h2>

<form method="post" enctype="multipart/form-data">

    <label>Nama Barang:</label><br>
    <input type="text" name="nama"><br><br>

    <label>Kategori:</label><br>
    <select name="kategori">
        <option value="Komputer">Komputer</option>
        <option value="Elektronik">Elektronik</option>
        <option value="Hand Phone">Hand Phone</option>
    </select><br><br>

    <label>Harga Jual:</label><br>
    <input type="number" name="harga_jual"><br><br>

    <label>Harga Beli:</label><br>
    <input type="number" name="harga_beli"><br><br>

    <label>Stok:</label><br>
    <input type="number" name="stok"><br><br>

    <label>File Gambar:</label><br>
    <input type="file" name="file_gambar"><br><br>

    <button type="submit" name="submit">Simpan</button>
</form>

<?php
if (isset($_POST['submit'])) {

    // Escape input menggunakan class Database
    $nama       = $db->escape($_POST['nama']);
    $kategori   = $db->escape($_POST['kategori']);
    $harga_jual = $db->escape($_POST['harga_jual']);
    $harga_beli = $db->escape($_POST['harga_beli']);
    $stok       = $db->escape($_POST['stok']);

    // Proses upload gambar (jika ada)
    $gambar = null;
    if ($_FILES['file_gambar']['error'] == 0) {
        $filename = str_replace(' ', '_', $_FILES['file_gambar']['name']);
        $target_path = "gambar/$filename";

        if (move_uploaded_file($_FILES['file_gambar']['tmp_name'], $target_path)) {
            $gambar = $target_path;
        }
    }

    // Query insert menggunakan class Database
    $insert = $db->query("
        INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar)
        VALUES ('$nama', '$kategori', '$harga_jual', '$harga_beli', '$stok', '$gambar')
    ");

    if ($insert) {
        echo "<script>alert('Data berhasil disimpan'); window.location='index.php?page=user/list';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}
?>
