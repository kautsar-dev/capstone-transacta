<?php

require "config/config.php"; // koneksi MySQL

// Ambil data total produk
$totalProdukQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM produk");
$totalProduk = mysqli_fetch_assoc($totalProdukQuery)['total'];

// Ambil data total kategori
$totalKategoriQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori");
$totalKategori = mysqli_fetch_assoc($totalKategoriQuery)['total'];

// Ambil data total supplier
$totalSupplierQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM supplier");
$totalSupplier = mysqli_fetch_assoc($totalSupplierQuery)['total'];

// Ambil data stok hampir habis (misal < 5)
$lowStockQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM produk WHERE stok < 5");
$lowStock = mysqli_fetch_assoc($lowStockQuery)['total'];

$title = "Dashboard - sistemkasir";
require "template/header.php";
require "template/sidebar.php";
?>


  <!-- Content Wrapper. Contains page content -->
  <main class="content-wrapper min-h-screen" role="main" style="background-color: #9ACD9A;">
    <?php include 'template/navbar.php';?>

    <section aria-labelledby="summaryTitle">
      <h1 id="summaryTitle" class="h2 mb-3">Ringkasan Gudang</h1>
      
      <div class="summary-cards" aria-label="Statistik ringkasan gudang">
      <article class="summary-card total-product">
        <div class="icon-container"><!-- ikon -->
          <img src="../asset/image/total-prodak.svg" class="w-8 h-8" alt="Logo"/>
        </div>
        <div class="text-content">
          <div class="number"><?= $totalProduk ?></div>
          <div class="label">Total Produk</div>
        </div>
      </article>

      <article class="summary-card category">
        <div class="icon-container"><!-- ikon -->
          <img src="../asset/image/data-kategori.svg" class="w-8 h-8" alt="Logo"/>
        </div>
        <div class="text-content">
          <div class="number"><?= $totalKategori ?></div>
          <div class="label">Kategori</div>
        </div>
      </article>

      <article class="summary-card supplier">
        <div class="icon-container"><!-- ikon -->
          <img src="../asset/image/supplier.svg" class="w-8 h-8" alt="Logo"/>
        </div>
        <div class="text-content">
          <div class="number"><?= $totalSupplier ?></div>
          <div class="label">Supplier</div>
        </div>
      </article>

      <article class="summary-card low-stock">
        <div class="icon-container"><!-- ikon -->
          <img src="../asset/image/hampir-habis.svg" class="w-8 h-8" alt="Logo"/>
        </div>
        <div class="text-content">
          <div class="number"><?= $lowStock ?></div>
          <div class="label">Hampir Habis</div>
        </div>
        <?php if ($lowStock > 0): ?>
        <div class="warning-icon" role="img">!</div>
        <?php endif; ?>
      </article>

      </div>
    </section>


    <section aria-labelledby="statistikTitle" class="mt-4">
      <div class="statistik-box" role="region" aria-live="polite" aria-label="Area statistik">
        <h2 id="statistikTitle">Statistik</h2>
        <!-- Content statistik bisa ditambahkan di sini -->
      </div>
    </section>
  </main>
    <!-- /.content -->
 
<?php

require "template/footer.php";

?>