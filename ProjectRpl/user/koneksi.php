<?php
$servername = "localhost";
$username = "root";
$password = "";
$databases = "db_peminjaman";

// Buat koneksi
$koneksi = new mysqli($servername, $username, $password, $databases);

// Periksa koneksi
if ($koneksi->connect_error) {
    echo "Gagal Koneksi: " . $koneksi->connect_error . "<br>";
    die(); // Hentikan eksekusi jika koneksi gagal
} 
?>