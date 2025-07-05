<?php
session_start();
session_unset();    // Hapus semua variabel sesi
session_destroy();  // Hancurkan sesi

// Redirect ke login page
header("Location: login.php");
exit;
