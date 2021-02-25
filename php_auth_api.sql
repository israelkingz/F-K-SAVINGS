-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2021 at 12:10 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_auth_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `TransactionID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ReferenceID` varchar(50) NOT NULL,
  `Amount` float DEFAULT NULL,
  `IsValid` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`TransactionID`, `UserID`, `ReferenceID`, `Amount`, `IsValid`) VALUES
(1, 7, '760369edac171c', 50000, '0'),
(2, 7, '760369ef47f386', 67000, '0'),
(3, 7, '760369f3f93915', 67000, '0'),
(4, 6, '66037833e6e693', 70000, '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Wallet` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `name`, `email`, `password`, `Wallet`) VALUES
(6, 'Odeajo Israel', 'iodeajo@gmail.com', 'timileyin', -70000),
(7, 'Odeajo Israel', 'iodeajo@yahoo.com', '$2y$10$afMSlNMfPrXXPSrswssm2uGYp6NGNXO0sKFi4YUWFdnyVdad7dQ7u', 140000),
(8, 'Adeleke Adeola', 'adelekeadeola@gmail.com', '$2y$10$eBFGND8o70vIJrG9bAlDIe6PDBewRDmbmTTrCuf/vFVG6vhu8n0rG', 0),
(9, 'Adeleke Adeola', 'aadelekeadeola@gmail.com', '$2y$10$3jg5wCi0Wb4VPJsN9pjmHOHqmMgAramIglpBGOcRblhA.2Y9E356K', 0),
(10, 'Adeleke Adeola', 'adeola@gmail.com', '$2y$10$eaWyyuhN8lLO8bSGb1J0Nu8M0ZCKVBw4a30OJb5Ty7U2dgn.dl6D2', 0),
(11, 'Rain Nigeria', 'rainnigeria@gmail.com', '$2y$10$dP48mK2oYXRGtNT.wTzWE.8Sws1Rejy1yHT0dnlSktD72hgeCFUaG', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`TransactionID`),
  ADD UNIQUE KEY `ReferenceID` (`ReferenceID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
