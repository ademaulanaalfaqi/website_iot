-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jul 2024 pada 13.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot_ta`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `debit`
--

CREATE TABLE `debit` (
  `id` int(11) NOT NULL,
  `id_sensor` varchar(20) NOT NULL,
  `nilai_debit` float NOT NULL,
  `total_liter` float NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `debit`
--

INSERT INTO `debit` (`id`, `id_sensor`, `nilai_debit`, `total_liter`, `created_at`) VALUES
(2, 'Debit-OaDIw', 13, 20, '2024-06-22 13:16:26'),
(6, 'Debit-OaDIw', 15, 20, '2024-06-29 02:16:26'),
(7, 'Debit-OaDIw', 17, 20, '2024-06-29 02:16:26'),
(19, 'Debit-OaDIw', 12, 20, '2024-06-30 06:34:37'),
(21, 'Debit-OaDIw', 12, 0.14, '2024-06-30 06:39:12'),
(22, 'Debit-OaDIw', 13, 0.46, '2024-06-30 06:39:22'),
(23, 'Debit-OaDIw', 13, 0.51, '2024-06-30 06:44:02'),
(24, 'Debit-OaDIw', 13, 0.97, '2024-06-30 06:44:12'),
(25, 'Debit-OaDIw', 12, 0.17, '2024-06-30 06:45:50'),
(26, 'Debit-OaDIw', 11.64, 12, '2024-06-30 06:46:00'),
(27, 'Debit-OaDIw', 11, 0.46, '2024-06-30 06:46:10'),
(28, 'Debit-OaDIw', 13, 0.75, '2024-06-30 06:46:20'),
(29, 'Debit-OaDIw', 12.8, 0.96, '2024-06-30 06:46:30'),
(30, 'Debit-OaDIw', 12, 1.14, '2024-06-30 06:46:40'),
(31, 'Debit-OaDIw', 12, 1.31, '2024-06-30 06:46:50'),
(32, 'Debit-OaDIw', 12, 1.89, '2024-06-30 06:47:00'),
(33, 'Debit-OaDIw', 11, 2.38, '2024-06-30 06:47:10'),
(34, 'Debit-OaDIw', 10, 2.4, '2024-07-07 06:47:10'),
(36, 'Debit-OaDIw', 10, 0.08, '2024-07-23 06:56:39'),
(37, 'Debit-OaDIw', 11, 0.55, '2024-07-23 06:56:48'),
(41, 'Debit-OaDIw', 13, 0, '2024-07-23 08:48:08'),
(42, 'Debit-OaDIw', 14, 0.09, '2024-07-28 04:41:25'),
(43, 'Debit-OaDIw', 15, 0.2, '2024-07-28 04:41:35'),
(44, 'Debit-OaDIw', 12, 15, '2024-07-28 04:41:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kekeruhan`
--

