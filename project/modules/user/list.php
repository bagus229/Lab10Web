<?php
// =====================
// SEARCH LOGIC
// =====================
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$where = '';

if ($q !== '') {
    $where = " WHERE nama LIKE '%$q%' OR kategori LIKE '%$q%'";
}

// =====================
// PAGINATION LOGIC
// =====================
$per_page = 1; // jumlah data per halaman
$p = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$p = ($p < 1) ? 1 : $p;
$offset = ($p - 1) * $per_page;

// Hitung total data
$count_sql = "SELECT COUNT(*) AS total FROM data_barang" . $where;
$count_result = $db->query($count_sql);
$total_data = $count_result->fetch_assoc()['total'];
$num_page = ceil($total_data / $per_page);

// Ambil data
$sql = "SELECT * FROM data_barang" . $where . " LIMIT $offset, $per_page";
$result = $db->query($sql);
?>

<link rel="stylesheet" href="/lab10_php_oop/project/assets/css/style.css">

<style>
/* SEARCH */
.search-container {
    text-align: center;
    margin: 20px 0;
}
.search-container form {
    display: inline-block;
}

/* PAGINATION */
.pagination-container {
    text-align: center;
    margin-top: 20px;
}
ul.pagination {
    display: inline-block;
    padding: 0;
    margin: 0;
}
ul.pagination li {
    display: inline;
}
ul.pagination li a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    margin: 0 2px;
}
ul.pagination li a.active {
    background-color: #428bca;
    color: white;
    border: 1px solid #428bca;
}
ul.pagination li a:hover:not(.active) {
    background-color: #ddd;
}
</style>

<h2 style="text-align:center;">Data Barang</h2>

<div style="text-align:center; margin-bottom:10px;">
    <a href="index.php?page=user/add" class="btn btn-large">Tambah Barang</a>
</div>

<!-- SEARCH -->
<div class="search-container">
    <form method="get">
        <input type="hidden" name="page" value="user/list">
        <label for="q">Cari data:</label>
        <input type="text" name="q" id="q" value="<?= htmlspecialchars($q) ?>">
        <input type="submit" value="Cari" class="btn btn-primary">
    </form>
</div>

<?php if ($result && $result->num_rows > 0): ?>

<table border="1" cellpadding="8" cellspacing="0" align="center">
    <tr>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Harga Jual</th>
        <th>Harga Beli</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><img src="<?= $row['gambar']; ?>" width="80"></td>
        <td><?= $row['nama']; ?></td>
        <td><?= $row['kategori']; ?></td>
        <td><?= $row['harga_jual']; ?></td>
        <td><?= $row['harga_beli']; ?></td>
        <td><?= $row['stok']; ?></td>
        <td>
            <a href="index.php?page=user/edit&id=<?= $row['id_barang']; ?>">Edit</a> |
            <a href="index.php?page=user/delete&id=<?= $row['id_barang']; ?>"
               onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- PAGINATION -->
<div class="pagination-container">
<ul class="pagination">

    <?php
    // PREVIOUS
    $prev = ($p > 1) ? $p - 1 : 1;
    $prev_link = "index.php?page=user/list&p=$prev";
    if ($q !== '') $prev_link .= "&q=$q";
    ?>
    <li><a href="<?= $prev_link ?>">&laquo;</a></li>

    <?php for ($i = 1; $i <= $num_page; $i++):
        $link = "index.php?page=user/list&p=$i";
        if ($q !== '') $link .= "&q=$q";
    ?>
        <li>
            <a href="<?= $link ?>" class="<?= ($p == $i) ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        </li>
    <?php endfor; ?>

    <?php
    // NEXT
    $next = ($p < $num_page) ? $p + 1 : $num_page;
    $next_link = "index.php?page=user/list&p=$next";
    if ($q !== '') $next_link .= "&q=$q";
    ?>
    <li><a href="<?= $next_link ?>">&raquo;</a></li>

</ul>
</div>

<?php else: ?>
    <p style="text-align:center;">Data tidak ditemukan.</p>
<?php endif; ?>
