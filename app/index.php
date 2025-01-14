<!DOCTYPE html>
<html lang="en">
<?php session_start();
if (!$_SESSION['nama']){
  header('location:../index.php?session=expired'); 
}
include('header.php');?>

<?php include('../conf/config.php');?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <?php include('preloader.php')?>

  <!-- Navbar -->
  <?php include('navbar.php')?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
   <?php include('logo.php')?>

    <!-- Sidebar -->
    <?php include('sidebar.php')?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include('content_header.php')?>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php
    if (isset($_GET['page'])){
    if ($_GET['page'] == 'dashboard') {
        include('dashboard.php');
    } else if ($_GET['page'] == 'sparepart') {
        include('sparepart.php');   
    } else if ($_GET['page'] == 'supplier') {
        include('supplier.php');
    }
     else if ($_GET['page'] == 'detail_restock') {
        include('detail_restock.php');
    }
      else if ($_GET['page'] == 'pelanggan') {
        include('pelanggan.php');
    }
      else if ($_GET['page'] == 'transaksi') {
        include('transaksi.php');
    }
      else if ($_GET['page'] == 'alternatif') {
        include('alternatif.php');
    }
      else if ($_GET['page'] == 'penilaian') {
        include('penilaian.php');
    }
      else if ($_GET['page'] == 'hasil') {
        include('hasil.php');
    }
      else if ($_GET['page'] == 'kriteria') {
        include('kriteria.php');
    }
      else if ($_GET['page'] == 'edit_kriteria') {
        include('edit_kriteria.php');
    }
      else if ($_GET['page'] == 'edit_sparepart') {
        include('edit/edit_sparepart.php');
    }
    else if ($_GET['page'] == 'edit_supplier') {
      include('edit/edit_supplier.php');
    }
    else if ($_GET['page'] == 'detail_transaksi') {
      include('detail_transaksi.php');
    }
    else if ($_GET['page'] == 'edit_pelanggan') {
      include('edit/edit_pelanggan.php');
    }
    else{
      include('dashboard.php');
    }
    }
    else{
      include('dashboard.php');
    }
    ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('footer.php')?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


</body>
</html>
