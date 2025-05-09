-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 09:08 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `res`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `full_name` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email`, `password`, `created_at`) VALUES
(1, 'admin admin', 'admin@gmail.com', '$2y$10$EXgOeaGi0rm0DjR.3GCZmu7y.WmuzsZekmASbZA2btCvq8N44qpHS', '2025-01-06 17:08:30');

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `inquiry_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unread',
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_inquiries`
--

INSERT INTO `contact_inquiries` (`id`, `name`, `email`, `inquiry_type`, `message`, `status`, `submitted_at`) VALUES
(1, 'James Doe', 'james@gmail.com', 'private_event', 'This is a special request', 'unread', '2025-01-06 17:45:15'),
(2, 'Adefuwa', 'ponmile@gmail.com', 'private_event', 'hi', 'unread', '2025-05-07 02:16:46'),
(3, 'Adefuwa', 'ponmile@gmail.com', 'custom_dining', 'hello', 'unread', '2025-05-07 02:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `rating` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `dish_review` text COLLATE utf8mb4_general_ci,
  `general_feedback` text COLLATE utf8mb4_general_ci,
  `status` varchar(200) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'unread',
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int NOT NULL,
  `item_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity_on_hand` int NOT NULL,
  `reorder_level` int NOT NULL,
  `supplier_info` text COLLATE utf8mb4_general_ci,
  `requested_by` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_id`, `item_name`, `quantity_on_hand`, `reorder_level`, `supplier_info`, `requested_by`, `created_at`, `updated_at`) VALUES
(1, 'item677c23db8ebd7', 'Pepper', 3, 4, '0', '', '2025-01-06 22:41:31', '2025-01-06 22:41:31'),
(2, 'item677c2438709cc', 'Onions', 78, 76, 'West Indies', '', '2025-01-06 22:43:04', '2025-01-06 22:43:04'),
(3, 'item677c2eeb3449e', 'Sausage', 45, 23, 'Georiga', 'Admin', '2025-01-06 23:28:43', '2025-01-06 23:28:43'),
(4, 'item677c316ca98f6', 'Hotdog', 34, 89, 'KFC', 'James Doe', '2025-01-06 23:39:24', '2025-01-06 23:39:24'),
(5, 'item681ad1e4847b8', 'sv', 2, 9, 'jtyu', 'Admin', '2025-05-07 04:22:12', '2025-05-07 04:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `price`, `description`, `image`) VALUES
('menu681a5aaceb317', 'Beef', '90', 'Japanese wagyu beef', './public/assets/img/menu/menu681a5aaceb317_beef.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `order_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `table_number` int NOT NULL,
  `items` text COLLATE utf8mb4_general_ci NOT NULL,
  `quantities` text COLLATE utf8mb4_general_ci NOT NULL,
  `special_requests` text COLLATE utf8mb4_general_ci,
  `status` enum('Pending','In Progress','Ready','Completed','Cancelled') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `table_number`, `items`, `quantities`, `special_requests`, `status`, `payment_amount`, `created_at`, `updated_at`) VALUES
(0, '', 0, '[{\"name\":\"Italian Pizza\",\"price\":7.49,\"quantity\":1}]', '[1]', 'foof', 'Pending', NULL, '2025-04-29 21:30:11', '2025-04-29 21:30:11'),
(0, '', 0, '[{\"name\":\"Burrito Wrap\",\"price\":4.49,\"quantity\":1}]', '[1]', '6yt6yuiiythyho8', 'Pending', NULL, '2025-04-29 21:31:19', '2025-04-29 21:31:19'),
(0, '', 0, '[{\"name\":\"Burrito Wrap\",\"price\":4.49,\"quantity\":1}]', '[1]', 'food', 'Pending', NULL, '2025-04-29 21:40:50', '2025-04-29 21:40:50'),
(0, '', 0, '[{\"name\":\"Beef\",\"price\":90,\"quantity\":1}]', '[1]', 'i like it medium rare', 'Pending', NULL, '2025-05-06 18:00:37', '2025-05-06 18:00:37'),
(0, '', 0, '[{\"name\":\"Beef\",\"price\":90,\"quantity\":1}]', '[1]', 'Fresh meat', 'Pending', NULL, '2025-05-06 19:03:00', '2025-05-06 19:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `reservation_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `table_number` int NOT NULL,
  `date_time` datetime NOT NULL,
  `time_of_event` time NOT NULL,
  `num_guests` int NOT NULL,
  `special_request` text COLLATE utf8mb4_general_ci,
  `status` enum('Pending','Confirmed','Completed','Cancelled') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `reservation_id`, `customer_name`, `table_number`, `date_time`, `time_of_event`, `num_guests`, `special_request`, `status`, `created_at`, `updated_at`) VALUES
(7, 'r677c38448d407', 'Smith Jane', 14, '2025-01-07 00:00:00', '21:05:00', 6, 'No special request', 'Pending', '2025-01-07 00:08:36', '2025-01-07 01:55:29'),
(8, 'r677c386119ed8', 'Smith Jane', 15, '2025-01-07 00:00:00', '21:05:00', 6, 'No special request', 'Cancelled', '2025-01-07 00:09:05', '2025-01-07 01:54:53'),
(9, 'r677c387772583', 'Smith Jane', 18, '2025-01-07 00:00:00', '21:05:00', 6, 'No special request', 'Cancelled', '2025-01-07 00:09:27', '2025-01-07 01:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `staff_schedule`
--

CREATE TABLE `staff_schedule` (
  `id` int NOT NULL,
  `staff_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `shift_start` time NOT NULL,
  `shift_end` time NOT NULL,
  `hours_worked` decimal(5,2) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_schedule`
--

INSERT INTO `staff_schedule` (`id`, `staff_id`, `name`, `position`, `shift_start`, `shift_end`, `hours_worked`, `created_at`, `updated_at`) VALUES
(1, 3, 'James Doe', '', '01:11:00', '06:14:00', '5.00', '2025-01-17', '2025-01-07 04:09:54'),
(0, 3, 'James Doe', '', '17:00:00', '00:00:00', '6.00', '2025-05-07', '2025-05-06 19:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `support_queries`
--

CREATE TABLE `support_queries` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Resolved') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `created_at` datetime NOT NULL,
  `resolved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int NOT NULL,
  `table_number` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `seats` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `table_number`, `seats`) VALUES
(1, '14', 6),
(2, '15', 6),
(3, '18', 6),
(0, '12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `time_off_requests`
--

CREATE TABLE `time_off_requests` (
  `id` int NOT NULL,
  `staff_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `request_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Approved','Rejected') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_off_requests`
--

INSERT INTO `time_off_requests` (`id`, `staff_id`, `name`, `position`, `request_date`, `start_date`, `end_date`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'James Doe', '', '2025-01-17', '2025-01-08', '2025-01-23', 'ghe', 'Approved', '2025-01-07 04:21:01', '2025-01-07 04:21:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `staff_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `position` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('Customer','Staff','Admin') COLLATE utf8mb4_general_ci DEFAULT 'Customer',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `staff_id`, `full_name`, `email`, `password`, `phone_number`, `address`, `position`, `role`, `created_at`, `updated_at`) VALUES
(3, '', 'James Doe', 'james@gmail.com', '$2y$10$EXgOeaGi0rm0DjR.3GCZmu7y.WmuzsZekmASbZA2btCvq8N44qpHS', '1234567', 'London', '', 'Staff', '2025-01-06 23:03:39', '2025-01-06 23:03:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_queries`
--
ALTER TABLE `support_queries`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `support_queries`
--
ALTER TABLE `support_queries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
