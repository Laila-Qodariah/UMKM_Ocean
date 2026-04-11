<?php
$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare($conn, "SELECT * FROM staff WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    $_SESSION['error'] = "Data staff tidak ditemukan.";
    header("Location: index.php?menu=staff");
    exit;
}
?>

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">
            <h3 class="section-title mb-4">Edit Staff</h3>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="update_staff.php" method="POST">
                <input type="hidden" name="id" value="<?= $data['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control">
                    <small class="text-muted">Kosongkan jika password tidak ingin diubah.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="staff" <?= $data['role'] === 'staff' ? 'selected' : ''; ?>>Staff</option>
                            <option value="pemilik" <?= $data['role'] === 'pemilik' ? 'selected' : ''; ?>>Pemilik/CEO</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif" <?= $data['status'] === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="nonaktif" <?= $data['status'] === 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="index.php?menu=staff" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div> 