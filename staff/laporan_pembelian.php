<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}

$tanggal_awal  = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

$where = "";
$params = [];
$types  = "";

if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
    $where = "WHERE DATE(pm.tanggal) BETWEEN ? AND ?";
    $params[] = $tanggal_awal;
    $params[] = $tanggal_akhir;
    $types .= "ss";
}

$sql = "
    SELECT 
        pmd.id,
        pm.tanggal,
        p.nama_produk,
        pmd.qty,
        s.nama_lengkap AS petugas
    FROM produk_masuk_detail pmd
    INNER JOIN produk_masuk pm ON pmd.transaksi_id = pm.id
    INNER JOIN produk p ON pmd.produk_id = p.id
    LEFT JOIN staff s ON pm.created_by = s.id
    $where
    ORDER BY pm.tanggal DESC, pmd.id DESC
";

$stmt = mysqli_prepare($conn, $sql);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<style>
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-top: 18px;
    margin-bottom: 16px;
}

.dataTables_wrapper .dataTables_length label {
    display: inline-block !important;
    white-space: nowrap;
    margin-bottom: 0;
}

.dataTables_wrapper .dataTables_length select {
    display: inline-block !important;
    width: 70px !important;
    min-width: 70px !important;
    margin: 0 8px !important;
    padding: 4px 8px !important;
    height: 36px !important;
    line-height: 1.2 !important;
    border-radius: 8px !important;
    border: 1px solid #ced4da !important;
    background-color: #fff !important;
    vertical-align: middle !important;
}

.dataTables_wrapper .dataTables_filter label {
    white-space: nowrap;
    margin-bottom: 0;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: 8px !important;
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 6px 10px;
}

.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin-top: 14px;
}

.dataTables_wrapper .row:last-child {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: nowrap;
    gap: 12px;
}

.dataTables_wrapper .row:last-child > div:first-child {
    flex: 1;
}

.dataTables_wrapper .row:last-child > div:last-child {
    flex-shrink: 0;
    text-align: right;
}

.dataTables_wrapper .dataTables_paginate {
    white-space: nowrap;
}
</style>

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <div>
                    <h3 class="mb-1 section-title">Laporan Pembelian / Produk Masuk</h3>
                    <p class="text-muted mb-0">Lihat riwayat produk masuk berdasarkan rentang tanggal.</p>
                </div>
                <a href="index.php?menu=home" class="btn btn-secondary">← Kembali</a>
            </div>

            <form method="GET" action="index.php" class="mb-4">
                <input type="hidden" name="menu" value="laporan_pembelian">

                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control" value="<?= htmlspecialchars($tanggal_awal); ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control" value="<?= htmlspecialchars($tanggal_akhir); ?>">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>

                    <div class="col-md-2">
                        <a href="index.php?menu=laporan_pembelian" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table id="tableLaporanPembelian" class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th width="70">No</th>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Staff</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars(date('Y-m-d', strtotime($row['tanggal']))); ?></td>
                                <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                                <td><?= (int)$row['qty']; ?></td>
                                <td><?= htmlspecialchars($row['petugas'] ?? '-'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data laporan.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#tableLaporanPembelian').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [[1, 'desc']],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            zeroRecords: "Data tidak ditemukan",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"f>>rt<"row mt-3"<"col-sm-6"i><"col-sm-6 text-end"p>>'
    });
});
</script>