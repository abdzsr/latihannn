<?php
session_start();
require 'koneksi.php';
header('Content-Type: application/json');

$response = [];

// Fungsi untuk menyimpan pengajuan baru
function savePengajuan($koneksi, $data) {
    $stmt = $koneksi->prepare("INSERT INTO tb_pengajuan (nama, email, no_hp, barang, status) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        return false; // Gagal menyiapkan pernyataan
    }

    $status = 'Diajukan'; // Status awal saat disimpan
    $stmt->bind_param("sssss", $data->nama, $data->email, $data->no_hp, $data->barang, $status);
    
    if ($stmt->execute()) {
        // Simpan data peminjaman ke session
        $peminjaman = array (
            'id' => $koneksi->insert_id,
            'nama' => $data->nama,
            'email' => $data->email,
            'no_hp' => $data->no_hp,
            'barang' => $data->barang,
            'status' => $status
        );
        $_SESSION['peminjaman'] = $peminjaman;
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk memperbarui status pengajuan
function updateStatusPengajuan($koneksi, $id, $status) {
    $stmt = $koneksi->prepare("UPDATE tb_pengajuan SET status = ? WHERE id = ?");
    
    if ($stmt === false) {
        return false; // Gagal menyiapkan pernyataan
    }

    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        // Perbarui status peminjaman di session
        if (isset($_SESSION['peminjaman']) && $_SESSION['peminjaman']['id'] == $id) {
            $_SESSION['peminjaman']['status'] = $status;
        }
        return true;
    } else {
        return false;
    }
}

// Fungsi untuk menghapus pengajuan
function deletePengajuan($koneksi, $id) {
    $stmt = $koneksi->prepare("DELETE FROM tb_pengajuan WHERE id = ?");
    
    if ($stmt === false) {
        return false; // Gagal menyiapkan pernyataan
    }

    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Hapus data peminjaman dari session jika ada
        if (isset($_SESSION['peminjaman']) && $_SESSION['peminjaman']['id'] == $id) {
            unset($_SESSION['peminjaman']);
        }
        return true;
    } else {
        return false;
    }
}

// Ambil data JSON dari request
$data = json_decode(file_get_contents("php://input"));

// Validasi input
if (isset($data->action)) {
    if ($data->action === 'simpan') {
        // Simpan data pengajuan baru
        if (savePengajuan($koneksi, $data)) {
            $response['status'] = 'success';
            $response['message'] = 'Pengajuan berhasil disimpan.';
            $response['redirect'] = 'BuktiPeminjaman.php'; // Redirect ke bukti peminjaman
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal menyimpan pengajuan.';
        }
    } elseif (isset($data->id)) {
        $id = intval($data->id);
        
        if ($data->action === 'terima') {
            if (updateStatusPengajuan($koneksi, $id, 'Disetujui')) {
                $response['status'] = 'success';
                $response['message'] = 'Pengajuan diterima.';
                $response['redirect'] = 'BuktiPeminjaman.php'; // Redirect ke bukti peminjaman
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Gagal memperbarui status pengajuan.';
            }
        } elseif ($data->action === 'tolak') {
            if (deletePengajuan($koneksi, $id)) {
                $response['status'] = 'error';
                $response['message'] = 'Pengajuan ditolak. Stok barang habis dan pengajuan dihapus.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Gagal menghapus pengajuan.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Aksi tidak valid.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Data tidak lengkap.';   
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Data tidak lengkap.';
}

echo json_encode($response);
$koneksi->close();
?>