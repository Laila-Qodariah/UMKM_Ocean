<?php
include '../config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: ../index.php");
    exit;
}

$keranjang = $_SESSION['keranjang_masuk'] ?? [];
$totalItem = 0;

foreach ($keranjang as $item) {
    $totalItem += (int)$item['qty'];
}
?>

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <div>
                    <h3 class="mb-1 section-title">Keranjang Barang Masuk</h3>
                    <p class="text-muted mb-0">Cek ulang item sebelum menyimpan transaksi masuk.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="produk_masuk.php" class="btn btn-secondary">← Kembali Pilih Produk</a>
                    <a href="../index.php?menu=home" class="btn btn-outline-secondary">Dashboard</a>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <span class="badge text-bg-primary">Total Item: <?= $totalItem; ?></span>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Qty Masuk</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($keranjang)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($keranjang as $item): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="text-center">
                                    <?php if (!empty($item['gambar']) && file_exists("../admin/uploads/" . $item['gambar'])): ?>
                                        <img src="../admin/uploads/<?= htmlspecialchars($item['gambar']); ?>" class="table-img" width="60">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($item['nama_produk']); ?></td>
                                <td class="text-center"><?= (int)$item['qty']; ?></td>
                                <td class="text-center">
                                    <a href="hapus_keranjang.php?id=<?= $item['produk_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus item ini dari keranjang?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Keranjang masih kosong.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (!empty($keranjang)): ?>
                <form action="simpan_transaksi.php" method="POST" class="mt-4">
                    <div class="mb-3">
                        <label class="form-label">Keterangan Transaksi</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Barang masuk dari supplier A"></textarea>
                    </div>

                    <button type="submit" name="simpan_transaksi" class="btn btn-primary">Simpan Transaksi</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>