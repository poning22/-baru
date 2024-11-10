<?php
session_start();

// Periksa apakah admin sudah login
if ($_SESSION['role'] != "staf") {
    header("location:gagal_login");
    exit();
}

include '../config.php';

// Cek apakah parameter id dan status ada di POST
if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update status calon siswa di database
    $stmt = $db->prepare("UPDATE pendaftaran SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        // Jika update berhasil, alihkan ke halaman status pendaftaran dengan pesan sukses
        header("Location: infopendaftaran.php?pesan=berhasil");
    } else {
        // Jika gagal, alihkan ke halaman status pendaftaran dengan pesan error
        header("Location: infopendaftaran.php?pesan=gagal");
    }

    $stmt->close();
} else {
    // Jika data tidak lengkap, alihkan kembali dengan pesan error
    header("Location: infopendaftaran.php?pesan=gagal");
}
?>