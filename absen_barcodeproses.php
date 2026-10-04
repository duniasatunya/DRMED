<?php

session_start();
require_once '../admin_drmed/pesan_masukstudio.php'; // gunakan fungsi kirimLaporanStudio()

// Debug yang aman (opsional saat develop)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// --- Ambil & sanitasi input ---
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($id === '') {
    echo '<script>alert("ID tidak valid");window.location.href="../admin_drmed/isi_studio.php";</script>';
    exit();
}

// --- Cek apakah id_wali sudah ada di dr_media_studio ---
$stmt = mysqli_prepare($conn, "SELECT 1 FROM dr_media_studio WHERE id_wali = ?");
mysqli_stmt_bind_param($stmt, 's', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$exists = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);

// Variabel untuk pesan
$stat = null;   // 'masuk' | 'keluar'
$wali = null;   // data wali

// --- Transaksi ---
mysqli_begin_transaction($conn);

try {
    if ($exists) {
        // Ambil data wali untuk alert/WA
        $stmt = mysqli_prepare($conn, "SELECT nm_siswa, kelamin, kelas_wali, id_kelas FROM dr_wali WHERE id_wali = ?");
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $wali = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        // Hapus dari studio
        $stmt = mysqli_prepare($conn, "DELETE FROM dr_media_studio WHERE id_wali = ?");
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        $affected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);

        if ($affected < 1) { throw new Exception("Tidak ada baris terhapus."); }

        $stat = 'keluar';

    } else {
        // Ambil wali
        $stmt = mysqli_prepare($conn, "SELECT * FROM dr_wali WHERE id_wali = ?");
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if (!$res || mysqli_num_rows($res) === 0) {
            mysqli_stmt_close($stmt);
            throw new Exception("Data wali tidak ditemukan.");
        }
        $hasil = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        // Bukan crew aktif?
        if ((int)$hasil['status_drmed'] !== 1) {
            echo '<script>alert("Santri ' . htmlspecialchars($hasil['nm_siswa']) . ' Bukan Crew DRMEDIA");</script>';
            echo '<script>window.location.href="../admin_drmed/isi_studio.php";</script>';
            mysqli_rollback($conn);
            exit();
        }

        // Insert ke studio
        $stmt = mysqli_prepare($conn, "INSERT INTO dr_media_studio (id_wali, kelamin, status) VALUES (?, ?, '1')");
        mysqli_stmt_bind_param($stmt, 'ss', $id, $hasil['kelamin']);
        mysqli_stmt_execute($stmt);
        $affected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);

        if ($affected < 1) { throw new Exception("Gagal insert ke dr_media_studio."); }

        // Set session seperlunya
        $_SESSION['id_drmed']    = $hasil['id_wali'];
        $_SESSION['email_drmed'] = $hasil['email_wali'];
        $_SESSION['nm_drmed']    = $hasil['nm_siswa'];
        $_SESSION['kelas_drmed'] = $hasil['kelas_wali'];
        $_SESSION['id_kelas']    = $hasil['id_kelas'];
        $_SESSION['profil_drmed']= $hasil['foto_siswa'];
        $_SESSION['kelamin']     = $hasil['kelamin'];
        $_SESSION['status']      = 'crew';

        $stat = 'masuk';
        $wali = $hasil;
    }

    // Commit dulu supaya perubahan pasti tersimpan
    mysqli_commit($conn);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo '<script>alert("Terjadi kesalahan: ' . htmlspecialchars($e->getMessage()) . '");</script>';
    echo '<script>window.location.href="../admin_drmed/isi_studio.php";</script>';
    exit();
}

// === Kirim WA SETELAH COMMIT (tidak ada redirect/exit di sini) ===
kirimLaporanStudio($conn, $wali, $stat, $_SERVER['REMOTE_ADDR']);

// === ALERT BERHASIL BARCODE + redirect ===
$namaForAlert = $wali['nm_siswa'] ?? 'Unknown';
echo '<script>
    alert("Barcode ' . ($stat === 'masuk' ? 'MASUK' : 'KELUAR') . ' berhasil diproses untuk ' . htmlspecialchars($namaForAlert) . '");

    window.location.href="../admin_drmed/isi_studio.php";
</script>';
exit();


?>