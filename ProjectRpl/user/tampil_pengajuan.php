<?php
require 'koneksi.php';

// Ambil data dari database
$query = "SELECT * FROM tb_pengajuan";
$result = $koneksi->query($query);

echo '<table>';
echo '<tr><th>ID</th><th>Nama</th><th>Email</th><th>No HP</th><th>Barang</th><th>Status</th></tr>';

while ($row = $result->fetch_assoc()) {
    // Decode JSON jika diperlukan
    $barang = json_decode($row['barang'], true);
    
    // Format barang menjadi string
    $barang_string = '';
    foreach ($barang as $item) {
        $barang_string .= $item['nama_barang'] . ' (' . $item['jumlah'] . '), ';
    }
    
    // Hapus koma terakhir
    $barang_string = rtrim($barang_string, ', ');

    // Tampilkan data
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['nama']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td>{$row['no_hp']}</td>";
    echo "<td>{$barang_string}</td>"; // Tampilkan barang
    echo "<td>{$row['status']}</td>";
    echo "</tr>";
}

echo '</table>';
$koneksi->close();
?>