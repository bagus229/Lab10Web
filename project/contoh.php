$sql = 'SELECT * FROM data_barang';
$sql_count = "SELECT COUNT(*) FROM data_barang";
if (isset($sql_where)) {
    $sql .= $sql_where;
    $sql_count .= $sql_where;
}
$result_count = mysqli_query($conn, $sql_count);
$count = 0;
if ($result_count) {
    $r_data = mysqli_fetch_row($result_count);
    $count = $r_data[0];
}
$per_page = 1;
$num_page = ceil($count / $per_page);
$limit = $per_page;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $offset = ($page -1) * $per_page;
} else {
    $offset = 0;
    $page = 1;
}
$sql .= " LIMIT {$offset}, {$limit}";
$result = mysqli_query($conn, $sql);
include_once 'header.php';

<?php endwhile; ?>
</table>
<ul class="pagination">
    <li><a href="#">&laquo;</a></li>
    <?php for ($i=1; $i <= $num_page; $i++) {
        $link = "?page={$i}";
        if (!empty($q)) $link .= "&q={$q}";
        $class = ($page == $i ? 'active' : '');
        echo "<li><a class=\"{$class}\" href=\"{$link}\">{$i}</a></li>";
    } ?>
    <li><a href="#">&raquo;</a></li>
</ul>
<?php endif; ?>
<?php include_once 'footer.php'; ?>





<?php
echo '<a href="tambah_barang.php" class="btn btn-large">Tambah Barang</a>';
?>
<form action="" method="get">
    <label for="q">Cari data: </label>
    <input type="text" id="q" name="q" class="input-q" value="<?php echo $q ?>">
    <input type="submit" name="submit" value="Cari" class="btn btn-primary">
</form>
<?php
if ($result):
?>
<table>

<?php
$q="";
if (isset($_GET['submit']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    $sql_where = " WHERE nama LIKE '{$q}%'";
}
$title = 'Data Barang';
include_once 'koneksi.php';
$sql = 'SELECT * FROM data_barang';
if (isset($sql_where))
    $sql .= $sql_where;
$result = mysqli_query($conn, $sql);
include_once 'header.php';

