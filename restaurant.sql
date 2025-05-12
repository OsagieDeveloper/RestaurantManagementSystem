-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 07:14 PM
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
(1, 'admin admin', 'admin@gmail.com', '$2y$10$EXgOeaGi0rm0DjR.3GCZmu7y.WmuzsZekmASbZA2btCvq8N44qpHS', '2025-01-06 16:08:30');

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

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `m_id` int(11) NOT NULL,
  `id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`m_id`, `id`, `name`, `type`, `price`, `description`, `image`) VALUES
(1, 'menu681fe958ee674', 'Fried Chicken', 'appetizers', '12000', 'This is a fried chicken', './public/assets/img/menu/menu681fe958ee674_photo-1551024601-bec78aea704b.jpg'),
(2, 'menu682141293bff8', 'Potato', 'dishes', '40', 'Sweet Potatoes', './public/assets/img/menu/menu682141293bff8_download.jpeg'),
(3, 'menu682142cd61ae1', 'Coke', 'drinks', '60', 'Soft Drinks', './public/assets/img/menu/menu682142cd61ae1_Coke-1.5L.png'),
(4, 'menu682144cc6f282', 'Fried Ice Cream Dessert', 'dessert', '30', 'Dessert', './public/assets/img/menu/menu682144cc6f282_download (1).jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` varchar(10) DEFAULT 'food'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reservation_id` varchar(200) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cooking','ready','delivered','cancelled') DEFAULT 'pending',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `reservation_id`, `total`, `status`, `created_at`) VALUES
(1, 8, NULL, 12600.00, 'confirmed', '2025-05-11 01:05:25'),
(2, 8, NULL, 113400.00, 'cooking', '2025-05-11 01:23:23'),
(3, 8, NULL, 126000.00, 'delivered', '2025-05-11 01:24:56'),
(4, 8, NULL, 138600.00, 'pending', '2025-05-11 01:25:57'),
(5, 8, NULL, 12600.00, 'pending', '2025-05-11 09:04:25'),
(7, 6, '1', 12000.00, 'pending', '2025-05-11 16:32:04'),
(9, NULL, NULL, 156.00, '', '2025-05-11 19:27:34'),
(10, NULL, NULL, 899.00, '', '2025-05-11 19:32:19'),
(11, NULL, NULL, 899.00, '', '2025-05-11 19:32:51'),
(12, NULL, NULL, 899.00, '', '2025-05-11 19:33:17'),
(13, NULL, NULL, 3400.00, '', '2025-05-12 06:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  `menu_item_id_n` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_item_id`, `menu_item_id_n`, `quantity`, `price`) VALUES
(18, 1, NULL, 'menu681fe958ee674', 1, 12000.00),
(19, 2, NULL, '0', 9, 12000.00),
(20, 3, NULL, 'menu681fe958ee674', 10, 12000.00),
(21, 4, NULL, 'menu681fe958ee674', 11, 12000.00),
(22, 5, NULL, 'menu681fe958ee674', 1, 12000.00),
(23, 12, 0, 'menu681fe958ee674', 1, 12000.00),
(24, 13, 0, 'menu681fe958ee674', 2, 12000.00),
(25, 13, 0, 'menu682141293bff8', 2, 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `reservation_id` varchar(50) NOT NULL,
  `user_id` int(20) NOT NULL,
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

INSERT INTO `reservations` (`id`, `reservation_id`, `user_id`, `customer_name`, `table_number`, `date_time`, `time_of_event`, `num_guests`, `special_request`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 6, 'Nathaniel', 2, '2025-05-11 16:58:59', '15:58:59', 2, 'nil', 'Pending', '2025-05-11 14:00:00', '2025-05-12 08:40:16');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, '100', 34);

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
(1, 'John Doe', 'james@gmail.com', '', '1782092209', NULL, 'Manager', 'Customer', '2025-05-07 17:48:26', '2025-05-07 17:48:26'),
(2, 'Elizabeth', 'elizabeth@gmail.com', '', '29920902893', NULL, 'waiter', 'Customer', '2025-05-07 17:49:09', '2025-05-07 17:49:09'),
(3, 'James Doe', 'jamesdoe@gmail.com', '$2y$10$VP/PJGFXkadAx0PAxPAKCOx.qZvGH1KKGBDzS33qGDgJ8fZiWHT7G', '898989', 'England', '', 'Staff', '2025-05-07 17:58:47', '2025-05-10 08:26:42'),
(4, 'kasalk', 'kasalk@gmail.com', '$2y$10$Wet8gZTAV8cGLCKrwXHrIufSOUVIDfaiRhCA4p8g65BU/0mmeb9pe', '1234564454', 'ajkldDKk', '', 'Staff', '2025-05-09 13:42:55', '2025-05-09 13:42:55'),
(5, 'Kasalk', 'kasalk@email.com', '$2y$10$FCcc/kLNV2/P0RKloL4YZ.Yh2AG3JmLevrzhGrtahq5ZG904uZpwa', '123456789', 'Abuja', '', 'Customer', '2025-05-09 15:10:13', '2025-05-09 15:10:13'),
(6, 'Kasalk Allen', 'kasalkallen@gmail.com', '$2y$10$.vDQI9a9m33klY8Fca8XueMNaLdKovAxxonue0fJoxnf2OIbJZ1wy', '7389383983', 'Turkey', '', 'Customer', '2025-05-09 15:15:19', '2025-05-09 15:15:19'),
(7, 'kasalk customer', 'kasalkcustomer@gmail.com', '$2y$10$S1Sh5pWuVoeCEdQiNhUmxu5g3TIdM5dmd/YrBoc.W7bGMf5pwwAli', '28332093933', 'norway', '', 'Customer', '2025-05-09 16:27:06', '2025-05-09 16:27:06'),
(8, 'customer', 'customer@gmail.com', '$2y$10$uFAjDZBjHLwfyAaREbe9a.cIo1TsBRdg2X1Z6xyO6krYaSUiLjX8a', '456789', 'India', '', 'Customer', '2025-05-09 20:58:08', '2025-05-10 08:22:18'),
(9, 'Staff Fullname', 'staff@gmail.com', '$2y$10$qXg.CQCJW70kMmh/dUEoGemsiPbi3IqwIURDzWhEgFVze2DtZemDe', '09091458969', 'Lagos', '', 'Staff', '2025-05-12 00:19:37', '2025-05-12 00:19:37'),
(10, 'Adefuwa Oluwaponmile', 'customers@gmail.com', '$2y$10$yyysWSAQAv3aIAEGnNdSUOm53b.UY63xLeHFak2XQFmdFnOyugg7K', '08101646572', 'No 8, Hon ballo', '', 'Customer', '2025-05-12 08:34:57', '2025-05-12 08:34:57');

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
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_schedule`
--
ALTER TABLE `staff_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_queries`
--
ALTER TABLE `support_queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_off_requests`
--
ALTER TABLE `time_off_requests`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_schedule`
--
ALTER TABLE `staff_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_queries`
--
ALTER TABLE `support_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `time_off_requests`
--
ALTER TABLE `time_off_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
