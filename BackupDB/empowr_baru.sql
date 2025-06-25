-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 12:03 PM
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
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text NOT NULL,
  `status` enum('open','under review','resolved') NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 1, 8950000.00, '2025-06-23 06:13:39', '2025-06-23 09:09:09'),
(2, 2, 9770000.00, '2025-06-23 06:14:51', '2025-06-23 09:38:36');

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
(26, '2025_05_17_144734_create_transactions_table', 1),
(27, '2025_05_17_153441_create_ewallet_table', 1),
(28, '2025_05_27_222406_create_worker_verification_affiliations_table', 1),
(29, '2025_05_27_222407_create_worker_verification_affiliations_logs_table', 1),
(30, '2025_06_21_155720_add_ewallet_name_to_user_payment_accounts_table', 1);

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
-- Table structure for table `payouts`
--

CREATE TABLE `payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `escrow_id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `payment_account_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `status` enum('pending','processed','failed') NOT NULL,
  `created_at` datetime NOT NULL,
  `processed_at` datetime DEFAULT NULL
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
('BMqMl5sT9faj9AtWg14Bm5wpspU3OmsGYvu0A5X8', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidGtHUkptU2JyNXZOaU1aMWVJaE9xdnkzejdHNnpURVNSelZ6amFTdyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVjay1zZXNzaW9uIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6InVzZXJfZGF0YSI7YTo0OntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjY6IndvcmtlciI7czo0OiJyb2xlIjtzOjY6IndvcmtlciI7czo1OiJlbWFpbCI7czoxNjoid29ya2VyQGdtYWlsLmNvbSI7fX0=', 1750672978),
('y3Zu4PmYlFMXZ4ek9nvZhnajziljxJk1y7zGuSaP', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMjlYNFBqcFI3SE1NZk80dGF4YWEwcHlvYVZkRGtXaDlTWG1oWmEyWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVjay1zZXNzaW9uIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6InVzZXJfZGF0YSI7YTo0OntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjY6IkZhcmhhbiI7czo0OiJyb2xlIjtzOjY6ImNsaWVudCI7czo1OiJlbWFpbCI7czoxNjoiY2xpZW50QGdtYWlsLmNvbSI7fX0=', 1750672972);

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
  `harga_task_affiliate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `client_id`, `profile_id`, `title`, `description`, `qualification`, `start_date`, `deadline`, `deadline_promotion`, `provisions`, `price`, `status`, `revisions`, `category`, `job_file`, `status_affiliate`, `pengajuan_affiliate`, `harga_pajak_affiliate`, `harga_task_affiliate`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 'Membuat rumah', '<p>asdasd</p>', '<p>asdasdad</p>', '2025-06-23', '2025-06-23', '2025-06-23', '<p>asadad</p>', 10000.00, 'completed', 1, '[\"Mobile Development\"]', NULL, NULL, NULL, 0.00, 0.00, '2025-06-23 09:07:15', '2025-06-23 09:09:25'),
(5, 1, 1, 'Membuat PPT', '<p>dsfsdfsdf</p>', '<p>dsfsdf</p>', '2025-06-23', '2025-06-23', '2025-06-23', '<p>sdfsdf</p>', 10000.00, 'completed', 2, '[\"Mobile Development\"]', NULL, NULL, NULL, 0.00, 0.00, '2025-06-23 09:07:52', '2025-06-23 09:09:38');

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
  `applied_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_assignments`
--

