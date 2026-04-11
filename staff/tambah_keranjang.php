<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_POST['tambah'])) {
    header("Location: index.php?menu=produk_masuk");
    exit;
}

$produk_id = (int)($_POST['produk_id'] ?? 0);
$qty       = (int)($_POST['qty'] ?? 0);

if ($produk_id <= 0 || $qty <= 0) {
    $_SESSION['error'] = "Produk dan jumlah harus valid.";
    header("Location: index.php?menu=produk_masuk");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT id, nama_produk, stok, gambar FROM produk WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $produk_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    $_SESSION['error'] = "Produk tidak ditemukan.";
    header("Location: index.php?menu=produk_masuk");
    exit;
}

if (!isset($_SESSION['keranjang_masuk'])) {
    $_SESSION['keranjang_masuk'] = [];
}

if (isset($_SESSION['keranjang_masuk'][$produk_id])) {
    $_SESSION['keranjang_masuk'][$produk_id]['qty'] += $qty;
} else {
    $_SESSION['keranjang_masuk'][$produk_id] = [
        'produk_id'   => $produk['id'],
        'nama_produk' => $produk['nama_produk'],
        'gambar'      => $produk['gambar'],
        'qty'         => $qty
    ];
}

$_SESSION['success'] = "Produk berhasil ditambahkan ke keranjang.";
header("Location: index.php?menu=produk_masuk");
exit;
?>