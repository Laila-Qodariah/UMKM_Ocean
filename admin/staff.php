<?php
$query = "SELECT * FROM staff ORDER BY id DESC";
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

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <h3 class="mb-1 section-title">Data Staff</h3>
                    <p class="text-muted mb-0">Kelola akun admin dan staff secara terpusat.</p>
                </div>
                <a href="index.php?menu=tambah_staff" class="btn btn-primary">+ Tambah Staff</a>
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

            <div class="table-responsive mt-3">
                <table id="tableStaff" class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th width="170">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                <td class="text-center">
                                    <?php if ($row['role'] === 'admin'): ?>
                                        <span class="badge rounded-pill text-bg-primary">Admin</span>
                                    <?php elseif ($row['role'] === 'staff'): ?>
                                        <span class="badge rounded-pill text-bg-success">Staff</span>
                                    <?php elseif ($row['role'] === 'pemilik'): ?>
                                        <span class="badge rounded-pill text-bg-dark">Pemilik/CEO</span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill text-bg-secondary"><?= ucfirst(htmlspecialchars($row['role'])); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill <?= $row['status'] === 'aktif' ? 'text-bg-success' : 'text-bg-danger'; ?>">
                                        <?= ucfirst(htmlspecialchars($row['status'])); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="index.php?menu=edit_staff&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                                    <a href="hapus_staff.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus staff ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data staff.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="area-kembali">
                <a href="javascript:history.back()" class="btn btn-kembali btn-sm">← Kembali </a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    if ($.fn.DataTable.isDataTable('#tableStaff')) {
        $('#tableStaff').DataTable().destroy();
    }

    $('#tableStaff').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
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