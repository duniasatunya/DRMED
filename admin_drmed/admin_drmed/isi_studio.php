<?php include 'intro.php'; ?>

<body>

    <?php include 'header.php'; ?>



    <?php
    // $check = mysqli_query($conn, "SELECT * FROM dr_wali WHERE id_wali = '490' ") or die(mysqli_error($conn));
    // $hasil = mysqli_fetch_array($check);
    
    // $_SESSION['id_drmed'] = $hasil['id_wali'];
    // $_SESSION['email_drmed'] = $hasil['email_wali'];
    // $_SESSION['nm_drmed'] = $hasil['nm_siswa'];
    // $_SESSION['kelas_drmed'] = $hasil['kelas_wali'];
    // $_SESSION['id_drmed'] = $hasil['id_kelas'];
    // $_SESSION['profil_drmed'] = $hasil['foto_siswa'];
    
    // $_SESSION['kelamin'] = $hasil['kelamin'];
    // $_SESSION['status'] = 'crew';
    ?>


    <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="caption header-text">
                        <h6>
                            Crew di Studio
                        </h6>
                        <?php
                        $l12 = mysqli_query($conn, "SELECT * FROM dr_media_studio WHERE status = '1' ");
                        $total = mysqli_num_rows($l12); ?>
                        <h3>Total <b style="color:white"><?= $total ?></b> di Studio</h3>
                        <br>
                        <div class="search-input">
                            <form id="search" action="#" onsubmit="return false;">
                                <input type="password" placeholder="Absen Barcode Disini" id="searchText"
                                    name="searchKeyword" onpaste="return false" ondrop="return false"
                                    oncopy="return false" oncut="return false" />
                                <button type="button" onclick="redirectToLink()">Absen</button>
                            </form>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    document.getElementById('searchText').focus();
                                });

                                function redirectToLink() {
                                    const barcode = document.getElementById('searchText').value.trim();
                                    if (barcode) {
                                        // Validasi URL
                                        if (validateURL(barcode)) {
                                            // Mengarahkan ke URL yang sudah ada di barcode, menambahkan &crew_media
                                            window.location.href = barcode + '&crew_media'; // Mengarahkan ke URL dengan &crew_media
                                        } else {
                                            alert('URL tidak valid.');
                                        }
                                    } else {
                                        alert('Silakan masukkan barcode yang valid.');
                                    }
                                }

                                // Fungsi untuk validasi URL
                                function validateURL(url) {
                                    // Tentukan awalan URL yang diizinkan
                                    const allowedURL = "https://santripage.pp-daarulrahman.sch.id/log/?id=";
                                    // Memeriksa apakah URL yang dimasukkan sesuai dengan awalan yang diizinkan
                                    return url.startsWith(allowedURL);
                                }

                                // Optional: Jika Anda ingin mengarahkan secara otomatis saat barcode dipindai
                                document.getElementById('searchText').addEventListener('input', function () {
                                    const barcode = this.value.trim();
                                    if (barcode) {
                                        // Validasi URL
                                        if (validateURL(barcode)) {
                                            // Mengarahkan ke URL yang sudah ada di barcode, menambahkan &crew_media
                                            window.location.href = barcode + '&crew_media'; // Mengarahkan ke URL dengan &crew_media
                                        }
                                    }
                                });

                            </script>
                        </div>
                        <br>

                        <div class="box-body" style="color:white">




                            <style>
                                .container2 {
                                    display: flex;
                                    flex-wrap: wrap;
                                    gap: 20px;
                                    /* Adjust the space between columns */
                                }

                                .item {
                                    flex: 0 0 45%;
                                    /* Each item will take 45% of the container's width */
                                    margin-bottom: 10px;
                                }

                                h1 {
                                    margin: 0;
                                }

                                .item span {
                                    font-size: 18px;
                                }
                            </style>

                            <div class="container2">
                                <?php
                                $no = 1;
                                $l1 = mysqli_query($conn, "SELECT * FROM dr_media_studio m
                        JOIN dr_wali w ON w.id_wali = m.id_wali  ORDER BY m.id_crewdrmed ASC");
                                while ($siswa = mysqli_fetch_array($l1)) {
                                    // Menentukan warna berdasarkan status
                                    $col = ($siswa['status'] == '1') ? 'white' : 'red';
                                    ?>
                                    <div class="item">
                                        <h1 style="color:<?= $col ?>"><?= $no++ ?></h1>
                                        <span><?= $siswa['nm_siswa'] ?> <b
                                                style="font-size:20px"><?= $siswa['kelas_wali'] ?></b></span>
                                        <br><br>
                                        <!-- Input pekerjaan dengan gaya background otomatis -->
                                        <input type="text" class="kerjaan form-control"
                                            style="background-color:<?= $siswa['kerjaan'] == NULL ? 'red' : 'white'; ?>"
                                            data-id="<?= $siswa['id_crewdrmed'] ?>" value="<?= $siswa['kerjaan'] ?>"
                                            placeholder="Ngapain ... ?">
                                        <div id="message-<?= $siswa['id_crewdrmed'] ?>"></div>
                                        <!-- Pesan sukses/gagal untuk setiap data -->
                                    </div>
                                    <br>
                                <?php } ?>
                            </div>



                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                            <script>
                                $(document).ready(function () {
                                    // Tangkap event keyup pada setiap input pekerjaan dengan kelas .kerjaan
                                    $('.kerjaan').on('keyup change', function () {
                                        var pekerjaan = $(this).val(); // Ambil nilai input pekerjaan
                                        var id_kerjaan = $(this).data('id'); // Ambil id_crewdrmed dari data-id

                                        // Cek apakah input pekerjaan kosong
                                        if (pekerjaan == "") {
                                            // Jika kosong, ubah background menjadi merah
                                            $(this).css('background-color', 'red');
                                        } else {
                                            // Jika ada isian, ubah background menjadi putih
                                            $(this).css('background-color', 'white');
                                        }

                                        // Kirim data menggunakan AJAX jika pekerjaan tidak kosong
                                        if (pekerjaan != "") {
                                            $.ajax({
                                                url: 'update_kerjaan.php',  // File PHP untuk menangani request
                                                method: 'POST',
                                                data: {
                                                    pekerjaan: pekerjaan,
                                                    id_crewdrmed: id_kerjaan  // Kirim id_crewdrmed untuk setiap input pekerjaan
                                                },
                                                success: function (response) {
                                                    if (response == "success") {
                                                        $('#message-' + id_kerjaan).html('<div class="alert alert-success">Data berhasil diperbarui!</div>');
                                                    } else {
                                                        $('#message-' + id_kerjaan).html('<div class="alert alert-danger">Gagal memperbarui data.</div>');
                                                    }
                                                },
                                                error: function (xhr, status, error) {
                                                    $('#message-' + id_kerjaan).html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi!</div>');
                                                }
                                            });
                                        }
                                    });
                                });
                            </script>







                        </div>

                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="right-image">
                        <?php if (!isset($_SESSION['status']) && isset($_SESSION['status']) && $_SESSION['status'] == 'crew') { ?>

                            <img src="assets/images/banner-image.jpg" alt="">

                        <?php } else { ?>
                            <img src="../images/foto_siswa/<?= isset($_SESSION['profil_drmed']) ? $_SESSION['profil_drmed'] : '' ?>"
                                alt="">

                        <?php } ?>
                        <span class="price"><?= isset($_SESSION['nm_drmed']) ? $_SESSION['nm_drmed'] : '' ?></span>

                        <style>
                            /* Menyembunyikan elemen .offer pada perangkat dengan lebar layar kurang dari 768px (mobile) */
                            @media (max-width: 767px) {
                                .offer {
                                    display: none !important;
                                }
                            }
                        </style>
                        <span
                            class="offer"><?= isset($_SESSION['kelas_drmed']) ? $_SESSION['kelas_drmed'] : '' ?></span>

                    </div>
                </div>

            </div>
        </div>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>

    </div>





    <?php include 'outro.php'; ?>

</body>

</html>