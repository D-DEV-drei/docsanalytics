-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2024 at 03:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dmpar_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_access`
--

CREATE TABLE `fms_g14_access` (
  `id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `folder_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_access`
--

INSERT INTO `fms_g14_access` (`id`, `user_id`, `folder_id`) VALUES
(19, 34, 3),
(20, 34, 5),
(21, 34, 16),
(22, 20, 16),
(23, 12, 3),
(24, 12, 5);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_files`
--

CREATE TABLE `fms_g14_files` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) NOT NULL,
  `folder_id` int(30) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_files`
--

INSERT INTO `fms_g14_files` (`id`, `name`, `description`, `user_id`, `folder_id`, `file_type`, `file_path`, `date_updated`, `active`) VALUES
(61, 'to-do-list', 'To do List', 34, 5, 'docx', '../assets/uploads/to-do-list.docx', '2024-03-30 21:58:06', 0),
(62, 'Maging Sino ka man (1)', 'Try', 12, 3, 'docx', '../assets/uploads/Maging Sino ka man (1).docx', '2024-03-30 22:12:55', 0),
(63, 'm1', 'Trial1', 12, 5, 'jpg', '../assets/uploads/m1.jpg', '2024-03-30 22:26:44', 0);

--
-- Triggers `fms_g14_files`
--
DELIMITER $$
CREATE TRIGGER `after_files_insert` AFTER INSERT ON `fms_g14_files` FOR EACH ROW BEGIN
    -- Insert record into the inbound table
    INSERT INTO fms_g14_inbound (files_id, reason, status) VALUES (NEW.id, 'Added new file', 'Pending');

    -- Generate notification message and insert record into the notifications table
    SET @notification_message = CONCAT('There is a request to upload file');
    INSERT INTO fms_g14_notifications (message, type, status) VALUES (@notification_message, 'inbound', 'unread');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_folder`
--

CREATE TABLE `fms_g14_folder` (
  `id` int(11) NOT NULL,
  `user_id` int(50) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `parent_id` int(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `active` int(11) NOT NULL,
  `is_folder` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_folder`
--

