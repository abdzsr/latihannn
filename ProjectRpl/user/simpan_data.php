<?php
session_start(); 
require 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->nama) && isset($data->email) && isset($data->no_hp) && isset($data->mata_kuliah) && isset($data->kelas) && isset($data->jam_matkul)) {
    // Ambil data dari request
    $nama = $data->nama;
    $email = $data->email;
    $no_hp = $data->no_hp;
    $mata_kuliah = $data->mata_kuliah;
    $kelas = $data->kelas;
    $jam_matkul = $data->jam_matkul;

    // Generate kode peminjaman 
    $kode_peminjaman = 'PMJ-' . date('Ymd') . '-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);


    // Siapkan statement untuk menyimpan data
    $stmt = $koneksi->prepare("INSERT INTO tb_peminjaman (kode_peminjaman, nama, email, no_hp, mata_kuliah, kelas, jam_matkul) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $kode_peminjaman, $nama, $email, $no_hp, $mata_kuliah, $kelas, $jam_matkul);

    if ($stmt->execute()) {
        // Simpan data peminjaman ke session
        $_SESSION['peminjaman'] = [
            'kode_peminjaman' => $kode_peminjaman,
            'nama' => $nama,
            'email' => $email,
            'no_hp' => $no_hp,
            'mata_kuliah' => $mata_kuliah,
            'kelas' => $kelas,
            'jam_matkul' => $jam_matkul,
        ];

        echo json_encode(['status' => 'success', 'kode_peminjaman' => $kode_peminjaman]); // Kembalikan kode peminjaman
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data: ' . $stmt->error]);
    }

    $stmt->close();
    $koneksi->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
}
?>