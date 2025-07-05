<?php
session_start();
require "config/config.php";

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}

if (isset($_POST['register'])) {
  $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
  $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role     = $_POST['role'];

  // Cek email duplikat
  $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");
  if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah terdaftar.');</script>";
  } else {
    $query = "INSERT INTO user (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')";
    if (mysqli_query($koneksi, $query)) {
      echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
      echo "<script>alert('Gagal mendaftar.');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-100 min-h-screen flex items-center justify-center">

<form method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-md space-y-5">
  <h2 class="text-2xl font-bold text-center text-green-700">Daftar Akun</h2>

  <input type="text" name="nama" required placeholder="Nama Lengkap" class="w-full p-3 border rounded" />
  <input type="email" name="email" required placeholder="Email" class="w-full p-3 border rounded" />
  <input type="password" name="password" required placeholder="Password" class="w-full p-3 border rounded" />

  <select name="role" required class="w-full p-3 border rounded">
    <option value="" disabled selected>Pilih Role</option>
    <option value="owner">Owner</option>
    <option value="gudang">Gudang</option>
    <option value="operator">Operator</option>
  </select>

  <button type="submit" name="register" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Daftar</button>

  <p class="text-center text-sm">Sudah punya akun? <a href="login.php" class="text-green-700 underline">Login</a></p>
</form>

</body>
</html>
