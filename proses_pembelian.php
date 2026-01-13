<?php
include 'koneksi.php';

$item_code  = $_POST['item_code'];
$jumlah_beli = $_POST['jumlah_beli'];
$harga_beli  = $_POST['harga_beli'];

// 1. Ambil stok saat ini
$barang = mysqli_query($koneksi, "SELECT qty FROM daftar_barang WHERE item_code = '$item_code'");
$b = mysqli_fetch_array($barang);
$stok_baru = $b['qty'] + $jumlah_beli;

// 2. Simpan riwayat pembelian
$insert = mysqli_query($koneksi, "INSERT INTO pembelian (item_code, jumlah_beli, harga_beli) 
                                  VALUES ('$item_code', '$jumlah_beli', '$harga_beli')");

// 3. Update stok di tabel barang
$update = mysqli_query($koneksi, "UPDATE daftar_barang SET qty = '$stok_baru' WHERE item_code = '$item_code'");

header("location:pembelian.php");
?>