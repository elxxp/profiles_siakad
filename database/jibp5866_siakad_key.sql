-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 16, 2025 at 11:44 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jibp5866_siakad_key`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountID` int NOT NULL,
  `accountUsername` varchar(255) NOT NULL,
  `accountPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountID`, `accountUsername`, `accountPassword`) VALUES
(1, 'astro', 'astro123');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `idKey` int NOT NULL,
  `userDisplay` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nameDisplay` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `userKey` varchar(255) NOT NULL,
  `passKey` varchar(255) NOT NULL,
  `levelKey` varchar(255) NOT NULL,
  `bypass` enum('true','false') NOT NULL,
  `detect` enum('true','false') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`idKey`, `userDisplay`, `nameDisplay`, `userKey`, `passKey`, `levelKey`, `bypass`, `detect`) VALUES
(1, '197907192006042029', 'Lina Andriani, S.Pd.', 'lina', 'bGluYQ==', 'bk', 'true', 'false'),
(2, '198004242022212008', 'Sulastri, S.Pd.', '198004242022212008', 'djBoMTVtNA==', 'guru', 'true', 'true'),
(3, '197209072023212004 ', 'Sri Wayati, S.Pd.', '197209072023212004 ', 'djBoMTVtNA==', 'guru', 'false', 'true');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`idKey`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `idKey` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;