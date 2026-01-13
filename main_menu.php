<?php include 'cek_sesi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Main Menu - Toko Elektronik</title>
	<title>Kelompok Dwi Susilo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; padding-top: 50px; }
        .menu-card { transition: 0.3s; border: none; border-radius: 15px; text-align: center; }
        .menu-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .icon-box { font-size: 3rem; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="container">
    <div class="text-center mb-5">
        <h1 class="fw-bold">SISTEM MANAJEMEN TOKO</h1>
        <p class="text-muted">Halo, <b><?php echo $_SESSION['username']; ?></b> (<?php echo ucfirst($_SESSION['level']); ?>)</p>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <a href="transaksi.php" class="text-decoration-none">
                <div class="card menu-card p-4 shadow-sm">
                    <div class="icon-box text-danger"><i class="fas fa-shopping-cart"></i></div>
                    <h4 class="text-dark">Penjualan</h4>
                </div>
            </a>
        </div>

        <?php if ($_SESSION['level'] == 'admin') : ?>
        <div class="col-md-4">
            <a href="index.php" class="text-decoration-none">
                <div class="card menu-card p-4 shadow-sm">
                    <div class="icon-box text-primary"><i class="fas fa-boxes"></i></div>
                    <h4 class="text-dark">Onhand Stock</h4>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="pembelian.php" class="text-decoration-none">
                <div class="card menu-card p-4 shadow-sm">
                    <div class="icon-box text-warning"><i class="fas fa-truck"></i></div>
                    <h4 class="text-dark">Pembelian</h4>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="list_user.php" class="text-decoration-none">
                <div class="card menu-card p-4 shadow-sm border-primary">
                    <div class="icon-box text-info"><i class="fas fa-users-cog"></i></div>
                    <h4 class="text-dark">Manage Users</h4>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
            <a href="ubah_password.php" class="text-decoration-none">
                <div class="card menu-card p-4 shadow-sm">
                    <div class="icon-box text-dark"><i class="fas fa-key"></i></div>
                    <h4 class="text-dark">Ubah Password</h4>
                </div>
            </a>
        </div>
    </div>
</div>
</body>
</html>