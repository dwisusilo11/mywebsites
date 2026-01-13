<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $order_qtys = $_POST['order_qty']; // Ini adalah array [item_code => qty]
    
    $berhasil = 0;

    foreach ($order_qtys as $item_code => $qty) {
        $qty = (int)$qty;
        
        if ($qty > 0) {
            // Masukkan ke antrean pesanan sebanyak qty yang diinput
            // Kita simpan per baris agar kasir mudah melihatnya
            for ($i = 0; $i < $qty; $i++) {
                mysqli_query($koneksi, "INSERT INTO antrean_pesanan (nama_pelanggan, item_code) 
                                        VALUES ('$nama_pelanggan', '$item_code')");
            }
            $berhasil++;
        }
    }

    if ($berhasil > 0) {
        echo "<script>alert('Pesanan berhasil dikirim! Silakan menuju kasir untuk pembayaran.'); window.location='katalog.php';</script>";
    } else {
        echo "<script>alert('Pilih minimal 1 barang!'); window.history.back();</script>";
    }
}
?>