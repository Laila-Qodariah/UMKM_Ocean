<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['error'] = "ID produk tidak valid.";
    header("Location: index.php?menu=produk");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT gambar FROM produk WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    $_SESSION['error'] = "Produk tidak ditemukan.";
    header("Location: index.php?menu=produk");
    exit;
}

if (!empty($data['gambar']) && file_exists("uploads/" . $data['gambar'])) {
    unlink("uploads/" . $data['gambar']);
}

$stmtDelete = mysqli_prepare($conn, "DELETE FROM produk WHERE id = ?");
mysqli_stmt_bind_param($stmtDelete, "i", $id);
mysqli_stmt_execute($stmtDelete);

$_SESSION['success'] = "Produk berhasil dihapus.";
header("Location: index.php?menu=produk");
exit;
?>