<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- ***** Preloader End ***** -->



<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.php" class="logo">
                        <img src="assets/images/logo1.png" alt="" style="width: 158px;">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="index.php" class="active">Home</a></li>
                        <li><a href="isi_studio.php">Studio Crew</a></li>
                        <?php if (isset($_SESSION['status']) && $_SESSION['status'] == 'guru') { ?>
                            <li><a href="../admin_guru/"><b>Kembali ke Santripage</b></a></li>
                        <?php } else { ?>
                            <li><a href="../"><b>Kembali ke Santripage</b></a></li>
                        <?php } ?>

                        <li><a href="">History</a></li>
                        <li><a href="">Chat Koor</a></li>
                        <?php if (isset($_SESSION['id_drmed'])) { ?>
                            <li><a style="background-color:darkred" href="logout.php">Sign Out</a></li>
                        <?php } else { ?>
                            <li><a href="login_drmed.php">Sign In</a></li>
                        <?php } ?>

                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>