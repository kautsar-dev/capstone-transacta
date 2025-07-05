<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4" id="sidebar">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="sidebar d-flex flex-column">
        <a href="#" class="logo" tabindex="0" aria-label="Logo Transacta">
          <img src="../asset/image/Logo kasir.svg" class="w-12 h-12" alt="Logo"/>
          Transacta
        </a>
        <a href="<?= $main_url ?>dashboard.php" class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" tabindex="0" aria-current="page" aria-label="Dashboard">
        <img src="../asset/image/dashboard.svg" class="w-8 h-8" alt="Logo"/>
          Dashboard
        </a>
        <a href="<?= $main_url ?>menu/produk.php" class="nav-link <?= $current_page == 'produk.php' ? 'active' : '' ?>" tabindex="0" aria-label="Data Produk">
          <img src="../asset/image/produk.svg" class="w-8 h-8" alt="Logo"/>
          Data Produk
        </a>
        <a href="<?= $main_url ?>menu/datakategori.php" class="nav-link <?= $current_page == 'datakategori.php' ? 'active' : '' ?>" tabindex="0" aria-label="Data Kategori">
        <img src="../asset/image/kategori.svg" class="w-8 h-8" alt="Logo"/>
          Data Kategori
        </a>
        <a href="<?= $main_url ?>menu/supplier.php" class="nav-link <?= $current_page == 'supplier.php' ? 'active' : '' ?>" tabindex="0" aria-label="Supplier">
        <img src="../asset/image/supplier.svg" class="w-8 h-8" alt="Logo"/>
          Supplier
        </a>
        <div class="nav-item">
          <!-- Parent link -->
          <button type="button" class="nav-link flex items-center justify-between w-full <?= in_array($current_page, ['pemesanan.php', 'riwayat-pemesanan.php']) ? 'active' : '' ?>" onclick="toggleSubmenu('pemesananMenu')" aria-expanded="false" aria-controls="pemesananMenu">
            <div class="flex items-center gap-2">
              <img src="../asset/image/pembelian.svg" class="w-8 h-8" alt="Logo"/>
              <span>Pemesanan</span>
            </div>
            <svg class="w-4 h-4 transition-transform" id="pemesananChevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M8.59 16.59 13.17 12 8.59 7.41 10 6l6 6-6 6z" />
            </svg>
          </button>

          <!-- Child links -->
          <div id="pemesananMenu" class="submenu hidden ml-6 mt-2 space-y-2 flex flex-column">
            <a href="<?= $main_url ?>menu/pemesanan.php" class="nav-sublink <?= $current_page == 'pemesanan.php' ? 'active' : '' ?>"><i class="far fa-circle nav-icon text-sm"></i> Pemesanan Barang</a>
            <a href="<?= $main_url ?>menu/riwayat-pemesanan.php" class="nav-sublink <?= $current_page == 'riwayat-pemesanan.php' ? 'active' : '' ?>"><i class="far fa-circle nav-icon text-sm"></i> Riwayat Pemesanan</a>
          </div>
        </div>

        <a href="../logout.php" class="logout-link" aria-label="Logout dari aplikasi">
  <svg class="icon" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" role="img" aria-hidden="true"><path d="M16 13v-2H7V7l-5 5 5 5v-4h9Z"/></svg>
  Logout
</a>

      </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <script>
  function toggleSubmenu(id) {
    const menu = document.getElementById(id);
    const chevron = document.getElementById(id + 'Chevron');
    if (menu.classList.contains('hidden')) {
      menu.classList.remove('hidden');
      chevron.style.transform = 'rotate(90deg)';
    } else {
      menu.classList.add('hidden');
      chevron.style.transform = 'rotate(0deg)';
    }
  }
</script>
