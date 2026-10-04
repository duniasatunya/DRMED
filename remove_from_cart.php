<?php
session_start();
include 'config/koneksi.php'; // Pastikan untuk menyertakan koneksi database

if (isset($_POST['id_pinjamalat'])) {
    $id_pinjamalat = $_POST['id_pinjamalat'];

    // Hapus satu entri dari dr_mediapinjamalat
    $query = "DELETE FROM dr_mediapinjamalat WHERE id_pinjamalat = '$id_pinjamalat' LIMIT 1"; // Hapus satu entri

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error']);
}
?>