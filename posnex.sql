-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2025 at 10:46 PM
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
-- Database: `posnex`
--

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `details`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'Softwares', 'POS', 1, '2025-05-29 16:01:26', '2025-05-29 16:01:26'),
(2, 'Website', 'Custom', 1, '2025-05-29 16:01:38', '2025-05-29 16:01:38'),
(3, 'Web Applications', 'User Define Web Application', 2, '2025-06-03 16:14:29', '2025-06-03 16:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `taxCash` decimal(5,2) NOT NULL DEFAULT 0.00,
  `taxCard` decimal(5,2) NOT NULL DEFAULT 0.00,
  `taxOnline` decimal(5,2) NOT NULL DEFAULT 0.00,
  `type` enum('wholesale','retail','both') NOT NULL,
  `cell_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ntn` varchar(255) DEFAULT NULL,
  `tel_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `taxCash`, `taxCard`, `taxOnline`, `type`, `cell_no`, `email`, `ntn`, `tel_no`, `created_at`, `updated_at`) VALUES
(1, 'POSNEX', 15.00, 5.00, 10.00, 'both', '03197131158', 'admin@mail.com', NULL, NULL, '2025-05-28 01:52:08', '2025-07-08 14:55:55'),
(2, 'NexAura', 0.00, 0.00, 0.00, 'retail', NULL, NULL, NULL, NULL, '2025-06-03 16:10:34', '2025-06-03 16:10:34'),
(3, 'Shop', 0.00, 0.00, 0.00, 'both', '0300-0000000', NULL, NULL, NULL, '2025-07-08 15:02:04', '2025-07-08 15:02:04');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('retail','wholesale','both') NOT NULL,
  `cel_no` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cnic` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `type`, `cel_no`, `email`, `cnic`, `address`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'Saleem', 'wholesale', '0300-0000000', NULL, NULL, NULL, 1, '2025-05-29 17:48:15', '2025-05-29 17:48:15'),
(2, 'Ali', 'retail', '0300-0000000', NULL, NULL, NULL, 1, '2025-05-29 17:48:38', '2025-05-29 17:48:38'),
(3, 'Asad', 'both', '0300-0000000', NULL, NULL, NULL, 1, '2025-05-29 17:49:33', '2025-05-29 17:49:33'),
(4, 'Walk-In', 'retail', '0300-0000000', NULL, NULL, NULL, 2, '2025-06-03 16:33:17', '2025-06-03 16:33:17'),
(5, 'School', 'wholesale', '0300-0000000', NULL, NULL, NULL, 2, '2025-06-03 16:33:34', '2025-06-03 16:33:34');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paidBy` varchar(255) NOT NULL,
  `paymentWay` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `purpose`, `details`, `amount`, `paidBy`, `paymentWay`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'Utility Bills', 'Electricity Bills', 5000.00, 'Ahmad', 'cash', 1, '2025-06-17 16:24:42', '2025-06-17 16:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `external_purchases`
--

CREATE TABLE `external_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchaseE_id` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `purchase_amount` decimal(10,2) NOT NULL,
  `purchase_source` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `external_purchases`
--

INSERT INTO `external_purchases` (`id`, `purchaseE_id`, `item_name`, `details`, `purchase_amount`, `purchase_source`, `created_by`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'P001-00001', 'E Commerce', 'E commerce Website', 30000.00, 'NexAura Softwares', 'Admin', 1, '2025-06-16 16:50:50', '2025-06-16 16:50:50'),
(2, 'P001-00002', 'Portfolio', 'Business Site', 15000.00, 'NexAura Softwares', 'Admin', 1, '2025-06-16 17:23:50', '2025-06-16 17:23:50'),
(3, 'P001-00003', 'Portfolio', 'Business Site', 15000.00, 'NexAura Softwares', 'Admin', 1, '2025-06-16 17:24:21', '2025-06-16 17:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `external_sales`
--

CREATE TABLE `external_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `saleE_id` varchar(255) NOT NULL,
  `purchaseE_id` varchar(255) NOT NULL,
  `sale_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','card','online') NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `external_sales`
--

INSERT INTO `external_sales` (`id`, `saleE_id`, `purchaseE_id`, `sale_amount`, `payment_method`, `tax_amount`, `total_amount`, `created_by`, `company_id`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 'P001-00001', 'P001-00001', 50000.00, 'cash', 7500.00, 57500.00, 'Admin', 1, 1, '2025-06-16 16:50:50', '2025-06-16 16:50:50'),
(2, 'P001-00002', 'P001-00002', 20000.00, 'cash', 3000.00, 23000.00, 'Admin', 1, 2, '2025-06-16 17:23:50', '2025-06-16 17:23:50'),
(3, 'P001-00003', 'P001-00003', 20000.00, 'cash', 3000.00, 23000.00, 'Admin', 1, 2, '2025-06-16 17:24:21', '2025-06-16 17:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `retail_amount` decimal(10,2) NOT NULL,
  `wholesale_amount` decimal(10,2) DEFAULT NULL,
  `details` text NOT NULL,
  `unit` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `image` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_name`, `retail_amount`, `wholesale_amount`, `details`, `unit`, `barcode`, `sku`, `supplier_id`, `category_id`, `status`, `image`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'POS', 20000.00, 15000.00, 'Point of Sale', '18', NULL, NULL, 1, 1, 'active', 'inventory_images/LQnCSeApNrmnG8eFr3VNR0hLsn6Pbe0M1ogK8txE.png', 1, '2025-05-29 16:02:58', '2025-06-19 17:05:06'),
