<?php
include 'cek_sesi.php';
include 'koneksi.php';

if ($_GET['aksi'] == "update_dan_proses") {
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $item_codes = $_POST['item_code']; 
    $qtys = $_POST['qty']; 
    $hapus_items = isset($_POST['hapus_item']) ? $_POST['hapus_item'] : [];
    
    $no_jurnal = "INV-" . date("YmdHis");
    $nama_kasir = $_SESSION['username'];
    $total_bayar = 0;

    if (!empty($item_codes)) {
        for ($i = 0; $i < count($item_codes); $i++) {
            $kode = $item_codes[$i];
            $qty = $qtys[$i];

            // Proses jika barang TIDAK dicentang hapus
            if (!in_array($kode, $hapus_items)) {
                $brg = mysqli_query($koneksi, "SELECT harga FROM daftar_barang WHERE item_code = '$kode'");
                $data = mysqli_fetch_assoc($brg);
                
                if ($data) {
                    $subtotal = $data['harga'] * $qty;
                    $total_bayar += $subtotal;

                    // 1. Simpan Detail Transaksi
                    mysqli_query($koneksi, "INSERT INTO penjualan_detail (no_jurnal, item_code, qty, subtotal) 
                                            VALUES ('$no_jurnal', '$kode', '$qty', '$subtotal')");
                    
                    // 2. Potong Stok Barang
                    mysqli_query($koneksi, "UPDATE daftar_barang SET qty = qty - $qty WHERE item_code = '$kode'");
                }
            }
        }
    }

    // 3. Simpan Header Penjualan & Hapus Antrean
    if ($total_bayar > 0) {
        mysqli_query($koneksi, "INSERT INTO penjualan_header (no_jurnal, nama_pelanggan, total_bayar, nama_kasir) 
                                VALUES ('$no_jurnal', '$nama_pelanggan', '$total_bayar', '$nama_kasir')");
        
        mysqli_query($koneksi, "DELETE FROM antrean_pesanan WHERE nama_pelanggan = '$nama_pelanggan'");
        
        echo "<script>alert('Berhasil! Jurnal $no_jurnal dibuat.'); window.location='transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal! Tidak ada item yang dipilih.'); window.location='transaksi.php';</script>";
    }
}
?>