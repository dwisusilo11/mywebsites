<?php
include 'koneksi.php';

$item_code = $_POST['item_code'];
$nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);

$query = mysqli_query($koneksi, "INSERT INTO antrean_pesanan (item_code, nama_pelanggan) VALUES ('$item_code', '$nama_pelanggan')");

if ($query) {
    echo "<script>
        alert('Pesanan terkirim! Silakan menuju kasir untuk melakukan pembayaran.');
        window.location='katalog.php';
    </script>";
}
?>