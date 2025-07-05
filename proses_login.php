<?php
session_start();
require "config/config.php"; // pastikan path benar

if (isset($_POST['login'])) {
  $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
  $password = $_POST['password'];

  $query = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email' LIMIT 1");

  if (mysqli_num_rows($query) === 1) {
    $user = mysqli_fetch_assoc($query);

    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id']   = $user['id_user'];
      $_SESSION['user_name'] = $user['nama'];
      $_SESSION['user_role'] = $user['role'];

      // Login berhasil, arahkan ke dashboard
      header("Location: dashboard.php");
      exit;
    } else {
      echo "<script>alert('Password salah!'); window.location='login.php';</script>";
    }
  } else {
    echo "<script>alert('Email tidak terdaftar!'); window.location='login.php';</script>";
  }
} else {
  header("Location: login.php");
  exit;
}
