<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus user berdasarkan ID
    $query = mysqli_query($db, "DELETE FROM pendaftaran WHERE id='$id'");

    if ($query) {
        header("Location: informasipendaftaran.php");
    } else {
        echo "Error deleting user";
    }
}
?>