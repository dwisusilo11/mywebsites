<?php 
include 'cek_sesi.php'; 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembelian Barang - Toko Elektronik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .header-section { background: white; padding: 20px 0; border-bottom: 1px solid #dee2e6; margin-bottom: 30px; }
    </style>
</head>
<body>

<div class="header-section shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="main_menu.php" class="btn btn-outline-secondary">
            <i class="fas fa-chevron-left"></i> Back to Main Menu
        </a>
        <h4 class="mb-0 fw-bold text-warning"><i class="fas fa-truck-loading me-2"></i>Pembelian Barang (Restock)</h4>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark py-3 fw-bold">Input Stok Masuk</div>
                <div class="card-body">
                    <form action="proses_pembelian.php" method="post">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Item Code</label>
                            <select name="item_code" class="form-select" required>
                                <option value="">-- Pilih Kode Barang --</option>
                                <?php
                                $brg = mysqli_query($koneksi, "SELECT * FROM daftar_barang");
                                while($b = mysqli_fetch_array($brg)){
                                    echo "<option value='".$b['item_code']."'>".$b['item_code']." - ".$b['item_name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Beli (Qty)</label>
                            <input type="number" name="jumlah_beli" class="form-control" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Beli Satuan (Modal)</label>
                            <input type="number" name="harga_beli" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Stok
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">Riwayat Stok Masuk</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Item Code</th>
                                <th>Barang</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end pe-3">Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT p.*, b.item_name FROM pembelian p 
                                      JOIN daftar_barang b ON p.item_code = b.item_code 
                                      ORDER BY p.tgl_pembelian DESC";
                            $res = mysqli_query($koneksi, $query);
                            while($row = mysqli_fetch_array($res)){
                                $total = $row['jumlah_beli'] * $row['harga_beli'];
                                echo "<tr>
                                    <td class='small'>".date('d/m/y H:i', strtotime($row['tgl_pembelian']))."</td>
                                    <td><span class='badge bg-info text-dark'>".$row['item_code']."</span></td>
                                    <td class='fw-bold'>".$row['item_name']."</td>
                                    <td class='text-center text-success'>+".$row['jumlah_beli']."</td>
                                    <td class='text-end pe-3'>Rp ".number_format($total, 0, ',', '.')."</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>