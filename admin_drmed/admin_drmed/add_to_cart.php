<?php
session_start();
include 'config/koneksi.php'; // Pastikan untuk menyertakan koneksi database

if (isset($_POST['id_alat']) && isset($_POST['quantity'])) {
    $id_alat = $_POST['id_alat'];
    $id_pinjam = $_POST['id_pinjam'];
    $quantity = (int) $_POST['quantity']; // Pastikan quantity adalah integer

    // Logika untuk menambahkan item ke keranjang
    // Misalnya, menyimpan ke dalam session
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    // Tambahkan item ke keranjang
    if (isset($_SESSION['keranjang'][$id_alat])) {
        $_SESSION['keranjang'][$id_alat] += $quantity; // Tambah jumlah jika sudah ada
    } else {
        $_SESSION['keranjang'][$id_alat] = $quantity; // Tambah item baru
    }

    // Simpan ke database dr_mediapinjamalat
    $user_id = $_SESSION['user_id']; // Pastikan Anda memiliki user_id dalam session

    // Loop untuk memasukkan data sebanyak quantity
    for ($i = 0; $i < $quantity; $i++) {
        $query = "INSERT INTO dr_mediapinjamalat (id_alat, id_pinjam) VALUES ('$id_alat', '$id_pinjam')";

        if (!mysqli_query($conn, $query)) {
            echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
            exit(); // Keluar jika ada kesalahan
        }
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>