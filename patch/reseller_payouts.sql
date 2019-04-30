-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2019 at 12:49 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `essensan_ge_nouni`
--

-- --------------------------------------------------------

--
-- Table structure for table `reseller_payouts`
--

CREATE TABLE `reseller_payouts` (
  `payout_id` bigint(11) UNSIGNED NOT NULL,
  `trackingcode` varchar(100) NOT NULL,
  `total_voucher_amount` decimal(9,2) NOT NULL,
  `total_requests` int(10) NOT NULL,
  `processedby` bigint(11) UNSIGNED NOT NULL,
  `dateprocessed` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reseller_payouts`
--
ALTER TABLE `reseller_payouts`
  ADD PRIMARY KEY (`payout_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reseller_payouts`
--
ALTER TABLE `reseller_payouts`
  MODIFY `payout_id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
