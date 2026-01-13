<?php
include 'koneksi.php';

$code = mysqli_real_escape_string($koneksi, $_GET['code']);
$query = mysqli_query($koneksi, "SELECT item_code, item_name, harga FROM daftar_barang WHERE item_code = '$code' AND qty > 0");

if (mysqli_num_rows($query) > 0) {
    echo json_encode(mysqli_fetch_assoc($query));
} else {
    echo json_encode(['error' => 'Barang tidak ditemukan atau stok habis']);
}
?>