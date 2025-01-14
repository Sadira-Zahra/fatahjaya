<?php

// Ambil ID transaksi dari URL
$id_transaksi = $_GET['id'];

// Ambil data transaksi
$query_transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id = $id_transaksi");
$transaksi = mysqli_fetch_array($query_transaksi);

// Ambil data spareparts terkait dengan transaksi
$query_spareparts = mysqli_query($koneksi, "SELECT spareparts_transaksi.*, spareparts.nama AS sparepart_name 
                                             FROM spareparts_transaksi
                                             JOIN spareparts ON spareparts_transaksi.id_spareparts = spareparts.id
                                             WHERE spareparts_transaksi.id_transaksi = $id_transaksi");
?>

<div class="container">
    <h2>Detail Spareparts Transaksi - <?php echo $transaksi['kode_transaksi']; ?></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Sparepart</th>
                <th>Nama Sparepart</th>
                <th>Kuantitas</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($sparepart = mysqli_fetch_array($query_spareparts)) { 
                // Ambil harga sparepart dari tabel spareparts
                $query_harga = mysqli_query($koneksi, "SELECT harga FROM spareparts WHERE id = " . $sparepart['id_spareparts']);
                $harga_sparepart = mysqli_fetch_array($query_harga);
                $total_harga = $harga_sparepart['harga'] * $sparepart['kuantitas'];
                ?>
                <tr>
                    <td><?php echo $sparepart['id_spareparts']; ?></td>
                    <td><?php echo $sparepart['sparepart_name']; ?></td>
                    <td><?php echo $sparepart['kuantitas']; ?></td>
                    <td><?php echo number_format($harga_sparepart['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="index.php?page=transaksi" class="btn btn-primary">Kembali</a>
</div>
