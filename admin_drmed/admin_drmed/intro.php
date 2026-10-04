<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>DRMEDIA PAGE</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

</head>

<?php include 'config/koneksi.php'; ?>

<?php
session_start();


if (isset($_GET['guru'])) {

    $gu = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM dr_guru WHERE id_guru = '$_SESSION[id_guru]'"));
    $_SESSION['id_drmed'] = $gu['id_guru'];
    $_SESSION['email_drmed'] = $gu['email_guru'];
    $_SESSION['nm_drmed'] = $gu['nm_guru'];
    $_SESSION['kelas_drmed'] = $gu['kelas_guru'];
    $_SESSION['id_kelas'] = $gu['id_kelas'];  // Fixed session key here
    $_SESSION['profil_drmed'] = $gu['profil_guru'];
    $_SESSION['kelamin'] = $gu['kelamin'];
    $_SESSION['status'] = 'guru';
}

$_SESSION['media'] = 'media';
if (isset($_SESSION['id_drmed'])) {

    $l31 = mysqli_query($conn, "SELECT * FROM dr_guru WHERE id_guru = '$_SESSION[id_drmed]' ");
    $drmed = mysqli_fetch_array($l31);

    if ($_SESSION['kelamin'] == 'L') {
        $kelamin = 'Ustad. ';
    } elseif ($_SESSION['kelamin'] == 'P') {
        $kelamin = 'Ustadzah. ';
    } else {
        $kelamin = '';
    }

}
?>