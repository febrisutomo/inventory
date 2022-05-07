-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 07, 2022 at 03:04 PM
-- Server version: 5.7.24
-- PHP Version: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Elektronik', '2022-03-28 17:27:39', '2022-04-01 20:32:52'),
(3, 'Makanan', '2022-03-28 17:27:49', '2022-04-01 20:33:08'),
(15, 'Kesehatan', '2022-03-31 10:35:12', '2022-04-01 20:33:18'),
(16, 'Furniturex', '2022-03-31 10:38:11', '2022-04-02 02:04:54'),
(17, 'Pakaian', '2022-03-31 10:38:57', '2022-04-01 20:33:51'),
(22, 'Alat Tulis Kantor', '2022-04-01 19:04:43', '2022-04-02 02:04:43'),
(24, 'Adminsas', '2022-04-19 07:17:21', '2022-04-19 14:17:21');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Yeo Sosa', '+15088191898', 'Qui molestiae maior', 1, '2022-04-03 10:33:07', '2022-04-19 08:56:33'),
(2, 'Gary Emerson', '1323987281', 'Est quis voluptatem ', 1, '2022-04-03 10:33:28', '2022-04-03 17:33:28'),
(3, 'Yen Estes', '+1 (845) 798-2279', 'Non alias est minus ', 1, '2022-04-03 10:41:48', '2022-04-03 17:41:48'),
(5, 'Cullen Moss', '+1 (105) 838-7275', 'Tenetur voluptates q', 1, '2022-04-04 14:08:30', '2022-04-04 21:08:30'),
(6, 'Lara Aguilar', '+1 (687) 746-2828', 'Consequatur neque au', 0, '2022-04-19 06:36:18', '2022-04-19 13:36:18'),
(7, 'Wang Caldwell', '4547353634', '76 Green Nobel Boulevard', 1, '2022-04-19 07:18:58', '2022-04-19 14:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `buy_price` int(11) NOT NULL,
  `sell_price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `buy_price`, `sell_price`, `stock`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Laptop', 6000000, 6500000, 0, 1, 1, '2022-03-28 17:28:17', '2022-04-19 14:18:17'),
(2, 'Lemari', 2000000, 2300000, 4, 16, 1, '2022-03-28 17:42:18', '2022-05-01 19:43:23'),
(10, 'Televisi', 1000000, 1200000, 122, 1, 1, '2022-03-31 05:52:43', '2022-05-07 21:31:54'),
(11, 'Radio', 250000, 270000, 76, 1, 1, '2022-03-31 05:55:18', '2022-04-04 17:26:05'),
(14, 'Kulkas', 1000000, 1100000, 0, 1, 1, '2022-03-31 05:59:53', '2022-04-04 03:09:04'),
(15, 'Mesin Cuci', 1500000, 1600000, 91, 1, 1, '2022-03-31 06:48:23', '2022-05-01 19:26:47'),
(20, 'Kemeja', 70000, 80000, 93, 17, 1, '2022-04-01 13:37:48', '2022-04-19 08:55:54'),
(21, 'Masker Duckbill', 25000, 300000, 196, 15, 1, '2022-04-01 13:38:15', '2022-05-07 21:31:54'),
(22, 'Vitamin C', 50000, 55000, 150, 15, 0, '2022-04-01 13:38:36', '2022-04-02 02:12:17'),
(23, 'Montana Robles', 42, 100, 61, 16, 0, '2022-04-01 19:12:08', '2022-04-02 02:12:08'),
(24, 'Makanan Lezat', 232, 2323, 23, 3, 1, '2022-04-19 07:16:51', '2022-04-19 14:16:51'),
(25, 'Barang 1', 100000, 120000, 220, 1, 1, '2022-05-07 13:28:27', '2022-05-07 21:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) NOT NULL,
  `supplier_id` bigint(20) DEFAULT NULL,
  `total` int(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `supplier_id`, `total`, `created_at`, `updated_at`) VALUES
(28, 12, 4450000, '2022-04-03 17:14:32', '2022-04-04 00:14:32'),
(29, 10, 3000000, '2022-04-03 19:12:22', '2022-04-04 02:12:22'),
(30, 10, 60000000, '2022-04-03 19:13:30', '2022-04-04 02:13:30'),
(31, 12, 9450000, '2022-04-19 06:34:20', '2022-04-19 13:34:20'),
(32, 12, 33075000, '2022-04-19 07:19:35', '2022-04-19 14:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) NOT NULL,
  `purchase_id` bigint(20) NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `product_name`, `qty`) VALUES
(54, 28, 14, 'Kulkas', 4),
(56, 29, 14, 'Kulkas', 3),
(57, 30, 1, 'Laptop', 10),
(58, 31, 15, 'Mesin Cuci', 3),
(60, 32, 10, 'Televisi', 33),
(61, 32, 21, 'Masker Duckbill', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `total` int(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `total`, `created_at`, `updated_at`) VALUES
(25, 2, 360000000, '2022-04-03 19:16:58', '2022-04-04 02:16:58'),
(26, 3, 11000000, '2022-04-04 10:26:05', '2022-04-04 17:26:05'),
(27, 1, 17750000, '2022-04-04 14:00:44', '2022-04-04 21:00:44'),
(28, 2, 580000, '2022-04-04 14:06:23', '2022-04-04 21:06:23'),
(29, 1, 48000000, '2022-04-04 14:08:07', '2022-04-04 21:08:07'),
(30, 5, 4500000, '2022-04-04 14:10:34', '2022-04-04 21:10:34'),
(31, NULL, 285000, '2022-04-19 01:55:53', '2022-04-19 08:55:53'),
(32, NULL, 4550000, '2022-04-19 06:31:15', '2022-04-19 13:31:15'),
(33, 2, 52500000, '2022-04-19 06:31:50', '2022-04-19 13:31:50'),
(34, 2, 69000000, '2022-04-19 07:18:17', '2022-04-19 14:18:17'),
(35, 5, 4500000, '2022-05-01 12:26:47', '2022-05-01 19:26:47'),
(36, 7, 3250000, '2022-05-07 14:31:53', '2022-05-07 21:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) NOT NULL,
  `sale_id` bigint(20) NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `product_name`, `qty`, `created_at`, `updated_at`) VALUES
(7, 25, 1, 'Laptop', 60, '2022-04-04 03:26:58', '2022-04-04 10:26:58'),
(8, 26, 15, 'Mesin Cuci', 4, '2022-04-04 10:26:05', '2022-04-04 17:26:05'),
(9, 26, 11, 'Radio', 4, '2022-04-04 10:26:05', '2022-04-04 17:26:05'),
(10, 26, 2, 'Lemari', 2, '2022-04-04 10:26:05', '2022-04-04 17:26:05'),
(11, 27, NULL, 'Kipas Angin', 5, '2022-04-04 14:00:44', '2022-04-04 21:00:44'),
(12, 27, 10, 'Televisi', 5, '2022-04-04 14:00:44', '2022-04-04 21:00:44'),
(13, 27, 2, 'Lemari', 6, '2022-04-04 14:00:44', '2022-04-04 21:00:44'),
(14, 28, NULL, 'Kipas Angin', 2, '2022-04-04 14:06:23', '2022-04-04 21:06:23'),
(15, 28, 20, 'Kemeja', 4, '2022-04-04 14:06:23', '2022-04-04 21:06:23'),
(16, 29, 15, 'Mesin Cuci', 32, '2022-04-04 14:08:07', '2022-04-04 21:08:07'),
(17, 30, 15, 'Mesin Cuci', 3, '2022-04-04 14:10:34', '2022-04-04 21:10:34'),
(18, 31, 20, 'Kemeja', 3, '2022-04-19 01:55:54', '2022-04-19 08:55:54'),
(19, 31, 21, 'Masker Duckbill', 3, '2022-04-19 01:55:54', '2022-04-19 08:55:54'),
(20, 32, 15, 'Mesin Cuci', 3, '2022-04-19 06:31:15', '2022-04-19 13:31:15'),
(21, 32, 21, 'Masker Duckbill', 2, '2022-04-19 06:31:15', '2022-04-19 13:31:15'),
(22, 33, 10, 'Televisi', 3, '2022-04-19 06:31:50', '2022-04-19 13:31:50'),
(23, 33, 15, 'Mesin Cuci', 33, '2022-04-19 06:31:50', '2022-04-19 13:31:50'),
(24, 34, 1, 'Laptop', 3, '2022-04-19 07:18:17', '2022-04-19 14:18:17'),
(25, 34, 15, 'Mesin Cuci', 34, '2022-04-19 07:18:17', '2022-04-19 14:18:17'),
(26, 35, 15, 'Mesin Cuci', 3, '2022-05-01 12:26:47', '2022-05-01 19:26:47'),
(27, 36, 10, 'Televisi', 3, '2022-05-07 14:31:54', '2022-05-07 21:31:54'),
(28, 36, 25, 'Barang 1', 2, '2022-05-07 14:31:54', '2022-05-07 21:31:54'),
(29, 36, 21, 'Masker Duckbill', 2, '2022-05-07 14:31:54', '2022-05-07 21:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(10, 'Benedict Bassddd', '2437544957', 'Purwokerto', 1, '2022-03-28 19:27:15', '2022-04-01 20:42:19'),
(12, 'Cristiano Ronaldo', '2437544957', '99 North First Street', 1, '2022-03-31 12:30:51', '2022-04-01 20:44:33'),
(14, 'Lionel Messi', '085870005110', 'Argentina', 1, '2022-04-01 13:44:16', '2022-04-01 20:44:16'),
(15, 'David Beckham', '11323446356', 'London, Inggris', 1, '2022-04-01 13:45:43', '2022-04-01 20:45:43'),
(16, 'Keane Herrera', '33222', 'Ratione suscipit err', 0, '2022-04-01 19:02:45', '2022-04-02 02:02:45'),
(17, 'Quinlan Villarreal', '+1(598)746-6006', 'Quibusdam veritatis ', 0, '2022-04-03 03:19:29', '2022-04-03 10:19:29'),
(18, 'Damian Mullins', '22333333', 'Incididunt maiores f', 1, '2022-04-03 10:29:22', '2022-04-03 17:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pegawai') NOT NULL DEFAULT 'pegawai',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$pia583yoQl25pw8DWls4x.fOHVr0BlK1BYbQ524HsN3J8pU3Mg5fm', 'admin', 1, '2022-03-31 12:38:28', '2022-03-31 19:38:28'),
(2, 'Wang Caldwell', 'zyrexoji@mailinator.com', '$2y$10$.bj8P2LKaNWS3xIIo2VTY.NCcIzxm0aMSj70BrfHLbj1bJMTIizD.', 'pegawai', 0, '2022-03-31 12:43:13', '2022-04-02 00:05:52'),
(3, 'Wang Caldwell', 'gajo@mailinator.com', '$2y$10$rYDZrZPDtPNeKYlaNl5F/.9Ii8do/nEJNkbJESw2.Q5BMyOAdfpEq', 'admin', 0, '2022-04-01 17:04:39', '2022-04-02 00:04:39'),
(4, 'Sacha Anthony', 'sds@gmail.com', '$2y$10$Gf/r/5DipnxPb6b1fF0K3OD5PleqM6.vJdvRz3DcCmR4dmDQE9zOu', 'admin', 1, '2022-04-01 17:07:16', '2022-04-02 00:07:16'),
(5, 'Makanan Lezat', 'aldy@gmail.com', '$2y$10$7BOch87Qwn8nHJu7Q0XYU.3y1kIT1kFkrGdm9Qj6gNg0ZVQIphukq', 'admin', 1, '2022-04-01 17:11:53', '2022-04-02 00:11:53'),
(6, 'Baxter Norton', 'hucaguz@mailinator.com', '$2y$10$Kz8WlHGqwVFHDLWjFeVrW.4v6bS7LywXox80a1ic9y4HjSJ0UhPdO', 'pegawai', 0, '2022-04-01 17:17:01', '2022-04-02 02:00:51'),
(7, 'Leroy Vasquez', 'netikihimu@mailinator.com', '$2y$10$T/gAQu3N6YsG1nj9dJJJ0.D4nnJi5WOE4fBXy45kdyoZaIwDJsP6i', 'pegawai', 0, '2022-04-01 18:58:40', '2022-04-02 01:58:40'),
(8, 'May Flowers', 'qobucimyf@mailinator.com', '$2y$10$nMbpZmDC4sZoGArdoivl1uP4yq3Flr73MgB6z0a.TJQ2Y5iu3tx0y', 'pegawai', 1, '2022-04-01 19:00:30', '2022-04-02 02:00:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incoming_id` (`purchase_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`customer_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incoming_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
