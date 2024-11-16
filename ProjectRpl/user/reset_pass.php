<?php
session_start();
require 'koneksi.php';

// Cek apakah form reset password telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Query untuk memeriksa apakah email ada
    $query = "SELECT * FROM tb_regist WHERE email = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Buat token reset password
        $token = bin2hex(random_bytes(32));
        $reset_time = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Simpan token dan waktu reset ke database
        $update_query = "UPDATE tb_regist SET reset_token = ?, reset_time = ? WHERE email = ?";
        $stmt = $koneksi->prepare($update_query);
        $stmt->bind_param("sss", $token, $reset_time, $email);
        if ($stmt->execute()) {
            // Kirim email dengan link reset password
            $reset_link = "http://example.com/reset_password.php?token=$token";
            // Tambahkan kode untuk mengirim email di sini
            echo "Instruksi reset password telah dikirim ke email Anda.";
        } else {
            echo "Terjadi kesalahan saat memperbarui token reset password.";
        }
    } else {
        echo "Email tidak terdaftar.";
    }

    $stmt->close();
}

if (isset($koneksi)) {
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Layanan Peminjaman Barang</title>
    <link rel="stylesheet" href="../mycss/style.css">
</head>
<body>
    <div class="container">
        <div class="form-box forgot">
            <h2>Reset Password</h2>
            <form action="reset_pass.php" method="post">
                <div class="input-box">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <button type="submit" class="btn">Reset Password</button>
                <p class="switch-text">Remember your password? <a href="login.php" class="switch-login">Log in</a></p>
            </form>
        </div>
    </div>
</body>
</html>