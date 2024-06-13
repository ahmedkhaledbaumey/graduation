-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2024 at 02:56 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gradution`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'ahmedkhaledr2@gmail.com', '$2y$12$i42nzJ1BbrFsrrhMBaCiM.JnplO0SSmDxitddvsgCnlbEBOh0ubDy', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'a@gmail.co', '$2y$12$hsVD53h.CTO.m6tLfcruK.DLR.Mj1HQpf8pnXzan8S1I2jmpV43i2', '2024-06-10 22:19:09', '2024-06-10 22:19:09'),
(3, 'a@gmail.com', '$2y$12$vPclPV3Jxnf60wZ3dSVT6.UGoNPLEd8xflTBYYvuxAkgwsd.KjUM6', '2024-06-10 22:20:38', '2024-06-10 22:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` enum('first','last') COLLATE utf8mb4_unicode_ci NOT NULL,
  `chose` enum('elective','non_elective') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `code`, `name`, `hours`, `material`, `time`, `chose`, `created_at`, `updated_at`) VALUES
(1, 'cssss', 'cs', '5', 'sss', 'first', 'elective', NULL, NULL),
(2, '111', 'ss', '2', '555', 'first', 'elective', '2024-05-09 08:18:20', '2024-05-09 08:18:20'),
(3, 'IS15', 'iot', '3', '5', 'first', 'elective', '2024-05-09 21:19:27', '2024-05-09 21:19:27'),
(4, 'IS18', 'logic', '3', '5', 'first', 'elective', '2024-05-09 21:19:51', '2024-05-09 21:19:51'),
(5, 'IS20', 'computer architecture', '3', '5', 'first', 'elective', '2024-05-09 21:20:13', '2024-05-09 21:20:13'),
(6, 'IS21', 'information technology', '3', '5', 'first', 'elective', '2024-05-09 21:20:40', '2024-05-09 21:20:40'),
(7, 'IS23', 'human rights', '2', '2', 'first', 'elective', '2024-05-09 21:21:08', '2024-05-09 21:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `course_students`
--

CREATE TABLE `course_students` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `grade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstOrSecond` enum('first','second') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_students`
--

INSERT INTO `course_students` (`id`, `student_id`, `course_id`, `grade`, `firstOrSecond`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, 'first', NULL, NULL),
(2, 3, 2, NULL, 'first', NULL, NULL),
(3, 2, 1, NULL, 'first', NULL, NULL),
(4, 2, 2, NULL, 'first', NULL, NULL),
(5, 33, 1, NULL, 'first', NULL, NULL),
(6, 33, 2, NULL, 'first', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('is','cs','ai','sc') COLLATE utf8mb4_unicode_ci NOT NULL,
  `research_plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `type`, `research_plan`, `head_id`, `created_at`, `updated_at`) VALUES
