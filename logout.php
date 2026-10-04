<?php
session_start();

unset($_SESSION['email_drmed']);
session_unset();
session_destroy();

?>
<script>alert("Anda sudah logout"); document.location.href = "index.php"
</script>
<?
include "index.php";
?>