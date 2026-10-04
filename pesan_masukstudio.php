<?php
// pesan_masukstudio.php
function kirimLaporanStudio($conn, $wali, $stat, $remoteAddr)
{
    // --- Kirim WA hanya jika bukan localhost ---
    $isLocalhost = ($remoteAddr === '127.0.0.1' || $remoteAddr === '::1');
    if ($isLocalhost || empty($stat) || empty($wali))
        return;

    // Ambil device id gateway
    $qGate = mysqli_query($conn, "SELECT deviceid FROM dr_gateway WHERE id_gateway = 4");
    $gate = mysqli_fetch_assoc($qGate);
    $device_id = $gate['deviceid'] ?? null;
    if (!$device_id) {
        error_log('device_id tidak ditemukan untuk id_gateway=4');
        return;
    }

    // Label kelamin
    $klamin = (isset($wali['kelamin']) && strtolower($wali['kelamin']) === 'laki-laki') ? 'CREW PUTRA ' : 'CREW PUTRI ';

    // Total crew di studio dgn kelamin sama & status=1
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total
                                   FROM dr_media_studio m
                                   JOIN dr_wali w ON m.id_wali = w.id_wali
                                   WHERE m.status = '1' AND w.kelamin = ?");
    $kelaminNow = $wali['kelamin'];
    mysqli_stmt_bind_param($stmt, 's', $kelaminNow);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);
    $total = (int) ($row['total'] ?? 0);

    // Locale Indonesia
    setlocale(LC_TIME, 'id_ID.UTF-8', 'id_ID', 'Indonesian');
    $hari = strftime("%A");
    $tanggal = date('d-m-Y');
    $jam = date('H:i');

    $pesanTag = ($stat === 'masuk') ? '*MASUK*' : '*KELUAR*';

    $message2 = $klamin . " " . $pesanTag . " KE STUDIO \n" . $jam . ", " . $hari . " " . $tanggal . "\n\n";

    if ($total > 0) {
        $message2 .= "Total *" . $total . "* crew di dalam Studio\n\n" .
            "Nama : " . $wali['nm_siswa'] . "\n" .
            "Kelas : " . $wali['kelas_wali'] . "\n\n";
    } else {
        if ($stat === 'keluar') {
            $message2 .= $wali['nm_siswa'] . " Keluar dari Studio \n\n";
        }
        $message2 .= "Studio Sudah *KOSONG* \n\n";
    }

    $message2 .= "Untuk lihat crew di dalam studio bisa klik disini\n" .
        "https://santripage.pp-daarulrahman.sch.id/admin_drmed/isi_studio.php";

    // Kirim via WhatsApp Center
    $urlgrup = "https://app.whacenter.com/api/sendGroup";
    $grup = 'LAPORAN ISI STUDIO';
    $payload = http_build_query([
        'device_id' => $device_id,
        'group' => $grup,
        'message' => $message2
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlgrup);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $resp = curl_exec($ch);

    if (curl_errno($ch)) {
        error_log('cURL error (group): ' . curl_error($ch));
    } else {
        error_log('cURL response (group): ' . $resp);
    }
    curl_close($ch);
}
?>