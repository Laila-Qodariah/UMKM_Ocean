<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}

$queryProduk = mysqli_query($conn, "SELECT * FROM produk ORDER BY nama_produk ASC");
$keranjang = $_SESSION['keranjang_masuk'] ?? [];
?>

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <div>
                    <h3 class="mb-1 section-title">Transaksi Produk Masuk</h3>
                    <p class="text-muted mb-0">Pilih produk, tentukan jumlah, lalu tambahkan ke keranjang transaksi.</p>
                </div>
                <a href="index.php?menu=home" class="btn btn-secondary">← Kembali</a>
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

            <form action="tambah_keranjang.php" method="POST" class="mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">Pilih Produk</label>
                        <select name="produk_id" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php while ($produk = mysqli_fetch_assoc($queryProduk)): ?>
                                <option value="<?= $produk['id']; ?>">
                                    <?= htmlspecialchars($produk['nama_produk']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Jumlah Masuk</label>
                        <input type="number" name="qty" class="form-control" min="1" value="1" required>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" name="tambah" class="btn btn-primary w-100">Tambah</button>
                    </div>
                </div>
            </form>

            <hr>

            <h4 class="section-title mb-3" style="font-size: 1.6rem;">Keranjang</h4>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th width="70">No</th>
                            <th>Produk</th>
                            <th width="150">Jumlah</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($keranjang)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($keranjang as $item): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($item['nama_produk']); ?></td>
                                <td class="text-center"><?= (int)$item['qty']; ?></td>
                                <td class="text-center">
                                    <a href="hapus_keranjang.php?id=<?= $item['produk_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus item ini dari keranjang?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">Keranjang masih kosong.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (!empty($keranjang)): ?>
                <form action="simpan_transaksi.php" method="POST" class="mt-3">
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Barang masuk dari supplier"></textarea>
                    </div>

                    <button type="submit" name="simpan_transaksi" class="btn btn-success">
                        Simpan Transaksi
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>