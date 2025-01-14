<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "stok_sparepart");

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data dari form
$id_transaksi = $_POST['id_transaksi'];
$id_sparepart = $_POST['id_sparepart'];
$kuantitas = $_POST['kuantitas'];

// Validasi data
if (empty($id_transaksi) || empty($id_sparepart) || empty($kuantitas)) {
    echo "<script>alert('Semua data harus diisi.'); window.location='detail_transaksi.php?id=$id_transaksi';</script>";
    exit;
}

// Tambahkan data ke tabel spareparts_transaksi
$query = "INSERT INTO spareparts_transaksi (id_transaksi, id_spareparts, kuantitas) 
          VALUES ('$id_transaksi', '$id_sparepart', '$kuantitas')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Data berhasil ditambahkan.'); window.location='detail_transaksi.php?id=$id_transaksi';</script>";
} else {
    echo "<script>alert('Gagal menambahkan data.'); window.location='detail_transaksi.php?id=$id_transaksi';</script>";
}
?>
