-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 28, 2023 at 06:58 AM
-- Server version: 8.0.35-0ubuntu0.20.04.1
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `retina_soft_ajaxerp`
--

--
-- Dumping data for table `settings_absent_penalties`
--

INSERT INTO `settings_absent_penalties` (`id`, `title`, `description`, `rate_type`, `salary_type`, `rate`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Without Notice', 'test', 0, 1, '120.00', 1, '2023-12-28 00:52:29', 1, NULL, NULL, 0, NULL, NULL);

--
-- Dumping data for table `settings_bonus_types`
--

INSERT INTO `settings_bonus_types` (`id`, `title`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Eid-ul-fitr', 'test', 1, '2023-12-28 00:53:44', 1, NULL, NULL, 0, NULL, NULL),
(2, 'Eid-ul-adha', 'test', 1, '2023-12-28 00:54:12', 1, NULL, NULL, 0, NULL, NULL);

--
-- Dumping data for table `settings_bonus_type_salary_bonuses`
--

INSERT INTO `settings_bonus_type_salary_bonuses` (`id`, `settings_bonus_type_id`, `settings_salary_type_id`, `rate_type`, `salary_type`, `rate`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 2, 1, 0, 1, '60.00', 1, '2023-12-28 00:54:30', 1, NULL, NULL, 0, NULL, NULL),
(2, 2, 2, 0, 1, '80.00', 1, '2023-12-28 00:55:01', 1, NULL, NULL, 0, NULL, NULL),
(3, 1, 1, 0, 1, '60.00', 1, '2023-12-28 00:55:20', 1, NULL, NULL, 0, NULL, NULL),
(4, 1, 2, 0, 1, '80.00', 1, '2023-12-28 00:56:00', 1, NULL, NULL, 0, NULL, NULL);

--
-- Dumping data for table `settings_geo_locations`
--

INSERT INTO `settings_geo_locations` (`id`, `title`, `description`, `map_type`, `location_data`, `is_default`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Head Office', 'test', 0, '[{\"lat\":23.745754358863323,\"lng\":90.35265900314988},{\"lat\":23.745567768337345,\"lng\":90.35124279679002},{\"lat\":23.744173241205033,\"lng\":90.35170413674058},{\"lat\":23.74466427358852,\"lng\":90.35346366585435}]', 1, 1, '2023-12-28 00:47:45', 1, NULL, NULL, 0, NULL, NULL),
(2, 'DOHS Branch', 'test', 0, '[{\"lat\":23.836517227517902,\"lng\":90.36522320710807},{\"lat\":23.84130622021969,\"lng\":90.37123135530143},{\"lat\":23.83486851697515,\"lng\":90.37715367280632},{\"lat\":23.83109995703188,\"lng\":90.36874226533561}]', 0, 1, '2023-12-28 00:48:59', 1, NULL, NULL, 0, NULL, NULL);

--
-- Dumping data for table `settings_holidays`
--

INSERT INTO `settings_holidays` (`id`, `title`, `description`, `start_date`, `end_date`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'New Year 2024', 'TEST', '2024-01-01', '2024-01-01', 1, '2023-12-28 00:45:08', 1, NULL, NULL, 0, NULL, NULL),
(2, 'International Mother Language Day', 'test', '2024-02-21', '2024-02-21', 1, '2023-12-28 00:46:03', 1, NULL, NULL, 0, NULL, NULL);

--
-- Dumping data for table `settings_late_penalties`
--

INSERT INTO `settings_late_penalties` (`id`, `title`, `description`, `late_count_minutes`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Employee', 'test', 15, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(2, 'Management', 'test', 30, 1, NULL, NULL, NULL, NULL, 0, NULL, NULL);

--
-- Dumping data for table `settings_leave_types`
--

INSERT INTO `settings_leave_types` (`id`, `title`, `description`, `annual_leave_days`, `max_leave_per_month`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Employee', 'test', 21, 3, 1, '2023-12-28 00:46:42', 1, NULL, NULL, 0, NULL, NULL),
(2, 'Management', 'TEST', 40, 5, 1, '2023-12-28 00:46:56', 1, NULL, NULL, 0, NULL, NULL);

--
-- Dumping data for table `settings_office_times`
--

INSERT INTO `settings_office_times` (`id`, `office_time_type_id`, `day`, `start_time`, `end_time`, `is_weekend`, `working_hour`) VALUES
(1, 1, 'sunday', '09:00:00', '18:00:00', 0, 8),
(2, 1, 'monday', '09:00:00', '18:00:00', 0, 8),
(3, 1, 'tuesday', '09:00:00', '18:00:00', 0, 8),
(4, 1, 'wednesday', '09:00:00', '18:00:00', 0, 8),
(5, 1, 'thursday', '09:00:00', '18:00:00', 0, 8),
(6, 1, 'friday', NULL, NULL, 1, 0),
(7, 1, 'saturday', NULL, NULL, 1, 0),
(8, 2, 'sunday', '10:00:00', '18:00:00', 0, 7),
(9, 2, 'monday', '10:00:00', '18:00:00', 0, 7),
(10, 2, 'tuesday', '10:00:00', '18:00:00', 0, 7),
(11, 2, 'wednesday', '10:00:00', '18:00:00', 0, 7),
(12, 2, 'thursday', '10:00:00', '18:00:00', 0, 7),
(13, 2, 'friday', NULL, NULL, 1, 0),
(14, 2, 'saturday', NULL, NULL, 1, 0);

--
-- Dumping data for table `settings_office_time_types`
--

INSERT INTO `settings_office_time_types` (`id`, `name`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Employees Time', 'test', 1, '2023-12-28 00:40:03', 1, '2023-12-28 00:41:50', 1, 0, NULL, NULL),
(2, 'Management', 'test', 1, '2023-12-28 00:43:05', 1, NULL, NULL, 0, NULL, NULL);

--
-- Dumping data for table `settings_overtime_types`
--

INSERT INTO `settings_overtime_types` (`id`, `title`, `description`, `salary_type`, `rate`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Employee', 'test', 1, '100.00', 1, '2023-12-28 00:43:50', 1, NULL, NULL, 0, NULL, NULL),
(2, 'Management', 'test', 1, '150.00', 1, '2023-12-28 00:44:02', 1, '2023-12-28 00:44:13', 1, 0, NULL, NULL);

--
-- Dumping data for table `settings_salary_types`
--

INSERT INTO `settings_salary_types` (`id`, `title`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
(1, 'Employee', 'test', 1, '2023-12-28 00:50:25', 1, '2023-12-28 00:50:25', 1, 0, NULL, NULL),
(2, 'Management', 'test', 1, '2023-12-28 00:51:43', 1, '2023-12-28 00:51:43', 1, 0, NULL, NULL);

--
-- Dumping data for table `settings_salary_type_details`
--

INSERT INTO `settings_salary_type_details` (`id`, `settings_salary_type_id`, `type`, `title`, `value`) VALUES
(1, 1, 0, 'MA', '10.00'),
(2, 1, 0, 'HRA', '40.00'),
(3, 1, 0, 'DA', '10.00'),
(4, 1, 0, 'TA', '40.00'),
(5, 1, 1, 'PFA', '5.00'),
(6, 2, 0, 'MA', '20.00'),
(7, 2, 0, 'HRA', '60.00'),
(8, 2, 0, 'DA', '10.00'),
(9, 2, 0, 'TA', '40.00'),
(10, 2, 1, 'PFA', '10.00');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
