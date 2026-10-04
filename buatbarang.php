<?php include 'config/koneksi.php'; ?>
<?php include 'intro.php'; ?>

<body>

    <?php include 'header.php'; ?>

    <!-- ***** Header Area End ***** -->

    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>BUAT DATA ALAT BARU</h3>
                    <?php if (isset($_GET['buat'])) {
                        $nm_alat = $_POST['nm_alat'];
                        $milik = $_POST['milik'];
                        $id_kategori = $_POST['nm_kategori'];
                        $kondisi = $_POST['kondisi'];
                        $ket = $_POST['ket'];
                        $id_alat2 = $_POST['id_alat'];

                        // Tentukan ukuran maksimum file (dalam bytes)
                        $maxSize = 10485760; // 10MB
                    
                        // Cek ukuran file
                        if ($_FILES['foto_alat']['size'] > $maxSize) {
                            echo '<script>alert("Ukuran file terlalu besar, maksimal 10MB!"); window.location.href = "buatbarang.php";</script>';
                            exit();
                        }

                        // Tentukan lokasi folder untuk menyimpan file yang diupload
                        $uploadDir = '../images/foto_alat/';
                        // Tentukan nama file yang diupload
                        $foto_alat = mysqli_real_escape_string($conn, str_replace(' ', '_', $_FILES["foto_alat"]['name']));
                        $uploadFile = $uploadDir . $foto_alat;

                        // Pindahkan file ke folder yang ditentukan
                        if (move_uploaded_file($_FILES['foto_alat']['tmp_name'], $uploadFile)) {
                            // Jika upload berhasil, masukkan data ke database
                            $buat = mysqli_query($conn, "INSERT INTO dr_mediaalat (id_alat,nm_alat,id_kategori,kondisi,ket,milik,foto_alat) VALUES ('','$nm_alat','$id_kategori','$kondisi','$ket','$milik','$foto_alat')");

                            if ($buat) {
                                $new_id = mysqli_insert_id($conn);
                                echo '<script>alert("BERHASIL BUAT DATA BARU"); window.location.href="product-details.php?id_alat=' . $new_id . '";</script>';
                            } else {
                                echo '<script>alert("Gagal menambahkan data."); window.location.href="buatbarang.php";</script>';
                            }
                        } else {
                            echo '<script>alert("Gagal meng-upload foto."); window.location.href="buatbarang.php";</script>';
                        }
                    } ?>
                    <form action="?buat" method="post" enctype="multipart/form-data">
                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                            <div style="flex: 1; margin-right: 10px;">
                                <center>
                                    <label for="nm_alat">
                                        <b>NAMA ALAT</b>
                                    </label>
                                </center>
                                <input type="text" name="nm_alat" placeholder="Nama Alat" class="form-control"
                                    style="width: 100%;" required>
                            </div>

                            <div style="flex: 1; margin-left: 10px;">
                                <center>
                                    <label for="milik">
                                        <b>KEPEMILIKAN</b>
                                    </label>
                                </center>
                                <input type="text" name="milik" placeholder="Kepemilikan Barang" class="form-control"
                                    style="width: 100%;" required>

                            </div>
                        </div>
                        <br>
                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                            <div style="flex: 1; margin-right: 10px;">
                                <center>
                                    <label for="nm_kategori">
                                        <b>KATEGORI</b>
                                    </label>
                                </center>

                                <select name="nm_kategori" class="form-control" style="width: 100%;color:black;"
                                    required>
                                    <option value="">Pilih Kategori</option>

                                    <?php $l12 = mysqli_query($conn, "SELECT * FROM  dr_mediakategorialat  ");
                                    while ($kat = mysqli_fetch_array($l12)) {
                                        ?>
                                        <option value="<?= $kat['id_kategorialat'] ?>"><?= $kat['nm_kategori'] ?></option>

                                    <?php } ?>
                                </select>


                            </div>

                            <div style="flex: 1; margin-left: 10px;">
                                <center>
                                    <label for="nm_alat">
                                        <b>Kondisi</b>
                                    </label>
                                </center>

                                <select name="kondisi" class="form-control" style="width: 100%;" required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="1">Baik</option>
                                    <option value="2">Kurang Baik</option>
                                    <option value="3">Rusak</option>

                                </select>

                            </div>
                        </div>
                        <br>
                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                            <div style="flex: 1; margin-right: 10px;">


                                <center>
                                    <label for="ket">
                                        <b>KETERANGAN</b>
                                    </label>
                                </center>
                                <textarea name="ket" class="form-control" required></textarea>


                            </div>
                        </div>
                        <BR></BR>
                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                            <div style="flex: 1; margin-right: 10px;">


                                <center>
                                    <label for="ket">
                                        <b>FOTO</b>
                                    </label>
                                </center>
                                <input type="file" name="foto_alat" class="form-control" required>
                                <center>
                                    <label>
                                        &nbsp;
                                    </label>
                                </center>
                                <input type="submit" value="BUAT DATA" class="btn btn-success"
                                    style="width: 100%;background-color:green">
                            </div>
                        </div>

                    </form>






                </div>
            </div>
        </div>
    </div>

    <div class="section trending">
        <div class="container">



            <br>
            <div class="row trending-box">






            </div>

        </div>
    </div>

    <?php include 'outro.php'; ?>


</body>

</html>