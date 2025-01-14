<?php 
include('../../conf/config.php');
$kode = $_GET['kode'];
$nama = $_GET['nama'];
$stok = $_GET['stok'];
$harga = $_GET['harga'];
$query= mysqli_query($koneksi, "INSERT INTO spareparts (kode_spareparts,nama,stok,harga) VALUES ('$kode','$nama','$stok','$harga')");
header ('location: ../index.php?page=sparepart');
?>