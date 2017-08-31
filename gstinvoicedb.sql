-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 31, 2017 at 02:25 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gstinvoicedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `hsn`
--

CREATE TABLE `hsn` (
  `hsn_code_id` int(11) NOT NULL,
  `hsn_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `hsn_code_name` text COLLATE utf8_unicode_ci NOT NULL,
  `gst_rate` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hsn`
--

INSERT INTO `hsn` (`hsn_code_id`, `hsn_code`, `hsn_code_name`, `gst_rate`) VALUES
(1, '1011010', 'LIVE HORSES, ASSES, MULES AND HINNIES PURE-BRED BREEDING ANIMALS HORSES', 28),
(2, '96083021', 'HIGH VALUE PENS', 18);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `invoice_ref_no` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `update_by` int(11) NOT NULL,
  `update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sub_total` double NOT NULL,
  `tax_total` double NOT NULL DEFAULT '0',
  `gross_total` double NOT NULL,
  `archive_in` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_item`
--

CREATE TABLE `invoice_item` (
  `item_id` mediumint(9) NOT NULL,
  `item_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `item_unit_price` double NOT NULL,
  `item_unit_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item_qty` double NOT NULL,
  `item_tax_rate` double NOT NULL,
  `item_price` double NOT NULL,
  `item_tax_total` double NOT NULL DEFAULT '0',
  `item_total` double NOT NULL,
  `invoice_id` mediumint(9) NOT NULL,
  `ref_product_id` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` mediumint(9) NOT NULL,
  `prod_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `prod_details` text COLLATE utf8_unicode_ci,
  `unit_id` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `hsn_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_rate` double NOT NULL DEFAULT '0',
  `stock_qty` double NOT NULL DEFAULT '0',
  `active_in` tinyint(4) NOT NULL DEFAULT '1',
  `update_by` int(11) NOT NULL,
  `update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upc` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gtin` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mpn` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` int(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_name`, `prod_details`, `unit_id`, `unit_price`, `hsn_code`, `tax_rate`, `stock_qty`, `active_in`, `update_by`, `update_ts`, `upc`, `gtin`, `mpn`, `barcode`) VALUES
