<?php
$totalProduk = 0;
$totalStaff  = 0;
$totalStok   = 0;
$totalNilai  = 0;

$q1 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk");
if ($q1) {
    $d1 = mysqli_fetch_assoc($q1);
    $totalProduk = $d1['total'];
}

$q2 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM staff");
if ($q2) {
    $d2 = mysqli_fetch_assoc($q2);
    $totalStaff = $d2['total'];
}

$q3 = mysqli_query($conn, "SELECT COALESCE(SUM(stok),0) AS total FROM produk");
if ($q3) {
    $d3 = mysqli_fetch_assoc($q3);
    $totalStok = $d3['total'];
}

$q4 = mysqli_query($conn, "SELECT COALESCE(SUM(harga * stok),0) AS total FROM produk");
if ($q4) {
    $d4 = mysqli_fetch_assoc($q4);
    $totalNilai = $d4['total'];
}
?>

<div class="container py-4">
    <div class="hero-box mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-2">Selamat Datang, <?= htmlspecialchars($_SESSION['admin_nama'] ?? 'Administrator'); ?> 👋</h2>
                <p class="mb-0">Kelola data produk dan staff melalui panel admin yang modular, rapi, dan siap dipakai.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <span class="badge rounded-pill text-bg-light px-3 py-2">Ocean Blue Dashboard</span>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-bubble">
                    <i class="bi bi-box-seam fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Produk</div>
                    <h3 class="mb-0"><?= number_format($totalProduk); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-bubble">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Staff</div>
                    <h3 class="mb-0"><?= number_format($totalStaff); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-bubble">
                    <i class="bi bi-archive-fill fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Stok</div>
                    <h3 class="mb-0"><?= number_format($totalStok); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-bubble">
                    <i class="bi bi-wallet2 fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Nilai Inventori</div>
                    <h6 class="mb-0">Rp <?= number_format($totalNilai, 0, ',', '.'); ?></h6>
                </div>
            </div>
        </div>
    </div>
</div>

    <h4 class="section-title mb-3">Menu Cepat</h4>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="index.php?menu=produk" class="text-decoration-none">
                <div class="card quick-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold">Kelola Data Produk</h5>
                        <p class="text-muted mb-0">Lihat, tambah, edit, dan hapus data produk beserta gambar, harga, dan stok.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="index.php?menu=staff" class="text-decoration-none">
                <div class="card quick-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold">Kelola Data Staff</h5>
                        <p class="text-muted mb-0">Atur akun staff, role, status aktif dan nonaktif, serta ubah password lewat menu edit.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="index.php?menu=tambah_produk" class="text-decoration-none">
                <div class="card quick-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold">Tambah Produk Cepat</h5>
                        <p class="text-muted mb-0">Masukkan produk baru langsung dari dashboard dengan alur yang lebih rapi.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>