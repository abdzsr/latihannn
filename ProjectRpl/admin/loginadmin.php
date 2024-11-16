<?php
session_start(); 
require 'koneksi.php';

// Periksa apakah form login telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'] ?? null; 
    $password = $_POST['password'] ?? null; 

    // Query untuk mencari username
    $sql = "SELECT * FROM tb_admn WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data pengguna
        $user = $result->fetch_assoc();

        // Verifikasi password
        if ($user['password'] === $password) { 
            $_SESSION['username'] = $username; 
            header("Location: DashboardAdmin.php"); 
            exit();
        } else {
            echo "Username atau password salah!";
        }
    } else {
        echo "Username atau password salah!";
    }

    $stmt->close();
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MY ADMIN</title>
    <link rel="stylesheet" href="../mycss/admin_css.css">
</head>
<body>
<img src="../Picture/LogoPolnes.png" alt="Gambar 1" class="gambar1">
<img src="../Picture/LogoTI.png" alt="Gambar 2" class="gambar2">
    <div class="title-container">
        <h1>MY ADMIN</h1>
    </div>
    <div class="container">
        
        <!-- Form Login -->
        <div class="form-box login">
            <h2>Login</h2>
            <form action="loginadmin.php" method="post">
                <div class="input-box">
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>
        </div>
        <script src="../myjss/admin_script.js"></script>
    </body>
</html>