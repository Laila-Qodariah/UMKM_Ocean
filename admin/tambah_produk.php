<?php
if (isset($_POST['simpan'])) {
    $nama_produk = trim($_POST['nama_produk']);
    $deskripsi   = trim($_POST['deskripsi']);
    $harga       = (float) $_POST['harga'];
    $stok        = (int) $_POST['stok'];

    if ($nama_produk == '' || $harga < 0 || $stok < 0) {
        $_SESSION['error'] = "Nama produk, harga, dan stok wajib valid.";
        echo "<script>window.location='index.php?menu=tambah_produk';</script>";
        exit;
    }

    $gambar_nama = null;

    if (!empty($_FILES['gambar']['name'])) {
        $file_name = $_FILES['gambar']['name'];
        $tmp_name  = $_FILES['gambar']['tmp_name'];
        $error     = $_FILES['gambar']['error'];
        $size      = $_FILES['gambar']['size'];

        $ext_valid = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($ext, $ext_valid)) {
            $_SESSION['error'] = "Format gambar harus jpg, jpeg, png, atau webp.";
            echo "<script>window.location='index.php?menu=tambah_produk';</script>";
            exit;
        }

        if ($size > 2 * 1024 * 1024) {
            $_SESSION['error'] = "Ukuran gambar maksimal 2 MB.";
            echo "<script>window.location='index.php?menu=tambah_produk';</script>";
            exit;
        }

        if ($error === 0) {
            if (!is_dir("uploads")) {
                mkdir("uploads", 0777, true);
            }

            $gambar_nama = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file_name);
            move_uploaded_file($tmp_name, "uploads/" . $gambar_nama);
        }
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO produk (nama_produk, deskripsi, harga, stok, gambar) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssdis", $nama_produk, $deskripsi, $harga, $stok, $gambar_nama);
    mysqli_stmt_execute($stmt);

    $_SESSION['success'] = "Produk berhasil ditambahkan.";
    echo "<script>window.location='index.php?menu=produk';</script>";
    exit;
}
?>

<div class="container py-4">
    <div class="card content-card">
        <div class="card-body">
            <h3 class="section-title mb-4">Tambah Produk</h3>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                </div>

                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="text" id="harga" class="form-control" placeholder="Rp 0" required>
                        <input type="hidden" name="harga" id="harga_hidden">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" min="0" required>
                    </div>

                </div>

                <div class="mb-4">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">Opsional. Maksimal 2 MB.</small>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <a href="index.php?menu=produk" class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>
</div>

<script>
const hargaInput = document.getElementById('harga');
const hargaHidden = document.getElementById('harga_hidden');

if (hargaInput && hargaHidden) {

    hargaInput.addEventListener('input', function() {
        let value = this.value.replace(/[^0-9]/g, '');

        if (value === '') {
            this.value = '';
            hargaHidden.value = '';
            return;
        }

        hargaHidden.value = value;
        this.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
    });

    hargaInput.form.addEventListener('submit', function() {
        hargaHidden.value = hargaInput.value.replace(/[^0-9]/g, '');
    });
}
</script>