-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Haz 2025, 19:52:21
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `u2289124_vl`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `villa_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `guests` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `bookings`
--

INSERT INTO `bookings` (`id`, `villa_id`, `customer_id`, `check_in`, `check_out`, `guests`, `total_price`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 15, 3, '2025-04-23', '2025-05-05', 0, 85152, 'completed', 'Özel temizlik talep ediliyor.', '2025-04-18 10:38:54', '2025-05-06 10:38:54'),
(2, 3, 3, '2025-04-16', '2025-04-25', 0, 71523, 'completed', 'Erken check-in talep ediliyor.', '2025-04-01 10:38:54', '2025-04-26 10:38:54'),
(3, 8, 3, '2025-02-24', '2025-03-03', 1, 14042, 'completed', 'Deniz manzarası önemli.', '2025-01-27 10:38:54', '2025-03-04 10:38:54'),
(4, 8, 3, '2025-03-28', '2025-04-04', 1, 14042, 'completed', 'Özel temizlik talep ediliyor.', '2025-03-06 10:38:54', '2025-04-05 10:38:54'),
(5, 1, 3, '2025-01-17', '2025-01-28', 1, 63019, 'completed', NULL, '2025-01-16 10:38:54', '2025-01-29 10:38:54'),
(6, 12, 3, '2025-02-03', '2025-02-14', 1, 18810, 'completed', 'Geç check-out gerekli.', '2025-01-28 10:38:54', '2025-02-15 10:38:54'),
(7, 8, 3, '2025-01-23', '2025-01-31', 0, 16048, 'completed', NULL, '2025-01-20 10:38:54', '2025-02-01 10:38:54'),
(8, 19, 3, '2024-12-09', '2024-12-16', 0, 28168, 'completed', 'Aile toplantısı.', '2024-11-28 10:38:54', '2024-12-17 10:38:54'),
(9, 11, 3, '2024-12-29', '2025-01-11', 0, 54639, 'completed', 'Çocuk dostu ortam gerekli.', '2024-12-19 10:38:54', '2025-01-12 10:38:54'),
(10, 7, 3, '2025-02-11', '2025-02-18', 1, 54152, 'completed', 'Pet-friendly villa arıyoruz.', '2025-01-15 10:38:54', '2025-02-19 10:38:54'),
(11, 9, 3, '2025-02-23', '2025-03-05', 1, 24420, 'completed', NULL, '2025-02-02 10:38:54', '2025-03-06 10:38:54'),
(12, 13, 3, '2025-01-07', '2025-01-12', 1, 26260, 'completed', 'Ekstra havlu ve çarşaf gerekli.', '2024-12-14 10:38:54', '2025-01-13 10:38:54'),
(13, 5, 3, '2024-12-23', '2024-12-31', 1, 42728, 'completed', 'Özel temizlik talep ediliyor.', '2024-11-24 10:38:54', '2025-01-01 10:38:54'),
(14, 5, 3, '2024-12-17', '2024-12-23', 0, 32046, 'completed', 'Erken check-in talep ediliyor.', '2024-12-06 10:38:54', '2024-12-24 10:38:54'),
(15, 16, 3, '2025-04-03', '2025-04-15', 1, 34368, 'completed', 'Geç check-out gerekli.', '2025-03-04 10:38:54', '2025-04-16 10:38:54'),
(16, 15, 3, '2025-05-29', '2025-06-04', 1, 42576, 'confirmed', 'Balayı tatili.', '2025-05-10 10:38:54', '2025-05-10 10:38:54'),
(17, 10, 3, '2025-05-31', '2025-06-13', 0, 103285, 'confirmed', 'Balayı tatili.', '2025-05-14 10:38:54', '2025-05-14 10:38:54'),
(18, 12, 3, '2025-06-01', '2025-06-09', 1, 13680, 'confirmed', NULL, '2025-04-11 10:38:54', '2025-04-11 10:38:54'),
(19, 1, 3, '2025-05-31', '2025-06-06', 1, 34374, 'confirmed', 'Özel temizlik talep ediliyor.', '2025-05-11 10:38:54', '2025-05-11 10:38:54'),
(20, 16, 3, '2025-05-28', '2025-06-04', 0, 20048, 'confirmed', 'Aile toplantısı.', '2025-04-20 10:38:54', '2025-04-20 10:38:54'),
(21, 4, 3, '2025-09-20', '2025-09-29', 1, 16191, 'confirmed', 'Deniz manzarası önemli.', '2025-05-30 10:38:54', '2025-05-28 10:38:54'),
(22, 17, 3, '2025-08-28', '2025-09-18', 0, 101031, 'confirmed', 'Ekstra havlu ve çarşaf gerekli.', '2025-05-29 10:38:54', '2025-06-01 10:38:54'),
(23, 8, 3, '2025-07-25', '2025-08-06', 0, 24072, 'confirmed', 'Mutfak malzemeleri tam olsun.', '2025-05-29 10:38:54', '2025-05-22 10:38:54'),
(24, 13, 3, '2025-07-30', '2025-08-12', 1, 68276, 'confirmed', 'Çocuk dostu ortam gerekli.', '2025-05-07 10:38:54', '2025-05-19 10:38:54'),
(25, 16, 3, '2025-09-03', '2025-09-07', 1, 11456, 'confirmed', NULL, '2025-05-12 10:38:54', '2025-05-30 10:38:54'),
(26, 1, 3, '2025-08-30', '2025-09-14', 1, 85935, 'confirmed', NULL, '2025-05-04 10:38:54', '2025-05-20 10:38:54'),
(27, 7, 3, '2025-06-16', '2025-07-05', 0, 146984, 'confirmed', NULL, '2025-05-11 10:38:54', '2025-05-24 10:38:54'),
(28, 4, 3, '2025-09-29', '2025-10-15', 0, 28784, 'confirmed', 'Aile toplantısı.', '2025-05-16 10:38:54', '2025-05-22 10:38:54'),
(29, 19, 3, '2025-06-08', '2025-06-20', 0, 48288, 'confirmed', 'Çocuk dostu ortam gerekli.', '2025-05-16 10:38:54', '2025-05-27 10:38:54'),
(30, 7, 3, '2025-07-26', '2025-08-11', 1, 123776, 'confirmed', 'Transfer hizmeti gerekli.', '2025-05-19 10:38:54', '2025-05-29 10:38:54'),
(31, 10, 3, '2025-08-15', '2025-08-26', 0, 87395, 'confirmed', 'Ekstra havlu ve çarşaf gerekli.', '2025-06-01 10:38:54', '2025-05-18 10:38:54'),
(32, 20, 3, '2025-07-26', '2025-08-15', 0, 86900, 'confirmed', 'Mutfak malzemeleri tam olsun.', '2025-05-30 10:38:54', '2025-05-22 10:38:54'),
(33, 2, 3, '2025-09-06', '2025-09-19', 0, 92937, 'confirmed', 'Balayı tatili.', '2025-05-09 10:38:54', '2025-05-18 10:38:54'),
(34, 13, 3, '2025-07-24', '2025-08-05', 0, 63024, 'confirmed', 'İş seyahati.', '2025-05-06 10:38:54', '2025-05-27 10:38:54'),
(35, 10, 3, '2025-08-06', '2025-08-21', 0, 119175, 'confirmed', 'Balayı tatili.', '2025-05-25 10:38:54', '2025-05-19 10:38:54'),
(36, 20, 3, '2025-06-21', '2025-06-29', 1, 34760, 'confirmed', 'Özel temizlik talep ediliyor.', '2025-05-10 10:38:54', '2025-05-19 10:38:54'),
(37, 3, 3, '2025-06-28', '2025-07-08', 1, 79470, 'confirmed', NULL, '2025-05-29 10:38:54', '2025-05-23 10:38:54'),
(38, 3, 3, '2025-07-28', '2025-08-03', 0, 47682, 'confirmed', 'Deniz manzarası önemli.', '2025-05-16 10:38:54', '2025-05-25 10:38:54'),
(39, 13, 3, '2025-07-10', '2025-07-15', 1, 26260, 'confirmed', 'Doğum günü kutlaması için.', '2025-05-19 10:38:54', '2025-05-29 10:38:54'),
(40, 19, 3, '2025-09-01', '2025-09-14', 0, 52312, 'confirmed', 'Çocuk dostu ortam gerekli.', '2025-05-23 10:38:54', '2025-05-26 10:38:54'),
(41, 10, 3, '2025-06-19', '2025-06-29', 0, 79450, 'pending', 'Havuz kullanımı önemli.', '2025-05-31 10:38:54', '2025-05-31 10:38:54'),
(42, 9, 3, '2025-07-31', '2025-08-10', 1, 24420, 'pending', NULL, '2025-06-02 10:38:54', '2025-05-30 10:38:54'),
(43, 1, 3, '2025-07-01', '2025-07-09', 1, 45832, 'pending', 'Aile toplantısı.', '2025-05-27 10:38:54', '2025-05-30 10:38:54'),
(44, 16, 3, '2025-07-07', '2025-07-12', 0, 14320, 'pending', 'Geç check-out gerekli.', '2025-05-29 10:38:54', '2025-05-30 10:38:54'),
(45, 8, 3, '2025-06-12', '2025-06-19', 0, 14042, 'pending', 'Ekstra havlu ve çarşaf gerekli.', '2025-05-30 10:38:54', '2025-06-02 10:38:54'),
(46, 3, 3, '2025-07-10', '2025-07-20', 1, 79470, 'pending', 'Mutfak malzemeleri tam olsun.', '2025-05-30 10:38:54', '2025-05-30 10:38:54'),
(47, 14, 3, '2025-06-21', '2025-06-26', 1, 27540, 'pending', 'Deniz manzarası önemli.', '2025-05-29 10:38:54', '2025-05-30 10:38:54'),
(48, 1, 3, '2025-06-14', '2025-06-19', 0, 28645, 'pending', 'Mutfak malzemeleri tam olsun.', '2025-05-28 10:38:54', '2025-06-01 10:38:54'),
(49, 9, 3, '2025-08-05', '2025-08-16', 0, 26862, 'cancelled', 'Deniz manzarası önemli.', '2025-05-11 10:38:54', '2025-06-01 10:38:54'),
(50, 8, 3, '2025-08-18', '2025-08-30', 1, 24072, 'cancelled', 'Ekstra havlu ve çarşaf gerekli.', '2025-05-26 10:38:54', '2025-05-27 10:38:54'),
(51, 7, 3, '2025-06-25', '2025-06-28', 1, 23208, 'cancelled', 'Doğum günü kutlaması için.', '2025-05-12 10:38:54', '2025-05-20 10:38:54'),
(52, 9, 3, '2025-08-29', '2025-09-12', 1, 34188, 'cancelled', 'Sessiz bir ortam tercih ediliyor.', '2025-05-04 10:38:54', '2025-05-18 10:38:54'),
(53, 3, 3, '2025-06-25', '2025-07-06', 0, 87417, 'cancelled', 'Transfer hizmeti gerekli.', '2025-05-06 10:38:54', '2025-05-21 10:38:54'),
(54, 4, 3, '2025-08-24', '2025-08-29', 0, 8995, 'cancelled', 'Aile toplantısı.', '2025-05-03 10:38:54', '2025-05-18 10:38:54'),
(55, 1, 3, '2025-08-19', '2025-09-25', 2, 190776, 'confirmed', 'Uzun süreli konaklama - %10 indirim uygulandı. Erken check-in talep ediliyor.', '2025-04-26 10:38:54', '2025-05-19 10:38:54'),
(56, 12, 3, '2025-08-08', '2025-09-04', 1, 41553, 'confirmed', 'Uzun süreli konaklama - %10 indirim uygulandı. İş seyahati.', '2025-05-13 10:38:54', '2025-05-18 10:38:54'),
(57, 5, 3, '2025-07-30', '2025-09-09', 0, 197083, 'confirmed', 'Uzun süreli konaklama - %10 indirim uygulandı. Geç check-out gerekli.', '2025-04-24 10:38:54', '2025-05-18 10:38:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `reply_message` text DEFAULT NULL,
  `status` enum('new','read','replied') NOT NULL DEFAULT 'new',
  `read_at` timestamp NULL DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `villa_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `villa_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2025-06-02 10:41:12', '2025-06-02 10:41:12'),
(2, 3, 2, '2025-06-02 10:41:12', '2025-06-02 10:41:12'),
(3, 3, 3, '2025-06-02 10:41:13', '2025-06-02 10:41:13');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `features`
--

CREATE TABLE `features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `icon` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `features`
--

