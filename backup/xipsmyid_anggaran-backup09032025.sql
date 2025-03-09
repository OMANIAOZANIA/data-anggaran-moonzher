-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 09 Mar 2025 pada 15.10
-- Versi server: 8.0.41-cll-lve
-- Versi PHP: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xipsmyid_anggaran`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggaran`
--

CREATE TABLE `anggaran` (
  `kode_anggaran` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `user_anggaran` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `response` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggaran`
--

INSERT INTO `anggaran` (`kode_anggaran`, `user_anggaran`, `nama_kegiatan`, `tanggal`, `jumlah`, `keterangan`, `status`, `response`) VALUES
('AGR-67c8e9e0aa32b', 'user', 'Minta Dana 3 Miliar', '2025-03-06', 30000000.00, 'Minta Dana 3 Miliar', 'approved', 'Telah diterima.'),
('AGR-67cbf765f3d1d', 'user', 'Anggaran Percobaan', '2025-03-29', 15000.00, 'Hanya percobaan saja..', 'rejected', 'Dilarang mencoba!'),
('AGR-67cbf92f4d1eb', 'Isu', 'Diddy Party', '2025-03-08', 900000.00, 'Yes', 'approved', 'yes bro i agree'),
('AGR-67cbf96cc04d0', 'Depuns', 'oplos pertamina', '2025-03-20', 1000000000000.00, 'need 980T', 'pending', 'Menunggu balasan Administrator.'),
('AGR-67cbf9f139354', 'user', 'Korupsi Duit 1 Juta', '2025-03-01', 1000000.00, 'Ingin korupsi', 'pending', 'Menunggu balasan Administrator.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Administrator', 'admin', '$2y$10$gfyOaTcPkJNdYC095fMrnekquSmGbJfRfR9zqBz9Pa5L6ibuBdlre', 'admin'),
(2, 'Rajendra Verrill Hafizha', 'user', '$2y$10$Mm8zcMJrO5Y0Ix8CxtZlW.dkrIEsrdnShHuS7e2iAEVgyXyzjUONK', 'user'),
(3, 'Devan', 'Depuns', '$2y$10$gbm3xBGcfOtbdK49OFtcpOdrJ1PiYa1eKaC9WvnXZbjL17uLG4nkS', 'user'),
(6, 'Gerald', 'Isu', '$2y$10$iYfGtu6LEgF1wDkPlNmPFu8lxIa1b1Zer5EHxCTCWCnvRzK/lorHu', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`kode_anggaran`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
