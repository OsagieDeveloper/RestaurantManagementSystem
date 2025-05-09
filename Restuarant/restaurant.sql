-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 10:26 PM
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
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email`, `password`, `created_at`) VALUES
(1, 'admin admin', 'admin@gmail.com', '$2y$10$EXgOeaGi0rm0DjR.3GCZmu7y.WmuzsZekmASbZA2btCvq8N44qpHS', '2025-01-06 18:08:30');

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `inquiry_type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'unread',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_inquiries`
--

INSERT INTO `contact_inquiries` (`id`, `name`, `email`, `inquiry_type`, `message`, `status`, `submitted_at`) VALUES
(1, 'James Doe', 'james@gmail.com', 'private_event', 'This is a special request', 'unread', '2025-01-06 18:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `rating` int(11) NOT NULL,
  `dish_review` text DEFAULT NULL,
  `general_feedback` text DEFAULT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'unread',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `name`, `rating`, `dish_review`, `general_feedback`, `status`, `submitted_at`) VALUES
(1, '', 2, '', '', 'unread', '2025-01-06 18:00:28');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_id` varchar(50) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity_on_hand` int(11) NOT NULL,
  `reorder_level` int(11) NOT NULL,
  `supplier_info` text DEFAULT NULL,
  `requested_by` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_id`, `item_name`, `quantity_on_hand`, `reorder_level`, `supplier_info`, `requested_by`, `created_at`, `updated_at`) VALUES