CREATE TABLE `kekeruhan` (
  `id` int(11) NOT NULL,
  `id_sensor` varchar(20) NOT NULL,
  `turbi_ntu` float DEFAULT NULL,
  `turbi_voltage` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kekeruhan`
--

INSERT INTO `kekeruhan` (`id`, `id_sensor`, `turbi_ntu`, `turbi_voltage`, `created_at`) VALUES
(2, 'Tur-0FU', 25, 3, '2024-07-01 17:25:25'),
(3, 'Tur-0FU', 3000, 1.5, '2024-07-09 10:35:03'),
(4, 'Tur-0FU', 115, 3, '2024-07-08 18:59:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggans`
--

CREATE TABLE `pelanggans` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `sensor` char(15) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggans`
--

INSERT INTO `pelanggans` (`id`, `nama`, `alamat`, `latitude`, `longitude`, `keterangan`, `sensor`, `created_at`, `updated_at`) VALUES
('Met-ELmZ7', 'Kelempiau', 'Jl. Alammat', '-1.82067739966034', '109.92550849914552', 'Dekat Sumur', 'Meteran', '2024-07-25 11:33:09', '2024-07-28 04:27:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ph`
--

CREATE TABLE `ph` (
  `id` int(11) NOT NULL,
  `id_sensor` varchar(20) NOT NULL,
  `ph_value` float DEFAULT NULL,
  `ph_voltage` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ph`
--

INSERT INTO `ph` (`id`, `id_sensor`, `ph_value`, `ph_voltage`, `created_at`) VALUES
(1, 'pH-kGK', 7, 2, '2024-07-05 07:58:53'),
(2, 'pH-kGK', 7.4, 2, '2024-07-19 07:58:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sensor`
--

CREATE TABLE `sensor` (
  `id` varchar(20) NOT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `sensor` char(15) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sensor`
--

INSERT INTO `sensor` (`id`, `latitude`, `longitude`, `keterangan`, `sensor`, `created_at`, `updated_at`) VALUES
('Debit-OaDIw', '-1.8053213974095434', '109.95838165283205', 'suka bangun', 'Debit', '2024-06-23 06:40:26', '2024-07-29 13:44:53'),
('pH-kGK', '-1.8185863316047028', '109.97657775878908', 'fefeiii', 'pH', '2024-07-04 02:14:32', '2024-07-27 08:33:22'),
('Tek-E7ifE', '-1.8327733764145868', '109.98353004455568', 'Mulia Baru', 'Tekanan', '2024-06-25 00:05:33', '2024-07-29 13:46:05'),
('Tur-0FU', '-1.827851353150054', '109.97451782226564', 'BENDE NIN BUAT DI TEPI AIK', 'Turbidity', '2024-07-04 02:20:43', '2024-07-27 12:35:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tekanan`
--

CREATE TABLE `tekanan` (
  `id` int(11) NOT NULL,
  `id_sensor` varchar(20) NOT NULL,
  `nilai_tekanan` float NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tekanan`
--

INSERT INTO `tekanan` (`id`, `id_sensor`, `nilai_tekanan`, `created_at`) VALUES
(65, 'Tek-E7ifE', 2, '2024-07-23 06:56:30'),
(66, 'Tek-E7ifE', 1, '2024-07-23 06:56:39'),
(67, 'Tek-E7ifE', 1, '2024-07-23 06:56:49'),
(68, 'Tek-E7ifE', 0, '2024-07-23 08:47:37'),
(69, 'Tek-E7ifE', 1, '2024-07-23 08:47:47'),
(70, 'Tek-E7ifE', 4, '2024-07-23 08:47:57'),
(71, 'Tek-E7ifE', 4, '2024-07-23 08:48:09'),
(72, 'Tek-E7ifE', 3, '2024-07-23 08:49:09'),
(73, 'Tek-E7ifE', 2, '2024-07-23 08:50:09'),
(74, 'Tek-E7ifE', 1, '2024-07-28 04:41:26'),
(75, 'Tek-E7ifE', 1, '2024-07-28 04:41:35'),
(76, 'Tek-E7ifE', 1, '2024-07-28 04:41:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `created_at`, `updated_at`) VALUES
(4, 'Ade Maulana', 'admlna', '$2y$10$j0bk6IFdIp9VoD/RNjQGLOlhiHO.iJRnOTVYLXwOElDUyyIjKBWeS', '2024-07-10 05:45:27', '2024-07-10 05:45:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `water_flows`
--

CREATE TABLE `water_flows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pelanggan` varchar(20) NOT NULL,
  `volume` float(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `water_flows`
--

INSERT INTO `water_flows` (`id`, `id_pelanggan`, `volume`, `created_at`) VALUES
(824, 'Met-ELmZ7', 0.25, '2024-07-26 22:45:26'),
(825, 'Met-ELmZ7', 1.31, '2024-07-26 22:45:28'),
(826, 'Met-ELmZ7', 0.18, '2024-07-26 22:45:33'),
(827, 'Met-ELmZ7', 0.01, '2024-07-26 22:52:02'),
(828, 'Met-ELmZ7', 1.38, '2024-07-26 22:52:04'),
(829, 'Met-ELmZ7', 0.35, '2024-07-26 22:52:06');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `debit`
--
ALTER TABLE `debit`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kekeruhan`
--
ALTER TABLE `kekeruhan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sensor` (`id_sensor`);

--
-- Indeks untuk tabel `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ph`
--
ALTER TABLE `ph`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sensor` (`id_sensor`);

--
-- Indeks untuk tabel `sensor`
--
ALTER TABLE `sensor`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tekanan`
--
ALTER TABLE `tekanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `water_flows`
--
ALTER TABLE `water_flows`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `debit`
--
ALTER TABLE `debit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `kekeruhan`
--
ALTER TABLE `kekeruhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `ph`
--
ALTER TABLE `ph`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `tekanan`
--
ALTER TABLE `tekanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `water_flows`
--
ALTER TABLE `water_flows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=830;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
