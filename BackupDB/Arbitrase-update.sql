-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 12:45 PM
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
-- Database: `empowr`
--

-- --------------------------------------------------------

--
-- Table structure for table `arbitrase`
--

CREATE TABLE `arbitrase` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text NOT NULL,
  `status` enum('open','under review','resolved','cancelled') NOT NULL,
  `created_at` datetime NOT NULL,
  `pelapor` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arbitrase`
--

INSERT INTO `arbitrase` (`id`, `task_id`, `reason`, `status`, `created_at`, `pelapor`) VALUES
(2, 1, 'jelek', 'resolved', '2025-07-07 13:03:54', 1),
(4, 1, 'gasuka', 'cancelled', '2025-07-07 14:03:29', 1),
(5, 1, 'gasuka', 'cancelled', '2025-07-07 14:52:26', 1),
(6, 1, 'as', 'cancelled', '2025-07-07 14:59:12', 1),
(7, 1, 'gajelas lu', 'resolved', '2025-07-07 15:11:07', 2),
(12, 1, 'gblk', 'resolved', '2025-07-07 15:48:55', 2),
(13, 2, 'lala', 'resolved', '2025-07-07 15:49:17', 2),
(14, 3, 'Masuk', 'resolved', '2025-07-07 15:50:58', 5),
(15, 4, 'a', 'resolved', '2025-07-07 16:20:12', 2),
(16, 5, 'b', 'cancelled', '2025-07-07 16:20:34', 2),
(17, 7, 'd', 'resolved', '2025-07-07 16:21:52', 5),
(18, 6, 'c', 'resolved', '2025-07-07 16:22:18', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certified_applications`
--

CREATE TABLE `certified_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('application stage','viewed','selection test','interview selection','selection results') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `other_user_id` bigint(20) UNSIGNED NOT NULL,
  `last_time_message` timestamp NULL DEFAULT NULL,
  `unread_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `user_id`, `other_user_id`, `last_time_message`, `unread_count`, `created_at`, `updated_at`) VALUES
(1, 3, 3, '2025-07-07 09:44:25', 0, '2025-07-07 09:44:25', '2025-07-07 09:44:25');

-- --------------------------------------------------------

--
-- Table structure for table `escrow_payments`
--

CREATE TABLE `escrow_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `status` enum('holding','released','disputed') NOT NULL,
  `created_at` datetime NOT NULL,
  `released_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ewallet`
--

CREATE TABLE `ewallet` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ewallet`
--

