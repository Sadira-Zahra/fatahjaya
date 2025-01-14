<?php 
include('../../conf/config.php');
$kode = $_GET['kode'];
$nama = $_GET['nama'];
$tipe = $_GET['tipe'];
$nopol = $_GET['nopol'];
$notelepon = $_GET['notelepon'];
$query= mysqli_query($koneksi, "INSERT INTO pelanggan (kode_pelanggan,nama,tipe,nopol,notelepon) VALUES ('$kode','$nama','$tipe','$nopol','$notelepon')");
header ('location: ../index.php?page=pelanggan');
?>