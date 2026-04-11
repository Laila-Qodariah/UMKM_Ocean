<?php
if (isset($_POST['simpan'])) {
    $username     = trim($_POST['username']);
    $password     = trim($_POST['password']);
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $role         = trim($_POST['role']);
    $status       = trim($_POST['status']);

    if ($username === '' || $password === '' || $nama_lengkap === '' || $role === '' || $status === '') {
        $_SESSION['error'] = "Semua field wajib diisi.";
        echo "<script>window.location='index.php?menu=tambah_staff';</script>";
        exit;
    }

    if (!in_array($role, ['admin', 'staff', 'pemilik'])) {
        $_SESSION['error'] = "Role tidak valid.";
        echo "<script>window.location='index.php?menu=tambah_staff';</script>";
        exit;
    }

    $cek = mysqli_prepare($conn, "SELECT id FROM staff WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($cek, "s", $username);
    mysqli_stmt_execute($cek);
    $cekResult = mysqli_stmt_get_result($cek);

    if (mysqli_num_rows($cekResult) > 0) {
        $_SESSION['error'] = "Username sudah digunakan.";
        echo "<script>window.location='index.php?menu=tambah_staff';</script>";
        exit;
    }

    $password_hash = $password;

    $stmt = mysqli_prepare($conn, "INSERT INTO staff (username, password, nama_lengkap, role, status) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $username, $password_hash, $nama_lengkap, $role, $status);
    mysqli_stmt_execute($stmt);

    $_SESSION['success'] = "Staff berhasil ditambahkan.";
    echo "<script>window.location='index.php?menu=staff';</script>";
    exit;
}
?>

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">
            <h3 class="section-title mb-4">Tambah Staff</h3>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="pemilik">Pemilik/CEO</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="index.php?menu=staff" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>