<?php
include 'config.php';

if (!isset($_POST['login'])) {
    header("Location: index.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$captcha  = trim($_POST['captcha'] ?? '');

if ($username === '' || $password === '' || $captcha === '') {
    $_SESSION['error'] = "Semua field wajib diisi.";
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['captcha']) || strtolower($captcha) !== strtolower($_SESSION['captcha'])) {
    unset($_SESSION['captcha']);
    $_SESSION['error'] = "Captcha salah.";
    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT id, username, password, nama_lengkap, role, status FROM staff WHERE username = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

$password_valid = ($password === $data['password']);

if (!$password_valid) {
    $_SESSION['error'] = "Password salah.";
    header("Location: index.php");
    exit;
}

if (!$data) {
    $_SESSION['error'] = "Username tidak ditemukan.";
    header("Location: index.php");
    exit;
}

if ($data['status'] !== 'aktif') {
    $_SESSION['error'] = "Akun tidak aktif.";
    header("Location: index.php");
    exit;
}

if ($data && $password === $data['password'])

if (!$password_valid) {
    $_SESSION['error'] = "Password salah.";
    header("Location: index.php");
    exit;
}

$_SESSION['admin_login']    = true;
$_SESSION['admin_id']       = $data['id'];
$_SESSION['admin_nama']     = $data['nama_lengkap'];
$_SESSION['admin_username'] = $data['username'];
$_SESSION['admin_role']     = $data['role'];

unset($_SESSION['captcha']);

$_SESSION['success'] = "Login berhasil.";
header("Location: index.php");
exit;
?>