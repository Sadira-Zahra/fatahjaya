<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "stok_sparepart";

// Create connection
$conn = mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Query untuk mendapatkan jumlah sparepart
$query_sparepart = "SELECT COUNT(*) AS total_sparepart FROM spareparts";
$result_sparepart = mysqli_query($conn, $query_sparepart);
$row_sparepart = mysqli_fetch_assoc($result_sparepart);

// Query untuk mendapatkan jumlah supplier
$query_supplier = "SELECT COUNT(*) AS total_supplier FROM suppliers";
$result_supplier = mysqli_query($conn, $query_supplier);
$row_supplier = mysqli_fetch_assoc($result_supplier);

// Query untuk mendapatkan jumlah transaksi
$query_transaksi = "SELECT COUNT(*) AS total_transaksi FROM transaksi";
$result_transaksi = mysqli_query($conn, $query_transaksi);
$row_transaksi = mysqli_fetch_assoc($result_transaksi);

// Query untuk mendapatkan jumlah pelanggan
$query_pelanggan = "SELECT COUNT(*) AS total_pelanggan FROM pelanggan";
$result_pelanggan = mysqli_query($conn, $query_pelanggan);
$row_pelanggan = mysqli_fetch_assoc($result_pelanggan);
?>

<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <!-- Sparepart -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $row_sparepart['total_sparepart']; ?></h3>
            <p>Sparepart</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="index.php?page=sparepart" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- Supplier -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?php echo $row_supplier['total_supplier']; ?></h3>
            <p>Supplier</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="index.php?page=supplier" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- transaksi -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?php echo $row_transaksi['total_transaksi']; ?></h3>
            <p>transaksi</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="index.php?page=transaksi" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- Pelanggan -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?php echo $row_pelanggan['total_pelanggan']; ?></h3>
            <p>Pelanggan</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="index.php?page=pelanggan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>

    <!-- Chart Section for Data Visualization -->
    <div class="row">
      <div class="col-lg-12 col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Visualisasi Data</h3>
          </div>
          <div class="card-body">
            <canvas id="dataChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Script untuk Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Inisialisasi Chart.js
const ctx = document.getElementById('dataChart').getContext('2d');
const dataChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Sparepart', 'Supplier', 'transaksi', 'Pelanggan'],
    datasets: [{
      label: 'Total Count',
      data: [
        <?php echo $row_sparepart['total_sparepart']; ?>,
        <?php echo $row_supplier['total_supplier']; ?>,
        <?php echo $row_transaksi['total_transaksi']; ?>,
        <?php echo $row_pelanggan['total_pelanggan']; ?>
      ],
      backgroundColor: [
        'rgba(0, 123, 255, 0.5)', // Warna untuk Sparepart
        'rgba(40, 167, 69, 0.5)', // Warna untuk Supplier
        'rgba(255, 193, 7, 0.5)', // Warna untuk transaksi
        'rgba(220, 53, 69, 0.5)'  // Warna untuk Pelanggan
      ],
      borderColor: [
        'rgba(0, 123, 255, 1)',
        'rgba(40, 167, 69, 1)',
        'rgba(255, 193, 7, 1)',
        'rgba(220, 53, 69, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
</script>
