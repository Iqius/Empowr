-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 04, 2025 at 07:22 PM
-- Server version: 8.4.3
-- PHP Version: 8.2.27

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
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `worker_id` bigint UNSIGNED NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('open','under review','resolved') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certified_applications`
--

CREATE TABLE `certified_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  `status` enum('application stage','viewed','selection test','interview selection','selection results') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `other_user_id` bigint UNSIGNED NOT NULL,
  `last_time_message` timestamp NULL DEFAULT NULL,
  `unread_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `user_id`, `other_user_id`, `last_time_message`, `unread_count`, `created_at`, `updated_at`) VALUES
(7, 4, 1, '2025-07-04 13:17:15', 0, '2025-07-04 13:17:15', '2025-07-04 13:17:15'),
(8, 1, 4, '2025-07-04 13:17:15', 0, '2025-07-04 13:17:15', '2025-07-04 13:17:15'),
(9, 4, 0, '2025-07-04 13:17:32', 0, '2025-07-04 13:17:32', '2025-07-04 13:17:32'),
(10, 0, 4, '2025-07-04 13:17:32', 0, '2025-07-04 13:17:32', '2025-07-04 13:17:32'),
(11, 4, 3, '2025-07-04 13:18:17', 0, '2025-07-04 13:18:17', '2025-07-04 13:18:17'),
(12, 3, 4, '2025-07-04 13:18:17', 0, '2025-07-04 13:18:17', '2025-07-04 13:18:17'),
(13, 3, 0, '2025-07-04 13:23:48', 0, '2025-07-04 13:23:48', '2025-07-04 13:23:48'),
(14, 0, 3, '2025-07-04 13:23:48', 0, '2025-07-04 13:23:48', '2025-07-04 13:23:48');

-- --------------------------------------------------------

--
-- Table structure for table `escrow_payments`
--

CREATE TABLE `escrow_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `status` enum('holding','released','disputed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `released_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ewallet`
--

CREATE TABLE `ewallet` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ewallet`
--

INSERT INTO `ewallet` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 1, 9345000.00, '2025-05-27 15:47:15', '2025-06-01 19:25:29'),
(2, 2, 0.00, '2025-05-27 15:47:40', '2025-05-27 15:47:40'),
(3, 3, 3348889.00, '2025-05-27 15:48:08', '2025-07-04 19:21:04'),
(4, 4, 30000.00, '2025-05-27 19:26:16', '2025-05-29 13:32:09'),
(5, 5, 0.00, '2025-06-18 15:47:26', '2025-06-18 15:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_by_sender` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_by_receiver` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `midtrans_transactions`
--

CREATE TABLE `midtrans_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `escrow_id` bigint UNSIGNED NOT NULL,
  `transaction_status` enum('pending','success','failed','expired','refund') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_amount` double NOT NULL,
  `midtrans_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2025_03_12_083705_add_profile_fields_to_users', 1),
(4, '2025_03_24_999999_add_avatar_to_users', 1),
(5, '2025_04_16_033124_create_user_payment_accounts_table', 1),
(6, '2025_04_16_034519_create_worker_profiles_table', 1),
(7, '2025_04_16_034520_create_task_table', 1),
(8, '2025_04_16_034521_create_escrow_payments_table', 1),
(9, '2025_04_16_034523_create_payouts_table', 1),
(10, '2025_04_16_034744_create_task_applications_table', 1),
(11, '2025_04_16_034832_create_task_assignments_table', 1),
(12, '2025_04_16_034915_create_task_reviews_table', 1),
(13, '2025_04_16_035201_create_midtrans_transactions_table', 1),
(14, '2025_04_16_035307_create_arbitrase_table', 1),
(15, '2025_04_16_035533_create_portofolios_table', 1),
(16, '2025_04_16_035603_create_portofolios_images', 1),
(17, '2025_04_16_035635_create_sertifikasi_table', 1),
(18, '2025_04_16_035659_create_sertifikasi_images_table', 1),
(19, '2025_04_16_035742_create_certified_applications_table', 1),
(20, '2025_04_18_024818_create_otp_codes_table', 1),
(21, '2025_04_22_055134_create_personal_access_tokens_table', 1),
(22, '2025_04_23_052815_create_notifications_table', 1),
(23, '2025_04_24_031926_create_task_progression_table', 1),
(24, '2025_05_06_114048_create_messages_table', 1),
(25, '2025_05_06_114109_create_conversations_table', 1),
(26, '2025_05_07_145916_modify_created_at_nullable_on_arbitrase_table', 1),
(27, '2025_05_17_144734_create_transactions_table', 1),
(28, '2025_05_17_153441_create_ewallet_table', 1),
(29, '2025_05_27_222406_create_worker_verification_affiliations_table', 1),
(30, '2025_05_27_222407_create_worker_verification_affiliations_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sender_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `jenis` enum('chat','arbitrase','pembayaran','applicant') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'chat',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `sender_name`, `message`, `is_read`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-28 01:13:34', '2025-05-28 07:38:08'),
(2, 1, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-28 06:49:45', '2025-05-28 07:38:08'),
(3, 1, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-28 07:07:27', '2025-05-28 07:38:08'),
(4, 1, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-28 07:34:54', '2025-05-28 07:38:08'),
(5, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 11:53:10', '2025-06-01 10:34:34'),
(6, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 11:53:42', '2025-06-01 10:34:34'),
(7, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 11:54:14', '2025-06-01 10:34:34'),
(8, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 11:58:24', '2025-06-01 10:34:34'),
(9, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 11:59:40', '2025-06-01 10:34:34'),
(10, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 12:01:34', '2025-06-01 10:34:34'),
(11, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 12:01:35', '2025-06-01 10:34:34'),
(12, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 12:02:02', '2025-06-01 10:34:34'),
(13, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 12:02:20', '2025-06-01 10:34:34'),
(14, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 12:03:50', '2025-06-01 10:34:34'),
(15, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 12:04:06', '2025-06-01 10:34:34'),
(16, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 12:04:25', '2025-06-01 10:34:34'),
(17, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 1, 'chat', '2025-05-29 13:04:45', '2025-06-01 10:34:34'),
(18, 4, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 0, 'chat', '2025-07-04 08:36:00', '2025-07-04 08:36:00'),
(19, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 0, 'chat', '2025-07-04 17:18:12', '2025-07-04 17:18:12'),
(20, 3, 'admin empowr', 'Maaf pengajuan affiliate telah ditolak.', 0, 'chat', '2025-07-04 18:10:39', '2025-07-04 18:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` bigint UNSIGNED NOT NULL,
  `escrow_id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  `payment_account_id` bigint UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `status` enum('pending','processed','failed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `processed_at` datetime DEFAULT NULL
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
-- Table structure for table `portofolios`
--

CREATE TABLE `portofolios` (
  `id` bigint UNSIGNED NOT NULL,
  `worker_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portofolios`
--

INSERT INTO `portofolios` (`id`, `worker_id`, `title`, `description`, `duration`, `created_at`, `updated_at`) VALUES
(1, 2, 'p', 'p', 200, '2025-07-04 11:25:19', '2025-07-04 11:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `portofolio_images`
--

CREATE TABLE `portofolio_images` (
  `id` bigint UNSIGNED NOT NULL,
  `portofolio_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portofolio_images`
--

INSERT INTO `portofolio_images` (`id`, `portofolio_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'images/portofolio/udin-worker/1751628319453-mindmend_page-0001.jpg', '2025-07-04 11:25:19', '2025-07-04 11:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikasi`
--

CREATE TABLE `sertifikasi` (
  `id` bigint UNSIGNED NOT NULL,
  `worker_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sertifikasi_images`
--

CREATE TABLE `sertifikasi_images` (
  `id` bigint UNSIGNED NOT NULL,
  `sertifikasi_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ct3eJUfQtwDmfiZmbAvaa0UWlt1KsZVzn49a151q', 0, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTG1yZVVvQ1dhTkJNNEFWZmt0dFVwY3JkWnZ0N0dTNzBJNGJQeGhORyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZC9NeWpvYnMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2NoZWNrLXNlc3Npb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTowO3M6OToidXNlcl9kYXRhIjthOjQ6e3M6MjoiaWQiO2k6MDtzOjQ6Im5hbWUiO3M6NToiYWRtaW4iO3M6NDoicm9sZSI7czo1OiJhZG1pbiI7czo1OiJlbWFpbCI7czoxNToiYWRtaW5AZ21haWwuY29tIjt9fQ==', 1751656867),
('hsKg7pq6uFxBfVCE6yl1u4t89DbC4502th6E2nBt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT3JMYVdwalNWOVFVT3IzN3NUMXFuOWhTbXpYQnhINmM0N2U2bDJRMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVjay1zZXNzaW9uIjt9czo5OiJ1c2VyX2RhdGEiO2E6NDp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo1OiJSaXNreSI7czo0OiJyb2xlIjtzOjY6IndvcmtlciI7czo1OiJlbWFpbCI7czoxNjoid29ya2VyQGdtYWlsLmNvbSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1751656869),
('OT20YkMYQFehbuChg86BhEamJlgJThGL0eWejvK6', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiME9FUWdrcnRTdkRyNTJrNjFsV1pqU1RlY0JETVZDWTI3WkQyUjNzUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVjay1zZXNzaW9uIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJ1c2VyX2RhdGEiO2E6NDp7czoyOiJpZCI7aTozO3M6NDoibmFtZSI7czo3OiJSaXNmcmhuIjtzOjQ6InJvbGUiO3M6NjoiY2xpZW50IjtzOjU6ImVtYWlsIjtzOjE2OiJjbGllbnRAZ21haWwuY29tIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1751656919);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `qualification` longtext COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `deadline` date NOT NULL,
  `deadline_promotion` date NOT NULL,
  `provisions` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(15,2) NOT NULL,
  `status` enum('open','in progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisions` int NOT NULL,
  `category` text COLLATE utf8mb4_unicode_ci,
  `job_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_affiliate` tinyint(1) DEFAULT '0',
  `pengajuan_affiliate` tinyint(1) DEFAULT '0',
  `harga_pajak_affiliate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `harga_task_affiliate` decimal(15,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `client_id`, `profile_id`, `title`, `description`, `qualification`, `start_date`, `deadline`, `deadline_promotion`, `provisions`, `price`, `status`, `revisions`, `category`, `job_file`, `created_at`, `updated_at`, `status_affiliate`, `pengajuan_affiliate`, `harga_pajak_affiliate`, `harga_task_affiliate`) VALUES
(2, 3, 2, 'sadasd', '<p>asdasda</p>', '<p>asdasdasd</p>', '2025-05-28', '2025-05-30', '2025-05-29', '<p><br></p>', 20000.00, 'completed', 2, '[\"Backend Development\",\"Game Development\",\"Software Engineering\"]', NULL, '2025-05-27 19:30:01', '2025-05-29 13:32:09', 1, 1, 10000.00, 10000.00),
(3, 3, 1, 'Membuat topologi jaringan PT XYZ', '<h1><strong>Deskripsi Proyek</strong></h1><p>Tugas ini bertujuan untuk merancang dan mendokumentasikan sebuah <strong>topologi jaringan</strong> yang efisien dan skalabel untuk memenuhi kebutuhan spesifik suatu organisasi (misalnya, kantor cabang baru, pusat data kecil, atau peningkatan infrastruktur). Topologi ini harus mencakup perangkat keras, perangkat lunak, dan konfigurasi logis yang diperlukan untuk mendukung operasional jaringan yang handal dan aman.</p>', '<h1><strong>Kualifikasi</strong></h1><ol><li><strong>Pendidikan</strong>: Gelar D3/S1 di bidang Teknik Komputer, Teknik Informatika, Sistem Informasi, atau bidang terkait. Sertifikasi relevan seperti <strong>CCNA (Cisco Certified Network Associate)</strong> atau setara akan sangat dihargai.</li><li><strong>Pengalaman</strong>: Minimal 2 tahun pengalaman praktis dalam merancang, mengimplementasikan, dan mengelola jaringan komputer.</li><li><strong>Keterampilan Teknis</strong>:</li></ol><ul><li class=\"ql-indent-1\">Pemahaman mendalam tentang model <strong>OSI Layer</strong> dan <strong>TCP/IP</strong>.</li><li class=\"ql-indent-1\">Mahir dalam konfigurasi <em>router</em> dan <em>switch</em> dari berbagai vendor (Cisco, Juniper, Mikrotik, dll.).</li><li class=\"ql-indent-1\">Pengalaman dengan protokol <em>routing</em> (OSPF, EIGRP, BGP) dan <em>switching</em> (VLAN, STP, EtherChannel).</li><li class=\"ql-indent-1\">Pengetahuan tentang konsep keamanan jaringan (<em>firewall, VPN, ACL, NAT</em>).</li><li class=\"ql-indent-1\">Mampu menggunakan <em>tools</em> simulasi dan desain jaringan (Packet Tracer, GNS3, Visio).</li></ul><ol><li><strong>Keterampilan Non-Teknis</strong>:</li></ol><ul><li class=\"ql-indent-1\">Kemampuan analisis dan pemecahan masalah yang kuat.</li><li class=\"ql-indent-1\">Kemampuan mendokumentasikan proyek dengan jelas dan sistematis.</li><li class=\"ql-indent-1\">Teliti dan berorientasi pada detail.</li><li class=\"ql-indent-1\">Mampu bekerja secara mandiri maupun dalam tim.</li></ul><p><br></p>', '2025-06-22', '2025-06-28', '2025-06-15', '<h1><strong>Ketentuan Teknis</strong></h1><ol><li><strong>Analisis Kebutuhan</strong>:</li></ol><ul><li class=\"ql-indent-1\">Identifikasi jumlah pengguna, jenis aplikasi yang digunakan, dan persyaratan throughput jaringan.</li><li class=\"ql-indent-1\">Tentukan kebutuhan akan ketersediaan tinggi, keamanan, dan skalabilitas di masa mendatang.</li></ul><ol><li><strong>Perancangan Topologi Fisik</strong>:</li></ol><ul><li class=\"ql-indent-1\">Sertakan setidaknya dua <strong>router</strong> (misalnya, satu untuk koneksi internet, satu untuk routing internal).</li><li class=\"ql-indent-1\">Sertakan setidaknya tiga <strong>switch</strong> (misalnya, satu <em>core switch</em>, dua <em>access switch</em>).</li><li class=\"ql-indent-1\">Sertakan setidaknya sepuluh <strong>perangkat akhir</strong> (PC, laptop, printer, server) yang terhubung ke jaringan.</li><li class=\"ql-indent-1\">Gambarkan penempatan fisik perangkat dan koneksi kabel (misalnya, serat optik, <em>UTP Cat 6</em>) menggunakan diagram yang jelas.</li></ul><ol><li><strong>Perancangan Topologi Logis</strong>:</li></ol><ul><li class=\"ql-indent-1\">Tentukan skema <strong>pengalamatan IP</strong> yang efisien (IPv4 atau IPv6, atau kombinasi keduanya) dengan penggunaan <em>subnetting</em> yang tepat.</li><li class=\"ql-indent-1\">Konfigurasikan <strong>VLAN</strong> untuk segmentasi jaringan (misalnya, divisi HR, divisi IT, <em>Guest Wi-Fi</em>) dan pastikan komunikasi antar-VLAN dapat diatur.</li><li class=\"ql-indent-1\">Terapkan protokol <em>routing</em> yang sesuai (misalnya, <strong>OSPF, EIGRP, atau BGP</strong> jika ada koneksi eksternal).</li><li>Rencanakan <strong>keamanan jaringan</strong> dasar:</li><li class=\"ql-indent-2\">Implementasi <em>firewall rules</em> untuk membatasi akses yang tidak sah.</li><li class=\"ql-indent-2\">Penggunaan <strong>ACL (Access Control List)</strong> untuk memfilter <em>traffic</em>.</li><li class=\"ql-indent-1\">Rekomendasi untuk otentikasi pengguna dan perangkat.</li></ul><ol><li><strong>Dokumentasi</strong>:</li></ol><ul><li class=\"ql-indent-1\">Sediakan <strong>diagram topologi</strong> yang jelas dan profesional (menggunakan <em>tool</em> seperti Cisco Packet Tracer, GNS3, Visio, atau Draw.io).</li><li class=\"ql-indent-1\">Sertakan <strong>tabel pengalamatan IP</strong> yang detail.</li><li class=\"ql-indent-1\">Berikan <strong>daftar perangkat keras</strong> yang direkomendasikan beserta spesifikasinya.</li><li class=\"ql-indent-1\">Sertakan <strong>penjelasan naratif</strong> mengenai setiap aspek perancangan dan alasan di balik pilihan desain.</li><li class=\"ql-indent-1\">Buat <strong>rencana konfigurasi</strong> dasar untuk perangkat-perangkat kunci (misalnya, konfigurasi <em>interface</em> router dan switch, konfigurasi VLAN)</li></ul><p><br></p>', 100000.00, 'completed', 5, NULL, NULL, '2025-06-01 10:47:56', '2025-06-01 10:57:49', 0, 0, 0.00, 0.00),
(4, 3, 1, 'asdasd', '<p>asdasd</p>', '<p>asdasd</p>', '2025-06-20', '2025-06-24', '2025-06-28', '<p><br></p>', 100000.00, 'in progress', 1, NULL, NULL, '2025-06-01 19:33:24', '2025-06-18 14:45:01', 0, 0, 0.00, 0.00),
(5, 3, NULL, 'fghfgh', '<p>fghfgh</p>', '<p>fghf</p>', '2025-06-16', '2025-06-18', '2025-06-25', '<p>fghfgh</p>', 111111.00, 'open', 1, NULL, NULL, '2025-06-01 19:45:37', '2025-06-01 19:45:37', 0, 0, 0.00, 0.00),
(6, 3, NULL, 'fghfgh', '<p>fghfgh</p>', '<p>fghf</p>', '2025-06-16', '2025-06-18', '2025-06-25', '<p>fghfgh</p>', 111111.00, 'open', 1, '[\"Game Development\",\"Software Engineering\",\"Backend Development\"]', NULL, '2025-06-01 19:47:33', '2025-07-04 11:23:22', 0, 1, 0.00, 0.00),
(7, 3, 3, 'fghfgh', '<p>fghfgh</p>', '<p>fghf</p>', '2025-06-16', '2025-06-18', '2025-06-25', '<p>fghfgh</p>', 111111.00, 'in progress', 1, '[\"Game Development\",\"Software Engineering\",\"Backend Development\"]', NULL, '2025-06-01 19:49:26', '2025-06-18 15:52:05', 0, 1, 0.00, 0.00),
(8, 3, NULL, 'membuat hp', '<p>asdasdasda</p>', '<p>asdasdasd</p>', '2025-06-28', '2025-06-27', '2025-06-26', '<p>asdasdad</p>', 100000.00, 'open', 1, '[\"Mobile Development\",\"Software Engineering\",\"Backend Development\"]', NULL, '2025-06-18 15:57:41', '2025-07-04 18:10:39', 0, 0, 0.00, 0.00),
(9, 3, NULL, 'gg', '<p>aa</p>', '<p>aa</p>', '2025-07-04', '2025-07-04', '2025-07-04', '<p>aa</p>', 2.00, 'open', 1, '[\"Mobile Development\"]', NULL, '2025-07-04 12:43:29', '2025-07-04 15:13:16', 0, 1, 0.00, 0.00),
(10, 3, NULL, 'aa', '<p>aa</p>', '<p>aa</p>', '2025-07-04', '2025-07-04', '2025-07-04', '<p>aa</p>', 200.00, 'open', 1, '[\"Mobile Development\"]', NULL, '2025-07-04 12:45:46', '2025-07-04 14:59:42', 0, 1, 0.00, 0.00),
(11, 3, NULL, 'a', '<p>a</p>', '<p>a</p>', '2025-07-04', '2025-07-04', '2025-07-04', '<p>a</p>', 200.00, 'open', 1, '[\"Mobile Development\"]', NULL, '2025-07-04 12:50:38', '2025-07-04 17:18:12', 0, 0, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `task_applications`
--

CREATE TABLE `task_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `bidPrice` double NOT NULL,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL,
  `affiliated` tinyint(1) DEFAULT '0',
  `harga_pajak_affiliate` decimal(15,2) DEFAULT '0.00',
  `applied_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_applications`
--

INSERT INTO `task_applications` (`id`, `task_id`, `profile_id`, `catatan`, `bidPrice`, `status`, `affiliated`, `harga_pajak_affiliate`, `applied_at`) VALUES
(1, 2, 1, 'aaa', 10000, 'pending', NULL, 0.00, '2025-05-29 16:43:52'),
(11, 2, 2, 'Saya adalah worker affiliasi yang direkomendasikan oleh admin empowr', 20000, 'pending', 1, 0.00, '2025-05-29 20:05:40'),
(18, 8, 3, 'sadasdasdasd', 100000, 'pending', 0, 0.00, '2025-06-18 23:01:11'),
(19, 6, 2, 'Saya adalah worker affiliasi yang direkomendasikan oleh admin empowr', 11000, 'pending', 1, 1000.00, '2025-07-04 21:43:28'),
(20, 7, 2, 'Saya adalah worker affiliasi yang direkomendasikan oleh admin empowr', 220, 'pending', 1, 20.00, '2025-07-04 21:43:47'),
(23, 9, 1, NULL, 5, 'pending', 0, 0.00, '2025-07-04 21:47:01'),
(25, 9, 3, NULL, 2, 'pending', 0, 0.00, '2025-07-04 21:56:58'),
(27, 10, 2, 'Saya adalah worker affiliasi yang direkomendasikan oleh admin empowr', 20200, 'pending', 1, 200.00, '2025-07-04 22:07:10'),
(28, 9, 2, 'Saya adalah worker affiliasi yang direkomendasikan oleh admin empowr', 220, 'pending', 1, 20.00, '2025-07-04 22:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `task_assignments`
--

CREATE TABLE `task_assignments` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  `assigned_by` bigint UNSIGNED NOT NULL,
  `worker_status` enum('assigned','accepted','declined') COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_status` enum('pending','accepted','declined') COLLATE utf8mb4_unicode_ci NOT NULL,
  `assigned_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `action_taken_at` datetime DEFAULT NULL,
  `action_by` enum('worker','client') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rejection_notes` text COLLATE utf8mb4_unicode_ci,
  `expired_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_progression`
--

CREATE TABLE `task_progression` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `path_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_by_client` bigint UNSIGNED DEFAULT NULL,
  `action_by_worker` bigint UNSIGNED DEFAULT NULL,
  `status_upload` enum('null','uploaded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'null',
  `status_approve` enum('waiting','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `note` text COLLATE utf8mb4_unicode_ci,
  `date_upload` datetime DEFAULT NULL,
  `date_approve` datetime DEFAULT NULL,
  `progression_ke` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_reviews`
--

CREATE TABLE `task_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reviewed_user_id` bigint UNSIGNED NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_reviews`
--

INSERT INTO `task_reviews` (`id`, `task_id`, `user_id`, `reviewed_user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 4, 5, 'aaa', '2025-05-29 13:30:22', '2025-05-29 13:30:22'),
(2, 2, 3, 4, 5, 'sss', '2025-05-29 13:32:09', '2025-05-29 13:32:09'),
(3, 3, 1, 3, 4, 'asas', '2025-06-01 10:52:40', '2025-06-01 11:08:10'),
(4, 3, 3, 1, 3, 'aa', '2025-06-01 10:52:40', '2025-06-01 10:57:49'),
(6, 4, 1, 3, 0, NULL, '2025-06-18 14:45:01', '2025-06-18 14:45:01'),
(7, 4, 3, 1, 0, NULL, '2025-06-18 14:45:01', '2025-06-18 14:45:01'),
(8, 7, 3, 3, 0, NULL, '2025-06-18 15:52:05', '2025-06-18 15:52:05'),
(9, 7, 3, 3, 0, NULL, '2025-06-18 15:52:05', '2025-06-18 15:52:05');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_id` bigint UNSIGNED DEFAULT NULL,
  `worker_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` enum('pending','success','cancel','expire') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` enum('direct','ewallet') COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdraw_method` enum('bank','ewallet') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('payment','payout','topup','salary','refund') COLLATE utf8mb4_unicode_ci NOT NULL,
  `proof_transfer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `task_id`, `worker_id`, `client_id`, `amount`, `status`, `payment_method`, `withdraw_method`, `type`, `proof_transfer`, `created_at`, `updated_at`) VALUES
(1, 'selesai-2-1748525422', 2, 2, 3, 10000.00, 'success', 'direct', NULL, 'salary', NULL, '2025-05-29 13:30:22', '2025-05-29 13:30:22'),
(2, 'selesai-2-1748525529', 2, 2, 3, 10000.00, 'success', 'direct', NULL, 'salary', NULL, '2025-05-29 13:32:09', '2025-05-29 13:32:09'),
(3, '3-1-1748775160', 3, 1, 3, 100000.00, 'success', 'ewallet', NULL, 'payment', NULL, '2025-06-01 10:52:40', '2025-06-01 10:52:40'),
(4, 'selesai-3-1748775469', 3, 1, 3, 100000.00, 'success', 'direct', NULL, 'salary', NULL, '2025-06-01 10:57:49', '2025-06-01 10:57:49'),
(8, 'WD-683C74C7AE5F0', NULL, 1, NULL, 15000.00, 'success', 'direct', 'bank', 'payout', 'bukti_transfer/bukti_transfer_1748796542.jpg', '2025-06-01 15:41:59', '2025-06-01 16:49:02'),
(9, 'WD-683C870AC552C', NULL, 1, NULL, 10000.00, 'cancel', 'direct', 'bank', 'payout', NULL, '2025-06-01 16:59:54', '2025-06-01 18:47:59'),
(10, 'WD-683CA13A01F4B', NULL, 1, NULL, 100000.00, 'cancel', 'direct', 'bank', 'payout', NULL, '2025-06-01 18:51:38', '2025-06-01 18:51:53'),
(11, 'WD-683CA39A720FC', NULL, 1, NULL, 200000.00, 'cancel', 'direct', 'bank', 'payout', NULL, '2025-06-01 19:01:46', '2025-06-01 19:01:52'),
(12, 'WD-683CA42633EA1', NULL, 1, NULL, 100000.00, 'cancel', 'direct', 'bank', 'payout', NULL, '2025-06-01 19:04:06', '2025-06-01 19:05:09'),
(13, 'WD-683CA52602378', NULL, 1, NULL, 100000.00, 'cancel', 'direct', 'bank', 'payout', NULL, '2025-06-01 19:08:22', '2025-06-01 19:08:26'),
(14, 'WD-683CA59C55D56', NULL, 1, NULL, 10000.00, 'cancel', 'direct', 'bank', 'payout', NULL, '2025-06-01 19:10:20', '2025-06-01 19:10:23'),
(15, 'WD-683CA5B8ECE60', NULL, 1, NULL, 10000.00, 'cancel', 'direct', 'bank', 'payout', NULL, '2025-06-01 19:10:48', '2025-06-01 19:25:29'),
(16, '4-1-1750257901', 4, 1, 3, 100000.00, 'success', 'ewallet', NULL, 'payment', NULL, '2025-06-18 14:45:01', '2025-06-18 14:45:01'),
(17, '7-3-1750261925', 7, 3, 3, 111111.00, 'success', 'ewallet', NULL, 'payment', NULL, '2025-06-18 15:52:05', '2025-06-18 15:52:05'),
(18, 'WD-686821323FEBB', NULL, NULL, 3, 10000.00, 'pending', 'direct', 'bank', 'payout', NULL, '2025-07-04 18:45:06', '2025-07-04 18:45:06'),
(19, 'WD-686828C820428', NULL, NULL, 3, 10000.00, 'pending', 'direct', 'bank', 'payout', NULL, '2025-07-04 19:17:28', '2025-07-04 19:17:28'),
(20, 'WD-68682908CF6BA', NULL, NULL, 3, 10000.00, 'pending', 'direct', 'bank', 'payout', NULL, '2025-07-04 19:18:32', '2025-07-04 19:18:32'),
(21, 'WD-686829A0E2DD1', NULL, NULL, 3, 10000.00, 'pending', 'direct', 'bank', 'payout', NULL, '2025-07-04 19:21:04', '2025-07-04 19:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('worker','client','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negara` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ewallet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_bergabung` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `profile_image`, `nomor_telepon`, `alamat`, `negara`, `ewallet`, `tanggal_bergabung`, `bio`, `created_at`, `updated_at`, `linkedin`, `avatar`) VALUES
(0, 'admin', '$2y$12$ddmG5qEDeuK/yreGNuVgVOep1bmBG0y3msP1eATU50pq2RyRgkWfi', 'admin empowr', 'admin@gmail.com', 'admin', NULL, '08121421233', NULL, NULL, NULL, '2025-05-27 15:47:39', NULL, '2025-05-27 15:47:40', '2025-05-27 15:47:40', NULL, 'avatar.png'),
(1, 'Risky', '$2y$12$5u0Bsna8.HCXjKOU63WV5uJdrIOXGcWtFum//J/5yDV42FKQfQP1O', 'Risky Farhan', 'worker@gmail.com', 'worker', NULL, '0813212121', NULL, NULL, NULL, '2025-05-27 15:47:15', NULL, '2025-05-27 15:47:15', '2025-05-27 15:47:15', NULL, 'avatar.png'),
(3, 'Risfrhn', '$2y$12$qnB.U7JvVW0rGLHvRFuKBesAy2/pD.x7SbGeWpoxKM8tLg7MHTxGe', 'Muhammad Risky Farhan', 'client@gmail.com', 'client', NULL, '0812412312', NULL, NULL, NULL, '2025-05-27 15:48:08', NULL, '2025-05-27 15:48:08', '2025-05-27 15:48:08', NULL, 'avatar.png'),
(4, 'Udin', '$2y$12$aEczHP3CVM8E4kBGb.GUF.Z.QF5Hi39GTKN8QKXg15OMR0JBJ3LTa', 'Udin Worker', 'udin@gmail.com', 'worker', NULL, '08634234234', NULL, NULL, NULL, '2025-05-27 19:26:16', NULL, '2025-05-27 19:26:16', '2025-05-27 19:26:16', NULL, 'avatar.png'),
(5, 'worker2', '$2y$12$tA0QianKud0iPy0pht.Lzu5WyFdzRJ51cbWvGeSFOmuVsUmkNweky', 'worker2', 'worker2@gmail.com', 'worker', NULL, '0812121212', NULL, NULL, NULL, '2025-06-18 15:47:26', NULL, '2025-06-18 15:47:26', '2025-06-18 15:47:26', NULL, 'avatar.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_accounts`
--

CREATE TABLE `user_payment_accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `account_type` enum('ewallet','bank','Tidak ada') COLLATE utf8mb4_unicode_ci DEFAULT 'Tidak ada',
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Tidak ada',
  `bank_account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Tidak ada',
  `bank_name` enum('BCA','BNI','BRI','Mandiri','CIMB Niaga','Danamon','Permata','BTN','Maybank','OCBC NISP','Panin','Bank Jago','BSI','Bank DKI','Bank Jabar Banten (BJB)','Bank Sumut','Bank Nagari','Bank Aceh','Bank Kaltimtara','Bank Kalsel','Bank Kalteng','Bank Papua','Bank NTB Syariah','Bank NTT','Bank Sulselbar','Bank SulutGo','Bank Bengkulu','Bank Riau Kepri','Bank Maluku Malut','Bank Lampung','Bank Sumsel Babel','Tidak ada') COLLATE utf8mb4_unicode_ci DEFAULT 'Tidak ada',
  `ewallet_provider` enum('Gopay','OVO','DANA','ShopeePay','LinkAja','Jenius Pay','Sakuku','iSaku','Paytren','Tidak ada') COLLATE utf8mb4_unicode_ci DEFAULT 'Tidak ada',
  `wallet_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Tidak ada',
  `ewallet_account_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Tidak ada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_payment_accounts`
--

INSERT INTO `user_payment_accounts` (`id`, `user_id`, `account_type`, `account_number`, `bank_account_name`, `bank_name`, `ewallet_provider`, `wallet_number`, `ewallet_account_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Bank Sumut', 'OVO', 'Tidak ada', 'Tidak ada', '2025-05-27 15:47:15', '2025-05-27 15:47:15'),
(2, 2, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-05-27 15:47:40', '2025-05-27 15:47:40'),
(3, 3, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Bank NTT', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-05-27 15:48:08', '2025-05-27 15:48:08'),
(4, 4, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-05-27 19:26:16', '2025-05-27 19:26:16'),
(5, 5, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-06-18 15:47:26', '2025-06-18 15:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `worker_profiles`
--

CREATE TABLE `worker_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tingkat_keahlian` enum('Beginner','Intermediate','Expert') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keahlian` text COLLATE utf8mb4_unicode_ci,
  `empowr_label` tinyint(1) NOT NULL DEFAULT '0',
  `empowr_affiliate` tinyint(1) NOT NULL DEFAULT '0',
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengalaman_kerja` text COLLATE utf8mb4_unicode_ci,
  `pendidikan` text COLLATE utf8mb4_unicode_ci,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `tanggal_diperbarui` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keahlian_affiliate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selfie_with_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliated_since` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worker_profiles`
--

INSERT INTO `worker_profiles` (`id`, `user_id`, `tingkat_keahlian`, `keahlian`, `empowr_label`, `empowr_affiliate`, `cv`, `pengalaman_kerja`, `pendidikan`, `status_aktif`, `tanggal_diperbarui`, `keahlian_affiliate`, `identity_photo`, `selfie_with_id`, `linkedin`, `affiliated_since`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 0, 0, NULL, NULL, NULL, 1, '2025-05-27 15:47:15', '[\"Mobile Development\",\"Software Engineering\"]', 'affiliator_documents/1/keAfFjz7PvHwtNYWeVQyRfVEW6pNyalWoupT3qkL.jpg', 'affiliator_documents/1/Aqp3Qa29wCpM8j6bWaiApXGHoQy0HDGlQbrPgolI.jpg', NULL, NULL, '2025-05-27 15:47:15', '2025-05-28 06:39:15'),
(2, 4, NULL, '[]', 0, 1, NULL, NULL, NULL, 1, '2025-05-27 19:26:16', '[\"Web Development\",\"Game Development\",\"Software Engineering\",\"Frontend Development\"]', 'affiliator_documents/4/nAnRTALcioAi1pp1OnLopP9OjLY4JEjTrc7MQdlS.jpg', 'affiliator_documents/4/05NrEAvcEvXgH5Gg5dxyhwC6ymxNxc3sUSCptIKf.jpg', NULL, NULL, '2025-05-27 19:26:16', '2025-07-04 11:42:12'),
(3, 5, NULL, NULL, 0, 0, NULL, NULL, NULL, 1, '2025-06-18 15:47:26', NULL, NULL, NULL, NULL, NULL, '2025-06-18 15:47:26', '2025-06-18 15:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `worker_verification_affiliations`
--

CREATE TABLE `worker_verification_affiliations` (
  `id` bigint UNSIGNED NOT NULL,
  `profile_id` bigint UNSIGNED NOT NULL,
  `identity_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selfie_with_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_meet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keahlian_affiliate` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','reviewed','interview','result') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status_decision` enum('approve','rejected','waiting') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `jadwal_interview` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `worker_verification_affiliation_logs`
--

CREATE TABLE `worker_verification_affiliation_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `affiliation_id` bigint UNSIGNED NOT NULL,
  `status_decision` enum('waiting','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `status` enum('rejected','pending','reviewed','Interview','result') COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_admin` bigint UNSIGNED DEFAULT NULL,
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
  ADD KEY `arbitrase_client_id_foreign` (`client_id`),
  ADD KEY `arbitrase_worker_id_foreign` (`worker_id`);

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
-- Indexes for table `payouts`
--
ALTER TABLE `payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payouts_escrow_id_foreign` (`escrow_id`),
  ADD KEY `payouts_profile_id_foreign` (`profile_id`),
  ADD KEY `payouts_payment_account_id_foreign` (`payment_account_id`);

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
-- Indexes for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_assignments_task_id_foreign` (`task_id`),
  ADD KEY `task_assignments_profile_id_foreign` (`profile_id`);

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
  ADD KEY `fk_action_admin` (`action_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arbitrase`
--
ALTER TABLE `arbitrase`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certified_applications`
--
ALTER TABLE `certified_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `escrow_payments`
--
ALTER TABLE `escrow_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ewallet`
--
ALTER TABLE `ewallet`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `midtrans_transactions`
--
ALTER TABLE `midtrans_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portofolios`
--
ALTER TABLE `portofolios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `portofolio_images`
--
ALTER TABLE `portofolio_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sertifikasi`
--
ALTER TABLE `sertifikasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sertifikasi_images`
--
ALTER TABLE `sertifikasi_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task_applications`
--
ALTER TABLE `task_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `task_assignments`
--
ALTER TABLE `task_assignments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_progression`
--
ALTER TABLE `task_progression`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_reviews`
--
ALTER TABLE `task_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_payment_accounts`
--
ALTER TABLE `user_payment_accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `worker_profiles`
--
ALTER TABLE `worker_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `worker_verification_affiliations`
--
ALTER TABLE `worker_verification_affiliations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `worker_verification_affiliation_logs`
--
ALTER TABLE `worker_verification_affiliation_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
