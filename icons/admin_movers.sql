-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 09:41 AM
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
-- Database: `admin_movers`
--

-- --------------------------------------------------------

--
-- Table structure for table `accident_reports`
--

CREATE TABLE `accident_reports` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `accident_date` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` enum('Resolved','Unresolved') NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accident_reports`
--

INSERT INTO `accident_reports` (`id`, `employee_id`, `accident_date`, `location`, `description`, `status`, `action`) VALUES
(1, 123423, '2025-03-14 09:27:02', 'Makati', 'Isang kotse ang biglang sumulpot mula sa isang eskinita at hindi napansin ng driver ng bus. Nagkaroon ng bahagyang banggaan, pero hindi ito malubha. Parehong mga driver ay ligtas at walang nasaktan sa insidente.', 'Unresolved', '');

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE `active_users` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `percentage` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compliance_data`
--

CREATE TABLE `compliance_data` (
  `id` int(11) NOT NULL,
  `bus_name` varchar(50) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `status` enum('Compliant','Non-Compliant','Pending') NOT NULL,
  `notes` text DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compliance_data`
--

INSERT INTO `compliance_data` (`id`, `bus_name`, `plate_number`, `status`, `notes`, `action`) VALUES
(39, 'wadadw', 'adsa@gamil.com', 'Non-Compliant', 'asddas', NULL),
(40, 'Taxi-ABCSS', 'AO2155', 'Non-Compliant', 'Driver Have Anger Issue', NULL),
(41, 'Taxi-ABCA', 'AO21553', 'Compliant', 'No light in the front and broken car door', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inbox_communication`
--

CREATE TABLE `inbox_communication` (
  `name_issue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description_issue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `action_issue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `send_at` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_id` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `inbox_communication`
--

INSERT INTO `inbox_communication` (`name_issue`, `name`, `description_issue`, `action_issue`, `email_id`, `send_at`, `date_id`) VALUES
('Cancellation', 'Arnold', 'I’ve just had an unpleasant experience with my driver. There was a situation involving discrimination that made me feel uncomfortable. Because of this, I’m cancelling the ride. I hope this matter is taken seriously and addressed promptly. Thank you for your understanding.\r\n\r\n', 'DRIVER REPORT', 'arnold@gmail.com', 'EMAIL', '2024-11-27'),
('Cancellation', 'Shahana', 'I had a very upsetting interaction with my driver, as I felt I was treated unfairly due to discrimination. Because of this, I am cancelling the ride. I trust that this issue will be taken seriously, and I hope steps will be taken to prevent it from happening again. I expect to hear back regarding this matter. Thank you for your attention.', 'DRIVER REPORT', 'shahana@gmail.com', 'EMAIL', '2024-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_management`
--

CREATE TABLE `issue_management` (
  `picture` longblob NOT NULL,
  `task_name` varchar(250) NOT NULL,
  `short_discrip` varchar(250) NOT NULL,
  `location` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `reporter` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketing_document`
--

CREATE TABLE `marketing_document` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `document_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `marketing_document`
--

INSERT INTO `marketing_document` (`id`, `file_name`, `file_path`, `document_title`, `uploaded_at`) VALUES
(1, 'NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'uploads/NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'marketing', '2024-11-26 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `user` varchar(250) NOT NULL,
  `id` int(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `ticket` int(50) NOT NULL,
  `dstatus` varchar(50) NOT NULL,
  `dtext` varchar(250) NOT NULL,
  `ddate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pdf_files`
--

CREATE TABLE `pdf_files` (
  `file_name` varchar(250) NOT NULL,
  `file_path` varchar(250) NOT NULL,
  `document_title` varchar(250) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pdf_files`
--

INSERT INTO `pdf_files` (`file_name`, `file_path`, `document_title`, `uploaded_at`, `id`) VALUES
('OKAY_TNVS-ADMIN_CHAPTER123-.pdf', 'uploads/OKAY_TNVS-ADMIN_CHAPTER123-.pdf', 'fff', '2024-11-24 01:13:13', 2),
('NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'uploads/NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'document', '2024-11-26 12:20:12', 3);

-- --------------------------------------------------------

--
-- Table structure for table `project_document`
--

CREATE TABLE `project_document` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `document_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_document`
--

INSERT INTO `project_document` (`id`, `file_name`, `file_path`, `document_title`, `uploaded_at`) VALUES
(1, 'NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'uploads/NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'project', '2024-11-26 12:20:33'),
(2, 'NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'uploads/NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'project 2', '2024-11-26 12:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `request_management`
--

CREATE TABLE `request_management` (
  `category` varchar(250) NOT NULL,
  `label` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `date_request` date NOT NULL,
  `member` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `template_document`
--

CREATE TABLE `template_document` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `document_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `template_document`
--

INSERT INTO `template_document` (`id`, `file_name`, `file_path`, `document_title`, `uploaded_at`) VALUES
(1, 'NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'uploads/NEW-OJT-NARRATIVE-REPORT-TEMPLATE.docx', 'template', '2024-11-26 12:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` enum('Open','In Progress','Closed') DEFAULT 'Open',
  `priority` enum('Low','Medium','High') DEFAULT 'Medium'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT '',
  `account_status` enum('active','disabled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `password`, `user_type`, `account_status`) VALUES
(NULL, 'Super Admin', 'superadmin@gmail.com', '$2y$10$fBbShBrkaQj0KvZTn9d4NO16amMeEeUv1QDShDEbmAEnvJFRSB8WW', 'superadmin', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_management`
--

CREATE TABLE `user_management` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `position` varchar(50) DEFAULT NULL,
  `drole` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `team` varchar(50) DEFAULT NULL,
  `ddescription` text DEFAULT NULL,
  `uploaded_file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_management`
--

INSERT INTO `user_management` (`id`, `first_name`, `last_name`, `position`, `drole`, `email`, `phone_number`, `team`, `ddescription`, `uploaded_file_path`, `created_at`, `role`) VALUES
(1, '', '', '', '', '', '', '', '', '', '2024-11-22 18:19:36', NULL),
(2, '', '', '', '', '', '', '', '', '', '2024-11-26 05:51:19', NULL),
(3, '', '', '', '', '', '', '', '', '', '2024-11-26 05:51:25', NULL),
(4, '', '', '', '', '', '', '', '', '', '2024-11-26 05:51:30', NULL),
(5, '', '', '', '', '', '', '', '', '', '2024-11-26 05:51:42', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accident_reports`
--
ALTER TABLE `accident_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `active_users`
--
ALTER TABLE `active_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compliance_data`
--
ALTER TABLE `compliance_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plate_number` (`plate_number`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketing_document`
--
ALTER TABLE `marketing_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdf_files`
--
ALTER TABLE `pdf_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_document`
--
ALTER TABLE `project_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_document`
--
ALTER TABLE `template_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_management`
--
ALTER TABLE `user_management`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accident_reports`
--
ALTER TABLE `accident_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `active_users`
--
ALTER TABLE `active_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compliance_data`
--
ALTER TABLE `compliance_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123132;

--
-- AUTO_INCREMENT for table `marketing_document`
--
ALTER TABLE `marketing_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pdf_files`
--
ALTER TABLE `pdf_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_document`
--
ALTER TABLE `project_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `template_document`
--
ALTER TABLE `template_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_management`
--
ALTER TABLE `user_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