(1, 'item677c23db8ebd7', 'Pepper', 3, 4, '0', '', '2025-01-06 23:41:31', '2025-01-06 23:41:31'),
(2, 'item677c2438709cc', 'Onions', 78, 76, 'West Indies', '', '2025-01-06 23:43:04', '2025-01-06 23:43:04'),
(3, 'item677c2eeb3449e', 'Sausage', 45, 23, 'Georiga', 'Admin', '2025-01-07 00:28:43', '2025-01-07 00:28:43'),
(4, 'item677c316ca98f6', 'Hotdog', 34, 89, 'KFC', 'James Doe', '2025-01-07 00:39:24', '2025-01-07 00:39:24'),
(0, 'item68110c217e803', 'Garri', 10, 5, 'we need more garri for the resturant', 'James Doe', '2025-04-29 18:28:01', '2025-04-29 18:28:01'),
(0, 'item681156705fe77', 'pepper', 10, 5, 'Market', 'James Doe', '2025-04-29 23:45:04', '2025-04-29 23:45:04');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
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
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `table_number` int(11) NOT NULL,
  `items` text NOT NULL,
  `quantities` text NOT NULL,
  `special_requests` text DEFAULT NULL,
  `status` enum('Pending','In Progress','Ready','Completed','Cancelled') DEFAULT 'Pending',
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `table_number`, `items`, `quantities`, `special_requests`, `status`, `payment_amount`, `created_at`, `updated_at`) VALUES
(0, '', 0, '[{\"name\":\"Italian Pizza\",\"price\":7.49,\"quantity\":1}]', '[1]', 'foof', 'Pending', NULL, '2025-04-29 22:30:11', '2025-04-29 22:30:11'),
(0, '', 0, '[{\"name\":\"Burrito Wrap\",\"price\":4.49,\"quantity\":1}]', '[1]', '6yt6yuiiythyho8', 'Pending', NULL, '2025-04-29 22:31:19', '2025-04-29 22:31:19'),
(0, '', 0, '[{\"name\":\"Burrito Wrap\",\"price\":4.49,\"quantity\":1}]', '[1]', 'food', 'Pending', NULL, '2025-04-29 22:40:50', '2025-04-29 22:40:50'),
(0, '', 0, '[{\"name\":\"Beef\",\"price\":90,\"quantity\":1}]', '[1]', 'i like it medium rare', 'Pending', NULL, '2025-05-06 19:00:37', '2025-05-06 19:00:37'),
(0, '', 0, '[{\"name\":\"Beef\",\"price\":90,\"quantity\":1}]', '[1]', 'Fresh meat', 'Pending', NULL, '2025-05-06 20:03:00', '2025-05-06 20:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `reservation_id` varchar(50) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `table_number` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `time_of_event` time NOT NULL,
  `num_guests` int(11) NOT NULL,
  `special_request` text DEFAULT NULL,
  `status` enum('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `reservation_id`, `customer_name`, `table_number`, `date_time`, `time_of_event`, `num_guests`, `special_request`, `status`, `created_at`, `updated_at`) VALUES
(7, 'r677c38448d407', 'Smith Jane', 14, '2025-01-07 00:00:00', '21:05:00', 6, 'No special request', 'Pending', '2025-01-07 01:08:36', '2025-01-07 02:55:29'),
(8, 'r677c386119ed8', 'Smith Jane', 15, '2025-01-07 00:00:00', '21:05:00', 6, 'No special request', 'Cancelled', '2025-01-07 01:09:05', '2025-01-07 02:54:53'),
(9, 'r677c387772583', 'Smith Jane', 18, '2025-01-07 00:00:00', '21:05:00', 6, 'No special request', 'Cancelled', '2025-01-07 01:09:27', '2025-01-07 02:54:53'),
(0, 'r6810f2cc2fd34', 'Nathaniel Preye Amachree', 14, '2025-05-02 00:00:00', '14:00:00', 5, 'I need a window table', 'Pending', '2025-04-29 15:39:56', '2025-04-29 15:39:56'),
(0, 'r6811055994f39', 'Nathaniel Preye Amachree', 15, '2025-05-02 00:00:00', '14:00:00', 5, 'I need a window table', 'Cancelled', '2025-04-29 16:59:05', '2025-05-06 20:18:58'),
(0, 'r681105c573859', 'Kasalk', 14, '2025-04-30 00:00:00', '12:00:00', 3, 'i don\\&#039;t like dairy products', 'Completed', '2025-04-29 17:00:53', '2025-05-06 20:18:53'),
(0, 'r681a6a9caeda0', 'Nathaniel', 14, '2025-05-07 00:00:00', '12:22:00', 3, 'Fresh food', 'Confirmed', '2025-05-06 20:01:32', '2025-05-06 20:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `position`, `email`, `phone`) VALUES
('staff677c0cfed7f7d', 'Sarah Anna', 'Waiter', 'sarah@gmail.com', '1234567'),
('staff677c0d999eed3', 'Jane Jean', 'Receptionist', 'jane@gmail.com', '343434353535');

-- --------------------------------------------------------

--
-- Table structure for table `staff_schedule`
--

CREATE TABLE `staff_schedule` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `shift_start` time NOT NULL,
  `shift_end` time NOT NULL,
  `hours_worked` decimal(5,2) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_schedule`
--

INSERT INTO `staff_schedule` (`id`, `staff_id`, `name`, `position`, `shift_start`, `shift_end`, `hours_worked`, `created_at`, `updated_at`) VALUES
(1, 3, 'James Doe', '', '01:11:00', '06:14:00', 5.00, '2025-01-17', '2025-01-07 05:09:54'),
(0, 3, 'James Doe', '', '17:00:00', '00:00:00', 6.00, '2025-05-07', '2025-05-06 20:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `support_queries`
--

CREATE TABLE `support_queries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Pending','Resolved') DEFAULT 'Pending',
  `created_at` datetime NOT NULL,
  `resolved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_number` varchar(50) NOT NULL,
  `seats` int(11) NOT NULL
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
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `request_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_off_requests`
--

INSERT INTO `time_off_requests` (`id`, `staff_id`, `name`, `position`, `request_date`, `start_date`, `end_date`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'James Doe', '', '2025-01-17', '2025-01-08', '2025-01-23', 'ghe', 'Approved', '2025-01-07 05:21:01', '2025-01-07 05:21:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `position` varchar(200) NOT NULL,
  `role` enum('Customer','Staff','Admin') DEFAULT 'Customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone_number`, `address`, `position`, `role`, `created_at`, `updated_at`) VALUES
(3, 'James Doe', 'james@gmail.com', '$2y$10$EXgOeaGi0rm0DjR.3GCZmu7y.WmuzsZekmASbZA2btCvq8N44qpHS', '1234567', 'London', '', 'Staff', '2025-01-07 00:03:39', '2025-01-07 00:03:39'),
(0, 'Adefuwa Ponmile', 'admin@gmail.com', '$2y$10$KBDIF3rrlN/lVHxj6M4oS.ZFBjw6oPf0eDekQ1U5ZwPdms2gv3XIW', '09091458969', 'lados', '', 'Staff', '2025-04-20 14:06:34', '2025-04-20 14:06:34'),
(0, 'Kasalk', 'allensamanthagamer@gmail.com', '$2y$10$55Q5wsFQdoKiIuO.fsD5tuz9NLcaYnMDmKJ2oXh9MqYDyrJe2UntS', '+9054212833', 'place', '', 'Staff', '2025-04-29 22:57:45', '2025-04-29 22:57:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_queries`
--
ALTER TABLE `support_queries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `support_queries`
--
ALTER TABLE `support_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
