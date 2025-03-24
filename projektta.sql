-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 02:51 PM
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
-- Database: `projektta`
--

-- --------------------------------------------------------

--
-- Table structure for table `cikli_pvh`
--

CREATE TABLE `cikli_pvh` (
  `id` int(11) NOT NULL,
  `titulli` varchar(255) NOT NULL,
  `aksioni` varchar(255) NOT NULL,
  `dega` varchar(255) NOT NULL,
  `desiminatori` varchar(255) NOT NULL,
  `punetori` varchar(255) NOT NULL,
  `permbajtja_titulli` varchar(255) NOT NULL,
  `permbajtja` text NOT NULL,
  `analiza_problemit` text NOT NULL,
  `note` text NOT NULL,
  `percaktimi` text NOT NULL,
  `perdorimi_projektit` text NOT NULL,
  `informacione_shtese` text NOT NULL,
  `skedaret` text DEFAULT NULL,
  `vleresimi` decimal(3,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_requests`
--

CREATE TABLE `contact_requests` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_requests`
--

INSERT INTO `contact_requests` (`id`, `username`, `email`, `role`, `message`, `created_at`) VALUES
(1, 'a', 'z@gmail.com', 'mentor', 'a', '2025-03-24 10:08:42'),
(2, 'qqq', 'qqq@gmail.com', 'mentor', 'kerkese per regjistrimin si mentor', '2025-03-24 10:09:09'),
(3, 'qqq', 'qqq@gmail.com', 'mentor', 'kerkese per regjistrimin si mentor', '2025-03-24 10:33:08'),
(4, 'ardiana', 'ardiana@gmail.com', 'desiminator', 'a', '2025-03-24 12:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `desiminatoret`
--

CREATE TABLE `desiminatoret` (
  `id` int(11) NOT NULL,
  `emri` varchar(50) NOT NULL,
  `mbiemri` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `numri_telefonit` varchar(20) NOT NULL,
  `qyteti_rajoni` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `desiminatoret`
--

INSERT INTO `desiminatoret` (`id`, `emri`, `mbiemri`, `email`, `numri_telefonit`, `qyteti_rajoni`, `password`) VALUES
(1, 'Teacher1', 'Shala', 'Teacher1@gmail.com', '049 663 060', NULL, ''),
(2, 'Teacher2', 'Shala', 'Teacher2@gmail.com', '049 663 600', NULL, ''),
(3, 'Teacher3', 'Shala', 'Teacher3@gmail.com', '049 663 006', NULL, ''),
(4, 'z', 'z', 'z@gmail.com', '000000000', 'ob', '$2y$10$HlIiNlW0H6obOJYnsEbPZekbQpc6oUjCOF3IWcmrvaemuWoglt2Ee'),
(5, 'qqq', 'qqq', 'qqq@gmail.com', '123123123', 'pr', '$2y$10$AhgvLL0GxGXG9kejXiJ4Y.73iFmi0XQ4kPTxIj5RKpNUQs.7BniAi');

-- --------------------------------------------------------

--
-- Table structure for table `mentoret`
--

CREATE TABLE `mentoret` (
  `id` int(11) NOT NULL,
  `emri` varchar(50) NOT NULL,
  `mbiemri` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `numri_telefonit` varchar(20) NOT NULL,
  `qyteti_rajoni` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentoret`
--

INSERT INTO `mentoret` (`id`, `emri`, `mbiemri`, `email`, `numri_telefonit`, `qyteti_rajoni`, `password`) VALUES
(1, 'Mentor1', 'Shala', 'mentor1@gmail.com', '049 663 060', NULL, ''),
(2, 'q', 'q', 'q@gmail.com', '1234567890', 'qqq', '$2y$10$66VpCB.Pt1c4rAWYu55LNe8Xjr3ns/ZQ0mEZWx6XQjHCJc3FV3N.G');

-- --------------------------------------------------------

--
-- Table structure for table `oret_vullnetare`
--

CREATE TABLE `oret_vullnetare` (
  `id` int(11) NOT NULL,
  `aktivitetet_konkrete` text NOT NULL,
  `data_fillimit` date NOT NULL,
  `ora_fillimit` time NOT NULL,
  `data_perfundimit` date NOT NULL,
  `ora_perfundimit` time NOT NULL,
  `pjesemarresit` text NOT NULL,
  `vleresimi` decimal(3,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projektet`
--

CREATE TABLE `projektet` (
  `id` int(11) NOT NULL,
  `titulli` varchar(100) NOT NULL,
  `mentori_id` int(11) NOT NULL,
  `desiminatori_id` int(11) NOT NULL,
  `vleresimi` float DEFAULT 0,
  `statusi` enum('ne zhvillim','perfunduara') NOT NULL DEFAULT 'ne zhvillim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projektet`
--

INSERT INTO `projektet` (`id`, `titulli`, `mentori_id`, `desiminatori_id`, `vleresimi`, `statusi`) VALUES
(1, '123qwe', 1, 2, 10, 'ne zhvillim'),
(2, 'qqq', 2, 4, 4.4, 'ne zhvillim'),
(3, 'eee', 1, 4, 1.4, 'ne zhvillim');

-- --------------------------------------------------------

--
-- Table structure for table `raportet`
--

CREATE TABLE `raportet` (
  `id` int(11) NOT NULL,
  `desiminator_id` int(11) NOT NULL,
  `titulli` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `pershkrimi` text DEFAULT NULL,
  `rajoni` varchar(100) NOT NULL,
  `shkolla` varchar(255) NOT NULL,
  `numri_pjesemarresve` int(11) NOT NULL,
  `drejtimet` text NOT NULL,
  `anet_pozitive` text NOT NULL,
  `raportin_pergatitur` varchar(255) NOT NULL,
  `rekomandime` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `raportet`
--

INSERT INTO `raportet` (`id`, `desiminator_id`, `titulli`, `data`, `pershkrimi`, `rajoni`, `shkolla`, `numri_pjesemarresve`, `drejtimet`, `anet_pozitive`, `raportin_pergatitur`, `rekomandime`) VALUES
(2, 1, 'q', '2025-03-19', NULL, 'prishtine', 'prishtine', 3, 'q', 'q', 'q', 'q');

-- --------------------------------------------------------

--
-- Table structure for table `rezultatet_e_arritura`
--

CREATE TABLE `rezultatet_e_arritura` (
  `id` int(11) NOT NULL,
  `produktet` varchar(255) NOT NULL,
  `numri_njerezve` int(11) NOT NULL,
  `mjetet_financiare` decimal(10,2) NOT NULL,
  `gjera_shtes` text NOT NULL,
  `pershkrimi_projektit` text NOT NULL,
  `faturat` text DEFAULT NULL,
  `vleresimi` decimal(3,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'superadmin', 'Ka qasje në të gjitha seksionet'),
(2, 'mentor', 'Ka qasje tek Mentorët, Projektet dhe Raportet'),
(3, 'desiminator', 'Ka qasje tek Desiminatorët, Projektet dhe Raportet'),
(4, 'vullnetar', 'Nuk ka qasje në asnjë seksion');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$6XneNGzglQMBucOALhlvouyFzSjs88zLutSFI527tMjcnjjG6eEEG', 1),
(2, 'mentori', '$2y$10$P1ea3OD4TtX1pNHw5YVIgeY64L.1fawJPRnP262zyB8dFdug8ZfiC', 2),
(3, 'desiminatori', '$2y$10$vxmbatb14A1WNc1AQZlFTOLJmQuq1YT05Pdd1zO.o18FuENRqPXKG', 3),
(4, 'vullnetari', '$2y$10$q1qGZXUaHbZe00kpAWKCBu4dRa6IZRhrQLmp.QLz0dQEXL4y8EBJm', 4),
(9, 'ardiana', '$2y$10$4pPExINUozq5p5C6OjdNbe53bvBwDB21Rvp26eXtAGsO9KEseR.Am', 3);

-- --------------------------------------------------------

--
-- Table structure for table `vullnetaret`
--

CREATE TABLE `vullnetaret` (
  `id` int(11) NOT NULL,
  `emri` varchar(50) NOT NULL,
  `mbiemri` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `numri_telefonit` varchar(20) NOT NULL,
  `qyteti_rajoni` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vullnetaret`
--

INSERT INTO `vullnetaret` (`id`, `emri`, `mbiemri`, `email`, `numri_telefonit`, `qyteti_rajoni`, `password`) VALUES
(1, 'e', 'e', 'e@gmail.com', '123321123', 'fr', '$2y$10$.subZPBdhKh7PSZNfn.MBeanRTbNteRBX6cXJ1dPR0B.1b1A3TrEi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cikli_pvh`
--
ALTER TABLE `cikli_pvh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `desiminatoret`
--
ALTER TABLE `desiminatoret`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `mentoret`
--
ALTER TABLE `mentoret`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `oret_vullnetare`
--
ALTER TABLE `oret_vullnetare`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projektet`
--
ALTER TABLE `projektet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentori_id` (`mentori_id`),
  ADD KEY `desiminatori_id` (`desiminatori_id`);

--
-- Indexes for table `raportet`
--
ALTER TABLE `raportet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `desiminator_id` (`desiminator_id`);

--
-- Indexes for table `rezultatet_e_arritura`
--
ALTER TABLE `rezultatet_e_arritura`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role`);

--
-- Indexes for table `vullnetaret`
--
ALTER TABLE `vullnetaret`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cikli_pvh`
--
ALTER TABLE `cikli_pvh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `desiminatoret`
--
ALTER TABLE `desiminatoret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mentoret`
--
ALTER TABLE `mentoret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `oret_vullnetare`
--
ALTER TABLE `oret_vullnetare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projektet`
--
ALTER TABLE `projektet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `raportet`
--
ALTER TABLE `raportet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rezultatet_e_arritura`
--
ALTER TABLE `rezultatet_e_arritura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vullnetaret`
--
ALTER TABLE `vullnetaret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projektet`
--
ALTER TABLE `projektet`
  ADD CONSTRAINT `projektet_ibfk_1` FOREIGN KEY (`mentori_id`) REFERENCES `mentoret` (`id`),
  ADD CONSTRAINT `projektet_ibfk_2` FOREIGN KEY (`desiminatori_id`) REFERENCES `desiminatoret` (`id`);

--
-- Constraints for table `raportet`
--
ALTER TABLE `raportet`
  ADD CONSTRAINT `raportet_ibfk_1` FOREIGN KEY (`desiminator_id`) REFERENCES `desiminatoret` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
