<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login dan sebagai admin
if ($_SESSION['role'] != "staf") {
    header("location:gagal_login.php");
    exit();
}

include '../config.php';

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Menghitung jumlah data dengan status "diterima"
$count_query = mysqli_query($db, "SELECT COUNT(*) as total_diterima FROM pendaftaran WHERE status = 'diterima'");

if (!$count_query) {
    die("Query failed: " . mysqli_error($db));
}

$count_result = mysqli_fetch_assoc($count_query);
$total_diterima = $count_result['total_diterima'];

// Menghitung total jumlah pendaftar
$count_total_query = mysqli_query($db, "SELECT COUNT(*) as total_pendaftar FROM pendaftaran");
if (!$count_total_query) {
    die("Query failed: " . mysqli_error($db));
}

$count_total_result = mysqli_fetch_assoc($count_total_query);
$total_pendaftar = $count_total_result['total_pendaftar'];

$selisih = $total_pendaftar - $total_diterima;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Daftar Pendaftar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .laporan {
            width: 90%;
            margin: auto;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td img {
            width: 60px; /* Ukuran kecil untuk foto KTP */
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 5px;
        }

        .tombol-cetak {
            margin: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .tombol-cetak:hover {
            background-color: #45a049;
        }

        h2 {
            color: #333;
        }
    </style>
</head>
<body>

<div class="laporan">
    <h2>Laporan Daftar Pendaftar</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NISN</th>
                <th>Jurusan</th>
                <th>Foto KTP</th>
                <th>Status Pendaftaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql = mysqli_query($db, "SELECT * FROM pendaftaran");
            while ($query = mysqli_fetch_assoc($sql)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($query['nama']) . "</td>";
                echo "<td>" . htmlspecialchars($query['nisn']) . "</td>";
                echo "<td>" . htmlspecialchars($query['jurusan']) . "</td>";
               
                // Menampilkan foto KTP jika ada
                if (!empty($query['ktp'])) {
                    echo "<td><img src='../uploads/" . htmlspecialchars($query['ktp']) . "' alt='KTP'></td>";
                } else {
                    echo "<td>Tidak ada foto</td>";
                }

                echo "<td>" . htmlspecialchars($query['status']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10" style="text-align: right;">Jumlah Pendaftar: <?php echo $total_pendaftar; ?></td>
            </tr>
            <tr>
                <td colspan="10" style="text-align: right;">Jumlah Pendaftar yang diterima: <?php echo $total_diterima; ?></td>
            </tr>
            <tr>    
                <td colspan="10" style="text-align: right;">Jumlah selisih: <?php echo $selisih; ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Tombol untuk mencetak halaman -->
<button onclick="window.print()" class="tombol-cetak">Cetak Laporan</button>

</body>
</html>