INSERT INTO `features` (`id`, `name`, `icon`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Özel Havuz', 'swimming-pool', 'Villa\'ya özel yüzme havuzu', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(2, 'Deniz Manzarası', 'water', 'Muhteşem deniz manzarası', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(3, 'Jakuzi', 'hot-tub', 'Özel jakuzi', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(4, 'Bahçe', 'tree', 'Özel bahçe alanı', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(5, 'Barbekü', 'fire', 'Barbekü alanı', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(6, 'Wi-Fi', 'wifi', 'Ücretsiz Wi-Fi', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(7, 'Klima', 'snowflake', 'Merkezi klima sistemi', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(8, 'Otopark', 'parking', 'Özel otopark alanı', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(9, 'Güvenlik', 'shield-alt', '7/24 güvenlik', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(10, 'Oyun Odası', 'gamepad', 'Oyun ve eğlence odası', '2025-06-02 10:38:54', '2025-06-02 10:38:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_popular` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `locations`
--

INSERT INTO `locations` (`id`, `name`, `slug`, `description`, `is_active`, `is_popular`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Kalkan', 'kalkan', 'Antalya\'nın en güzel tatil beldelerinden biri olan Kalkan, muhteşem koyları ve tarihi dokusuyla öne çıkıyor.', 1, 1, 'location-images/pvGuYLG7xPkW79Bv8xihxmSozFImxEryuKHis3mG.jpg', '2025-06-02 10:38:54', '2025-06-03 14:48:19'),
(2, 'Kaş', 'kas', 'Akdeniz\'in incisi Kaş, berrak denizi ve antik kentleriyle misafirlerini büyülüyor.', 1, 1, 'location-images/hmVz6IQZwuTkfmsZkFXw1GHkPDqbcfFSTX3XTJy1.jpg', '2025-06-02 10:38:54', '2025-06-03 14:48:37'),
(3, 'Fethiye', 'fethiye', 'Ölüdeniz\'in muhteşem manzarası ve doğal güzellikleriyle ünlü Fethiye, unutulmaz bir tatil vadediyor.', 1, 1, 'location-images/8WPcMc1A3Q4Wzvy6f5MAKj7u21ClZPyTnIDjdqRW.jpg', '2025-06-02 10:38:54', '2025-06-03 14:48:01'),
(4, 'Bodrum', 'bodrum', 'Türkiye\'nin en popüler tatil destinasyonlarından Bodrum, eğlence ve lüksü bir arada sunuyor.', 1, 0, 'location-images/eNmH4Q3qK51kQGTXE2RxMshUuy9WNXM64bGd7nBD.jpg', '2025-06-02 10:38:54', '2025-06-03 14:47:21'),
(5, 'Çeşme', 'cesme', 'İzmir\'in gözde tatil beldesi Çeşme, termal kaynakları ve rüzgar sörfüyle meşhur.', 1, 0, 'location-images/UwPVhdyL71c7LirtxmZuLj4PFW6yC0tIx2LktE0G.jpg', '2025-06-02 10:38:54', '2025-06-03 14:47:39');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2023_01_01_000001_create_permission_tables', 1),
(5, '2023_01_01_000002_create_locations_table', 1),
(6, '2023_01_01_000003_create_features_table', 1),
(7, '2023_01_01_000004_create_villas_table', 1),
(8, '2023_01_01_000005_create_villa_images_table', 1),
(9, '2023_01_01_000006_create_villa_features_table', 1),
(10, '2023_01_01_000007_create_bookings_table', 1),
(11, '2024_03_19_add_image_to_locations_table', 1),
(12, '2024_03_21_000000_create_settings_table', 1),
(13, '2024_03_22_cleanup_villa_features', 1),
(14, '2025_05_25_204109_create_favorites_table', 1),
(15, '2025_05_25_204147_add_customer_fields_to_users_table', 1),
(16, '2025_05_28_103830_update_villa_check_times', 1),
(17, '2025_05_28_110953_create_reviews_table', 1),
(18, '2025_05_28_111349_update_reviews_table_add_booking_id', 1),
(19, '2025_05_28_191019_create_contacts_table', 1),
(20, '2025_05_28_194108_add_reply_message_to_contacts_table', 1),
(21, '2025_06_02_182923_update_location_image_paths', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view villas', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(2, 'create villa', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(3, 'edit villa', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(4, 'delete villa', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(5, 'manage villa images', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(6, 'manage villa features', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(7, 'view locations', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(8, 'create location', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(9, 'edit location', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(10, 'delete location', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(11, 'view features', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(12, 'create feature', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(13, 'edit feature', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(14, 'delete feature', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(15, 'view bookings', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(16, 'create booking', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(17, 'edit booking', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(18, 'cancel booking', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(19, 'manage booking status', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(20, 'view users', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(21, 'create user', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(22, 'edit user', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(23, 'delete user', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(24, 'manage user roles', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `villa_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(10) UNSIGNED NOT NULL COMMENT '1-5 arası puan',
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `reviews`
--

INSERT INTO `reviews` (`id`, `booking_id`, `villa_id`, `user_id`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 3, 5, 'her şey çok güzeldi', 1, '2025-06-02 10:49:27', '2025-06-02 10:51:41'),
(2, 1, 15, 3, 4, 'bayıldım bir daha gitmek istiyorum', 1, '2025-06-02 10:49:56', '2025-06-02 10:51:38'),
(3, 2, 3, 3, 5, 'her şey çok güzeldi elinize sağlık', 1, '2025-06-02 10:50:15', '2025-06-02 10:51:45'),
(4, 4, 8, 3, 4, 'tatil için vazgeçilmez', 1, '2025-06-02 10:50:27', '2025-06-02 10:51:35'),
(5, 15, 16, 3, 4, 'her tatil buradayım', 1, '2025-06-02 10:50:38', '2025-06-02 10:51:31'),
(6, 11, 9, 3, 5, 'villa kocamandııııı', 1, '2025-06-02 10:50:50', '2025-06-02 10:51:27');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(2, 'realtor', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(3, 'customer', 'web', '2025-06-02 10:38:54', '2025-06-02 10:38:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(11, 2),
(11, 3),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(15, 2),
(15, 3),
(16, 1),
(16, 3),
(17, 1),
(18, 1),
(18, 3),
(19, 1),
(19, 2),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `notifications_email` tinyint(1) NOT NULL DEFAULT 1,
  `notifications_sms` tinyint(1) NOT NULL DEFAULT 0,
  `language` varchar(2) NOT NULL DEFAULT 'tr',
  `currency` varchar(3) NOT NULL DEFAULT 'TRY',
  `profile_public` tinyint(1) NOT NULL DEFAULT 0,
  `show_booking_history` tinyint(1) NOT NULL DEFAULT 0,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(191) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `city`, `birth_date`, `gender`, `bio`, `notifications_email`, `notifications_sms`, `language`, `currency`, `profile_public`, `show_booking_history`, `last_login_at`, `profile_image`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@villaland.com', '2025-06-02 10:38:54', '$2y$10$G7vkxiJDynSfoVY7SVMDJ.c7AJ.iOfX2qATdDCStLRu8zYMmIqv3C', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 'tr', 'TRY', 0, 0, NULL, NULL, NULL, NULL, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(2, 'Realtor', 'realtor@villaland.com', '2025-06-02 10:38:54', '$2y$10$5.R83.IhHDuvU7EAulx4X.03bMbQs/ahMhNOzU4W7Il0dXAfxVL2q', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 'tr', 'TRY', 0, 0, NULL, NULL, NULL, NULL, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(3, 'Customer', 'customer@villaland.com', '2025-06-02 10:38:54', '$2y$10$8Oo.zU6n1awLcQZxvmM51OGN1tXUkTbiEkC97a3zwO2ErkyS06VS2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 'tr', 'TRY', 0, 0, NULL, NULL, 'avatars/kMgGICBs6NAWgp3yQKWdlY9HIIKItjywmT1tnSss.jpg', NULL, '2025-06-02 10:38:54', '2025-06-02 15:36:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `villas`
--

CREATE TABLE `villas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `realtor_id` bigint(20) UNSIGNED NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `cleaning_fee` decimal(10,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `min_stay` int(11) NOT NULL DEFAULT 1,
  `address` varchar(191) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `villas`
--

INSERT INTO `villas` (`id`, `title`, `slug`, `description`, `location_id`, `realtor_id`, `bedrooms`, `bathrooms`, `capacity`, `size`, `price_per_night`, `cleaning_fee`, `is_active`, `is_featured`, `check_in_time`, `check_out_time`, `min_stay`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Lüks Deniz Manzaralı Villa', 'luks-deniz-manzarali-villa-1', 'Ea adipisci qui libero. Nostrum fugit quibusdam optio sint deleniti autem quis quia. Voluptas accusamus qui vitae cupiditate. Maiores qui vitae non delectus est ut perferendis et.\r\n\r\nRerum distinctio illo quod iure ut. Et delectus nulla fuga aliquam qui voluptates aliquam. Accusamus pariatur dolores est error qui corporis. Sed mollitia dolorum voluptatem nemo reprehenderit.', 3, 2, 6, 4, 9, 354, 5729.00, 0.00, 1, 1, '15:00:00', '11:00:00', 1, '684 Arch Bypass\r\nSaigeport, AL 25930-8460', -71.90539800, 72.81581500, '2025-06-02 10:38:54', '2025-06-02 10:57:34'),
(2, 'Modern Havuzlu Villa', 'modern-havuzlu-villa-2', 'Accusamus commodi voluptate a quo repellat. Quam voluptatibus occaecati nihil recusandae nihil asperiores rerum voluptas. Enim et labore explicabo sequi fugiat aliquam et.\n\nRerum ipsam voluptate harum deleniti facilis et harum at. At placeat et id necessitatibus aut consequatur hic. Cumque et asperiores maiores et temporibus.', 5, 2, 6, 1, 7, 275, 7149.00, 367.00, 1, 0, '15:00:00', '11:00:00', 5, '52916 Kelley Flats\nWest Rossfort, OH 14252', 4.80873100, -81.88463800, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(3, 'Özel Plajlı Villa', 'ozel-plajli-villa-3', 'Vero perferendis in adipisci aut eius aliquam recusandae. Corporis quia consequatur commodi sint sequi. Mollitia deleniti quia in est iure sint qui. Beatae iusto voluptatibus praesentium. Voluptatem tempore laborum qui quod.\n\nSed velit quia nihil omnis. Deserunt similique molestiae dignissimos et dignissimos quidem in. Quos nihil et quo aliquam.', 5, 2, 4, 4, 7, 217, 7947.00, 467.00, 1, 1, '15:00:00', '11:00:00', 7, '2648 Mavis Trail Suite 580\nNew Jamey, KY 17955-8349', -56.80532200, -86.16068200, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(4, 'Muhteşem Manzaralı Villa', 'muhtesem-manzarali-villa-4', 'Itaque aliquid distinctio ratione autem molestiae odio sequi quos. Et laudantium consequatur laborum voluptatem saepe. Harum dolores ut autem quasi quibusdam vel. Aliquid dolores consectetur suscipit in recusandae corrupti.\n\nEt reiciendis consectetur accusantium aliquid. Libero occaecati repellat optio enim alias aut tempore. Nulla vel doloremque cupiditate qui numquam ut sunt.', 2, 2, 2, 3, 11, 336, 1799.00, 573.00, 1, 0, '15:00:00', '11:00:00', 5, '1593 Olson Road Suite 974\nVonborough, OK 64287', 72.83406700, -11.67662900, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(5, 'Jakuzili Lüks Villa', 'jakuzili-luks-villa-5', 'Quasi reprehenderit provident reiciendis incidunt laudantium ut nemo. Et voluptates itaque voluptatum perspiciatis consectetur rerum. Et sint voluptas tempora expedita autem. Suscipit vero laborum ex voluptatem nulla.\n\nImpedit deleniti quo voluptas. Ut autem numquam facilis praesentium. Nostrum velit sed tenetur accusamus.', 4, 2, 6, 3, 12, 195, 5341.00, 214.00, 1, 0, '15:00:00', '11:00:00', 7, '77597 Louie Hills\nNorth Irma, AR 29342-2913', 21.70142800, 34.90480500, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(6, 'Doğa İçinde Villa', 'doga-icinde-villa-6', 'Consequuntur quas eligendi minus aut. Iste est aliquid natus sint labore architecto. Neque autem enim ut repellendus iusto architecto dolores. Facilis quos dolores doloribus sed.\n\nQuis repellat earum sint vel velit. Iste qui cum dolore porro dolores. Nisi aut quis quos occaecati eum commodi.', 1, 2, 4, 3, 8, 178, 2651.00, 694.00, 1, 1, '15:00:00', '11:00:00', 7, '702 Daniel Drives Apt. 580\nSoniamouth, MT 20876-8988', 43.11464100, 98.93013200, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(7, 'Infinity Havuzlu Villa', 'infinity-havuzlu-villa-7', 'Amet hic ipsa qui neque nisi veritatis illo. Ut et vel voluptatem alias perferendis. Aut ex id doloremque id sunt alias.\n\nMaxime cupiditate ut eos explicabo laborum ea. Ipsum earum non numquam. Ipsum necessitatibus qui aut magni quis. Officia et ab omnis odit totam officia. Temporibus voluptatibus deserunt temporibus ipsa.', 5, 2, 2, 1, 11, 121, 7736.00, 626.00, 1, 0, '15:00:00', '11:00:00', 6, '9187 Farrell Oval Apt. 782\nNorth Sylvia, CO 36681', 84.96891300, -51.12460900, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(8, 'Sahil Kenarı Villa', 'sahil-kenari-villa-8', 'Rerum officiis tempore tempore sed non harum. Non odio tenetur est velit qui animi. Doloribus ex non molestiae qui ea sit harum voluptas. Rerum aut aut ut voluptas fugiat voluptates molestiae voluptatibus.\n\nInventore exercitationem tempora dignissimos vero rem. Illo dolore eaque qui cumque dolore labore. Voluptatibus a et omnis quia eius. Quas omnis quod molestiae labore quos voluptatem soluta repellat. Suscipit voluptatem laudantium officia.', 4, 2, 5, 3, 9, 361, 2006.00, 287.00, 1, 0, '15:00:00', '11:00:00', 2, '2031 Kaleb Hollow\nDuBuqueburgh, AK 92736', 20.93428700, -57.22135500, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(9, 'Panoramik Manzaralı Villa', 'panoramik-manzarali-villa-9', 'Pariatur optio consequatur autem quaerat iure rem soluta vero. Illum quod consequatur libero at architecto. Soluta et sunt sequi dolorem facilis illo. Modi nisi ut qui delectus ipsum.\n\nUt animi ratione error pariatur vel. Voluptatum nostrum vel est voluptas commodi quaerat inventore. Dolorum non eum ut eos ut voluptatem.', 1, 2, 3, 4, 7, 348, 2442.00, 481.00, 1, 1, '15:00:00', '11:00:00', 3, '98766 Friesen Causeway Apt. 234\nNorth Jess, MO 98293', -17.71655700, -115.39917800, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(10, 'Ultra Lüks Villa', 'ultra-luks-villa-10', 'Non voluptas et modi aut. Aut blanditiis rem tenetur in voluptas fuga impedit corporis. Sunt est quis sequi et adipisci et porro vel.\n\nAt in perferendis a quisquam optio expedita reiciendis. Veniam eveniet consequatur illum consequatur ipsam. Pariatur nemo libero voluptas id non suscipit repudiandae.', 1, 2, 6, 1, 5, 339, 7945.00, 440.00, 1, 0, '15:00:00', '11:00:00', 3, '841 Carroll Shore Suite 240\nPort Stanfort, NV 35076-3057', 52.75732200, -113.09970700, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(11, 'Özel Tasarım Villa', 'ozel-tasarim-villa-11', 'Soluta et quasi omnis ea maiores ducimus aut. Et quia soluta iusto. Cum maxime quis ea hic nesciunt a cumque. Nam voluptas molestiae amet quasi animi. Est sequi dolorem labore ratione ea molestias amet.\n\nUt qui odio qui. Consequatur corporis illo nesciunt perspiciatis consequuntur praesentium aut.', 1, 2, 3, 3, 4, 374, 4203.00, 479.00, 1, 1, '15:00:00', '11:00:00', 6, '499 Jenkins Flat Apt. 774\nEast Lysannemouth, NY 35416-2278', -70.50545600, 46.76466800, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(12, 'Bahçeli Müstakil Villa', 'bahceli-mustakil-villa-12', 'Facilis voluptatem similique omnis totam. Laboriosam est dolor beatae est.\n\nProvident repellat dolorem reprehenderit aut unde cumque. Et ipsum magnam beatae qui accusamus excepturi magnam. Iure sint non est in omnis. Voluptas est odio odio magnam ducimus rerum.', 1, 2, 6, 4, 12, 136, 1710.00, 543.00, 1, 0, '15:00:00', '11:00:00', 4, '99165 Ullrich Wells\nNew Sigridville, LA 85838', 40.22984200, 28.08350900, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(13, 'Spa & Havuzlu Villa', 'spa-havuzlu-villa-13', 'Consequatur rerum debitis itaque facilis ut qui. Aut dolore illum consequuntur sint sit dolor. At qui assumenda earum sint adipisci vero voluptatem. Eos perspiciatis vero id perspiciatis.\n\nNihil sequi fuga magnam iste. Aut incidunt molestiae sed iure porro.', 2, 2, 3, 2, 8, 307, 5252.00, 253.00, 1, 1, '15:00:00', '11:00:00', 5, '24709 Welch Unions\nOthomouth, UT 43657', 42.41360600, 86.82638400, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(14, 'Denize Sıfır Villa', 'denize-sifir-villa-14', 'Iusto et optio excepturi voluptas et nostrum tenetur. Maiores aut incidunt quia vel numquam impedit doloribus. Porro quaerat deserunt tempore eum accusantium.\n\nImpedit sit officiis aut quidem voluptatem laboriosam voluptatem. Quisquam alias sint voluptatem veritatis tempore pariatur excepturi. Nesciunt atque nihil sunt praesentium beatae architecto ex. Nisi perspiciatis quia architecto.', 3, 2, 3, 4, 4, 162, 5508.00, 255.00, 1, 0, '15:00:00', '11:00:00', 4, '873 Garrett Pass\nIsomberg, KY 39218', 17.00718600, 83.52897100, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(15, 'Orman Manzaralı Villa', 'orman-manzarali-villa-15', 'Nihil in sapiente labore sed fugit similique veritatis. Illo ut perferendis vitae. Delectus sed ipsa quidem sit fugiat dolore sunt. Asperiores facilis et et numquam.\n\nSapiente magni dolor vero illo qui. Ex eligendi vel harum deleniti. Qui voluptatem sit cumque esse quae asperiores.', 3, 2, 6, 1, 4, 172, 7096.00, 313.00, 1, 0, '15:00:00', '11:00:00', 4, '566 Daphne Shoals\nBernhardburgh, HI 86228-6902', 72.03688300, -141.65611700, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(16, 'Teraslı Lüks Villa', 'terasli-luks-villa-16', 'Aliquid fugit repellat dolorem sed ullam iste. Aut architecto vel voluptate similique aspernatur. Reiciendis doloremque soluta vero. Deleniti est vitae architecto sint quia consequuntur est.\n\nQuia ipsa voluptas molestias dolores. Alias pariatur doloribus tempore sit. Soluta quia consequatur quia non et. Quae nulla sed ex dolores optio quo ducimus.', 1, 2, 3, 1, 5, 187, 2864.00, 257.00, 1, 0, '15:00:00', '11:00:00', 4, '15348 Little Orchard Apt. 354\nWiegandmouth, DE 07323-0202', -34.20502700, -17.92348300, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(17, 'Özel Havuzlu Villa', 'ozel-havuzlu-villa-17', 'Quia deleniti nam iusto aspernatur rerum sit odio. Ex voluptatibus eos qui corporis vitae voluptatem. Omnis repellat ratione aut est repudiandae. Dolorem voluptatem sed fuga sequi iste architecto.\n\nQuod rerum cupiditate ipsa harum dolores. Veritatis quasi eos iure rerum reprehenderit praesentium facilis. Qui dolore et rerum fugiat sapiente optio exercitationem. Aut qui magnam vel doloremque.', 3, 2, 6, 1, 8, 317, 4811.00, 625.00, 1, 0, '15:00:00', '11:00:00', 4, '2010 Saige Underpass Suite 292\nNorth Juliofort, NV 18633-5107', 86.90745000, -55.74880900, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(18, 'Muhteşem Konumlu Villa', 'muhtesem-konumlu-villa-18', 'Quos a vitae qui quam fugiat voluptatum illo. Est quia architecto illo totam voluptas ducimus. Amet nam sed id dolor.\n\nId in in sint. Ab voluptatem magnam ea et repudiandae. Nam aspernatur aliquid sed quia. Placeat dolores facere voluptas nemo maiores voluptatibus numquam.', 5, 2, 4, 3, 7, 214, 5846.00, 566.00, 1, 1, '15:00:00', '11:00:00', 2, '795 D\'Amore Plains Apt. 806\nNew Dedricchester, NM 49051-1217', -41.09892900, 49.68231400, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(19, 'Ayrıcalıklı Villa', 'ayricalikli-villa-19', 'Qui facere qui unde sit eveniet non quibusdam. Dolores et quasi similique quisquam praesentium et. Minus expedita quo cupiditate magni voluptates provident.\n\nConsequatur ut laudantium porro eaque. Optio ipsam vero velit ullam ipsum neque. Quidem beatae natus voluptas nihil fuga.', 5, 2, 5, 4, 10, 214, 4024.00, 750.00, 1, 0, '15:00:00', '11:00:00', 5, '95446 Adams Cove\nKeeblershire, MO 10353', -68.48520800, -92.27291500, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(20, 'Premium Villa', 'premium-villa-20', 'Quam architecto aut qui modi et maxime impedit. Ut qui repudiandae omnis. Rem quis quo architecto voluptas. Et esse dolores natus aspernatur officiis.\n\nId libero a sed numquam perferendis unde. Et velit officia suscipit qui est ab et et. Dolores ullam non repudiandae voluptas cumque. Unde maiores aut et.', 3, 2, 6, 1, 9, 162, 4345.00, 658.00, 1, 0, '15:00:00', '11:00:00', 4, '39053 Denesik Hill Suite 941\nElijahville, CT 38897', 54.83852400, -117.97574200, '2025-06-02 10:38:54', '2025-06-02 10:38:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `villa_features`
--

CREATE TABLE `villa_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `villa_id` bigint(20) UNSIGNED NOT NULL,
  `feature_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `villa_images`
--

CREATE TABLE `villa_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `villa_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(191) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `villa_images`
--

INSERT INTO `villa_images` (`id`, `villa_id`, `path`, `is_primary`, `order`, `created_at`, `updated_at`) VALUES
(2, 2, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(3, 3, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(4, 4, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(5, 5, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(6, 6, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(7, 7, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(8, 8, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(9, 9, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(10, 10, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(11, 11, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(12, 12, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(13, 13, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(14, 14, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(15, 15, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(16, 16, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(17, 17, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(18, 18, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(19, 19, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(20, 20, 'images/villa-placeholder.jpg', 1, 1, '2025-06-02 10:38:54', '2025-06-02 10:38:54'),
(48, 1, 'villa-images/0ea9dUb71faEp23pLAMB77fAwCjxT16Jnlh58aaf.jpg', 0, 0, '2025-06-03 14:46:56', '2025-06-03 14:46:56'),
(49, 1, 'villa-images/INAZRQKsfNRkKN2axdVc1FobipqfnsKTA360lEsT.jpg', 0, 1, '2025-06-03 14:46:56', '2025-06-03 14:46:56'),
(50, 1, 'villa-images/TcRAzZuyMwqCm0uTB7TB9Ub1CEpT80WCTahVffyq.jpg', 0, 2, '2025-06-03 14:46:56', '2025-06-03 14:46:56'),
(51, 1, 'villa-images/I35fBCibUFPngDKY98aey5cQu20m3WEZ6lbMmBou.jpg', 0, 3, '2025-06-03 14:46:56', '2025-06-03 14:46:56'),
(52, 1, 'villa-images/SxqGbeLoORw2easLmxHC2VhYmHVdcmjm1DzQRihR.jpg', 1, 4, '2025-06-03 14:46:56', '2025-06-03 14:46:56');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_villa_id_foreign` (`villa_id`),
  ADD KEY `bookings_customer_id_foreign` (`customer_id`);

--
-- Tablo için indeksler `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_villa_id_unique` (`user_id`,`villa_id`),
  ADD KEY `favorites_villa_id_foreign` (`villa_id`);

--
-- Tablo için indeksler `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_slug_unique` (`slug`);

--
-- Tablo için indeksler `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Tablo için indeksler `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Tablo için indeksler `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Tablo için indeksler `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Tablo için indeksler `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Tablo için indeksler `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_booking_id_unique` (`booking_id`),
  ADD KEY `reviews_villa_id_is_approved_index` (`villa_id`,`is_approved`),
  ADD KEY `reviews_user_id_index` (`user_id`);

--
-- Tablo için indeksler `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Tablo için indeksler `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Tablo için indeksler `villas`
--
ALTER TABLE `villas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `villas_slug_unique` (`slug`),
  ADD KEY `villas_location_id_foreign` (`location_id`),
  ADD KEY `villas_realtor_id_foreign` (`realtor_id`);

--
-- Tablo için indeksler `villa_features`
--
ALTER TABLE `villa_features`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `villa_features_villa_id_feature_id_unique` (`villa_id`,`feature_id`),
  ADD KEY `villa_features_feature_id_foreign` (`feature_id`);

--
-- Tablo için indeksler `villa_images`
--
ALTER TABLE `villa_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villa_images_villa_id_foreign` (`villa_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Tablo için AUTO_INCREMENT değeri `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `villas`
--
ALTER TABLE `villas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Tablo için AUTO_INCREMENT değeri `villa_features`
--
ALTER TABLE `villa_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `villa_images`
--
ALTER TABLE `villa_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_villa_id_foreign` FOREIGN KEY (`villa_id`) REFERENCES `villas` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_villa_id_foreign` FOREIGN KEY (`villa_id`) REFERENCES `villas` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_villa_id_foreign` FOREIGN KEY (`villa_id`) REFERENCES `villas` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `villas`
--
ALTER TABLE `villas`
  ADD CONSTRAINT `villas_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `villas_realtor_id_foreign` FOREIGN KEY (`realtor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `villa_features`
--
ALTER TABLE `villa_features`
  ADD CONSTRAINT `villa_features_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `villa_features_villa_id_foreign` FOREIGN KEY (`villa_id`) REFERENCES `villas` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `villa_images`
--
ALTER TABLE `villa_images`
  ADD CONSTRAINT `villa_images_villa_id_foreign` FOREIGN KEY (`villa_id`) REFERENCES `villas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