(1, 'is', 'is_researchplan', 1, '2024-05-20 11:10:50', '2024-05-30 11:10:50'),
(2, 'cs', 'cs_researchplan', 2, NULL, NULL),
(3, 'ai', 'ai_researchplan', 4, NULL, NULL),
(4, 'sc', 'sc_researchplan', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department_courses`
--

CREATE TABLE `department_courses` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department_professors`
--

CREATE TABLE `department_professors` (
  `id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `prof_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `login_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'heads'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `heads`
--

CREATE TABLE `heads` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `heads` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'heads'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `heads`
--

INSERT INTO `heads` (`id`, `name`, `email`, `password`, `phone`, `degree`, `created_at`, `updated_at`, `heads`) VALUES
(1, 'is_head', NULL, NULL, '01021547873', 'doctor', NULL, NULL, 'heads'),
(2, 'cs_head', NULL, NULL, '01254796446', 'doctor', NULL, NULL, 'heads'),
(3, 'SC_head', NULL, NULL, '02154789612', 'doctor', NULL, NULL, 'heads'),
(4, 'AI_head', NULL, NULL, '012547841267', 'doctor', NULL, NULL, 'heads'),
(5, 'cs_head', 'head@gmail.com', '$2y$12$EkrdHfdbqXadWxj/iFWiq.rJlY6.ujDikTuaUY43gCr38ArE.ZsLq', NULL, NULL, '2024-06-10 22:52:54', '2024-06-10 22:52:54', 'heads');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2023_04_30_201923_create_heads_table', 1),
(5, '2024_04_30_201506_create_departments_table', 1),
(6, '2024_04_30_201548_create_students_table', 1),
(7, '2024_04_30_201700_create_courses_table', 1),
(8, '2024_04_30_201734_create_profs_table', 1),
(9, '2024_04_30_201956_create_employees_table', 1),
(10, '2024_04_30_202044_create_vice_deans_table', 1),
(11, '2024_04_30_202140_create_schedules_table', 1),
(12, '2024_04_30_202208_create_seminars_table', 1),
(13, '2024_04_30_202254_create_department_professors_table', 1),
(14, '2024_04_30_202319_create_department_courses_table', 1),
(15, '2024_04_30_202404_create_reports_table', 1),
(16, '2024_04_30_202434_create_course_students_table', 1),
(17, '2025_04_30_202405_create_reports_table', 2),
(18, '20025_04_30_202405_create_reports_table', 3),
(19, '2024_05_19_121458_create_admin_table', 4),
(20, '2024_05_20_094321_create_student_photos_table', 5),
(21, '2024_06_11_004543_admins', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profs`
--

CREATE TABLE `profs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialization` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `login_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'profs'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prof_id` bigint UNSIGNED DEFAULT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `head_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `content`, `date`, `type`, `prof_id`, `student_id`, `head_id`, `created_at`, `updated_at`) VALUES
(3, '44564', '2024-06-11', '54', NULL, NULL, 1, '2024-06-10 23:42:45', '2024-06-10 23:42:45'),
(6, '44564', '2024-06-11', '54', NULL, NULL, 5, '2024-06-10 23:53:20', '2024-06-10 23:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('study','exam') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seminars`
--

CREATE TABLE `seminars` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('seminar1','semeinar2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `supervisor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `english_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int NOT NULL,
  `SSN` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idea` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('moed','external') COLLATE utf8mb4_unicode_ci DEFAULT 'moed',
  `degree` enum('master','phd') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'master',
  `level` enum('first_level','second_level') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'first_level',
  `enrollment_papers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_bachelors_degree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','accept') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `time` enum('first','last') COLLATE utf8mb4_unicode_ci NOT NULL,
  `marital_status` enum('married','divorce','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `login_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'students',
  `payment` enum('pending','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `english_name`, `age`, `SSN`, `password`, `email`, `account`, `phone`, `nationality`, `religion`, `job`, `address`, `idea`, `type`, `degree`, `level`, `enrollment_papers`, `original_bachelors_degree`, `status`, `time`, `marital_status`, `gender`, `department_id`, `created_at`, `updated_at`, `login_type`, `payment`) VALUES
(2, 'نتالاىبتبيبب', 'mohamed', 78, '524825737836781', '$2y$12$i42nzJ1BbrFsrrhMBaCiM.JnplO0SSmDxitddvsgCnlbEBOh0ubDy', 'merna78@saykocak.com', 'نتالاىبتبيبب@fci.bu.edu.eg', '556564655678', NULL, NULL, NULL, 'hgjhgkk', NULL, 'external', 'master', 'first_level', NULL, NULL, 'accept', 'first', 'married', 'male', 2, '2024-05-09 08:13:05', '2024-05-19 07:13:37', 'students', 'complete'),
(3, 'نتالاىبتبيبب', 'mohamed', 68, '5024825737836781', '$2y$12$s35U7WeV0m70QRZAAqrrwer0PP96/4FwwSbbKzygRpG455Bjh85qW', 'mmerna78@saykocak.com', '', '556564655678', NULL, NULL, NULL, 'hgjhgkk', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-09 08:16:28', '2024-05-09 08:16:28', 'students', 'pending'),
(4, 'نتالاىبتبيبب', 'mohamed', 68, '5024825737836781', '$2y$12$Dm3Pte1cPK5cfiOl7i8RSuqxlf2I0dVMQWfQyD2EEiztTENkWjB/.', 'mmernax78@saykocak.com', NULL, '556564655678', NULL, NULL, NULL, 'hgjhgkk', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 3, '2024-05-09 18:27:22', '2024-05-09 18:27:22', 'students', 'pending'),
(5, 'Griffin Mills', 'Morris Jast', 244, '78889545456124', '$2y$12$iUoOb1FzGWMGTnfMjJLgaeVF87NyhYa41LtW.rWZFuOyZVWuJGtrS', 'your.email+fakedata68767@gmail.com', NULL, '517-495-3333', NULL, NULL, NULL, '4291 Bergstrom Forges', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 3, '2024-05-09 18:38:17', '2024-05-19 07:24:30', 'students', 'complete'),
(6, 'Zella Johns', 'Giovanna Simonis', 52, 'Quaerat sequi harum.', '$2y$12$6b3FAilnnDfNiRb8Efv.e.gxtX1MiSkaK0ce9RlWKHo735utX4C6q', 'your.email+fakedata54341@gmail.com', NULL, '577-966-2297', NULL, NULL, NULL, '4059 Dach Drive', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 3, '2024-05-09 18:54:44', '2024-05-09 18:54:44', 'students', 'pending'),
(7, 'Zoey Homenick', 'Dell Walker', 346, 'Cumque excepturi dignissimos sapiente exercitationem officiis libero dolor saepe.', '$2y$12$x/FNWjpR4SWKFky3CDqKI.p4MbmT/6mn3BtTbZhFTLWX87m1IWAXy', 'your.email+fakedata78668@gmail.com', 'Zoey Homenick@fci.bu.edu.eg', '746-413-5733', NULL, NULL, NULL, '852 Wunsch Ridge', NULL, 'external', 'master', 'first_level', NULL, NULL, 'accept', 'first', 'married', 'male', 2, '2024-05-09 19:01:40', '2024-06-10 22:00:36', 'students', 'pending'),
(8, 'Kristoffer Kuvalis', 'Queenie Welch', 415, 'Quas id repellendus fugiat nulla molestiae libero qui laudantium commodi.', '$2y$12$R4HuXUZH7eQ1UJ5yrApqIe3Ys5FWUIRfT9ZDVJh0y1ngaK3Od6BZq', 'your.email+fakedata35555@gmail.com', 'Kristoffer Kuvalis@fci.bu.edu.eg', '498-637-4007', NULL, NULL, NULL, '153 Rogahn Way', NULL, 'external', 'master', 'first_level', NULL, NULL, 'accept', 'first', 'married', 'male', 3, '2024-05-09 19:02:56', '2024-06-10 22:01:49', 'students', 'pending'),
(9, 'Lavina Turner', 'Ila Feest', 660, 'Quam fugiat nulla quo sapiente ab voluptatibus debitis nostrum.', '$2y$12$zCwZ29WyhtUar6uZfpnyR.lIfJJQXPdn6EqwQfd0HLNlzyN6dxHlq', 'your.email+fakedata18759@gmail.com', 'Lavina Turner@fci.bu.edu.eg', '056-553-8209', NULL, NULL, NULL, '49238 Lucius Common', NULL, 'external', 'master', 'first_level', NULL, NULL, 'accept', 'first', 'married', 'male', 3, '2024-05-09 19:04:13', '2024-06-10 22:02:29', 'students', 'pending'),
(10, 'Muhammad Sanford', 'Johnnie Jenkins', 113, 'Fuga molestias quae.', '$2y$12$ytsp4bJqs8cBIkSuYyBkgurb3a3NFGKdpPOy82/vmohFUffWxKNVq', 'your.email+fakedata87217@gmail.com', NULL, '370-337-5991', NULL, NULL, NULL, '71121 Huels Place', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 4, '2024-05-09 19:06:39', '2024-05-09 19:06:39', 'students', 'pending'),
(11, 'Tressie Deckow', 'Ebony Kilback', 289, 'Ipsum voluptas nisi sit neque necessitatibus maiores ducimus.', '$2y$12$h8iTfD/XO7w3kJCitQZzn.s.1v9Q3PaNBfaoCbe6Uh7.U75k6HKca', 'your.email+fakedata37488@gmail.com', NULL, '768-853-2808', NULL, NULL, NULL, '388 Cartwright River', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 4, '2024-05-09 19:28:28', '2024-05-09 19:28:28', 'students', 'pending'),
(12, 'Bethel Treutel', 'Krystina Kulas', 115, 'Nemo praesentium cum saepe aperiam natus.', '$2y$12$1Y.PoCiTqcN9WCHwhdQcquWD42AYz7Dqj2TK/mm8KcsHNEoTG9xBu', 'your.email+fakedata51259@gmail.com', NULL, '080-361-2910', NULL, NULL, NULL, '4336 Wilderman Plain', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-09 19:30:56', '2024-05-09 19:30:56', 'students', 'pending'),
(13, 'Bert Boehm', 'Iliana Doyle', 251, 'Earum laborum asperiores quidem ullam non.', '$2y$12$Vngj8Jnu2WIqam5sKibhD.tabhUSa.fgnWupdD2aoRb4L8gFuieg6', 'your.email+fakedata90028@gmail.com', NULL, '788-323-7996', NULL, NULL, NULL, '72884 Caroline Plains', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-09 19:32:48', '2024-05-09 19:32:48', 'students', 'pending'),
(14, 'Dameon Raynor', 'Damian Mayert', 333, 'Repudiandae consectetur atque laboriosam tempora deserunt numquam facilis dignissimos sint.', '$2y$12$0z73sSkSg9ZKoVIHbwuDN.chms9GS6mDIFEsP9ez9fo/EjzlxZKdm', 'your.email+fakedata75163@gmail.com', NULL, '179-555-8524', NULL, NULL, NULL, '3788 Hessel Flat', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 3, '2024-05-09 20:10:49', '2024-05-09 20:10:49', 'students', 'pending'),
(15, 'Nelda Hayes', 'Carolyne Nienow', 161, 'Deleniti sed ex quos quos iste tempora eum temporibus sed.', '$2y$12$2ZperqLmDmfQJYZH2OYpgOY4MOhnDJtyN3HcLPhbjuJJ3KIWQdb6W', 'your.email+fakedata60639@gmail.com', NULL, '145-634-9911', NULL, NULL, NULL, '4657 Halle Bypass', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-09 20:16:48', '2024-05-09 20:16:48', 'students', 'pending'),
(16, 'Mckayla Bradtke', 'Lindsey Deckow', 219, 'Quisquam nesciunt vitae mollitia sapiente id.', '$2y$12$g0bDxTMfJPvoPtF3H3oX3OCRkPh91xwy.h55m1Ih2pZO2zqoQVg4G', 'your.email+fakedata18721@gmail.com', NULL, '189-362-3398', NULL, NULL, NULL, '40941 Howell Route', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 3, '2024-05-09 20:21:38', '2024-05-09 20:21:38', 'students', 'pending'),
(17, 'نتالاىبتبيبب', 'mohamed', 68, '50248257378346781', '$2y$12$tF9J3HXJUKCuPZ2dGO8giOctaXUw3Dhrv5iqJkwGXdOmRvqXCIwgm', 'mmernax778@saykocak.com', NULL, '556564655678', NULL, NULL, NULL, 'hgjhgkk', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 3, '2024-05-09 21:17:26', '2024-05-09 21:17:26', 'students', 'pending'),
(18, 'Aubree Kihn', 'Autumn Stiedemann', 388, 'Eos nostrum porro.', '$2y$12$nZdPkFmuu0UTz9tXsyLTd.sJXe5OnOp1wlOdS07e7Ag5k39egHlkC', 'your.email+fakedata22529@gmail.com', NULL, '218-518-9163', NULL, NULL, NULL, '683 Raymond Junctions', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 4, '2024-05-09 22:58:51', '2024-05-09 22:58:51', 'students', 'pending'),
(19, 'Christina Wilderman', 'Rowena Stroman', 407, 'Molestias natus necessitatibus aut soluta harum quia fugit ducimus reprehenderit.', '$2y$12$XBbvc/p/12bKn7QNfbH5iOnYfwQj.rLDU3Kwwy1lXZOKH0oCMu.yK', 'your.email+fakedata19946@gmail.com', NULL, '570-238-1492', NULL, NULL, NULL, '759 Rosenbaum Key', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 4, '2024-05-09 23:03:40', '2024-05-09 23:03:40', 'students', 'pending'),
(20, 'Rosamond Ward', 'Arne Stanton', 68, 'Quas pariatur nesciunt debitis numquam repellat voluptate reprehenderit.', '$2y$12$QZ6pcQ6eK3tLg0Uduzx.AOiWKNeYndW3UDtw4lGt2NflTJRInpzfG', 'your.email+fakedata49271@gmail.com', NULL, '682-900-5510', NULL, NULL, NULL, '1505 Brakus Stream', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-09 23:05:00', '2024-05-09 23:05:00', 'students', 'pending'),
(21, 'Madison O\'Kon', 'Tamara Walsh', 309, 'Animi suscipit a numquam aut aliquam aut laboriosam.', '$2y$12$QDiJuIYP2SKWIcRegEHTpul.kLmOEPDXdZr2ACVTA.n5z3Hz4C0VG', 'your.email+fakedata30247@gmail.com', NULL, '092-093-9138', NULL, NULL, NULL, '94013 Ratke Place', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 3, '2024-05-09 23:06:48', '2024-05-09 23:06:48', 'students', 'pending'),
(22, 'Linnea Medhurst', 'Boyd Kunde', 222, 'Neque officiis id magni pariatur maiores quis neque.', '$2y$12$VT/HragyZSW8l/YugGOQDO3QiDdZeCIDcMbzwWq2YaMvqz9WYYl52', 'your.email+fakedata87257@gmail.com', NULL, '035-559-0959', NULL, NULL, NULL, '366 Ebert Crescent', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-12 21:32:03', '2024-05-12 21:32:03', 'students', 'pending'),
(23, 'ahmed', 'jj', 5, '522222232', '$2y$12$8U4driftEiEp2J/1nZMvceYAMRcwQiX6ZEpyP6QCPk5aA3GWB4bX6', 'ahmedkhaledr2@gmail.com', NULL, '46', NULL, NULL, NULL, 'jb', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-19 08:55:02', '2024-05-19 08:55:02', 'students', 'pending'),
(24, 'ahmed', 'jjnnjbuhu', 23, '5222222322', '$2y$12$5/Clc9x7Cv90dzdzi/KoU.3PPKhXKX9vp23joKzBoLhbffow8we.O', 'aahmedkhaledr2@gmail.com', NULL, '4622222222', NULL, NULL, NULL, 'jbgygggyygy', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-19 08:59:30', '2024-05-19 08:59:30', 'students', 'pending'),
(25, 'ahmed', 'jjnnjbuhu', 23, '52222223224', '$2y$12$9NKdXjtcl0nlT0AdW2evwON1uWpaNiZcVI5cSaIZJN32hGH.F1pHe', 'aahmedkhaledrd2@gmail.com', NULL, '4622222222', NULL, NULL, NULL, 'jbgygggyygy', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-19 09:00:48', '2024-05-19 09:00:48', 'students', 'pending'),
(26, 'ahmed', 'jjnnjbuhu', 23, '522222232242', '$2y$12$56w0SXrlYOMNplC8j6gKJOriH1YN784Dj3fpVeMFu7n9Z1Fbs41Tm', 'aaahmedkhaledrd2@gmail.com', NULL, '4622222222', NULL, NULL, NULL, 'jbgygggyygy', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-20 07:01:15', '2024-05-20 07:01:15', 'students', 'pending'),
(27, 'ahmed', 'jjnnjbuhu', 23, '5222222322422', '$2y$12$Y8E2RvatADu0wgY8wRVUTeGrZ92yjX0ubKyBtWem3nsPy6G2cPjyK', 'aaaahmedkhaledrd2@gmail.com', NULL, '4622222222', NULL, NULL, NULL, 'jbgygggyygy', NULL, 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 2, '2024-05-20 07:01:47', '2024-05-20 07:01:47', 'students', 'pending'),
(28, 'aaaaaaaaaaaaaa', 'aaaaaaaaaaa', 22, '122144455555', '$2y$12$eoZc5jFIvp81xIG8EYX2Z.zc3tlSzSEoGd0KE0dKhCUVrtE6ko2GK', 'a@gmail.commm', NULL, '74222222', NULL, NULL, NULL, 'a', 'a', 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 1, '2024-06-06 15:20:17', '2024-06-06 15:20:17', 'students', 'pending'),
(29, 'aaaaaaaaaaaaaa', 'aaaaaaaaaaa', 22, '122144455551', '$2y$12$eh9K4F.6hAuf/4im8o4QO.8W9OYNPZMcKO3XMHAZ6moMiYmMyw6Zm', 'a@gmail.comm', NULL, '74222222', NULL, NULL, NULL, 'a', 'a', 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 1, '2024-06-06 15:21:08', '2024-06-06 15:21:08', 'students', 'pending'),
(30, 'aaaaaaaaaaaaaa', 'aaaaaaaaaaa', 22, '122144455554', '$2y$12$vl8.m5SScmtl1r8YGrXYEODq8o1Y7nJbj00uLx02WqOmGtt/RoMTy', 'a@gmail.com', NULL, '74222222', NULL, NULL, NULL, 'a', 'a', 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 1, '2024-06-06 15:32:39', '2024-06-06 15:32:39', 'students', 'pending'),
(31, 'aaaaaaaaaaaaaa', 'aaaaaaaaaaa', 22, '1221444555541', '$2y$12$rHtbGCbtwvJsryt0N3Nea.rhouj8D29N6qCuDlCJEpTiBQaVeVv2q', 'a@gmail.com1', NULL, '74222222', NULL, NULL, NULL, 'a', 'a', 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 1, '2024-06-06 15:34:29', '2024-06-06 15:34:29', 'students', 'pending'),
(32, 'aaaaaaaaaaaaaa', 'aaaaaaaaaaa', 22, '122144455', '$2y$12$UTLSoe0dWpllTI4UEjQ02eFSwNAMyEpjTtX6cYydL8fPeD.X7Nnr.', 'a@gmail.com11', NULL, '12221212', NULL, NULL, NULL, 'a', 'a', 'external', 'master', 'first_level', NULL, NULL, 'pending', 'first', 'married', 'male', 1, '2024-06-10 21:34:33', '2024-06-10 21:34:33', 'students', 'pending'),
(33, 'aaaaaaaaaaaaaa', 'aaaaaaaaaaa', 22, '1221444556', '$2y$12$F3UIX0ftprbhScGRe0zgRu4JbJUMqCMu5Dh1aiBlNA5Fh.aE/ONdC', 'homos@gmail.com', 'aaaaaaaaaaaaaa@fci.bu.edu.eg', '12221212', NULL, NULL, NULL, 'a', 'a', 'external', 'master', 'first_level', NULL, NULL, 'accept', 'first', 'married', 'male', 1, '2024-06-10 22:54:41', '2024-06-10 22:56:06', 'students', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `student_photos`
--

CREATE TABLE `student_photos` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `enrollment_papers` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_bachelors_degree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_photos`
--

INSERT INTO `student_photos` (`id`, `student_id`, `enrollment_papers`, `original_bachelors_degree`, `created_at`, `updated_at`) VALUES
(1, 27, '[\"enrollment_papers\\/bnjK8wZyN6IGkJcPEc8GohIrRedZDB6MfCeN6bL2.png\",\"enrollment_papers\\/Ov5cG8HQmEMjjOXkcCpQAEbwkiICCAxL1RXRQrcd.png\"]', 'original_bachelors_degree/hSd8CTTLfWEn2eDLqVmxX0SOglqmJYk6cfUWIguJ.png', '2024-05-20 07:01:47', '2024-05-20 07:01:47'),
(2, 28, '[]', 'student/original_bachelors_degree/cg5K3T9ZR298zM6eGBdaef07O3u7X3kZAmynInf5.png', '2024-06-06 15:20:17', '2024-06-06 15:20:17'),
(3, 29, '[]', 'student/original_bachelors_degree/kJtzUlO8KYJHnHzc2jQvKCtxHbqf3FiA9hOsAVre.png', '2024-06-06 15:21:08', '2024-06-06 15:21:08'),
(4, 30, NULL, 'student/original_bachelors_degree/S0KmAos1owCJcfAKIXzllkyqZtMC6Y48pT9i1V8a.png', '2024-06-06 15:32:39', '2024-06-06 15:32:39'),
(5, 31, NULL, 'student/original_bachelors_degree/0W6tDnjZcBPGvebjGpqbrly1ZSnfcrCaLkYVvyJU.png', '2024-06-06 15:34:29', '2024-06-06 15:34:29'),
(6, 32, NULL, 'student/original_bachelors_degree/KkKs8iaFPR9ogXHh45FtNKMMIis4qjTwzMQmQyuq.png', '2024-06-10 21:34:33', '2024-06-10 21:34:33'),
(7, 33, NULL, 'student/original_bachelors_degree/LzNnzCnjKnWJ8TtYhonAX6ZrcqMY4bvY8bzLXFzp.png', '2024-06-10 22:54:41', '2024-06-10 22:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `vice_deans`
--

CREATE TABLE `vice_deans` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `login_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vice_deans'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email_unique` (`email`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_students`
--
ALTER TABLE `course_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_students_student_id_foreign` (`student_id`),
  ADD KEY `course_students_course_id_foreign` (`course_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_head_id_foreign` (`head_id`);

--
-- Indexes for table `department_courses`
--
ALTER TABLE `department_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_courses_course_id_foreign` (`course_id`),
  ADD KEY `department_courses_department_id_foreign` (`department_id`);

--
-- Indexes for table `department_professors`
--
ALTER TABLE `department_professors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_professors_department_id_foreign` (`department_id`),
  ADD KEY `department_professors_prof_id_foreign` (`prof_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `heads`
--
ALTER TABLE `heads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `heads_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `profs`
--
ALTER TABLE `profs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profs_email_unique` (`email`),
  ADD KEY `profs_department_id_foreign` (`department_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_prof_id_foreign` (`prof_id`),
  ADD KEY `reports_student_id_foreign` (`student_id`),
  ADD KEY `reports_head_id_foreign` (`head_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seminars`
--
ALTER TABLE `seminars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seminars_student_id_foreign` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`),
  ADD UNIQUE KEY `students_account_unique` (`account`),
  ADD KEY `students_department_id_foreign` (`department_id`),
  ADD KEY `account` (`account`),
  ADD KEY `account_2` (`account`);

--
-- Indexes for table `student_photos`
--
ALTER TABLE `student_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_photos_student_id_foreign` (`student_id`);

--
-- Indexes for table `vice_deans`
--
ALTER TABLE `vice_deans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vice_deans_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course_students`
--
ALTER TABLE `course_students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `department_courses`
--
ALTER TABLE `department_courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_professors`
--
ALTER TABLE `department_professors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `heads`
--
ALTER TABLE `heads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profs`
--
ALTER TABLE `profs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seminars`
--
ALTER TABLE `seminars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `student_photos`
--
ALTER TABLE `student_photos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vice_deans`
--
ALTER TABLE `vice_deans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_students`
--
ALTER TABLE `course_students`
  ADD CONSTRAINT `course_students_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_students_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_head_id_foreign` FOREIGN KEY (`head_id`) REFERENCES `heads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `department_courses`
--
ALTER TABLE `department_courses`
  ADD CONSTRAINT `department_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `department_courses_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `department_professors`
--
ALTER TABLE `department_professors`
  ADD CONSTRAINT `department_professors_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `department_professors_prof_id_foreign` FOREIGN KEY (`prof_id`) REFERENCES `profs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profs`
--
ALTER TABLE `profs`
  ADD CONSTRAINT `profs_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_head_id_foreign` FOREIGN KEY (`head_id`) REFERENCES `departments` (`head_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_prof_id_foreign` FOREIGN KEY (`prof_id`) REFERENCES `profs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seminars`
--
ALTER TABLE `seminars`
  ADD CONSTRAINT `seminars_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_photos`
--
ALTER TABLE `student_photos`
  ADD CONSTRAINT `student_photos_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
