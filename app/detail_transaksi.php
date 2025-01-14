<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "stok_sparepart");

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Mendapatkan id_transaksi dari URL
$id_transaksi = isset($_GET['id']) ? $_GET['id'] : '';

// Ambil data transaksi berdasarkan id_transaksi
$transaksi_query = mysqli_query($koneksi, "
    SELECT 
        t.kode_transaksi, 
        p.nama AS nama_pelanggan,
        t.tanggal 
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id
    WHERE t.id = '$id_transaksi'
");

if ($transaksi = mysqli_fetch_array($transaksi_query)) {
    $kode_transaksi = $transaksi['kode_transaksi'];
    $nama_pelanggan = $transaksi['nama_pelanggan'];
    $tanggal = $transaksi['tanggal'];
} else {
    echo "<p>Transaksi tidak ditemukan.</p>";
    exit;
}

// Hitung total dari detail sparepart
$total_query = mysqli_query($koneksi, "
    SELECT SUM(st.kuantitas * sp.harga) AS total
    FROM spareparts_transaksi st
    JOIN spareparts sp ON st.id_spareparts = sp.id
    WHERE st.id_transaksi = '$id_transaksi'
");
$total_result = mysqli_fetch_assoc($total_query);
$total = $total_result['total'] ?? 0;
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Transaksi</h3>
                    </div>
                    <div class="card-body">
                        <h4>Informasi Transaksi:</h4>
                        <p><strong>Kode Transaksi:</strong> <?php echo $kode_transaksi; ?></p>
                        <p><strong>Nama Pelanggan:</strong> <?php echo $nama_pelanggan; ?></p>
                        <p><strong>Total:</strong> <?php echo number_format($total, 0, ',', '.'); ?></p>
                        <p><strong>Tanggal:</strong> <?php echo date('d-m-Y', strtotime($tanggal)); ?></p>

                        <hr>

                        <h4>Detail Sparepart:</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Sparepart</th>
                                    <th>Harga Satuan</th>
                                    <th>Kuantitas</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil data detail sparepart
                                $detail_query = mysqli_query($koneksi, "
                                    SELECT 
                                        sp.nama AS nama_sparepart, 
                                        sp.harga AS harga_satuan,
                                        st.kuantitas,
                                        (sp.harga * st.kuantitas) AS harga_total
                                    FROM spareparts_transaksi st
                                    JOIN spareparts sp ON st.id_spareparts = sp.id
                                    WHERE st.id_transaksi = '$id_transaksi'
                                ");
                                $total_sparepart = 0; // Variabel untuk menampung total sub-total
                                while ($detail = mysqli_fetch_array($detail_query)) {
                                    $total_sparepart += $detail['harga_total']; // Menambahkan harga_total ke variabel
                                    echo "<tr>
                                        <td>{$detail['nama_sparepart']}</td>
                                        <td>Rp " . number_format($detail['harga_satuan'], 0, ',', '.') . "</td>
                                        <td>{$detail['kuantitas']}</td>
                                        <td>Rp " . number_format($detail['harga_total'], 0, ',', '.') . "</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    <td><strong>Rp <?php echo number_format($total_sparepart, 0, ',', '.'); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>

                        <hr>
                        <a href="index.php?page=transaksi" class="btn btn-sm btn-success">Kembali</a>
                        <!-- Tombol cetak -->
                        <button class="btn btn-sm btn-primary" onclick="window.print();">Cetak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
  @media print {
    .btn-success, .btn-primary {
      display: none;
    }
  }
</style>
<script>
  // Menambahkan CSS khusus untuk tampilan cetak agar lebih rapi
  window.addEventListener('beforeprint', () => {
    const body = document.querySelector('body');
    body.style.fontFamily = 'Arial, sans-serif';
  });
</script>