CREATE TABLE `task_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_by` bigint(20) UNSIGNED NOT NULL,
  `worker_status` enum('assigned','accepted','declined') NOT NULL,
  `client_status` enum('pending','accepted','declined') NOT NULL,
  `assigned_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `action_taken_at` datetime DEFAULT NULL,
  `action_by` enum('worker','client') DEFAULT NULL,
  `rejection_notes` text DEFAULT NULL,
  `expired_time` datetime DEFAULT NULL
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

--
-- Dumping data for table `task_reviews`
--

INSERT INTO `task_reviews` (`id`, `task_id`, `user_id`, `reviewed_user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(7, 4, 1, 2, 4, NULL, '2025-06-23 09:09:25', '2025-06-23 09:09:25'),
(8, 5, 1, 2, 5, NULL, '2025-06-23 09:09:38', '2025-06-23 09:09:38'),
(9, 5, 2, 1, 5, NULL, '2025-06-23 09:28:26', '2025-06-23 09:28:26'),
(10, 4, 2, 1, 5, NULL, '2025-06-23 09:31:12', '2025-06-23 09:31:12');

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
(7, 'WD-6858F6542CBDB', NULL, 1, NULL, 20000.00, 'pending', 'direct', 'payout', NULL, 'bank', '2025-06-23 06:38:12', '2025-06-23 06:38:12'),
(8, 'WD-6858F668628CB', NULL, 1, NULL, 100000.00, 'pending', 'direct', 'payout', NULL, 'bank', '2025-06-23 06:38:32', '2025-06-23 06:38:32'),
(9, 'WD-6858F74BC91D6', NULL, 1, NULL, 10000.00, 'pending', 'direct', 'payout', NULL, 'bank', '2025-06-23 06:42:19', '2025-06-23 06:42:19'),
(12, 'WD-6858F9938A07B', NULL, NULL, 1, 1000000.00, 'pending', 'direct', 'payout', NULL, 'bank', '2025-06-23 06:52:03', '2025-06-23 06:52:03'),
(13, '4-1-1750669733', 4, 1, 1, 10000.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-06-23 09:08:53', '2025-06-23 09:08:53'),
(14, '5-1-1750669749', 5, 1, 1, 10000.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-06-23 09:09:09', '2025-06-23 09:09:09'),
(15, 'selesai-4-1750669765', 4, 1, 1, 10000.00, 'success', 'direct', 'salary', NULL, NULL, '2025-06-23 09:09:25', '2025-06-23 09:09:25'),
(16, 'selesai-5-1750669778', 5, 1, 1, 10000.00, 'success', 'direct', 'salary', NULL, NULL, '2025-06-23 09:09:38', '2025-06-23 09:09:38'),
(17, 'selesai-5-1750670236', 5, 1, 2, 10000.00, 'success', 'direct', 'salary', NULL, NULL, '2025-06-23 09:17:16', '2025-06-23 09:17:16'),
(18, 'selesai-5-1750670772', 5, 1, 2, 10000.00, 'success', 'direct', 'salary', NULL, NULL, '2025-06-23 09:26:12', '2025-06-23 09:26:12'),
(21, 'WD-6859208B93E7E', NULL, 1, NULL, 10000.00, 'pending', 'direct', 'payout', NULL, 'bank', '2025-06-23 09:38:19', '2025-06-23 09:38:19'),
(22, 'WD-6859209C06760', NULL, 1, NULL, 100000.00, 'pending', 'direct', 'payout', NULL, 'bank', '2025-06-23 09:38:36', '2025-06-23 09:38:36');

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
  `alamat` varchar(255) DEFAULT NULL,
  `negara` varchar(255) DEFAULT NULL,
  `tanggal_bergabung` timestamp NOT NULL DEFAULT current_timestamp(),
  `bio` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `profile_image`, `nomor_telepon`, `alamat`, `negara`, `tanggal_bergabung`, `bio`, `created_at`, `updated_at`, `linkedin`, `avatar`) VALUES
(1, 'Farhan', '$2y$12$5Y97cgtl8MswuM5nf3JfYOajG6gWgymt9Y7yGuUL2be9IegZ/EdIO', 'Muhammad Risky Farhan', 'client@gmail.com', 'client', NULL, '0812412312', NULL, NULL, '2025-06-23 06:13:39', NULL, '2025-06-23 06:13:39', '2025-06-23 06:13:39', NULL, 'avatar.png'),
(2, 'worker', '$2y$12$AiqgV1t5qZWMQq9us2uKMum7a4tCJnDfCshtaHR0SRXlff5NyngR6', 'Muhammad Risky Farhan', 'worker@gmail.com', 'worker', NULL, '082131231', NULL, NULL, '2025-06-23 06:14:51', NULL, '2025-06-23 06:14:51', '2025-06-23 06:14:51', NULL, 'avatar.png');

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
(1, 1, 'bank', '129121', 'Farhan', 'Bank SulutGo', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-06-23 06:13:39', '2025-06-23 06:13:39', NULL),
(2, 2, 'bank', '1212121', 'Risky', 'Bank Maluku Malut', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-06-23 06:14:51', '2025-06-23 06:14:51', NULL);

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
(1, 2, NULL, NULL, 0, 0, NULL, NULL, NULL, 1, '2025-06-23 06:14:51', NULL, NULL, NULL, NULL, NULL, '2025-06-23 06:14:51', '2025-06-23 06:14:51');

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
  ADD KEY `worker_verification_affiliation_logs_action_admin_foreign` (`action_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arbitrase`
--
ALTER TABLE `arbitrase`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certified_applications`
--
ALTER TABLE `certified_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `escrow_payments`
--
ALTER TABLE `escrow_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ewallet`
--
ALTER TABLE `ewallet`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payouts`
--
ALTER TABLE `payouts`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task_applications`
--
ALTER TABLE `task_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task_assignments`
--
ALTER TABLE `task_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_progression`
--
ALTER TABLE `task_progression`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_reviews`
--
ALTER TABLE `task_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_payment_accounts`
--
ALTER TABLE `user_payment_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `worker_profiles`
--
ALTER TABLE `worker_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `arbitrase_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `arbitrase_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `arbitrase_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `worker_profiles` (`user_id`) ON DELETE CASCADE;

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
-- Constraints for table `payouts`
--
ALTER TABLE `payouts`
  ADD CONSTRAINT `payouts_escrow_id_foreign` FOREIGN KEY (`escrow_id`) REFERENCES `escrow_payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payouts_payment_account_id_foreign` FOREIGN KEY (`payment_account_id`) REFERENCES `user_payment_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payouts_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `worker_profiles` (`user_id`) ON DELETE CASCADE;

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
-- Constraints for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD CONSTRAINT `task_assignments_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `worker_profiles` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_assignments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE;

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
