<?php 
include 'cek_sesi.php'; 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onhand Stock - Toko Elektronik</title>
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
        <h4 class="mb-0 fw-bold text-primary">Onhand Stock Management</h4>
    </div>
</div>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0 text-dark">Daftar Barang Tersedia</h2>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
            <i class="fas fa-plus"></i> Tambah Barang Baru
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Item Code</th>
                        <th>Item Name</th>
                        <th class="text-center">Qty</th>
                        <th>Harga Satuan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = mysqli_query($koneksi, "SELECT * FROM daftar_barang");
                    if(mysqli_num_rows($data) > 0) {
                        while($d = mysqli_fetch_array($data)){
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary"><?= $d['item_code']; ?></td>
                                <td><?= $d['item_name']; ?></td>
                                <td class="text-center">
                                    <span class="badge <?= ($d['qty'] > 5) ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                        <?= $d['qty']; ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format($d['harga'], 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <a href="edit.php?id=<?= $d['item_code']; ?>" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="proses.php?aksi=hapus&id=<?= $d['item_code']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus barang ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center py-5'>Data Kosong</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Input Barang Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="proses.php?aksi=tambah" method="POST">
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Item Code</label>
                <input type="text" name="item_code" class="form-control" placeholder="Contoh: ELC001" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Item Name</label>
                <input type="text" name="item_name" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="qty" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Barang</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>