INSERT INTO `fms_g14_folder` (`id`, `user_id`, `file_name`, `parent_id`, `created_at`, `active`, `is_folder`) VALUES
(2, 11, 'Invoices and Corp', 0, '2024-03-30 13:53:31', 0, 0),
(3, 11, 'Driver Management', 0, '2024-03-29 20:35:14', 0, 0),
(4, 11, 'Order Management', 0, '2024-02-19 16:47:50', 0, 0),
(5, 11, 'Carrier Collaboration and Communication', 0, '2024-02-19 16:48:12', 0, 0),
(6, 11, 'Custom Compliance and Documentation', 0, '2024-02-19 16:56:53', 0, 0),
(16, 11, 'dasd', 2, '2024-02-24 02:37:54', 0, 0),
(17, 11, 'sasa', 2, '2024-02-28 16:29:29', 0, 0),
(18, 11, '123', 2, '2024-02-28 16:33:11', 0, 0),
(19, 11, 'Sheesh', 0, '2024-03-29 20:45:28', 1, 0),
(20, 11, 'Renamed', 0, '2024-03-29 20:45:15', 1, 0),
(21, 11, 'Driver Management and Compliance', 0, '2024-03-29 20:45:57', 1, 0),
(22, 11, 'Tryas', 0, '2024-03-29 20:53:01', 1, 0),
(23, 11, 'sadasdd', 0, '2024-03-29 20:55:26', 1, 0),
(24, 11, 'sadsad', 3, '2024-03-29 22:12:42', 0, 0),
(25, 11, 'dadsa', 0, '2024-03-30 13:54:47', 1, 0),
(26, 11, 'dasdasdsadsacsac', 0, '2024-03-29 23:33:35', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_inbound`
--

CREATE TABLE `fms_g14_inbound` (
  `id` int(11) NOT NULL,
  `files_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_inbound`
--

INSERT INTO `fms_g14_inbound` (`id`, `files_id`, `reason`, `status`) VALUES
(55, 61, 'Added new file', 'Accepted'),
(56, 62, 'Added new file', 'Accepted'),
(57, 63, 'Added new file', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_notifications`
--

CREATE TABLE `fms_g14_notifications` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_notifications`
--

INSERT INTO `fms_g14_notifications` (`id`, `message`, `type`, `status`, `created_at`) VALUES
(62, 'There is a request to upload file', 'inbound', 'unread', '2024-03-29 07:18:57'),
(63, 'There is a request to upload file', 'inbound', 'unread', '2024-03-29 07:19:53'),
(64, 'There is a request to upload file', 'inbound', 'unread', '2024-03-29 21:01:20'),
(65, 'There is a request to upload file', 'inbound', 'unread', '2024-03-30 13:58:06'),
(66, 'There is a request to upload file', 'inbound', 'unread', '2024-03-30 14:12:55'),
(67, 'There is a request to upload file', 'inbound', 'unread', '2024-03-30 14:26:44'),
(68, 'alyssa is requesting to access the Maging Sino ka man (1)', 'outbound', 'unread', '2024-03-30 14:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_outbound`
--

CREATE TABLE `fms_g14_outbound` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `files_id` int(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `view` int(255) NOT NULL,
  `download` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_outbound`
--

INSERT INTO `fms_g14_outbound` (`id`, `user_id`, `files_id`, `reason`, `status`, `created_at`, `view`, `download`) VALUES
(19, 12, 62, 'View/Download', 'Accepted', '2024-03-30 14:37:51', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_reports`
--

CREATE TABLE `fms_g14_reports` (
  `id` int(11) NOT NULL,
  `folder_id` int(255) NOT NULL,
  `report_name` varchar(255) NOT NULL,
  `report_description` text DEFAULT NULL,
  `access` int(50) NOT NULL,
  `user` int(50) NOT NULL,
  `download` int(50) NOT NULL,
  `upload` int(50) NOT NULL,
  `include_access` int(255) NOT NULL DEFAULT 0,
  `include_users` int(255) NOT NULL DEFAULT 0,
  `include_downloads` int(255) NOT NULL DEFAULT 0,
  `include_uploads` int(255) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_reports`
--

INSERT INTO `fms_g14_reports` (`id`, `folder_id`, `report_name`, `report_description`, `access`, `user`, `download`, `upload`, `include_access`, `include_users`, `include_downloads`, `include_uploads`, `created_at`) VALUES
(29, 3, 'R1 IPM', 'sdasda', 1, 1, 1, 1, 1, 0, 0, 1, '2024-03-30 14:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_shared_report`
--

CREATE TABLE `fms_g14_shared_report` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_shared_report`
--

INSERT INTO `fms_g14_shared_report` (`id`, `report_id`, `user_id`) VALUES
(8, 29, 34);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_users`
--

CREATE TABLE `fms_g14_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verify_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activate` int(50) NOT NULL,
  `role` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `code` int(255) DEFAULT NULL,
  `expired` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_users`
--

INSERT INTO `fms_g14_users` (`id`, `username`, `email`, `password`, `verify_token`, `created_at`, `activate`, `role`, `image`, `code`, `expired`) VALUES
(11, 'admin', 'treisadiutor@gmail.com', '$2y$10$5p7x96jiYTYxkmT3.FYoMeO3rkogRWP5mfCpwxlWQkoZceDPzSAti', NULL, '2024-03-30 13:51:53', 1, 1, '../assets/uploads/jose.jpg', NULL, NULL),
(12, 'alyssa', 'hello@gmail.com', '$2y$10$/y8SWI4dM8aV/dRlhmtiNuzMQa1sSeJg9WNjyAVe3qWCZoPnu8lnS', NULL, '2024-03-30 04:48:50', 1, 0, '../img/default-img.jpg', 772671, '2024-03-30'),
(20, 'cris', 'cris@gmail.com', '$2y$10$Mk6.rwE8ZM1RAA10FOGMQOpvOK7tbT3Z8.SUR53X.nh6xfDb9oIPi', NULL, '2024-02-20 07:58:43', 1, 0, '../assets/uploads/jose.jpg', NULL, NULL),
(34, 'ryan', 'ryan@gmail.com', '$2y$10$s.1L1nK.iHX/Gi7QfcxtmuRCBKQtqBS4FXVWEFKhE4K1s45CNtlV6', NULL, '2024-02-23 15:47:35', 1, 0, '../img/default-img.jpg', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fms_g14_access`
--
ALTER TABLE `fms_g14_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_folder_id_access` (`folder_id`);

--
-- Indexes for table `fms_g14_files`
--
ALTER TABLE `fms_g14_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g14_folder`
--
ALTER TABLE `fms_g14_folder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g14_inbound`
--
ALTER TABLE `fms_g14_inbound`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inbound_files_id` (`files_id`);

--
-- Indexes for table `fms_g14_notifications`
--
ALTER TABLE `fms_g14_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g14_outbound`
--
ALTER TABLE `fms_g14_outbound`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g14_reports`
--
ALTER TABLE `fms_g14_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folder_id` (`folder_id`);

--
-- Indexes for table `fms_g14_shared_report`
--
ALTER TABLE `fms_g14_shared_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shared_report_report_id` (`report_id`);

--
-- Indexes for table `fms_g14_users`
--
ALTER TABLE `fms_g14_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fms_g14_access`
--
ALTER TABLE `fms_g14_access`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `fms_g14_files`
--
ALTER TABLE `fms_g14_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `fms_g14_folder`
--
ALTER TABLE `fms_g14_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `fms_g14_inbound`
--
ALTER TABLE `fms_g14_inbound`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `fms_g14_notifications`
--
ALTER TABLE `fms_g14_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `fms_g14_outbound`
--
ALTER TABLE `fms_g14_outbound`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `fms_g14_reports`
--
ALTER TABLE `fms_g14_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `fms_g14_shared_report`
--
ALTER TABLE `fms_g14_shared_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fms_g14_users`
--
ALTER TABLE `fms_g14_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fms_g14_access`
--
ALTER TABLE `fms_g14_access`
  ADD CONSTRAINT `fk_folder_id_access` FOREIGN KEY (`folder_id`) REFERENCES `fms_g14_folder` (`id`);

--
-- Constraints for table `fms_g14_inbound`
--
ALTER TABLE `fms_g14_inbound`
  ADD CONSTRAINT `fk_inbound_files_id` FOREIGN KEY (`files_id`) REFERENCES `fms_g14_files` (`id`);

--
-- Constraints for table `fms_g14_reports`
--
ALTER TABLE `fms_g14_reports`
  ADD CONSTRAINT `fms_g14_reports_ibfk_2` FOREIGN KEY (`folder_id`) REFERENCES `fms_g14_folder` (`id`);

--
-- Constraints for table `fms_g14_shared_report`
--
ALTER TABLE `fms_g14_shared_report`
  ADD CONSTRAINT `fk_shared_report_report_id` FOREIGN KEY (`report_id`) REFERENCES `fms_g14_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_file_status` ON SCHEDULE EVERY 1 YEAR STARTS '2025-03-30 06:22:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Update the active column to 1 and status column to 'Expired' for files that are older than one year
    UPDATE fms_g14_files
    SET active = 1,
        status = 'Expired'
    WHERE date_updated < DATE_SUB(NOW(), INTERVAL 1 YEAR);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
