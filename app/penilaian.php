<?php
// Include database connection
include('../conf/config.php');

// Handle form submission for adding a new penilaian
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_alternatif = $_POST['id_alternatif'];
    $id_kriteria = $_POST['id_kriteria'];
    $nilai = $_POST['nilai'];

    $query = "INSERT INTO penilaian (id_alternatif, id_kriteria, nilai) VALUES ('$id_alternatif', '$id_kriteria', '$nilai')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Penilaian berhasil ditambahkan!'); window.location = 'index.php?page=penilaian';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan penilaian!');</script>";
    }
}

// Handle deletion if action=delete is set in the URL
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM penilaian WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Penilaian berhasil dihapus!'); window.location = 'index.php?page=penilaian';</script>";
    } else {
        echo "<script>alert('Gagal menghapus penilaian!');</script>";
    }
}

// Fetch existing penilaian from the database
$query = "SELECT penilaian.id, alternatif.nama_alternatif, kriteria.nama_kriteria, penilaian.nilai
          FROM penilaian
          INNER JOIN alternatif ON penilaian.id_alternatif = alternatif.id
          INNER JOIN kriteria ON penilaian.id_kriteria = kriteria.id";
$result = mysqli_query($koneksi, $query);

// Fetch data for dropdowns
$alternatif_query = "SELECT * FROM alternatif";
$alternatif_result = mysqli_query($koneksi, $alternatif_query);

$kriteria_query = "SELECT * FROM kriteria";
$kriteria_result = mysqli_query($koneksi, $kriteria_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penilaian</title>
    <!-- Add your preferred stylesheets -->
</head>
<body>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Penilaian</h3>
                </div>
                <div class="card-body">
                    <!-- Table for displaying penilaian -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Alternatif</th>
                                <th>Kriteria</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($penilaian = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $penilaian['nama_alternatif'] . "</td>";
                                echo "<td>" . $penilaian['nama_kriteria'] . "</td>";
                                echo "<td>" . $penilaian['nilai'] . "</td>";
                                echo "<td>
                                    <a href='penilaian.php?action=delete&id=" . $penilaian['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                                  </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Form for adding new penilaian -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Tambah Penilaian</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="id_alternatif">Alternatif</label>
                            <select name="id_alternatif" class="form-control" required>
                                <option value="">Pilih Alternatif</option>
                                <?php
                                while ($alternatif = mysqli_fetch_assoc($alternatif_result)) {
                                    echo "<option value='" . $alternatif['id'] . "'>" . $alternatif['nama_alternatif'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_kriteria">Kriteria</label>
                            <select name="id_kriteria" class="form-control" required>
                                <option value="">Pilih Kriteria</option>
                                <?php
                                while ($kriteria = mysqli_fetch_assoc($kriteria_result)) {
                                    echo "<option value='" . $kriteria['id'] . "'>" . $kriteria['nama_kriteria'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nilai">Nilai</label>
                            <input type="number" name="nilai" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
