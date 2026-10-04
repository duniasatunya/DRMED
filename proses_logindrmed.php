<?php
include "config/koneksi.php";

session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $username = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    $hashed_password = md5($password); // Currently using MD5 for transition. Will handle below.

    if ($username == 'try') {
        // Admin login (using prepared statement to prevent SQL Injection)
        $stmt = $conn->prepare("SELECT * FROM dr_admingoogle WHERE username = ? AND password = ? AND akses = '1'");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            while ($hasil = $result->fetch_assoc()) {
                $_SESSION['id_admin'] = $hasil['id_admin'];
                $_SESSION['username'] = $hasil['username'];
                ?>
                <script>
                    alert("Selamat Datang admin Dari <?= $hasil['username']; ?> Kamu Telah Login Ke Halaman User !!!");
                    window.location.href = "index.php";
                </script>
                <?php
            }
        } else {
            echo '<script>alert("Masukan email dan Password dengan Benar !!!");
            window.location.href="login_admin.php"</script>';
        }
    } else {
        // Teacher login (using prepared statement to prevent SQL Injection)
        $stmt = $conn->prepare("SELECT * FROM dr_guru WHERE (email_guru = ? OR username = ?) AND akses_drmed = '1'");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            while ($hasil = $result->fetch_assoc()) {
                // If the password is stored using MD5 (length 32) and matches the MD5 hash
                if (strlen($hasil['password']) === 32 && md5($password) == $hasil['password']) {
                    // Password is in MD5, so we update it to Argon2
                    $argon2_hash = password_hash($password, PASSWORD_ARGON2I);

                    // Update the password in the database to Argon2
                    $update_stmt = $conn->prepare("UPDATE dr_guru SET password = ? WHERE id_guru = ?");
                    $update_stmt->bind_param("si", $argon2_hash, $hasil['id_guru']);
                    $update_stmt->execute();

                    // Set session data
                    $_SESSION['id_drmed'] = $hasil['id_guru'];
                    $_SESSION['email_drmed'] = $hasil['email_guru'];
                    $_SESSION['nm_drmed'] = $hasil['nm_guru'];
                    $_SESSION['kelas_drmed'] = $hasil['kelas_guru'];
                    $_SESSION['id_kelas'] = $hasil['id_kelas'];  // Fixed session key here
                    $_SESSION['profil_drmed'] = $hasil['profil_guru'];
                    $_SESSION['kelamin'] = $hasil['kelamin'];
                    $_SESSION['status'] = 'guru';

                    ?>
                    <script>
                        alert("Selamat Datang, Anda berhasil login di DRMEDIA PAGE !!!");
                        window.location.href = "index.php";
                    </script>
                    <?php
                } elseif (password_verify($password, $hasil['password'])) {
                    // If the password is Argon2, verify it using password_verify
                    $_SESSION['id_drmed'] = $hasil['id_guru'];
                    $_SESSION['email_drmed'] = $hasil['email_guru'];
                    $_SESSION['nm_drmed'] = $hasil['nm_guru'];
                    $_SESSION['kelas_drmed'] = $hasil['kelas_guru'];
                    $_SESSION['id_kelas'] = $hasil['id_kelas'];  // Fixed session key here
                    $_SESSION['profil_drmed'] = $hasil['profil_guru'];
                    $_SESSION['kelamin'] = $hasil['kelamin'];
                    $_SESSION['status'] = 'guru';

                    ?>
                    <script>
                        alert("Selamat Datang, Anda berhasil login di DRMEDIA PAGE !!!");
                        window.location.href = "index.php";
                    </script>
                    <?php
                } else {
                    // If password doesn't match
                    ?>
                    <script>
                        alert("Password Salah");
                        window.location.href = "index.php";
                    </script>
                    <?php
                }
            }
        } else {
            echo '<script>alert("Masukan email dan Password dengan Benar !!!");
            window.location.href="login_drmed.php"</script>';
        }
    }
} else {
    echo '<script>alert("Email dan Password tidak boleh kosong !!!");
    window.location.href="login_drmed.php"</script>';
}
?>