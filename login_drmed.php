<?php include 'config/koneksi.php'; ?>
<?php include 'intro.php'; ?>

<body>



    <!-- ***** Header Area End ***** -->

    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>DRMEDIA LOGIN</h3>

                    <div class="form">
                        <form action="proses_logindrmed.php" method="post">
                            <div class="inputBox">
                                <input type="text" name="email" class="form-control"
                                    placeholder="Masukkan Username atau Email" required>

                            </div>
                            <br>
                            <div class="inputBox">
                                <input type="password" name="password" placeholder="Masukkan Password"
                                    class="form-control" required>

                            </div>
                            <br>
                            <div class="inputBox">
                                <input type="submit" class="form-control btn btn-success" value="Login">
                            </div><br>
                            <div class="inputBox">
                                <a href="index.php" class="btn btn-danger">Kembali</a>
                            </div>
                            <div class="inputBox">
                                <p style="color:white;">Jika anda adalah santri yang menjadi crew, maka login DRMED PAGE
                                    harus via Absen QR Code</p>
                            </div>
                            <br>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>





    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/counter.js"></script>
    <script src="assets/js/custom.js"></script>


</body>

</html>