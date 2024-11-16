<?php
session_start(); 
require 'koneksi.php';
if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../mycss/TampilanAdmin_css.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex p-0">
        <!-- Sidebar -->
<!-- Sidebar -->
<div class="sidebar bg-dark text-white p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>MY ADMIN</h2>
        </div>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a id="dashboard-link" class="nav-link active text-white bg-primary" href="DashboardAdmin.php">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a id="pengajuan-link" class="nav-link text-white" href="Pengajuan.php">
                    <i class="bi bi-bell"></i> Pengajuan
                </a>
            </li>
            <li class="nav-item">
                <a id="peminjaman-link" class="nav-link text-white" href="Peminjaman.php">
                    <i class="bi bi-file-earmark"></i> Dipinjamkan
                </a>
            </li>
            <li class="nav-item">
                <a id="report-link" class="nav-link text-white" href="Report.php">
                    <i class="bi bi-file-earmark-text"></i> Item Report
                </a>
            </li>
        </ul>
        <button class="btn btn-secondary mt-4 w-100" onclick="location.href='logoutadmin.php';">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </div>


        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4 bg-light">
            <!-- User Info  -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="user-info d-flex align-items-center">
                    <div class="user-avatar bg-warning rounded-circle d-flex justify-content-center align-items-center">
                        🍔
                    </div>
                    <div class="user-role ms-3">
                        <span>Administrator</span>
                    </div>
                </div>
                <div class="notification-icon position-relative">
                    <i class="bi bi-bell fs-4"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </div>
            </div>
            <!-- Dashboard -->
            <div id="dashboard-section" class="section active">
                <h3>Selamat Datang</h3>
                <p>Layanan Pengelolaan Peminjaman Barang</p>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../myjss/TampilanAdmin_js.js"></script>
        </div>
    </div>
</body>
</html>