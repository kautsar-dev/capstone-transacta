<?php
$main_url = '/';
$title = "Data Kategori - sistemkasir";
require "../config/config.php";

// Proses tambah kategori
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_kategori'])) {
  $kategori = $_POST['kategori'];
  $stmt = $koneksi->prepare("INSERT INTO kategori (kategori) VALUES (?)");
  $stmt->bind_param("s", $kategori);
  $stmt->execute();
  header("Location: datakategori.php");
  exit;
}

require "../template/header.php";
require "../template/sidebar.php";
?>

<!-- Main content -->
<main class="content-wrapper min-h-screen" role="main" style="background-color: #9ACD9A">
  <?php include '../template/navbar.php'; ?>

  <div class="bg-[#c9dfc0] rounded-t-md px-6 py-4 select-none d-flex justify-content-between align-items-center">
    <h1 class="h2">Data Kategori</h1>
    <!-- Tombol Tambah -->
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">+ Tambah</button>
  </div>

  <section class="bg-white p-6 rounded-b-md">
    <div class="flex flex-col gap-4">

      <?php
      $result = $koneksi->query("SELECT * FROM kategori ORDER BY kategori ASC");
      while ($row = $result->fetch_assoc()):
      ?>
        <div class="bg-[#c9dfc0] rounded-md py-6 px-8 flex items-center justify-between select-none w-full">
          <div class="flex items-center gap-4 text-lg font-normal">
            <i class="fas fa-tag"></i>
            <?= htmlspecialchars($row['kategori']) ?>
          </div>
            <!-- Tombol Edit & Hapus -->
          <div class="d-flex gap-2">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditSupplier<?= $kategori['id'] ?>">
              Edit
            </button>
            <a href="?hapus=<?= $kategori['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
              Hapus
            </a>
          </div>
        </div>

      <?php endwhile; ?>

    </div>
  </section>
</main>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="kategori" class="form-label">Nama Kategori</label>
          <input type="text" name="kategori" id="kategori" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit_kategori" class="btn btn-success">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<?php require "../template/footer.php"; ?>