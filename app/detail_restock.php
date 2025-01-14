<?php
// Ambil ID sparepart dari URL
$id_sparepart = isset($_GET['id']) ? $_GET['id'] : 0;

// Query untuk mendapatkan data detail restock berdasarkan ID sparepart, termasuk nama supplier
$query = "SELECT spareparts.nama AS nama_spareparts, spareparts_supplier.kuantitas, spareparts_supplier.tanggal, suppliers.nama AS nama_supplier
          FROM spareparts_supplier
          JOIN spareparts ON spareparts_supplier.id_spareparts = spareparts.id
          JOIN suppliers ON spareparts_supplier.id_supplier = suppliers.id
          WHERE spareparts_supplier.id_spareparts = $id_sparepart";
$result = mysqli_query($koneksi, $query);

// Ambil nama sparepart untuk ditampilkan di header
$sparepart_name = '';
if ($id_sparepart > 0) {
    $sparepart_query = "SELECT nama FROM spareparts WHERE id = $id_sparepart";
    $sparepart_result = mysqli_query($koneksi, $sparepart_query);
    if ($sparepart_row = mysqli_fetch_assoc($sparepart_result)) {
        $sparepart_name = $sparepart_row['nama'];
    }
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Detail Restock <?php echo $sparepart_name; ?></h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- Table for displaying restock details -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Restock untuk <?php echo $sparepart_name; ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Nama Sparepart</th>
                  <th>Nama Supplier</th>
                  <th>Kuantitas</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Loop untuk menampilkan data hanya untuk sparepart yang dipilih
                if ($id_sparepart > 0 && mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                      <td><?php echo $row['nama_spareparts']; ?></td>
                      <td><?php echo $row['nama_supplier']; ?></td>
                      <td><?php echo $row['kuantitas']; ?></td>
                      <td><?php echo $row['tanggal']; ?></td>
                    </tr>
                <?php
                  }
                } else {
                  echo "<tr><td colspan='4'>Tidak ada data ditemukan</td></tr>";
                }
                ?>
              </tbody>
            </table>
            <a href="index.php?page=sparepart" class="btn btn-sm btn-success">Kembali</a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>

<!-- Script untuk DataTables -->
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>