(1, 'Test Product 1', 'Test details 1', 1, 10, '', 10, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(2, 'Test Product 2', 'Test details 2', 2, 11, '96083021', 0, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(3, 'Test Product 3', 'Test details 3', 1, 12, '', 12, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(4, 'Test Product 4', 'Test details 4', 2, 13, '96083021', 0, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(5, 'Test Product 5', 'Test details 5', 1, 14, '', 14, 0, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(6, 'Test Product 6', 'Test details 6', 1, 15, '1011010', 0, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(7, 'Test Product 7', 'Test details 7', 1, 16, '', 16, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(8, 'Test Product 8', 'Test details 8', 1, 17, '', 17, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(9, 'Test Product 9', 'Test details 9', 1, 18, '', 18, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(10, 'Test Product 10', 'Test details 10', 1, 19, '', 19, 0, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(11, 'Test Product 11', 'Test details 11', 1, 20, '', 20, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(12, 'Test Product 12', 'Test details 12', 1, 21, '', 21, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(13, 'Test Product 13', 'Test details 13', 2, 22, '1011010', 0, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(14, 'Test Product 14', 'Test details 14', 1, 23, '', 23, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(15, 'Test Product 15', 'Test details 15', 1, 24, '', 24, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(16, 'Test Product 16', 'Test details 16', 1, 25, '', 25, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(17, 'Test Product 17', 'Test details 17', 1, 26, '', 26, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(18, 'Test Product 18', 'Test details 18', 1, 27, '1011010', 0, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(19, 'Test Product 19', 'Test details 19', 1, 28, '', 28, 0, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(20, 'Test Product 20', 'Test details 20', 1, 29, '', 29, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(21, 'Test Product 21', 'Test details 21', 1, 30, '', 30, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(22, 'Test Product 22', 'Test details 22', 1, 31, '', 31, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0),
(23, 'Test Product 23', 'Test details 23', 1, 32, '', 32, 100, 1, 1, '2017-08-29 19:31:01', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_unit`
--

CREATE TABLE `product_unit` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `fraction_allowed_in` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_unit`
--

INSERT INTO `product_unit` (`unit_id`, `unit_name`, `fraction_allowed_in`) VALUES
(1, 'Piece', 0),
(2, 'KG', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_in` tinyint(1) NOT NULL DEFAULT '1',
  `access_level` tinyint(4) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `full_name`, `username`, `password`, `email_id`, `active_in`, `access_level`) VALUES
(1, 'Prithwiraj Bose', 'admin', 'xyz123', 'sribasu@gmail.com', 1, 1),
(2, 'Pom Bose', 'sampleuser1', 'xyz124', 'exampleid10000@gmail.com', 1, 2),
(3, 'Parijat Bose', 'sampleuser2', 'xyz125', 'exampleid10001@gmail.com', 1, 2),
(4, 'Ishita Bose', 'sampleuser3', 'xyz126', 'exampleid10000@gmail.com', 1, 2),
(5, 'Tilottama Bose', 'sampleuser4', 'xyz127', 'exampleid10001@gmail.com', 1, 2),
(6, 'Partha Sarathi Bose', 'sampleuser5', 'xyz128', 'exampleid10000@gmail.com', 1, 2),
(7, 'Mukti Bose', 'sampleuser6', 'xyz129', 'exampleid10001@gmail.com', 1, 2),
(8, 'Prithwiraj Bose', 'sampleuser7', 'xyz130', 'exampleid10000@gmail.com', 1, 2),
(9, 'Prithwiraj Bose', 'sampleuser8', 'xyz131', 'exampleid10001@gmail.com', 1, 2),
(10, 'Prithwiraj Bose', 'sampleuser9', 'xyz132', 'exampleid10000@gmail.com', 1, 2),
(11, 'Prithwiraj Bose', 'admin23', 'xyz123', 'sribasu@gmail.com', 0, 1),
(12, 'Pom Bose', 'hostuser1', 'xyz124', 'exampleid10000@gmail.com', 1, 2),
(13, 'Parijat Bose', 'hostuser2', 'xyz125', 'exampleid10001@gmail.com', 1, 2),
(14, 'Ishita Bose', 'hostuser3', 'xyz126', 'exampleid10000@gmail.com', 1, 2),
(15, 'Tilottama Bose', 'hostuser4', 'xyz127', 'exampleid10001@gmail.com', 1, 2),
(16, 'Partha Sarathi Bose', 'hostuser5', 'xyz128', 'exampleid10000@gmail.com', 1, 2),
(17, 'Mukti Bose', 'hostuser6', 'xyz129', 'exampleid10001@gmail.com', 1, 2),
(18, 'Prithwiraj Bose', 'hostuser7', 'xyz130', 'exampleid10000@gmail.com', 1, 2),
(19, 'Prithwiraj Bose', 'hostuser8', 'xyz131', 'exampleid10001@gmail.com', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hsn`
--
ALTER TABLE `hsn`
  ADD PRIMARY KEY (`hsn_code_id`),
  ADD UNIQUE KEY `hsn_code` (`hsn_code`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_item`
--
ALTER TABLE `invoice_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `invoice_items_invoice_id` (`invoice_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `prod_name` (`prod_name`,`upc`,`gtin`,`mpn`,`barcode`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `hsn_code` (`hsn_code`);

--
-- Indexes for table `product_unit`
--
ALTER TABLE `product_unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hsn`
--
ALTER TABLE `hsn`
  MODIFY `hsn_code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoice_item`
--
ALTER TABLE `invoice_item`
  MODIFY `item_id` mediumint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `product_unit`
--
ALTER TABLE `product_unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `product_unit` (`unit_id`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
