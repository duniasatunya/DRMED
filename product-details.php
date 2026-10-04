<?php include 'config/koneksi.php'; ?>
<?php include 'intro.php'; ?>

<body>

  <?php include 'header.php';


  $l1 = mysqli_query($conn, "SELECT * FROM dr_mediaalat a JOIN dr_mediakategorialat k ON  a.id_kategori = k.id_kategorialat WHERE a.id_alat = '$_GET[id_alat]'");
  $alat = mysqli_fetch_array($l1);

  $lqty = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]' ");
  $qty = mysqli_num_rows($lqty);

  $lbaik = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]'and kondisi = '1' ");
  $baik = mysqli_num_rows($lbaik);

  $lkurangbaik = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]'and kondisi = '2' ");
  $kurangbaik = mysqli_num_rows($lkurangbaik);

  $lrusak = mysqli_query($conn, "SELECT * FROM dr_mediaalat WHERE nm_alat = '$alat[nm_alat]'and kondisi = '3' ");
  $rusak = mysqli_num_rows($lrusak);


  if ($alat['kondisi'] == '1') {
    $kondisi = 'Baik';
    $st = 'background-color:#b3ffb3;color:green;';
  } elseif ($alat['kondisi'] == '2') {
    $kondisi = 'Kurang Baik';
    $st = 'background-color:#ffffb3;color:black;';
  } elseif ($alat['kondisi'] == '3') {
    $kondisi = 'Rusak';
    $st = 'background-color:#ff9999;color:red;';
  } ?>

  <!-- ***** Header Area End ***** -->

  <!-- ***** Header Area End ***** -->

  <div class="page-heading header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h3><?= $alat['nm_alat'] ?></h3>
          <span class="breadcrumb"><a href="#">Home</a> > <a href="#">Storage</a> > <?= $alat['nm_alat'] ?></span>
        </div>
      </div>
    </div>
  </div>

  <div class="single-product section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="left-image">
            <img src="../images/foto_alat/<?= $alat['foto_alat'] ?>" alt="">
          </div>
        </div>
        <div class="col-lg-6 align-self-center">
          <?php if (isset($_GET['update'])) {
            $nm_alat = $_POST['nm_alat'];
            $milik = $_POST['milik'];
            $id_kategori = $_POST['nm_kategori'];
            $kondisi = $_POST['kondisi'];
            $ket = $_POST['ket'];
            $id_alat = $_POST['id_alat'];


            $update = mysqli_query($conn, "UPDATE dr_mediaalat SET nm_alat = '$nm_alat',milik = '$milik',id_kategori = '$id_kategori',kondisi = '$kondisi',ket = '$ket' WHERE id_alat = '$id_alat'");

            if ($update) {
              echo '<script>alert("BERHASIL UPDATE");window.location.href="product-details.php?id_alat=' . $id_alat . '";</script>';
            } else {
              echo '<script>alert("gagal);window.location.href="product-details.php?id_alat=' . $id_alat . '";</script>';

            }
          } ?>


          <?php if (isset($_GET['duplicat'])) {



            $nm_alat = $_GET['nm_alat'];
            $milik = $_GET['milik'];
            $id_kategori = $_GET['id_kategori'];
            $kondisi = $_GET['kondisi'];
            $ket = $_GET['ket'];
            $id_alat2 = $_GET['id_alat'];
            $foto_alat = $_GET['foto_alat'];

            $duplicate = mysqli_query($conn, "INSERT INTO dr_mediaalat (id_alat,nm_alat,id_kategori,kondisi,ket,milik,foto_alat) VALUES ('','$nm_alat','$id_kategori','$kondisi','$ket','$milik','$foto_alat')");



            if ($duplicate) {

              $new_id = mysqli_insert_id($conn);

              $l15 = mysqli_query($conn, "SELECT * FROM dr_mediaalat a JOIN dr_mediakategorialat k ON  a.id_kategori = k.id_kategorialat WHERE a.id_alat = '$new_id'");
              $alat5 = mysqli_fetch_array($l15);

              echo '<script>alert("BERHASIL DUPLICATE");window.location.href="product-details.php?id_alat=' . $alat['id_alat'] . '";</script>';
            } else {
              echo '<script>alert("gagal);window.location.href="product-details.php?id_alat=' . $id_alat . '";</script>';

            }
          } ?>


          <?php if (isset($_GET['hapus'])) {


            $id_alat = $_GET['id_alat'];

            $hapus = mysqli_query($conn, "DELETE FROM dr_mediaalat WHERE id_alat = '$id_alat' ");



            if ($hapus) {


              echo '<script>alert("BERHASIL HAPUS");window.location.href="barangkita.php";</script>';
            } else {
              echo '<script>alert("gagal);window.location.href="product-details.php?id_alat=' . $id_alat . '";</script>';

            }
          } ?>
          <?php if (isset($_GET['edit'])) { ?>

            <form action="?update&id_alat=<?= $_GET['id_alat'] ?>" method="post" role="form">
              <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                <div style="flex: 1; margin-right: 10px;">
                  <center>
                    <label for="nm_alat">
                      <b>NAMA ALAT</b>
                    </label>
                  </center>
                  <input type="text" name="nm_alat" value="<?= $alat['nm_alat'] ?>" class="form-control"
                    style="width: 100%;">
                </div>
                <input type="hidden" name="id_alat" value="<?= $alat['id_alat'] ?>" class="form-control">
                <div style="flex: 1; margin-left: 10px;">
                  <center>
                    <label for="milik">
                      <b>KEPEMILIKAN</b>
                    </label>
                  </center>
                  <input type="text" name="milik" value="<?= $alat['milik'] ?>" class="form-control" style="width: 100%;">

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

                  <select name="nm_kategori" class="form-control" style="width: 100%;color:black;text-align:center">
                    <option value="<?= $alat['id_kategori'] ?>"><?= $alat['nm_kategori'] ?></option>

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

                  <select name="kondisi" class="form-control"
                    style="width: 100%;color:white;text-align:center;<?= $st ?>">
                    <option value="<?= $alat['kondisi'] ?>"><?= $kondisi ?></option>
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
                    <label>
                      <b>QTY</b> = <?= $qty ?>
                    </label>
                  </center>
                  <br>
                  <center>
                    <label for="ket">
                      <b>KETERANGAN</b>
                    </label>
                  </center>
                  <textarea name="ket" class="form-control"><?= $alat['ket'] ?></textarea>

                  <center>
                    <label>
                      &nbsp;
                    </label>
                  </center>
                  <input type="submit" value="UPDATE" class="btn btn-success" style="width: 100%;background-color:green">
                </div>
              </div>

            </form>


          <?php } else { ?>
            <h4><?= $alat['nm_alat'] ?></h4>
            <span class="price ">QTY <b><?= $qty ?></b></span><br>

            <span class="badge text-bg-danger">Rusak <?= $rusak ?></span><br>
            <span class="badge text-bg-warning">Kurang Baik <?= $kurangbaik ?></span>
            <span class="badge text-bg-success">Baik <?= $baik ?></span>


            <br>
            <?php if (isset($_SESSION['id_drmed'])) { ?>





              <br><br><br><a href="?id_alat=<?= $_GET['id_alat'] ?>&edit" class="btn btn-primary">Edit</a> &nbsp;
              <a href="?id=<?= $_GET['id_alat'] ?>&duplicat&foto_alat=<?= $alat['foto_alat'] ?>&&nm_alat=<?= $alat['nm_alat'] ?>&milik=<?= $alat['milik'] ?>&id_kategori=<?= $alat['id_kategori'] ?>&kondisi=<?= $alat['kondisi'] ?>&ket=<?= $alat['ket'] ?>&id_alat=<?= $alat['id_alat'] ?>"
                class="btn btn-secondary"
                onclick="return confirm('Apakah Anda yakin ingin duplicate data ini?')">Duplicate</a> &nbsp;
              <br><br>

              <a href="?id_alat=<?= $_GET['id_alat'] ?>&hapus"
                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                <div class="trash btn btn-danger" style=" cursor: pointer; padding: 10px; display: inline-block;">
                  <i class="fa fa-trash"></i> Hapus
                </div>
              </a>
              <?php
            } ?>
            <p>Milik <b><?= $alat['milik'] ?></b><br><br><span style="font-size:30px;">KONDISI
                <b><?= $kondisi ?></b></span>
            </p>

            <span>" <?= $alat['ket'] ?> "</span>


            <ul>
              <li><span>Kategori Alat :</span>
                <?= $alat['nm_kategori'] ?>
              </li>

            </ul>
          <?php } ?>


        </div>
        <div class="col-lg-12">
          <div class="sep"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="more-info">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">

          <div class="nav-wrapper ">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                  type="button" role="tab" aria-controls="description" aria-selected="true">Daftar
                  <?= $alat['nm_alat'] ?></button>
              </li>

            </ul>
          </div>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">


              <ul style="list-style-type: none; padding: 0;">
                <style>
                  .ss img {
                    height: 100px;
                    width: auto;
                  }

                  .item {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: flex-start;
                    /* Mojok ke kiri */
                    margin-bottom: 15px;
                    /* Jarak antar item */
                    border: 1px solid #ddd;
                    /* Border untuk setiap item */
                    padding: 10px;
                    /* Padding di dalam item */
                    background-color: #fff;
                    /* Warna latar belakang item */
                  }

                  .item div {
                    flex: 1;
                    /* Membagi ruang secara merata */
                    margin-right: 10px;
                    /* Jarak antar kolom */
                  }

                  .item div:last-child {
                    margin-right: 0;
                    /* Menghapus margin kanan untuk kolom terakhir */
                  }
                </style>
                <?php $l12s = mysqli_query($conn, "SELECT * FROM  dr_mediaalat WHERE nm_alat = '$alat[nm_alat]'  ");
                while ($alatlagi = mysqli_fetch_array($l12s)) {
                  ?>
                  <a href="?id_alat=<?= $alatlagi['id_alat'] ?>">
                    <li class="item">

                      <div>
                        <div class="ss">
                          <img src="../images/foto_alat/<?= $alatlagi['foto_alat'] ?>" alt="Foto Alat">
                        </div>
                      </div>
                      <div style="text-align: left;">
                        <div class="ss">
                          <?php if ($alatlagi['kondisi'] == '1') {
                            $kondisi2 = 'Baik';

                          } elseif ($alatlagi['kondisi'] == '2') {
                            $kondisi2 = 'Kurang Baik';

                          } elseif ($alatlagi['kondisi'] == '3') {
                            $kondisi2 = 'Rusak';

                          } ?>
                          <h1>ID ALAT = <?= $alatlagi['id_alat'] ?></h1>
                          <span>KONDISI <b><?= $kondisi2 ?></b></span><br>
                          <span>MILIK <b><?= $alatlagi['milik'] ?></b></span>
                        </div>
                      </div>



              </div>


              </li>
              </a>
            <?php } ?>
            </ul>
          </div>

        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>



  <?php include 'outro.php'; ?>

</body>

</html>