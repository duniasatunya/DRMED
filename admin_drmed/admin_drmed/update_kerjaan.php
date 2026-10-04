<?php
session_start();
include 'config/koneksi.php';  // Pastikan koneksi Anda sudah benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari AJAX
    $pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan']);
    $id_crewdrmed = $_POST['id_crewdrmed'];  // id_crewdrmed dikirim dari input hidden

    // Validasi apakah id_crewdrmed dan pekerjaan ada
    if (empty($pekerjaan) || empty($id_crewdrmed)) {
        echo "error";
        exit();
    }

    // Update data pekerjaan berdasarkan id_crewdrmed
    $sql = "UPDATE dr_media_studio SET kerjaan = '$pekerjaan' WHERE id_crewdrmed = '$id_crewdrmed'";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil
        echo "success";
    } else {
        // Jika gagal
        echo "error";
    }
}
?>