INSERT INTO `ewallet` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 1, 35.00, '2025-07-07 05:27:50', '2025-07-07 09:33:20'),
(2, 2, 125.00, '2025-07-07 05:28:42', '2025-07-07 09:33:20'),
(3, 3, 2100.00, '2025-07-07 06:06:02', '2025-07-07 08:13:47'),
(4, 4, 0.00, '2025-07-07 08:07:23', '2025-07-07 08:07:23'),
(5, 5, 40.00, '2025-07-07 08:08:31', '2025-07-07 09:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `attachment_type` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_by_sender` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_by_receiver` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `midtrans_transactions`
--

CREATE TABLE `midtrans_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `escrow_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_status` enum('pending','success','failed','expired','refund') NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `gross_amount` double NOT NULL,
  `midtrans_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`midtrans_response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_03_24_999999_add_avatar_to_users', 1),
(4, '2025_04_16_033124_create_user_payment_accounts_table', 1),
(5, '2025_04_16_034519_create_worker_profiles_table', 1),
(6, '2025_04_16_034520_create_task_table', 1),
(7, '2025_04_16_034521_create_escrow_payments_table', 1),
(8, '2025_04_16_034744_create_task_applications_table', 1),
(9, '2025_04_16_034915_create_task_reviews_table', 1),
(10, '2025_04_16_035201_create_midtrans_transactions_table', 1),
(11, '2025_04_16_035307_create_arbitrase_table', 1),
(12, '2025_04_16_035533_create_portofolios_table', 1),
(13, '2025_04_16_035603_create_portofolios_images', 1),
(14, '2025_04_16_035635_create_sertifikasi_table', 1),
(15, '2025_04_16_035659_create_sertifikasi_images_table', 1),
(16, '2025_04_16_035742_create_certified_applications_table', 1),
(17, '2025_04_18_024818_create_otp_codes_table', 1),
(18, '2025_04_22_055134_create_personal_access_tokens_table', 1),
(19, '2025_04_23_052815_create_notifications_table', 1),
(20, '2025_04_24_031926_create_task_progression_table', 1),
(21, '2025_05_06_114048_create_messages_table', 1),
(22, '2025_05_06_114109_create_conversations_table', 1),
(23, '2025_05_17_144734_create_transactions_table', 1),
(24, '2025_05_17_153441_create_ewallet_table', 1),
(25, '2025_05_27_222406_create_worker_verification_affiliations_table', 1),
(26, '2025_05_27_222407_create_worker_verification_affiliations_logs_table', 1),
(27, '2025_06_21_155720_add_ewallet_name_to_user_payment_accounts_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `jenis` enum('chat','arbitrase','pembayaran','applicant') NOT NULL DEFAULT 'chat',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `sender_name`, `message`, `is_read`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin empowr', 'Arbitrase dengan reason jelek telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 06:44:19', '2025-07-07 06:44:19'),
(2, 3, 'admin empowr', 'Arbitrase dengan reason jelek telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 06:44:19', '2025-07-07 06:44:19'),
(3, 1, 'admin empowr', 'Arbitrase dengan reason kacau telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 06:55:45', '2025-07-07 06:55:45'),
(4, 3, 'admin empowr', 'Arbitrase dengan reason kacau telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 06:55:45', '2025-07-07 06:55:45'),
(5, 1, 'admin empowr', 'Arbitrase dengan reason kacau telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 06:57:06', '2025-07-07 06:57:06'),
(6, 3, 'admin empowr', 'Arbitrase dengan reason kacau telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 06:57:06', '2025-07-07 06:57:06'),
(7, 1, 'admin empowr', 'Arbitrase dengan reason kacau telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 07:02:16', '2025-07-07 07:02:16'),
(8, 2, 'admin empowr', 'Arbitrase dengan reason kacau telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 07:02:16', '2025-07-07 07:02:16'),
(9, 1, 'admin empowr', 'Arbitrase dengan reason gasuka telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 07:04:01', '2025-07-07 07:04:01'),
(10, 2, 'admin empowr', 'Arbitrase dengan reason gasuka telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 07:04:01', '2025-07-07 07:04:01'),
(11, 1, 'Muhammad Risky Farhan', 'Laporan tugas Membuat website empowr telah dibatalkan oleh Muhammad Risky Farhan', 0, 'chat', '2025-07-07 08:05:59', '2025-07-07 08:05:59'),
(12, 2, 'Budi yudiono', 'Laporan tugas Membuat website empowr telah dibatalkan oleh Muhammad Risky Farhan', 0, 'chat', '2025-07-07 08:05:59', '2025-07-07 08:05:59'),
(13, 3, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:13:47', '2025-07-07 08:13:47'),
(14, 2, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:13:47', '2025-07-07 08:13:47'),
(15, 1, 'admin empowr', 'Arbitrase dengan reason gajelas lu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:14:21', '2025-07-07 08:14:21'),
(16, 2, 'admin empowr', 'Arbitrase dengan reason gajelas lu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:14:21', '2025-07-07 08:14:21'),
(17, 3, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:21:59', '2025-07-07 08:21:59'),
(18, 2, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:21:59', '2025-07-07 08:21:59'),
(19, 3, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:24:11', '2025-07-07 08:24:11'),
(20, 2, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:24:11', '2025-07-07 08:24:11'),
(21, 3, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:25:53', '2025-07-07 08:25:53'),
(22, 2, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:25:53', '2025-07-07 08:25:53'),
(23, 3, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:27:31', '2025-07-07 08:27:31'),
(24, 2, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:27:31', '2025-07-07 08:27:31'),
(25, 3, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:36:02', '2025-07-07 08:36:02'),
(26, 2, 'admin empowr', 'Arbitrase dengan reason asu telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:36:02', '2025-07-07 08:36:02'),
(27, 3, 'admin empowr', 'Arbitrase dengan reason p telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:38:45', '2025-07-07 08:38:45'),
(28, 2, 'admin empowr', 'Arbitrase dengan reason p telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:38:45', '2025-07-07 08:38:45'),
(29, 5, 'admin empowr', 'Arbitrase dengan reason K telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:46:22', '2025-07-07 08:46:22'),
(30, 2, 'admin empowr', 'Arbitrase dengan reason K telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:46:22', '2025-07-07 08:46:22'),
(31, 5, 'admin empowr', 'Arbitrase dengan reason lala telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:52:07', '2025-07-07 08:52:07'),
(32, 2, 'admin empowr', 'Arbitrase dengan reason lala telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:52:07', '2025-07-07 08:52:07'),
(33, 1, 'admin empowr', 'Arbitrase dengan reason gblk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:53:04', '2025-07-07 08:53:04'),
(34, 2, 'admin empowr', 'Arbitrase dengan reason gblk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 08:53:04', '2025-07-07 08:53:04'),
(35, 1, 'admin empowr', 'Arbitrase dengan reason gblk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:01:41', '2025-07-07 09:01:41'),
(36, 2, 'admin empowr', 'Arbitrase dengan reason gblk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:01:41', '2025-07-07 09:01:41'),
(37, 1, 'admin empowr', 'Arbitrase dengan reason gblk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:08:20', '2025-07-07 09:08:20'),
(38, 2, 'admin empowr', 'Arbitrase dengan reason gblk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:08:20', '2025-07-07 09:08:20'),
(39, 1, 'admin empowr', 'Arbitrase dengan reason gblk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:14:53', '2025-07-07 09:14:53'),
(40, 2, 'admin empowr', 'Arbitrase dengan reason gblk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:14:53', '2025-07-07 09:14:53'),
(41, 5, 'admin empowr', 'Arbitrase dengan reason Masuk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:15:46', '2025-07-07 09:15:46'),
(42, 2, 'admin empowr', 'Arbitrase dengan reason Masuk telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:15:46', '2025-07-07 09:15:46'),
(43, 5, 'admin empowr', 'Arbitrase dengan reason a telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:23:45', '2025-07-07 09:23:45'),
(44, 2, 'admin empowr', 'Arbitrase dengan reason a telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:23:45', '2025-07-07 09:23:45'),
(45, 5, 'admin empowr', 'Arbitrase dengan reason a telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:27:44', '2025-07-07 09:27:44'),
(46, 2, 'admin empowr', 'Arbitrase dengan reason a telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:27:44', '2025-07-07 09:27:44'),
(47, 5, 'admin empowr', 'Arbitrase dengan reason d telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:28:54', '2025-07-07 09:28:54'),
(48, 2, 'admin empowr', 'Arbitrase dengan reason d telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:28:54', '2025-07-07 09:28:54'),
(49, 5, 'admin empowr', 'Arbitrase dengan reason d telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:30:37', '2025-07-07 09:30:37'),
(50, 2, 'admin empowr', 'Arbitrase dengan reason d telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:30:37', '2025-07-07 09:30:37'),
(51, 1, 'admin empowr', 'Arbitrase dengan reason c telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:33:20', '2025-07-07 09:33:20'),
(52, 2, 'admin empowr', 'Arbitrase dengan reason c telah diterima dan akan ditindaklanjuti sesuai kesepakatan.', 0, 'chat', '2025-07-07 09:33:20', '2025-07-07 09:33:20'),
(53, 5, 'admin empowr', 'Arbitrase dengan reason <b>\"b\"</b> telah ditolak oleh admin.', 0, 'chat', '2025-07-07 09:52:17', '2025-07-07 09:52:17'),
(54, 2, 'admin empowr', 'Arbitrase dengan reason <b>\"b\"</b> telah ditolak oleh admin.', 0, 'chat', '2025-07-07 09:52:17', '2025-07-07 09:52:17'),
(55, 5, 'admin empowr', 'Arbitrase dengan reason <b>\"b\"</b> telah ditolak oleh admin.', 0, 'chat', '2025-07-07 09:52:38', '2025-07-07 09:52:38'),
(56, 2, 'admin empowr', 'Arbitrase dengan reason <b>\"b\"</b> telah ditolak oleh admin.', 0, 'chat', '2025-07-07 09:52:38', '2025-07-07 09:52:38'),
(57, 5, 'Budi yudiono', 'Laporan tugas b telah dibatalkan oleh Budi yudiono', 0, 'chat', '2025-07-07 10:41:31', '2025-07-07 10:41:31'),
(58, 2, 'Budi yudiono', 'Laporan tugas b telah dibatalkan oleh Budi yudiono', 0, 'chat', '2025-07-07 10:41:31', '2025-07-07 10:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
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
-- Table structure for table `portofolios`
--

CREATE TABLE `portofolios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portofolio_images`
--

CREATE TABLE `portofolio_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `portofolio_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sertifikasi`
--

CREATE TABLE `sertifikasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sertifikasi_images`
--

CREATE TABLE `sertifikasi_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sertifikasi_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4g4vUOanHLZyYP0lSO21jZ6rF3fgvhNb3Jmx9XDo', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSlpsT015NTFUSkFXWTg3MHdhcmNoTURCeHBndjNPZVdyZGZIekN3QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVjay1zZXNzaW9uIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJ1c2VyX2RhdGEiO2E6NDp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czo2OiJCdWRidWQiO3M6NDoicm9sZSI7czo2OiJjbGllbnQiO3M6NToiZW1haWwiO3M6MjA6ImJ1ZGlDbGllbnRAZ21haWwuY29tIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1751885126),
('xVpeWfbhFnuSeo3cEEyg5XEHK68eEcVRunqmfClE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV1FzckVhcE5wb2xlcVdTZVZuR3d5YWM5dU9qS0Z4cklmUmdEU2p2TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQvam9icyI7fX0=', 1751882880);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `qualification` longtext DEFAULT NULL,
  `start_date` date NOT NULL,
  `deadline` date NOT NULL,
  `deadline_promotion` date NOT NULL,
  `provisions` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `status` enum('open','in progress','on-hold','completed','arbitrase-completed') NOT NULL,
  `revisions` int(11) NOT NULL,
  `category` text DEFAULT NULL,
  `job_file` varchar(255) DEFAULT NULL,
  `status_affiliate` tinyint(1) DEFAULT NULL,
  `pengajuan_affiliate` tinyint(1) DEFAULT NULL,
  `harga_pajak_affiliate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `client_id`, `profile_id`, `title`, `description`, `qualification`, `start_date`, `deadline`, `deadline_promotion`, `provisions`, `price`, `status`, `revisions`, `category`, `job_file`, `status_affiliate`, `pengajuan_affiliate`, `harga_pajak_affiliate`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Membuat website empowr', '<p>Situs web atau website adalah salah satu sarana penting yang bisa dimanfaatkan oleh bisnis maupun individu untuk berbagai tujuan. Baik untuk perusahaan kecil, perusahaan besar, maupun freelancer, website bisa menjadi senjata efektif untuk memperkenalkan diri Anda di internet.</p><p>Apalagi, bisa dibilang saat ini website hampir tak terpisahkan dari keseharian semua orang. Hampir semua orang menggunakan website untuk menemukan informasi, branding bisnis, menyajikan konten, promosi produk, bahkan mencari penghasilan.</p><p>Namun, sebenarnya apa itu website? Apa saja manfaat yang bisa didapat darinya? Nah, di artikel ini, kami akan membahas pengertian website dan cara kerjanya serta menjelaskan komponen, jenis, dan kategorinya. Langsung scroll ke bawah yuk!</p>', '<p><strong>Website adalah</strong> kumpulan halaman web atau ‘lokasi’ di internet tempat Anda menyimpan informasi dan menyajikannya agar bisa diakses oleh siapa pun secara online. Informasi ini bisa tentang diri Anda, bisnis, atau bahkan topik yang Anda minati.</p><p>Seperti ‘lokasi’ pada umumnya, website bekerja menggunakan sistem alamat yang akan memberitahukan lokasi tepatnya di internet sehingga Anda bisa mengaksesnya melalui web browser.</p><p>Penjelasan mudahnya, alamat tersebut mirip seperti alamat yang Anda gunakan untuk menuju suatu tempat di aplikasi maps. Ketika Anda mengakses alamat website, web browser akan menuju ke lokasi yang ditentukan dan mengambil file website tersebut.</p><p>Proses pengambilan informasi ini dilakukan oleh layanan web menggunakan teknologi seperti Hypertext Transfer Protocol (HTTP) dan <a href=\"https://www.hostinger.com/id/tutorial/ftp-adalah\" target=\"_blank\">File Transfer Protocol (FTP</a>). Protokol ini pada dasarnya berfungsi untuk menentukan cara informasi dan file ditransmisikan melalui web.</p>', '2025-07-20', '2025-07-26', '2025-07-12', '<p>Dengan Hostinger <a href=\"https://www.hostinger.com/id/website-builder\" target=\"_blank\">AI Website Builder</a>, Anda hanya perlu memasukkan beberapa kalimat, seperti nama brand dan deskripsi website, lalu tool ini akan langsung membuatkan template untuk Anda.</p><p>Selanjutnya Anda bisa menggunakan editor drag-and-drop, yang memungkinkan Anda mengedit semua elemen website secara intuitif cukup dengan menggeser beberapa elemen di layar editor.</p>', 1000.00, 'arbitrase-completed', 12, '[\"Game Development\",\"Frontend Development\",\"Full Stack Development\"]', NULL, 0, NULL, 0.00, '2025-07-07 05:30:58', '2025-07-07 09:14:53'),
(2, 2, 3, 'sefs', '<p>sdfsdfsdf</p>', '<p>sdfsdfsdf</p>', '2025-07-31', '2025-07-11', '2025-07-18', '<p><br></p>', 2000.00, 'arbitrase-completed', 1, '[\"Software Engineering\",\"Frontend Development\"]', NULL, 0, NULL, 0.00, '2025-07-07 08:09:26', '2025-07-07 08:52:07'),
(3, 2, 3, 'Asu', '<p>asu	</p>', '<p>asu</p>', '2025-07-16', '2025-07-23', '2025-07-24', '<p><br></p>', 1000.00, 'arbitrase-completed', 1, '[\"Game Development\",\"Frontend Development\",\"Full Stack Development\"]', NULL, 0, NULL, 0.00, '2025-07-07 08:47:40', '2025-07-07 09:15:46'),
(4, 2, 3, 'a', '<p>a</p>', '<p>a</p>', '2025-07-07', '2025-07-07', '2025-07-07', '<p><br></p>', 100.00, 'arbitrase-completed', 1, '[\"Mobile Development\"]', NULL, 0, NULL, 0.00, '2025-07-07 09:17:40', '2025-07-07 09:27:44'),
(5, 2, 3, 'b', '<p>b</p>', '<p>b</p>', '2025-07-08', '2025-07-30', '2025-07-06', '<p><br></p>', 100.00, 'in progress', 1, '[\"Game Development\",\"Frontend Development\"]', NULL, 0, NULL, 0.00, '2025-07-07 09:18:01', '2025-07-07 10:41:31'),
(6, 2, 1, 'c', '<p>c</p>', '<p>c</p>', '2025-07-22', '2025-07-15', '2025-07-17', '<p><br></p>', 100.00, 'arbitrase-completed', 1, '[\"Mobile Development\",\"Software Engineering\"]', NULL, 0, NULL, 0.00, '2025-07-07 09:18:21', '2025-07-07 09:33:20'),
(7, 2, 3, 'd', '<p>d</p>', '<p>d</p>', '2025-07-15', '2025-07-24', '2025-07-11', '<p><br></p>', 100.00, 'arbitrase-completed', 1, '[\"Mobile Development\"]', NULL, 0, NULL, 0.00, '2025-07-07 09:20:57', '2025-07-07 09:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `task_applications`
--

CREATE TABLE `task_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `catatan` text DEFAULT NULL,
  `bidPrice` double NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL,
  `affiliated` tinyint(1) DEFAULT 0,
  `harga_pajak_affiliate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `applied_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_progression`
--

CREATE TABLE `task_progression` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `action_by_client` bigint(20) UNSIGNED DEFAULT NULL,
  `action_by_worker` bigint(20) UNSIGNED DEFAULT NULL,
  `status_upload` enum('null','uploaded') NOT NULL DEFAULT 'null',
  `status_approve` enum('waiting','approved','rejected') NOT NULL DEFAULT 'waiting',
  `note` text DEFAULT NULL,
  `date_upload` datetime DEFAULT NULL,
  `date_approve` datetime DEFAULT NULL,
  `progression_ke` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_reviews`
--

CREATE TABLE `task_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reviewed_user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `task_id` bigint(20) UNSIGNED DEFAULT NULL,
  `worker_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('pending','success','cancel','expire') NOT NULL,
  `payment_method` enum('direct','ewallet') NOT NULL,
  `type` enum('payment','payout','topup','salary','refund') NOT NULL,
  `proof_transfer` varchar(255) DEFAULT NULL,
  `withdraw_method` enum('bank','ewallet') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `task_id`, `worker_id`, `client_id`, `amount`, `status`, `payment_method`, `type`, `proof_transfer`, `withdraw_method`, `created_at`, `updated_at`) VALUES
(1, '1-1-1751866321', 1, 1, 2, 1000.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-07-07 05:32:01', '2025-07-07 05:32:01'),
(2, 'pengembalian-1-31-1751870659', 1, 1, NULL, 900.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 06:44:19', '2025-07-07 06:44:19'),
(3, 'pengembalian-1-31-1751870659-client', 1, NULL, 3, 100.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 06:44:19', '2025-07-07 06:44:19'),
(4, 'pengembalian-1-31-1751871345', 1, 1, NULL, 500.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 06:55:45', '2025-07-07 06:55:45'),
(5, 'pengembalian-1-31-1751871345-client', 1, NULL, 3, 500.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 06:55:45', '2025-07-07 06:55:45'),
(6, 'pengembalian-1-31-1751871426', 1, 1, NULL, 500.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 06:57:06', '2025-07-07 06:57:06'),
(7, 'pengembalian-1-31-1751871426-client', 1, NULL, 3, 500.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 06:57:06', '2025-07-07 06:57:06'),
(8, 'pengembalian-1-21-1751871736', 1, 1, NULL, 0.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 07:02:16', '2025-07-07 07:02:16'),
(9, 'pengembalian-1-21-1751871736-client', 1, NULL, 2, 1000.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 07:02:16', '2025-07-07 07:02:16'),
(10, 'pengembalian-1-21-1751871841', 1, 1, NULL, 500.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 07:04:01', '2025-07-07 07:04:01'),
(11, 'pengembalian-1-21-1751871841-client', 1, NULL, 2, 500.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 07:04:01', '2025-07-07 07:04:01'),
(12, '2-3-1751875853', 2, 3, 2, 2000.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-07-07 08:10:53', '2025-07-07 08:10:53'),
(13, 'pengembalian-2-23-1751876027', 2, 3, NULL, 1000.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:13:47', '2025-07-07 08:13:47'),
(14, 'pengembalian-2-23-1751876027-client', 2, NULL, 2, 1000.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:13:47', '2025-07-07 08:13:47'),
(15, 'pengembalian-1-21-1751876061', 1, 1, NULL, 900.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:14:21', '2025-07-07 08:14:21'),
(16, 'pengembalian-1-21-1751876061-client', 1, NULL, 2, 100.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:14:21', '2025-07-07 08:14:21'),
(17, 'pengembalian-2-23-1751876519', 2, 3, NULL, 1800.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:21:59', '2025-07-07 08:21:59'),
(18, 'pengembalian-2-23-1751876519-client', 2, NULL, 2, 200.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:21:59', '2025-07-07 08:21:59'),
(19, 'pengembalian-2-23-1751876651', 2, 3, NULL, 1800.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:24:11', '2025-07-07 08:24:11'),
(20, 'pengembalian-2-23-1751876651-client', 2, NULL, 2, 200.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:24:11', '2025-07-07 08:24:11'),
(21, 'pengembalian-2-23-1751876753', 2, 3, NULL, 1800.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:25:53', '2025-07-07 08:25:53'),
(22, 'pengembalian-2-23-1751876753-client', 2, NULL, 2, 200.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:25:53', '2025-07-07 08:25:53'),
(23, 'pengembalian-2-23-1751876851', 2, 3, NULL, 1800.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:27:31', '2025-07-07 08:27:31'),
(24, 'pengembalian-2-23-1751876851-client', 2, NULL, 2, 200.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:27:31', '2025-07-07 08:27:31'),
(25, 'pengembalian-2-23-1751877362', 2, 3, NULL, 200.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:36:02', '2025-07-07 08:36:02'),
(26, 'pengembalian-2-23-1751877362-client', 2, NULL, 2, 1800.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:36:02', '2025-07-07 08:36:02'),
(27, 'pengembalian-2-23-1751877525', 2, 3, NULL, 1800.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:38:45', '2025-07-07 08:38:45'),
(28, 'pengembalian-2-23-1751877525-client', 2, NULL, 2, 200.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:38:45', '2025-07-07 08:38:45'),
(30, 'pengembalian-2-25-1751877982', 2, 3, NULL, 1800.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:46:22', '2025-07-07 08:46:22'),
(31, 'pengembalian-2-25-1751877982-client', 2, NULL, 2, 200.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:46:22', '2025-07-07 08:46:22'),
(32, '3-3-1751878219', 3, 3, 2, 1000.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-07-07 08:50:19', '2025-07-07 08:50:19'),
(33, 'pengembalian-2-25-1751878327', 2, 3, NULL, 200.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:52:07', '2025-07-07 08:52:07'),
(34, 'pengembalian-2-25-1751878327-client', 2, NULL, 2, 1800.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:52:07', '2025-07-07 08:52:07'),
(35, 'pengembalian-1-21-1751878384', 1, 1, NULL, 900.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:53:04', '2025-07-07 08:53:04'),
(36, 'pengembalian-1-21-1751878384-client', 1, NULL, 2, 100.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 08:53:04', '2025-07-07 08:53:04'),
(41, 'pengembalian-1-21-1751878901', 1, 1, NULL, 900.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:01:41', '2025-07-07 09:01:41'),
(42, 'pengembalian-1-21-1751878901-client', 1, NULL, 2, 100.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:01:41', '2025-07-07 09:01:41'),
(44, 'pengembalian-1-21-1751879300', 1, 1, NULL, 900.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:08:20', '2025-07-07 09:08:20'),
(45, 'pengembalian-1-21-1751879300-client', 1, NULL, 2, 100.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:08:20', '2025-07-07 09:08:20'),
(49, 'pengembalian-1-21-1751879693', 1, 1, NULL, 900.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:14:53', '2025-07-07 09:14:53'),
(50, 'pengembalian-1-21-1751879693-client', 1, NULL, 2, 100.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:14:53', '2025-07-07 09:14:53'),
(51, 'pengembalian-3-23-1751879746', 3, 3, NULL, 100.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:15:46', '2025-07-07 09:15:46'),
(52, 'pengembalian-3-23-1751879746-client', 3, NULL, 2, 900.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:15:46', '2025-07-07 09:15:46'),
(53, '4-3-1751879978', 4, 3, 2, 100.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-07-07 09:19:38', '2025-07-07 09:19:38'),
(54, '5-3-1751879987', 5, 3, 2, 100.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-07-07 09:19:47', '2025-07-07 09:19:47'),
(55, '6-1-1751879996', 6, 1, 2, 100.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-07-07 09:19:56', '2025-07-07 09:19:56'),
(56, '7-3-1751880093', 7, 3, 2, 100.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-07-07 09:21:33', '2025-07-07 09:21:33'),
(57, 'pengembalian-4-23-1751880225', 4, 3, NULL, 90.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:23:45', '2025-07-07 09:23:45'),
(58, 'pengembalian-4-23-1751880225-client', 4, NULL, 2, 10.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:23:45', '2025-07-07 09:23:45'),
(59, 'pengembalian-4-23-1751880464', 4, 3, NULL, 90.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:27:44', '2025-07-07 09:27:44'),
(60, 'pengembalian-4-23-1751880464-client', 4, NULL, 2, 10.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:27:44', '2025-07-07 09:27:44'),
(61, 'pengembalian-7-23-1751880534', 7, 3, NULL, 40.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:28:54', '2025-07-07 09:28:54'),
(62, 'pengembalian-7-23-1751880534-client', 7, NULL, 2, 60.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:28:54', '2025-07-07 09:28:54'),
(63, 'pengembalian-7-23-1751880637', 7, 3, NULL, 40.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:30:37', '2025-07-07 09:30:37'),
(64, 'pengembalian-7-23-1751880637-client', 7, NULL, 2, 60.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:30:37', '2025-07-07 09:30:37'),
(65, 'pengembalian-6-21-1751880800', 6, 1, NULL, 35.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:33:20', '2025-07-07 09:33:20'),
(66, 'pengembalian-6-21-1751880800-client', 6, NULL, 2, 65.00, 'success', 'ewallet', 'refund', NULL, NULL, '2025-07-07 09:33:20', '2025-07-07 09:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('worker','client','admin') NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(255) DEFAULT NULL,
  `tanggal_bergabung` timestamp NOT NULL DEFAULT current_timestamp(),
  `linkedin` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `profile_image`, `nomor_telepon`, `tanggal_bergabung`, `linkedin`, `bio`, `created_at`, `updated_at`, `avatar`) VALUES
(1, 'Risfrhn', '$2y$12$2hGNVUIcNI6uzc5O6lxHFeIfQdtVdWocHGXFE3mGEjwdCLzUym7hS', 'Muhammad Risky Farhan', 'riskyWorker@gmail.com', 'worker', NULL, '081328961251', '2025-07-07 05:27:49', NULL, NULL, '2025-07-07 05:27:50', '2025-07-07 05:27:50', 'avatar.png'),
(2, 'Budbud', '$2y$12$faINVp7rcHw2Ra9muEVhQeV5xqNpG/4mQ6p3TnLOHRAa2msRZG606', 'Budi yudiono', 'budiClient@gmail.com', 'client', NULL, '08431217622', '2025-07-07 05:28:41', NULL, NULL, '2025-07-07 05:28:42', '2025-07-07 05:28:42', 'avatar.png'),
(3, 'admin', '$2y$12$Cp04vneRMHSO1e2cyEFwN.RoPNY540WOiugL/4Rsv5xrxlSFxvHLq', 'admin empowr', 'admin@gmail.com', 'admin', NULL, '08121421233', '2025-07-07 06:06:02', NULL, NULL, '2025-07-07 06:06:02', '2025-07-07 06:06:02', 'avatar.png'),
(4, 'agoy', '$2y$12$o6GOOrxgwicYcVgyJ26NCe7Tn4J4YxQm6OsPx/uLwYsa/EKc1Vg9m', 'agoyWorker', 'agoy@gmail.com', 'worker', NULL, '08654214623', '2025-07-07 08:07:23', NULL, NULL, '2025-07-07 08:07:23', '2025-07-07 08:07:23', 'avatar.png'),
(5, 'agus', '$2y$12$Ky7IcSPmLhU2lXnkTxUNxOvU.2gss99pENf5F.unTfsopxWtCQlve', 'agusWorker', 'agusWorker@gmail.com', 'worker', NULL, '08542234212', '2025-07-07 08:08:31', NULL, NULL, '2025-07-07 08:08:31', '2025-07-07 08:08:31', 'avatar.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_accounts`
--

CREATE TABLE `user_payment_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_type` enum('ewallet','bank','Tidak ada') DEFAULT 'Tidak ada',
  `account_number` varchar(255) DEFAULT 'Tidak ada',
  `bank_account_name` varchar(255) DEFAULT 'Tidak ada',
  `bank_name` enum('BCA','BNI','BRI','Mandiri','CIMB Niaga','Danamon','Permata','BTN','Maybank','OCBC NISP','Panin','Bank Jago','BSI','Bank DKI','Bank Jabar Banten (BJB)','Bank Sumut','Bank Nagari','Bank Aceh','Bank Kaltimtara','Bank Kalsel','Bank Kalteng','Bank Papua','Bank NTB Syariah','Bank NTT','Bank Sulselbar','Bank SulutGo','Bank Bengkulu','Bank Riau Kepri','Bank Maluku Malut','Bank Lampung','Bank Sumsel Babel','Tidak ada') DEFAULT 'Tidak ada',
  `ewallet_provider` enum('Gopay','OVO','DANA','ShopeePay','LinkAja','Jenius Pay','Sakuku','iSaku','Paytren','Tidak ada') DEFAULT 'Tidak ada',
  `wallet_number` varchar(255) DEFAULT 'Tidak ada',
  `ewallet_account_name` varchar(255) DEFAULT 'Tidak ada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ewallet_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_payment_accounts`
--

INSERT INTO `user_payment_accounts` (`id`, `user_id`, `account_type`, `account_number`, `bank_account_name`, `bank_name`, `ewallet_provider`, `wallet_number`, `ewallet_account_name`, `created_at`, `updated_at`, `ewallet_name`) VALUES
(1, 1, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-07-07 05:27:50', '2025-07-07 05:27:50', NULL),
(2, 2, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-07-07 05:28:42', '2025-07-07 05:28:42', NULL),
(3, 3, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-07-07 06:06:02', '2025-07-07 06:06:02', NULL),
(4, 4, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-07-07 08:07:23', '2025-07-07 08:07:23', NULL),
(5, 5, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-07-07 08:08:31', '2025-07-07 08:08:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `worker_profiles`
--

CREATE TABLE `worker_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tingkat_keahlian` enum('Beginner','Intermediate','Expert') DEFAULT NULL,
  `keahlian` text DEFAULT NULL,
  `empowr_label` tinyint(1) NOT NULL DEFAULT 0,
  `empowr_affiliate` tinyint(1) NOT NULL DEFAULT 0,
  `cv` varchar(255) DEFAULT NULL,
  `pengalaman_kerja` text DEFAULT NULL,
  `pendidikan` text DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `tanggal_diperbarui` timestamp NOT NULL DEFAULT current_timestamp(),
  `keahlian_affiliate` varchar(255) DEFAULT NULL,
  `identity_photo` varchar(255) DEFAULT NULL,
  `selfie_with_id` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `affiliated_since` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worker_profiles`
--

INSERT INTO `worker_profiles` (`id`, `user_id`, `tingkat_keahlian`, `keahlian`, `empowr_label`, `empowr_affiliate`, `cv`, `pengalaman_kerja`, `pendidikan`, `status_aktif`, `tanggal_diperbarui`, `keahlian_affiliate`, `identity_photo`, `selfie_with_id`, `linkedin`, `affiliated_since`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '[]', 0, 0, NULL, NULL, NULL, 1, '2025-07-07 05:27:50', NULL, NULL, NULL, NULL, NULL, '2025-07-07 05:27:50', '2025-07-07 05:27:50'),
(2, 4, NULL, '[]', 0, 0, NULL, NULL, NULL, 1, '2025-07-07 08:07:23', NULL, NULL, NULL, NULL, NULL, '2025-07-07 08:07:23', '2025-07-07 08:07:23'),
(3, 5, NULL, '[]', 0, 0, NULL, NULL, NULL, 1, '2025-07-07 08:08:31', NULL, NULL, NULL, NULL, NULL, '2025-07-07 08:08:31', '2025-07-07 08:08:31');

-- --------------------------------------------------------

--
-- Table structure for table `worker_verification_affiliations`
--

CREATE TABLE `worker_verification_affiliations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `identity_photo` varchar(255) NOT NULL,
  `selfie_with_id` varchar(255) NOT NULL,
  `link_meet` varchar(255) DEFAULT NULL,
  `keahlian_affiliate` text NOT NULL,
  `status` enum('pending','reviewed','Interview','result') NOT NULL DEFAULT 'pending',
  `status_decision` enum('approve','rejected','waiting') NOT NULL DEFAULT 'waiting',
  `jadwal_interview` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `worker_verification_affiliation_logs`
--

CREATE TABLE `worker_verification_affiliation_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `affiliation_id` bigint(20) UNSIGNED NOT NULL,
  `action_admin` bigint(20) UNSIGNED DEFAULT NULL,
  `status_decision` enum('waiting','approved','rejected') NOT NULL DEFAULT 'waiting',
  `status` enum('pending','reviewed','Interview','result') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arbitrase`
--
ALTER TABLE `arbitrase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arbitrase_task_id_foreign` (`task_id`),
  ADD KEY `arbitrase_pelapor_foreign` (`pelapor`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `certified_applications`
--
ALTER TABLE `certified_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `certified_applications_profile_id_foreign` (`profile_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conversations_user_id_other_user_id_unique` (`user_id`,`other_user_id`),
  ADD KEY `conversations_other_user_id_foreign` (`other_user_id`);

--
-- Indexes for table `escrow_payments`
--
ALTER TABLE `escrow_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `escrow_payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `ewallet`
--
ALTER TABLE `ewallet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ewallet_user_id_unique` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `midtrans_transactions`
--
ALTER TABLE `midtrans_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `midtrans_transactions_client_id_foreign` (`client_id`),
  ADD KEY `midtrans_transactions_task_id_foreign` (`task_id`),
  ADD KEY `midtrans_transactions_escrow_id_foreign` (`escrow_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_codes_email_index` (`email`);

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
-- Indexes for table `portofolios`
--
ALTER TABLE `portofolios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portofolios_worker_id_foreign` (`worker_id`);

--
-- Indexes for table `portofolio_images`
--
ALTER TABLE `portofolio_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portofolio_images_portofolio_id_foreign` (`portofolio_id`);

--
-- Indexes for table `sertifikasi`
--
ALTER TABLE `sertifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sertifikasi_worker_id_foreign` (`worker_id`);

--
-- Indexes for table `sertifikasi_images`
--
ALTER TABLE `sertifikasi_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sertifikasi_images_sertifikasi_id_foreign` (`sertifikasi_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_client_id_foreign` (`client_id`),
  ADD KEY `task_profile_id_foreign` (`profile_id`);

--
-- Indexes for table `task_applications`
--
ALTER TABLE `task_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_applications_task_id_foreign` (`task_id`),
  ADD KEY `task_applications_profile_id_foreign` (`profile_id`);

--
-- Indexes for table `task_progression`
--
ALTER TABLE `task_progression`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_progression_task_id_foreign` (`task_id`),
  ADD KEY `task_progression_action_by_client_foreign` (`action_by_client`),
  ADD KEY `task_progression_action_by_worker_foreign` (`action_by_worker`);

--
-- Indexes for table `task_reviews`
--
ALTER TABLE `task_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_reviews_task_id_foreign` (`task_id`),
  ADD KEY `task_reviews_user_id_foreign` (`user_id`),
  ADD KEY `task_reviews_reviewed_user_id_foreign` (`reviewed_user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_order_id_unique` (`order_id`),
  ADD KEY `transactions_task_id_foreign` (`task_id`),
  ADD KEY `transactions_worker_id_foreign` (`worker_id`),
  ADD KEY `transactions_client_id_foreign` (`client_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_payment_accounts`
--
ALTER TABLE `user_payment_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_payment_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `worker_profiles`
--
ALTER TABLE `worker_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worker_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `worker_verification_affiliations`
--
ALTER TABLE `worker_verification_affiliations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worker_verification_affiliations_profile_id_foreign` (`profile_id`);

--
-- Indexes for table `worker_verification_affiliation_logs`
--
ALTER TABLE `worker_verification_affiliation_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worker_verification_affiliation_logs_affiliation_id_foreign` (`affiliation_id`),
  ADD KEY `worker_verification_affiliation_logs_action_admin_foreign` (`action_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arbitrase`
--
ALTER TABLE `arbitrase`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `certified_applications`
--
ALTER TABLE `certified_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `escrow_payments`
--
ALTER TABLE `escrow_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ewallet`
--
ALTER TABLE `ewallet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `midtrans_transactions`
--
ALTER TABLE `midtrans_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portofolios`
--
ALTER TABLE `portofolios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portofolio_images`
--
ALTER TABLE `portofolio_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sertifikasi`
--
ALTER TABLE `sertifikasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sertifikasi_images`
--
ALTER TABLE `sertifikasi_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `task_applications`
--
ALTER TABLE `task_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `task_progression`
--
ALTER TABLE `task_progression`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_reviews`
--
ALTER TABLE `task_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_payment_accounts`
--
ALTER TABLE `user_payment_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `worker_profiles`
--
ALTER TABLE `worker_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `worker_verification_affiliations`
--
ALTER TABLE `worker_verification_affiliations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `worker_verification_affiliation_logs`
--
ALTER TABLE `worker_verification_affiliation_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arbitrase`
--
ALTER TABLE `arbitrase`
  ADD CONSTRAINT `arbitrase_pelapor_foreign` FOREIGN KEY (`pelapor`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `arbitrase_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certified_applications`
--
ALTER TABLE `certified_applications`
  ADD CONSTRAINT `certified_applications_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `worker_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_other_user_id_foreign` FOREIGN KEY (`other_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `escrow_payments`
--
ALTER TABLE `escrow_payments`
  ADD CONSTRAINT `escrow_payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ewallet`
--
ALTER TABLE `ewallet`
  ADD CONSTRAINT `ewallet_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `midtrans_transactions`
--
ALTER TABLE `midtrans_transactions`
  ADD CONSTRAINT `midtrans_transactions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `midtrans_transactions_escrow_id_foreign` FOREIGN KEY (`escrow_id`) REFERENCES `escrow_payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `midtrans_transactions_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portofolios`
--
ALTER TABLE `portofolios`
  ADD CONSTRAINT `portofolios_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `worker_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `portofolio_images`
--
ALTER TABLE `portofolio_images`
  ADD CONSTRAINT `portofolio_images_portofolio_id_foreign` FOREIGN KEY (`portofolio_id`) REFERENCES `portofolios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sertifikasi`
--
ALTER TABLE `sertifikasi`
  ADD CONSTRAINT `sertifikasi_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `worker_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sertifikasi_images`
--
ALTER TABLE `sertifikasi_images`
  ADD CONSTRAINT `sertifikasi_images_sertifikasi_id_foreign` FOREIGN KEY (`sertifikasi_id`) REFERENCES `sertifikasi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `worker_profiles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `task_applications`
--
ALTER TABLE `task_applications`
  ADD CONSTRAINT `task_applications_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `worker_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_applications_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_progression`
--
ALTER TABLE `task_progression`
  ADD CONSTRAINT `task_progression_action_by_client_foreign` FOREIGN KEY (`action_by_client`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `task_progression_action_by_worker_foreign` FOREIGN KEY (`action_by_worker`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `task_progression_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_reviews`
--
ALTER TABLE `task_reviews`
  ADD CONSTRAINT `task_reviews_reviewed_user_id_foreign` FOREIGN KEY (`reviewed_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_reviews_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `worker_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_payment_accounts`
--
ALTER TABLE `user_payment_accounts`
  ADD CONSTRAINT `user_payment_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `worker_profiles`
--
ALTER TABLE `worker_profiles`
  ADD CONSTRAINT `worker_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `worker_verification_affiliations`
--
ALTER TABLE `worker_verification_affiliations`
  ADD CONSTRAINT `worker_verification_affiliations_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `worker_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `worker_verification_affiliation_logs`
--
ALTER TABLE `worker_verification_affiliation_logs`
  ADD CONSTRAINT `worker_verification_affiliation_logs_action_admin_foreign` FOREIGN KEY (`action_admin`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `worker_verification_affiliation_logs_affiliation_id_foreign` FOREIGN KEY (`affiliation_id`) REFERENCES `worker_verification_affiliations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
