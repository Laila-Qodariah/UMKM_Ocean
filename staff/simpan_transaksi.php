<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_POST['simpan_transaksi'])) {
    header("Location: index.php?menu=produk_masuk");
    exit;
}

$keranjang  = $_SESSION['keranjang_masuk'] ?? [];
$keterangan = trim($_POST['keterangan'] ?? '');

if (empty($keranjang)) {
    $_SESSION['error'] = "Keranjang masih kosong.";
    header("Location: index.php?menu=produk_masuk");
    exit;
}

mysqli_begin_transaction($conn);

try {
    $tanggal      = date('Y-m-d H:i:s');
    $kodeTransaksi = 'PM-' . date('YmdHis');
    $supplier     = null;
    $created_by   = $_SESSION['admin_id'] ?? 0;
    $total_item   = 0;

    foreach ($keranjang as $item) {
        $total_item += (int)$item['qty'];
    }

    $stmtTransaksi = mysqli_prepare(
        $conn,
        "INSERT INTO produk_masuk (kode_transaksi, tanggal, supplier, keterangan, total_item, created_by)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param(
        $stmtTransaksi,
        "ssssii",
        $kodeTransaksi,
        $tanggal,
        $supplier,
        $keterangan,
        $total_item,
        $created_by
    );
    mysqli_stmt_execute($stmtTransaksi);

    if (!$stmtTransaksi) {
        throw new Exception("Gagal insert ke produk_masuk");
    }

    $transaksi_id = mysqli_insert_id($conn);

    foreach ($keranjang as $item) {
        $produk_id = (int)$item['produk_id'];
        $qty       = (int)$item['qty'];

        $cekProduk = mysqli_prepare($conn, "SELECT stok FROM produk WHERE id = ? LIMIT 1");
        mysqli_stmt_bind_param($cekProduk, "i", $produk_id);
        mysqli_stmt_execute($cekProduk);
        $resultProduk = mysqli_stmt_get_result($cekProduk);
        $dataProduk = mysqli_fetch_assoc($resultProduk);

        if (!$dataProduk) {
            throw new Exception("Produk tidak ditemukan.");
        }

        $stok_sebelum = (int)$dataProduk['stok'];
        $stok_sesudah = $stok_sebelum + $qty;

        $stmtDetail = mysqli_prepare(
            $conn,
            "INSERT INTO produk_masuk_detail (transaksi_id, produk_id, qty, stok_sebelum, stok_sesudah)
             VALUES (?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param(
            $stmtDetail,
            "iiiii",
            $transaksi_id,
            $produk_id,
            $qty,
            $stok_sebelum,
            $stok_sesudah
        );
        mysqli_stmt_execute($stmtDetail);

        $stmtUpdate = mysqli_prepare($conn, "UPDATE produk SET stok = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmtUpdate, "ii", $stok_sesudah, $produk_id);
        mysqli_stmt_execute($stmtUpdate);
    }

    mysqli_commit($conn);

    unset($_SESSION['keranjang_masuk']);
    $_SESSION['success'] = "Transaksi barang masuk berhasil disimpan dan stok produk sudah bertambah.";
    header("Location: index.php?menu=produk_masuk");
    exit;

} catch (Throwable $e) {
    mysqli_rollback($conn);
    $_SESSION['error'] = "Gagal menyimpan transaksi masuk: " . $e->getMessage();
    header("Location: index.php?menu=produk_masuk");
    exit;
}
?>