<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);

if ($id > 0 && isset($_SESSION['keranjang_masuk'][$id])) {
    unset($_SESSION['keranjang_masuk'][$id]);
    $_SESSION['success'] = "Item berhasil dihapus dari keranjang.";
} else {
    $_SESSION['error'] = "Item keranjang tidak ditemukan.";
}

header("Location: index.php?menu=produk_masuk");
exit;
?>