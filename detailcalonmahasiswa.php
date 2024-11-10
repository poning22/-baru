<?php
include '../config.php';

// Periksa apakah parameter `id` sudah diterima melalui GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo "ID yang diterima: " . htmlspecialchars($id) . "<br>"; // Tambahan untuk debugging

    // Validasi ID sebagai integer
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        echo "<p>ID tidak valid.</p>";
        exit;
    }

    // Query untuk mengambil data calon siswa berdasarkan ID
    $sql = $db->prepare("SELECT * FROM pendaftaran WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Tambahkan tombol cetak di bagian atas
        echo "<div style='text-align: right; margin-bottom: 20px;'>";
        echo "<a href='cetak_per_pendaftar.php?id=" . htmlspecialchars($id) . "' target='_blank'>";
        echo "<button style='padding: 10px 20px; font-size: 16px; background-color: #4CAF50; color: white; border: none; cursor: pointer;'>Cetak Laporan</button>";
        echo "</a>";
        echo "</div>";
        
        // Tampilkan detail calon siswa
        echo "<h2>Detail Calon Siswa</h2>";
        echo "<p><strong>Nama:</strong> " . htmlspecialchars($data['nama']) . "</p>";
        echo "<p><strong>NISN:</strong> " . htmlspecialchars($data['nisn']) . "</p>";
        echo "<p><strong>Jurusan:</strong> " . htmlspecialchars($data['jurusan']) . "</p>";
        echo "<p><strong>Status Pendaftaran:</strong> " . htmlspecialchars($data['status']) . "</p>";
        
        // Tampilkan KTP jika tersedia
        if (!empty($data['ktp'])) {
            echo "<p><strong>KTP:</strong></p>";
            echo "<img src='../uploads/" . htmlspecialchars($data['ktp']) . "' alt='KTP' style='width:100%; max-width:300px; display: block; margin-bottom: 20px;'>";
        }
    } else {
        echo "<p>Data tidak ditemukan.</p>";
    }

    $sql->close();
} else {
    echo "<p>ID tidak valid.</p>";
}
?>