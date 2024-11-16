    <?php
    session_start();

    // Konfigurasi database
    $db_username = 'root';
    $db_password = '';
    $db_name = 'db_peminjaman';


    $koneksi= new mysqli('localhost', 'root', '', 'db_peminjaman');

    // Cek koneksi
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Cek apakah form telah di-submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form
        $nama_lengkap = $_POST['nama_lengkap'];
        $nim = $_POST['nim'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk memeriksa apakah email sudah ada
        $query = "SELECT * FROM tb_regist WHERE email = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Jika email sudah ada, tampilkan pesan error
        if ($result->num_rows > 0) {
            echo "Email sudah terdaftar, silakan gunakan email lain.";
        } else {
            // Jika email belum ada, masukkan data baru
            $query = "INSERT INTO tb_regist (nama_lengkap, nim, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("ssss", $nama_lengkap, $nim, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: ../user/login.php");
                exit;
            } else {
                echo "Terjadi kesalahan saat registrasi: " . $stmt->error;
            }
        }
        $stmt->close();
    }
    $koneksi->close();
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Layanan Peminjaman Barang</title>
    <link rel="stylesheet" href="../mycss/style.css">
</head>
<body>
    <img src="../Picture/LogoPolnes.png" alt="Gambar 1" class="gambar1">
    <img src="../Picture/LogoTI.png" alt="Gambar 2" class="gambar2">
    <div class="title-container">
        <h1>Layanan Peminjaman Barang</h1>
    </div>
    <div class="container">
         <div class="form-box register">
            <h2>Registrasi</h2>
            <form action="registrasi.php" method="post"> 
                <div class="input-box">
                    <input type="text"name="nama_lengkap" required>
                    <label>Nama Lengkap</label>
                </div>
                <div class="input-box">
                    <input type="text" name="nim" required>
                    <label>NIM</label>
                </div>
                <div class="input-box">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit" class="btn">Register</button>
                <p class="switch-text">Already have an account? <a href="login.php" class="switch-login">Log in</a></p>
            </form>
        </div>
    </div>
    <script src="../myjss/script.js"></script>
</body>
</html>
