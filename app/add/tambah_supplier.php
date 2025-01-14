<?php 
include('../../conf/config.php');
$kode = $_GET['kode'];
$nama = $_GET['nama'];
$email = $_GET['email'];
$alamat = $_GET['alamat'];
$query= mysqli_query($koneksi, "INSERT INTO suppliers (kode_supplier,nama,email,alamat) VALUES ('$kode','$nama','$email','$alamat')");
header ('location: ../index.php?page=supplier');
?>