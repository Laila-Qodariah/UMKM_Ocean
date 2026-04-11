<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_POST['update'])) {
    header("Location: index.php?menu=produk");
    exit;
}

$id          = (int) $_POST['id'];
$nama_produk = trim($_POST['nama_produk']);
$deskripsi   = trim($_POST['deskripsi']);
$harga       = (float) $_POST['harga'];
$stok        = (int) $_POST['stok'];
$gambar_lama = trim($_POST['gambar_lama']);

if ($id <= 0 || $nama_produk === '' || $harga < 0 || $stok < 0) {
    $_SESSION['error'] = "Data produk tidak valid.";
    header("Location: index.php?menu=edit_produk&id=" . $id);
    exit;
}

$gambar_final = $gambar_lama;

if (!empty($_FILES['gambar']['name'])) {
    $gambar_baru = $_FILES['gambar']['name'];
    $tmp         = $_FILES['gambar']['tmp_name'];
    $error       = $_FILES['gambar']['error'];
    $size        = $_FILES['gambar']['size'];

    $ext = strtolower(pathinfo($gambar_baru, PATHINFO_EXTENSION));
    $valid = ['jpg','jpeg','png','webp'];

    if (!in_array($ext, $valid)) {
        $_SESSION['error'] = "Format gambar harus jpg, jpeg, png, atau webp.";
        header("Location: index.php?menu=edit_produk&id=" . $id);
        exit;
    }

    if ($size > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Ukuran gambar maksimal 2 MB.";
        header("Location: index.php?menu=edit_produk&id=" . $id);
        exit;
    }

    if ($error === 0) {
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        $nama_file = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $gambar_baru);

        if (move_uploaded_file($tmp, "uploads/" . $nama_file)) {
            if ($gambar_lama && file_exists("uploads/" . $gambar_lama)) {
                unlink("uploads/" . $gambar_lama);
            }

            $gambar_final = $nama_file;
        } else {
            $_SESSION['error'] = "Upload gambar gagal.";
            header("Location: index.php?menu=edit_produk&id=" . $id);
            exit;
        }
    }
}

$stmt = mysqli_prepare($conn, "UPDATE produk SET nama_produk = ?, deskripsi = ?, harga = ?, stok = ?, gambar = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "ssdisi", $nama_produk, $deskripsi, $harga, $stok, $gambar_final, $id);
mysqli_stmt_execute($stmt);

$_SESSION['success'] = "Produk berhasil diupdate.";
header("Location: index.php?menu=produk");
exit;
?>