<?php 
include 'cek_sesi.php'; 
include 'koneksi.php'; 
if($_SESSION['level'] != 'admin') { header("location:main_menu.php"); exit; } 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="fas fa-users-cog me-2"></i>Daftar Pengguna</h5>
            <div>
                <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalAddUser">
                    <i class="fas fa-user-plus"></i> Tambah User
                </button>
                <a href="main_menu.php" class="btn btn-sm btn-light">Kembali</a>
            </div>
        </div>
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-4">Username</th>
                    <th>Level</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($koneksi, "SELECT * FROM users ORDER BY level ASC");
                while($u = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr>
                        <td class="ps-4"><b><?php echo $u['username']; ?></b></td>
                        <td>
                            <span class="badge <?php echo ($u['level'] == 'admin') ? 'bg-primary' : 'bg-secondary'; ?>">
                                <?php echo strtoupper($u['level']); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#reset<?php echo $u['id']; ?>">
                                <i class="fas fa-key"></i> Reset Pass
                            </button>
                        </td>
                    </tr>

                    <div class="modal fade" id="reset<?php echo $u['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <form action="proses_user.php?aksi=reset_user" method="POST">
                                <div class="modal-content">
                                    <div class="modal-header"><h5>Reset: <?php echo $u['username']; ?></h5></div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id_user" value="<?php echo $u['id']; ?>">
                                        <input type="text" name="pass_baru" class="form-control mb-2" placeholder="Password Baru" required>
                                        <button type="submit" class="btn btn-primary btn-sm w-100">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalAddUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_user.php?aksi=tambah_user" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level Akses</label>
                        <select name="level" class="form-select" required>
                            <option value="kasir">Kasir (Akses Terbatas)</option>
                            <option value="admin">Admin (Akses Penuh)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>