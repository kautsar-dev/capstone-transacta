<?php
$main_url = '/';
$title = "Data Supplier - sistemkasir";
require "../config/config.php";

// Menambahkan supplier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_supplier'])) {
  $nama     = $_POST['nama'];
  $email    = $_POST['email'];
  $telepon  = $_POST['telepon'];
  $alamat   = $_POST['alamat'];

  $stmt = $koneksi->prepare("INSERT INTO supplier (nama, email, telepon, alamat) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $nama, $email, $telepon, $alamat);
  $stmt->execute();
}

// Menghapus supplier
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $stmt = $koneksi->prepare("DELETE FROM supplier WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header("Location: supplier.php");
  exit;
}

// Edit supplier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_edit_supplier'])) {
  $id       = $_POST['id'];
  $nama     = $_POST['nama'];
  $email    = $_POST['email'];
  $telepon  = $_POST['telepon'];
  $alamat   = $_POST['alamat'];

  $stmt = $koneksi->prepare("UPDATE supplier SET nama=?, email=?, telepon=?, alamat=? WHERE id=?");
  $stmt->bind_param("ssssi", $nama, $email, $telepon, $alamat, $id);
  $stmt->execute();
  header("Location: supplier.php");
  exit;
}


require "../template/header.php";
require "../template/sidebar.php";
?>


<!-- Content Wrapper -->
<main class="content-wrapper min-vh-100" role="main" style="background-color: #9ACD9A;">
  <?php include '../template/navbar.php'; ?>

  <section aria-labelledby="supplierTitle">
    <div class="bg-success-subtle rounded-top px-6 py-4 d-flex justify-content-between align-items-center">
      <h1 id="supplierTitle" class="h2 mb-0">Supplier</h1>
      <!-- Tombol Tambah -->
      <button type="button" class="btn btn-light d-flex align-items-center gap-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambahSupplier">
        <strong>+</strong> Tambah
      </button>

    </div>

    <section class="bg-white rounded-bottom p-4">
      <?php
      $query = "SELECT * FROM supplier ORDER BY nama ASC";
      $result = mysqli_query($koneksi, $query);

      if (mysqli_num_rows($result) > 0):
while ($supplier = mysqli_fetch_assoc($result)):
  $inisial = strtoupper(substr($supplier['nama'], 0, 2));
?>
<div class="d-flex justify-content-between align-items-center bg-success-subtle rounded p-3 mb-3">
  <!-- KIRI: Inisial + Informasi -->
  <div class="d-flex align-items-center gap-4">
    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-weight: bold;">
      <?= $inisial ?>
    </div>
    <div>
      <div class="fw-semibold fs-5"><?= htmlspecialchars($supplier['nama']) ?></div>
      <div class="text-muted small">📧 <?= htmlspecialchars($supplier['email']) ?></div>
      <div class="text-muted small">📞 <?= htmlspecialchars($supplier['telepon']) ?></div>
      <div class="text-muted small">📍 <?= htmlspecialchars($supplier['alamat']) ?></div>
    </div>
  </div>

  <!-- Tombol Edit & Hapus -->
  <div class="d-flex gap-2">
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditSupplier<?= $supplier['id'] ?>">
      Edit
    </button>
    <a href="?hapus=<?= $supplier['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus supplier ini?')">
      Hapus
    </a>
  </div>
</div>

  <!-- Modal Edit Supplier (dalam loop) -->
  <div class="modal fade" id="modalEditSupplier<?= $supplier['id'] ?>" tabindex="-1" aria-labelledby="modalEditSupplierLabel<?= $supplier['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditSupplierLabel<?= $supplier['id'] ?>">Edit Supplier</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?= $supplier['id'] ?>">
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($supplier['nama']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($supplier['email']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($supplier['telepon']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required><?= htmlspecialchars($supplier['alamat']) ?></textarea>
          </div>
        </div>
        <div class="modal-footer tex">
          <button type="submit" name="submit_edit_supplier" class="btn btn-success">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
<?php endwhile;

      else:
        echo "<div class='text-muted'>Belum ada data supplier.</div>";
      endif;
      ?>
    </section>
  </section>
</main>

<!-- Modal Tambah Supplier -->
<div class="modal fade" id="modalTambahSupplier" tabindex="-1" aria-labelledby="modalTambahSupplierLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahSupplierLabel">Tambah Data Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nama Supplier</label>
          <input type="text" name="nama" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Nomor Telepon</label>
          <input type="text" name="telepon" class="form-control" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Alamat</label>
          <textarea name="alamat" class="form-control" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit_supplier" class="btn btn-success">Simpan Supplier</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<?php require "../template/footer.php"; ?>