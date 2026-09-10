-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2026 at 01:11 PM
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
-- Database: `techshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Laptopovi'),
(2, 'Računari'),
(3, 'Grafičke kartice'),
(4, 'Monitori'),
(5, 'Periferije'),
(6, 'Telefoni');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `order_date`) VALUES
(1, 1, 806999.85, '2026-09-09 20:00:13'),
(2, 1, 116999.96, '2026-09-09 20:07:19'),
(3, 1, 107999.97, '2026-09-09 20:42:09'),
(4, 1, 98999.98, '2026-09-10 00:13:48'),
(5, 1, 219999.98, '2026-09-10 00:33:44'),
(6, 1, 89999.99, '2026-09-10 00:34:26'),
(7, 1, 89999.99, '2026-09-10 00:35:50'),
(8, 1, 89999.99, '2026-09-10 00:39:54'),
(9, 4, 89999.99, '2026-09-10 00:44:07'),
(11, 1, 221999.96, '2026-09-10 12:32:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, NULL, 2, 8999.99),
(2, 1, 5, 2, 89999.99),
(3, 1, 1, 3, 129999.99),
(4, 1, 4, 4, 8999.99),
(5, 1, 2, 3, 49999.99),
(6, 1, 3, 1, 32999.99),
(7, 2, 5, 1, 89999.99),
(8, 2, 4, 1, 8999.99),
(9, 2, NULL, 2, 8999.99),
(10, 3, NULL, 1, 8999.99),
(11, 3, 5, 1, 89999.99),
(12, 3, 4, 1, 8999.99),
(13, 4, 5, 1, 89999.99),
(14, 4, 4, 1, 8999.99),
(15, 5, 5, 1, 89999.99),
(16, 5, 1, 1, 129999.99),
(17, 6, 5, 1, 89999.99),
(18, 7, 5, 1, 89999.99),
(19, 8, 5, 1, 89999.99),
(20, 9, 5, 1, 89999.99),
(21, 11, 5, 2, 89999.99),
(22, 11, 4, 1, 8999.99),
(23, 11, 3, 1, 32999.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `image`) VALUES
(1, 'ASUS TUF Gaming Laptop', 'Gaming laptop sa Ryzen procesorom i RTX grafičkom karticom.', 129999.99, 1, 'asus-laptop.jpg'),
(2, 'RTX 4060', 'NVIDIA GeForce RTX 4060 grafička kartica.', 49999.99, 3, 'rtx4060.jpg'),
(3, 'Samsung Odyssey G5', 'Gaming monitor 27 inča, 144Hz.', 32999.99, 4, 'samsung-monitor.jpg'),
(4, 'Logitech G Pro Mouse', 'Gaming miš visokih performansi.', 8999.99, 5, 'logitech-mouse.jpg'),
(5, 'Samsung Galaxy S24', 'Pametni telefon najnovije generacije.', 89999.99, 1, 'samsung-s24.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Aleksa', 'inflammablehd@gmail.com', '$2y$10$GnwL0VaJYLCDyLtewWX7jOzr4T3tFRMyNoJE4EIGCHWLQzpc79nVq', 'user', '2026-09-09 18:55:58'),
(2, 'admin', 'admin@techshop.com', '$2y$10$6zxNxG2CIzSnUiMA/.QsQOJB2d..LP/IuXkP6N.cYTtPnvSccLTQa', 'admin', '2026-09-09 19:31:35'),
(3, 'Marko', 'marko@gmail.com', '$2y$10$DsjluuUt55yupIIPtdtGpeYMWbru.A6QMFJ29IbQXQRHIp1FdH8Tm', 'user', '2026-09-10 00:11:19'),
(4, 'Dusan', 'dusan@gmail.com', '$2y$10$FUcifOnRMTwsb.duvg4JeeuFD41cgTObB7N3G1vUpNQmT/SCeMW16', 'user', '2026-09-10 00:43:43'),
(5, 'Aya', 'ayanf071@gmail.com', '$2y$10$fzIKCbBFwI.23srUJ7o7c..6AVss9myNhWVlLq3usy.FUiIKBBehq', 'user', '2026-09-10 00:50:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
