-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 05, 2025 at 06:49 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auto_gsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `colleges_table`
--

CREATE TABLE `colleges_table` (
  `college_id` int(11) NOT NULL,
  `college_name` varchar(255) NOT NULL,
  `departments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colleges_table`
--

INSERT INTO `colleges_table` (`college_id`, `college_name`, `departments`) VALUES
(7, 'Engineering', '19,20'),
(8, 'Computing Studies', '17,18'),
(12, 'Nursing', '21');

-- --------------------------------------------------------

--
-- Table structure for table `college_department_table`
--

CREATE TABLE `college_department_table` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `college_department_table`
--

INSERT INTO `college_department_table` (`department_id`, `department_name`) VALUES
(17, 'Information Technology'),
(18, 'Computer Science'),
(19, 'Civil Engineering'),
(20, 'Mechanical Engineering'),
(21, 'Nursing');

-- --------------------------------------------------------

--
-- Table structure for table `course_curr`
--

CREATE TABLE `course_curr` (
  `college_course_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `degree_level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_curr`
--

INSERT INTO `course_curr` (`college_course_id`, `name`, `degree_level`) VALUES
(11, 'Civil Engineering', 'Bachelor&#039;s Degree'),
(12, 'Nursing', 'Bachelor&#039;s Degree'),
(13, 'Information Technology', 'Doctoral&#039;s Degree'),
(14, 'Information Technology', 'Associate Degree'),
(15, 'Computer Science', 'Bachelor&#039;s Degree'),
(16, 'Information Technology', 'Bachelor&#039;s Degree'),
(17, 'Psychology', 'Bachelor&#039;s Degree');

-- --------------------------------------------------------

--
-- Table structure for table `curr_table`
--

CREATE TABLE `curr_table` (
  `curr_id` int(11) NOT NULL,
  `curr_year_id` int(11) NOT NULL,
  `college_course_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `year_level_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `sub_code` varchar(150) NOT NULL,
  `sub_name` varchar(250) NOT NULL,
  `sub_prerequisite` varchar(250) DEFAULT NULL,
  `lec` int(11) DEFAULT NULL,
  `lab` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curr_table`
--

INSERT INTO `curr_table` (`curr_id`, `curr_year_id`, `college_course_id`, `time_id`, `year_level_id`, `semester_id`, `sub_code`, `sub_name`, `sub_prerequisite`, `lec`, `lab`) VALUES
(34, 6, 15, 1, 1, 1, 'CC 101', 'Computer Programming 1', '', 1, 2),
(35, 6, 15, 1, 1, 1, 'CC 100', 'Introduction To Computing', '', 1, 2),
(37, 6, 15, 1, 1, 1, 'EUTH A', 'Euthenics A', '', 1, 0),
(38, 6, 15, 1, 1, 1, 'MATH 100', 'Mathematics in the Modern World', '', 1, 1),
(39, 6, 15, 1, 1, 1, 'PE 101', 'Physical Education 1', '', 1, 0),
(40, 6, 15, 1, 1, 2, 'CC102', 'Computer Programming 2', 'CC 101', 1, 2),
(41, 6, 15, 1, 1, 2, 'EUTH B', 'Euthenics B', 'EUTH A', 1, 0),
(42, 6, 15, 1, 1, 2, 'MATH 103', 'Calculus 1', 'MATH 100', 1, 1),
(43, 6, 15, 1, 1, 2, 'PE 102', 'Physical Education 2', 'PE 101', 1, 0),
(44, 6, 15, 1, 1, 2, 'STS 100', 'Science, Technology, and Society', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `curr_time`
--

CREATE TABLE `curr_time` (
  `time_id` int(11) NOT NULL,
  `time_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curr_time`
--

INSERT INTO `curr_time` (`time_id`, `time_name`) VALUES
(1, 'Present'),
(2, 'Former');

-- --------------------------------------------------------

--
-- Table structure for table `curr_year`
--

CREATE TABLE `curr_year` (
  `curr_year_id` int(11) NOT NULL,
  `year_start` int(4) NOT NULL,
  `year_end` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curr_year`
--

INSERT INTO `curr_year` (`curr_year_id`, `year_start`, `year_end`) VALUES
(1, 2019, 2020),
(2, 2020, 2021),
(3, 2021, 2022),
(4, 2022, 2023),
(5, 2023, 2024),
(6, 2024, 2025);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_schedule`
--

CREATE TABLE `faculty_schedule` (
  `sched_id` int(11) NOT NULL,
  `profiling_id` int(11) NOT NULL,
  `release_time` tinyint(1) NOT NULL,
  `hrs_per_week` int(11) NOT NULL,
  `school_yr` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_schedule`
--

INSERT INTO `faculty_schedule` (`sched_id`, `profiling_id`, `release_time`, `hrs_per_week`, `school_yr`, `semester`) VALUES
(5, 30, 0, 40, '2022 - 2023', 1),
(7, 31, 0, 6, '2025', 2),
(13, 29, 0, 35, '2023 - 2026', 3);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_subjects`
--

CREATE TABLE `faculty_subjects` (
  `faculty_sub_id` int(11) NOT NULL,
  `sched_id` int(11) NOT NULL,
  `sub_code` varchar(255) NOT NULL,
  `yr_sec` varchar(255) NOT NULL,
  `no_students` int(11) NOT NULL,
  `lec_days` varchar(255) DEFAULT NULL,
  `lab_days` varchar(255) DEFAULT NULL,
  `lec_time` varchar(255) DEFAULT NULL,
  `lab_time` varchar(255) DEFAULT NULL,
  `lec_room` varchar(255) DEFAULT NULL,
  `lab_room` varchar(255) DEFAULT NULL,
  `lec_units` int(11) DEFAULT NULL,
  `lab_units` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_subjects`
--

INSERT INTO `faculty_subjects` (`faculty_sub_id`, `sched_id`, `sub_code`, `yr_sec`, `no_students`, `lec_days`, `lab_days`, `lec_time`, `lab_time`, `lec_room`, `lab_room`, `lec_units`, `lab_units`) VALUES
(7, 5, 'CC102', 'BSCS 2A', 32, 'MF', 'TF', '1:22 PM - 1:22 PM', '1:22 PM - 1:22 PM', 'LR 2', 'LAB 2', 1, 2),
(9, 5, 'EUTH A', 'BSCS 1A', 32, 'MTH', NULL, '1:28 PM - 1:28 PM', NULL, 'CLA 12', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `gradeid` varchar(8) NOT NULL,
  `studentid` int(8) DEFAULT NULL,
  `attendance` int(3) DEFAULT NULL,
  `quiz` int(3) DEFAULT NULL,
  `exam` int(3) DEFAULT NULL,
  `grade` float DEFAULT NULL,
  `pointequivalent` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`gradeid`, `studentid`, `attendance`, `quiz`, `exam`, `grade`, `pointequivalent`) VALUES
('1', 222, 85, 90, 88, 87, 3.5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_id` int(11) NOT NULL,
  `user_role` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notif_id`, `user_role`, `user_id`, `message`, `created_at`, `updated_at`) VALUES
(16, 1, 12, 'The account <span style=\"color:blue;\">cvbxvdfbf@gmail.com(2021-000023)</span> has successfully changed its password.', '2024-11-25 06:13:21', '2024-11-25 07:11:53');

-- --------------------------------------------------------

--
-- Table structure for table `profiling_table`
--

CREATE TABLE `profiling_table` (
  `profiling_id` int(11) NOT NULL,
  `emp_id` text NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `m_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `start_service` varchar(50) NOT NULL,
  `end_service` varchar(50) DEFAULT NULL,
  `acad_type` varchar(100) NOT NULL,
  `faculty_type` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `department_id` int(100) NOT NULL,
  `is_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiling_table`
--

INSERT INTO `profiling_table` (`profiling_id`, `emp_id`, `f_name`, `l_name`, `m_name`, `email`, `start_service`, `end_service`, `acad_type`, `faculty_type`, `designation`, `department_id`, `is_created`, `is_updated`) VALUES
(29, '2021-00089', 'Sairyl', 'Manabat', '', 'sonarshironji@gmail.com', '2025-01-03', '2025-02-28', 'Instructor III', 'Regular Lecturer', 'Professor', 20, '2025-01-26 13:12:59', '2025-01-28 11:40:51'),
(30, '2021-000009', 'Alco', 'Plus', 'Iso', 'email@email.com', '2025-01-04', '2025-03-19', 'Professor II', 'Regular Lecturer', 'Professor', 20, '2025-01-26 13:54:43', '2025-01-28 11:21:01'),
(31, '2021-000023', 'Raf', 'Saludo', '', 'saludoraf@gmail.com', '2025-01-03', '2025-01-30', 'Instructor', 'Visiting Lecturer', 'Assistant Professor', 17, '2025-01-26 14:32:56', '2025-01-26 14:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `gradeid` varchar(8) DEFAULT NULL,
  `quiz_date` date DEFAULT NULL,
  `quiz_no` int(3) DEFAULT NULL,
  `quiz_quantity` int(3) DEFAULT NULL,
  `quiz_score` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `semester_id` int(11) NOT NULL,
  `semester` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`semester_id`, `semester`) VALUES
(1, '1st Semester'),
(2, '2nd Semester'),
(3, 'Summer');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentid` int(8) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `mname` varchar(250) NOT NULL,
  `extension` varchar(250) NOT NULL,
  `studentemail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentid`, `lname`, `fname`, `mname`, `extension`, `studentemail`) VALUES
(222, 'qqqqqqqqqqqq', 'xx', 'xx', 'Jr', 'sss'),
(1223, 'shalalal', 'cc', 'cc', 'Junior', 'fff'),
(2021, 'edhhd', 'sjssj', 'ddj', '', '23@gmail.com'),
(2022, 'q', 'q', 'q', 'Jr', '123'),
(2023, 'pink', 'xx', 'xx', 'Jr', 'sss'),
(2344, 'so tonight', 'xx', 'df', 'Jr', 'dd'),
(20102, 'cc', '   ccc', 'ccc', 'Jr', 'dcdm'),
(22243, 'xx', 'xx', 'xx', '', 'sss'),
(345546, 'lubguuban', 'sairyl', 'gsflf', 'Jr', 'gvbvgfh@gmail'),
(2002123, 'living', 'all', 'alone', 'Jr', 'shhss'),
(20212203, 'sala', 'rhea', 'salazar', 'Jr', 'dhsklhf@gmail.com'),
(20213456, 'quque', 'queque', 'quque', 'Jr', 'xnxjshs'),
(22222222, 'cc', 'vv', 'vv', 'Jr', 'wwwwwwwww');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(100) NOT NULL,
  `emp_id` text NOT NULL,
  `user_role` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `f_name` varchar(155) NOT NULL,
  `l_name` varchar(155) NOT NULL,
  `m_name` varchar(155) DEFAULT NULL,
  `faculty_type` varchar(250) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `is_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `emp_id`, `user_role`, `email`, `password`, `f_name`, `l_name`, `m_name`, `faculty_type`, `profile_image`, `is_created`, `is_updated`) VALUES
(1, '2021-00150', 1, 'ofranklinjames@gmail.com', '$2y$10$oefvsQpyW0dBtXpNOWlFjOsiNaeTV8Nj0JskhRZzrJBLiy68Y6jSa', 'Franklin', 'Oliveros', 'Ituralde', 'Visiting Lecturer', NULL, '2024-01-25 14:07:56', '2024-01-28 08:19:11'),
(2, '2021-00151', 2, 'admin@gmail.com', '$2y$10$SnuD42TMnd7XB1t/UULH0eWd3d9r9KodyflG5Lp.MslLebbY9Z0V6', 'Admin', 'Main', '', 'regular ', 'admin-profile.png', '2024-01-28 04:49:03', '2025-01-09 13:11:49'),
(3, '2021-000009', 1, 'email@email.com', '$2y$10$g37cVIDEYRsCfYmIPMwybOLTd/JFqCR6Y48T2MQ4muzx/WCnpYI6u', 'Alco', 'Plus', 'Iso', 'Regular Lecturer', NULL, '2024-01-30 01:29:48', '2024-11-20 06:38:26'),
(12, '2021-000023', 1, 'saludoraf@gmail.com', '$2y$10$SnuD42TMnd7XB1t/UULH0eWd3d9r9KodyflG5Lp.MslLebbY9Z0V6', 'Raf', 'Saludo', '', 'Visiting Lecturer', NULL, '2024-11-21 22:30:34', '2025-01-09 14:44:41'),
(13, '2021-00089', 1, 'sonarshironji@gmail.com', '$2y$10$lReSRFWPxTJFHwrM1p3PWOXW5/izol3xtvzdsLBX0nlZ85lYiql4e', 'Sairyl', 'Manabat', '', 'Visiting Lecturer', NULL, '2024-11-24 19:49:16', '2024-11-24 19:49:16');

-- --------------------------------------------------------

--
-- Table structure for table `year_lvl`
--

CREATE TABLE `year_lvl` (
  `year_level_id` int(11) NOT NULL,
  `year_level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `year_lvl`
--

INSERT INTO `year_lvl` (`year_level_id`, `year_level`) VALUES
(1, '1st year'),
(2, '2nd year'),
(3, '3rd year'),
(4, '4th year');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colleges_table`
--
ALTER TABLE `colleges_table`
  ADD PRIMARY KEY (`college_id`);

--
-- Indexes for table `college_department_table`
--
ALTER TABLE `college_department_table`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `course_curr`
--
ALTER TABLE `course_curr`
  ADD PRIMARY KEY (`college_course_id`);

--
-- Indexes for table `curr_table`
--
ALTER TABLE `curr_table`
  ADD PRIMARY KEY (`curr_id`),
  ADD KEY `college_course_id` (`college_course_id`),
  ADD KEY `time_id` (`time_id`),
  ADD KEY `year_lvl_id` (`year_level_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `curr_year_id` (`curr_year_id`),
  ADD KEY `sub_code` (`sub_code`);

--
-- Indexes for table `curr_time`
--
ALTER TABLE `curr_time`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `curr_year`
--
ALTER TABLE `curr_year`
  ADD PRIMARY KEY (`curr_year_id`);

--
-- Indexes for table `faculty_schedule`
--
ALTER TABLE `faculty_schedule`
  ADD PRIMARY KEY (`sched_id`),
  ADD KEY `semester` (`semester`);

--
-- Indexes for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  ADD PRIMARY KEY (`faculty_sub_id`),
  ADD KEY `sub_code` (`sub_code`),
  ADD KEY `sched_id` (`sched_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`gradeid`),
  ADD KEY `studentid` (`studentid`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_role` (`user_role`);

--
-- Indexes for table `profiling_table`
--
ALTER TABLE `profiling_table`
  ADD PRIMARY KEY (`profiling_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `gradeid` (`gradeid`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_role` (`user_role`);

--
-- Indexes for table `year_lvl`
--
ALTER TABLE `year_lvl`
  ADD PRIMARY KEY (`year_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colleges_table`
--
ALTER TABLE `colleges_table`
  MODIFY `college_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `college_department_table`
--
ALTER TABLE `college_department_table`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `course_curr`
--
ALTER TABLE `course_curr`
  MODIFY `college_course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `curr_table`
--
ALTER TABLE `curr_table`
  MODIFY `curr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `curr_time`
--
ALTER TABLE `curr_time`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `curr_year`
--
ALTER TABLE `curr_year`
  MODIFY `curr_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `faculty_schedule`
--
ALTER TABLE `faculty_schedule`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  MODIFY `faculty_sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `profiling_table`
--
ALTER TABLE `profiling_table`
  MODIFY `profiling_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `year_lvl`
--
ALTER TABLE `year_lvl`
  MODIFY `year_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `curr_table`
--
ALTER TABLE `curr_table`
  ADD CONSTRAINT `college_course_id` FOREIGN KEY (`college_course_id`) REFERENCES `course_curr` (`college_course_id`),
  ADD CONSTRAINT `curr_year_id` FOREIGN KEY (`curr_year_id`) REFERENCES `curr_year` (`curr_year_id`),
  ADD CONSTRAINT `semester_id` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`semester_id`),
  ADD CONSTRAINT `time_id` FOREIGN KEY (`time_id`) REFERENCES `curr_time` (`time_id`),
  ADD CONSTRAINT `year_lvl_id` FOREIGN KEY (`year_level_id`) REFERENCES `year_lvl` (`year_level_id`);

--
-- Constraints for table `faculty_schedule`
--
ALTER TABLE `faculty_schedule`
  ADD CONSTRAINT `faculty_schedule_ibfk_2` FOREIGN KEY (`semester`) REFERENCES `semester` (`semester_id`),
  ADD CONSTRAINT `faculty_schedule_ibfk_3` FOREIGN KEY (`profiling_id`) REFERENCES `profiling_table` (`profiling_id`);

--
-- Constraints for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  ADD CONSTRAINT `faculty_subjects_ibfk_1` FOREIGN KEY (`sub_code`) REFERENCES `curr_table` (`sub_code`),
  ADD CONSTRAINT `faculty_subjects_ibfk_2` FOREIGN KEY (`sched_id`) REFERENCES `faculty_schedule` (`sched_id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_role` FOREIGN KEY (`user_role`) REFERENCES `user` (`user_role`);

--
-- Constraints for table `profiling_table`
--
ALTER TABLE `profiling_table`
  ADD CONSTRAINT `department_id` FOREIGN KEY (`department_id`) REFERENCES `college_department_table` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
