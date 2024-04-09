-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 06, 2024 at 03:05 AM
-- Server version: 10.6.16-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sust_main`
--

-- --------------------------------------------------------

--
-- Table structure for table `ar_internal_metadata`
--

CREATE TABLE `ar_internal_metadata` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `ar_internal_metadata`
--

INSERT INTO `ar_internal_metadata` (`key`, `value`, `created_at`, `updated_at`) VALUES
('environment', 'production', '2024-03-30 01:49:47.591134', '2024-03-30 01:49:47.591138');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_accounts`
--

CREATE TABLE `fms_g11_accounts` (
  `u_id` int(11) NOT NULL,
  `u_username` varchar(250) NOT NULL,
  `u_first_name` varchar(255) NOT NULL,
  `u_last_name` varchar(255) NOT NULL,
  `u_password` varchar(250) NOT NULL,
  `u_isactive` varchar(100) NOT NULL DEFAULT '1',
  `u_email` varchar(256) NOT NULL,
  `u_role` varchar(255) NOT NULL,
  `u_profile_picture` varchar(255) NOT NULL,
  `u_created_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `fms_g11_accounts`
--

INSERT INTO `fms_g11_accounts` (`u_id`, `u_username`, `u_first_name`, `u_last_name`, `u_password`, `u_isactive`, `u_email`, `u_role`, `u_profile_picture`, `u_created_date`) VALUES
(1, 'Matthew', 'Matt', 'Manabat', '$2b$10$uQRhi1vYbYk8p9DoHEUS2OdU7BbfT3Rkf.kUGoj1vCwjDLuFfvIwi', '1', 'ralphmatthewmanabat@gmail.com', 'admin', '', '2024-02-27 02:06:13'),
(2, 'Ralph', 'Ralph Matthew', 'Manabat', '$2b$10$B48va.MNU1DFrXvgVXyo/.WIkGYpbVk8DD58h2.hnU238NwWYhqdm', '1', 'ralphmatthewmanabat@gmail.com', 'admin', 'qisl53c3a7bsjxqhzjpn.png', '2024-02-27 10:59:48'),
(3, 'Ryomen', 'Ryomen', 'Sukuna', '$2b$10$8gGSUrTcJjMEXYa/zQvRnuBeRLQ6IdDh1OHhb2EZXj15Mo124e4RS', '1', 'Ryomen@gmail.com', 'driver', 'rs0et18raqubs2gczqft.avif', '2024-03-04 21:32:25'),
(4, 'Satoru', 'Satoru', 'Gojo', '$2b$10$pVPzO4/e5Y.zP0cT.JQ/PePwBbMhZwUiMpgIqfDfhyXfy9iUu/bzu', '1', 'sensei@gmail.com', 'driver', 'pajido2wn3c1g7satmse.avif', '2024-02-12 17:01:45'),
(5, 'superAdmin', 'Albert', 'Einstein', '$2b$10$SEbieWyVi4/dbmPE7OuemOb3PmVXUS7VoHHOVlyFl8MfwRg2uz9l6', '1', 'superadmin@gmail.com', 'admin', 'qisl53c3a7bsjxqhzjpn.png', '2024-03-04 21:01:01');

--
-- Triggers `fms_g11_accounts`
--
DELIMITER $$
CREATE TRIGGER `insert_admin_access` AFTER INSERT ON `fms_g11_accounts` FOR EACH ROW INSERT INTO fms_g11_accounts_access (a_id, a_u_id, a_admin_board, a_driver_board, a_fuel, a_maintenance, a_tracking, a_admin_chat, a_settings, a_deliveries, a_history, a_driver_chat)
  VALUES (NEW.u_id, NEW.u_id, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_accounts_access`
--

CREATE TABLE `fms_g11_accounts_access` (
  `a_id` int(255) NOT NULL,
  `a_u_id` int(255) NOT NULL,
  `a_admin_board` tinyint(1) NOT NULL,
  `a_driver_board` tinyint(1) NOT NULL,
  `a_fuel` tinyint(1) NOT NULL,
  `a_maintenance` tinyint(1) NOT NULL,
  `a_tracking` tinyint(1) NOT NULL,
  `a_admin_chat` tinyint(1) NOT NULL,
  `a_settings` tinyint(1) NOT NULL,
  `a_deliveries` tinyint(1) NOT NULL,
  `a_history` tinyint(1) NOT NULL,
  `a_driver_chat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g11_accounts_access`
--

INSERT INTO `fms_g11_accounts_access` (`a_id`, `a_u_id`, `a_admin_board`, `a_driver_board`, `a_fuel`, `a_maintenance`, `a_tracking`, `a_admin_chat`, `a_settings`, `a_deliveries`, `a_history`, `a_driver_chat`) VALUES
(1, 1, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0),
(2, 2, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0),
(3, 3, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(4, 4, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(5, 5, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_driver_access`
--

CREATE TABLE `fms_g11_driver_access` (
  `a_id` int(255) NOT NULL,
  `a_u_id` int(255) NOT NULL,
  `a_admin_board` tinyint(1) NOT NULL,
  `a_driver_board` tinyint(1) NOT NULL,
  `a_fuel` tinyint(1) NOT NULL,
  `a_maintenance` tinyint(1) NOT NULL,
  `a_tracking` tinyint(1) NOT NULL,
  `a_admin_chat` tinyint(1) NOT NULL,
  `a_settings` tinyint(1) NOT NULL,
  `a_deliveries` tinyint(1) NOT NULL,
  `a_history` tinyint(1) NOT NULL,
  `a_driver_chat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g11_driver_access`
--

INSERT INTO `fms_g11_driver_access` (`a_id`, `a_u_id`, `a_admin_board`, `a_driver_board`, `a_fuel`, `a_maintenance`, `a_tracking`, `a_admin_chat`, `a_settings`, `a_deliveries`, `a_history`, `a_driver_chat`) VALUES
(1, 1, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(2, 2, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(3, 3, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(4, 4, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(5, 5, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(6, 6, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(7, 7, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(8, 8, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(9, 9, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(10, 10, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(11, 11, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(12, 12, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(13, 13, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(14, 14, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(15, 15, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(16, 16, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(17, 17, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(19, 19, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(20, 20, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(21, 21, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(22, 22, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(23, 23, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(24, 24, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(25, 25, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(26, 26, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(27, 27, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(28, 28, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(29, 29, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1),
(30, 30, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_fuel`
--

CREATE TABLE `fms_g11_fuel` (
  `v_fuel_id` int(10) NOT NULL,
  `v_id` varchar(100) NOT NULL,
  `v_fuel_quantity` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `v_odometerreading` varchar(100) DEFAULT NULL,
  `v_fuelprice` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `v_fuelfilldate` date NOT NULL,
  `v_fueladdedby` varchar(100) NOT NULL,
  `v_fuelcomments` varchar(256) NOT NULL,
  `v_modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `v_created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g11_fuel`
--

INSERT INTO `fms_g11_fuel` (`v_fuel_id`, `v_id`, `v_fuel_quantity`, `v_odometerreading`, `v_fuelprice`, `v_fuelfilldate`, `v_fueladdedby`, `v_fuelcomments`, `v_modified_date`, `v_created_date`) VALUES
(1, 'Scania R730', '200', '12679', '600', '2024-02-11', 'Matt', 'So good', '2024-02-11 02:51:48', '2024-02-11'),
(2, 'DAF XF', '2334', '235465', '1223', '2024-02-07', 'Matt', 'MAhusays', '2024-02-11 03:11:53', '2024-02-11'),
(3, 'Scania R730', '21', '23434', '123', '2024-03-08', 'Ralph', 'hasfs', '2024-03-02 06:46:31', '2024-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_maintenance`
--

CREATE TABLE `fms_g11_maintenance` (
  `m_id` int(255) NOT NULL,
  `m_v_id` varchar(255) NOT NULL,
  `m_start_date` date NOT NULL,
  `m_end_date` date NOT NULL,
  `m_details` varchar(255) NOT NULL,
  `m_cost` int(255) NOT NULL,
  `m_vendor_name` varchar(255) NOT NULL,
  `m_service` varchar(255) NOT NULL,
  `m_status` varchar(255) NOT NULL,
  `v_created_date` date NOT NULL,
  `v_modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g11_maintenance`
--

INSERT INTO `fms_g11_maintenance` (`m_id`, `m_v_id`, `m_start_date`, `m_end_date`, `m_details`, `m_cost`, `m_vendor_name`, `m_service`, `m_status`, `v_created_date`, `v_modified_date`) VALUES
(1, 'Mercedes-Benz Actros', '2024-02-10', '2024-03-01', 'Msadfasccz', 1200, 'Emferyork', 'Headlight/Taillight Bulb Replacement', 'On Hold', '2024-02-11', '2024-03-04 00:00:00'),
(2, 'Kenworth W900', '2024-02-23', '2024-03-02', 'Paki ayos ', 234, 'AHAHAHA', 'Serpentine Belt Replacement', 'Completed', '2024-02-11', '2024-03-05 00:00:00'),
(3, 'Mack Anthem', '2024-02-01', '2024-02-28', 'Galingan pls', 123, 'HAHAh2we23erw', 'Trailer Lighting Inspection/Service', 'Deferred', '2024-02-11', '2024-02-11 02:58:26'),
(4, 'Fuso Super Great', '2024-02-22', '2024-03-20', 'fwergsd', 234, 'sdfasdf', 'Trailer Suspension Inspection/Service', 'Completed', '2024-02-11', '2024-02-11 02:59:21'),
(5, 'Fuso Super Great', '2024-02-08', '2024-02-29', 'Hasdfasd', 234, 'sdf4wdf', 'Windshield Wiper Blade Replacement', 'Scheduled', '2024-02-12', '2024-03-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_message`
--

CREATE TABLE `fms_g11_message` (
  `msg_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `timesent` bigint(255) DEFAULT NULL,
  `prof_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g11_message`
--

INSERT INTO `fms_g11_message` (`msg_id`, `username`, `role`, `message`, `timesent`, `prof_pic`) VALUES
(1, 'Ralph', 'admin', 'Good day!', 1709362062265, 'qisl53c3a7bsjxqhzjpn.png'),
(2, 'Ralph', 'admin', 'Redef', 1709455869161, 'qisl53c3a7bsjxqhzjpn.png'),
(3, 'Ralph', 'admin', 'Redef ang Financial and Frieght', 1709455882641, 'qisl53c3a7bsjxqhzjpn.png'),
(4, 'Ryomen', 'driver', 'sir', 1709455711531, 'viatcjdtvalnpig7tpsd.avif'),
(5, 'Ralph', 'admin', 'Hello, Good Day!', 1709542814303, 'qisl53c3a7bsjxqhzjpn.png'),
(6, 'Ryomen', 'driver', 'Hello good day sir', 1709617124517, 'rs0et18raqubs2gczqft.avif'),
(7, 'Ralph', 'admin', 'Test', 1709617145802, 'qisl53c3a7bsjxqhzjpn.png'),
(8, 'juan01', 'Driver', 'HELLO', 1711432596071, 'yd3m8fsbuhphzsujpt0c.png'),
(9, 'Ralph', 'admin', 'Fhhgg', 1711432773343, 'qisl53c3a7bsjxqhzjpn.png'),
(10, 'Ralph', 'admin', 'Hello', 1711951538347, 'qisl53c3a7bsjxqhzjpn.png');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_notifications`
--

CREATE TABLE `fms_g11_notifications` (
  `n_id` int(255) NOT NULL,
  `n_description` varchar(255) NOT NULL,
  `n_isRead` tinyint(1) NOT NULL DEFAULT 0,
  `n_modified_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g11_notifications`
--

INSERT INTO `fms_g11_notifications` (`n_id`, `n_description`, `n_isRead`, `n_modified_date`) VALUES
(1, 'Delivery in progress, handled by Ryomen. Review details for more info.', 0, '2024-03-12 09:06:04'),
(2, 'Delivery successfully completed by Ryomen. Thank you for your service!', 1, '2024-03-12 09:09:25'),
(3, 'Delivery in progress, handled by Ryomen. Review details for more info.', 0, '2024-03-15 04:48:00'),
(6, 'Delivery successfully completed by Pedro. Thank you for your service!', 1, '2024-03-21 00:55:02'),
(7, 'Delivery in progress, handled by Juan. Review details for more info.', 0, '2024-03-22 04:25:27'),
(8, 'Delivery successfully completed by Juan. Thank you for your service!', 0, '2024-03-22 04:35:47'),
(9, 'Delivery in progress, handled by Juan. Review details for more info.', 1, '2024-03-22 07:57:59'),
(10, 'Delivery successfully completed by Juan. Thank you for your service!', 0, '2024-03-22 08:00:20'),
(11, 'Delivery in progress, handled by Juan. Review details for more info.', 1, '2024-03-22 08:05:04'),
(12, 'Delivery successfully completed by Juanx. Thank you for your service!', 0, '2024-03-26 06:08:47'),
(13, 'Delivery in progress, handled by Pedro. Review details for more info.', 0, '2024-03-27 06:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_positions`
--

CREATE TABLE `fms_g11_positions` (
  `id` int(11) NOT NULL,
  `trip_id` int(255) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `altitude` double DEFAULT NULL,
  `speed` double DEFAULT NULL,
  `heading` double DEFAULT NULL,
  `accuracy` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g11_positions`
--

INSERT INTO `fms_g11_positions` (`id`, `trip_id`, `latitude`, `longitude`, `altitude`, `speed`, `heading`, `accuracy`, `created_date`) VALUES
(1, 4, 14.6440192, 121.0220544, NULL, 0, NULL, 7966, '2024-03-03 11:37:13'),
(2, 3, 14.5988263, 120.9755851, 80.80000305175781, 0, NULL, 15, '2024-04-02 08:37:29'),
(3, 1, 14.516224, 121.1957248, NULL, 0, NULL, 11624, '2024-03-22 04:25:33'),
(4, 5, 14.5988571, 120.9756141, 81, 0.08, NULL, 11, '2024-03-26 06:41:15'),
(5, 2, 14.7266267, 121.0368349, 102.4000015258789, 1.17, 103.9865493774414, 12, '2024-03-22 08:01:29'),
(6, 9, 14.516224, 121.1957248, NULL, 0, NULL, 11624, '2024-03-23 07:35:21'),
(7, 7, 14.7035657, 121.0370165, 101.69999999999999, 9.03, 41.46833801269531, 4, '2024-03-15 04:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_sustainability_data`
--

CREATE TABLE `fms_g11_sustainability_data` (
  `sd_id` int(255) NOT NULL,
  `sd_trip_id` int(255) DEFAULT NULL,
  `sd_fuelcost` varchar(255) DEFAULT NULL,
  `sd_fuelconsumption` varchar(255) DEFAULT NULL,
  `sd_carbon_emission` varchar(255) DEFAULT NULL,
  `sd_rainfall_rate` varchar(255) DEFAULT NULL,
  `sd_current_weather` varchar(255) DEFAULT NULL,
  `sd_air_quality` varchar(255) DEFAULT NULL,
  `sd_wind_speed` varchar(255) DEFAULT NULL,
  `sd_wind_direction` varchar(255) DEFAULT NULL,
  `sd_wind_angle` varchar(255) DEFAULT NULL,
  `sd_temperature` varchar(255) DEFAULT NULL,
  `sd_humidity` varchar(255) DEFAULT NULL,
  `sd_visibility` varchar(255) DEFAULT NULL,
  `sd_uv_index` varchar(255) DEFAULT NULL,
  `sd_solar_radiation` varchar(255) DEFAULT NULL,
  `sd_pressure` varchar(255) DEFAULT NULL,
  `sd_sealevel_pressure` varchar(255) DEFAULT NULL,
  `alerts` varchar(255) DEFAULT NULL,
  `sd_modified_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g11_sustainability_data`
--

INSERT INTO `fms_g11_sustainability_data` (`sd_id`, `sd_trip_id`, `sd_fuelcost`, `sd_fuelconsumption`, `sd_carbon_emission`, `sd_rainfall_rate`, `sd_current_weather`, `sd_air_quality`, `sd_wind_speed`, `sd_wind_direction`, `sd_wind_angle`, `sd_temperature`, `sd_humidity`, `sd_visibility`, `sd_uv_index`, `sd_solar_radiation`, `sd_pressure`, `sd_sealevel_pressure`, `alerts`, `sd_modified_date`) VALUES
(1, 1, '₱47.46', '0.71l', '1083.71g', '0mm/hr', 'Scattered clouds', '74AQI', '5.14m/s', 'east-southeast', '119°', '26.7°C', '56%RH', '16km', '7.48UV Index', '965.1W/m2', '1001.5mb', '1012.49695mb', 'No Current Alerts', '2024-03-22 04:34:52'),
(2, 5, '₱927.41', '13.94l', '43325.24g', '0mm/hr', 'Clear sky', '100AQI', '4.63m/s', 'east-southeast', '116°', '32.8°C', '57%RH', '16km', '8.69UV Index', '904W/m2', '1010.5mb', '1011.63mb', 'No Current Alerts', '2024-03-26 06:07:56'),
(3, 3, '₱42.66', '0.64l', '895.63g', '0mm/hr', 'Clear sky', '29AQI', '3.6m/s', 'east-southeast', '103°', '28.9°C', '66%RH', '16km', '2.30UV Index', '227.9W/m2', '1008mb', '1010.41724mb', 'No Current Alerts', '2024-04-01 23:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g11_trips`
--

CREATE TABLE `fms_g11_trips` (
  `t_id` int(11) NOT NULL,
  `t_start_date` date NOT NULL,
  `t_end_date` date NOT NULL,
  `t_trip_fromlocation` varchar(100) NOT NULL,
  `t_trip_tolocation` varchar(100) NOT NULL,
  `t_trip_fromlat` double DEFAULT NULL,
  `t_trip_fromlog` double DEFAULT NULL,
  `t_trip_tolat` double DEFAULT NULL,
  `t_trip_tolog` double DEFAULT NULL,
  `t_driver` int(255) NOT NULL,
  `t_vehicle` varchar(255) NOT NULL,
  `t_totalweight` int(255) NOT NULL,
  `t_totaldistance` double DEFAULT NULL,
  `t_totaldrivetime` varchar(255) DEFAULT NULL,
  `t_trip_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `t_picture` varchar(255) NOT NULL DEFAULT 'N/A',
  `t_reason` varchar(255) NOT NULL DEFAULT 'N/A',
  `t_remarks` varchar(255) NOT NULL DEFAULT 'N/A',
  `t_trackingcode` varchar(100) DEFAULT NULL,
  `t_created_by` varchar(100) NOT NULL,
  `t_created_date` datetime NOT NULL,
  `t_modified_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `fms_g11_trips`
--

INSERT INTO `fms_g11_trips` (`t_id`, `t_start_date`, `t_end_date`, `t_trip_fromlocation`, `t_trip_tolocation`, `t_trip_fromlat`, `t_trip_fromlog`, `t_trip_tolat`, `t_trip_tolog`, `t_driver`, `t_vehicle`, `t_totalweight`, `t_totaldistance`, `t_totaldrivetime`, `t_trip_status`, `t_picture`, `t_reason`, `t_remarks`, `t_trackingcode`, `t_created_by`, `t_created_date`, `t_modified_date`) VALUES
(1, '2024-01-05', '2024-01-08', 'P2GP+MVG, Topaz, Novaliches, Quezon City, Metro Manila', 'Andres Soriano Avenue Barangay 655, Manila.', 14.726582928426808, 121.03666348624142, 14.592171720661497, 120.97251356426898, 1, 'Mercedes-Benz Actros', 435, 15.39739574298, '0h 43m', 'Completed', 'rkp805kndp8xlkiktl18.jpg', 'null', 'The trip was smooth, has no problem at all.', 'BN1jb0mU', 'Admin', '2024-01-05 09:38:47', '2024-03-22 04:35:43'),
(2, '2024-02-07', '2024-02-10', 'Andres Soriano Avenue Barangay 655, Manila.', '150 D. Aquino St, Grace Park West, Caloocan, 1406 Metro Manila', 14.592171720661497, 120.97251356426898, 14.6483901, 120.9769461, 1, 'Iveco Stralis', 570, 5.848659416509999, '0h 21m', 'Pending', 'N/A', 'null', 'N/A', 'FjTaF39k', 'Ralph', '2024-02-07 02:42:54', '2024-03-29 09:57:58'),
(3, '2024-03-17', '2024-03-21', 'Andres Soriano Avenue Barangay 655, Manila', 'BLK 15 LOT 1, BRIÑAS CORNER BANZON ST, BF Resort Dr, Las Piñas, 1747 Metro Manila', 14.592171720661497, 120.97251356426898, 14.4256336, 120.9867445, 2, 'Freightliner Cascadia', 400, 14.45600900832, '0h 40m', 'In Progress', 'N/A', 'N/A', 'N/A', 'QwErTy', 'Ralph', '2024-02-07 03:30:14', '2024-04-04 02:44:36'),
(4, '2024-04-14', '2024-04-17', 'Andres Soriano Avenue Barangay 655, Manila', 'Silangan Warehousing, Calamba, 4027 Laguna', 14.592171720661497, 120.97251356426898, 14.2303719, 121.1187231, 2, 'Western Star 4900', 250, 29.68932081814, '0h 59m', 'Pending', 'N/A', 'N/A', 'N/A', 'SJasfQ3S8', 'ralph', '2024-02-14 11:10:42', '2024-04-01 03:08:38'),
(5, '2024-05-20', '2024-05-23', 'Andres Soriano Avenue Barangay 655, Manila', '5 Daisy Panacal Vill. P.C. 3500, Tuguegarao City, Cagayan', 14.592171720661497, 120.97251356426898, 17.6022249, 121.6770585, 1, 'Fuso Super Great', 890, 300.86550915247, '8h 20m', 'Completed', 'ugm6ap2qr0fdrykqexhm.jpg', 'null', 'Completed', 'Asf35J7', 'Ralph', '2024-02-14 11:10:42', '2024-03-26 06:08:37'),
(6, '2024-03-10', '2024-03-15', 'Andres Soriano Avenue Barangay 655, Manila', '150 D. Aquino St, Grace Park West, Caloocan, 1406 Metro Manila', 14.592171720661497, 120.97251356426898, 14.6483901, 120.9769461, 3, 'Ford Ranger', 400, 0, NULL, 'Pending', 'N/A', 'N/A', 'N/A', 'KJ9df6Rt', 'Admin', '2024-03-10 09:25:12', '2024-03-16 05:31:06'),
(7, '2024-04-05', '2024-04-10', 'Andres Soriano Avenue Barangay 655, Manila', 'BLK 15 LOT 1, BRIÑAS CORNER BANZON ST, BF Resort Dr, Las Piñas, 1747 Metro Manila', 14.592171720661497, 120.97251356426898, 14.4256336, 120.9867445, 4, 'Mitsubishi L300', 300, 14.45666952463, '0h 42m', 'Pending', 'N/A', 'N/A', 'N/A', 'FG5jk8Lp', 'Admin', '2024-04-05 11:38:22', '2024-03-22 04:11:02'),
(8, '2024-06-12', '2024-06-17', 'Andres Soriano Avenue Barangay 655, Manila', 'Silangan Warehousing, Calamba, 4027 Laguna', 14.592171720661497, 120.97251356426898, 14.2303719, 121.1187231, 3, 'Isuzu Elf', 350, 0, NULL, 'Pending', 'N/A', 'N/A', 'N/A', 'TR4sd2Hg', 'Admin', '2024-06-12 14:55:00', '2024-03-16 05:31:22'),
(9, '2024-07-20', '2024-07-25', 'Andres Soriano Avenue Barangay 655, Manila', '5 Daisy Panacal Vill. P.C. 3500, Tuguegarao City, Cagayan', 14.592171720661497, 120.97251356426898, 17.6022249, 121.6770585, 3, 'Hino 700', 500, 300.86548989, '8h 31m', 'Pending', 'N/A', 'N/A', 'N/A', 'OP7gh3Bv', 'Admin', '2024-07-20 16:42:10', '2024-03-16 05:31:25'),
(10, '2024-08-15', '2024-08-20', 'Andres Soriano Avenue Barangay 655, Manila', '150 D. Aquino St, Grace Park West, Caloocan, 1406 Metro Manila', 14.592171720661497, 120.97251356426898, 14.6483901, 120.9769461, 4, 'Foton Tornado', 450, 0, NULL, 'Pending', 'N/A', 'N/A', 'N/A', 'YU6rf9Nm', 'Admin', '2024-08-15 09:18:30', '2024-03-16 05:31:14'),
(11, '2024-09-10', '2024-09-15', 'Andres Soriano Avenue Barangay 655, Manila', 'BLK 15 LOT 1, BRIÑAS CORNER BANZON ST, BF Resort Dr, Las Piñas, 1747 Metro Manila', 14.592171720661497, 120.97251356426898, 14.4256336, 120.9867445, 4, 'Hyundai H-100', 320, 14.455990988589999, '0h 42m', 'Pending', 'N/A', 'N/A', 'N/A', 'LK3vb4Vn', 'Admin', '2024-09-10 11:35:45', '2024-03-16 05:31:28'),
(16, '2024-12-12', '2024-04-03', 'Andres Soriano Avenue Brgy 655, Manila', 'Hub A Somewhere', 14.592171669006348, 120.9725112915039, 14.592171669006348, 120.9725112915039, 1, 'truck', 100, 100, NULL, 'Pending', 'N/A', 'N/A', 'N/A', 'sh0402202401', 'test@example.com', '2024-04-02 19:03:17', '2024-04-02 19:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g12_compliance`
--

CREATE TABLE `fms_g12_compliance` (
  `id` int(11) NOT NULL,
  `d_driver_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `status` tinyint(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g12_compliance`
--

INSERT INTO `fms_g12_compliance` (`id`, `d_driver_id`, `description`, `from`, `status`, `created_at`, `updated_at`) VALUES
(112, 1, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 1, '2024-03-21 12:11:52', '2024-03-22 07:53:35'),
(113, 1, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 1, '2024-03-21 12:12:18', '2024-03-22 07:58:54'),
(114, 2, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:19', '2024-03-21 12:12:19'),
(115, 3, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:19', '2024-03-21 12:12:19'),
(116, 4, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:19', '2024-03-21 12:12:19'),
(117, 5, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:19', '2024-03-21 12:12:19'),
(118, 6, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:19', '2024-03-21 12:12:19'),
(119, 7, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:19', '2024-03-21 12:12:19'),
(120, 8, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:19', '2024-03-21 12:12:19'),
(121, 9, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:19', '2024-03-21 12:12:19'),
(122, 10, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(123, 11, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(124, 12, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(125, 13, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(126, 14, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 1, '2024-03-21 12:12:20', '2024-03-22 08:12:04'),
(127, 15, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(128, 16, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(129, 17, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(130, 18, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(131, 19, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20');
INSERT INTO `fms_g12_compliance` (`id`, `d_driver_id`, `description`, `from`, `status`, `created_at`, `updated_at`) VALUES
(132, 20, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(133, 21, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(134, 22, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(135, 23, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(136, 24, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(137, 31, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-21 12:12:20', '2024-03-21 12:12:20'),
(138, 30, '<p>Dear [Driver\'s Name], Subject: Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with [Your Company Name]. Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of [Your Company Name], you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 0, '2024-03-28 14:32:10', '2024-03-28 14:32:10'),
(139, 30, '<p>Compliance Reminder We hope this letter finds you well. As part of our ongoing commitment to safety and regulatory compliance, we would like to bring to your attention certain requirements and expectations that pertain to your role as a driver with . Licensing and Certification: It is imperative that you maintain a valid driver\'s license and any additional certifications required for the type of vehicle(s) you operate. Please ensure that all necessary documents are up to date and readily accessible while on duty. Vehicle Inspection and Maintenance: Your responsibility includes conducting routine inspections of the vehicle(s) assigned to you to ensure they are in proper working condition. Any issues or concerns regarding vehicle maintenance should be promptly reported to the appropriate personnel for resolution. Compliance with Traffic Laws and Regulations: As a representative of , you are expected to adhere strictly to all traffic laws and regulations while operating a company vehicle. This includes but is not limited to obeying speed limits, traffic signals, and signage. Hours of Service: Compliance with hours of service regulations is essential for your safety and the safety of others on the road. Please ensure that you adhere to the prescribed hours of service limits and accurately record your hours as required by law. Drug and Alcohol Policy: [Your Company Name] maintains a zero-tolerance policy regarding the use of drugs and alcohol while on duty. You are required to abstain from the use of any substances that may impair your ability to operate a vehicle safely. Customer Service and Professionalism: We expect all our drivers to conduct themselves with professionalism and courtesy when interacting with customers and the public. Your behavior reflects directly on our company\'s reputation, and we trust you will represent us admirably. Please review the above points carefully and ensure full compliance with all applicable regulations and company policies. Should you have any questions or require further clarification on any matter, please do not hesitate to reach out to your supervisor or the HR department. Thank you for your attention to these matters. Your dedication to safety and compliance is greatly appreciated and crucial to the success of our operations. Sincerely,</p>', NULL, 1, '2024-03-28 14:33:02', '2024-03-28 14:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g12_drivers`
--

CREATE TABLE `fms_g12_drivers` (
  `d_id` int(255) NOT NULL,
  `d_email` varchar(255) DEFAULT NULL,
  `d_username` varchar(255) DEFAULT NULL,
  `d_password` varchar(255) DEFAULT NULL,
  `d_first_name` varchar(100) NOT NULL,
  `d_last_name` varchar(100) NOT NULL,
  `d_mobile` varchar(15) NOT NULL,
  `d_address` varchar(250) NOT NULL,
  `d_age` int(11) NOT NULL,
  `d_gender` varchar(10) NOT NULL,
  `d_licenseno` varchar(100) NOT NULL,
  `d_license_expdate` date NOT NULL,
  `d_total_exp` int(11) DEFAULT NULL,
  `d_doj` date NOT NULL,
  `d_ref` varchar(256) DEFAULT NULL,
  `d_is_active` int(11) NOT NULL DEFAULT 1,
  `d_picture` varchar(255) DEFAULT 'yd3m8fsbuhphzsujpt0c.png',
  `d_created_by` varchar(100) NOT NULL,
  `d_created_date` datetime NOT NULL,
  `d_modified_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `d_is_read` tinyint(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `fms_g12_drivers`
--

INSERT INTO `fms_g12_drivers` (`d_id`, `d_email`, `d_username`, `d_password`, `d_first_name`, `d_last_name`, `d_mobile`, `d_address`, `d_age`, `d_gender`, `d_licenseno`, `d_license_expdate`, `d_total_exp`, `d_doj`, `d_ref`, `d_is_active`, `d_picture`, `d_created_by`, `d_created_date`, `d_modified_date`, `d_is_read`) VALUES
(1, 'juan@gmail.com', 'juan01', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Juanx', 'Dela Cruz', '09171234567', '123 P. Burgos St, Manila', 35, 'male', 'PH123456', '2025-05-15', 10, '2020-01-01', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-25 16:22:14', 0),
(2, 'pedro_reyes@gmail.com', 'pedroreyes', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Pedro', 'Reyes', '09393456789', '789 Roxas Blvd, Pasay City', 42, 'Male', 'PH789012', '2023-12-31', 15, '2010-08-15', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(3, 'francisco@gmail.com', 'francisco', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Francisco', 'Torres', '09656789012', '303 Ortigas Ave, Pasig City', 45, 'Male', 'PH222333', '2024-09-10', 20, '2004-02-28', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(4, 'ramon@gmail.com', 'ramon1', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Ramon', 'Cruz', '09838901234', '505 Aurora Blvd, Quezon City', 29, 'Male', 'PH999000', '2026-03-20', 7, '2017-09-30', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(5, 'carlo@gmail.com', 'carlo1', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Carlos', 'Ramos', '09110234567', '707 Boni Ave, Mandaluyong City', 31, 'Male', 'PH444555', '2024-06-08', 9, '2019-01-03', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(6, 'antonio1@gmail.com', 'antonio', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Antonio', 'Lopez', '09392456789', '909 JP Rizal St, Makati City', 36, 'Male', 'PH333222', '2026-01-10', 11, '2016-04-08', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(7, 'jose@gmail.com', 'jose01', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Jose', 'Cruz', '09574678901', '1111 Marcos Highway, Antipolo City', 34, 'Male', 'PH555444', '2024-04-05', 12, '2013-08-30', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(8, 'felipe@gmail.com', 'felipe1', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Felipe', 'Cruz', '09939012345', '1515 Aurora Blvd, Quezon City', 41, 'Male', 'PH888999', '2023-10-10', 14, '2012-09-15', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(9, 'salvador@gmail.com', 'salvador', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Salvador', 'Reyes', '09120123456', '1616 White Plains, Quezon City', 28, 'Male', 'PH222333', '2026-05-25', 8, '2018-04-20', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(10, 'ricardo@gmail.com', 'ricardo', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Ricardo', 'Gonzales', '09231234567', '1717 Katipunan Ave, Quezon City', 35, 'Male', 'PH666777', '2025-09-30', 11, '2017-10-10', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(11, 'alberto@gmail.com', 'alberto', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Alberto', 'Santos', '09342345678', '1818 Tomas Morato Ave, Quezon City', 39, 'Male', 'PH777888', '2024-08-15', 13, '2011-12-20', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(12, 'miguel@gmail.com', 'miguel', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Miguel', 'Reyes', '09453456789', '1919 Shaw Blvd, Mandaluyong City', 33, 'Male', 'PH999111', '2025-07-20', 10, '2018-02-25', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(13, 'juanito@gmail.com', 'juanito', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Juanito', 'Cruz', '09564567890', '2020 E. Rodriguez Sr. Ave, Quezon City', 37, 'Male', 'PH222111', '2026-06-05', 9, '2019-05-10', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(14, 'pedrito@gmail.com', 'pedrito', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Pedrito', 'Torres', '09675678901', '2121 Aurora Blvd, Quezon City', 32, 'Male', 'PH888222', '2025-11-30', 8, '2017-08-10', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(15, 'andres@gmail.com', 'andres', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Andres', 'Garcia', '09786789012', '2222 P. Tuazon, Quezon City', 40, 'Male', 'PH555333', '2024-10-25', 15, '2009-07-15', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(16, 'diego@gmail.com', 'diego1', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Diego', 'Santos', '09897890123', '2323 N. Domingo St, San Juan City', 38, 'Male', 'PH777222', '2023-12-05', 12, '2014-09-10', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(17, 'feliciano@gmail.com', 'feliciano', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Feliciano', 'Reyes', '09908901234', '2424 Araneta Ave, Quezon City', 36, 'Male', 'PH999444', '2025-05-10', 11, '2016-04-20', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(18, 'fernardi@gmail.com', 'fernardi', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Fernando', 'Torres', '09110987654', '2525 Boni Ave, Mandaluyong City', 42, 'Male', 'PH888555', '2023-07-05', 14, '2013-06-30', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(19, 'benjamin@gmail.com', 'benjamin', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Benjamin', 'Garcia', '09221098765', '2626 EDSA, Mandaluyong City', 31, 'Male', 'PH666555', '2026-02-20', 10, '2018-11-25', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(20, 'josefino@gmail.com', 'josefino', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Josefino', 'Santos', '09332109876', '2727 Ortigas Ave, Pasig City', 39, 'Male', 'PH555666', '2025-09-15', 13, '2012-08-10', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(21, 'santiago@gmail.com', 'santiago', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Santiago', 'Reyes', '09443210987', '2828 Aurora Blvd, Quezon City', 34, 'Male', 'PH777666', '2024-04-20', 12, '2013-03-25', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(22, 'antonio@gmail.com', 'antonio2', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Antonio', 'Torres', '09554321098', '2929 Shaw Blvd, Mandaluyong City', 43, 'Male', 'PH999777', '2023-11-15', 16, '2008-10-20', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(23, 'rodrigo@gmail.com', 'rodrigo', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Rodrigo', 'Santos', '09665432109', '3030 E. Rodriguez Ave, Quezon City', 38, 'Male', 'PH888666', '2025-08-30', 14, '2011-09-05', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(24, 'tomas@gmail.com', 'tomas01', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Tomas', 'Reyes', '09776543210', '3131 Boni Ave, Mandaluyong City', 36, 'Male', 'PH666888', '2024-06-10', 12, '2013-03-15', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(25, 'victor@gmail.com', 'victor01', '$2y$12$kjbwMVDJx7pH9UwNeSz5SucSvkEahywYwBZ6igWSgCSL2IwxhosKy', 'Victor', 'Santos', '09887654321', '3232 Katipunan Ave, Quezon City', 41, 'Male', 'PH777999', '2023-10-25', 15, '2010-07-30', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-03 23:26:24', '2024-03-03 23:26:24', 0),
(26, 'jake@gmail.com', 'jake', '$2y$12$9jJzuXBtaLYWiCKfKMHzze5sf3wiF9gwYMMqnWOlv4LqJOFQ0USgK', 'Suki', 'Fisher', '09120023883', 'Eaque enim ipsam et', 25, 'male', '12345678901', '2024-03-25', NULL, '2024-03-25', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-25 15:56:15', '2024-03-25 16:05:33', 0),
(27, 'xotoboliz@mailinator.com', 'xisah', '$2y$12$JMpV0tRl1ugV8glV/9zivOgxMG9UEUvwuby9FKszReyVW4fwU9eey', 'Zelda', 'Madden', '091231233133', 'Et deleniti vero inv', 32, 'male', '12345678901', '2024-03-25', NULL, '2024-03-25', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-25 16:10:41', '2024-03-25 16:10:52', 0),
(28, 'pavymen@mailinator.com', 'lejinu', '$2y$12$B/B66MhXyYg1U9J83z.7fuVzlEhaRVHdHEb9PU39/x6pKQsq8kWAK', 'Alexander', 'Rosales', '1012312323123', 'Ipsam vel iusto et v', 66, 'male', '12345678901', '2024-03-25', NULL, '2024-03-25', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-25 17:16:34', '2024-03-25 17:16:34', 0),
(29, 'qoponim@mailinator.com', 'tujyjavik', '$2y$12$oM5nDl9BjEMTDgBF5d5GXOvXAKe3PhHHtgwGAQH4d8lRwfKEB8a.S', 'Thor', 'Yates', '09123213123123', 'Eligendi dolore quo', 35, 'male', '09123456789', '2024-03-25', NULL, '2024-03-25', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-25 19:00:36', '2024-03-25 19:00:36', 0),
(30, 'wuqedi@mailinator.com', 'zynis', '$2y$12$E2ahUrqSiXy2Rz3VR6iT3e9nU9Ub1Hk4C1hZsk.hF6FJxenPIjDIO', 'Preston', 'Norman', '82', 'Corrupti ipsum odit', 22, 'male', '09123456789', '2024-03-25', NULL, '2024-03-25', NULL, 1, 'yd3m8fsbuhphzsujpt0c.png', 'Admin', '2024-03-25 19:52:52', '2024-03-25 19:52:52', 0);

--
-- Triggers `fms_g12_drivers`
--
DELIMITER $$
CREATE TRIGGER `insert_driver_access` AFTER INSERT ON `fms_g12_drivers` FOR EACH ROW INSERT INTO fms_g11_driver_access (a_id, a_u_id, a_admin_board, a_driver_board, a_fuel, a_maintenance, a_tracking, a_admin_chat, a_settings, a_deliveries, a_history, a_driver_chat)
  VALUES (NEW.d_id, NEW.d_id, 0, 1, 0, 0, 0, 0, 1, 1, 1, 1)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g12_driver_availability`
--

CREATE TABLE `fms_g12_driver_availability` (
  `availability_id` int(11) NOT NULL,
  `d_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g12_driver_availability`
--

INSERT INTO `fms_g12_driver_availability` (`availability_id`, `d_id`, `start_date`, `end_date`, `is_available`) VALUES
(1, 1, '2024-03-26', '2024-04-30', 1),
(3, 29, '2024-03-26', '2024-05-31', 1),
(4, 28, '2024-03-26', '2024-03-26', 1),
(5, 20, '2024-03-01', '2024-03-31', 1),
(6, 30, '2024-03-31', '2024-03-31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g12_driver_requirements`
--

CREATE TABLE `fms_g12_driver_requirements` (
  `id` int(11) NOT NULL,
  `d_id` int(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g12_driver_requirements`
--

INSERT INTO `fms_g12_driver_requirements` (`id`, `d_id`, `title`, `description`, `file`, `file_name`, `created_at`, `updated_at`, `status`) VALUES
(14, 30, 'Qui dicta aperiam ex', 'Laboriosam nisi tem', 'uploads/bg-about-600x224.jpg', 'bg-about-600x224.jpg', '2024-04-01 02:34:44', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g12_rate_histories`
--

CREATE TABLE `fms_g12_rate_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `package` varchar(255) NOT NULL,
  `boxFee` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rate_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g12_rate_histories`
--

INSERT INTO `fms_g12_rate_histories` (`id`, `origin`, `destination`, `package`, `boxFee`, `rate`, `type`, `action`, `created_at`, `updated_at`, `rate_id`) VALUES
(8, 'NCR', 'NCR', 'KB XL', '44', '45', 'air', 'create', '2024-02-29 13:01:55', '2024-02-29 13:01:55', 45),
(9, 'NCR', 'N.Luzon', 'KB Small', '63', '53', 'land', 'update', '2024-02-29 13:02:09', '2024-02-29 13:02:09', 45),
(10, 'NCR', 'N.Luzon', 'KB Small', '1', '1', 'air', 'create', '2024-03-01 07:03:30', '2024-03-01 07:03:30', 46),
(11, 'NCR', 'N.Luzon', 'KB XL', '82', '16', 'land', 'create', '2024-03-01 07:10:17', '2024-03-01 07:10:17', 47),
(12, 'NCR', 'N.Luzon', 'KB Large', '43', '76', 'air', 'create', '2024-03-01 07:14:40', '2024-03-01 07:14:40', 48),
(13, 'NCR', 'NCR', 'KB XL', '45', '65', 'air', 'create', '2024-03-01 07:19:40', '2024-03-01 07:19:40', 49),
(14, 'NCR', 'NCR', 'KB XL', '145.00', '165.00', 'water', 'update', '2024-03-01 07:20:34', '2024-03-01 07:20:34', 49),
(15, 'NCR', 'S.Luzon', 'KB Medium', '5000', '5500', 'land', 'create', '2024-03-28 14:23:12', '2024-03-28 14:23:12', 50);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g12_settings`
--

CREATE TABLE `fms_g12_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `land` decimal(8,2) NOT NULL,
  `sea` decimal(8,2) NOT NULL,
  `air` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g12_settings`
--

INSERT INTO `fms_g12_settings` (`id`, `land`, `sea`, `air`, `created_at`, `updated_at`) VALUES
(1, '68.00', '58.00', '3000.00', '2024-02-28 10:20:07', '2024-03-01 07:14:43');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g12_shipping_rates`
--

CREATE TABLE `fms_g12_shipping_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `package` varchar(255) NOT NULL,
  `boxFee` decimal(8,2) NOT NULL,
  `rate` decimal(8,2) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'land',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g12_shipping_rates`
--

INSERT INTO `fms_g12_shipping_rates` (`id`, `origin`, `destination`, `package`, `boxFee`, `rate`, `type`, `created_at`, `updated_at`) VALUES
(2, 'NCR', 'NCR', 'KB Small', '20.00', '100.00', 'land', NULL, NULL),
(3, 'NCR', 'NCR', 'KB Slim', '20.00', '100.00', 'land', NULL, NULL),
(5, 'NCR', 'NCR', 'KB Large', '35.00', '420.00', 'land', NULL, NULL),
(6, 'NCR', 'NCR', 'KB XL', '60.00', '820.00', 'land', NULL, NULL),
(7, 'NCR', 'N.Luzon', 'KB Mini', '15.00', '85.00', 'land', NULL, NULL),
(8, 'NCR', 'N.Luzon', 'KB Small', '20.00', '120.00', 'land', NULL, NULL),
(9, 'NCR', 'N.Luzon', 'KB Slim', '20.00', '120.00', 'land', NULL, NULL),
(10, 'NCR', 'S.Luzon', 'KB Medium', '20.00', '320.00', 'land', NULL, NULL),
(50, 'NCR', 'S.Luzon', 'KB Medium', '5000.00', '5500.00', 'land', '2024-03-28 14:23:12', '2024-03-28 14:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g12_users`
--

CREATE TABLE `fms_g12_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `driver_rate` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g12_users`
--

INSERT INTO `fms_g12_users` (`id`, `username`, `first_name`, `last_name`, `middle_name`, `phone`, `type`, `address`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `driver_rate`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', NULL, 'admin', NULL, 'admin@gmail.com', '2024-02-28 10:17:57', '$2y$12$Cld3s9n.HIWeib64OHf03exyY528jzru7EhSKP7NIkBSXJRyy4eq.', 'sIFs9w6h7KvhOvc1xg3hhAr8b5PEU4lc8zcAcishBPELOLzfg0wseDBtH0HF', '2024-02-28 10:17:57', '2024-02-28 10:17:57', 0),
(4, 'rooney', 'Rooney', 'Peterson', 'Mufutau Boone', '40', 'driver', 'Reprehenderit sed f', 'bixuhyzyk@mailinator.com', NULL, '$2y$12$BtVn0LDHU6Hwyy.LUIpun.RPauRQIj.qTEfpqm8iBPyG7Upoa1cdS', NULL, '2024-02-28 10:35:37', '2024-02-28 15:33:05', 22),
(5, 'looney', 'Iona', 'Ashley', 'Emerson Kim', '32', 'driver', 'Minus nemo ea qui im', 'cifem@mailinator.com', NULL, '$2y$12$SxbxVuTPeGESqt9wmaNH3eLpnwEFDqf8g7PwnEEY5nnDSU3cj5UAK', NULL, '2024-02-28 15:45:22', '2024-02-28 15:45:22', 0),
(9, 'super', 'super', 'super', 'super', '5555', 'admin', 'Manila Philippines', 'super@gmail.com', NULL, '$2y$12$BtVn0LDHU6Hwyy.LUIpun.RPauRQIj.qTEfpqm8iBPyG7Upoa1cdS', NULL, NULL, NULL, 0);

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
(45, 76, 19),
(46, 76, 20),
(47, 76, 28),
(48, 76, 27),
(49, 76, 27),
(50, 76, 19),
(51, 76, 19),
(52, 77, 19);

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
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_files`
--

INSERT INTO `fms_g14_files` (`id`, `name`, `description`, `user_id`, `folder_id`, `file_type`, `file_path`, `date_updated`) VALUES
(71, 'APPLE ID', 'order', 76, 19, 'txt', '../assets/uploads/APPLE ID.txt', '2024-03-05 06:56:21'),
(72, 'CALCULATOR', 'invoice', 76, 20, 'txt', '../assets/uploads/CALCULATOR.txt', '2024-03-05 06:57:58'),
(73, 'CALCULATOR', 'receipts', 76, 28, 'txt', '../assets/uploads/CALCULATOR.txt', '2024-03-05 07:12:45'),
(74, 'annual_emission_chart (3)', 'Annual Reports', 77, 19, 'pdf', '../assets/uploads/annual_emission_chart (3).pdf', '2024-03-10 02:42:52'),
(75, 'Doc2', 'sdsd', 77, 19, 'docx', '../assets/uploads/Doc2.docx', '2024-03-13 07:19:25');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_folder`
--

INSERT INTO `fms_g14_folder` (`id`, `user_id`, `file_name`, `parent_id`, `created_at`) VALUES
(19, 11, 'Order Management', 0, '2024-03-03 10:23:17'),
(20, 11, 'Invoice and Payment Management', 0, '2024-03-03 10:23:26'),
(21, 11, 'Freight Audit and Claims Management', 0, '2024-03-03 10:23:36'),
(22, 11, 'Sustainability and Environmental Impact', 0, '2024-03-03 10:23:45'),
(23, 11, 'Shipment Execution and Tracking', 0, '2024-03-03 10:23:52'),
(24, 11, 'Warehouse Management Integration', 0, '2024-03-03 10:24:03'),
(25, 11, 'Custom Compliance and Documentation', 0, '2024-03-03 10:24:10'),
(26, 11, 'Supplier and Vendor Collaboration', 0, '2024-03-03 10:24:19'),
(27, 11, 'Driver Management and Compliance', 0, '2024-03-03 10:24:32'),
(28, 11, 'receipts', 21, '2024-03-05 07:11:36');

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
(62, 71, 'Added new file', 'Accepted'),
(63, 72, 'Added new file', 'Declined'),
(64, 73, 'Added new file', 'Accepted'),
(65, 74, 'Added new file', 'Accepted'),
(66, 75, 'Added new file', 'Pending');

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
(73, 'There is a request to upload file', 'inbound', 'read', '2024-03-05 01:32:32'),
(74, 'There is a request to upload file', 'inbound', 'read', '2024-03-05 01:37:29'),
(75, 'user is requesting to access the as', 'outbound', 'read', '2024-03-05 01:38:11'),
(76, 'There is a request to upload file', 'inbound', 'unread', '2024-03-05 02:53:47'),
(77, 'There is a request to upload file', 'inbound', 'read', '2024-03-05 06:56:21'),
(78, 'There is a request to upload file', 'inbound', 'unread', '2024-03-05 06:57:58'),
(79, 'There is a request to upload file', 'inbound', 'unread', '2024-03-05 07:12:45'),
(80, 'There is a request to upload file', 'inbound', 'unread', '2024-03-10 02:42:52'),
(81, 'There is a request to upload file', 'inbound', 'unread', '2024-03-13 07:19:25');

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
(35, 19, 'report today ', 'adass', 1, 1, 1, 1, 1, 0, 0, 1, '2024-03-05 07:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g14_shared_report`
--

CREATE TABLE `fms_g14_shared_report` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g14_users`
--

INSERT INTO `fms_g14_users` (`id`, `username`, `email`, `password`, `verify_token`, `created_at`, `activate`, `role`, `image`) VALUES
(11, 'admin', 'ica@gmail.com', '$2y$10$OvfYQF./684ulw6HtornuewOqsx/3ZQgxe1qmeGh3Lcl5ESTGpmsy', NULL, '2024-03-02 15:48:21', 1, 1, '../assets/uploads/jose.jpg'),
(74, 'Super Admin', 'superadmin@gmail.com', '$2y$10$Lu9jGEarY3f5TnLxKail1ucpC9E3vfEx2rRYwhixHpR3LQ94YX0aq', NULL, '2024-03-05 01:06:29', 1, 1, '../assets/uploads/pngtree-happy-man-male-user-avatar-picture-image_8205981.png'),
(76, 'user', 'user@gmail.com', '$2y$10$uY3DDk30APBGx5XhOnG.9Or12Bgds0E8/BZAMF1MV1XF6wu9MVtZG', NULL, '2024-03-05 01:09:32', 1, 0, '../assets/uploads/download.jpg'),
(77, 'OrderManagement', 'order@gmail.com', '$2y$10$8sKM5FRmznuLpcjy79Zu2uysRJa3rq1LrNXb4qz//pY.z0OKr1v1O', NULL, '2024-03-10 02:39:22', 1, 0, '../img/default-img.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g15_expenses`
--

CREATE TABLE `fms_g15_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` char(255) NOT NULL,
  `drivers_name` char(255) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `truck_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g15_expenses`
--

INSERT INTO `fms_g15_expenses` (`id`, `type`, `drivers_name`, `amount`, `truck_number`, `created_at`, `updated_at`) VALUES
(12, 'maintenance', 'aiman', 576.00, '19015929', '2024-01-25 08:49:17', '2024-01-31 08:49:17'),
(13, 'fuel', 'jake', 29992.00, '20802808', '2024-01-25 08:49:17', '2024-01-31 08:49:17'),
(14, 'maintenance', 'aiman', 576.00, '19015929', '2024-01-25 08:49:17', '2024-01-31 08:49:17'),
(15, 'maintenance', 'aiman', 576.00, '19015929', '2024-01-25 08:49:17', '2024-01-31 08:49:17'),
(16, 'maintenance', 'aiman', 576.00, '19015929', '2024-01-25 08:49:17', '2024-01-31 08:49:17'),
(17, 'maintenance', 'aiman', 576.00, '19015929', '2024-01-25 08:49:17', '2024-01-31 08:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g15_failed_jobs`
--

CREATE TABLE `fms_g15_failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g15_invoices`
--

CREATE TABLE `fms_g15_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `customer_name` char(255) NOT NULL,
  `company_name` char(255) NOT NULL,
  `carrier` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g15_invoices`
--

INSERT INTO `fms_g15_invoices` (`id`, `invoice_number`, `payment_method`, `customer_name`, `company_name`, `carrier`, `created_at`, `updated_at`) VALUES
(1, '23', 'Stripe', 'John', 'Kargada', 'Land', '2024-01-25 08:49:17', '2024-01-31 08:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g15_migrations`
--

CREATE TABLE `fms_g15_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g15_migrations`
--

INSERT INTO `fms_g15_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_01_16_142051_add_details_to_users_table', 2),
(7, '2024_01_16_161611_add_details_to_users_table', 3),
(8, '2024_01_17_132012_create_invoices_table', 4),
(9, '2024_01_24_085110_expense_table', 4),
(10, '2024_01_24_085110_expenses_table', 5),
(11, '2024_01_25_091821_expenses_table', 6),
(12, '2024_02_07_054735_create_orders_table', 7),
(13, '2024_02_28_064030_create_invoices_table_', 8),
(14, '2024_02_28_071434_create_invoices_table', 9),
(15, '2024_02_28_135425_create_payments_table', 10),
(16, '2024_02_29_164510_create_payments_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g15_password_resets`
--

CREATE TABLE `fms_g15_password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g15_password_reset_tokens`
--

CREATE TABLE `fms_g15_password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g15_payments`
--

CREATE TABLE `fms_g15_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g15_payments`
--

INSERT INTO `fms_g15_payments` (`id`, `payment_id`, `product_name`, `quantity`, `amount`, `currency`, `customer_name`, `customer_email`, `payment_status`, `payment_method`, `created_at`, `updated_at`) VALUES
(2, 'cs_test_a1VDZ2lB3KxyOuihjTSJojOTXOjOpPTgOcm2LDGRdFusshdiODKeSe27OV', 'Cargo', '1', '5', 'usd', 'john', 'benten@email.com', 'complete', 'Stripe', '2024-02-29 09:39:29', '2024-02-29 09:39:29'),
(3, 'cs_test_a1yxlutiVU6aX8uamIth3azdY8KaBHkOvUCkRNcU1hTg8eCbWFhWuxl3sm', 'Cargo', '1', '5', 'usd', 'john', 'dantesshane8@gmail.com', 'complete', 'Stripe', '2024-02-29 21:00:49', '2024-02-29 21:00:49'),
(4, 'cs_test_a1JSEF688SuEMsyR5ujI3TKMiYJvlAnHxBFJxUrTsURhKDBD4IrSIm3bZ3', 'Cargo', '1', '5', 'usd', 'jakeee', 'jake@user.com', 'complete', 'Card', '2024-02-29 22:17:49', '2024-02-29 22:17:49'),
(5, 'cs_test_a1lWAg72ZZJNh9ZQfzbVHrO89JMxm7JE1rSlLsISg7doHLFPxUsMotn3bR', 'Cargo', '1', '5', 'usd', 'Jakeeeeeeee', 'asdasda@gmail.com', 'complete', 'Card', '2024-02-29 22:23:46', '2024-02-29 22:23:46'),
(6, 'cs_test_a1eWXJUh8VXs6H9FQIPNQ0Rz3cGcXn55VUFRWORWTcWcihn96U1OWS0MkO', 'Cargo', '1', '5', 'usd', 'luisjake', 'luisjake@gmail.com', 'complete', 'Card', '2024-02-29 22:27:49', '2024-02-29 22:27:49'),
(7, 'cs_test_a1eWXJUh8VXs6H9FQIPNQ0Rz3cGcXn55VUFRWORWTcWcihn96U1OWS0MkO', 'Cargo', '1', '5', 'usd', 'luisjake', 'luisjake@gmail.com', 'complete', 'Stripe', '2024-02-29 22:28:26', '2024-02-29 22:28:26'),
(8, 'cs_test_a1eWXJUh8VXs6H9FQIPNQ0Rz3cGcXn55VUFRWORWTcWcihn96U1OWS0MkO', 'Cargo', '1', '5', 'usd', 'luisjake', 'luisjake@gmail.com', 'complete', 'Stripe', '2024-02-29 22:28:37', '2024-02-29 22:28:37'),
(9, 'cs_test_a1eWXJUh8VXs6H9FQIPNQ0Rz3cGcXn55VUFRWORWTcWcihn96U1OWS0MkO', 'Cargo', '1', '5', 'usd', 'luisjake', 'luisjake@gmail.com', 'complete', 'Stripe', '2024-02-29 22:30:01', '2024-02-29 22:30:01'),
(10, 'cs_test_a1eWXJUh8VXs6H9FQIPNQ0Rz3cGcXn55VUFRWORWTcWcihn96U1OWS0MkO', 'Cargo', '1', '5', 'usd', 'luisjake', 'luisjake@gmail.com', 'complete', 'Stripe', '2024-02-29 22:30:16', '2024-02-29 22:30:16'),
(11, 'cs_test_a1eWXJUh8VXs6H9FQIPNQ0Rz3cGcXn55VUFRWORWTcWcihn96U1OWS0MkO', 'Cargo', '1', '5', 'usd', 'luisjake', 'luisjake@gmail.com', 'complete', 'Stripe', '2024-02-29 22:30:41', '2024-02-29 22:30:41'),
(12, '123456', 'Sample Product', '2', '50.0', 'USD', 'John Doe', 'john@example.com', 'paid', 'credit_card', '2024-03-04 17:03:32', '2024-03-04 17:03:32');

--
-- Triggers `fms_g15_payments`
--
DELIMITER $$
CREATE TRIGGER `fms_g15_payments_delete_trigger` AFTER DELETE ON `fms_g15_payments` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, row_id, action, old_value, new_value, changed_by)
    VALUES ('fms_g15_payments', OLD.id, 'DELETE', CONCAT('Deleted row with id: ', OLD.id), NULL, CURRENT_USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `fms_g15_payments_insert_trigger` AFTER INSERT ON `fms_g15_payments` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, row_id, action, old_value, new_value, changed_by)
    VALUES ('fms_g15_payments', NEW.id, 'INSERT', NULL, CONCAT('Inserted new row with id: ', NEW.id), CURRENT_USER());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `fms_g15_payments_update_trigger` AFTER UPDATE ON `fms_g15_payments` FOR EACH ROW BEGIN
    INSERT INTO audit_log (table_name, row_id, action, old_value, new_value, changed_by)
    VALUES ('fms_g15_payments', NEW.id, 'UPDATE', CONCAT('Old values: ', OLD.payment_id, ', ', OLD.product_name, ', ', OLD.quantity, ', ', OLD.amount, ', ', OLD.currency, ', ', OLD.customer_name, ', ', OLD.customer_email, ', ', OLD.payment_status, ', ', OLD.payment_method, ', ', OLD.created_at, ', ', OLD.updated_at), CONCAT('New values: ', NEW.payment_id, ', ', NEW.product_name, ', ', NEW.quantity, ', ', NEW.amount, ', ', NEW.currency, ', ', NEW.customer_name, ', ', NEW.customer_email, ', ', NEW.payment_status, ', ', NEW.payment_method, ', ', NEW.created_at, ', ', NEW.updated_at), CURRENT_USER());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g15_personal_access_tokens`
--

CREATE TABLE `fms_g15_personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g15_users`
--

CREATE TABLE `fms_g15_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_as` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=user,1=admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g15_users`
--

INSERT INTO `fms_g15_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_as`) VALUES
(1, 'john', 'johnlloydilocto11@gmail.com', NULL, '$2y$12$.u7F328Ym.3YyMe9MkTeZeAeHPS2LAMm11eEmNKc3sK5lmIypvgO2', NULL, '2024-01-15 05:42:19', '2024-01-15 05:42:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g16_loads`
--

CREATE TABLE `fms_g16_loads` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `fms_g16_shipment_id` bigint(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,0) DEFAULT NULL,
  `total_fee` decimal(10,0) DEFAULT NULL,
  `total_weight` decimal(10,0) DEFAULT NULL,
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g16_loads`
--

INSERT INTO `fms_g16_loads` (`id`, `name`, `fms_g16_shipment_id`, `description`, `total_price`, `total_fee`, `total_weight`, `created_at`, `updated_at`) VALUES
(1, 'Kargada Load', 1, NULL, '0', '0', '0', '2024-03-30 01:58:38.106209', '2024-03-30 01:58:38.106209'),
(4, 'laptop', NULL, 'gadget', '105000', '10', '10', '2024-04-02 19:05:37.545213', '2024-04-02 19:05:52.818077');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g16_orders`
--

CREATE TABLE `fms_g16_orders` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `fee` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `dimension` varchar(255) DEFAULT NULL,
  `LocationFrom` varchar(255) DEFAULT NULL,
  `LocationTo` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `fms_g16_load_id` bigint(20) DEFAULT NULL,
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g16_orders`
--

INSERT INTO `fms_g16_orders` (`id`, `name`, `item`, `price`, `fee`, `weight`, `dimension`, `LocationFrom`, `LocationTo`, `qty`, `fms_g16_load_id`, `created_at`, `updated_at`) VALUES
(1, 'Iphone', 'iPhone 15 Pro', 105000, 10, 10, '20x20x20', 'Warehouse A', 'Warehouse B', '1', 4, '2024-04-02 21:48:33.000000', '2024-04-02 19:05:52.310672'),
(2, 'MacBook', 'MacBook M1', 45000, 10, 20, '20x20x20', 'Warehouse A', 'Warehouse B', '1', NULL, '2024-04-02 21:48:33.000000', '2024-04-02 21:48:36.000000');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g16_routes`
--

CREATE TABLE `fms_g16_routes` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `origin_location` varchar(255) DEFAULT NULL,
  `delivery_destination` varchar(255) DEFAULT NULL,
  `origin_latitude` double DEFAULT NULL,
  `origin_longitude` double DEFAULT NULL,
  `destination_latitude` double DEFAULT NULL,
  `destination_longitude` double DEFAULT NULL,
  `distance` double DEFAULT NULL,
  `estimated_time` double DEFAULT NULL,
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g16_routes`
--

INSERT INTO `fms_g16_routes` (`id`, `name`, `origin_location`, `delivery_destination`, `origin_latitude`, `origin_longitude`, `destination_latitude`, `destination_longitude`, `distance`, `estimated_time`, `created_at`, `updated_at`) VALUES
(1, 'Kargada Warehouse to Hub A', 'Andres Soriano Avenue Brgy 655, Manila', 'Hub A Somewhere', 14.592171669006348, 120.9725112915039, 14.592171669006348, 120.9725112915039, 100, 100, '2024-03-30 01:58:36.928754', '2024-03-30 01:58:36.928754');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g16_shipments`
--

CREATE TABLE `fms_g16_shipments` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `fms_g16_route_id` bigint(20) DEFAULT NULL,
  `vehicle` varchar(255) DEFAULT NULL,
  `fms_g12_driver_id` int(11) DEFAULT NULL,
  `total_distance` int(11) DEFAULT NULL,
  `tracking_code` varchar(255) DEFAULT NULL,
  `total_drive_time` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `current_load` decimal(10,0) DEFAULT NULL,
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g16_shipments`
--

INSERT INTO `fms_g16_shipments` (`id`, `name`, `start_date`, `end_date`, `fms_g16_route_id`, `vehicle`, `fms_g12_driver_id`, `total_distance`, `tracking_code`, `total_drive_time`, `status`, `quantity`, `current_load`, `created_at`, `updated_at`) VALUES
(1, 'Shipment#001', '2024-01-01', '2024-02-02', 1, 'Fotons', NULL, 100, 'fdosfo34', '100', 'Completed', 2, NULL, '2024-03-30 01:58:37.652596', '2024-03-30 01:58:37.652596'),
(3, 'Shipment#002', '2024-12-12', '2024-04-03', 1, 'truck', 1, 100, 'sh0402202401', '100.0', 'Pending', NULL, NULL, '2024-04-02 19:02:46.985387', '2024-04-02 19:03:17.415530');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g16_users`
--

CREATE TABLE `fms_g16_users` (
  `id` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `encrypted_password` varchar(255) NOT NULL DEFAULT '',
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_sent_at` datetime(6) DEFAULT NULL,
  `remember_created_at` datetime(6) DEFAULT NULL,
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `fms_g16_users`
--

INSERT INTO `fms_g16_users` (`id`, `email`, `encrypted_password`, `reset_password_token`, `reset_password_sent_at`, `remember_created_at`, `created_at`, `updated_at`) VALUES
(1, 'test@example.com', '$2a$12$4krf6dO/JEBs7Z7UVyh13uP8c1Zjq.pHIElXV5qZcn1/lNMW8HVgC', NULL, NULL, NULL, '2024-03-30 01:58:36.561596', '2024-03-30 01:58:36.561596');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g17_consumption_reports`
--

CREATE TABLE `fms_g17_consumption_reports` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g17_consumption_reports`
--

INSERT INTO `fms_g17_consumption_reports` (`id`, `title`, `description`) VALUES
(5, 'Panel', '<h2>1 Inspirational designs, illustrations, and graphic elements from the world&rsquo;s best designers.<br />\r\nWant more inspiration? Browse our&nbsp;<a href=\"https://dribbble.com/search/notification%20panel\">search results</a>...</h2>\r\n'),
(6, 'test', '<p><u><em><strong>report consumpotion 34</strong></em></u></p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g17_items`
--

CREATE TABLE `fms_g17_items` (
  `id` int(11) NOT NULL,
  `reference_code` text NOT NULL,
  `itemname` text NOT NULL,
  `description` text NOT NULL,
  `length` text NOT NULL,
  `width` text NOT NULL,
  `height` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g17_items`
--

INSERT INTO `fms_g17_items` (`id`, `reference_code`, `itemname`, `description`, `length`, `width`, `height`) VALUES
(84, 'REF001', 'Device', 'A small widget with gears', '5', '3.5', '2'),
(85, 'REF001', 'Electronics', 'An electronic gadget with a touchscreen', '8', '4.5', '1.5'),
(86, 'REF001', 'Tool Set', 'A set of essential tools for DIY projects', '12', '6', '3'),
(87, 'REF002', 'Bookshelf', 'A wooden bookshelf with multiple shelves', '36', '24', '72'),
(88, 'REF003', 'Laptop', 'A high-performance laptop for gaming', '14', '10', '1'),
(89, 'REF003', 'Candle Set', 'A set of scented candles in various fragrances', '3', '3', '4'),
(90, 'REF004', 'Fitness Tracker', 'A wearable device to monitor fitness activities', '2.5', '0.8', '0.5'),
(91, 'REF005', 'Kitchen Blender', 'A powerful blender for smoothies and shakes', '10', '8', '12'),
(92, 'REF005', 'Artificial Plant', 'A realistic artificial plant for home decor', '6', '6', '4.6'),
(93, 'REF005', 'Wireless Headphones', 'High-quality wireless headphones with noise cancellation', '7', '6', '3'),
(94, 'REF006', 'Wireless Phone', 'High-quality wireless headphones with noise cancellation', '7', '6', '3');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g17_notification`
--

CREATE TABLE `fms_g17_notification` (
  `id` int(11) NOT NULL,
  `all_id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g17_notification`
--

INSERT INTO `fms_g17_notification` (`id`, `all_id`, `description`) VALUES
(2, 5, 'Panel'),
(3, 6, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g17_shipment`
--

CREATE TABLE `fms_g17_shipment` (
  `id` int(11) NOT NULL,
  `reference_code` text NOT NULL,
  `shipmentfrom` text NOT NULL,
  `shipmentto` text NOT NULL,
  `vehicletype` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g17_shipment`
--

INSERT INTO `fms_g17_shipment` (`id`, `reference_code`, `shipmentfrom`, `shipmentto`, `vehicletype`) VALUES
(4, 'REF003', 'Central Storage Hub', 'Metro Logistics Center', 'Truck 8x8'),
(5, 'REF004', 'Coastal Distribution Warehouse', 'Inland Express Depot', 'Truck 6x6'),
(6, 'REF003', 'Inland Express Depot', 'Valley Storage Solutions', 'Motorcycle'),
(7, 'REF002', 'Central Storage Hub', 'Metro Logistics Center', 'Truck 8x8'),
(8, 'REF002', 'Metro Logistics Center', 'Coastal Distribution Warehouse', 'Van'),
(9, 'REF001', 'Metro Logistics Center', 'Urban Fulfillment Center', 'Van');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g17_shipment_details`
--

CREATE TABLE `fms_g17_shipment_details` (
  `id` int(11) NOT NULL,
  `reference_code` text NOT NULL,
  `receiver_fullname` text NOT NULL,
  `receiver_contact` text NOT NULL,
  `receiver_address` text NOT NULL,
  `sender_fullname` text NOT NULL,
  `sender_contact` text NOT NULL,
  `sender_address` text NOT NULL,
  `sender_tin` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g17_shipment_details`
--

INSERT INTO `fms_g17_shipment_details` (`id`, `reference_code`, `receiver_fullname`, `receiver_contact`, `receiver_address`, `sender_fullname`, `sender_contact`, `sender_address`, `sender_tin`, `status`) VALUES
(51, 'REF001', 'Alice Johnson', '111-222-3333', '123 Elm St, Cityville', 'Bob Anderson', '444-555-6666', '789 Oak St, Townsville', 'TIN123456', ''),
(52, 'REF002', 'Charlie Brown', '777-888-9999', '456 Maple St, Villagetown', 'Diana Smith', '999-000-1111', '321 Pine St, Hamletville', 'TIN789012', '4'),
(53, 'REF003', 'Eva Miller', '123-456-7890', '987 Birch St, Countryside', 'Frank Johnson', '222-333-4444', '654 Cedar St, Riverside', 'TIN345678', ''),
(54, 'REF004', 'George Williams', '555-666-7777', '789 Pine St, Lakeside', 'Helen Davis', '111-222-3333', '432 Oak St, Mountainside', 'TIN901234', ''),
(55, 'REF005', 'Ivy Martinez', '888-999-0000', '567 Maple St, Hillside', 'Jack Smith', '333-444-5555', '876 Elm St, Seaside', 'TIN567890', ''),
(56, 'REF006', 'Ivy Martinez', '888-999-0000', '567 Maple St, Hillside', 'Jack Smith', '333-444-5555', '876 Elm St, Seaside', 'TIN567890', '');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g17_status`
--

CREATE TABLE `fms_g17_status` (
  `id` int(11) NOT NULL,
  `reference_code` text NOT NULL,
  `status` text NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g17_status`
--

INSERT INTO `fms_g17_status` (`id`, `reference_code`, `status`, `datetime`) VALUES
(2, 'REF004', '1', '2024-02-27 12:42:45'),
(3, 'REF004', '2', '2024-02-27 12:43:03'),
(4, 'REF004', '3', '2024-02-27 12:52:27'),
(5, 'REF002', '1', '2024-02-29 11:18:55'),
(6, 'REF002', '2', '2024-02-29 11:19:09'),
(7, 'REF002', '4', '2024-02-29 12:06:25');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g17_users`
--

CREATE TABLE `fms_g17_users` (
  `id` int(11) NOT NULL,
  `img` text NOT NULL,
  `user_first_name` varchar(100) NOT NULL,
  `user_last_name` varchar(100) NOT NULL,
  `user_email_address` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `passwordtxt` varchar(50) NOT NULL,
  `user_contact` varchar(15) NOT NULL,
  `user_address` text NOT NULL,
  `code` int(11) NOT NULL,
  `type` int(1) NOT NULL DEFAULT 1,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g17_users`
--

INSERT INTO `fms_g17_users` (`id`, `img`, `user_first_name`, `user_last_name`, `user_email_address`, `password`, `passwordtxt`, `user_contact`, `user_address`, `code`, `type`, `status`) VALUES
(1, 'curly-hairstyles-for-men-1200x900.jpg', 'Admin1', '', 'admin@admin.com', '$2y$10$M6NFb7FklQzv.YcNUrD5u.uPHq0CLpvjsMqix1CJzxI.1EH12Xc92', 'admin', '0', '', 22198, 0, 1),
(42, '', 'Admin2', '', 'driver@kargada.com', '$2y$10$p8X29YgoCoY07iEcHoVk0Os/VG3cCG4UH0qLp4yBwDNsBk1GTAw4S', '123', '', '', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g17_vehicle`
--

CREATE TABLE `fms_g17_vehicle` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vehicle_id` text NOT NULL,
  `destination` text NOT NULL,
  `fuel_consumption` text NOT NULL,
  `added_fuel` text NOT NULL,
  `maintenance` text NOT NULL,
  `vehicle_status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g18_formdetails`
--

CREATE TABLE `fms_g18_formdetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `item` enum('ElectronicAndGadget','FoodAndBeverages','MedicalSupply','AutomobileAndMachinery','ChemicalsAndDrugs','FurnitureAndKitchenware','Others') NOT NULL,
  `dimensions` enum('KB Mini (9 X 5 X 3) Inch','KB Small (12 X 10 X 5) Inch','KB Slim (16 X 10 X 3) Inch','KB Medium (14 X 10.5 X 7) Inch','KB Large (18 X 12 X 9) Inch','KB XL (20 X 16 X 12) Inch') NOT NULL,
  `LocationFrom` enum('Andres Soriano Avenue Barangay 655, Manila, Philippines') NOT NULL,
  `LocationTo` enum('MetroManila','Luzon','Visayas','Mindanao') NOT NULL,
  `DropOffWarehouse` enum('150 D. Aquino St, Grace Park West, Caloocan, 1406 Metro Manila','BLK 15 LOT 1, BRIÑAS CORNER BANZON ST, BF Resort Dr, Las Piñas, 1747 Metro Manila','Silangan Warehousing, Calamba, 4027 Laguna','5 Daisy Panacal Vill. P.C. 3500, Tuguegarao City, Cagayan','14 Lavilles Street, Mj Cuenco Avenue. P.C. 6000, Cebu City, Cebu','347115 Rizal St, Lapuz, Iloilo City, Iloilo','Door No. 2, Luzviminda Building, Km. 9 Old Arpt Rd, Sasa, Davao City, 8000 Davao del Sur','Kasanyangan Rd, Zamboanga, 7000 Zamboanga del Sur') NOT NULL,
  `consigneeName` varchar(255) NOT NULL,
  `receiverContact` varchar(255) NOT NULL,
  `receiveraddress` varchar(255) NOT NULL,
  `modeSelection` enum('Land','Air','Sea') NOT NULL,
  `deliveryDate` date NOT NULL,
  `price` int(11) NOT NULL,
  `fee` int(11) NOT NULL,
  `totalAmount` int(11) NOT NULL,
  `status` enum('Pending','Ongoing') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `load_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g18_migrations`
--

CREATE TABLE `fms_g18_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g18_migrations`
--

INSERT INTO `fms_g18_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_02_24_152731_create_tb_useracc_table', 1),
(3, '2024_02_26_161509_user_order_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g18_personal_access_tokens`
--

CREATE TABLE `fms_g18_personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g18_tbuseracc`
--

CREATE TABLE `fms_g18_tbuseracc` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin','employee') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fms_g18_tbuseracc`
--

INSERT INTO `fms_g18_tbuseracc` (`id`, `firstname`, `lastname`, `contact`, `image`, `email`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '09123456789', NULL, 'super_admin@gmail.com', 'superAdmin', '$2y$12$iCMhdGq4ceqAPcLLEEKbLul4LqgGfpYhv9gYhngYwJBonnssyCe1q', 'admin', NULL, '2024-03-03 01:33:10', '2024-03-03 01:33:10'),
(2, 'employee', 'employee', '09123456789', NULL, 'kargada_employee@gmail.com', 'employee', '$2y$12$BwFe3vd2aSPHK1UtFA0rUe1wsBJEhOMf63Y9AwkoTMD7i2Lr9u/cC', 'employee', NULL, '2024-03-03 01:33:10', '2024-03-03 01:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g19_admin`
--

CREATE TABLE `fms_g19_admin` (
  `ADMIN_ID` varchar(255) NOT NULL,
  `ADMIN_PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g19_admin`
--

INSERT INTO `fms_g19_admin` (`ADMIN_ID`, `ADMIN_PASSWORD`) VALUES
('ADMIN', 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g19_cars`
--

CREATE TABLE `fms_g19_cars` (
  `CAR_ID` int(11) NOT NULL,
  `CAR_NAME` varchar(255) NOT NULL,
  `FUEL_TYPE` varchar(255) NOT NULL,
  `CAPACITY` int(11) NOT NULL,
  `PRICE` int(11) NOT NULL,
  `CAR_IMG` varchar(255) NOT NULL,
  `AVAILABLE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g19_cars`
--

INSERT INTO `fms_g19_cars` (`CAR_ID`, `CAR_NAME`, `FUEL_TYPE`, `CAPACITY`, `PRICE`, `CAR_IMG`, `AVAILABLE`) VALUES
(22, 'L300', 'DEISEL', 1215, 0, 'L3.png', 'Y'),
(23, '10 WHEELER TRUCK', 'DEISEL', 30000, 0, '10wt.png', 'Y'),
(24, '16 WHEELER TRUCK', 'DEISEL', 38000, 0, '16wt.png', 'Y'),
(25, '18 WHEELER TRUCK', 'DEISEL', 40000, 0, '18wt.png', 'Y'),
(26, 'WING VAN', 'DEISEL', 1120, 0, 'wingvan.png', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g19_checklist`
--

CREATE TABLE `fms_g19_checklist` (
  `ORDER_ID` int(11) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `AMOUNT` int(11) NOT NULL,
  `DATE` date NOT NULL DEFAULT current_timestamp(),
  `STATUS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g19_request`
--

CREATE TABLE `fms_g19_request` (
  `REQUEST_ID` int(11) NOT NULL,
  `CAR_ID` int(11) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `REQUEST_DATE` date NOT NULL,
  `REQUEST_STATUS` varchar(255) NOT NULL DEFAULT 'UNDER PROCESSING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g19_users`
--

CREATE TABLE `fms_g19_users` (
  `FNAME` varchar(255) NOT NULL,
  `LNAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `LIC_NUM` varchar(255) NOT NULL,
  `PHONE_NUMBER` bigint(11) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `GENDER` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g19_users`
--

INSERT INTO `fms_g19_users` (`FNAME`, `LNAME`, `EMAIL`, `LIC_NUM`, `PHONE_NUMBER`, `PASSWORD`, `GENDER`) VALUES
('Swasthik', 'Jain', 'swasthik@gmail.com', 'B2343', 9845687555, 'c788b480e4a3c807a14b6f3f4b1a1ae6', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g20_dummy_brt`
--

CREATE TABLE `fms_g20_dummy_brt` (
  `sku` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g20_dummy_brt`
--

INSERT INTO `fms_g20_dummy_brt` (`sku`, `brand_name`, `created_at`) VALUES
('BRD001', 'Apple', '2024-03-26 16:30:10'),
('BRD002', 'Dell', '2024-03-26 16:30:10'),
('BRD003', 'Samsung', '2024-03-26 16:30:10'),
('BRD005', 'Amazon', '2024-03-26 16:30:10'),
('BRD006', 'LG', '2024-03-26 16:30:10'),
('BRD007', 'Oculus', '2024-03-26 16:30:10'),
('BRD008', 'Canon', '2024-03-26 16:30:10'),
('BRD009', 'Fitbit', '2024-03-26 16:30:10'),
('BRD010', 'TP-Link', '2024-03-26 16:30:10'),
('BRD011', 'Jabra', '2024-03-26 16:30:10'),
('BRD012', 'HP', '2024-03-26 16:30:10'),
('BRD014', 'Seagate', '2024-03-26 16:30:10'),
('BRD015', 'Sony', '2024-03-26 16:30:10'),
('BRD017', 'DJI', '2024-03-26 16:30:10'),
('BRD018', 'Nest', '2024-03-26 16:30:10'),
('BRD020', 'Logitech', '2024-03-26 16:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g20_dummy_prt`
--

CREATE TABLE `fms_g20_dummy_prt` (
  `sku` varchar(50) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g20_dummy_prt`
--

INSERT INTO `fms_g20_dummy_prt` (`sku`, `product_name`, `created_at`) VALUES
('PRT001', 'Smartphone', '2024-03-26 16:28:22'),
('PRT002', 'Laptop', '2024-03-26 16:28:22'),
('PRT003', 'Tablet', '2024-03-26 16:28:22'),
('PRT004', 'Smartwatch', '2024-03-26 16:28:22'),
('PRT005', 'Headphones', '2024-03-26 16:28:22'),
('PRT006', 'Gaming Console', '2024-03-26 16:28:22'),
('PRT007', 'Wireless Speaker', '2024-03-26 16:28:22'),
('PRT008', 'Camera', '2024-03-26 16:28:22'),
('PRT009', 'Fitness Tracker', '2024-03-26 16:28:22'),
('PRT010', 'Smart Home Speaker', '2024-03-26 16:28:22'),
('PRT011', 'Monitor', '2024-03-26 16:28:22'),
('PRT012', 'VR Headset', '2024-03-26 16:28:22'),
('PRT013', 'Printer', '2024-03-26 16:28:22'),
('PRT014', 'Router', '2024-03-26 16:28:22'),
('PRT015', 'External Hard Drive', '2024-03-26 16:28:22'),
('PRT016', 'Bluetooth Earbuds', '2024-03-26 16:28:22'),
('PRT017', 'Drone', '2024-03-26 16:28:22'),
('PRT018', 'Smart Thermostat', '2024-03-26 16:28:22'),
('PRT019', 'E-reader', '2024-03-26 16:28:22'),
('PRT020', 'Wireless Mouse', '2024-03-26 16:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g20_dummy_supply`
--

CREATE TABLE `fms_g20_dummy_supply` (
  `id` int(11) NOT NULL,
  `sku` varchar(10) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g20_dummy_supply`
--

INSERT INTO `fms_g20_dummy_supply` (`id`, `sku`, `product_name`, `brand`, `model`, `description`, `price`, `quantity`, `supplier_id`, `received_date`, `created_at`, `updated_at`) VALUES
(1, 'SKU001', 'Smartphone', 'Apple', 'iPhone 13', 'High-end smartphone with advanced features', '1000.00', 50, 1, '2024-03-01', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(2, 'SKU002', 'Laptop', 'Dell', 'XPS 15', 'Powerful laptop with stunning display', '1500.00', 30, 2, '2024-03-02', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(3, 'SKU003', 'Tablet', 'Samsung', 'Galaxy Tab S8', 'Premium tablet with sleek design', '800.00', 20, 3, '2024-03-03', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(4, 'SKU004', 'Smartwatch', 'Apple', 'Watch Series 7', 'Latest smartwatch with health tracking features', '400.00', 40, 4, '2024-03-04', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(5, 'SKU005', 'Headphones', 'Sony', 'WH-1000XM5', 'Noise-canceling headphones with exceptional sound quality', '300.00', 40, 5, '2024-03-05', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(6, 'SKU006', 'Gaming Console', 'Sony', 'PlayStation 5', 'Next-gen gaming console for immersive gaming experience', '500.00', 25, 6, '2024-03-06', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(7, 'SKU007', 'Wireless Speaker', 'Sonos', 'Roam', 'Portable wireless speaker with rich sound', '200.00', 35, 7, '2024-03-07', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(8, 'SKU008', 'Camera', 'Canon', 'EOS R5', 'Professional mirrorless camera with 8K video capability', '3000.00', 15, 8, '2024-03-08', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(9, 'SKU009', 'Fitness Tracker', 'Fitbit', 'Charge 5', 'Advanced fitness tracker with built-in GPS', '150.00', 45, 9, '2024-03-09', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(10, 'SKU010', 'Smart Home Speaker', 'Amazon', 'Echo Dot (4th Gen)', 'Voice-controlled smart speaker with Alexa', '50.00', 60, 10, '2024-03-10', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(11, 'SKU011', 'Monitor', 'LG', 'UltraGear 27GL850-B', '27\" QHD gaming monitor with IPS panel', '400.00', 20, 11, '2024-03-11', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(12, 'SKU012', 'VR Headset', 'Oculus', 'Quest 2', 'Standalone VR headset for virtual reality experiences', '300.00', 30, 12, '2024-03-12', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(13, 'SKU013', 'Printer', 'HP', 'OfficeJet Pro 9015', 'All-in-one inkjet printer for home and office use', '200.00', 25, 13, '2024-03-13', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(14, 'SKU014', 'Router', 'TP-Link', 'Archer AX21', 'Dual-band Wi-Fi 6 router for high-speed internet connection', '100.00', 30, 14, '2024-03-14', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(15, 'SKU015', 'External Hard Drive', 'Seagate', 'Backup Plus Slim', 'Portable external hard drive for data backup', '80.00', 50, 15, '2024-03-15', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(16, 'SKU016', 'Bluetooth Earbuds', 'Jabra', 'Elite 85t', 'True wireless earbuds with active noise cancellation', '250.00', 35, 16, '2024-03-16', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(17, 'SKU017', 'Drone', 'DJI', 'Mavic Air 2', 'Compact drone with 4K camera and intelligent shooting modes', '800.00', 20, 17, '2024-03-17', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(18, 'SKU018', 'Smart Thermostat', 'Nest', 'Learning Thermostat', 'Programmable thermostat for energy efficiency', '200.00', 40, 18, '2024-03-18', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(19, 'SKU019', 'E-reader', 'Amazon', 'Kindle Paperwhite', 'High-resolution e-reader with built-in light', '150.00', 30, 19, '2024-03-19', '2024-03-26 08:30:30', '2024-03-26 08:41:22'),
(20, 'SKU020', 'Wireless Mouse', 'Logitech', 'MX Master 3', 'Advanced wireless mouse with customizable buttons', '100.00', 45, 20, '2024-03-20', '2024-03-26 08:30:30', '2024-03-26 08:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g20_dummy_supply_invoice`
--

CREATE TABLE `fms_g20_dummy_supply_invoice` (
  `invoice_id` varchar(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('Paid','Pending','Overdue') DEFAULT NULL,
  `payment_due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fms_g20_messages`
--

CREATE TABLE `fms_g20_messages` (
  `msg_id` varchar(255) NOT NULL,
  `sender_id` varchar(255) NOT NULL,
  `receiver_id` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g20_messages`
--

INSERT INTO `fms_g20_messages` (`msg_id`, `sender_id`, `receiver_id`, `content`, `sent_at`, `read_at`, `updated_at`) VALUES
('0cebd795-d238-4c0a-bdd4-41fd36d5504a', 'efe74ec0-2dc4-4663-b962-c22f2f3c51b8', '16f5c273-140e-46a5-9917-2f3189a52b81', 'BYe', '2024-03-24 15:15:55', NULL, NULL),
('2553e227-b02e-4fd3-9a22-23c4ff774955', '9b30d81d-db21-46d4-9769-067967bfbfd7', '16f5c273-140e-46a5-9917-2f3189a52b81', 'Yes', '2024-03-24 15:13:40', NULL, NULL),
('2b5f0997-b326-475b-9eb4-1d9b12e5bc12', '80c8d32e-1f2b-4400-8640-6a2bd699ead2', '0e6dbde6-0a38-40d0-83be-377b57d9b31e', 'sdsds', '2024-04-05 03:13:26', NULL, NULL),
('58507dc1-fa7b-43cb-a839-caa4946b9d6a', '16f5c273-140e-46a5-9917-2f3189a52b81', '9b30d81d-db21-46d4-9769-067967bfbfd7', 'you good ?', '2024-03-24 15:13:36', NULL, NULL),
('5bded7c1-67b7-4a74-abb9-c30cbda26d94', '16f5c273-140e-46a5-9917-2f3189a52b81', 'efe74ec0-2dc4-4663-b962-c22f2f3c51b8', 'Yow', '2024-03-24 15:15:48', NULL, NULL),
('60e43983-2649-4289-95fa-5fe201bbc550', 'efe74ec0-2dc4-4663-b962-c22f2f3c51b8', '16f5c273-140e-46a5-9917-2f3189a52b81', 'Hey', '2024-03-24 15:15:42', NULL, NULL),
('804cf794-f119-48a7-a971-41d70866422e', '16f5c273-140e-46a5-9917-2f3189a52b81', '9b30d81d-db21-46d4-9769-067967bfbfd7', 'Yow', '2024-03-24 15:12:48', NULL, NULL),
('b44eb8c4-6c16-4b33-ad83-1491362b82e0', '16f5c273-140e-46a5-9917-2f3189a52b81', '9b30d81d-db21-46d4-9769-067967bfbfd7', 'Hi', '2024-03-24 15:14:46', NULL, NULL),
('c9774de6-cbde-44d0-b9de-521de7efbfe4', '9b30d81d-db21-46d4-9769-067967bfbfd7', '16f5c273-140e-46a5-9917-2f3189a52b81', 'Hii', '2024-03-24 15:13:24', NULL, NULL),
('cec125be-bf36-44a3-b19a-6fcefe5fdbca', '9b30d81d-db21-46d4-9769-067967bfbfd7', '16f5c273-140e-46a5-9917-2f3189a52b81', 'Yes', '2024-03-24 15:15:01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g20_storage`
--

CREATE TABLE `fms_g20_storage` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `capacity` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g20_storage`
--

INSERT INTO `fms_g20_storage` (`id`, `name`, `location`, `description`, `capacity`, `created_at`) VALUES
(6, 'Laptop Storage', 'Area 1', 'Storage for laptop only: \nno foods and drinks allowed inside the storage!', 5000, '2024-03-27 16:19:44'),
(7, 'Iphone Storage', 'Area 2', 'No Food and Drinks allowed also, ', 9000, '2024-03-27 16:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g20_supply_requests`
--

CREATE TABLE `fms_g20_supply_requests` (
  `request_id` int(11) NOT NULL,
  `supply_code` varchar(255) DEFAULT NULL,
  `storage_loc` int(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `requester` varchar(255) NOT NULL,
  `status` enum('Pending','Checking','Cancelled','Rejected','Completed','On Hold') NOT NULL,
  `date_requested` datetime NOT NULL DEFAULT current_timestamp(),
  `date_expected` date NOT NULL,
  `date_arrived` datetime DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `receiver` varchar(255) NOT NULL,
  `invoice_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g20_supply_requests`
--

INSERT INTO `fms_g20_supply_requests` (`request_id`, `supply_code`, `storage_loc`, `item_name`, `quantity`, `requester`, `status`, `date_requested`, `date_expected`, `date_arrived`, `comments`, `receiver`, `invoice_id`) VALUES
(24, 'PRT001BRD001NO01', 7, 'iPhone 13', 2000, 'Moeko', 'Completed', '2024-03-27 16:22:59', '2024-03-28', '2024-03-27 18:40:30', 'kindly please attach a quality documentation for this product', 'Ussop', NULL),
(25, 'PRT006BRD015NO01', 6, 'PlayStation 5', 2000, 'Moeko', 'Pending', '2024-03-27 16:26:37', '2024-03-27', NULL, 'Temporarily goes to laptop storage.\nThe laptop storage is empty ', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fms_g20_userroles`
--

CREATE TABLE `fms_g20_userroles` (
  `role_id` int(255) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_desc` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g20_userroles`
--

INSERT INTO `fms_g20_userroles` (`role_id`, `role_name`, `role_desc`, `created_at`) VALUES
(1, 'Administrator', 'Responsible for creating Accounts', '2024-03-11 18:48:33'),
(3, 'Quality Engineer', 'Quality engineers are involved in the design and implementation of quality control systems and processes. They analyze data, conduct root cause analysis of quality issues, and develop solutions to improve product quality and reliability. They may also work on product testing and validation activities.', '2024-03-24 15:56:48'),
(4, 'Warehouse Manager', 'Supervising Warehouse Operations:\n\nManage and coordinate day-to-day warehouse activities, including receiving, storing, picking, packing, and shipping goods.\nAssign tasks to warehouse staff and set priorities to meet operational goals and deadlines.\nMonitor workflow and productivity, making adjustments as needed to ensure efficient operations.\nInventory Management:\n\nMaintain accurate inventory records using warehouse management systems (WMS) or other software tools.\nMonitor inventory levels and replenish stock as needed to prevent shortages or overstock situations.\nConduct regular inventory audits and cycle counts to ensure inventory accuracy.\nOptimizing Warehouse Layout and Organization:\n\nPlan and optimize warehouse layout and storage configurations to maximize space utilization and efficiency.\nImplement organized storage systems, such as bin locations, shelving, and racking systems, to facilitate easy access to inventory.\nEnsure compliance with safety regulations and standards for storage and handling of goods.\nManaging Shipping and Receiving:\n\nCoordinate inbound and outbound shipments, including scheduling, documentation, and carrier selection.\nOversee the receiving process to ensure accurate and timely receipt of incoming goods.\nManage the shipping process to ensure orders are picked, packed, and shipped accurately and on time.\nQuality Control and Assurance:\n\nImplement quality control processes and procedures to ensure product quality and accuracy.\nConduct inspections and audits to identify and address quality issues or discrepancies.\nCollaborate with quality assurance teams to implement corrective and preventive actions.\nSafety and Compliance:\n\nEnforce safety policies and procedures to maintain a safe working environment for warehouse staff.\nEnsure compliance with health and safety regulations, including OSHA guidelines and industry standards.\nConduct regular safety inspections and training sessions for warehouse staff.\nContinuous Improvement:\n\nIdentify opportunities for process improvements and cost savings in warehouse operations.\nImplement best practices and lean principles to streamline workflows and increase efficiency.\nTrack key performance indicators (KPIs) and metrics to measure and improve warehouse performance.', '2024-03-25 01:02:23'),
(6, 'Warehouse Associate', 'Receiving and inspecting incoming goods.\nOrganizing inventory and maintaining accurate records.\nPicking and packing orders for shipment.\nLoading and unloading trucks and containers.\nOperating material handling equipment, such as forklifts and pallet jacks.\nPerforming inventory counts and reconciling discrepancies.\nKeeping the warehouse clean, organized, and safe.\nAssisting with inventory audits and cycle counts.\nCommunicating effectively with team members and supervisors.\nFollowing all safety protocols and procedures.', '2024-03-25 17:18:02'),
(7, 'Dummy Supplier', 'Retailer', '2024-03-28 12:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `fms_g20_users`
--

CREATE TABLE `fms_g20_users` (
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_role` int(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` mediumtext NOT NULL,
  `age` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `image_link` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fms_g20_users`
--

INSERT INTO `fms_g20_users` (`email`, `name`, `password`, `user_role`, `contact`, `address`, `age`, `marital_status`, `image_link`, `created_at`, `updated_at`, `id`) VALUES
('Jcayan27@gmail.com', 'Jamaine', '$2b$10$XA6/bq3.2Djt.QfrYbOB7.CyMbzUZGnUBNcSjbkQYjZQFKaOBkyQi', 1, '9693259563', 'Bistekville 26 Palayan Dulo Brgy Culiat QC.', '24', 'single', NULL, '2024-03-17 12:01:38', '2024-03-17 12:01:38', '0e6dbde6-0a38-40d0-83be-377b57d9b31e'),
('reinielpardinesandres@gmail.com', 'Reiniel', '$2b$10$WKmR/EcP3GnbrGzJ7iNQ4eOe9cUmsYwjLOFy/eAZdWoM4gIO0YNBS', 1, '9495285575', '#147 Area 5 Luzon Avenue QC.', '25', 'single', NULL, '2024-03-16 23:30:28', '2024-03-16 23:30:28', '16f5c273-140e-46a5-9917-2f3189a52b81'),
('Ussip@gmail.com', 'Ussop', '$2b$10$LTnR.uSKimttOAPqfvSnyu16rvGBQGIKdvUTSBm72RHeVZWw12nnG', 6, '9495285576', 'One piece sample', '28', 'Married', 'https://cdn.suwalls.com/wallpapers/anime/usopp-one-piece-14013-1920x1200.jpg', '2024-03-25 17:30:33', '2024-03-25 17:30:33', '6923dca3-2c39-4cba-929f-d7089448df0b'),
('yabut@gmail.com', 'Yabut', '$2b$10$ljQMdh2bYANjHlt0JbXrJuwUt5fQkcXisDQoTp8MHSzRTbs7FRZjy', 1, '9123456789', '#123 sample address', '23', 'single', 'https://i.pinimg.com/originals/78/2f/03/782f032235bd4b00c80de140b8e70538.jpg', '2024-03-18 13:23:33', '2024-03-25 01:08:41', '80c8d32e-1f2b-4400-8640-6a2bd699ead2'),
('Nhelleandres@yahoo.com', 'Yamada', '$2b$10$xboxVB7RdzGGKorVif3ZueC/Hpo1s.EKJDDOQGI1hfJUMWgKFTAFa', 1, '9123456789', 'Tokyo Japan', '21', 'single', 'https://i0.wp.com/news.qoo-app.com/en/wp-content/uploads/sites/3/2023/03/QooApp_The-Dangers-in-my-Heart.jpg', '2024-03-23 04:08:10', '2024-03-23 04:08:10', '9b30d81d-db21-46d4-9769-067967bfbfd7'),
('Kyoutaroichikawa@gmail.com', 'Kyoutaro', '$2b$10$wcOHyUnCMxDs38We2UBO5.J8soPTKJ5xJk68icrGqgCDTlGL55B4e', 3, '9693259561', '#14 Area 5 Luzon Avenue QC.', '21', 'Single', 'https://i.pinimg.com/originals/6e/2f/f5/6e2ff545d0153a40bacdd6c7228798f4.png', '2024-03-25 01:20:18', '2024-03-25 01:20:18', '9ead51bc-7f56-458c-aa6a-1f2ac74a48f0'),
('supplier@gmail.com', 'Supplier', '$2b$10$ZN4eA4GqWzj23QtQI1LvTOKJHH6zsnmCzrztG.Uut0H/xS2TcMdtm', 7, '9693259564', 'Sample Address', '26', 'Married', 'https://i.pinimg.com/originals/fd/1d/70/fd1d70b936ff880d551e26c1f96f8bfa.png', '2024-03-28 12:09:25', '2024-03-28 12:19:23', 'ef1fb138-6293-49ff-871f-d5a0b5652ba9'),
('LogiTest@gmail.com', 'Moeko', '$2b$10$SdpX7frIbTWqxc3ROFto9.dSpm/.jSJ/Hf8.NvcqvNouOCrqSpfxG', 4, '9693259564', '#123 sample address', '19', 'Single', 'https://m.media-amazon.com/images/M/MV5BN2MzNmQwZTktZjhhMC00YmJhLWI4YTAtN2FlYjFlYTExOWVmXkEyXkFqcGdeQXVyOTc4OTAwMjU@._V1_.jpg', '2024-03-24 02:00:27', '2024-03-25 01:05:12', 'efe74ec0-2dc4-4663-b962-c22f2f3c51b8');

-- --------------------------------------------------------

--
-- Table structure for table `schema_migrations`
--

CREATE TABLE `schema_migrations` (
  `version` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `schema_migrations`
--

INSERT INTO `schema_migrations` (`version`) VALUES
('20240303183242'),
('20240328180027'),
('20240328180939'),
('20240328181000'),
('20240328181012');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ar_internal_metadata`
--
ALTER TABLE `ar_internal_metadata`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `fms_g11_accounts`
--
ALTER TABLE `fms_g11_accounts`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `user_name` (`u_username`);

--
-- Indexes for table `fms_g11_accounts_access`
--
ALTER TABLE `fms_g11_accounts_access`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `a_u_id` (`a_u_id`);

--
-- Indexes for table `fms_g11_driver_access`
--
ALTER TABLE `fms_g11_driver_access`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `a_u_id` (`a_u_id`);

--
-- Indexes for table `fms_g11_fuel`
--
ALTER TABLE `fms_g11_fuel`
  ADD PRIMARY KEY (`v_fuel_id`);

--
-- Indexes for table `fms_g11_maintenance`
--
ALTER TABLE `fms_g11_maintenance`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `fms_g11_message`
--
ALTER TABLE `fms_g11_message`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `fms_g11_notifications`
--
ALTER TABLE `fms_g11_notifications`
  ADD PRIMARY KEY (`n_id`);

--
-- Indexes for table `fms_g11_positions`
--
ALTER TABLE `fms_g11_positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trip_id` (`trip_id`);

--
-- Indexes for table `fms_g11_sustainability_data`
--
ALTER TABLE `fms_g11_sustainability_data`
  ADD PRIMARY KEY (`sd_id`),
  ADD KEY `sd_trip_id` (`sd_trip_id`);

--
-- Indexes for table `fms_g11_trips`
--
ALTER TABLE `fms_g11_trips`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `t_driver` (`t_driver`);

--
-- Indexes for table `fms_g12_compliance`
--
ALTER TABLE `fms_g12_compliance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g12_drivers`
--
ALTER TABLE `fms_g12_drivers`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `fms_g12_driver_availability`
--
ALTER TABLE `fms_g12_driver_availability`
  ADD PRIMARY KEY (`availability_id`),
  ADD KEY `d_id` (`d_id`);

--
-- Indexes for table `fms_g12_driver_requirements`
--
ALTER TABLE `fms_g12_driver_requirements`
  ADD KEY `id` (`id`);

--
-- Indexes for table `fms_g12_rate_histories`
--
ALTER TABLE `fms_g12_rate_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g12_settings`
--
ALTER TABLE `fms_g12_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g12_shipping_rates`
--
ALTER TABLE `fms_g12_shipping_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g12_users`
--
ALTER TABLE `fms_g12_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
-- Indexes for table `fms_g15_expenses`
--
ALTER TABLE `fms_g15_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g15_failed_jobs`
--
ALTER TABLE `fms_g15_failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fms_g15_invoices`
--
ALTER TABLE `fms_g15_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g15_migrations`
--
ALTER TABLE `fms_g15_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g15_password_resets`
--
ALTER TABLE `fms_g15_password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `fms_g15_password_reset_tokens`
--
ALTER TABLE `fms_g15_password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `fms_g15_payments`
--
ALTER TABLE `fms_g15_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g15_personal_access_tokens`
--
ALTER TABLE `fms_g15_personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `fms_g15_users`
--
ALTER TABLE `fms_g15_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `fms_g16_loads`
--
ALTER TABLE `fms_g16_loads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_fms_g16_loads_on_fms_g16_shipment_id` (`fms_g16_shipment_id`);

--
-- Indexes for table `fms_g16_orders`
--
ALTER TABLE `fms_g16_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_fms_g16_orders_on_fms_g16_load_id` (`fms_g16_load_id`);

--
-- Indexes for table `fms_g16_routes`
--
ALTER TABLE `fms_g16_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g16_shipments`
--
ALTER TABLE `fms_g16_shipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_fms_g16_shipments_on_fms_g16_route_id` (`fms_g16_route_id`),
  ADD KEY `fk_rails_e33953e32f` (`fms_g12_driver_id`);

--
-- Indexes for table `fms_g16_users`
--
ALTER TABLE `fms_g16_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index_fms_g16_users_on_email` (`email`),
  ADD UNIQUE KEY `index_fms_g16_users_on_reset_password_token` (`reset_password_token`);

--
-- Indexes for table `fms_g17_consumption_reports`
--
ALTER TABLE `fms_g17_consumption_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g17_items`
--
ALTER TABLE `fms_g17_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g17_notification`
--
ALTER TABLE `fms_g17_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g17_shipment`
--
ALTER TABLE `fms_g17_shipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g17_shipment_details`
--
ALTER TABLE `fms_g17_shipment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g17_status`
--
ALTER TABLE `fms_g17_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g17_users`
--
ALTER TABLE `fms_g17_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g17_vehicle`
--
ALTER TABLE `fms_g17_vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g18_formdetails`
--
ALTER TABLE `fms_g18_formdetails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fms_g18_formdetails_order_id_unique` (`order_id`),
  ADD KEY `fms_g18_formdetails_user_id_foreign` (`user_id`);

--
-- Indexes for table `fms_g18_migrations`
--
ALTER TABLE `fms_g18_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g18_personal_access_tokens`
--
ALTER TABLE `fms_g18_personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `fms_g18_tbuseracc`
--
ALTER TABLE `fms_g18_tbuseracc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fms_g18_tbuseracc_username_unique` (`username`);

--
-- Indexes for table `fms_g19_admin`
--
ALTER TABLE `fms_g19_admin`
  ADD PRIMARY KEY (`ADMIN_ID`);

--
-- Indexes for table `fms_g19_cars`
--
ALTER TABLE `fms_g19_cars`
  ADD PRIMARY KEY (`CAR_ID`);

--
-- Indexes for table `fms_g19_checklist`
--
ALTER TABLE `fms_g19_checklist`
  ADD PRIMARY KEY (`ORDER_ID`),
  ADD KEY `TEST` (`EMAIL`);

--
-- Indexes for table `fms_g19_request`
--
ALTER TABLE `fms_g19_request`
  ADD PRIMARY KEY (`REQUEST_ID`),
  ADD KEY `CAR_ID` (`CAR_ID`),
  ADD KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `fms_g19_users`
--
ALTER TABLE `fms_g19_users`
  ADD PRIMARY KEY (`EMAIL`);

--
-- Indexes for table `fms_g20_dummy_brt`
--
ALTER TABLE `fms_g20_dummy_brt`
  ADD PRIMARY KEY (`sku`);

--
-- Indexes for table `fms_g20_dummy_prt`
--
ALTER TABLE `fms_g20_dummy_prt`
  ADD PRIMARY KEY (`sku`);

--
-- Indexes for table `fms_g20_dummy_supply`
--
ALTER TABLE `fms_g20_dummy_supply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_name` (`product_name`),
  ADD KEY `brand_name` (`brand`);

--
-- Indexes for table `fms_g20_dummy_supply_invoice`
--
ALTER TABLE `fms_g20_dummy_supply_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `fms_g20_messages`
--
ALTER TABLE `fms_g20_messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `receiver_index` (`receiver_id`),
  ADD KEY `sender_index` (`sender_id`);

--
-- Indexes for table `fms_g20_storage`
--
ALTER TABLE `fms_g20_storage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fms_g20_supply_requests`
--
ALTER TABLE `fms_g20_supply_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `invoice_id` (`invoice_id`),
  ADD KEY `storage_loc` (`storage_loc`),
  ADD KEY `suppy_code` (`supply_code`);

--
-- Indexes for table `fms_g20_userroles`
--
ALTER TABLE `fms_g20_userroles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `fms_g20_users`
--
ALTER TABLE `fms_g20_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_role` (`user_role`);

--
-- Indexes for table `schema_migrations`
--
ALTER TABLE `schema_migrations`
  ADD PRIMARY KEY (`version`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fms_g11_accounts`
--
ALTER TABLE `fms_g11_accounts`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fms_g11_accounts_access`
--
ALTER TABLE `fms_g11_accounts_access`
  MODIFY `a_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fms_g11_driver_access`
--
ALTER TABLE `fms_g11_driver_access`
  MODIFY `a_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `fms_g11_fuel`
--
ALTER TABLE `fms_g11_fuel`
  MODIFY `v_fuel_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fms_g11_maintenance`
--
ALTER TABLE `fms_g11_maintenance`
  MODIFY `m_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fms_g11_message`
--
ALTER TABLE `fms_g11_message`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fms_g11_notifications`
--
ALTER TABLE `fms_g11_notifications`
  MODIFY `n_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fms_g11_positions`
--
ALTER TABLE `fms_g11_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fms_g11_sustainability_data`
--
ALTER TABLE `fms_g11_sustainability_data`
  MODIFY `sd_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fms_g11_trips`
--
ALTER TABLE `fms_g11_trips`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `fms_g12_compliance`
--
ALTER TABLE `fms_g12_compliance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `fms_g12_drivers`
--
ALTER TABLE `fms_g12_drivers`
  MODIFY `d_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `fms_g12_driver_availability`
--
ALTER TABLE `fms_g12_driver_availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fms_g12_driver_requirements`
--
ALTER TABLE `fms_g12_driver_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `fms_g12_rate_histories`
--
ALTER TABLE `fms_g12_rate_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `fms_g12_settings`
--
ALTER TABLE `fms_g12_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fms_g12_shipping_rates`
--
ALTER TABLE `fms_g12_shipping_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `fms_g12_users`
--
ALTER TABLE `fms_g12_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fms_g14_access`
--
ALTER TABLE `fms_g14_access`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `fms_g14_files`
--
ALTER TABLE `fms_g14_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `fms_g14_folder`
--
ALTER TABLE `fms_g14_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `fms_g14_inbound`
--
ALTER TABLE `fms_g14_inbound`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `fms_g14_notifications`
--
ALTER TABLE `fms_g14_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `fms_g14_outbound`
--
ALTER TABLE `fms_g14_outbound`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `fms_g14_reports`
--
ALTER TABLE `fms_g14_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `fms_g14_shared_report`
--
ALTER TABLE `fms_g14_shared_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `fms_g14_users`
--
ALTER TABLE `fms_g14_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `fms_g15_expenses`
--
ALTER TABLE `fms_g15_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `fms_g15_failed_jobs`
--
ALTER TABLE `fms_g15_failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fms_g15_invoices`
--
ALTER TABLE `fms_g15_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fms_g15_migrations`
--
ALTER TABLE `fms_g15_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `fms_g15_payments`
--
ALTER TABLE `fms_g15_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fms_g15_personal_access_tokens`
--
ALTER TABLE `fms_g15_personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fms_g15_users`
--
ALTER TABLE `fms_g15_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fms_g16_loads`
--
ALTER TABLE `fms_g16_loads`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fms_g16_orders`
--
ALTER TABLE `fms_g16_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fms_g16_routes`
--
ALTER TABLE `fms_g16_routes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fms_g16_shipments`
--
ALTER TABLE `fms_g16_shipments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fms_g16_users`
--
ALTER TABLE `fms_g16_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fms_g17_consumption_reports`
--
ALTER TABLE `fms_g17_consumption_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fms_g17_items`
--
ALTER TABLE `fms_g17_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `fms_g17_notification`
--
ALTER TABLE `fms_g17_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fms_g17_shipment`
--
ALTER TABLE `fms_g17_shipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fms_g17_shipment_details`
--
ALTER TABLE `fms_g17_shipment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `fms_g17_status`
--
ALTER TABLE `fms_g17_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fms_g17_users`
--
ALTER TABLE `fms_g17_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `fms_g17_vehicle`
--
ALTER TABLE `fms_g17_vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fms_g18_formdetails`
--
ALTER TABLE `fms_g18_formdetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fms_g18_migrations`
--
ALTER TABLE `fms_g18_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fms_g18_personal_access_tokens`
--
ALTER TABLE `fms_g18_personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fms_g18_tbuseracc`
--
ALTER TABLE `fms_g18_tbuseracc`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fms_g19_cars`
--
ALTER TABLE `fms_g19_cars`
  MODIFY `CAR_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `fms_g19_checklist`
--
ALTER TABLE `fms_g19_checklist`
  MODIFY `ORDER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fms_g19_request`
--
ALTER TABLE `fms_g19_request`
  MODIFY `REQUEST_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `fms_g20_dummy_supply`
--
ALTER TABLE `fms_g20_dummy_supply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `fms_g20_storage`
--
ALTER TABLE `fms_g20_storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fms_g20_supply_requests`
--
ALTER TABLE `fms_g20_supply_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `fms_g20_userroles`
--
ALTER TABLE `fms_g20_userroles`
  MODIFY `role_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fms_g11_accounts_access`
--
ALTER TABLE `fms_g11_accounts_access`
  ADD CONSTRAINT `fms_g11_accounts_access_ibfk_1` FOREIGN KEY (`a_u_id`) REFERENCES `fms_g11_accounts` (`u_id`);

--
-- Constraints for table `fms_g11_driver_access`
--
ALTER TABLE `fms_g11_driver_access`
  ADD CONSTRAINT `fms_g11_driver_access_ibfk_2` FOREIGN KEY (`a_u_id`) REFERENCES `fms_g12_drivers` (`d_id`);

--
-- Constraints for table `fms_g11_positions`
--
ALTER TABLE `fms_g11_positions`
  ADD CONSTRAINT `fk_trip_id` FOREIGN KEY (`trip_id`) REFERENCES `fms_g11_trips` (`t_id`);

--
-- Constraints for table `fms_g11_sustainability_data`
--
ALTER TABLE `fms_g11_sustainability_data`
  ADD CONSTRAINT `fms_g11_sustainability_data_ibfk_1` FOREIGN KEY (`sd_trip_id`) REFERENCES `fms_g11_trips` (`t_id`);

--
-- Constraints for table `fms_g11_trips`
--
ALTER TABLE `fms_g11_trips`
  ADD CONSTRAINT `fms_g11_trips_ibfk_2` FOREIGN KEY (`t_driver`) REFERENCES `fms_g12_drivers` (`d_id`);

--
-- Constraints for table `fms_g12_driver_availability`
--
ALTER TABLE `fms_g12_driver_availability`
  ADD CONSTRAINT `fms_g12_driver_availability_ibfk_1` FOREIGN KEY (`d_id`) REFERENCES `fms_g12_drivers` (`d_id`),
  ADD CONSTRAINT `fms_g12_driver_availability_ibfk_2` FOREIGN KEY (`d_id`) REFERENCES `fms_g12_drivers` (`d_id`);

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

--
-- Constraints for table `fms_g16_loads`
--
ALTER TABLE `fms_g16_loads`
  ADD CONSTRAINT `fk_rails_ca6927f7a2` FOREIGN KEY (`fms_g16_shipment_id`) REFERENCES `fms_g16_shipments` (`id`);

--
-- Constraints for table `fms_g16_orders`
--
ALTER TABLE `fms_g16_orders`
  ADD CONSTRAINT `fk_rails_35d31b7fa3` FOREIGN KEY (`fms_g16_load_id`) REFERENCES `fms_g16_loads` (`id`);

--
-- Constraints for table `fms_g16_shipments`
--
ALTER TABLE `fms_g16_shipments`
  ADD CONSTRAINT `fk_rails_929ddfc271` FOREIGN KEY (`fms_g16_route_id`) REFERENCES `fms_g16_routes` (`id`),
  ADD CONSTRAINT `fk_rails_e33953e32f` FOREIGN KEY (`fms_g12_driver_id`) REFERENCES `fms_g12_drivers` (`d_id`);

--
-- Constraints for table `fms_g18_formdetails`
--
ALTER TABLE `fms_g18_formdetails`
  ADD CONSTRAINT `fms_g18_formdetails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `fms_g18_tbuseracc` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fms_g19_checklist`
--
ALTER TABLE `fms_g19_checklist`
  ADD CONSTRAINT `TEST` FOREIGN KEY (`EMAIL`) REFERENCES `fms_g19_users` (`EMAIL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fms_g19_request`
--
ALTER TABLE `fms_g19_request`
  ADD CONSTRAINT `fms_g19_request_ibfk_1` FOREIGN KEY (`CAR_ID`) REFERENCES `fms_g19_cars` (`CAR_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fms_g19_request_ibfk_2` FOREIGN KEY (`EMAIL`) REFERENCES `fms_g19_users` (`EMAIL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fms_g20_messages`
--
ALTER TABLE `fms_g20_messages`
  ADD CONSTRAINT `fms_g20_messages_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `fms_g20_users` (`id`),
  ADD CONSTRAINT `fms_g20_messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `fms_g20_users` (`id`);

--
-- Constraints for table `fms_g20_supply_requests`
--
ALTER TABLE `fms_g20_supply_requests`
  ADD CONSTRAINT `fms_g20_supply_requests_ibfk_1` FOREIGN KEY (`storage_loc`) REFERENCES `fms_g20_storage` (`id`),
  ADD CONSTRAINT `fms_g20_supply_requests_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `fms_g20_dummy_supply_invoice` (`invoice_id`);

--
-- Constraints for table `fms_g20_users`
--
ALTER TABLE `fms_g20_users`
  ADD CONSTRAINT `fms_g20_users_ibfk_1` FOREIGN KEY (`user_role`) REFERENCES `fms_g20_userroles` (`role_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
