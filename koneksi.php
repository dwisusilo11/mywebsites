<?php
$koneksi = mysqli_connect("localhost", "root", "", "toko_elektronik");
if (!$koneksi) { die("Koneksi Gagal: " . mysqli_connect_error()); }
?>