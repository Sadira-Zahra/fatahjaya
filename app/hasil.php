<?php
// Include database connection
include('../conf/config.php');

// Ambil semua alternatif beserta data supplier
$alternatif_query = "
    SELECT 
        a.id AS id_alternatif, 
        a.nama_alternatif, 
        s.nama AS nama_supplier 
    FROM alternatif a
    LEFT JOIN suppliers s ON a.id_supplier = s.id
";
$alternatif_result = mysqli_query($koneksi, $alternatif_query);

// Ambil semua kriteria
$kriteria_query = "SELECT * FROM kriteria";
$kriteria_result = mysqli_query($koneksi, $kriteria_query);

// Menyusun array bobot berdasarkan kriteria
$bobot = [];
while ($kriteria = mysqli_fetch_assoc($kriteria_result)) {
    $bobot[$kriteria['id']] = $kriteria['bobot'];
}

// Ambil penilaian alternatif berdasarkan kriteria
$penilaian_query = "SELECT p.id_alternatif, p.id_kriteria, p.nilai FROM penilaian p";
$penilaian_result = mysqli_query($koneksi, $penilaian_query);

// Menyusun data penilaian dalam array
$penilaian = [];
while ($pen = mysqli_fetch_assoc($penilaian_result)) {
    $penilaian[$pen['id_alternatif']][$pen['id_kriteria']] = $pen['nilai'];
}

// Menghitung total nilai untuk setiap alternatif
$hasil = [];
while ($alternatif = mysqli_fetch_assoc($alternatif_result)) {
    $total_nilai = 0;

    // Hitung nilai total berdasarkan kriteria
    foreach ($bobot as $kriteria_id => $bobot_value) {
        $nilai = isset($penilaian[$alternatif['id_alternatif']][$kriteria_id]) ? $penilaian[$alternatif['id_alternatif']][$kriteria_id] : 0;

        // Untuk kriteria 'cost', nilai yang lebih rendah lebih baik
        if ($bobot_value < 0) {
            $nilai = 1 / $nilai;
        }

        $total_nilai += $nilai * $bobot_value;
    }

    // Simpan total nilai untuk alternatif, termasuk nama supplier
    $hasil[] = [
        'id_alternatif' => $alternatif['id_alternatif'],
        'nama_alternatif' => $alternatif['nama_alternatif'],
        'nama_supplier' => $alternatif['nama_supplier'], // Tambahkan nama supplier
        'total_nilai' => $total_nilai
    ];
}

// Urutkan hasil berdasarkan total nilai terbesar
usort($hasil, function($a, $b) {
    if ($b['total_nilai'] > $a['total_nilai']) {
        return 1;
    } elseif ($b['total_nilai'] < $a['total_nilai']) {
        return -1;
    } else {
        return 0;
    }
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Penilaian</title>
    <!-- Add your preferred stylesheets -->
</head>
<body>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Hasil Penilaian</h3>
                </div>
                <div class="card-body">
                    <!-- Rekomendasi Supplier -->
                    <?php if (!empty($hasil)): ?>
                        <div class="alert alert-success">
                            <h5>Rekomendasi Supplier:</h5>
                            <p>
                                Supplier terbaik berdasarkan perhitungan adalah 
                                <strong><?php echo $hasil[0]['nama_supplier']; ?></strong> 
                                dengan total nilai 
                                <strong><?php echo number_format($hasil[0]['total_nilai'], 2); ?></strong>.
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- Tabel untuk menampilkan hasil -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Alternatif</th>
                                <th>Nama Supplier</th> <!-- Kolom baru -->
                                <th>Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($hasil as $row) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row['nama_alternatif'] . "</td>";
                                echo "<td>" . $row['nama_supplier'] . "</td>"; // Tampilkan nama supplier
                                echo "<td>" . number_format($row['total_nilai'], 2) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
