<?php
$query = "SELECT * FROM produk ORDER BY id DESC";
$result = mysqli_query($conn, $query);
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
    width: 65px !important;
    min-width: 65px !important;
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

/* BAGIAN BAWAH BIAR SEBARIS */
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
.btn-kembali {
    background: #b4cadb;
    border-radius: 10px;
    padding: 6px 14px;
    font-size: 13px;
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <h3 class="mb-1 section-title">Data Produk</h3>
                    <p class="text-muted mb-0">Kelola seluruh data produk UMKM di sini.</p>
                </div>
                <a href="index.php?menu=tambah_produk" class="btn btn-primary">+ Tambah Produk</a>
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

            <div class="table-responsive mt-4">
                <table id="tabelProduk" class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>

                                <td class="text-center">
                                    <?php if (!empty($row['gambar']) && file_exists("uploads/" . $row['gambar'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" class="table-img" width="60">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                                <td><?= htmlspecialchars($row['deskripsi']); ?></td>

                                <td data-order="<?= (float)$row['harga']; ?>">
                                    Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                                </td>

                                <td class="text-center"><?= (int)$row['stok']; ?></td>

                                <td class="text-center">
                                    <a href="index.php?menu=edit_produk&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                                    <a href="hapus_produk.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data produk.</td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
            <div class="area-kembali">
                <a href="javascript:history.back()" class="btn btn-kembali btn-sm">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#tabelProduk').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [1, 6] }
        ],
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
        }
    });
});
</script>

<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">