<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- /.card -->
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <!-- Button to open modal -->
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalTambahData">
              Tambah Data
            </button>
            <button type="button" class="btn btn-warning" onclick="cetakData()">Cetak</button>
            <br><br>
            <!-- Table to display spareparts -->
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Kode Spareparts</th>
                  <th>Nama Spareparts</th>
                  <th>Stok</th>
                  <th>Harga</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Query to fetch spareparts data
                $query = mysqli_query($koneksi, "SELECT * FROM spareparts");

                while ($sparepart = mysqli_fetch_array($query)) {
                    // Cek jika stok rendah
                    $stok_rendah = ($sparepart['stok'] < 5) ? true : false;
                ?>
                  <tr>
                    <td width='20%'><?php echo $sparepart['kode_spareparts']; ?></td>
                    <td><?php echo $sparepart['nama']; ?></td>
                    <td width='5%'>
                      <?php 
                      echo $sparepart['stok']; 
                      if ($stok_rendah) {
                        echo " <span class='badge badge-danger'>Stok Rendah!</span>";
                      }
                      ?>
                    </td>
                    <td width='10%'><?php echo "Rp " . number_format($sparepart['harga'], 0, ',', '.'); ?></td>
                    <td>
                      <a onclick="hapus(<?php echo $sparepart['id']; ?>)" class="btn btn-sm btn-danger">Hapus</a>
                      <a href="index.php?page=edit_sparepart&&id=<?php echo $sparepart['id']; ?>" class="btn btn-sm btn-success">Edit</a>
                      <!-- Restock Button -->
                      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-restock" 
                        onclick="setSparepartID(<?php echo $sparepart['id']; ?>)">Restock</button>
                      <a href="index.php?page=detail_restock&&id=<?php echo $sparepart['id']; ?>" class="btn btn-sm btn-success">History Restock</a>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>

<!-- Modal for adding sparepart -->
<div class="modal fade" id="modalTambahData">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Sparepart</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
        <div class="modal-body">
          <div class="form-group">
            <label for="kode_spareparts">Kode Sparepart</label>
            <input type="text" class="form-control" id="kode_spareparts" name="kode_spareparts" placeholder="Masukkan kode sparepart" required>
          </div>
          <div class="form-group">
            <label for="nama">Nama Sparepart</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama sparepart" required>
          </div>
          <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga" required>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" name="tambah_data">Tambah Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal for Restock -->
<div class="modal fade" id="modal-restock">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Restock Sparepart</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
        <div class="modal-body">
          <input type="hidden" id="id_spareparts" name="id_spareparts">
          <div class="form-group">
            <label for="kuantitas">Jumlah Restock</label>
            <input type="number" class="form-control" id="kuantitas" name="kuantitas" placeholder="Masukkan jumlah restock" required>
          </div>
          <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal" required>
          </div>
          <div class="form-group">
            <label for="supplier">Nama Supplier</label>
            <select class="form-control" id="supplier" name="supplier" required>
              <?php
                // Fetch suppliers from the database
                $supplier_query = mysqli_query($koneksi, "SELECT * FROM suppliers");
                while ($supplier = mysqli_fetch_array($supplier_query)) {
                  echo "<option value='" . $supplier['id'] . "'>" . $supplier['nama'] . "</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" name="restock">Restock</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function setSparepartID(id) {
  document.getElementById('id_spareparts').value = id;
}

// Function to confirm deletion of data
function hapus(data_id) {
  Swal.fire({
    title: "Yakin Untuk Menghapus Data?",
    showCancelButton: true,
    confirmButtonText: "Hapus",
    confirmButtonColor: '#CD5c5c',
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire("Data Dihapus!", "", "success");
      window.location = "?page=sparepart&action=delete&id=" + data_id;
    }
  });
}

// Function to print table data excluding the 'Action' column
function cetakData() {
    var table = document.getElementById('example1');
    var rows = table.rows;

    // Hide the 'Action' column (index 4)
    for (var i = 0; i < rows.length; i++) {
        rows[i].cells[4].style.display = 'none';
    }

    // Print the page content
    window.print();

    // After printing, restore the 'Action' column
    for (var i = 0; i < rows.length; i++) {
        rows[i].cells[4].style.display = '';
    }
}
</script>

<style>
@media print {
    /* Hiding buttons and action column in print view */
    .btn, .content-header, .modal, .modal-footer, th:nth-child(5), td:nth-child(5) {
        display: none;
    }

    /* Ensuring table fits on the page */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    /* Styling the table for print */
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }
}
</style>

<?php

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
  $id = $_GET['id'];  // Ambil ID dari URL
  // Query untuk menghapus data
  $query = "DELETE FROM spareparts WHERE id = $id";

  // Jalankan query
  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil dihapus!'); window.location = 'index.php?page=sparepart';</script>";
  } else {
    echo "<script>alert('Gagal menghapus data!'); window.location = 'index.php?page=sparepart';</script>";
  }
}

// Menangani form submit untuk menambah data sparepart
if (isset($_POST['tambah_data'])) {
  // Ambil data dari form
  $kode_spareparts = $_POST['kode_spareparts'];
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];

  // Query untuk menambah data ke tabel spareparts
  $query = "INSERT INTO spareparts (kode_spareparts, nama, harga) 
            VALUES ('$kode_spareparts', '$nama', '$harga')";
  
  // Menjalankan query
  if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil ditambahkan!'); window.location = 'index.php?page=sparepart';</script>";
  } else {
    echo "<script>alert('Gagal menambahkan data!'); window.location = 'index.php?page=sparepart';</script>";
  }
}

// Handle Restock Action
if (isset($_POST['restock'])) {
  $id_spareparts = $_POST['id_spareparts'];
  $kuantitas = $_POST['kuantitas'];
  $id_supplier = $_POST['supplier'];
  $tanggal = $_POST['tanggal']; // Ambil nilai tanggal dari form

  // Update stock in the spareparts table
  $update_query = "UPDATE spareparts 
                 SET stok = IFNULL(stok, 0) + $kuantitas 
                 WHERE id = $id_spareparts";
  if (mysqli_query($koneksi, $update_query)) {
    // Log restock history
    $log_query = "INSERT INTO spareparts_supplier (id_spareparts, kuantitas, id_supplier, tanggal) 
                  VALUES ($id_spareparts, $kuantitas, $id_supplier, '$tanggal')";
    mysqli_query($koneksi, $log_query);
    echo "<script>alert('Restock berhasil!'); window.location = 'index.php?page=sparepart';</script>";
  } else {
    echo "<script>alert('Gagal restock!'); window.location = 'index.php?page=sparepart';</script>";
  }
}
?>
