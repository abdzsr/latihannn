<?php
session_start();
require 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../mycss/TampilanAdmin_css.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex p-0">
<!-- Sidebar -->
<div class="sidebar bg-dark text-white p-3">
    <h2>MY ADMIN</h2>
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
    </ul>
    <hr>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a id="report-link" class="nav-link text-white" href="Report.php">
                <i class="bi bi-file-earmark-text"></i> Item Report
            </a>
        </li>
    </ul>
    <button class="btn btn-secondary mt-4 w-100" onclick="location.href='logoutadmin.php';">
    <i class="bi bi-box-arrow-right"></i> Logout
</div>

<!-- Main Content -->
<div class="main-content flex-grow-1 p-4 bg-light">
    <!-- User Info  -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="user-info d-flex align-items-center">
            <div class="user-avatar bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
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
    <!-- Pengajuan Section -->
    <div id="pengajuan-section" class="section active">
        <h3>Pengajuan Barang</h3>
        <table class="table table-bordered table-striped text-center">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Pemohon</th>
            <th>Email Pemohon</th>
            <th>Pengajuan Barang</th>
            <th>Nomor</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $koneksi->query("SELECT * FROM tb_pengajuan");
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $row['nama'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';

            // Menampilkan barang tanpa kurung
            $barang = json_decode($row['barang'], true);
            $barang_string = '';
            if (is_array($barang)) {
                $barang_string = '';
                foreach ($barang as $item) {
                    $barang_string .= $item['nama_barang'] . ' ' . $item['jumlah'] . ', ';
                }
                $barang_string = rtrim($barang_string, ', ');
            } else {
                $barang_string = 'Data barang tidak tersedia';
            }
            $barang_string = rtrim($barang_string, ', ');

            // Pada bagian penampilan data di halaman sebelumnya
            echo '<td><a href="#">' . $barang_string . '</a></td>'; 
            echo '<td>' . $row['no_hp'] . '</td>';
            echo '<td>';
            if ($row['status'] == 'Diajukan') {
                echo '<button class="btn btn-success btn-sm accept-btn" data-id="' . $row['id'] . '">TERIMA</button>';
                echo '<button class="btn btn-danger btn-sm reject-btn" data-id="' . $row['id'] . '">TOLAK</button>';
            } else {
                echo '<span class="badge ' . ($row['status'] == 'Disetujui' ? 'bg-success' : 'bg-danger') . '">' . strtoupper($row['status']) . '</span>';
            }
            echo '</td>';
            echo '<td>';
            if ($row['status'] == 'Disetujui') {
                echo '<a href="BuktiPeminjaman.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Cetak Bukti</a>';
            }
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../myjss/TampilanAdmin_js.js"></script>
</div>
</body>
</html>