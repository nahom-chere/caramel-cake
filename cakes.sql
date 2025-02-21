-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 10, 2025 at 12:49 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cakes`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cart_id`),
  KEY `product_id` (`product_id`),
  KEY `idx_cart_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 150.00, 'pending', '2025-02-09 16:55:16', '2025-02-09 16:55:16'),
(2, 1, 525.00, 'pending', '2025-02-09 17:22:36', '2025-02-09 17:22:36'),
(3, 4, 70.00, 'pending', '2025-02-09 19:13:06', '2025-02-09 19:13:06'),
(4, 4, 70.00, 'pending', '2025-02-09 19:14:52', '2025-02-09 19:14:52'),
(5, 2, 75.00, 'pending', '2025-02-09 19:16:34', '2025-02-09 19:16:34'),
(6, 2, 210.00, 'pending', '2025-02-09 20:04:41', '2025-02-09 20:04:41'),
(7, 2, 75.00, 'pending', '2025-02-09 20:06:57', '2025-02-09 20:06:57'),
(8, 2, 70.00, 'pending', '2025-02-09 20:07:35', '2025-02-09 20:07:35'),
(9, 2, 140.00, 'pending', '2025-02-09 20:08:11', '2025-02-09 20:08:11'),
(10, 2, 80.00, 'pending', '2025-02-09 20:08:32', '2025-02-09 20:08:32'),
(11, 2, 75.00, 'pending', '2025-02-09 20:18:14', '2025-02-09 20:18:14'),
(12, 2, 59.00, 'pending', '2025-02-09 22:04:41', '2025-02-09 22:04:41'),
(13, 2, 75.00, 'pending', '2025-02-10 00:10:22', '2025-02-10 00:10:22'),
(14, 2, 70.00, 'pending', '2025-02-10 00:23:18', '2025-02-10 00:23:18'),
(15, 2, 150.00, 'pending', '2025-02-10 00:55:47', '2025-02-10 00:55:47'),
(16, 2, 65.00, 'pending', '2025-02-10 00:56:16', '2025-02-10 00:56:16'),
(17, 2, 70.00, 'pending', '2025-02-10 01:14:27', '2025-02-10 01:14:27'),
(18, 7, 145.00, 'pending', '2025-02-10 06:00:58', '2025-02-10 06:00:58'),
(19, 9, 145.00, 'pending', '2025-02-10 06:41:08', '2025-02-10 06:41:08');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`item_id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `item_name`, `price`, `quantity`) VALUES
(1, 1, 2, 'Vanilla Cream Cake', 75.00, 2),
(2, 2, 5, 'Boxegna', 70.00, 2),
(3, 2, 1, 'Chocolate Fudge Cake', 80.00, 2),
(4, 2, 2, 'Vanilla Cream Cake', 75.00, 3),
(5, 3, 3, 'Red Velvet Cake', 70.00, 1),
(6, 4, 3, 'Red Velvet Cake', 70.00, 1),
(7, 5, 2, 'Vanilla Cream Cake', 75.00, 1),
(8, 6, 3, 'Red Velvet Cake', 70.00, 3),
(9, 7, 2, 'Vanilla Cream Cake', 75.00, 1),
(10, 8, 3, 'Red Velvet Cake', 70.00, 1),
(11, 9, 5, 'Boxegna', 70.00, 2),
(12, 10, 1, 'Chocolate Fudge Cake', 80.00, 1),
(13, 11, 2, 'Vanilla Cream Cake', 75.00, 1),
(15, 13, 2, 'Vanilla Cream Cake', 75.00, 1),
(16, 14, 3, 'Red Velvet Cake', 70.00, 1),
(17, 15, 2, 'Vanilla Cream Cake', 75.00, 2),
(18, 16, 5, 'Bomboloni', 65.00, 1),
(19, 17, 3, 'Red Velvet Cake', 70.00, 1),
(20, 18, 2, 'Vanilla Cream Cake', 75.00, 1),
(21, 18, 3, 'Red Velvet Cake', 70.00, 1),
(22, 19, 1, 'Chocolate Fudge Cake', 80.00, 1),
(23, 19, 5, 'Bomboloni', 65.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `image_url`, `stock`, `created_at`) VALUES
(1, 'Chocolate Fudge Cake', 'Rich and moist chocolate fudge cake.', 80.00, 'd.jpg', 46, '2025-02-09 10:19:31'),
(2, 'Vanilla Cream Cake', 'Light and fluffy vanilla cake with creamy frosting.', 75.00, 'v.jpg', 38, '2025-02-09 10:19:31'),
(3, 'Red Velvet Cake', 'Decadent red velvet cake with cream cheese frosting.', 70.00, 'z.jpg', 41, '2025-02-09 10:19:31'),
(4, 'Donut', 'Donut overlayed with Caramel.', 85.00, 'h.jpg', 100, '2025-02-09 10:19:31'),
(5, 'Bomboloni', 'Bomboloni has a homemade filling ', 65.00, 'b.jpg', 54, '2025-02-09 10:19:31'),
(6, 'Bread', 'Bread covered with sprinkled seed.', 70.00, 'j.jpg', 100, '2025-02-09 10:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('user','admin') COLLATE utf8mb4_general_ci DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'nahom', 'abc@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-02-09 16:47:09', 'admin'),
(2, 'elroi', '123@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-02-09 19:07:37', 'user'),
(3, 'abc', 'nnn@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-02-09 19:10:44', 'user'),
(4, 'hhh', 'hhh@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-02-09 19:11:34', 'user'),
(5, 'lidu', 'lidu@asf.asdf', '$2y$10$OgxiMDIrYbhGKVRnG24V3edFxYuBIkAn3HcXpNKJ7NDN.Vxz6liym', '2025-02-09 22:15:16', 'user'),
(6, 'miki', 'miki@gmail.com', '$2y$10$rawrGkNi4r9CqTUIfbXQm.aBKnKJ7JvIX2pwKa.s2czrEn89D8bfW', '2025-02-09 22:15:29', 'user'),
(7, 'a', 'a@gmai.com', 'c4ca4238a0b923820dcc509a6f75849b', '2025-02-10 05:59:27', 'user'),
(8, 'roi', '12@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-02-10 06:03:09', 'user'),
(9, 'eee', 'eee@gmail.com', '202cb962ac59075b964b07152d234b70', '2025-02-10 06:39:59', 'user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
