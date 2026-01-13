<?php 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Barang - Pesan Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; padding-bottom: 100px; }
        .card-barang { border: none; border-radius: 15px; transition: transform 0.2s; overflow: hidden; }
        .card-barang:hover { transform: translateY(-5px); }
        .img-container { height: 180px; background-color: #eee; display: flex; align-items: center; justify-content: center; }
        
        /* Sticky Footer Style */
        .footer-order {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
            padding: 15px 0;
            z-index: 1000;
            border-top: 3px solid #0d6efd;
        }
        .qty-input { max-width: 80px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary shadow-sm mb-4">
    <div class="container text-center">
        <span class="navbar-brand mb-0 h1 mx-auto"><i class="fas fa-store me-2"></i>KATALOG BELANJA</span>
    </div>
</nav>

<div class="container">
    <form id="formKatalog" action="proses_katalog.php" method="POST">
        <div class="row g-4">
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM daftar_barang WHERE qty > 0");
            while ($b = mysqli_fetch_assoc($query)) {
            ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card card-barang shadow-sm h-100">
                    <div class="img-container">
                        <i class="fas fa-box fa-4x text-muted"></i>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="fw-bold mb-1 text-truncate"><?php echo $b['item_name']; ?></h6>
                        <p class="text-primary fw-bold mb-2">Rp <?php echo number_format($b['harga'], 0, ',', '.'); ?></p>
                        <div class="mt-auto">
                            <div class="d-flex align-items-center justify-content-between bg-light p-2 rounded border">
                                <small class="text-muted">Stok: <b><?php echo $b['qty']; ?></b></small>
                                <input type="number" 
                                       name="order_qty[<?php echo $b['item_code']; ?>]" 
                                       class="form-control form-control-sm qty-input input-pesanan" 
                                       value="0" min="0" max="<?php echo $b['qty']; ?>"
                                       data-harga="<?php echo $b['harga']; ?>"
                                       onchange="hitungFooter()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="footer-order">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="d-flex flex-column">
                            <span class="small text-muted text-uppercase fw-bold">Ringkasan Pesanan:</span>
                            <span class="h4 mb-0 text-primary fw-bold" id="displayTotalHarga">Rp 0</span>
                            <small class="text-secondary"><span id="displayTotalItem">0</span> Item terpilih</small>
                        </div>
                    </div>
                    <div class="col-md-5 mb-3 mb-md-0">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-user"></i></span>
                            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan Nama Anda..." required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow" id="btnPesan" disabled>
                            PESAN SEKARANG <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function hitungFooter() {
    let totalHarga = 0;
    let totalItem = 0;
    const inputs = document.querySelectorAll('.input-pesanan');

    inputs.forEach(input => {
        const qty = parseInt(input.value) || 0;
        const harga = parseInt(input.getAttribute('data-harga'));
        
        if (qty > 0) {
            totalHarga += (qty * harga);
            totalItem += qty;
        }
    });

    // Update Tampilan
    document.getElementById('displayTotalHarga').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalHarga);
    document.getElementById('displayTotalItem').innerText = totalItem;

    // Aktifkan/Matikan Tombol Pesan
    const btn = document.getElementById('btnPesan');
    if (totalItem > 0) {
        btn.disabled = false;
        btn.classList.replace('btn-secondary', 'btn-primary');
    } else {
        btn.disabled = true;
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>