<?php
session_start();

// 1. Cek apakah sudah login
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

// 2. Batas Waktu 3 Menit (180 Detik)
if (isset($_SESSION['last_login_timestamp'])) {
    if ((time() - $_SESSION['last_login_timestamp']) > 180) {
        session_unset();
        session_destroy();
        echo "<script>alert('Sesi habis (3 menit). Silakan login kembali.'); window.location='login.php';</script>";
        exit;
    }
}
$_SESSION['last_login_timestamp'] = time(); // Refresh waktu aktivitas
?>