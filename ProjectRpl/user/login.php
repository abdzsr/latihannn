<?php
session_start();
require 'koneksi.php'; 

// Cek apakah form login telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Query untuk memeriksa apakah email ada
    $query = "SELECT password, nama_lengkap FROM tb_regist WHERE email = ?"; 
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika email ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Password benar, buat session
            $_SESSION['email'] = $email;
            $_SESSION['nama_lengkap'] = $row['nama_lengkap']; // Simpan nama pengguna
            header("Location: dashboarduser.php"); // Arahkan ke halaman setelah login
            exit;
        } else {
            $error_message = "Password salah.";
        }
    } else {
        $error_message = "Email tidak terdaftar.";
    }
    $stmt->close();
}

// Tutup koneksi
if (isset($koneksi)) {
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Layanan Peminjaman Barang</title>
    <link rel="stylesheet" href="../mycss/style.css">
</head>
<body>
    <img src="../Picture/LogoPolnes.png" alt="Gambar 1" class="gambar1">
    <img src="../Picture/LogoTI.png" alt="Gambar 2" class="gambar2">
    <div class="title-container">
        <h1>Layanan Peminjaman Barang</h1>
    </div>
    <div class="container">
        <!-- Form Login -->
        <div class="form-box login">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <div class="input-box">
                    <input type="text" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="options">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <p class="switch-text">Don't have an account? <a href="registrasi.php" class="switch-register">Sign up</a></p>
            </form>
        </div>

        <!-- Form Lupa Password -->
        <div class="form-box forgot hidden">
            <h2>Forgot Password</h2>
            <form action="reset_pass.php" method="post">
                <div class="input-box">
                    <input type="email" required>
                    <label>Email</label>
                </div>
                <button type="submit" class="btn">Reset Password</button>
                <p class="switch-text">Remember your password? <a href="login.php" class="switch-login">Log in</a></p>
            </form>
        </div>
    </div>

    <script src="../myjss/script.js"></script>
</body>
</html>