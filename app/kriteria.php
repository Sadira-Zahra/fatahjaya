<?php
// Include database connection
include('../conf/config.php');

// Handle form submission for adding a new kriteria
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kriteria = $_POST['nama_kriteria'];
    $bobot = $_POST['bobot'];
    $jenis = $_POST['jenis']; // Benefit or Cost

    $query = "INSERT INTO kriteria (nama_kriteria, bobot, jenis) VALUES ('$nama_kriteria', '$bobot', '$jenis')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Kriteria berhasil ditambahkan!'); window.location = 'index.php?page=kriteria';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan kriteria!');</script>";
    }
}

// Handle deletion if action=delete is set in the URL
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM kriteria WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Kriteria berhasil dihapus!'); window.location = 'index.php?page=kriteria';</script>";
    } else {
        echo "<script>alert('Gagal menghapus kriteria!');</script>";
    }
}

// Fetch existing kriteria from the database
$query = "SELECT * FROM kriteria";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kriteria</title>
    <!-- Add your preferred stylesheets -->
</head>
<body>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Kriteria</h3>
                </div>
                <div class="card-body">
                    <!-- Table for displaying kriteria -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($kriteria = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $kriteria['nama_kriteria'] . "</td>";
                                echo "<td>" . $kriteria['bobot'] . "</td>";
                                echo "<td>" . ucfirst($kriteria['jenis']) . "</td>";
                                echo "<td>
                                    <a href='index.php?page=edit_kriteria&id=" . $kriteria['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='kriteria.php?action=delete&id=" . $kriteria['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                                  </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Form for adding new kriteria -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Tambah Kriteria</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="nama_kriteria">Nama Kriteria</label>
                            <input type="text" name="nama_kriteria" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="bobot">Bobot</label>
                            <input type="number" name="bobot" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select name="jenis" class="form-control" required>
                                <option value="benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
