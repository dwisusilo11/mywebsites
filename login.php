<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung lempar ke main menu
if (isset($_SESSION['username'])) {
    header("location:main_menu.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_with_mysqli($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Mengenkripsi input password user

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (!$query) {
        $error = "Kesalahan Database: " . mysqli_error($koneksi);
    } elseif (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // Set Session
        $_SESSION['username'] = $data['username'];
        $_SESSION['level']    = $data['level'];
        $_SESSION['last_login_timestamp'] = time();

        header("location:main_menu.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}

// Fungsi proteksi input sederhana
function mysqli_real_escape_with_mysqli($koneksi, $data) {
    return mysqli_real_escape_string($koneksi, $data);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Toko Elektronik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { max-width: 400px; width: 100%; border: none; border-radius: 15px; }
    </style>
</head>
<body>
    <div class="card login-card shadow-lg p-4">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">SISTEM TOKO</h3>
            <p class="text-muted small">Silakan masuk ke akun Anda</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger p-2 small text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="admin / kasir" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="******" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 py-2 fw-bold">LOGIN SEKARANG</button>
        </form>
        
        <div class="mt-4 text-center">
            <a href="katalog.php" class="text-decoration-none small text-secondary">Lihat Katalog Barang (Customer)</a>
        </div>
    </div>
</body>
</html>