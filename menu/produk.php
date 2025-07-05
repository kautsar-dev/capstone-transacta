<?php
ob_start(); // Untuk mencegah warning header already sent

$main_url = '/';
$title = "Data Produk - sistemkasir";
require "../config/config.php";

// Proses simpan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_tambah'])) {
  $nama_barang  = $_POST['nama_barang'];
  $kategori     = $_POST['kategori'];
  $stok         = $_POST['stok'];

  $stmt = $koneksi->prepare("INSERT INTO produk (nama_produk, id_kategori, stok) VALUES (?, ?, ?)");
  $stmt->bind_param("ssi", $nama_barang, $kategori, $stok);
  $stmt->execute();

  header("Location: produk.php");
  exit;
}


// Hapus produk berdasarkan id
if (isset($_GET['hapus'])) {
  $id_hapus = intval($_GET['hapus']);

  $stmt = $koneksi->prepare("DELETE FROM produk WHERE id = ?");
  if ($stmt) {
    $stmt->bind_param("i", $id_hapus);
    $stmt->execute();
    $stmt->close();
  }
  header("Location: produk.php");
  exit;
}

// Proses Edit Produk
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_edit'])) {
  $id_edit       = $_POST['id_edit'];
  $nama_edit     = $_POST['nama_barang_edit'];
  $kategori_edit = $_POST['kategori_edit'];
  $stok_edit     = $_POST['stok_edit'];

  $stmt = $koneksi->prepare("UPDATE produk SET nama_produk=?, id_kategori=?, stok=? WHERE id=?");
  $stmt->bind_param("ssii", $nama_edit, $kategori_edit, $stok_edit, $id_edit);
  $stmt->execute();
  header("Location: produk.php");
  exit;
}


// Setelah semua proses POST, baru tampilkan halaman
require "../template/header.php";
require "../template/sidebar.php";
?>

<main class="content-wrapper min-h-screen" role="main" style="background-color: #9ACD9A">
    <?php include '../template/navbar.php';?>
            <h1 class="h2 mb-3">Data Produk</h1>
            <div class="mb-3">
                <form method="get" class="mt-2 mb-2">
                <div class="input-group">
                    <input 
                    type="text" 
                    name="cari" 
                    class="form-control" 
                    placeholder="Cari data (ID, Nama, Kategori, Stok)..." 
                    value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>"
                    >
                    <div class="input-group-append">
                    <button class="btn btn-success" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                    </div>
                </div>
                </form>


                <!-- Tombol tambah menggunakan data-toggle untuk Bootstrap 4 -->
                <button class="btn btn-success mt-2" data-toggle="modal" data-target="#formTambah">Tambah</button>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori Barang</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;

                    // Cek apakah ada pencarian
                    $cari = isset($_GET['cari']) ? '%' . $koneksi->real_escape_string($_GET['cari']) . '%' : null;
                    $view_all = isset($_GET['view']) && $_GET['view'] === 'all';
                    $limit_sql = $view_all ? "" : "LIMIT 10";

                    if ($cari) {
                        if ($view_all) {
                            $stmt = $koneksi->prepare("
                                SELECT produk.*, kategori.kategori 
                                FROM produk 
                                JOIN kategori ON produk.id_kategori = kategori.kategori 
                                WHERE 
                                    produk.id LIKE ? OR 
                                    produk.nama_produk LIKE ? OR 
                                    kategori.kategori LIKE ? OR 
                                    produk.stok LIKE ?
                            ");
                            $stmt->bind_param("ssss", $cari, $cari, $cari, $cari);
                        } else {
                            $stmt = $koneksi->prepare("
                                SELECT produk.*, kategori.kategori 
                                FROM produk 
                                JOIN kategori ON produk.id_kategori = kategori.kategori 
                                WHERE 
                                    produk.id LIKE ? OR 
                                    produk.nama_produk LIKE ? OR 
                                    kategori.kategori LIKE ? OR 
                                    produk.stok LIKE ?
                                LIMIT 10
                            ");
                            $stmt->bind_param("ssss", $cari, $cari, $cari, $cari);
                        }
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } else {
                        $limit_sql = $view_all ? "" : "LIMIT 10";
                        $result = $koneksi->query("
                            SELECT produk.*, kategori.kategori 
                            FROM produk 
                            JOIN kategori ON produk.id_kategori = kategori.kategori
                            $limit_sql
                        ");
                    }
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <!-- Modal Edit Produk -->
                        <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel<?= $row['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <form method="POST" action="">
                                <input type="hidden" name="id_edit" value="<?= $row['id'] ?>">
                                <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang_edit" value="<?= htmlspecialchars($row['nama_produk']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control" name="kategori_edit" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    $kat = $koneksi->query("SELECT kategori FROM kategori");
                                    while ($k = $kat->fetch_assoc()) {
                                        $selected = $k['kategori'] == $row['kategori'] ? 'selected' : '';
                                        echo "<option value='{$k['kategori']}' $selected>{$k['kategori']}</option>";
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" class="form-control" name="stok_edit" value="<?= $row['stok'] ?>" required>
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="submit" name="submit_edit" class="btn btn-success">Simpan Perubahan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>

                        <td><?= $no++ ?></td>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nama_produk'] ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td>
                            <!-- Tombol Edit -->
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id'] ?>">
                                Edit
                            </button>
                            
                            <!-- Tombol Hapus -->
                            <a href="produk.php?hapus=<?= $row['id'] ?>" 
                                onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                class="btn btn-danger btn-sm">
                                Hapus
                            </a>

                            </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Tombol View All (hanya muncul jika belum klik view=all) -->
            <?php
            // Buat URL dasar tanpa spasi
            $current_url = 'produk.php?';
            if (isset($_GET['cari'])) {
                $current_url .= 'cari=' . urlencode($_GET['cari']) . '&';
            }
            ?>
            <?php if (!$view_all): ?>
                <a href="<?= $current_url ?>view=all" class="btn btn-outline-primary">View All</a>
            <?php else: ?>
                <a href="<?= $current_url ?>" class="btn btn-outline-primary">Show Less</a>
            <?php endif; ?>
</main>

<!-- Modal Form Tambah Produk (Bootstrap 4 Compatible) -->
<div class="modal fade" id="formTambah" tabindex="-1" role="dialog" aria-labelledby="formTambahLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="" method="post">
        <div class="modal-body">
            <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <?php
                    $kat = $koneksi->query("SELECT kategori FROM kategori");
                    while ($k = $kat->fetch_assoc()) {
                        echo "<option value='{$k['kategori']}'>{$k['kategori']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
            </div>
        </div>

        <!-- kirim -->
        <div class="modal-footer">
          <button type="submit" name="submit_tambah" class="btn btn-primary">Kirim</button>
          <button type="button" class="btn btn-secondary" style="background-color: red" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require "../template/footer.php"; ?>