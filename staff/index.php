<?php
include 'config.php';

if (!isset($_SESSION['admin_login'])) {
    include 'login.php';
    exit;
}

include 'dashboard.php';
?>