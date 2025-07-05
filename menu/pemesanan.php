<?php
ob_start();

$main_url = '/';
$title = "Data Pembelian - sistemkasir";
require "../config/config.php";

// Generate nomor pesanan otomatis
$tanggal = date('Ymd');
$last = $koneksi->query("SELECT COUNT(*) as total FROM pembelian WHERE tanggal = CURDATE()")->fetch_assoc();
$nomor_pesanan = "PO" . $tanggal . '-' . str_pad($last['total'] + 1, 3, "0", STR_PAD_LEFT);

// Proses simpan pemesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nomor   = $_POST['orderNumber'];
  $user    = $_POST['user'];
  $gudang  = $_POST['warehouse'];
  $supplier = $_POST['supplier'];
  $tanggal = $_POST['orderDate'];
  $catatan = $_POST['orderNotes'];

  $kode_barang = $_POST['kode_barang'];
  $nama_barang = $_POST['nama_barang'];
  $jumlah      = $_POST['jumlah'];
  $satuan      = $_POST['satuan'];
  $harga       = $_POST['harga'];

  $subtotal = 0;
  for ($i = 0; $i < count($kode_barang); $i++) {
    $subtotal += $jumlah[$i] * $harga[$i];
  }
  $ppn = $subtotal * 0.11;
  $total = $subtotal + $ppn;

  $stmt = $koneksi->prepare("INSERT INTO pembelian (nomor_pesanan, user, gudang, supplier, tanggal, catatan, subtotal, ppn, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssddd", $nomor, $user, $gudang, $supplier, $tanggal, $catatan, $subtotal, $ppn, $total);
  $stmt->execute();
  $pembelian_id = $stmt->insert_id;

$stmtDetail = $koneksi->prepare("INSERT INTO riwayat_pemesanan (pembelian_id, kode_barang, nama_barang, jumlah_barang, harga_satuan , total_harga) VALUES (?, ?, ?, ?, ?, ?)");

for ($i = 0; $i < count($kode_barang); $i++) {
  $jumlah_barang = (int) $jumlah[$i];
  $harga_satuan = (float) $harga[$i];
  $total_harga = $jumlah_barang * $harga_satuan;

  $stmtDetail->bind_param("issisd", $pembelian_id, $kode_barang[$i], $nama_barang[$i], $jumlah_barang, $harga_satuan, $total_harga);
  $stmtDetail->execute();
}


  header("Location: riwayat-pemesanan.php");
  exit;
}

require "../template/header.php";
require "../template/sidebar.php";
?>

