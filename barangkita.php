<?php include 'config/koneksi.php'; ?>
<?php include 'intro.php'; ?>

<body>

    <?php include 'header.php'; ?>

    <!-- ***** Header Area End ***** -->

    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>OUR STORAGE</h3>
                    <span class="breadcrumb"><a href="index.php">Home</a> > Our Storage</span>

                    <?php if (isset($_SESSION['id_drmed'])) { ?>

                        <br><br><a href="buatbarang.php" class="btn btn-warning">Input Barang Baru</a>
                        <?php if (!isset($_GET['tabel'])) { ?>
                            <br><br>
                            <center><a class="btn btn-dark" href="?tabel">Cek Via
                                    Tabel</a></center><br>
                        <?php }
                    } ?>

                </div>
            </div>
        </div>
    </div>

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

                if (isset($_GET['tabel'])) { ?>


                    <center><a class="btn btn-primary" href="barangkita.php" style="margin-top:-100px">Kembali ke
                            Storage</a>
                    </center>
                    <br>

                    <style>
                        .box-body {
                            padding: 20px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            font-family: Arial, sans-serif;
                            table-layout: fixed;
                            /* Ensure table doesn't overflow */
                        }

                        table,
                        th,
                        td {
                            border: 1px solid #ddd;
                        }

                        th,
                        td {
                            padding: 12px;
                            text-align: left;
                            word-wrap: break-word;
                            /* Ensure content wraps within cell */
                        }

                        td img {
                            height: 80px;
                            width: auto;
                        }

                        th {
                            background-color: #f2f2f2;
                            color: #333;
                            font-weight: bold;
                        }

                        tbody tr:nth-child(even) {
                            background-color: #f9f9f9;
                        }

                        tbody tr:hover {
                            background-color: #f1f1f1;
                        }

                        .border-bottom {
                            border-bottom: 2px solid #333;
                        }

                        td.center,
                        th.center {
                            text-align: center;
                        }

                        .status-hadir {
                            color: green;
                            font-weight: bold;
                        }

                        .status-tidak-hadir {
                            color: red;
                        }

                        @media (max-width: 768px) {
                            .box-body {
                                padding: 10px;
                                /* Adjust padding for mobile view */
                            }

                            table {
                                width: 100%;
                                /* Set table width to 100% */
                                display: block;
                                /* Make table block for mobile */
                                overflow-x: auto;
                                /* Enable horizontal scrolling */
                                white-space: nowrap;
                                /* Prevent text wrapping */
                            }



                            .s2 {
                                display: none;
                            }


                            td {
                                padding: 8px;
                                /* Adjust cell padding for mobile view */
                                font-size: 14px;
                                /* Adjust font size for mobile view */
                                display: block;
                                /* Make cells block for mobile */
                                text-align: right;
                                /* Align text to the right */
                                width: 100%;
                                /* Set width to 100% for full width */
                                box-sizing: border-box;
                                /* Include padding in width calculation */
                            }

                            th {
                                text-align: left;
                                /* Align header text to the left */
                                background-color: #f2f2f2;
                                /* Keep header background */
                            }

                            tr {
                                margin-bottom: 10px;
                                /* Add space between rows */
                                display: block;
                                /* Make rows block for mobile */
                                border: 1px solid #ddd;
                                /* Add border to rows */
                                width: 100%;
                                /* Set row width to 100% */
                            }

                            td {
                                text-align: left;
                                /* Align cell text to the left */
                                position: relative;
                                /* Position relative for pseudo-elements */
                                padding-left: 50%;
                                /* Add padding for labels */
                                width: 100%;
                                /* Set cell width to 100% */
                                box-sizing: border-box;
                                /* Include padding in width calculation */
                            }

                            td:before {
                                content: attr(data-label);
                                /* Use data-label for cell labels */
                                position: absolute;
                                /* Position absolute for labels */
                                left: 10px;
                                /* Position labels */
                                width: calc(50% - 20px);
                                /* Width of labels */
                                padding-right: 10px;
                                /* Padding for labels */
                                white-space: nowrap;
                                /* Prevent label wrapping */
                                font-weight: bold;
                                /* Make labels bold */
                            }
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
                                            <center>Foto</center>
                                        </th>
                                        <th class="s">
                                            <center>Nama Alat</center>
                                        </th>

                                        <th class="s">
                                            <center>QTY</center>
                                        </th>
                                        <th class="s">
                                            <center>Baik</center>
                                        </th>
                                        <th class="s">
                                            <center>Kurang Baik</center>
                                        </th>
                                        <th class="s">
                                            <center>Rusak</center>
                                        </th>

                                        <th class="s2" style="text-align:center;">Cek</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $no = 1;
                                    $l1 = mysqli_query($conn, "SELECT * FROM dr_mediaalat GROUP BY nm_alat");
                                    while ($alat = mysqli_fetch_array($l1)) {
                                        $l3 = mysqli_query($conn, "SELECT * FROM dr_mediakategorialat WHERE id_kategorialat = '$alat[id_kategori]'");
                                        $kat3 = mysqli_fetch_array($l3);


                                        $lqty = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]'  ");
                                        $qty = mysqli_num_rows($lqty);

                                        $lbaik = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]'and kondisi = '1'   ");
                                        $baik = mysqli_num_rows($lbaik);

                                        $lkurangbaik = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]'and kondisi = '2'  ");
                                        $kurangbaik = mysqli_num_rows($lkurangbaik);

                                        $lrusak = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]'and kondisi = '3' ");
                                        $rusak = mysqli_num_rows($lrusak);



                                        ?>

                                        <tr>
                                            <td data-label="No.">
                                                <center><?php echo $no++ ?></center>
                                            </td>
                                            <td><img src="../images/foto_alat/<?= $alat['foto_alat'] ?>" alt=""></td>



                                            <td><?php echo $alat['nm_alat'] ?></td>




                                            <td data-label="Jumlah">
                                                <center><?php echo $qty ?></center>
                                            </td>
                                            <td data-label="Baik" style="background-color: #b3ffb3">
                                                <center><b><?php echo $baik ?></b> </center>
                                            </td>
                                            <td data-label="Kurang Baik" style="background-color:#ffffb3">
                                                <center><b><?php echo $kurangbaik ?></b> </center>
                                            </td>
                                            <td data-label="Rusak" style="background-color:#ff9999">
                                                <center><b><?php echo $rusak ?></b> </center>
                                            </td>

                                            <td>
                                                <center><a href="product-details.php?id_alat=<?php echo $alat['id_alat'] ?>"
                                                        class="btn ">Cek</a></center>
                                            </td>


                                            <?php
                                    }
                                    ?>

                                </tbody>

                            </table>


                        <?php } else { ?>


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
                                            <a href="product-details.php?id_alat=<?= $alat['id_alat'] ?>"><i
                                                    class="fa fa-shopping-bag"></i></a>
                                            <span class="category">Milik <b><?= $alat['milik'] ?></b></span>
                                        </div>
                                    </div>
                                </div>
                            <?php }

                } ?>




                    </div><?php if (!isset($_GET['tabel'])) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="pagination">
                                    <li><a href="#"> &lt; </a></li>
                                    <li><a href="#">1</a></li>
                                    <li><a class="is_active" href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#"> &gt; </a></li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
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