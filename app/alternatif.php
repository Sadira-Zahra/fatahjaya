<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "stok_sparepart");

// Menangani form submission untuk menambah alternatif
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nama_alternatif = $_POST['nama_alternatif'];
    $id_supplier = $_POST['id_supplier'];

    // Query untuk menambahkan alternatif
    $query = "INSERT INTO alternatif (nama_alternatif, id_supplier) VALUES ('$nama_alternatif', '$id_supplier')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Alternatif berhasil ditambahkan!'); window.location = 'index.php?page=alternatif';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan alternatif!'); window.location = 'index.php?page=alternatif';</script>";
    }
}

// Menangani aksi hapus alternatif
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM alternatif WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Alternatif berhasil dihapus!'); window.location = 'index.php?page=alternatif';</script>";
    } else {
        echo "<script>alert('Gagal menghapus alternatif!'); window.location = 'index.php?page=alternatif';</script>";
    }
}

// Query untuk menampilkan data alternatif beserta nama supplier
$query = "SELECT alternatif.id, alternatif.nama_alternatif, suppliers.nama AS nama_supplier 
          FROM alternatif 
          JOIN suppliers ON alternatif.id_supplier = suppliers.id";
$result = mysqli_query($koneksi, $query);
$alternatives = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alternatif</title>
    <!-- Include Bootstrap and your stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Alternatif</h3>
            </div>
            <div class="card-body">
                <!-- Tombol untuk membuka modal tambah alternatif -->
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#modal-add">Tambah Alternatif</button>

                <!-- Tabel Menampilkan Alternatif -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Alternatif</th>
                            <th>Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($alternatives) > 0): ?>
                            <?php foreach ($alternatives as $index => $alt): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo $alt['nama_alternatif']; ?></td>
                                    <td><?php echo $alt['nama_supplier']; ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                        <a href="index.php?page=alternatif&action=delete&id=<?php echo $alt['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus alternatif ini?')">Hapus</a>
                                        </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data alternatif.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Alternatif -->
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Alternatif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_alternatif">Nama Alternatif</label>
                            <input type="text" class="form-control" name="nama_alternatif" required>
                        </div>
                        <div class="form-group">
                            <label for="id_supplier">Supplier</label>
                            <select class="form-control" name="id_supplier" required>
                                <option value="">-- Pilih Supplier --</option>
                                <?php
                                // Query untuk mendapatkan data supplier
                                $query = "SELECT id, nama FROM suppliers";
                                $result = mysqli_query($koneksi, $query);
                                while ($supplier = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$supplier['id']}'>{$supplier['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="action" value="add">Tambah Alternatif</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
