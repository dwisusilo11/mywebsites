<?php include 'cek_sesi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Ubah Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow p-4">
                <h4 class="text-center mb-4">Ganti Password</h4>
                <form action="proses_user.php?aksi=ubah_pass" method="POST">
                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input type="password" name="pass_baru" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_pass" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    <a href="main_menu.php" class="btn btn-link w-100 mt-2 text-decoration-none text-muted">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>