<?php
// Include the database connection
include('../conf/config.php');

// Check if 'id' is set in the URL for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch pelanggan data from the database based on the ID
    $query = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id = '$id'");
    $pelanggan = mysqli_fetch_array($query);

    // Check if pelanggan data exists
    if (!$pelanggan) {
        echo "<script>alert('pelanggan not found!'); window.location = 'index.php?page=pelanggan';</script>";
        exit;
    }
}

// Handle form submission (Update pelanggan)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $tipe = $_POST['tipe'];
    $notelepon = $_POST['notelepon'];

    // Update the pelanggan data in the database
    $update_query = "UPDATE pelanggan SET kode_pelanggan = '$kode', nama = '$nama', tipe = '$tipe', notelepon = '$notelepon' WHERE id = '$id'";
    $query = mysqli_query($koneksi, $update_query);

    // Check if the update was successful
    if ($query) {
        echo "<script>alert('Data pelanggan berhasil diupdate!'); window.location = 'index.php?page=pelanggan';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data pelanggan!'); window.location = 'index.php?page=pelanggan';</script>";
    }
}
?>

<!-- Content Section -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Edit Data pelanggan</h3>
      </div>
      <div class="card-body">
        <!-- Form for editing pelanggan data -->
        <form method="POST" action="">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kode">Kode pelanggan</label>
                <input type="text" class="form-control" name="kode" value="<?php echo $pelanggan['kode_pelanggan']; ?>" readonly>
                <input type="hidden" name="id" value="<?php echo $pelanggan['id']; ?>">
              </div>
              <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="email">Tipe</label>
                  <input type="text" class="form-control" name="tipe" value="<?php echo $pelanggan['tipe']; ?>" required>
                </div>
              </div>
            </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nama">Nama pelanggan</label>
                <input type="text" class="form-control" name="nama" value="<?php echo $pelanggan['nama']; ?>" required>
              </div>
              <div class="form-group">
                  <label for="notelepon">No Telepon</label>
                  <input type="text" class="form-control" name="notelepon" value="<?php echo $pelanggan['notelepon']; ?>" required>
                </div>
            </div>
          </div>
          <button type="submit" class="btn btn-sm btn-info">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</section>
