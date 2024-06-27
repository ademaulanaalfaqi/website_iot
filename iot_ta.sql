-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jun 2024 pada 07.25
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
(2, 'Debit-OaDIw', 13, 20, '2024-06-22 13:16:26');

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
('Deb-EPNQO', '-1.8278835232805948', '109.96616364223883', 'siann', 'Debit', '2024-06-26 21:33:23', '2024-06-26 21:33:23'),
('Debit-OaDIw', '-1.810726038750336', '109.969253547024', 'dekat sian', 'Debit', '2024-06-23 06:40:26', '2024-06-23 06:40:26'),
('Tek-E7ifE', '-1.8573940122606436', '109.9750900338404', 'sini', 'Tekanan', '2024-06-25 00:05:33', '2024-06-25 00:05:33');

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
(38, 'Tek-E7ifE', 5, '2024-06-25 07:07:07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `debit`
--
ALTER TABLE `debit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_sensor` (`id_sensor`);

--
-- Indeks untuk tabel `sensor`
--
ALTER TABLE `sensor`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tekanan`
--
ALTER TABLE `tekanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tekanan_ibfk_1` (`id_sensor`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `debit`
--
ALTER TABLE `debit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tekanan`
--
ALTER TABLE `tekanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `debit`
--
ALTER TABLE `debit`
  ADD CONSTRAINT `debit_ibfk_1` FOREIGN KEY (`id_sensor`) REFERENCES `sensor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tekanan`
--
ALTER TABLE `tekanan`
  ADD CONSTRAINT `tekanan_ibfk_1` FOREIGN KEY (`id_sensor`) REFERENCES `sensor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
