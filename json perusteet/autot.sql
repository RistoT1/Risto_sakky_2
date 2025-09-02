-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+deb12u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 02.09.2025 klo 11:14
-- Palvelimen versio: 10.11.11-MariaDB-0+deb12u1
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `213603`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `autot`
--

CREATE TABLE `autot` (
  `ID` int(11) NOT NULL,
  `Merkki` varchar(50) NOT NULL,
  `Tyyppi` varchar(50) NOT NULL,
  `Vuosimalli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `autot`
--

INSERT INTO `autot` (`ID`, `Merkki`, `Tyyppi`, `Vuosimalli`) VALUES
(1, 'Audi', 'A5', 2013),
(2, 'BMW', 'M5', 2019),
(3, 'Ford', 'Focus', 2019);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autot`
--
ALTER TABLE `autot`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autot`
--
ALTER TABLE `autot`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
