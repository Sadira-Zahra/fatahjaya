<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">
              Tambah Data
            </button>
            <br><br>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Kode pelanggan</th>
                  <th>Nama pelanggan</th>
                  <th>Tipe</th>
                  <th>No Telepon</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Fetch data from the database
                $query = mysqli_query($koneksi, "SELECT * FROM pelanggan");

                while ($pelanggan = mysqli_fetch_array($query)) {
                  ?>
                  <tr>
                    <td width='20%'><?php echo $pelanggan['kode_pelanggan']; ?></td>
                    <td><?php echo $pelanggan['nama']; ?></td>
                    <td width='5%'><?php echo $pelanggan['tipe']; ?></td>
                    <td width='10%'><?php echo $pelanggan['notelepon']; ?></td>
                    <td>
                      <a onclick="hapus(<?php echo $pelanggan['id']; ?>)" class="btn btn-sm btn-danger">Hapus</a>
                      <a href="index.php?page=edit_pelanggan&&id=<?php echo $pelanggan['id']; ?>" class="btn btn-sm btn-success">Edit</a>
                      </td>
                  </tr>
                <?php
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

<!-- Modal for adding pelanggan -->
<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah pelanggan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
        <div class="modal-body">
          <div class="form-row">
            <div class="col">
              <input type="text" class="form-control" placeholder="Kode pelanggan" name="kode" required>
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Nama pelanggan" name="nama" required>
            </div>
            <div class="col">
              <input type="tipe" class="form-control" placeholder="Tipe" name="tipe" required>
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="NoTelepon" name="notelepon" required>
            </div>
          </div>
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
function hapus(data_id) {
  Swal.fire({
    title: "Yakin Untuk Menghapus Data?",
    showCancelButton: true,
    confirmButtonText: "Hapus",
    confirmButtonColor: '#CD5c5c',
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire("Data Dihapus!", "", "success");
      window.location = "?page=pelanggan&action=delete&id=" + data_id;
    }
  });
}
</script>

<?php
// Handle the delete action if 'action' is set to 'delete'
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
  $id = $_GET['id'];
  $delete_query = "DELETE FROM pelanggan WHERE id = $id";
  if (mysqli_query($koneksi, $delete_query)) {
    echo "<script>alert('Data berhasil dihapus!'); window.location = 'index.php?page=pelanggan';</script>";
  } else {
    echo "<script>alert('Gagal menghapus data!'); window.location = 'index.php?page=pelanggan';</script>";
  }
}

// Handle the form submission to add a new pelanggan
if (isset($_POST['submit'])) {
  $kode = $_POST['kode'];
  $nama = $_POST['nama'];
  $tipe = $_POST['tipe'];
  $notelepon = $_POST['notelepon'];

  // Insert data into the database
  $insert_query = "INSERT INTO pelanggan (kode_pelanggan, nama, tipe, notelepon) 
                   VALUES ('$kode', '$nama', '$tipe','$notelepon')";
  if (mysqli_query($koneksi, $insert_query)) {
    echo "<script>alert('Data berhasil ditambahkan!'); window.location = 'index.php?page=pelanggan';</script>";
  } else {
    echo "<script>alert('Gagal menambahkan data!'); window.location = 'index.php?page=pelanggan';</script>";
  }
}
?>
