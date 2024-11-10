<!DOCTYPE html>
<html>

<head>
    <title>Status Pendaftaran</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
    <style>


        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            width: 80%;
            z-index: 9999;
        }

        .success {
            background-color: #4CAF50;
            color: white;
        }

        .error {
            background-color: #f44336;
            color: white;
        }


        /* CSS untuk pop-up modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<?php
if (isset($_GET['pesan'])) {
    $pesan = $_GET['pesan'];
    if ($pesan == "berhasil") {
        echo "<div class='notification success'>Status berhasil diperbarui.</div>";
    } elseif ($pesan == "gagal") {
        echo "<div class='notification error'>Gagal memperbarui status.</div>";
    }
}
?>

<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login dan sebagai admin
if ($_SESSION['role'] != "staf") {
    header("location:gagal_login");
    exit();
}

include '../config.php';
?>

<body>
    <div class="datadaftar">
        <p class="tulisan_menu" style="color:aqua;">Status Pendaftaran</p>
        <br><br>
        <button onclick="window.location.href='cetaklaporan.php'" class="tomboltabel">Cetak Laporan</button>

        <table border="1" align="center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>Jurusan</th>
                    <th>Status Pendaftaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $sql = mysqli_query($db, "SELECT * FROM pendaftaran");
                while ($query = mysqli_fetch_assoc($sql)) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $query['nama']; ?></td>
                        <td><?php echo $query['nisn']; ?></td>
                        <td><?php echo $query['jurusan']; ?></td>
                        <td><?php echo $query['status']; ?></td>
                        <td>
                            <form action="editstatus.php" method="POST">
                                <select name="status" required>
                                    <option value="diterima" <?php echo $query['status'] == 'diterima' ? 'selected' : ''; ?>>Diterima</option>
                                    <option value="cadangan" <?php echo $query['status'] == 'cadangan' ? 'selected' : ''; ?>>Cadangan</option>
                                    <option value="tidak diterima" <?php echo $query['status'] == 'tidakditerima' ? 'selected' : ''; ?>>Tidak Diterima</option>
                                </select>
                                <input type="hidden" name="id" value="<?php echo $query['id']; ?>" />
                                <input type="submit" value="Update" class="tomboltabel" />
                            </form>
                        </td>
                        <td>
                            <button onclick="openModal('<?php echo $query['id']; ?>')">DETAIL</button>
                            <a href="delete_pendaftar.php?id=<?php echo $query['id']; ?>"><button>DELETE</button></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <!-- Modal untuk detail calon siswa -->
        <div id="modalDetail" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <div id="detailContent">
                    <!-- Konten detail akan diisi melalui AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal dan mengisi detail dari AJAX
        function openModal(id) {
            var modal = document.getElementById("modalDetail");
            var detailContent = document.getElementById("detailContent");

            // Menggunakan AJAX untuk mengambil detail calon siswa
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "detailcalonmahasiswa.php?id=" + id, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    detailContent.innerHTML = xhr.responseText;
                    modal.style.display = "block";
                } else {
                    detailContent.innerHTML = "<p>Gagal memuat detail calon siswa.</p>";
                }
            };
            xhr.send();
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            var modal = document.getElementById("modalDetail");
            modal.style.display = "none";
        }

        // Tutup modal saat pengguna mengklik di luar modal
        window.onclick = function(event) {
            var modal = document.getElementById("modalDetail");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>