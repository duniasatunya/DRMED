<?php include 'config/koneksi.php'; ?>
<?php include 'intro.php';


if (!isset($_SESSION['id_drmed'])) {
    echo '<script>alert("Mohon Maaf anda belum login, harap login dahulu");window.location.href="login_drmed.php";</script>';
}

?>

<body>

    <?php include 'header.php'; ?>

    <!-- ***** Header Area End ***** -->

    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>PEMINJAMAN</h3>




                    <span class="breadcrumb"><a href="index.php">Home</a> > Peminjaman
                    </span>

                    <?php if (isset($_SESSION['status']) and ($_SESSION['status'] == 'guru' or $_SESSION['status'] == 'crew')) { ?>
                        <h3 style="font-size:20px">Ajukan Peminjaman</h3>
                        <form action="?tambah" method="POST">
                            <div class="form-group">
                                <label style="color:white">Nama Penanggung Jawab</label>
                                <select name="id_wali" class="form-control kelas-select" onchange="fetchSantri(this.value)"
                                    required>
                                    <option value="">Pilih Nama Crew Penanggung Jawab</option>
                                    <?php



                                    $result = mysqli_query($conn, "SELECT * FROM dr_wali WHERE status_drmed = '1' ORDER BY kelas_wali DESC");
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<option value='" . $row['id_wali'] . "'>" . $row['nm_siswa'] . " ( " . $row['kelas_wali'] . " )</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <br>
                            <label style="color:white">Keperluan</label>
                            <div class="form-group">
                                <input type="text" name="nm_pinjam" class="form-control" placeholder="Isi Keperluannya"
                                    required>
                            </div>
                            <br>
                            <label style="color:white;">Tanggal Peminjaman</label>
                            <div class="form-group">
                                <input type="date" name="tanggal_pinjam" class="form-control"
                                    placeholder="Isi Waktu Pemakian" required>
                            </div>



                            <br>
                            <input type="submit" value="BUAT PENGAJUAN" class="btn btn-info">
                        </form>


                    <?php } ?>

                    <?php
                    if (isset($_GET['tambah'])) {
                        $nm = $_POST['nm_pinjam'];
                        $idwali = $_POST['id_wali'];
                        $tanggal_pinjam = $_POST['tanggal_pinjam'];

                        $now = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS
                    
                        $tambah = mysqli_query($conn, "INSERT INTO dr_mediapeminjaman (nm_pinjam,id_wali,tanggal_pinjam,timestamp,sts_pinjam)VALUES('$nm','$idwali','$tanggal_pinjam','$now','1')");

                        if ($tambah) {
                            echo '<script>alert("BERHASIL MENAMBAHKAN PENGAJUAN");window.location.href="peminjaman.php";</script>';
                        } else {
                            echo '<script>alert("gagal);window.location.href="peminjaman.php";</script>';
                        }

                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class="section trending">
        <div class="container">
            <?php if (!isset($_GET['tabel'])) { ?>


            <?php } ?>


            <br>
            <div class="row trending-box">




                <?php if (!isset($_GET['profil'])) { ?>

                    <style type="text/css">
                        .table-responsive {
                            overflow-x: auto;
                            min-width: 100%;
                        }

                        #kelas-table {
                            width: 100%;
                        }



                        td {
                            text-align: center;
                        }
                    </style>

                    <div class="row">
                        <div class="box-body">


                            <table id="kelas-table" class="table" paging="true" paging-size="2">
                                <thead>
                                    <tr>

                                        <th class="s">
                                            <center>No.</center>
                                        </th>

                                        <th class="s">
                                            <center>Keperluan</center>
                                        </th>

                                        <th class="s">
                                            <center>Penanggung Jawab</center>
                                        </th>
                                        <th class="s">
                                            <center>Update Tanggal</center>
                                        </th>

                                        <th class="s">
                                            <center>Aksi</center>
                                        </th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $no = 1;
                                    $l1 = mysqli_query($conn, "SELECT * FROM dr_mediapeminjaman ORDER BY id_pinjam DESC");
                                    while ($pinjam = mysqli_fetch_array($l1)) {



                                        ?>


                                        <tr>

                                            <td data-label="No.">

                                                <center><?php echo $no++ ?></center>

                                            </td>



                                            <td> <a href="peminjamandetil.php?id=<?= $pinjam['id_pinjam'] ?>"><?php echo $pinjam['nm_pinjam'] ?>
                                                </a></td>
                                            <?php $k = mysqli_query($conn, "SELECT * FROM dr_wali WHERE id_wali = '$pinjam[id_wali]'");
                                            $p = mysqli_fetch_array($k); ?>
                                            <td><?php echo $p['nm_siswa'] . ' ( ' . $p['kelas_wali'] . ' )' ?></td>

                                            <?php
                                            setlocale(LC_TIME, 'id_ID.UTF-8'); // Mengatur locale ke bahasa Indonesia
                                            ?>

                                            <td>
                                                <?php
                                                $tanggalPinjam = strtotime($pinjam['timestamp']); // Mengubah string tanggal menjadi timestamp
                                                echo strftime('%A, %e %B %Y', $tanggalPinjam); // Format: Hari, Tanggal Bulan
                                                ?>
                                            </td>

                                            <?php



                                            if ($pinjam['sts_pinjam'] == '1') {
                                                $status = 'Belum Diajukan';
                                                $styl = 'black';
                                            } elseif ($pinjam['sts_pinjam'] == '2') {
                                                $status = 'Sedang Diajukan';
                                                $styl = 'orange';
                                            } elseif ($pinjam['sts_pinjam'] == '3') {
                                                $status = 'Ditolak';
                                                $styl = 'red';
                                            } elseif ($pinjam['sts_pinjam'] == '4') {
                                                $status = 'Pengajuan Diterima';
                                                $styl = 'green';
                                            } elseif ($pinjam['sts_pinjam'] == '5') {
                                                $status = 'Sudah Diambil';
                                                $styl = 'darkgreen';
                                            } elseif ($pinjam['sts_pinjam'] == '6') {
                                                $status = 'Sudah Dikembalikan';
                                                $styl = 'darkcyan';
                                            } ?>
                                            <td style="color:<?= $styl ?>"><b><?php echo $status ?></b></td>

                                            <?php if (isset($_SESSION['status']) and $_SESSION['status'] == 'guru') { ?>

                                                <td class="s">
                                                    <a href="?hapus=<?php echo $pinjam['id_pinjam'] ?>" style="color:red"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        Hapus
                                                    </a>
                                                </td>

                                            <?php } ?>
                                        </tr>



                                        <?php
                                    }
                                    ?>

                                </tbody>

                            </table>


                        <?php } ?>

                        <?php if (isset($_GET['hapus'])) {


                            $id_pinjam = $_GET['hapus'];

                            $hapus = mysqli_query($conn, "DELETE FROM dr_mediapeminjaman WHERE id_pinjam = '$id_pinjam' ");
                            $hapus2 = mysqli_query($conn, "DELETE FROM dr_mediapinjamalat WHERE id_pinjam = '$id_pinjam' ");




                            if ($hapus && $hapus2) {

                                echo '<script>alert("BERHASIL HAPUS");window.location.href="peminjaman.php";</script>';
                            } else {
                                echo '<script>alert("gagal);window.location.href="peminjaman.php";</script>';

                            }
                        } ?>
                    </div>
                    <br><br><br><br><br><br><br><br><br>
                    <div style="margin-bottom:100px"></div>
                </div>

                <script src="vendor/jquery/jquery.min.js"></script>
                <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
                <script src="assets/js/isotope.min.js"></script>
                <script src="assets/js/owl-carousel.js"></script>
                <script src="assets/js/counter.js"></script>
                <script src="assets/js/custom.js"></script>


</body>

</html>