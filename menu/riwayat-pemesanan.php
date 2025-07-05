<?php
ob_start();
$main_url = '/';
$title = "Riwayat Pemesanan - sistemkasir";
require "../config/config.php";
require "../template/header.php";
require "../template/sidebar.php";
?>

<main class="content-wrapper min-h-screen" style="background-color: #9ACD9A;">
  <?php include '../template/navbar.php'; ?>
  <section aria-labelledby="riwayatTitle" class="px-6 py-4">
    <div class="max-w-full bg-[#c8e6c9] rounded-md">
      <div class="flex flex-col md:flex-row justify-between items-center px-6 py-4 border-b border-gray-300">
        <h1 id="riwayatTitle" class="text-black text-2xl font-semibold mb-4 md:mb-0">Riwayat Pemesanan</h1>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-[#f5f5f5] text-black text-sm md:text-base font-normal">
          <thead class="bg-green-100">
            <tr class="border-b border-gray-300 text-center">
              <th class="border-r border-gray-300 py-3 px-4">No</th>
              <th class="border-r border-gray-300 py-3 px-4">Nomor Pesanan</th>
              <th class="border-r border-gray-300 py-3 px-4">Nama Barang</th>
              <th class="border-r border-gray-300 py-3 px-4">Jumlah Barang</th>
              <th class="border-r border-gray-300 py-3 px-4">Total Setelah PPN</th>
              <th class="py-3 px-4">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $query = "
            SELECT 
              pembelian.nomor_pesanan,
              pembelian.tanggal,
              riwayat_pemesanan.nama_barang,
              riwayat_pemesanan.jumlah_barang,
              pembelian.total
            FROM riwayat_pemesanan
            JOIN pembelian ON riwayat_pemesanan.pembelian_id = pembelian.id
            ORDER BY pembelian.tanggal DESC
            ";
            $result = $koneksi->query($query);

            if ($result && $result->num_rows > 0):
              while ($row = $result->fetch_assoc()):
            ?>
            <tr class="border-b border-gray-300 text-center">
              <td class="border-r border-gray-300 py-3 px-4"><?= $no++ ?></td>
              <td class="border-r border-gray-300 py-3 px-4"><?= htmlspecialchars($row['nomor_pesanan']) ?></td>
              <td class="border-r border-gray-300 py-3 px-4"><?= htmlspecialchars($row['nama_barang'] ?? '-') ?></td>
              <td class="border-r border-gray-300 py-3 px-4"><?= htmlspecialchars($row['jumlah_barang'] ?? '-') ?></td>
              <td class="border-r border-gray-300 py-3 px-4">
                Rp <?= number_format((float)($row['total'] ?? 0), 0, ',', '.') ?>
              </td>
              <td class="py-3 px-4 text-green-600">Terkirim</td>
            </tr>
            <?php
              endwhile;
            else:
              echo "<tr><td colspan='7' class='text-center py-4'>Belum ada pemesanan.</td></tr>";
            endif;
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</main>

<?php require "../template/footer.php"; ?>
