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
              <?php echo isset($_SESSION['id_drmed']) ? 'Selamat Datang <b>' . $kelamin . $_SESSION['nm_drmed'] . '</b>' : 'Welcome to'; ?>
            </h6>
            <h2>DR MEDIA HOMEPAGE!</h2>
            <?php
            if (isset($_SESSION['id_guru'])) { ?>
              <a href="../monitoring/" class="btn btn-warning"><b>Pantau Komputer !</b></a>
            <?php }
            ?>
            <hr>
            <p>Page khusus managemen internal media dan masih banyak lagi.</p>
            <div class="search-input">
              <form id="search" action="#" onsubmit="return false;">
                <input type="password" placeholder="Absen Barcode Disini" id="searchText" name="searchKeyword"
                  onpaste="return false" ondrop="return false" oncopy="return false" oncut="return false" />
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
          </div>
        </div>
        <div class="col-lg-4 offset-lg-2">
          <div class="right-image">
            <?php if (!isset($_SESSION['id_drmed'])) { ?>

              <img src="assets/images/banner-image.jpg" alt="">

            <?php } else { ?>
              <img src="../images/profil_guru/<?= $_SESSION['profil_drmed'] ?>" alt="">

            <?php } ?>
            <span class="price">$100</span>
            <span class="offer">-40%</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="features">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <a href="barangkita.php">
            <div class="item">
              <div class="image">
                <img src="assets/images/featured-01.png" alt="" style="max-width: 44px;">
              </div>
              <h4>Checking Storage</h4>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-md-6">
          <a href="crew.php">
            <div class="item">
              <div class="image">
                <img src="assets/images/featured-02.png" alt="" style="max-width: 44px;">
              </div>
              <h4>DR MEDIA CREW</h4>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-md-6">
          <a href="peminjaman.php">
            <div class="item">
              <div class="image">
                <img src="assets/images/featured-03.png" alt="" style="max-width: 44px;">
              </div>
              <h4>tool usage permit</h4>
            </div>
          </a>
        </div>
        <div class="col-lg-3 col-md-6">
          <a href="#">
            <div class="item">
              <div class="image">
                <img src="assets/images/featured-04.png" alt="" style="max-width: 44px;">
              </div>
              <h4>DRMEDIA NEWS</h4>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>



  <div class="section most-played">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="section-heading">
            <h6>DAFTAR PEMINJAMAN ON-GOING</h6>
            <h2>SEDANG PROSES</h2>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="main-button">
            <a href="peminjaman.php">Lihat Daftar Peminjaman</a>
          </div>
        </div>
        <?php
        $a = mysqli_query($conn, "SELECT * FROM dr_mediapeminjaman WHERE sts_pinjam != '6'");
        while ($pinjam = mysqli_fetch_array($a)) {
          $a2 = mysqli_query($conn, "SELECT * FROM dr_wali WHERE id_wali = '$pinjam[id_wali]'");
          $wali = mysqli_fetch_array($a2);

          ?>




          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="item">
              <div class="thumb">
                <a href="peminjamandetil.php?id=<?= $pinjam['id_pinjam'] ?>"><img
                    src="../images/foto_siswa/<?= $wali['foto_siswa'] ?>" alt=""></a>
              </div>
              <div class="down-content">
                <tr>
                  <td>
                    <span class="category">Keperluan</span>
                  </td>
                  <td>:</td>
                  <td>
                    <span><?= $pinjam['nm_pinjam'] ?></span>
                  </td>
                </tr>
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
                }
                ?>
                <span class="category">Penanggung Jawab</span>
                <h4><?= $wali['nm_siswa'] ?></h4>
                <a href="peminjamandetil.php?id=<?= $pinjam['id_pinjam'] ?>" class="badge"
                  style="background-color:<?= $styl ?>"><?= $status ?></a>
              </div>
            </div>
          </div>

        <?php } ?>

      </div>
    </div>
  </div>




  <?php include 'outro.php'; ?>

</body>

</html>