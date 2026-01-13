<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM daftar_barang WHERE item_code='$id'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-header bg-warning"><h5>Edit Barang</h5></div>
        <form action="proses.php?aksi=update" method="post" class="card-body">
            <label>Kode Item (Tidak dapat diubah)</label>
            <input type="text" name="item_code" class="form-control mb-2" value="<?= $d['item_code']; ?>" readonly>
            
            <label>Nama Barang</label>
            <input type="text" name="item_name" class="form-control mb-2" value="<?= $d['item_name']; ?>" required>
            
            <label>Qty</label>
            <input type="number" name="qty" class="form-control mb-2" value="<?= $d['qty']; ?>" required>
            
            <label>Harga</label>
            <input type="number" name="harga" class="form-control mb-2" value="<?= $d['harga']; ?>" required>
            
            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
</body>
</html>