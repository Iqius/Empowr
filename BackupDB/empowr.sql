-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 02, 2025 at 07:55 AM
-- Server version: 8.4.3
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
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `worker_id` bigint UNSIGNED NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('open','under review','resolved') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
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
(1, 1, 8550000.00, '2025-06-23 06:13:39', '2025-07-02 07:15:43'),
(2, 2, 9770000.00, '2025-06-23 06:14:51', '2025-06-23 09:38:36'),
(3, 3, 200000.00, '2025-07-02 06:22:18', '2025-07-02 07:11:52'),
(4, 4, 0.00, '2025-07-02 06:22:52', '2025-07-02 06:22:52'),
(5, 5, 0.00, '2025-07-02 06:23:28', '2025-07-02 06:23:28');

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
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sender_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `jenis` enum('chat','arbitrase','pembayaran','applicant') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'chat',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('An7hFpq0ICFRcSQ06XUDw4KTy7xAZSf2ljuW6hQr', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiam4zeG1yNkdzR25yMEJDRHo5dTQ4RWJWSEt5d2ZJaXlPazhkTHg2QiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVjay1zZXNzaW9uIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjk6InVzZXJfZGF0YSI7YTo0OntzOjI6ImlkIjtpOjM7czo0OiJuYW1lIjtzOjEwOiJSeXVuZWhhaW11IjtzOjQ6InJvbGUiO3M6Njoid29ya2VyIjtzOjU6ImVtYWlsIjtzOjIzOiJyeXVuZWhhaW11MDA3QGdtYWlsLmNvbSI7fX0=', 1751442940),
('BOetZe6z9wu9GhZMj3p93pKGxUnR48iA4NsKg8y0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWE5tdldnVHBuSDJEcGp3eTNxMTVBS3RXVlVHUnlicmpEcmZNNlFiUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8wZGIyLTExNC0xMC0xNTAtMjgubmdyb2stZnJlZS5hcHAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1751442508),
('m00PULlcoLi0F8YmdyzkKExiIubwvTINEmHRG40W', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibm1jU3BWRmhqekxGd2NiWkFsSWdhN1U0Q1hwblp6YUU3amt5bWZIVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVjay1zZXNzaW9uIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6InVzZXJfZGF0YSI7YTo0OntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjY6IkZhcmhhbiI7czo0OiJyb2xlIjtzOjY6ImNsaWVudCI7czo1OiJlbWFpbCI7czoxNjoiY2xpZW50QGdtYWlsLmNvbSI7fX0=', 1751442940);

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
  `status` enum('open','in progress','on-hold','completed','arbitrase-completed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisions` int NOT NULL,
  `category` text COLLATE utf8mb4_unicode_ci,
  `job_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_affiliate` tinyint(1) DEFAULT NULL,
  `pengajuan_affiliate` tinyint(1) DEFAULT NULL,
  `harga_pajak_affiliate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `harga_task_affiliate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `client_id`, `profile_id`, `title`, `description`, `qualification`, `start_date`, `deadline`, `deadline_promotion`, `provisions`, `price`, `status`, `revisions`, `category`, `job_file`, `status_affiliate`, `pengajuan_affiliate`, `harga_pajak_affiliate`, `harga_task_affiliate`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 'Membuat rumah', '<p>asdasd</p>', '<p>asdasdad</p>', '2025-06-23', '2025-06-23', '2025-06-23', '<p>asadad</p>', 10000.00, 'completed', 1, '[\"Mobile Development\"]', NULL, NULL, NULL, 0.00, 0.00, '2025-06-23 09:07:15', '2025-06-23 09:09:25'),
(5, 1, 1, 'Membuat PPT', '<p>dsfsdfsdf</p>', '<p>dsfsdf</p>', '2025-06-23', '2025-06-23', '2025-06-23', '<p>sdfsdf</p>', 10000.00, 'completed', 2, '[\"Mobile Development\"]', NULL, NULL, NULL, 0.00, 0.00, '2025-06-23 09:07:52', '2025-06-23 09:09:38'),
(6, 1, 2, 'Rakit PC GIMANG', '<p>MERAKIT PC DENGAN BUDGET YANG TELAH DITENTUKAN DAN RAPI</p>', '<p>MENGETAHUI TENTANG PC</p>', '2025-07-03', '2025-07-10', '2025-07-09', '<p>BUDGET 8 JT MAX</p>', 200000.00, 'in progress', 1, '[\"IT Support\"]', 'task_files/1751437879_symptosense HKI 1_page-0001 (1).jpg', NULL, NULL, 0.00, 0.00, '2025-07-02 06:31:21', '2025-07-02 07:15:43'),
(7, 1, 2, 'Web Gofood kantin', '<p><br></p>', '<p><br></p>', '2025-07-03', '2025-07-09', '2025-07-08', '<p><br></p>', 200000.00, 'completed', 2, '[\"Mobile Development\"]', 'task_files/1751438418_symptosense HKI 1_page-0001 (1).jpg', NULL, NULL, 0.00, 0.00, '2025-07-02 06:40:18', '2025-07-02 07:11:52'),
(8, 1, NULL, 'Bikin Game RPG', '<p><br></p>', '<p><br></p>', '2025-07-09', '2025-07-23', '2025-07-15', '<p><br></p>', 200000.00, 'open', 2, '[\"Mobile Development\"]', 'task_files/1751438598_symptosense HKI 1_page-0001 (1).jpg', NULL, NULL, 0.00, 0.00, '2025-07-02 06:43:18', '2025-07-02 06:43:18'),
(10, 1, NULL, 'Test Insert Kategory', '<p>Test Insert Kategory</p>', '<p>Test Insert Kategory</p>', '2025-07-02', '2025-07-02', '2025-07-02', '<p>Test Insert Kategory</p>', 200000.00, 'open', 0, '[\"Web Development\",\"Frontend Development\",\"Backend Development\",\"Full Stack Development\"]', NULL, NULL, NULL, 0.00, 0.00, '2025-07-02 07:33:52', '2025-07-02 07:33:52');

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
  `applied_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `task_progression`
--

INSERT INTO `task_progression` (`id`, `task_id`, `path_file`, `action_by_client`, `action_by_worker`, `status_upload`, `status_approve`, `note`, `date_upload`, `date_approve`, `progression_ke`, `created_at`, `updated_at`) VALUES
(1, 7, 'progression_files/dX6RqpH7sCLUQEE0zunA12lzlGWAgw2N4jG76JJl.jpg', 1, 3, 'uploaded', 'approved', 'gg', '2025-07-02 14:10:42', '2025-07-02 14:11:07', 1, '2025-07-02 07:10:42', '2025-07-02 07:11:07');

-- --------------------------------------------------------

--
-- Table structure for table `task_reviews`
--

CREATE TABLE `task_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `task_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reviewed_user_id` bigint UNSIGNED NOT NULL,
  `rating` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
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
(10, 4, 2, 1, 5, NULL, '2025-06-23 09:31:12', '2025-06-23 09:31:12'),
(11, 7, 1, 3, 5, 'GG', '2025-07-02 07:11:52', '2025-07-02 07:11:52');

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
  `type` enum('payment','payout','topup','salary','refund') COLLATE utf8mb4_unicode_ci NOT NULL,
  `proof_transfer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `withdraw_method` enum('bank','ewallet') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
(22, 'WD-6859209C06760', NULL, 1, NULL, 100000.00, 'pending', 'direct', 'payout', NULL, 'bank', '2025-06-23 09:38:36', '2025-06-23 09:38:36'),
(23, '7-2-1751440171', 7, 2, 1, 200000.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-07-02 07:09:31', '2025-07-02 07:09:31'),
(24, 'selesai-7-1751440312', 7, 2, 1, 200000.00, 'success', 'direct', 'salary', NULL, NULL, '2025-07-02 07:11:52', '2025-07-02 07:11:52'),
(25, '6-2-1751440544', 6, 2, 1, 200000.00, 'success', 'ewallet', 'payment', NULL, NULL, '2025-07-02 07:15:44', '2025-07-02 07:15:44');

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

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `email`, `role`, `profile_image`, `nomor_telepon`, `alamat`, `negara`, `tanggal_bergabung`, `bio`, `created_at`, `updated_at`, `linkedin`, `avatar`) VALUES
(1, 'Farhan', '$2y$12$5Y97cgtl8MswuM5nf3JfYOajG6gWgymt9Y7yGuUL2be9IegZ/EdIO', 'Muhammad Risky Farhan', 'client@gmail.com', 'client', NULL, '0812412312', NULL, NULL, '2025-06-23 06:13:39', NULL, '2025-06-23 06:13:39', '2025-06-23 06:13:39', NULL, 'avatar.png'),
(2, 'worker', '$2y$12$AiqgV1t5qZWMQq9us2uKMum7a4tCJnDfCshtaHR0SRXlff5NyngR6', 'Muhammad Risky Farhan', 'worker@gmail.com', 'worker', NULL, '082131231', NULL, NULL, '2025-06-23 06:14:51', NULL, '2025-06-23 06:14:51', '2025-06-23 06:14:51', NULL, 'avatar.png'),
(3, 'Ryunehaimu', '$2y$12$sigQC2yBKu0HZpGqgdg4ouvYEB7WgiwUNMDaBrYlDCglIa0O/lwbi', 'Dede Rahmat', 'ryunehaimu007@gmail.com', 'worker', NULL, '089282693456', NULL, NULL, '2025-07-02 06:22:17', NULL, '2025-07-02 06:22:18', '2025-07-02 06:22:18', NULL, 'avatar.png'),
(4, 'Qijaw', '$2y$12$EClNuUQfXt5Siv/VPFV1SutGLmJiZfRGu/02KebtORHoWPqSC96/W', 'Qijaw', 'dederahmat927@gmail.com', 'worker', NULL, '089826728930', NULL, NULL, '2025-07-02 06:22:51', NULL, '2025-07-02 06:22:52', '2025-07-02 06:22:52', NULL, 'avatar.png'),
(5, 'Admin', '$2y$12$LqTQfxYLQSZcYdzWD2s2PuGjTKpnwQ0LdSKUo4BMrGRlcTlhnOAM2', 'Super Admin', 'superadmin@gmail.com', 'client', NULL, '089277293984', NULL, NULL, '2025-07-02 06:23:28', NULL, '2025-07-02 06:23:28', '2025-07-02 06:23:28', NULL, 'avatar.png');

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `ewallet_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_payment_accounts`
--

INSERT INTO `user_payment_accounts` (`id`, `user_id`, `account_type`, `account_number`, `bank_account_name`, `bank_name`, `ewallet_provider`, `wallet_number`, `ewallet_account_name`, `created_at`, `updated_at`, `ewallet_name`) VALUES
(1, 1, 'bank', '129121', 'Farhan', 'Bank SulutGo', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-06-23 06:13:39', '2025-06-23 06:13:39', NULL),
(2, 2, 'bank', '1212121', 'Risky', 'Bank Maluku Malut', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-06-23 06:14:51', '2025-06-23 06:14:51', NULL),
(3, 3, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-07-02 06:22:18', '2025-07-02 06:22:18', NULL),
(4, 4, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-07-02 06:22:52', '2025-07-02 06:22:52', NULL),
(5, 5, 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', 'Tidak ada', '2025-07-02 06:23:28', '2025-07-02 06:23:28', NULL);

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
(1, 2, NULL, '[]', 0, 0, NULL, NULL, NULL, 1, '2025-06-23 06:14:51', NULL, NULL, NULL, NULL, NULL, '2025-06-23 06:14:51', '2025-06-23 06:14:51'),
(2, 3, NULL, '[\"IT Support\"]', 0, 0, NULL, NULL, NULL, 1, '2025-07-02 06:22:18', NULL, NULL, NULL, NULL, NULL, '2025-07-02 06:22:18', '2025-07-02 07:00:26'),
(3, 4, NULL, '[]', 0, 0, NULL, NULL, NULL, 1, '2025-07-02 06:22:52', NULL, NULL, NULL, NULL, NULL, '2025-07-02 06:22:52', '2025-07-02 06:22:52');

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
  `status` enum('pending','reviewed','Interview','result') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
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
  `action_admin` bigint UNSIGNED DEFAULT NULL,
  `status_decision` enum('waiting','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `status` enum('pending','reviewed','Interview','result') COLLATE utf8mb4_unicode_ci NOT NULL,
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `portofolio_images`
--
ALTER TABLE `portofolio_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `task_applications`
--
ALTER TABLE `task_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `task_assignments`
--
ALTER TABLE `task_assignments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_progression`
--
ALTER TABLE `task_progression`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_reviews`
--
ALTER TABLE `task_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `worker_verification_affiliation_logs`
--
ALTER TABLE `worker_verification_affiliation_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
