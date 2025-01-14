<?php
// Include database connection
include('../conf/config.php');

// Get the ID of the kriteria to edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing data for the kriteria
    $query = "SELECT * FROM kriteria WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Kriteria tidak ditemukan!'); window.location = 'kriteria.php';</script>";
    }
} else {
    echo "<script>alert('ID Kriteria tidak ditemukan!'); window.location = 'kriteria.php';</script>";
}

// Handle form submission for editing kriteria
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kriteria = $_POST['nama_kriteria'];
    $bobot = $_POST['bobot'];
    $jenis = $_POST['jenis']; // Benefit or Cost

    // Update query
    $query = "UPDATE kriteria SET nama_kriteria = '$nama_kriteria', bobot = '$bobot', jenis = '$jenis' WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Kriteria berhasil diperbarui!'); window.location = 'index.php?page=kriteria';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui kriteria!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kriteria</title>
    <!-- Add your preferred stylesheets -->
</head>
<body>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Kriteria</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="nama_kriteria">Nama Kriteria</label>
                            <input type="text" name="nama_kriteria" class="form-control" value="<?php echo $data['nama_kriteria']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="bobot">Bobot</label>
                            <input type="number" name="bobot" class="form-control" step="0.01" value="<?php echo $data['bobot']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select name="jenis" class="form-control" required>
                                <option value="benefit" <?php echo $data['jenis'] === 'benefit' ? 'selected' : ''; ?>>Benefit</option>
                                <option value="cost" <?php echo $data['jenis'] === 'cost' ? 'selected' : ''; ?>>Cost</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="kriteria.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
