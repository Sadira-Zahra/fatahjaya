<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "stok_sparepart");

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Cek apakah form tambah transaksi disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $kode_transaksi = $_POST['kode_transaksi'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $tanggal = $_POST['tanggal'];
    $spareparts = $_POST['spareparts']; // array of spareparts with their quantities

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        // Insert transaksi baru tanpa kolom 'status'
        $query = "INSERT INTO transaksi (kode_transaksi, id_pelanggan, tanggal) 
                  VALUES ('$kode_transaksi', '$id_pelanggan', '$tanggal')";
        if (!mysqli_query($koneksi, $query)) {
            throw new Exception("Gagal menambahkan transaksi");
        }

        // Ambil ID transaksi yang baru saja dimasukkan
        $id_transaksi = mysqli_insert_id($koneksi);
        $total = 0; // Variabel untuk menghitung total transaksi

        // Loop melalui spareparts yang dibeli
        foreach ($spareparts as $data_sparepart) {
            $id_sparepart = $data_sparepart['id'];
            $kuantitas = $data_sparepart['kuantitas'];

            // Cek stok sparepart sebelum transaksi
            $stok_query = "SELECT stok FROM spareparts WHERE id = '$id_sparepart'";
            $stok_result = mysqli_query($koneksi, $stok_query);
            $stok_data = mysqli_fetch_assoc($stok_result);

            if ($stok_data['stok'] < $kuantitas) {
                throw new Exception("Stok sparepart tidak cukup untuk sparepart ID: $id_sparepart");
            }

            // Insert data transaksi sparepart
            $query_sparepart = "INSERT INTO spareparts_transaksi (id_transaksi, id_spareparts, kuantitas) 
                                VALUES ('$id_transaksi', '$id_sparepart', '$kuantitas')";
            if (!mysqli_query($koneksi, $query_sparepart)) {
                throw new Exception("Gagal menambahkan sparepart transaksi");
            }

            // Hitung total harga
            $harga_query = "SELECT harga FROM spareparts WHERE id = '$id_sparepart'";
            $harga_result = mysqli_query($koneksi, $harga_query);
            $harga_data = mysqli_fetch_assoc($harga_result);
            $total += $harga_data['harga'] * $kuantitas;

            // Update stok sparepart
            $query_update = "UPDATE spareparts SET stok = stok - $kuantitas WHERE id = '$id_sparepart'";
            if (!mysqli_query($koneksi, $query_update)) {
                throw new Exception("Gagal memperbarui stok sparepart");
            }
        }

        // Update transaksi dengan total harga (tanpa status)
        $query_update_transaksi = "UPDATE transaksi SET total = $total WHERE id = '$id_transaksi'";
        if (!mysqli_query($koneksi, $query_update_transaksi)) {
            throw new Exception("Gagal memperbarui transaksi");
        }

        // Commit transaksi
        mysqli_commit($koneksi);

        echo "<script>alert('Transaksi berhasil ditambahkan!'); window.location.href='index.php?page=transaksi';</script>";
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        mysqli_rollback($koneksi);
        echo "<script>alert('Transaksi gagal: " . $e->getMessage() . "'); window.location.href='index.php?page=transaksi';</script>";
    }
}
?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">
                            Tambah Transaksi
                        </button>
                        <br><br>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php
    // Menampilkan transaksi
    $query = "SELECT transaksi.*, pelanggan.nama 
              FROM transaksi 
              JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id";
    $result = mysqli_query($koneksi, $query);

    while ($transaksi = mysqli_fetch_array($result)) {
        // Hitung total dari detail sparepart
        $id_transaksi = $transaksi['id'];
        $total_query = mysqli_query($koneksi, "
            SELECT SUM(st.kuantitas * sp.harga) AS total
            FROM spareparts_transaksi st
            JOIN spareparts sp ON st.id_spareparts = sp.id
            WHERE st.id_transaksi = '$id_transaksi'
        ");
        $total_result = mysqli_fetch_assoc($total_query);
        $total = $total_result['total'] ?? 0;

        echo "<tr>
              <td>{$transaksi['kode_transaksi']}</td>
              <td>{$transaksi['nama']}</td>
              <td>" . number_format($total, 0, ',', '.') . "</td>
              <td>{$transaksi['tanggal']}</td>
              <td>
              <a href='index.php?page=detail_transaksi&id={$transaksi['id']}' class='btn btn-sm btn-info'>Detail</a>
              </td>
              </tr>";
    }
    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal for adding transaksi -->
<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="transaksi.php">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Kode Transaksi" name="kode_transaksi" required>
                        </div>
                        <div class="col">
                            <select class="form-control" name="id_pelanggan" required>
                                <option value="">Pilih Pelanggan</option>
                                <?php
                                // Menampilkan data pelanggan untuk dropdown
                                $pelanggan_query = "SELECT * FROM pelanggan";
                                $pelanggan_result = mysqli_query($koneksi, $pelanggan_query);
                                while ($pelanggan = mysqli_fetch_array($pelanggan_result)) {
                                    echo "<option value='{$pelanggan['id']}'>{$pelanggan['nama']} ({$pelanggan['kode_pelanggan']})</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                    </div>

                    <div id="spareparts-container" class="form-row mt-3">
                        <label>Spareparts</label>
                        <div class="col">
                            <select class="form-control" name="spareparts[1][id]" required>
                                <option value="">Pilih Sparepart</option>
                                <?php
                                // Menampilkan spareparts untuk dropdown
                                $sparepart_query = "SELECT * FROM spareparts";
                                $sparepart_result = mysqli_query($koneksi, $sparepart_query);
                                while ($sparepart = mysqli_fetch_array($sparepart_result)) {
                                    echo "<option value='{$sparepart['id']}'>{$sparepart['nama']} - Stok: {$sparepart['stok']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="spareparts[1][kuantitas]" placeholder="Jumlah" required>
                        </div>
                    </div>

                    <button type="button" id="add-sparepart" class="btn btn-primary mt-2">Tambah Sparepart</button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let sparepartCount = 1;

    document.getElementById('add-sparepart').addEventListener('click', function () {
        sparepartCount++;
        const newSparepart = `
            <div class="form-row mt-3">
                <div class="col">
                    <select class="form-control" name="spareparts[${sparepartCount}][id]" required>
                        <option value="">Pilih Sparepart</option>
                        <?php
                        // Menampilkan spareparts untuk dropdown
                        $sparepart_query = "SELECT * FROM spareparts";
                        $sparepart_result = mysqli_query($koneksi, $sparepart_query);
                        while ($sparepart = mysqli_fetch_array($sparepart_result)) {
                            echo "<option value='{$sparepart['id']}'>{$sparepart['nama']} - Stok: {$sparepart['stok']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="spareparts[${sparepartCount}][kuantitas]" placeholder="Jumlah" required>
                </div>
            </div>
        `;
        document.getElementById('spareparts-container').insertAdjacentHTML('beforeend', newSparepart);
    });
</script>
