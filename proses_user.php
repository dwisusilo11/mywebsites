<?php
include 'cek_sesi.php';
include 'koneksi.php';

$aksi = $_GET['aksi'];

// 1. Tambah User Baru (Admin Only)
if ($aksi == "tambah_user") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    $level    = $_POST['level'];

    // Cek apakah username sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if(mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.history.back();</script>";
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO users (username, password, level) VALUES ('$username', '$password', '$level')");
        if($insert) {
            echo "<script>alert('User berhasil ditambahkan!'); window.location='list_user.php';</script>";
        }
    }
}

// 2. Reset Password User lain (Admin Only)
if ($aksi == "reset_user") {
    $id = $_POST['id_user'];
    $pw = md5($_POST['pass_baru']);
    mysqli_query($koneksi, "UPDATE users SET password='$pw' WHERE id='$id'");
    echo "<script>alert('Reset Berhasil!'); window.location='list_user.php';</script>";
}

// 3. Ubah Password Sendiri (User Aktif)
if ($aksi == "ubah_pass") {
    $p1 = $_POST['pass_baru'];
    $p2 = $_POST['konfirmasi_pass'];
    $user = $_SESSION['username'];

    if ($p1 === $p2) {
        $pw = md5($p1);
        mysqli_query($koneksi, "UPDATE users SET password='$pw' WHERE username='$user'");
        echo "<script>alert('Password Berhasil Diubah!'); window.location='main_menu.php';</script>";
    } else {
        echo "<script>alert('Konfirmasi password tidak cocok!'); window.history.back();</script>";
    }
}
?>