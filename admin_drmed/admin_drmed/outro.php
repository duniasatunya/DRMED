<footer>
    <div class="container">
        <div class="col-lg-12">


            <p>Copyright 2024 . Jakarta. Made by Muhammad Ismail Habibi | Post
                <a rel="nofollow" href='https://pp-daarulrahman.sch.id' title='DRMED2023' target='_blank'
                    id="kioskLink">Daarul Rahman Media</a>
            </p>

            <script>
                // Fungsi untuk memeriksa apakah dalam mode kiosk
                function isKioskMode() {
                    // Logika untuk menentukan apakah dalam mode kiosk
                    // Misalnya, Anda bisa menggunakan variabel global atau kondisi tertentu
                    // Di sini kita asumsikan ada variabel `kioskMode` yang diatur di tempat lain
                    return true; // Ganti dengan logika yang sesuai
                }

                // Menangani klik pada link
                document.getElementById('kioskLink').addEventListener('click', function (event) {
                    if (!isKioskMode()) {
                        event.preventDefault(); // Mencegah aksi default jika dalam mode kiosk
                        alert('Mode kiosk aktif. Link tidak dapat diakses.'); // Pesan peringatan
                    }
                });
            </script>
        </div>
    </div>
</footer>

<!-- Scripts -->
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>