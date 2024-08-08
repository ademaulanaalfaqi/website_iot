-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 27, 2024 at 02:46 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
-- Table structure for table `water_flows`
--

CREATE TABLE `water_flows` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pelanggan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` float(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `water_flows`
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
-- Indexes for table `water_flows`
--
ALTER TABLE `water_flows`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `water_flows`
--
ALTER TABLE `water_flows`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=830;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
