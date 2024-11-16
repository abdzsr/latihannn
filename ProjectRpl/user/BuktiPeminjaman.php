<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['peminjaman'])) {
    header("Location: login.php"); 
    exit;
}

$peminjaman = $_SESSION['peminjaman'];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Ambil data peminjaman dari database
$stmt = $koneksi->prepare("SELECT * FROM tb_pengajuan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$peminjaman = $result->fetch_assoc();

if (!$peminjaman) {
    echo "Data peminjaman tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../mycss/BuktiPeminjaman.css">
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow" style="max-width: 350px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <img src="../Picture/LogoPolnes.png" alt="LogoPolnes" style="width: 50px; height: auto;">
                <img src="../Picture/LogoTi.png" alt="LogoTI" style="width: 50px; height: auto;">
            </div>
            <h4 class="text-center mb-3">Bukti Peminjaman</h4>
            <div class="text-left">
                <p><strong>Nama:</strong> <?php echo htmlspecialchars($peminjaman['nama']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($peminjaman['email']); ?></p>
                <p><strong>Matkul:</strong> <?php echo isset($peminjaman['mata_kuliah']) ? htmlspecialchars($peminjaman['mata_kuliah']) : '-'; ?></p>
                <p><strong>No Hp:</strong> <?php echo htmlspecialchars($peminjaman['no_hp']); ?></p>
                <p><strong>Kelas:</strong> <?php echo isset($peminjaman['kelas']) ? htmlspecialchars($peminjaman['kelas']) : '-'; ?></p>
                <p><strong>Jam Matkul:</strong> <?php echo isset($peminjaman['jam_matkul']) ? htmlspecialchars($peminjaman['jam_matkul']) : '-'; ?></p>
                <p><strong>Kode Peminjaman:</strong> <?php echo isset($peminjaman['kode_peminjaman']) ? htmlspecialchars($peminjaman['kode_peminjaman']) : '-'; ?></p>
            </div>
            <div class="text-center mt-3">
                <p><em>Tunjukkan Saat Ingin Mengambil Barang</em></p>
            </div>
            <!-- Tombol Cetak -->
            <div class="text-center">
                <form method="post">
                    <button type="submit" name="cetak" class="btn btn-primary">Cetak Bukti</button>
                    <button type="submit" name="kembali" class="btn btn-secondary">Kembali ke Dashboard</button>
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Fungsi Cetak Bukti
    if (isset($_POST['cetak'])) {
        echo "<script>window.print();</script>";
    }

    // Fungsi Kembali ke Dashboard
    if (isset($_POST['kembali'])) {
        header("Location: dashboard.php");
        exit;
    }

    // Fungsi Logout
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit;
    }
    ?>
</body>
</html>
