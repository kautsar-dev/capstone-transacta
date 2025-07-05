<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    // Belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

// Sudah login, arahkan ke dashboard
header("Location: dashboard.php");
exit;
?>
