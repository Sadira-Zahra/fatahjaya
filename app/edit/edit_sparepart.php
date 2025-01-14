<?php
include('../conf/config.php');

// Check if 'id' is set in the URL for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch sparepart data from the database based on the ID
    $query = mysqli_query($koneksi, "SELECT * FROM spareparts WHERE id = '$id'");
    $view = mysqli_fetch_array($query);

    // Check if sparepart data exists
    if (!$view) {
        echo "<script>alert('Sparepart not found!'); window.location = 'index.php?page=sparepart';</script>";
        exit;
    }
}

// Handle form submission (Update Sparepart)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    // Update the sparepart data in the database
    $update_query = "UPDATE spareparts SET kode_spareparts = '$kode', nama = '$nama', stok = '$stok', harga = '$harga' WHERE id = '$id'";
    $query = mysqli_query($koneksi, $update_query);

    // Check if the update was successful
    if ($query) {
        echo "<script>alert('Data sparepart berhasil diupdate!'); window.location = 'index.php?page=sparepart';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data sparepart!'); window.location = 'index.php?page=sparepart';</script>";
    }
}
?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Edit Data Sparepart</h3>
      </div>
      <div class="card-body">
        <!-- Form for editing sparepart data -->
        <form method="POST" action="">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kode">Kode Sparepart</label>
                <input type="text" class="form-control" placeholder="kode" name="kode" value="<?php echo $view['kode_spareparts'];?>" readonly>
                <input type="hidden" name="id" value="<?php echo $view['id'];?>">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" placeholder="nama" name="nama" value="<?php echo $view['nama'];?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="harga">Harga</label>
                <input type="text" class="form-control" placeholder="harga" name="harga" value="<?php echo $view['harga'];?>">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="stok">Stok</label>
                <input type="text" class="form-control" placeholder="stok" name="stok" value="<?php echo $view['stok'];?>" readonly>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-sm btn-info">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</section>
