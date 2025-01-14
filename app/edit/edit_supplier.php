<?php
// Include the database connection
include('../conf/config.php');

// Check if 'id' is set in the URL for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch supplier data from the database based on the ID
    $query = mysqli_query($koneksi, "SELECT * FROM suppliers WHERE id = '$id'");
    $supplier = mysqli_fetch_array($query);

    // Check if supplier data exists
    if (!$supplier) {
        echo "<script>alert('Supplier not found!'); window.location = 'index.php?page=supplier';</script>";
        exit;
    }
}

// Handle form submission (Update Supplier)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    // Update the supplier data in the database
    $update_query = "UPDATE suppliers SET kode_supplier = '$kode', nama = '$nama', email = '$email', alamat = '$alamat' WHERE id = '$id'";
    $query = mysqli_query($koneksi, $update_query);

    // Check if the update was successful
    if ($query) {
        echo "<script>alert('Data supplier berhasil diupdate!'); window.location = 'index.php?page=supplier';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data supplier!'); window.location = 'index.php?page=supplier';</script>";
    }
}
?>

<!-- Content Section -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Edit Data Supplier</h3>
      </div>
      <div class="card-body">
        <!-- Form for editing supplier data -->
        <form method="POST" action="">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kode">Kode Supplier</label>
                <input type="text" class="form-control" name="kode" value="<?php echo $supplier['kode_supplier']; ?>" readonly>
                <input type="hidden" name="id" value="<?php echo $supplier['id']; ?>">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nama">Nama Supplier</label>
                <input type="text" class="form-control" name="nama" value="<?php echo $supplier['nama']; ?>" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $supplier['email']; ?>" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" name="alamat" value="<?php echo $supplier['alamat']; ?>" required>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-sm btn-info">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</section>
