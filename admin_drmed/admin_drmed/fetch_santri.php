<?php
include 'config/koneksi.php'; // Pastikan untuk menyertakan koneksi database

if (isset($_GET['kelas_id'])) {
    $kelasId = $_GET['kelas_id'];

    // Query untuk mengambil santri berdasarkan ID kelas
    $result = mysqli_query($conn, "SELECT * FROM dr_wali WHERE id_kelas = '$kelasId'"); // Ganti 'id_kelas' dengan nama kolom yang sesuai

    $santri = [];
    while ($row = mysqli_fetch_array($result)) {
        $santri[] = [
            'id_wali' => $row['id_wali'], // Ganti dengan kolom ID santri
            'nm_siswa' => $row['nm_siswa'] // Ganti dengan kolom nama santri
        ];
    }

    // Mengembalikan data dalam format JSON
    echo json_encode($santri);
} else {
    // Jika tidak ada kelas_id yang diberikan, kembalikan array kosong
    echo json_encode([]);
}
?>