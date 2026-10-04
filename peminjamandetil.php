<?php include 'config/koneksi.php'; ?>
<?php include 'intro.php';

if (!isset($_SESSION['id_drmed'])) {
    echo '<script>alert("Mohon Maaf anda belum login, harap login dahulu");window.location.href="login_drmed.php";</script>';
}
?>

<body>

    <?php include 'header.php'; ?>

    <!-- ***** Header Area End ***** -->
    <?php
    $a = mysqli_query($conn, "SELECT * FROM dr_mediapeminjaman WHERE id_pinjam = '$_GET[id]'");
    $pinjam = mysqli_fetch_array($a);





    ?>
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>PEMINJAMAN</h3>




                    <span class="breadcrumb"><a href="index.php">Home</a> > Peminjaman
                    </span>


                    <h3 style="font-size:20px">Informasi Peminjaman</h3>



                    <div class="form-group">
                        <label style="color:white">Nama Penanggung Jawab</label>

                        <?php $k = mysqli_query($conn, "SELECT * FROM dr_wali WHERE id_wali = '$pinjam[id_wali]'");
                        $p = mysqli_fetch_array($k); ?>

                        <h2 style="color:white"><?php echo $p['nm_siswa'] . ' ( ' . $p['kelas_wali'] . ' )' ?></h2>

                    </div>
                    <div class="form-group">
                        <label style="color:white">Keperluan</label>


                        <h2 style="color:white"><?php echo $pinjam['nm_pinjam'] ?></h2>


                    </div>

                    <?php



                    if ($pinjam['sts_pinjam'] == '1') {
                        $status = 'Belum Diajukan';
                        $styl = 'black';
                        $t = $pinjam['tanggal_pinjam'];
                    } elseif ($pinjam['sts_pinjam'] == '2') {
                        $status = 'Sedang Diajukan';
                        $styl = 'orange';
                        $t = $pinjam['tanggal_diajukan'];
                    } elseif ($pinjam['sts_pinjam'] == '3') {
                        $status = 'Ditolak';
                        $styl = 'red';
                        $t = $pinjam['tanggal_ditolak'];
                    } elseif ($pinjam['sts_pinjam'] == '4') {
                        $status = 'Pengajuan Diterima';
                        $styl = 'aqua';
                        $t = $pinjam['tanggal_diterima'];
                    } elseif ($pinjam['sts_pinjam'] == '5') {
                        $status = 'Sudah Diambil';
                        $styl = 'yellow';
                        $t = $pinjam['tanggal_diambil'];
                    } elseif ($pinjam['sts_pinjam'] == '6') {
                        $status = 'Sudah Selesai';
                        $styl = 'white';
                        $t = $pinjam['tanggal_dikembalikan'];
                    } ?>

                    <div class="form-group">
                        <label style="color:white">Status Peminjaman</label>
                        <h2 style="color:<?= $styl ?>">" <?= $status ?> "</h2>

                        <?php
                        setlocale(LC_TIME, 'id_ID.UTF-8'); // Mengatur locale ke bahasa Indonesia
                        ?>

                        <td>
                            <?php
                            $tanggal2 = strtotime($t); // Mengubah string tanggal menjadi timestamp
                            $tanggal = strftime('%A, %e %B %Y, %H:%M', $tanggal2); // Format: Hari, Tanggal Bulan, Jam:Menit
                            ?>
                        </td>
                        <p style="color:white">- <?= $tanggal ?> -</p>




                        <br>
                        <div class="row">

                            <style type="text/css">
                                .table-responsive {
                                    margin-left: 10px;
                                    margin-right: 10px;
                                }

                                .table {
                                    font-family: 'Montserrat', sans-serif;
                                    font-size: 12px;
                                    background-color: white;
                                    border-radius: 20px;
                                }
                            </style>

                            <div class="table-responsive">

                                <table id="guru-table" class="table" paging="true" paging-size="2">
                                    <thead>
                                        <tr>

                                            <th class="s">
                                                <center>No.</center>
                                            </th>

                                            <th class="s">
                                                <center>Nama Alat</center>
                                            </th>

                                            <th class="s">
                                                <center>Jumlah Dipinjam</center>
                                            </th>


                                            <?php if ($pinjam['sts_pinjam'] == '1' or $pinjam['sts_pinjam'] == '3') { ?>
                                                <th class="s">
                                                    <center>Jumlah Asli</center>
                                                </th>
                                                <th class="s">
                                                    <center>Aksi</center>
                                                </th>

                                            <?php } ?>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        // Mengambil nilai pencarian
                                        $search = isset($_GET['search']) ? $_GET['search'] : '';

                                        $no = 1;
                                        $query = "SELECT * FROM dr_mediapinjamalat pm JOIN dr_mediaalat a 
                                    ON pm.id_alat = a.id_alat WHERE pm.id_pinjam = '$pinjam[id_pinjam]' GROUP BY a.nm_alat";
                                        $ambil = mysqli_query($conn, $query);
                                        while ($datapinjam = mysqli_fetch_array($ambil)) {

                                            $a2 = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE id_alat = '$datapinjam[id_alat]'");
                                            $alat2 = mysqli_fetch_array($a2);

                                            $a22 = mysqli_query($conn, "SELECT * FROM dr_mediaalat  WHERE nm_alat = '$alat2[nm_alat]'");
                                            $qty2 = mysqli_num_rows($a22);


                                            $a2 = mysqli_query($conn, "SELECT * FROM dr_mediaalat a JOIN dr_mediapinjamalat p
                                        ON p.id_alat = a.id_alat WHERE a.nm_alat = '$alat2[nm_alat]' AND p.id_pinjam = '$datapinjam[id_pinjam]'");
                                            $qty = mysqli_num_rows($a2);

                                            ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $alat2['nm_alat'] ?></td>
                                                <td><?php echo $qty ?></td>

                                                <?php if ($pinjam['sts_pinjam'] == '1' or $pinjam['sts_pinjam'] == '3') { ?>
                                                    <td><?php echo $qty2 ?></td>
                                                    <td>


                                                        <button class="btn btn-danger remove-from-cart"
                                                            data-id="<?= $datapinjam['id_pinjamalat'] ?>">Kurangi</button>

                                                    </td>
                                                <?php } ?>


                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <?php if ($pinjam['sts_pinjam'] == '1') { ?>

                                    <a href="?id=<?= $_GET['id'] ?>&ajukan=<?= $datapinjam['id_pinjam'] ?>"
                                        class="btn btn-info"
                                        onclick="return confirm('Apakah Anda yakin ? barang yang sudah diajukan tidak dapat diedit kecuali jika direvisi')">AJUKAN
                                        SEKARANG !!</a>

                                <?php } elseif (isset($_SESSION['status']) and $_SESSION['status'] == 'guru' and $pinjam['sts_pinjam'] == '2') { ?>

                                    <a href="?id=<?= $_GET['id'] ?>&terima" class="btn btn-success"
                                        onclick="return confirm('Apakah Anda yakin ? menerima pengajuan')">TERIMA
                                        PENGAJUAN</a>
                                    &nbsp;


                                    <a href="?id=<?= $_GET['id'] ?>&tolak" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ? menolak pengajuan')">TOLAK
                                        PENGAJUAN</a>
                                <?php } elseif ($pinjam['sts_pinjam'] == '3') { ?>

                                    <a href="?id=<?= $_GET['id'] ?>&ajukan" class="btn btn-info"
                                        onclick="return confirm('Apakah Anda yakin ? barang yang sudah diajukan tidak dapat diedit kecuali jika direvisi')">AJUKAN
                                        LAGI !!</a>
                                <?php } elseif ($pinjam['sts_pinjam'] == '4') { ?>




                                    <a href="?id=<?= $_GET['id'] ?>&ambilbarang" class="btn btn-secondary"
                                        onclick="return confirm('Apakah Anda yakin ? untuk mengambil barang')">AMBIL
                                        BARANG</a>
                                <?php } elseif ($pinjam['sts_pinjam'] == '5') { ?>

                                    <a href="?id=<?= $_GET['id'] ?>&selesai" class="btn btn-info"
                                        onclick="return confirm('Apakah Anda yakin ? untuk menyelesaikan peminjaman ? anda bertanggung jawab atas barang barang ini')">PEMINJAMAN
                                        SELESAI</a>
                                <?php } ?>




                                <?php
                                if (isset($_GET['ajukan']) or isset($_GET['terima']) or isset($_GET['tolak']) or isset($_GET['ambilbarang']) or isset($_GET['selesai'])) {
                                    $query = "SELECT * FROM dr_mediapinjamalat pm JOIN dr_mediaalat a 
          ON pm.id_alat = a.id_alat WHERE pm.id_pinjam = '$_GET[id]' AND pm.id_pinjam = '$datapinjam[id_pinjam]' GROUP BY a.nm_alat";
                                    $ambil = mysqli_query($conn, $query);

                                    if (isset($_GET['ajukan'])) {
                                        // Variabel untuk melacak status
                                        $allCorrect = true; // Asumsikan semua benar
                                
                                        while ($datapinjam = mysqli_fetch_array($ambil)) {
                                            $a2 = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE id_alat = '$datapinjam[id_alat]'");
                                            $alat2 = mysqli_fetch_array($a2);

                                            $a22 = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat2[nm_alat]'");
                                            $qty2 = mysqli_num_rows($a22);

                                            $a2 = mysqli_query($conn, "SELECT * FROM dr_mediaalat a JOIN dr_mediapinjamalat p ON p.id_alat = a.id_alat WHERE a.nm_alat = '$alat2[nm_alat]'");
                                            $qty = mysqli_num_rows($a2);

                                            // Memeriksa kondisi
                                            if ($qty > $qty2) {
                                                $allCorrect = false; // Set status menjadi salah jika ada yang salah
                                                break; // Keluar dari loop jika sudah ditemukan yang salah
                                            }
                                        }

                                        // Menampilkan hasil akhir
                                        if ($allCorrect) {

                                            date_default_timezone_set('Asia/Jakarta'); // Mengatur zona waktu ke Jakarta, Indonesia
                                            $now = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS
                                
                                            $ajukan = mysqli_query($conn, "UPDATE dr_mediapeminjaman SET sts_pinjam = '2', tanggal_diajukan = '$now' WHERE id_pinjam = '$_GET[id]'");

                                            if ($ajukan) {
                                                echo '<script>alert("BERHASIL DIAJUKAN");window.location.href="peminjamandetil.php?id=' . $_GET['id'] . '";</script>';
                                            } else {
                                                echo '<script>alert("GAGAL");window.location.href="peminjamandetil.php?id=' . $_GET['id'] . '";</script>';

                                            }

                                        } else {
                                            echo '<script>alert("GAGAL, mungkin ada Jumlah yang tidak sesuai");window.location.href="peminjamandetil.php?id=' . $_GET['id'] . '";</script>';
                                        }
                                    } elseif (isset($_GET['terima']) or isset($_GET['tolak']) or isset($_GET['ambilbarang']) or isset($_GET['selesai'])) {

                                        if (isset($_GET['terima'])) {
                                            $sq = 'tanggal_diterima';
                                            $sts = '4';
                                        } elseif (isset($_GET['tolak'])) {
                                            $sq = 'tanggal_ditolak';
                                            $sts = '3';
                                        } elseif (isset($_GET['ambilbarang'])) {
                                            $sq = 'tanggal_diambil';
                                            $sts = '5';
                                        } elseif (isset($_GET['selesai'])) {
                                            $sq = 'tanggal_dikembalikan';
                                            $sts = '6';
                                        }

                                        date_default_timezone_set('Asia/Jakarta'); // Mengatur zona waktu ke Jakarta, Indonesia
                                        $now = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS
                                
                                        $ubah = mysqli_query($conn, "UPDATE dr_mediapeminjaman SET sts_pinjam = '$sts', $sq = '$now' WHERE id_pinjam = '$_GET[id]'");

                                        if ($ubah) {
                                            echo '<script>alert("Berhasil");window.location.href="peminjamandetil.php?id=' . $_GET['id'] . '";</script>';

                                        } else {
                                            echo '<script>alert("GAGAL");window.location.href="peminjamandetil.php?id=' . $_GET['id'] . '";</script>';
                                        }

                                    }



                                }

                                ?>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function () {
                                        $('.remove-from-cart').click(function () {
                                            var idPinjamAlat = $(this).data('id');

                                            // Konfirmasi penghapusan
                                            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                                                $.ajax({
                                                    url: 'remove_from_cart.php', // URL untuk menghapus item
                                                    type: 'POST',
                                                    data: {
                                                        id_pinjamalat: idPinjamAlat
                                                    },
                                                    success: function (response) {
                                                        var result = JSON.parse(response);
                                                        if (result.status === 'success') {
                                                            alert('Item berhasil dihapus!');
                                                            location.reload(); // Reload halaman untuk memperbarui tampilan
                                                        } else {
                                                            alert('Terjadi kesalahan: ' + result.message);
                                                        }
                                                    },
                                                    error: function () {
                                                        alert('Terjadi kesalahan saat menghapus item.');
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>
                            </div>

                        </div>






                    </div>







                </div>
            </div>
        </div>
    </div>
    <?php if ($pinjam['sts_pinjam'] == '1' or $pinjam['sts_pinjam'] == '3') { ?>

        <div class="section trending">
            <div class="container">
                <?php if (!isset($_GET['tabel'])) { ?>

                    <ul class="trending-filter">
                        <li>
                            <a class="is_active" href="#!" data-filter="*">Show All</a>
                        </li>
                        <?php
                        $l = mysqli_query($conn, "SELECT * FROM dr_mediakategorialat ");
                        while ($kat = mysqli_fetch_array($l)) {

                            ?>
                            <li>
                                <a href="#!" data-filter=".<?= $kat['filler'] ?>"><?= $kat['nm_kategori'] ?></a>
                            </li>
                        <?php } ?>


                    </ul>
                <?php } ?>

                <style>
                    .main-banners {
                        display: flex;
                        /* Menggunakan Flexbox */
                        justify-content: center;
                        /* Memposisikan konten di tengah secara horizontal */
                    }

                    .main-banners .caption form {
                        position: relative;
                        max-width: 450px;
                        /* Lebar maksimum form */
                        width: 100%;
                        /* Memastikan form mengisi lebar maksimum */
                    }

                    .main-banners .caption form input {
                        max-width: 450px;
                        width: 100%;
                        height: 50px;
                        outline: none;
                        border-radius: 25px;
                        background-color: #fff;
                        border: none;
                        padding: 0px 25px;
                        font-size: 14px;
                        color: #7a7a7a;
                    }

                    .main-banners .caption form button {
                        display: inline-block;
                        height: 50px;
                        line-height: 50px;
                        background-color: green;
                        color: #fff;
                        font-size: 15px;
                        text-transform: uppercase;
                        font-weight: 500;
                        padding: 0px 25px;
                        border: none;
                        border-radius: 25px;
                        position: absolute;
                        right: 0;
                        top: 0;
                        transition: all .3s;
                    }

                    .main-banners .caption form button:hover {
                        background-color: #0071f8;
                    }
                </style>
                <div class="main-banners">

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 align-self-center">
                                <div class="caption header-text">
                                    <div class="search-input">
                                        <form id="search" action="#">
                                            <input type="text" placeholder="Cari barang disini" id='searchText'
                                                name="searchKeyword" oninput="searchItems()" />
                                            <button role="button" style="display: none;">Cari</button>
                                            <!-- Sembunyikan tombol -->
                                        </form>
                                        <script>
                                            function searchItems() {
                                                const input = document.getElementById('searchText').value.toLowerCase(); // Ambil nilai input
                                                const items = document.querySelectorAll('.trending-items'); // Ambil semua item yang ingin difilter

                                                items.forEach(item => {
                                                    const itemName = item.querySelector('.down-content h4').textContent.toLowerCase(); // Ambil nama alat dari elemen yang sesuai
                                                    if (itemName.includes(input)) {
                                                        item.style.display = ''; // Tampilkan item jika cocok
                                                    } else {
                                                        item.style.display = 'none'; // Sembunyikan item jika tidak cocok
                                                    }
                                                });
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row trending-box">




                    <?php
                    $l1 = mysqli_query($conn, "SELECT * FROM dr_mediaalat GROUP BY nm_alat");
                    while ($alat = mysqli_fetch_array($l1)) {
                        $l3 = mysqli_query($conn, "SELECT * FROM dr_mediakategorialat WHERE id_kategorialat = '$alat[id_kategori]'");
                        $kat3 = mysqli_fetch_array($l3);

                        $lqty = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]'");
                        $qty = mysqli_num_rows($lqty);

                        $lbaik = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]' AND kondisi = '1'");
                        $baik = mysqli_num_rows($lbaik);

                        $lkurangbaik = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]' AND kondisi = '2'");
                        $kurangbaik = mysqli_num_rows($lkurangbaik);

                        $lrusak = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]' AND kondisi = '3'");
                        $rusak = mysqli_num_rows($lrusak);
                        ?>
                        <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items <?= $kat3['filler'] ?>">
                            <div class="item">
                                <div class="thumb">
                                    <a href="product-details.php?id_alat=<?= $alat['id_alat'] ?>">
                                        <img src="../images/foto_alat/<?= $alat['foto_alat'] ?>" alt="" height="250px"
                                            width="150px">
                                    </a>
                                    <span class="price">QTY <b><?= $qty ?></b></span><br>
                                    <span class="badge text-bg-danger">Rusak <b><?= $rusak ?></b></span><br>
                                    <span class="badge text-bg-warning">Kurang Baik <b><?= $kurangbaik ?></b></span>
                                    <span class="badge text-bg-success">Baik <b><?= $baik ?></b></span>
                                </div>
                                <div class="down-content">
                                    <span class="category"><?= $kat3['nm_kategori'] ?></span>
                                    <h4><?= $alat['nm_alat'] ?></h4>
                                    <style>
                                        /* Gaya untuk container item */

                                        /* Gaya untuk input quantity */
                                        .qty-input {
                                            width: 70px;
                                            /* Lebar input */
                                            padding: 10px;
                                            /* Padding di dalam input */
                                            border: 1px solid #007bff;
                                            /* Border berwarna biru */
                                            border-radius: 5px;
                                            /* Sudut melengkung */
                                            font-size: 16px;
                                            /* Ukuran font */
                                            text-align: center;
                                            /* Teks di tengah */
                                            margin-right: 10px;
                                            /* Jarak antara input dan tombol */
                                        }

                                        /* Gaya untuk tombol */
                                        .btn-primary {
                                            background-color: #007bff;
                                            /* Warna latar belakang biru */
                                            color: white;
                                            /* Warna teks putih */
                                            border: none;
                                            /* Tanpa border */
                                            border-radius: 5px;
                                            /* Sudut melengkung */
                                            padding: 10px 15px;
                                            /* Padding atas-bawah dan kiri-kanan */
                                            font-size: 16px;
                                            /* Ukuran font */
                                            cursor: pointer;
                                            /* Pointer saat hover */
                                            transition: background-color 0.3s;
                                            /* Transisi untuk efek hover */
                                        }

                                        /* Efek hover untuk tombol */
                                        .btn-primary:hover {
                                            background-color: #0056b3;
                                            /* Warna latar belakang saat hover */
                                        }
                                    </style>
                                    <div class="item">
                                        <input type="number" name="qty[<?= $alat['id_alat'] ?>]" min="1" max="<?= $qty ?>"
                                            value="1" class="form-control qty-input" />
                                        <button class="btn btn-primary add-to-cart" data-id="<?= $alat['id_alat'] ?>"
                                            data-pinjam="<?= $pinjam['id_pinjam'] ?>">Tambah ke Keranjang</button>
                                    </div>
                                    <span class="category">Milik <b><?= $alat['milik'] ?></b></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            $('.add-to-cart').click(function () {
                                var idAlat = $(this).data('id');
                                var idPinjam = $(this).data('pinjam');
                                var qty = $('input[name="qty[' + idAlat + ']"]').val();

                                // Lakukan validasi jika qty lebih dari yang tersedia
                                if (qty > 0) {
                                    // Kirim data ke server untuk menambahkan ke keranjang
                                    $.ajax({
                                        url: 'add_to_cart.php', // Ganti dengan URL yang sesuai
                                        type: 'POST',
                                        data: {
                                            id_alat: idAlat,
                                            id_pinjam: idPinjam,
                                            quantity: qty
                                        },
                                        success: function (response) {
                                            alert('Item berhasil ditambahkan ke keranjang!');
                                        },
                                        error: function () {
                                            alert('Terjadi kesalahan saat menambahkan item ke keranjang.');
                                        }
                                    });
                                } else {
                                    alert('Jumlah tidak valid!');
                                }
                            });
                        });
                    </script>





                </div>
            </div>

        <?php } ?>
        <?php if (isset($_GET['tabel'])) { ?>
            <br><br><br><br><br>
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
            <script src="assets/js/isotope.min.js"></script>
            <script src="assets/js/owl-carousel.js"></script>
            <script src="assets/js/counter.js"></script>
            <script src="assets/js/custom.js"></script>
        <?php } else { ?>
            <?php include 'outro.php'; ?>
        <?php } ?>

</body>

</html>