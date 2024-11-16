-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2024 at 07:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_peminjaman`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admn`
--

CREATE TABLE `tb_admn` (
  `username` varchar(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admn`
--

INSERT INTO `tb_admn` (`username`, `password`) VALUES
('admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `jumlah` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id`, `nama_barang`, `jumlah`) VALUES
(1, 'Proyektor', 92),
(2, 'Converter', 88),
(3, 'ATK', 100),
(4, 'HDMI', 51),
(5, 'Terminal', 97);

-- --------------------------------------------------------

--
-- Table structure for table `tb_peminjaman`
--

CREATE TABLE `tb_peminjaman` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `mata_kuliah` varchar(255) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `jam_matkul` varchar(50) DEFAULT NULL,
  `kode_peminjaman` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_peminjaman`
--

INSERT INTO `tb_peminjaman` (`id`, `nama`, `email`, `no_hp`, `mata_kuliah`, `kelas`, `jam_matkul`, `kode_peminjaman`) VALUES
(62, 'Muhammad Rizqi Ramadani', 'coba@gmail.com', '08987676', 'rpl', 'ti-3A', '1:00', 'PMJ-20241027-895'),
(63, 'Syafira Aisha Serafina', 'syfra895@gmail.com', '081253992784', 'RPL', 'TI 3A', '09.00', 'PMJ-20241027-002'),
(64, 'Syafira Aisha Serafina', 'syfra895@gmail.com', '081253992784', 'RPL', 'TI 3A', '09.00', 'PMJ-20241027-556'),
(65, 'Syafira Aisha Serafina', 'syfra895@gmail.com', '081253992784', 'RPL', 'TI 3A', '09.00', 'PMJ-20241027-930');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengajuan`
--

CREATE TABLE `tb_pengajuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `barang` varchar(255) DEFAULT NULL,
  `status` enum('Diajukan','Disetujui','Ditolak') DEFAULT 'Diajukan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_pengajuan`
--

INSERT INTO `tb_pengajuan` (`id`, `nama`, `email`, `no_hp`, `barang`, `status`) VALUES
(35, 'Muhammad Rizqi Ramadani', 'coba@gmail.com', '08987676', '[{\"nama_barang\":\"hdmi\",\"jumlah\":2}]', 'Diajukan'),
(36, 'Syafira Aisha Serafina', 'syfra895@gmail.com', '081253992784', '[{\"nama_barang\":\"hdmi\",\"jumlah\":1},{\"nama_barang\":\"vga\",\"jumlah\":1},{\"nama_barang\":\"proyektor\",\"jumlah\":1},{\"nama_barang\":\"alat tulis kantor\",\"jumlah\":1}]', 'Diajukan'),
(37, 'Syafira Aisha Serafina', 'syfra895@gmail.com', '081253992784', '[{\"nama_barang\":\"hdmi\",\"jumlah\":1},{\"nama_barang\":\"vga\",\"jumlah\":1},{\"nama_barang\":\"proyektor\",\"jumlah\":1},{\"nama_barang\":\"alat tulis kantor\",\"jumlah\":1}]', 'Diajukan'),
(38, 'Syafira Aisha Serafina', 'syfra895@gmail.com', '081253992784', '[{\"nama_barang\":\"hdmi\",\"jumlah\":1},{\"nama_barang\":\"vga\",\"jumlah\":1},{\"nama_barang\":\"proyektor\",\"jumlah\":1},{\"nama_barang\":\"alat tulis kantor\",\"jumlah\":1}]', 'Diajukan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_regist`
--

CREATE TABLE `tb_regist` (
  `nama_lengkap` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_regist`
--

INSERT INTO `tb_regist` (`nama_lengkap`, `nim`, `email`, `password`, `reset_token`, `reset_time`) VALUES
('coba', '2222', 'coba@gmail.com', '$2y$10$thZ7PxY0NkUcA3YH8XVPc.nxdnAtwBIPmInIEPKXnsYDmkMc82hEG', NULL, NULL),
('Indah Khoirun Nissa', '2167890845', 'indahnissa28@gmail.com', '$2y$10$NkE83WwjSenO4TQL36e2u.XIUO1srtQms/EPZTwSJoFRwRcoPGHmG', NULL, NULL),
('Muhammad Rizqi Ramadani', '236151015', 'MuhammadRizqiRamadani@gmail.com', '$2y$10$dcITN1XlcH2pkygY8AO8fu9eD8Y8uPmkmuoYKMKAB0B2GttljS7Ze', NULL, NULL),
('Syafira Aisha Serafina', '2301036124', 'syfra895@gmail.com', '$2y$10$9jfGdCCmjR3UNNqSjIrxBOJJWzGWSdmh2RAx8pAw187wxFbbDgXAG', NULL, NULL),
('zidan', '2233', 'zidan22@gmail.com', '$2y$10$ah5QZp4x0eK.cuzB24JKdu/7sbRVyStwQhTXK6VG9zlP8kGAjSjs2', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admn`
--
ALTER TABLE `tb_admn`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pengajuan`
--
ALTER TABLE `tb_pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_regist`
--
ALTER TABLE `tb_regist`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nama_lengkap` (`nama_lengkap`,`nim`,`email`,`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tb_pengajuan`
--
ALTER TABLE `tb_pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
