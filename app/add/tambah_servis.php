<?php 
include('../../conf/config.php');
$kode = $_GET['kode'];
$nama = $_GET['nama'];
$harga = $_GET['harga'];
$query= mysqli_query($koneksi, "INSERT INTO servis (kode_servis,nama,harga) VALUES ('$kode','$nama','$harga')");
header ('location: ../index.php?page=servis');
?>