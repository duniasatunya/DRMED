<?php include 'config/koneksi.php'; ?>
<?php include 'intro.php'; ?>

<body>

    <?php include 'header.php'; ?>

    <!-- ***** Header Area End ***** -->

    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>CREW DRMEDIA</h3>

                    <?php if (isset($_GET['profil'])) {

                        $l1 = mysqli_query($conn, "SELECT * FROM dr_wali WHERE id_wali = '$_GET[profil]'");
                        $siswa = mysqli_fetch_array($l1);
                        ?>
                        <span class="breadcrumb"><a href="index.php">Home</a> > <a href="crew.php">Our Crew</a> >
                            <?= $siswa['nm_siswa'] ?></span>


                        <br>
                        <img src="../images/foto_siswa/<?= $siswa['foto_siswa'] ?>" alt=""
                            style="height:400px;width:auto;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <?php if (isset($_SESSION['id_drmed'])) { ?>

                            <img src="../images/barcode/wali<?= $siswa['id_wali'] ?>_barcode.png" alt=""
                                style="height:400px;width:auto;">

                        </div><?php } ?>


                <?php } else { ?>

                    <span class="breadcrumb"><a href="index.php">Home</a> > Our Crew
                    </span>

                    <?php if (isset($_SESSION['status']) and $_SESSION['status'] == 'guru') { ?>

                        <form action="?tambah" method="POST">
                            <div class="form-group">
                                <select name="id_kelas" class="form-control kelas-select" onchange="fetchSantri(this.value)">
                                    <option value="">Pilih Nama Kelas</option>
                                    <?php

                                    $ss = mysqli_query($conn, "SELECT * FROM dr_tahun WHERE status = '1'");
                                    $tahun = mysqli_fetch_array($ss);

                                    $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM dr_kelas WHERE tahun_id = '$tahun[tahun_id]' AND nm_kelas NOT LIKE '%BOGOR%' ORDER BY kode_kelamin,nm_kelas");
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<option value='" . $row['id_kelas'] . "'>" . $row['nm_kelas'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <br>

                            <div class="form-group">
                                <select name="id_wali" class="form-control" id="santriSelect">
                                    <option value="">Pilih Nama Santri</option>
                                </select>
                                <input type="hidden" name="nm_siswa" class="id-wali-input">
                            </div>

                            <script>
                                function fetchSantri(kelasId) {
                                    const santriSelect = document.getElementById('santriSelect');
                                    santriSelect.innerHTML = '<option value="">Pilih Nama Santri</option>'; // Reset santri select

                                    if (kelasId) {
                                        // Buat permintaan AJAX
                                        const xhr = new XMLHttpRequest();
                                        xhr.open('GET', 'fetch_santri.php?kelas_id=' + kelasId, true);
                                        xhr.onload = function () {
                                            if (this.status === 200) {
                                                const santri = JSON.parse(this.responseText);
                                                santri.forEach(function (item) {
                                                    const option = document.createElement('option');
                                                    option.value = item.id_wali; // Ganti dengan ID santri
                                                    option.textContent = item.nm_siswa; // Ganti dengan nama santri
                                                    santriSelect.appendChild(option);
                                                });
                                            }
                                        };
                                        xhr.send();
                                    }
                                }
                            </script>
                            <br>
                            <input type="submit" value="TAMBAH" class="btn btn-primary">
                        </form>
                    <?php } ?>

                <?php } ?>

                <?php
                if (isset($_GET['tambah'])) {
                    $nm = $_POST['nm_siswa'];
                    $idwali = $_POST['id_wali'];

                    $tambah = mysqli_query($conn, "UPDATE dr_wali SET status_drmed = '1' WHERE id_wali = '$idwali'");

                    if ($tambah) {
                        echo '<script>alert("BERHASIL MENAMBAHKAN");window.location.href="crew.php";</script>';
                    } else {
                        echo '<script>alert("gagal);window.location.href="crew.php";</script>';
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
                                            <center>Nama</center>
                                        </th>

                                        <th class="s">
                                            <center>Kelas</center>
                                        </th>
                                        <?php if (isset($_SESSION['status']) and $_SESSION['status'] == 'guru') { ?>

                                            <th class="s">
                                                <center>Aksi</center>
                                            </th>

                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $no = 1;
                                    $l1 = mysqli_query($conn, "SELECT * FROM dr_wali WHERE status_drmed = '1' ORDER BY kelamin,kelas_wali ASC");
                                    while ($siswa = mysqli_fetch_array($l1)) {



                                        ?>


                                        <tr>

                                            <td data-label="No.">

                                                <center><?php echo $no++ ?></center>

                                            </td>



                                            <td> <a href="?profil=<?php echo $siswa['id_wali'] ?>"><?php echo $siswa['nm_siswa'] ?>
                                                </a></td>

                                            <td><?php echo $siswa['kelas_wali'] ?></td>

                                            <?php if (isset($_SESSION['status']) and $_SESSION['status'] == 'guru') { ?>

                                                <td class="s">
                                                    <a href="?hapus=<?php echo $siswa['id_wali'] ?>" style="color:red"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        Hapus </a>
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


                            $id_wali = $_GET['hapus'];

                            $hapus = mysqli_query($conn, "UPDATE dr_wali SET status_drmed = '0' WHERE id_wali = '$id_wali' ");



                            if ($hapus) {

                                echo '<script>alert("BERHASIL HAPUS");window.location.href="crew.php";</script>';
                            } else {
                                echo '<script>alert("gagal);window.location.href="crew.php";</script>';

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