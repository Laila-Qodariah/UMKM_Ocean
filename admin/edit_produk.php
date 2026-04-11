<?php
$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    $_SESSION['error'] = "Produk tidak ditemukan.";
    header("Location: index.php?menu=produk");
    exit;
}
?>

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">
            <h3 class="section-title mb-4">Edit Produk</h3>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="update_produk.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($data['gambar']); ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($data['nama_produk']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($data['harga']); ?>" min="0" step="0.01" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($data['stok']); ?>" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Lama</label><br>
                    <?php if (!empty($data['gambar']) && file_exists("uploads/" . $data['gambar'])): ?>
                        <img src="uploads/<?= htmlspecialchars($data['gambar']); ?>" class="table-img" alt="<?= htmlspecialchars($data['nama_produk']); ?>">
                    <?php else: ?>
                        <span class="text-muted">Tidak ada gambar</span>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label">Ganti Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                </div>

                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="index.php?menu=produk" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>