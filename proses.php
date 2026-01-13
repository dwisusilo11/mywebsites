<?php
include 'koneksi.php';
$aksi = $_GET['aksi'];

if($aksi == "tambah") {
    $code = $_POST['item_code'];
    $name = $_POST['item_name'];
    $qty  = $_POST['qty'];
    $prc  = $_POST['harga'];
    mysqli_query($koneksi, "INSERT INTO daftar_barang VALUES('$code', '$name', '$qty', '$prc')");
} 

elseif($aksi == "update") {
    $code = $_POST['item_code'];
    $name = $_POST['item_name'];
    $qty  = $_POST['qty'];
    $prc  = $_POST['harga'];
    mysqli_query($koneksi, "UPDATE daftar_barang SET item_name='$name', qty='$qty', harga='$prc' WHERE item_code='$code'");
} 

elseif($aksi == "hapus") {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM daftar_barang WHERE item_code='$id'");
}

header("location:index.php");
?>