-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 27, 2025 lúc 11:04 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `project_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
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
-- Cấu trúc bảng cho bảng `formula_catalog`
--

CREATE TABLE `formula_catalog` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `latex` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_01_01_000000_create_users_table', 1),
(2, '0000_10_13_223009_create_notes_table', 1),
(3, '0001_01_01_000001_create_cache_table', 1),
(4, '0001_01_01_000002_create_jobs_table', 1),
(5, '0001_10_13_223010_create_pages_table', 1),
(6, '0002_10_13_223011_create_vip_plans_table', 1),
(7, '2025_10_13_223010_create_attachments_table', 1),
(8, '2025_10_13_223010_create_formula_catalog_table', 1),
(9, '2025_10_13_223010_create_study_sessions_table', 1),
(10, '2025_10_13_223011_create_purchases_table', 1),
(11, '2025_10_13_223011_create_reviews_table', 1),
(12, '2025_10_13_223011_create_session_queue_items_table', 1),
(13, '2025_10_18_194025_add_verification_token_to_users_table', 1),
(14, '2025_11_13_215229_fix_study_sessions_timestamps', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `study_method` varchar(255) NOT NULL DEFAULT 'SM2',
  `next_review_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('normal','vocab','formula') NOT NULL DEFAULT 'normal',
  `subject` varchar(255) DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT 1,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `page_limit` int(11) NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `study_method`, `next_review_at`, `title`, `description`, `type`, `subject`, `is_private`, `is_completed`, `page_limit`, `created_at`, `updated_at`) VALUES
