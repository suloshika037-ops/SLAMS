-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2026 at 08:42 AM
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
-- Database: `slams_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `nic` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `phone`, `address`, `nic`) VALUES
(1, 11, '0765432199', 'Balangoda', '20021345678'),
(2, 12, '0753331122', 'Rathnapura', '200212300456'),
(3, 13, '0761112233', 'Badulla', '200133444567'),
(7, 16, '0773434343', 'bandarawela', '199977666333'),
(8, 17, '0751212000', 'kuruwita', '200088900789'),
(10, 19, '0722992444', 'badulla', '200345700898');

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE `installments` (
  `id` int(11) NOT NULL,
  `installment_no` int(11) DEFAULT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `installments`
--

INSERT INTO `installments` (`id`, `installment_no`, `loan_id`, `due_date`, `amount`, `status`) VALUES
(1, 1, 1, '2026-02-02', 44000.00, 'Paid'),
(2, 2, 1, '2026-03-02', 44000.00, 'Paid'),
(3, 3, 1, '2026-04-02', 44000.00, 'Unpaid'),
(4, 4, 1, '2026-05-04', 44000.00, 'Paid'),
(5, 5, 1, '2026-06-02', 44000.00, 'Unpaid'),
(16, 1, 6, '2026-04-30', 22916.67, 'Paid'),
(17, 2, 6, '2026-05-30', 22916.67, 'Paid'),
(18, 3, 6, '2026-06-30', 22916.67, 'Paid'),
(20, 5, 6, '2026-08-30', 22916.67, 'Unpaid'),
(21, 6, 6, '2026-09-30', 22916.67, 'Unpaid'),
(22, 7, 6, '2026-10-30', 22916.67, 'Unpaid'),
(23, 8, 6, '2026-11-30', 22916.67, 'Unpaid'),
(25, 10, 6, '2027-01-30', 22916.67, 'Unpaid'),
(26, 11, 6, '2027-03-02', 22916.67, 'Unpaid'),
(27, 12, 6, '2027-03-30', 22916.67, 'Unpaid'),
(28, 1, 6, '2026-05-20', 45833.33, 'Paid'),
(29, 2, 6, '2026-06-20', 45833.33, 'Unpaid'),
(30, 3, 6, '2026-07-20', 45833.33, 'Unpaid'),
(32, 5, 6, '2026-09-20', 45833.33, 'Unpaid'),
(33, 6, 6, '2026-10-20', 45833.33, 'Unpaid'),
(59, 1, 9, '2026-08-17', 165000.00, 'Unpaid'),
(60, 2, 9, '2026-09-17', 165000.00, 'Unpaid'),
(61, 3, 9, '2026-10-17', 165000.00, 'Unpaid'),
(62, 4, 9, '2026-11-17', 165000.00, 'Unpaid'),
(63, 5, 9, '2026-12-17', 165000.00, 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `total_repayable` decimal(10,2) DEFAULT 0.00,
  `outstanding_balance` decimal(10,2) DEFAULT 0.00,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `amount`, `interest_rate`, `status`, `total_repayable`, `outstanding_balance`, `created_at`) VALUES
(1, 1, 200000.00, 10.00, 'Approved', 220000.00, 136000.00, '2026-01-05'),
(2, 2, 375000.00, 10.00, 'Rejected', 412500.00, 412500.00, '2026-02-24'),
(3, 3, 350000.00, 10.00, 'Pending', 385000.00, 385000.00, '2026-03-02'),
(5, 7, 400000.00, 10.00, 'Pending', 440000.00, 440000.00, '2026-05-31'),
(6, 8, 250000.00, 10.00, 'Approved', 275000.00, 164250.00, '2026-06-15'),
(9, 10, 750000.00, 10.00, 'Approved', 825000.00, 413000.00, '2026-07-11');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `receipt_no` varchar(30) DEFAULT NULL,
  `installment_id` int(11) DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `receipt_no`, `installment_id`, `paid_date`, `amount`) VALUES
(1, 'RCPT20260710150150', 1, '2026-02-02', 14000.00),
(2, 'RCPT20260710153010', 2, '2026-03-02', 30000.00),
(7, 'RCPT20260711071215', 16, '2026-04-30', 22916.67),
(8, 'RCPT20260711071251', 17, '2026-05-30', 20000.00),
(9, 'RCPT20260711071503', 18, '2026-06-30', 22000.00),
(10, 'RCPT20260711071659', 28, '2026-05-20', 45833.33);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(10, 'admin', 'admin@18.com', '$2y$10$ywamm20logNZt2qUy.HANOzpKMO4rVOvC813S4MDMeRkrMAseCu6a', 'admin'),
(11, 'vimal', 'vimal@gmail.com', '$2y$10$lpfrKECkyCSKiNE4sMJGZ.RKsfOD8okKakJDabPPDErsAAY6nrrBe', 'customer'),
(12, 'kumar', 'kumar@gmail.com', '$2y$10$CZ6wwSOqsx9V7dsLhCzafOGbUimD3rO.VdB7TkNsWt7iAXIYk8yva', 'customer'),
(13, 'saman', 'saman@14.com', '$2y$10$NyoU14ZCQFxnYaz2M/x6AOqPb5O5L8y7Ug89FAhkC6RRjOY9ZdVkm', 'customer'),
(15, 'tharun', 'tharun@gmail.com', '$2y$10$m5oesfG9k3b3GwyTMDbdyufXr8xWRPZqPMafB63k8cUPOKMQA/Kxe', 'customer'),
(16, 'kasun', 'kasun@gmail.com', '$2y$10$2GJ7EYb0.RnvE97eGanQtu.CxtcVqgKwM9OUkhY0e6BFkbmr546ku', 'customer'),
(17, 'george', 'geo@18.com', '$2y$10$JFJUN4wz6/IlBYiDu/spmeATHYk3nuWMETTNC7s7zRnPp3vRn4uPu', 'customer'),
(18, 'ajith', 'aji@gmail.com', '$2y$10$jSbP2xmltX9ir7q7C7ovpeUShM3IRDcGkfkw5eTSgOqvu9ydm.8k.', 'customer'),
(19, 'surya', 'surya@3.com', '$2y$10$jxAJXNXYI/1PDAdfqAuOMO6QMB5o/jddzDomrXYfeaoad3Ps1d9cW', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_installments_loan` (`loan_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_loans_customer` (`customer_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `installment_id` (`installment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `installments`
--
ALTER TABLE `installments`
  ADD CONSTRAINT `fk_installments_loan` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `fk_loans_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`installment_id`) REFERENCES `installments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
