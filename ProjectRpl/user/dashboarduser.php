<?php
session_start(); 
require 'koneksi.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../mycss/dashboard.css">
</head>
<body>
    <div class="container-fluid">
        <div class="sidebar">
            <div class="logo">
                <img src="../Picture/logoPolnes.png" alt="Logo">
            </div>
            <div class="menu">
                <button class="dashboard-btn w-100 mb-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-grid-fill"></i>
                    <span class="ms-2">Dashboard</span>
                </button>
            </div>
            <button class="logout-btn">Logout</button>
        </div>

        <div class="main-content container">
            <header>
                <div class="user-info">
                    <span><?php echo isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : 'User'; ?></span>
                    <img src="../Picture/User.png" alt="User Icon">
                </div>
            </header>

            <div class="content">
                <!-- Barang-Barang yang Tersedia -->
                <div class="item">
                    <img src="../Picture/Converter.png" alt="Converter">
                    <h2>CONVERTER</h2>
                    <div class="quantity-control">
                        <button class="minus" onclick="decreaseQuantity('converter')">-</button>
                        <span id="converter">0</span>
                        <button class="plus" onclick="increaseQuantity('converter')">+</button>
                    </div>
                </div>

                <div class="item">
                    <img src="../Picture/hdmi.jpg" alt="HDMI">
                    <h2>HDMI</h2>
                    <div class="quantity-control">
                        <button class="minus" onclick="decreaseQuantity('hdmi')">-</button>
                        <span id="hdmi">0</span>
                        <button class="plus" onclick="increaseQuantity('hdmi')">+</button>
                    </div>
                </div>

                <div class="item">
                    <img src="../Picture/terminal.jpg" alt="Terminal">
                    <h2>TERMINAL</h2>
                    <div class="quantity-control">
                        <button class="minus" onclick="decreaseQuantity('terminal')">-</button>
                        <span id="terminal">0</span>
                        <button class="plus" onclick="increaseQuantity('terminal')">+</button>
                    </div>
                </div>

                <div class="item">
                    <img src="../Picture/vga.jpg" alt="VGA">
                    <h2>KABEL VGA</h2>
                    <div class="quantity-control">
                        <button class="minus" onclick="decreaseQuantity('vga')">-</button>
                        <span id="vga">0</span>
                        <button class="plus" onclick="increaseQuantity('vga')">+</button>
                    </div>
                </div>

                <div class="item">
                    <img src="../Picture/proyektor.jpg" alt="Proyektor">
                    <h2>PROYEKTOR</h2>
                    <div class="quantity-control">
                        <button class="minus" onclick="decreaseQuantity('proyektor')">-</button>
                        <span id="proyektor">0</span>
                        <button class="plus" onclick="increaseQuantity('proyektor')">+</button>
                    </div>
                </div>

                <div class="item">
                    <img src="../Picture/ATK.png" alt="Spidol">
                    <h2>ALAT TULIS KANTOR</h2>
                    <div class="quantity-control">
                        <button class="minus" onclick="decreaseQuantity('alat tulis kantor')">-</button>
                        <span id="alat tulis kantor">0</span>
                        <button class="plus" onclick="increaseQuantity('alat tulis kantor')">+</button>
                    </div>
                </div>
            </div>

            <!-- Tombol Pinjam -->
            <button class="pinjam-btn btn btn-primary">Pinjam</button>
        
            <!-- Modal Barang yang Dipilih -->
            <div class="modal fade" id="pinjamModal" tabindex="-1" aria-labelledby="pinjamModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pinjamModalLabel">Barang yang Dipinjam</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul id="itemList">
                                <!-- Daftar barang yang dipilih akan muncul di sini -->
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="openFormModal()">Pinjam Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Formulir -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Informasi Lanjut</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPeminjaman" action="proses_pengajuan.php" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" autocomplete="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="noHP" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="noHP" name="noHP" autocomplete="tel" required>
                    </div>
                    <div class="mb-3">
                        <label for="mataKuliah" class="form-label">Mata Kuliah</label>
                        <input type="text" class="form-control" id="mataKuliah" name="mataKuliah" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="jamMatkul" class="form-label">Jam Matkul</label>
                        <input type="text" class="form-control" id="jamMatkul" name="jamMatkul" autocomplete="off" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="simpanBtn">Simpan</button>
            </div>
        </div>
    </d iv>
</div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../myjss/dashboard.js"></script>
        </div>
    </div>
</body>
</html>