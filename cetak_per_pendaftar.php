<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($db, "SELECT * FROM pendaftaran WHERE id='$id'");
    $query = mysqli_fetch_assoc($sql);

    if ($query) {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Laporan Pendaftar</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    margin: 20px;
                }

                h2 {
                    color: #333;
                }

                .container {
                    width: 80%;
                    margin: auto;
                    text-align: left;
                }

                .details {
                    border: 1px solid #ddd;
                    padding: 15px;
                    margin-top: 20px;
                    border-radius: 5px;
                }

                .details img {
                    width: 100px;
                    height: auto;
                    border-radius: 5px;
                    margin-bottom: 10px;
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
            </style>
        </head>

        <body>
            <h2>Laporan Pendaftar</h2>
            <div class="container">
                <div class="details">
                    <p><strong>Nama:</strong> <?php echo htmlspecialchars($query['nama']); ?></p>
                    <p><strong>NISN:</strong> <?php echo htmlspecialchars($query['nisn']); ?></p>
                    <p><strong>Jurusan:</strong> <?php echo htmlspecialchars($query['jurusan']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($query['status']); ?></p>

                    

                    <!-- Foto KTP -->
                    <p><strong>Foto KTP:</strong></p>
                    <?php if (!empty($query['ktp'])) { ?>
                        <img src="../uploads/<?php echo htmlspecialchars($query['ktp']);?>" alt="">
                    <?php } else { ?>
                        <p>Tidak ada foto KTP</p>
                    <?php } ?>
                </div>
            </div>

            <!-- Tombol Cetak -->
            <button onclick="window.print()" class="tombol-cetak">Cetak Laporan</button>
        </body>

        </html>
<?php
    } else {
        echo "Data pendaftar tidak ditemukan.";
    }
} else {
    echo "ID tidak valid.";
}
?>