<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['error'] = "ID staff tidak valid.";
    header("Location: index.php?menu=staff");
    exit;
}

$stmt = mysqli_prepare($conn, "DELETE FROM staff WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    $_SESSION['success'] = "Staff berhasil dihapus.";
} else {
    $_SESSION['error'] = "Data staff tidak ditemukan.";
}

header("Location: index.php?menu=staff");
exit;
?>