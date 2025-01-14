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
            <table  class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Kode Supplier</th>
                  <th>Nama Supplier</th>
                  <th>Email</th>
                  <th>Alamat</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Fetch data from the database
                $query = mysqli_query($koneksi, "SELECT * FROM suppliers");

                while ($supplier = mysqli_fetch_array($query)) {
                  ?>
                  <tr>
                    <td width='20%'><?php echo $supplier['kode_supplier']; ?></td>
                    <td><?php echo $supplier['nama']; ?></td>
                    <td width='5%'><?php echo $supplier['email']; ?></td>
                    <td width='10%'><?php echo $supplier['alamat']; ?></td>
                    <td>
                      <a onclick="hapus(<?php echo $supplier['id']; ?>)" class="btn btn-sm btn-danger">Hapus</a>
                      <a href="index.php?page=edit_supplier&&id=<?php echo $supplier['id']; ?>" class="btn btn-sm btn-success">Edit</a>
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

<!-- Modal for adding supplier -->
<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Supplier</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
        <div class="modal-body">
          <div class="form-row">
            <div class="col">
              <input type="text" class="form-control" placeholder="Kode Supplier" name="kode" required>
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Nama Supplier" name="nama" required>
            </div>
            <div class="col">
              <input type="email" class="form-control" placeholder="Email Supplier" name="email" required>
            </div>
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
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

<?php
// Insert new supplier
if (isset($_POST['submit'])) {
  $kode = $_POST['kode'];
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $alamat = $_POST['alamat'];

  // Insert into suppliers table
  $query = "INSERT INTO suppliers (kode_supplier, nama, email, alamat) 
            VALUES ('$kode', '$nama', '$email', '$alamat')";
  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Supplier berhasil ditambahkan!'); window.location = 'index.php?page=supplier';</script>";
  } else {
    echo "<script>alert('Gagal menambahkan supplier!'); window.location = 'index.php?page=supplier';</script>";
  }
}
?>