(1, 1, 'SM2', '2025-11-29 02:49:14', 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 02:43:43', '2025-11-28 02:49:14'),
(2, 1, 'SM2', '2025-11-29 03:03:11', 'da', 'đâ', 'formula', 'physics', 1, 0, 50, '2025-11-28 02:58:26', '2025-11-28 03:36:51'),
(3, 1, 'Pomodoro', '2025-11-29 03:42:00', 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 03:37:01', '2025-11-28 03:44:28'),
(4, 1, 'SM2', NULL, 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 03:48:15', '2025-11-28 04:12:00'),
(5, 1, 'SM2', NULL, 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 04:12:08', '2025-11-28 04:12:08'),
(6, 2, 'Custom', '2025-11-29 04:27:31', 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 04:22:36', '2025-11-28 04:30:16'),
(7, 2, 'SM2', NULL, 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 04:30:35', '2025-11-28 04:30:35'),
(8, 2, 'SM2', '2025-11-29 04:57:33', 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 04:38:47', '2025-11-28 05:01:21'),
(9, 2, 'SM2', '2025-11-29 05:12:08', 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 05:01:33', '2025-11-28 05:29:21'),
(10, 2, 'Pomodoro', '2025-11-29 05:35:52', 'da', 'da', 'formula', 'math', 1, 0, 50, '2025-11-28 05:29:58', '2025-11-28 05:35:58'),
(11, 2, 'SM2', '2025-11-29 05:36:39', 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 05:36:11', '2025-11-28 05:40:49'),
(12, 2, 'SM2', '2025-11-29 05:47:04', 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 05:40:57', '2025-11-28 05:47:04'),
(13, 2, 'SM2', NULL, 'da', 'da', 'vocab', NULL, 1, 0, 50, '2025-11-28 05:47:18', '2025-11-28 05:47:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `note_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'card',
  `position` int(11) NOT NULL DEFAULT 0,
  `front_text` text DEFAULT NULL,
  `back_text` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `front_latex` text DEFAULT NULL,
  `back_latex` text DEFAULT NULL,
  `image_front` varchar(255) DEFAULT NULL,
  `image_back` varchar(255) DEFAULT NULL,
  `source` varchar(255) NOT NULL DEFAULT 'user',
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pages`
--

INSERT INTO `pages` (`id`, `note_id`, `type`, `position`, `front_text`, `back_text`, `title`, `content`, `front_latex`, `back_latex`, `image_front`, `image_back`, `source`, `meta`, `created_at`, `updated_at`) VALUES
(1, 1, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, 'pages/zk2d6fBUqauJSD50yfbMHBfEiaR2sIygbsXP2LN8.png', 'pages/u8LwWKOPXsVfdmmxs9VXafK8EDO62XMpFKulEjLG.png', 'user', NULL, '2025-11-28 02:43:54', '2025-11-28 02:43:54'),
(2, 2, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 02:58:28', '2025-11-28 02:58:28'),
(3, 2, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 02:58:30', '2025-11-28 02:58:30'),
(4, 2, 'card', 3, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 02:58:32', '2025-11-28 02:58:32'),
(5, 3, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:37:04', '2025-11-28 03:37:04'),
(6, 3, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:37:07', '2025-11-28 03:37:07'),
(7, 3, 'card', 3, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:37:09', '2025-11-28 03:37:09'),
(8, 3, 'card', 4, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:37:11', '2025-11-28 03:37:11'),
(9, 3, 'card', 5, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:37:15', '2025-11-28 03:37:15'),
(10, 4, 'card', 1, 'đâ', 'đaad', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:48:19', '2025-11-28 03:48:19'),
(11, 4, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:48:20', '2025-11-28 03:48:20'),
(12, 4, 'card', 3, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:48:22', '2025-11-28 03:48:22'),
(13, 4, 'card', 4, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:48:24', '2025-11-28 03:48:24'),
(14, 4, 'card', 5, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 03:48:26', '2025-11-28 03:48:26'),
(15, 5, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:12:09', '2025-11-28 04:12:09'),
(16, 5, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:12:11', '2025-11-28 04:12:11'),
(17, 5, 'card', 3, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:12:13', '2025-11-28 04:12:13'),
(18, 5, 'card', 4, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:12:15', '2025-11-28 04:12:15'),
(19, 5, 'card', 5, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:12:17', '2025-11-28 04:12:17'),
(20, 5, 'card', 6, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:12:20', '2025-11-28 04:12:20'),
(21, 6, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:22:39', '2025-11-28 04:22:39'),
(22, 6, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:22:41', '2025-11-28 04:22:41'),
(23, 6, 'card', 3, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:22:43', '2025-11-28 04:22:43'),
(24, 6, 'card', 4, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:22:44', '2025-11-28 04:22:44'),
(25, 7, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:30:37', '2025-11-28 04:30:37'),
(26, 7, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:30:39', '2025-11-28 04:30:39'),
(27, 7, 'card', 3, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:30:40', '2025-11-28 04:30:40'),
(28, 7, 'card', 4, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:30:42', '2025-11-28 04:30:42'),
(29, 7, 'card', 5, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:30:44', '2025-11-28 04:30:44'),
(30, 8, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:38:49', '2025-11-28 04:38:49'),
(31, 8, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:38:51', '2025-11-28 04:38:51'),
(32, 8, 'card', 3, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:38:53', '2025-11-28 04:38:53'),
(33, 8, 'card', 4, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 04:38:55', '2025-11-28 04:38:55'),
(34, 9, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:01:36', '2025-11-28 05:01:36'),
(35, 9, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:01:38', '2025-11-28 05:01:38'),
(36, 9, 'card', 3, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:01:40', '2025-11-28 05:01:40'),
(37, 9, 'card', 4, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:01:47', '2025-11-28 05:01:47'),
(38, 9, 'card', 5, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:01:48', '2025-11-28 05:01:48'),
(39, 9, 'card', 6, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:01:50', '2025-11-28 05:01:50'),
(40, 9, 'card', 7, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:01:51', '2025-11-28 05:01:51'),
(41, 9, 'card', 8, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:01:53', '2025-11-28 05:01:53'),
(42, 10, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:30:00', '2025-11-28 05:30:00'),
(43, 10, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:30:01', '2025-11-28 05:30:01'),
(44, 10, 'card', 3, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:30:03', '2025-11-28 05:30:03'),
(45, 11, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:36:13', '2025-11-28 05:36:13'),
(46, 11, 'card', 2, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:36:16', '2025-11-28 05:36:16'),
(47, 12, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:41:00', '2025-11-28 05:41:00'),
(48, 13, 'card', 1, 'da', 'da', NULL, NULL, NULL, NULL, NULL, NULL, 'user', NULL, '2025-11-28 05:47:21', '2025-11-28 05:47:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `provider_reference` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quality` tinyint(4) NOT NULL DEFAULT 0,
  `response_time_sec` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `page_id`, `session_id`, `quality`, `response_time_sec`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 5, 1, NULL, '2025-11-28 02:49:14', '2025-11-28 02:49:14'),
(2, 1, 2, 2, 5, 1, NULL, '2025-11-28 03:03:11', '2025-11-28 03:03:11'),
(3, 1, 4, 2, 5, 1, NULL, '2025-11-28 03:20:20', '2025-11-28 03:20:20'),
(4, 1, 3, 2, 5, 0, NULL, '2025-11-28 03:36:51', '2025-11-28 03:36:51'),
(5, 1, 8, 3, 5, 1, NULL, '2025-11-28 03:42:00', '2025-11-28 03:42:00'),
(6, 1, 5, 3, 5, 136, NULL, '2025-11-28 03:44:21', '2025-11-28 03:44:21'),
(7, 1, 9, 3, 5, 0, NULL, '2025-11-28 03:44:24', '2025-11-28 03:44:24'),
(8, 1, 6, 3, 1, 1, NULL, '2025-11-28 03:44:26', '2025-11-28 03:44:26'),
(9, 1, 7, 3, 0, 0, NULL, '2025-11-28 03:44:28', '2025-11-28 03:44:28'),
(10, 2, 21, 9, 5, 1, NULL, '2025-11-28 04:27:31', '2025-11-28 04:27:31'),
(11, 2, 24, 9, 0, 1, NULL, '2025-11-28 04:30:12', '2025-11-28 04:30:12'),
(12, 2, 22, 9, 4, 1, NULL, '2025-11-28 04:30:14', '2025-11-28 04:30:14'),
(13, 2, 23, 9, 3, 0, NULL, '2025-11-28 04:30:16', '2025-11-28 04:30:16'),
(14, 2, 29, 10, 3, 0, NULL, '2025-11-28 04:38:33', '2025-11-28 04:38:33'),
(15, 2, 32, 11, 4, 1, NULL, '2025-11-28 04:57:33', '2025-11-28 04:57:33'),
(16, 2, 31, 11, 4, 0, NULL, '2025-11-28 05:01:14', '2025-11-28 05:01:14'),
(17, 2, 30, 11, 1, 0, NULL, '2025-11-28 05:01:19', '2025-11-28 05:01:19'),
(18, 2, 33, 11, 2, 0, NULL, '2025-11-28 05:01:21', '2025-11-28 05:01:21'),
(19, 2, 34, 12, 4, 1, NULL, '2025-11-28 05:12:08', '2025-11-28 05:12:08'),
(20, 2, 38, 12, 4, 1, NULL, '2025-11-28 05:29:07', '2025-11-28 05:29:07'),
(21, 2, 41, 12, 4, 0, NULL, '2025-11-28 05:29:14', '2025-11-28 05:29:14'),
(22, 2, 36, 12, 1, 0, NULL, '2025-11-28 05:29:15', '2025-11-28 05:29:15'),
(23, 2, 40, 12, 0, 0, NULL, '2025-11-28 05:29:17', '2025-11-28 05:29:17'),
(24, 2, 35, 12, 5, 0, NULL, '2025-11-28 05:29:19', '2025-11-28 05:29:19'),
(25, 2, 39, 12, 2, 0, NULL, '2025-11-28 05:29:20', '2025-11-28 05:29:20'),
(26, 2, 37, 12, 3, 0, NULL, '2025-11-28 05:29:21', '2025-11-28 05:29:21'),
(27, 2, 44, 13, 5, 0, NULL, '2025-11-28 05:35:52', '2025-11-28 05:35:52'),
(28, 2, 43, 13, 5, 1, NULL, '2025-11-28 05:35:55', '2025-11-28 05:35:55'),
(29, 2, 42, 13, 1, 1, NULL, '2025-11-28 05:35:58', '2025-11-28 05:35:58'),
(30, 2, 46, 14, 4, 0, NULL, '2025-11-28 05:36:39', '2025-11-28 05:36:39'),
(31, 2, 45, 14, 4, 1, NULL, '2025-11-28 05:40:49', '2025-11-28 05:40:49'),
(32, 2, 47, 15, 5, 0, NULL, '2025-11-28 05:47:04', '2025-11-28 05:47:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `session_queue_items`
--

CREATE TABLE `session_queue_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `queue_position` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `next_review_at` timestamp NULL DEFAULT NULL,
  `ease_factor` double NOT NULL DEFAULT 2.5,
  `interval_days` int(11) NOT NULL DEFAULT 0,
  `repetition_count` int(11) NOT NULL DEFAULT 0,
  `last_quality` tinyint(4) DEFAULT NULL,
  `last_reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `session_queue_items`
--

INSERT INTO `session_queue_items` (`id`, `session_id`, `page_id`, `queue_position`, `status`, `next_review_at`, `ease_factor`, `interval_days`, `repetition_count`, `last_quality`, `last_reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'done', '2025-11-29 02:49:14', 2.5, 1, 1, 5, '2025-11-28 02:49:14', '2025-11-28 02:44:09', '2025-11-28 02:49:14'),
(2, 2, 2, 1, 'done', '2025-11-29 03:03:11', 2.5, 1, 1, 5, '2025-11-28 03:03:11', '2025-11-28 02:58:43', '2025-11-28 03:03:11'),
(3, 2, 4, 2, 'done', '2025-11-29 03:20:20', 2.5, 1, 1, 5, '2025-11-28 03:20:20', '2025-11-28 02:58:43', '2025-11-28 03:20:20'),
(4, 2, 3, 3, 'done', '2025-11-29 03:36:51', 2.5, 1, 1, 5, '2025-11-28 03:36:51', '2025-11-28 02:58:43', '2025-11-28 03:36:51'),
(5, 3, 8, 1, 'done', '2025-11-29 03:42:00', 2.5, 1, 1, 5, '2025-11-28 03:42:00', '2025-11-28 03:37:29', '2025-11-28 03:42:00'),
(6, 3, 5, 2, 'done', '2025-11-29 03:44:21', 2.5, 1, 1, 5, '2025-11-28 03:44:21', '2025-11-28 03:37:29', '2025-11-28 03:44:21'),
(7, 3, 9, 3, 'done', '2025-11-29 03:44:24', 2.5, 1, 1, 5, '2025-11-28 03:44:24', '2025-11-28 03:37:29', '2025-11-28 03:44:24'),
(8, 3, 6, 4, 'done', '2025-11-29 03:44:26', 2.5, 1, 1, 1, '2025-11-28 03:44:26', '2025-11-28 03:37:29', '2025-11-28 03:44:26'),
(9, 3, 7, 5, 'done', '2025-11-29 03:44:28', 2.5, 1, 1, 0, '2025-11-28 03:44:28', '2025-11-28 03:37:29', '2025-11-28 03:44:28'),
(10, 4, 13, 1, 'pending', '2025-11-28 03:48:36', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:48:36', '2025-11-28 03:48:36'),
(11, 4, 10, 2, 'pending', '2025-11-28 03:48:36', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:48:36', '2025-11-28 03:48:36'),
(12, 4, 11, 3, 'pending', '2025-11-28 03:48:36', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:48:36', '2025-11-28 03:48:36'),
(13, 4, 12, 4, 'pending', '2025-11-28 03:48:36', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:48:36', '2025-11-28 03:48:36'),
(14, 4, 14, 5, 'pending', '2025-11-28 03:48:36', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:48:36', '2025-11-28 03:48:36'),
(15, 5, 12, 1, 'pending', '2025-11-28 03:59:02', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:59:02', '2025-11-28 03:59:02'),
(16, 5, 13, 2, 'pending', '2025-11-28 03:59:02', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:59:02', '2025-11-28 03:59:02'),
(17, 5, 10, 3, 'pending', '2025-11-28 03:59:02', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:59:02', '2025-11-28 03:59:02'),
(18, 5, 11, 4, 'pending', '2025-11-28 03:59:02', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:59:02', '2025-11-28 03:59:02'),
(19, 5, 14, 5, 'pending', '2025-11-28 03:59:02', 2.5, 0, 0, NULL, NULL, '2025-11-28 03:59:02', '2025-11-28 03:59:02'),
(20, 6, 14, 1, 'pending', '2025-11-28 04:12:00', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:00', '2025-11-28 04:12:00'),
(21, 6, 10, 2, 'pending', '2025-11-28 04:12:00', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:00', '2025-11-28 04:12:00'),
(22, 6, 12, 3, 'pending', '2025-11-28 04:12:00', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:00', '2025-11-28 04:12:00'),
(23, 6, 11, 4, 'pending', '2025-11-28 04:12:00', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:00', '2025-11-28 04:12:00'),
(24, 6, 13, 5, 'pending', '2025-11-28 04:12:00', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:00', '2025-11-28 04:12:00'),
(25, 7, 19, 1, 'pending', '2025-11-28 04:12:27', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:27', '2025-11-28 04:12:27'),
(26, 7, 20, 2, 'pending', '2025-11-28 04:12:27', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:27', '2025-11-28 04:12:27'),
(27, 7, 18, 3, 'pending', '2025-11-28 04:12:27', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:27', '2025-11-28 04:12:27'),
(28, 7, 17, 4, 'pending', '2025-11-28 04:12:27', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:27', '2025-11-28 04:12:27'),
(29, 7, 15, 5, 'pending', '2025-11-28 04:12:27', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:27', '2025-11-28 04:12:27'),
(30, 7, 16, 6, 'pending', '2025-11-28 04:12:27', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:12:27', '2025-11-28 04:12:27'),
(31, 8, 16, 1, 'pending', '2025-11-28 04:15:47', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:15:47', '2025-11-28 04:15:47'),
(32, 8, 15, 2, 'pending', '2025-11-28 04:15:47', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:15:47', '2025-11-28 04:15:47'),
(33, 8, 19, 3, 'pending', '2025-11-28 04:15:47', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:15:47', '2025-11-28 04:15:47'),
(34, 8, 18, 4, 'pending', '2025-11-28 04:15:47', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:15:47', '2025-11-28 04:15:47'),
(35, 8, 20, 5, 'pending', '2025-11-28 04:15:47', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:15:47', '2025-11-28 04:15:47'),
(36, 8, 17, 6, 'pending', '2025-11-28 04:15:47', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:15:47', '2025-11-28 04:15:47'),
(37, 9, 21, 1, 'done', '2025-11-29 04:27:31', 2.5, 1, 1, 5, '2025-11-28 04:27:31', '2025-11-28 04:22:50', '2025-11-28 04:27:31'),
(38, 9, 24, 2, 'done', '2025-11-29 04:30:12', 2.5, 1, 1, 0, '2025-11-28 04:30:12', '2025-11-28 04:22:50', '2025-11-28 04:30:12'),
(39, 9, 22, 3, 'done', '2025-11-29 04:30:14', 2.5, 1, 1, 4, '2025-11-28 04:30:14', '2025-11-28 04:22:50', '2025-11-28 04:30:14'),
(40, 9, 23, 4, 'done', '2025-11-29 04:30:16', 2.5, 1, 1, 3, '2025-11-28 04:30:16', '2025-11-28 04:22:50', '2025-11-28 04:30:16'),
(41, 10, 29, 1, 'done', '2025-11-29 04:38:33', 2.5, 1, 1, 3, '2025-11-28 04:38:33', '2025-11-28 04:30:50', '2025-11-28 04:38:33'),
(42, 10, 28, 2, 'pending', '2025-11-28 04:30:50', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:30:50', '2025-11-28 04:30:50'),
(43, 10, 27, 3, 'pending', '2025-11-28 04:30:50', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:30:50', '2025-11-28 04:30:50'),
(44, 10, 25, 4, 'pending', '2025-11-28 04:30:50', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:30:50', '2025-11-28 04:30:50'),
(45, 10, 26, 5, 'pending', '2025-11-28 04:30:50', 2.5, 0, 0, NULL, NULL, '2025-11-28 04:30:50', '2025-11-28 04:30:50'),
(46, 11, 32, 1, 'done', '2025-11-29 04:57:33', 2.5, 1, 1, 4, '2025-11-28 04:57:33', '2025-11-28 04:39:02', '2025-11-28 04:57:33'),
(47, 11, 31, 2, 'done', '2025-11-29 05:01:14', 2.5, 1, 1, 4, '2025-11-28 05:01:14', '2025-11-28 04:39:02', '2025-11-28 05:01:14'),
(48, 11, 30, 3, 'done', '2025-11-29 05:01:19', 2.5, 1, 1, 1, '2025-11-28 05:01:19', '2025-11-28 04:39:02', '2025-11-28 05:01:19'),
(49, 11, 33, 4, 'done', '2025-11-29 05:01:21', 2.5, 1, 1, 2, '2025-11-28 05:01:21', '2025-11-28 04:39:02', '2025-11-28 05:01:21'),
(50, 12, 34, 1, 'done', '2025-11-29 05:12:08', 2.5, 1, 1, 4, '2025-11-28 05:12:08', '2025-11-28 05:10:58', '2025-11-28 05:12:08'),
(51, 12, 38, 2, 'done', '2025-11-29 05:29:07', 2.5, 1, 1, 4, '2025-11-28 05:29:07', '2025-11-28 05:10:58', '2025-11-28 05:29:07'),
(52, 12, 41, 3, 'done', '2025-11-29 05:29:14', 2.5, 1, 1, 4, '2025-11-28 05:29:14', '2025-11-28 05:10:58', '2025-11-28 05:29:14'),
(53, 12, 36, 4, 'done', '2025-11-29 05:29:16', 2.5, 1, 1, 1, '2025-11-28 05:29:16', '2025-11-28 05:10:58', '2025-11-28 05:29:16'),
(54, 12, 40, 5, 'done', '2025-11-29 05:29:17', 2.5, 1, 1, 0, '2025-11-28 05:29:17', '2025-11-28 05:10:58', '2025-11-28 05:29:17'),
(55, 12, 35, 6, 'done', '2025-11-29 05:29:19', 2.5, 1, 1, 5, '2025-11-28 05:29:19', '2025-11-28 05:10:58', '2025-11-28 05:29:19'),
(56, 12, 39, 7, 'done', '2025-11-29 05:29:20', 2.5, 1, 1, 2, '2025-11-28 05:29:20', '2025-11-28 05:10:58', '2025-11-28 05:29:20'),
(57, 12, 37, 8, 'done', '2025-11-29 05:29:21', 2.5, 1, 1, 3, '2025-11-28 05:29:21', '2025-11-28 05:10:58', '2025-11-28 05:29:21'),
(58, 13, 44, 1, 'done', '2025-11-29 05:35:52', 2.5, 1, 1, 5, '2025-11-28 05:35:52', '2025-11-28 05:30:08', '2025-11-28 05:35:52'),
(59, 13, 43, 2, 'done', '2025-11-29 05:35:55', 2.5, 1, 1, 5, '2025-11-28 05:35:55', '2025-11-28 05:30:08', '2025-11-28 05:35:55'),
(60, 13, 42, 3, 'done', '2025-11-29 05:35:58', 2.5, 1, 1, 1, '2025-11-28 05:35:58', '2025-11-28 05:30:08', '2025-11-28 05:35:58'),
(61, 14, 46, 1, 'done', '2025-11-29 05:36:39', 2.5, 1, 1, 4, '2025-11-28 05:36:39', '2025-11-28 05:36:22', '2025-11-28 05:36:39'),
(62, 14, 45, 2, 'done', '2025-11-29 05:40:49', 2.5, 1, 1, 4, '2025-11-28 05:40:49', '2025-11-28 05:36:22', '2025-11-28 05:40:49'),
(63, 15, 47, 1, 'done', '2025-11-29 05:47:04', 2.5, 1, 1, 5, '2025-11-28 05:47:04', '2025-11-28 05:42:33', '2025-11-28 05:47:04'),
(64, 16, 48, 1, 'pending', '2025-11-28 05:47:28', 2.5, 0, 0, NULL, NULL, '2025-11-28 05:47:28', '2025-11-28 05:47:28'),
(65, 17, 18, 1, 'pending', '2025-11-28 06:00:12', 2.5, 0, 0, NULL, NULL, '2025-11-28 06:00:12', '2025-11-28 06:00:12'),
(66, 17, 19, 2, 'pending', '2025-11-28 06:00:12', 2.5, 0, 0, NULL, NULL, '2025-11-28 06:00:12', '2025-11-28 06:00:12'),
(67, 17, 20, 3, 'pending', '2025-11-28 06:00:12', 2.5, 0, 0, NULL, NULL, '2025-11-28 06:00:12', '2025-11-28 06:00:12'),
(68, 17, 17, 4, 'pending', '2025-11-28 06:00:12', 2.5, 0, 0, NULL, NULL, '2025-11-28 06:00:12', '2025-11-28 06:00:12'),
(69, 17, 16, 5, 'pending', '2025-11-28 06:00:12', 2.5, 0, 0, NULL, NULL, '2025-11-28 06:00:12', '2025-11-28 06:00:12'),
(70, 17, 15, 6, 'pending', '2025-11-28 06:00:12', 2.5, 0, 0, NULL, NULL, '2025-11-28 06:00:12', '2025-11-28 06:00:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `study_sessions`
--

CREATE TABLE `study_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `note_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) NOT NULL DEFAULT 'SM2',
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ended_at` timestamp NULL DEFAULT NULL,
  `total_seconds` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `study_sessions`
--

INSERT INTO `study_sessions` (`id`, `user_id`, `note_id`, `method`, `config`, `started_at`, `ended_at`, `total_seconds`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'SM2', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"1\\\",\\\"intervals\\\":[1,6,16,35,62]}\"', '2025-11-28 02:44:09', '2025-11-28 02:49:14', -306, '2025-11-28 02:44:09', '2025-11-28 02:49:14'),
(2, 1, 2, 'SM2', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"2\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T19:36:46.322452Z\\\"}\"', '2025-11-28 02:58:43', '2025-11-28 03:36:51', -2288, '2025-11-28 02:58:43', '2025-11-28 03:36:51'),
(3, 1, 3, 'Pomodoro', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,7,16],\\\"current_study_start\\\":\\\"2025-11-27T19:37:29.082356Z\\\"}\"', '2025-11-28 03:37:29', '2025-11-28 03:44:28', -420, '2025-11-28 03:37:29', '2025-11-28 03:44:28'),
(4, 1, 4, 'SM2', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T19:54:48.035574Z\\\",\\\"total_elapsed_seconds\\\":0}\"', '2025-11-28 03:48:36', NULL, NULL, '2025-11-28 03:48:36', '2025-11-28 03:54:48'),
(5, 1, 4, 'Leitner', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"10\\\",\\\"intervals\\\":[1,2,5,10,20],\\\"current_study_start\\\":\\\"2025-11-27T19:59:02.094359Z\\\"}\"', '2025-11-28 03:59:02', NULL, NULL, '2025-11-28 03:59:02', '2025-11-28 03:59:02'),
(6, 1, 4, 'SM2', '\"{\\\"study_time\\\":\\\"25\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T20:12:00.283084Z\\\"}\"', '2025-11-28 04:12:00', NULL, NULL, '2025-11-28 04:12:00', '2025-11-28 04:12:00'),
(7, 1, 5, 'SM2', '\"{\\\"study_time\\\":\\\"25\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T20:12:27.770123Z\\\"}\"', '2025-11-28 04:12:27', NULL, NULL, '2025-11-28 04:12:27', '2025-11-28 04:12:27'),
(8, 1, 5, 'SM2', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T20:15:47.244361Z\\\"}\"', '2025-11-28 04:15:47', NULL, NULL, '2025-11-28 04:15:47', '2025-11-28 04:15:47'),
(9, 2, 6, 'Custom', '\"{\\\"study_time\\\":\\\"20\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,3,7,14,30],\\\"current_study_start\\\":\\\"2025-11-27T20:22:50.064359Z\\\",\\\"total_study_seconds\\\":0}\"', '2025-11-28 04:22:50', '2025-11-28 04:30:16', 0, '2025-11-28 04:22:50', '2025-11-28 04:30:16'),
(10, 2, 7, 'SM2', '\"{\\\"study_time\\\":\\\"25\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T20:30:50.594690Z\\\",\\\"total_study_seconds\\\":0}\"', '2025-11-28 04:30:50', NULL, NULL, '2025-11-28 04:30:50', '2025-11-28 04:30:50'),
(11, 2, 8, 'SM2', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T20:47:36.763523Z\\\",\\\"total_study_seconds\\\":0}\"', '2025-11-28 04:39:02', '2025-11-28 05:01:21', -825, '2025-11-28 04:39:02', '2025-11-28 05:01:21'),
(12, 2, 9, 'SM2', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T21:10:58.819342Z\\\",\\\"total_elapsed_seconds\\\":0}\"', '2025-11-28 05:10:58', '2025-11-28 05:29:21', -1103, '2025-11-28 05:10:58', '2025-11-28 05:29:21'),
(13, 2, 10, 'Pomodoro', '\"{\\\"study_time\\\":\\\"25\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,7,16],\\\"current_study_start\\\":\\\"2025-11-27T21:36:01.752585Z\\\",\\\"total_elapsed_seconds\\\":-457}\"', '2025-11-28 05:30:08', '2025-11-28 05:35:58', -457, '2025-11-28 05:30:08', '2025-11-28 05:36:01'),
(14, 2, 11, 'SM2', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T21:40:53.822477Z\\\",\\\"total_elapsed_seconds\\\":-32}\"', '2025-11-28 05:36:22', '2025-11-28 05:40:49', -32, '2025-11-28 05:36:22', '2025-11-28 05:40:53'),
(15, 2, 12, 'SM2', '\"{\\\"study_time\\\":\\\"25\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T21:47:04.870335Z\\\",\\\"total_elapsed_seconds\\\":76}\"', '2025-11-28 05:42:33', '2025-11-28 05:47:04', 76, '2025-11-28 05:42:33', '2025-11-28 05:47:04'),
(16, 2, 13, 'SM2', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T22:00:19.060331Z\\\",\\\"total_elapsed_seconds\\\":126}\"', '2025-11-28 05:47:28', NULL, 126, '2025-11-28 05:47:28', '2025-11-28 06:00:19'),
(17, 1, 5, 'SM2', '\"{\\\"study_time\\\":\\\"5\\\",\\\"break_time\\\":\\\"5\\\",\\\"intervals\\\":[1,6,16,35,62],\\\"current_study_start\\\":\\\"2025-11-27T22:00:12.364224Z\\\",\\\"total_elapsed_seconds\\\":0}\"', '2025-11-28 06:00:12', NULL, 0, '2025-11-28 06:00:12', '2025-11-28 06:00:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_vip` tinyint(1) NOT NULL DEFAULT 0,
  `vip_expires_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verification_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `is_vip`, `vip_expires_at`, `remember_token`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'Truong Pham', 'hongtruongbvn2k5@gmail.com', NULL, '$2y$12$baMa5igNyo4KqxFsZt8B4.wjtkYK98Ty/J3UIvQqDtQHb4gebz/le', 0, 0, NULL, NULL, '2025-11-28 02:43:31', '2025-11-28 02:43:31', NULL),
(2, 'truongbvn', 'hoangnhungoc@gmail.com', NULL, '$2y$12$VRw5mybgMRL1m5gx6LQGOuoDOpRVi.i//nvy7K1h3zoDxLq8XqhmW', 0, 0, NULL, NULL, '2025-11-28 04:22:27', '2025-11-28 04:22:27', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vip_plans`
--

CREATE TABLE `vip_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_days` int(11) NOT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_page_id_foreign` (`page_id`),
  ADD KEY `attachments_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `formula_catalog`
--
ALTER TABLE `formula_catalog`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_note_id_foreign` (`note_id`);

--
-- Chỉ mục cho bảng `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_user_id_foreign` (`user_id`),
  ADD KEY `purchases_plan_id_foreign` (`plan_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_page_id_foreign` (`page_id`),
  ADD KEY `reviews_session_id_foreign` (`session_id`);

--
-- Chỉ mục cho bảng `session_queue_items`
--
ALTER TABLE `session_queue_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_queue_items_session_id_foreign` (`session_id`),
  ADD KEY `session_queue_items_page_id_foreign` (`page_id`);

--
-- Chỉ mục cho bảng `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `study_sessions_user_id_foreign` (`user_id`),
  ADD KEY `study_sessions_note_id_foreign` (`note_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `vip_plans`
--
ALTER TABLE `vip_plans`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `formula_catalog`
--
ALTER TABLE `formula_catalog`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `session_queue_items`
--
ALTER TABLE `session_queue_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `study_sessions`
--
ALTER TABLE `study_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `vip_plans`
--
ALTER TABLE `vip_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `attachments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_note_id_foreign` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `vip_plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `study_sessions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `session_queue_items`
--
ALTER TABLE `session_queue_items`
  ADD CONSTRAINT `session_queue_items_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `session_queue_items_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `study_sessions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD CONSTRAINT `study_sessions_note_id_foreign` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `study_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
