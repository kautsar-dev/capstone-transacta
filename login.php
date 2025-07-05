<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}
$title = "Login - sistemkasir";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title><?= $title ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center relative overflow-hidden">

  <!-- Dekorasi -->
  <div class="absolute -top-24 -right-24 w-[350px] h-[350px] rounded-full bg-green-300 opacity-70"></div>
  <div class="absolute -bottom-24 -left-24 w-[350px] h-[350px] rounded-full bg-green-300 opacity-70"></div>

  <!-- Form Login -->
  <form action="proses_login.php" method="POST" class="z-10 bg-white shadow-lg rounded-xl px-8 py-10 w-full max-w-md space-y-6">
    <h1 class="text-3xl font-extrabold text-center text-green-700">Login</h1>

    <!-- Email -->
    <div class="flex items-center bg-[#CCE5CA] rounded-lg px-5 py-4 space-x-4">
      <img src="https://storage.googleapis.com/a1aa/image/0231b977-1409-4f21-7f0f-261ca61694ff.jpg" class="w-6 h-6" />
      <input type="email" name="email" placeholder="Email" required class="bg-[#CCE5CA] text-black text-lg w-full focus:outline-none" />
    </div>

    <!-- Password -->
    <div class="flex items-center bg-[#CCE5CA] rounded-lg px-5 py-4 space-x-4">
      <img src="https://storage.googleapis.com/a1aa/image/03286072-e2bb-4bee-bee5-9c862b0ff92e.jpg" class="w-6 h-6" />
      <input type="password" name="password" placeholder="Password" required class="bg-[#CCE5CA] text-black text-lg w-full focus:outline-none" />
    </div>

    <!-- Tombol -->
    <button type="submit" name="login" class="bg-[#3DA235] text-white font-semibold rounded-md w-full py-3 hover:bg-green-700 transition">
      Masuk
    </button>

    <div class="text-center text-sm text-gray-700">
      Belum punya akun? <a href="register.php" class="text-green-700 font-semibold hover:underline">Daftar</a>
    </div>
  </form>

</body>
</html>
