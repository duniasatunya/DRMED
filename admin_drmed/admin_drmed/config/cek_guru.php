<?php
  session_start();
  if(!isset($_SESSION['nm_guru'])) {
  header('location:../index.php'); }
  else { $nm_guru = $_SESSION['nm_guru']; }
  require_once("koneksi.php");
  // $query = mysqli_query($conn, "SELECT * FROM dr_wali WHERE nm_guru = '$nm_guru'");
  // $hasil = mysqli_fetch_array($query);
?>