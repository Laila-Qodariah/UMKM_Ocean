<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_POST['update'])) {
    header("Location: index.php?menu=staff");
    exit;
}

$id           = (int) ($_POST['id'] ?? 0);
$username     = trim($_POST['username'] ?? '');
$password     = trim($_POST['password'] ?? '');
$nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
$role         = trim($_POST['role'] ?? '');
$status       = trim($_POST['status'] ?? '');

if ($id <= 0 || $username === '' || $nama_lengkap === '' || $role === '' || $status === '') {
    $_SESSION['error'] = "Data staff wajib diisi lengkap.";
    header("Location: index.php?menu=edit_staff&id=" . $id);
    exit;
}

$cek = mysqli_prepare($conn, "SELECT id FROM staff WHERE username = ? AND id != ?");
mysqli_stmt_bind_param($cek, "si", $username, $id);
mysqli_stmt_execute($cek);
$cekResult = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($cekResult) > 0) {
    $_SESSION['error'] = "Username sudah digunakan oleh staff lain.";
    header("Location: index.php?menu=edit_staff&id=" . $id);
    exit;
}

if ($password !== '') {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "UPDATE staff SET username = ?, password = ?, nama_lengkap = ?, role = ?, status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssssi", $username, $password_hash, $nama_lengkap, $role, $status, $id);
} else {
    $stmt = mysqli_prepare($conn, "UPDATE staff SET username = ?, nama_lengkap = ?, role = ?, status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $nama_lengkap, $role, $status, $id);
}

mysqli_stmt_execute($stmt);

$_SESSION['success'] = "Data staff berhasil diupdate.";
header("Location: index.php?menu=staff");
exit;
?>