-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2026 at 05:31 PM
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
-- Database: `scratch_group`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `why_applying` text DEFAULT NULL,
  `experience_years` int(11) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `status` enum('Received','Verification','Shortlist','Interview Scheduling','Conduct Interview','Medical Screening','Orientation','Onboarding','Enrolled','Rejected') DEFAULT 'Received',
  `interview_date` datetime DEFAULT NULL,
  `medical_date` datetime DEFAULT NULL,
  `appointment_status` enum('Pending','Confirmed','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `user_id`, `cv_path`, `why_applying`, `experience_years`, `phone_number`, `status`, `interview_date`, `medical_date`, `appointment_status`, `created_at`) VALUES
(1, 2, 3, 'uploads/1784487507_HCI_Project_Solution.pdf', 'Qualified', 1, '0548000931', 'Enrolled', '2026-07-19 09:00:00', '0000-00-00 00:00:00', 'Confirmed', '2026-07-19 18:58:27');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `category`, `description`) VALUES
(1, 'Strategy Consultant', 'Management', 'Lead group scaling.'),
(2, 'Senior Developer', 'Tech', 'Full stack SaaS development.'),
(3, 'Chief Accountant', 'Finance', 'Financial auditing.'),
(4, 'Logistics Lead', 'Logistics', 'Supply chain management.'),
(5, 'Head of Group Security', 'Safety', 'Overseeing group-wide facility protection.'),
(6, 'Chief Financial Officer', 'Management', 'Driving group fiscal strategy and ROI.'),
(7, 'Senior Flutter Developer', 'Tech', 'Building cross-platform mobile solutions.'),
(8, 'Venture Capital Analyst', 'Finance', 'Evaluating group investment opportunities.'),
(9, 'Corporate Wellness Lead', 'HR', 'Managing employee health and productivity.'),
(10, 'Global Logistics Head', 'Logistics', 'Optimizing maritime and air freight.'),
(11, 'Data Privacy Officer', 'Legal', 'Ensuring GDPR and local law compliance.'),
(12, 'Machine Learning Eng.', 'Tech', 'Developing AI-driven group automation.'),
(13, 'Publicity Director', 'Marketing', 'Managing group public image and press.'),
(14, 'Warehouse Operations', 'Logistics', 'Streamlining inventory and dispatch.'),
(15, 'Cloud Security Arch.', 'Tech', 'Protecting group SaaS infrastructure.'),
(16, 'Treasury Manager', 'Finance', 'Managing group cash flow and liquidity.'),
(17, 'Full Stack React Dev', 'Tech', 'Developing modern group interfaces.'),
(18, 'Regional Sales Head', 'Sales', 'Driving growth in African markets.'),
(19, 'Internal Audit Lead', 'Finance', 'Conducting group financial audits.'),
(20, 'SaaS Product Designer', 'Design', 'Prototyping next-gen group tools.'),
(21, 'Client Success Exec.', 'Support', 'Managing high-profile corporate accounts.'),
(22, 'Fleet Maintenance', 'Logistics', 'Managing group transport assets.'),
(23, 'Compliance Auditor', 'Legal', 'Risk management and internal vetting.'),
(24, 'Social Media Analyst', 'Marketing', 'Tracking group viral growth metrics.'),
(25, 'Systems Integrator', 'Tech', 'Bridging group software ecosystems.'),
(26, 'Executive Support', 'Admin', 'Providing elite support to C-suite.'),
(27, 'Procurement Analyst', 'Finance', 'Strategic vendor cost-optimization.'),
(28, 'Content Strategist', 'Marketing', 'Defining group brand voice.'),
(29, 'OHS Supervisor', 'Safety', 'Managing occupational health and safety.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('HR','Candidate','Employee') DEFAULT 'Candidate',
  `password_changed` tinyint(1) DEFAULT 0,
  `contact` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`, `password_changed`, `contact`) VALUES
(1, 'HR Director', 'admin@scratch.com', 'admin123', 'HR', 0, NULL),
(2, 'General Staff', 'staff@scratch.com', 'staff123', 'Employee', 0, NULL),
(3, 'Adomako Eugene', 'adomakoeugene15@gmail.com', '@Scratch1!', 'Candidate', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