<main class="content-wrapper min-h-screen" role="main" style="background-color: #9ACD9A;">
  <?php include '../template/navbar.php';?>
  <section class="px-6 py-4">
    <h1 class="px-6 py-4 text-2xl font-semibold bg-[#CCE5CA]">Pemesanan</h1>

    <form id="orderForm" method="POST" class="px-6 py-4 space-y-6 bg-[#F5F5F5]">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <label for="user" class="block font-medium mb-1">User:</label>
          <input type="text" id="user" name="user" class="form-input w-full rounded-md p-1.5 border" placeholder="Gudang" required>
        </div>
        <div>
          <label for="warehouse" class="block font-medium mb-1">Gudang Tujuan:</label>
          <select id="warehouse" name="warehouse" class="form-select w-full rounded-md" required>
            <option selected disabled>-Pilih Gudang-</option>
            <?php
              $gudang = $koneksi->query("SELECT DISTINCT nama_gudang FROM gudang");
              while ($g = $gudang->fetch_assoc()) {
                echo "<option value='{$g['nama_gudang']}'>{$g['nama_gudang']}</option>";
              }
            ?>
          </select>
        </div>
        <div>
          <label for="supplier" class="block font-medium mb-1">Supplier:</label>
          <select id="supplier" name="supplier" class="form-select w-full rounded-md" required>
            <option selected disabled>-Pilih Supplier-</option>
            <?php
              $supplier = $koneksi->query("SELECT nama FROM supplier ORDER BY nama ASC");
              while ($s = $supplier->fetch_assoc()) {
                echo "<option value='{$s['nama']}'>{$s['nama']}</option>";
              }
            ?>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="orderNumber" class="block font-medium mb-1">Nomor Pesanan:</label>
          <input type="text" id="orderNumber" name="orderNumber" value="<?= $nomor_pesanan ?>" readonly class="form-input w-full rounded-md border p-1.5">
        </div>
        <div>
          <label for="orderDate" class="block font-medium mb-1">Tanggal Pemesanan:</label>
          <input type="date" id="orderDate" name="orderDate" class="form-input w-full rounded-md border p-1.5" required>
        </div>
      </div>

      <div>
        <h2 class="text-lg font-semibold mb-2">Daftar Barang</h2>
        <div class="overflow-auto">
          <table class="table-auto w-full bg-white rounded-md shadow">
            <thead class="bg-[#9DD099] text-center">
              <tr>
                <th class="py-2 px-4">No</th>
                <th class="py-2 px-4">Kode Barang</th>
                <th class="py-2 px-4">Nama Barang</th>
                <th class="py-2 px-4">Jumlah Barang</th>
                <th class="py-2 px-4">Harga Satuan</th>
                <th class="py-2 px-4">Total Harga</th>
              </tr>
            </thead>
            <tbody id="itemsBody" class="text-center">
              <!-- Data dinamis -->
            </tbody>
          </table>
        </div>
        <button type="button" class="mt-3 bg-green-100 hover:bg-green-200 px-4 py-2 rounded-md text-sm font-medium" id="addItemBtn">
          + Tambah Barang
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
          <div class="bg-white rounded-md p-3 flex justify-between">
            <span>Subtotal</span>
            <span id="subtotal">Rp. 0</span>
          </div>
          <div class="bg-white rounded-md p-3 flex justify-between">
            <span>PPN (11%)</span>
            <span id="ppn">Rp. 0</span>
          </div>
          <div class="bg-white rounded-md p-3 flex justify-between font-semibold">
            <span>Total</span>
            <span id="totalOrder">Rp. 0</span>
          </div>
        </div>
        <div>
          <label for="orderNotes" class="block font-medium mb-1">Catatan:</label>
          <textarea id="orderNotes" name="orderNotes" rows="4" class="form-textarea w-full rounded-md" placeholder="Catatan tambahan..."></textarea>
        </div>
      </div>

      <div class="flex gap-3">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
          Simpan & Kirim PO
        </button>
        <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md" id="cancelBtn">
          Batal
        </button>
      </div>
    </form>
  </section>
</main>

<script>
  let index = 1;
  document.getElementById('addItemBtn').addEventListener('click', () => {
    const tbody = document.getElementById('itemsBody');
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${index}</td>
      <td><input type="text" name="kode_barang[]" class="form-control" required></td>
      <td><input type="text" name="nama_barang[]" class="form-control" required></td>
      <td><input type="number" name="jumlah[]" class="form-control jumlah" min="1" value="1" required></td>
      <td><input type="number" name="harga[]" class="form-control harga" min="0" value="0" required></td>
      <td class="total-harga">Rp. 0</td>
    `;
    tbody.appendChild(row);
    index++;
    updateCalculationEvents();
  });

  function updateCalculationEvents() {
    document.querySelectorAll('.jumlah, .harga').forEach(input => {
      input.removeEventListener('input', hitungTotal);
      input.addEventListener('input', hitungTotal);
    });
  }

function hitungTotal() {
  let subtotal = 0;
  const jumlahList = document.querySelectorAll('.jumlah');
  const hargaList = document.querySelectorAll('.harga');
  const totalList = document.querySelectorAll('.total-harga');

  jumlahList.forEach((jml, i) => {
    const qty = parseInt(jml.value) || 0;
    const hrg = parseFloat(hargaList[i].value) || 0;
    const totalPerItem = qty * hrg;
    subtotal += totalPerItem;

    if (totalList[i]) {
      totalList[i].innerText = `Rp. ${totalPerItem.toLocaleString()}`;
    }
  });

  const ppn = subtotal * 0.11;
  const total = subtotal + ppn;

  document.getElementById('subtotal').innerText = `Rp. ${subtotal.toLocaleString()}`;
  document.getElementById('ppn').innerText = `Rp. ${ppn.toLocaleString()}`;
  document.getElementById('totalOrder').innerText = `Rp. ${total.toLocaleString()}`;
}
</script>

<?php require "../template/footer.php"; ?>