(3, 'Custom Website', 25000.00, 20000.00, 'Business Website', '19', NULL, NULL, 1, 2, 'inactive', 'inventory_images/UAfY6jcUFUPJGsUP9a4h8gtWLVJJexD4M1g5QrvB.png', 1, '2025-05-29 17:31:27', '2025-06-02 18:45:12'),
(4, 'EMS', 25000.00, NULL, 'Education Management System', '7', NULL, NULL, 2, 3, 'active', NULL, 2, '2025-06-03 16:15:54', '2025-06-19 18:39:03'),
(5, 'Portfolio', 20000.00, 15000.00, 'Company Portfolio', '26', NULL, NULL, 3, 1, 'active', NULL, 1, '2025-07-07 17:38:02', '2025-07-07 17:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_sales`
--

CREATE TABLE `inventory_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `sale_type` enum('retail','wholesale') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_sales`
--

INSERT INTO `inventory_sales` (`id`, `sale_id`, `item_id`, `quantity`, `sale_type`, `amount`, `total_amount`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'retail', 20000.00, 20000.00, 1, '2025-06-18 14:48:58', '2025-06-18 14:48:58'),
(2, 2, 1, 1, 'retail', 20000.00, 20000.00, 1, '2025-06-19 17:05:06', '2025-06-19 17:05:06'),
(3, 3, 4, 1, 'retail', 25000.00, 25000.00, 2, '2025-06-19 18:39:03', '2025-06-19 18:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_27_192207_create_companies_table', 1),
(5, '2025_05_27_192431_add_company_id_status_role_to_users_table', 1),
(6, '2025_05_27_213225_create_categories_table', 1),
(7, '2025_05_27_213645_create_suppliers_table', 1),
(8, '2025_05_27_214529_create_inventory_table', 1),
(9, '2025_05_28_063801_create_purchases_table', 1),
(10, '2025_05_28_063856_create_purchase_items_table', 2),
(11, '2025_05_29_223800_create_customers_table', 3),
(12, '2025_06_02_223913_create_sales_table', 4),
(13, '2025_06_02_224026_create_inventory_sales_table', 5),
(14, '2025_06_02_230752_add_tax_columns_to_companies_table', 6),
(15, '2025_06_03_212130_add_customer_id_to_sales_table', 7),
(16, '2025_06_11_010502_add_sale_code_to_sales_table', 8),
(17, '2025_06_11_010613_add_sale_code_to_sales_table', 9),
(18, '2025_06_16_212717_create_external_purchases_table', 10),
(19, '2025_06_16_212844_create_external_sales_table', 11),
(20, '2025_06_17_211110_create_expenses_table', 12),
(21, '2025_07_08_201203_add_inactive_at_to_users_table', 13);

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
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `supplier_id`, `total_amount`, `company_id`, `purchase_date`, `created_at`, `updated_at`) VALUES
(2, 2, 180000.00, 2, '2025-06-11', '2025-06-10 19:06:47', '2025-06-10 19:06:47'),
(3, 2, 360000.00, 2, '2025-06-11', '2025-06-10 19:32:32', '2025-06-10 19:32:32'),
(4, 1, 10000.00, 1, '2025-06-18', '2025-06-18 14:34:54', '2025-06-18 14:34:54'),
(5, 3, 120000.00, 1, '2025-07-07', '2025-07-07 17:39:03', '2025-07-07 17:39:03'),
(6, 3, 120000.00, 1, '2025-07-07', '2025-07-07 17:40:09', '2025-07-07 17:40:09'),
(7, 3, 60000.00, 1, '2025-07-07', '2025-07-07 17:40:56', '2025-07-07 17:40:56'),
(8, 3, 12000.00, 1, '2025-07-07', '2025-07-07 17:44:07', '2025-07-07 17:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_amount` decimal(10,2) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `inventory_id`, `quantity`, `purchase_amount`, `company_id`, `created_at`, `updated_at`) VALUES
(3, 2, 4, 10, 180000.00, 2, '2025-06-10 19:06:47', '2025-06-10 19:06:47'),
(4, 3, 4, 20, 360000.00, 2, '2025-06-10 19:32:32', '2025-06-10 19:32:32'),
(5, 4, 1, 4, 10000.00, 1, '2025-06-18 14:34:54', '2025-06-18 14:34:54'),
(6, 5, 5, 10, 120000.00, 1, '2025-07-07 17:39:03', '2025-07-07 17:39:03'),
(7, 6, 5, 10, 120000.00, 1, '2025-07-07 17:40:09', '2025-07-07 17:40:09'),
(8, 7, 5, 5, 60000.00, 1, '2025-07-07 17:40:56', '2025-07-07 17:40:56'),
(9, 8, 5, 1, 12000.00, 1, '2025-07-07 17:44:07', '2025-07-07 17:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_code` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) NOT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `sale_code`, `created_by`, `subtotal`, `total_amount`, `tax_percentage`, `tax_amount`, `payment_method`, `discount`, `company_id`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 'P001-00001', 'Admin', 20000.00, 23000.00, 15.00, 3000.00, 'cash', 0.00, 1, 2, '2025-06-18 14:48:58', '2025-06-18 14:48:58'),
(2, 'P001-00002', 'Admin', 20000.00, 23000.00, 15.00, 3000.00, 'cash', 0.00, 1, 2, '2025-06-19 17:05:06', '2025-06-19 17:05:06'),
(3, 'N002-00001', 'NexAura', 25000.00, 25000.00, 0.00, 0.00, 'cash', 0.00, 2, 4, '2025-06-19 18:39:03', '2025-06-19 18:39:03');

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
('sHxmh40Y64tsvjeEFkURtZlKBNnm7RjDNj4gIQ8S', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaE1HRkpmWGJlRHMzOU1MaHdPdkdmU2l4bkw4dE9TclJCTWEwZGV4ZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752002776),
('vpcMU8KIlFZL9mAGJgUwg9QLaZ9SfSBMjFV0t31A', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidU1xMGlldGtWNmxQNzE0cWVjcGMxekxlQ05uM2RIYndMbllGc3g5OSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2VycyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1752007480);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `cell_no` varchar(255) NOT NULL,
  `tel_no` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `cell_no`, `tel_no`, `contact_person`, `email`, `address`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'NexAura Softwares', '03197131158', NULL, 'M. Ahmad', NULL, NULL, 1, '2025-05-29 16:01:52', '2025-05-29 16:01:52'),
(2, 'NexAura Softwares', '03197131158', NULL, 'Ahmad', NULL, NULL, 2, '2025-06-03 16:14:57', '2025-06-03 16:14:57'),
(3, 'Software House', '03197131158', NULL, 'M. Ahmad', NULL, NULL, 1, '2025-07-07 17:36:58', '2025-07-07 17:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `inactive_at` timestamp NULL DEFAULT NULL,
  `role` enum('superadmin','admin','manager','employee') NOT NULL DEFAULT 'employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `company_id`, `status`, `inactive_at`, `role`) VALUES
(1, 'Super Admin', 'admin@mail.com', NULL, '$2y$12$oklzG53Ne7nb8X9xP886QONEIa2qTKMRTVy..y6.8a/noFS6Y1oRu', NULL, '2025-05-28 01:50:44', '2025-07-08 14:56:13', 1, 'active', NULL, 'superadmin'),
(2, 'NexAura', 'admin3@mail.com', NULL, '$2y$12$MElYMGjGmlLsKk/Rb9t9EO4G3zex6FKEysL742IwdNVaRFV/jd1XK', NULL, '2025-06-03 16:11:15', '2025-06-10 19:05:58', 2, 'active', NULL, 'admin'),
(3, 'Employee', 'user@mail.com', NULL, '$2y$12$2IYaz0ZzBErbRi7I.iTo2u01n58wijUY2VhovfPKnij4GSFGm63ky', NULL, '2025-06-19 18:14:14', '2025-06-19 18:14:14', 2, 'active', NULL, 'employee'),
(4, 'Admin', 'admin@email.com', NULL, '$2y$12$H1CoXFdC8ZN47pjcbWcO2OaUJ2XiAxmHtd15PNTztuZo5hGdguT4.', NULL, '2025-07-08 15:02:48', '2025-07-08 15:02:48', 3, 'active', '2026-01-14 20:43:10', 'admin'),
(5, 'Cashier', 'cashier@email.com', NULL, '$2y$12$w7yn5J5J1eiS7QxqLFKz8.FZQ1UrhFJQhDIag5fpUzmtCZt41wcZq', NULL, '2025-07-08 15:04:03', '2025-07-08 15:04:03', 3, 'active', '2026-01-14 20:45:44', 'employee');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_company_id_foreign` (`company_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_company_id_foreign` (`company_id`);

--
-- Indexes for table `external_purchases`
--
ALTER TABLE `external_purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `external_purchases_purchasee_id_unique` (`purchaseE_id`),
  ADD KEY `external_purchases_company_id_foreign` (`company_id`);

--
-- Indexes for table `external_sales`
--
ALTER TABLE `external_sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `external_sales_salee_id_unique` (`saleE_id`),
  ADD KEY `external_sales_company_id_foreign` (`company_id`),
  ADD KEY `external_sales_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_supplier_id_foreign` (`supplier_id`),
  ADD KEY `inventory_category_id_foreign` (`category_id`),
  ADD KEY `inventory_company_id_foreign` (`company_id`);

--
-- Indexes for table `inventory_sales`
--
ALTER TABLE `inventory_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_sales_sale_id_foreign` (`sale_id`),
  ADD KEY `inventory_sales_item_id_foreign` (`item_id`),
  ADD KEY `inventory_sales_company_id_foreign` (`company_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchases_company_id_foreign` (`company_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_items_inventory_id_foreign` (`inventory_id`),
  ADD KEY `purchase_items_company_id_foreign` (`company_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_sale_code_unique` (`sale_code`),
  ADD KEY `sales_company_id_foreign` (`company_id`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_company_id_foreign` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `external_purchases`
--
ALTER TABLE `external_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `external_sales`
--
ALTER TABLE `external_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory_sales`
--
ALTER TABLE `inventory_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `external_purchases`
--
ALTER TABLE `external_purchases`
  ADD CONSTRAINT `external_purchases_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `external_sales`
--
ALTER TABLE `external_sales`
  ADD CONSTRAINT `external_sales_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `external_sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_sales`
--
ALTER TABLE `inventory_sales`
  ADD CONSTRAINT `inventory_sales_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_sales_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_sales_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD CONSTRAINT `purchase_items_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_items_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
