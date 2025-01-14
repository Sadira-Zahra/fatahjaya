<?php
// Include the database connection
include('../conf/config.php');

// Check if 'id' is set in the URL for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch servis data from the database based on the ID
    $query = mysqli_query($koneksi, "SELECT * FROM servis WHERE id = '$id'");
    $servis = mysqli_fetch_array($query);

    // Check if servis data exists
    if (!$servis) {
        echo "<script>alert('servis not found!'); window.location = 'index.php?page=servis';</script>";
        exit;
    }
}

// Handle form submission (Update servis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    // Update the servis data in the database
    $update_query = "UPDATE servis SET kode_servis = '$kode', nama = '$nama', harga = '$harga' WHERE id = '$id'";
    $query = mysqli_query($koneksi, $update_query);

    // Check if the update was successful
    if ($query) {
        echo "<script>alert('Data servis berhasil diupdate!'); window.location = 'index.php?page=servis';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data servis!'); window.location = 'index.php?page=servis';</script>";
    }
}
?>

<!-- Content Section -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Edit Data servis</h3>
      </div>
      <div class="card-body">
        <!-- Form for editing servis data -->
        <form method="POST" action="">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kode">Kode servis</label>
                <input type="text" class="form-control" name="kode" value="<?php echo $servis['kode_servis']; ?>" readonly>
                <input type="hidden" name="id" value="<?php echo $servis['id']; ?>">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nama">Nama servis</label>
                <input type="text" class="form-control" name="nama" value="<?php echo $servis['nama']; ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="harga">Harga</label>
                <input type="text" class="form-control" name="harga" value="<?php echo $servis['harga']; ?>" required>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-sm btn-info">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</section>
