-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 30 May 2025, 18:44:08
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
-- Veritabanı: `vl2`
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
(1, 3, 3, '2025-02-06', '2025-02-19', 1, 24505, 'completed', NULL, '2025-01-29 16:16:46', '2025-02-20 16:16:46'),
(2, 15, 3, '2025-04-11', '2025-04-25', 1, 26460, 'completed', 'Çocuk dostu ortam gerekli.', '2025-03-19 16:16:46', '2025-04-26 16:16:46'),
(3, 2, 3, '2025-03-28', '2025-04-03', 1, 30924, 'completed', 'Transfer hizmeti gerekli.', '2025-03-21 16:16:46', '2025-04-04 16:16:46'),
(4, 9, 3, '2025-01-09', '2025-01-13', 1, 14504, 'completed', 'Geç check-out gerekli.', '2024-12-11 16:16:46', '2025-01-14 16:16:46'),
(5, 13, 3, '2025-01-31', '2025-02-13', 1, 99437, 'completed', 'İş seyahati.', '2025-01-05 16:16:46', '2025-02-14 16:16:46'),
(6, 18, 3, '2025-03-14', '2025-03-27', 1, 70122, 'completed', NULL, '2025-02-23 16:16:46', '2025-03-28 16:16:46'),
(7, 15, 3, '2025-01-22', '2025-01-29', 1, 13230, 'completed', 'Özel diyet ihtiyacı var.', '2024-12-28 16:16:46', '2025-01-30 16:16:46'),
(8, 4, 3, '2025-02-23', '2025-03-01', 1, 46884, 'completed', 'Özel temizlik talep ediliyor.', '2025-01-31 16:16:46', '2025-03-02 16:16:46'),
(9, 15, 3, '2025-03-16', '2025-03-20', 0, 7560, 'completed', 'Çocuk dostu ortam gerekli.', '2025-03-06 16:16:46', '2025-03-21 16:16:46'),
(10, 14, 3, '2024-12-16', '2024-12-20', 0, 9040, 'completed', 'Çocuk dostu ortam gerekli.', '2024-12-01 16:16:46', '2024-12-21 16:16:46'),
(11, 8, 3, '2025-03-26', '2025-03-29', 1, 21972, 'completed', NULL, '2025-02-26 16:16:46', '2025-03-30 16:16:46'),
(12, 19, 3, '2025-01-01', '2025-01-10', 1, 40707, 'completed', 'Yakın restoran önerileri isteniyor.', '2024-12-02 16:16:46', '2025-01-11 16:16:46'),
(13, 2, 3, '2025-01-19', '2025-01-26', 1, 36078, 'completed', 'Deniz manzarası önemli.', '2025-01-11 16:16:46', '2025-01-27 16:16:46'),
(14, 5, 3, '2025-04-17', '2025-04-23', 0, 12282, 'completed', NULL, '2025-04-09 16:16:46', '2025-04-24 16:16:46'),
(15, 1, 3, '2025-03-22', '2025-04-05', 1, 53886, 'completed', 'Erken check-in talep ediliyor.', '2025-03-09 16:16:46', '2025-04-06 16:16:46'),
(16, 5, 3, '2025-05-24', '2025-06-02', 0, 18423, 'confirmed', 'Transfer hizmeti gerekli.', '2025-05-06 16:16:46', '2025-05-06 16:16:46'),
(17, 17, 3, '2025-05-23', '2025-05-31', 1, 38784, 'confirmed', 'Çocuk dostu ortam gerekli.', '2025-04-24 16:16:46', '2025-04-24 16:16:46'),
(18, 5, 3, '2025-05-21', '2025-05-31', 0, 20470, 'confirmed', 'Pet-friendly villa arıyoruz.', '2025-04-05 16:16:46', '2025-04-05 16:16:46'),
(19, 2, 3, '2025-05-23', '2025-05-31', 0, 41232, 'confirmed', 'Özel temizlik talep ediliyor.', '2025-04-17 16:16:46', '2025-04-17 16:16:46'),
(20, 2, 3, '2025-05-24', '2025-05-31', 1, 36078, 'confirmed', 'Özel temizlik talep ediliyor.', '2025-05-03 16:16:46', '2025-05-03 16:16:46'),
(21, 6, 3, '2025-06-26', '2025-07-13', 1, 65382, 'confirmed', 'Aile toplantısı.', '2025-05-13 16:16:46', '2025-05-17 16:16:46'),
(22, 20, 3, '2025-09-17', '2025-10-02', 1, 62745, 'confirmed', NULL, '2025-05-06 16:16:46', '2025-05-20 16:16:46'),
(23, 9, 3, '2025-05-29', '2025-06-05', 1, 25382, 'confirmed', 'Çocuk dostu ortam gerekli.', '2025-05-11 16:16:46', '2025-05-23 16:16:46'),
(24, 2, 3, '2025-06-03', '2025-06-15', 0, 61848, 'confirmed', 'Özel diyet ihtiyacı var.', '2025-05-01 16:16:46', '2025-05-19 16:16:46'),
(25, 3, 3, '2025-07-03', '2025-07-20', 0, 32045, 'confirmed', NULL, '2025-04-25 16:16:46', '2025-05-12 16:16:46'),
(26, 16, 3, '2025-07-12', '2025-07-15', 0, 16983, 'confirmed', 'Deniz manzarası önemli.', '2025-04-29 16:16:46', '2025-05-12 16:16:46'),
(27, 13, 3, '2025-06-06', '2025-06-21', 1, 114735, 'confirmed', 'Doğum günü kutlaması için.', '2025-05-01 16:16:46', '2025-05-17 16:16:46'),
(28, 4, 3, '2025-09-21', '2025-10-08', 0, 132838, 'confirmed', 'Özel temizlik talep ediliyor.', '2025-05-11 16:16:46', '2025-05-17 16:16:46'),
(29, 3, 3, '2025-07-23', '2025-07-31', 0, 15080, 'confirmed', 'Balayı tatili.', '2025-05-06 16:16:46', '2025-05-18 16:16:46'),
(30, 3, 3, '2025-09-06', '2025-09-26', 0, 37700, 'confirmed', 'Deniz manzarası önemli.', '2025-04-29 16:16:46', '2025-05-25 16:16:46'),
(31, 16, 3, '2025-09-01', '2025-09-10', 1, 50949, 'confirmed', 'Erken check-in talep ediliyor.', '2025-05-04 16:16:46', '2025-05-16 16:16:46'),
(32, 19, 3, '2025-08-08', '2025-08-24', 0, 72368, 'confirmed', 'Özel temizlik talep ediliyor.', '2025-05-05 16:16:46', '2025-05-20 16:16:46'),
(33, 1, 3, '2025-06-27', '2025-07-16', 1, 73131, 'confirmed', 'Erken check-in talep ediliyor.', '2025-05-05 16:16:46', '2025-05-10 16:16:46'),
(34, 19, 3, '2025-06-18', '2025-06-29', 1, 49753, 'confirmed', 'Pet-friendly villa arıyoruz.', '2025-05-17 16:16:46', '2025-05-11 16:16:46'),
(35, 19, 3, '2025-08-10', '2025-08-14', 1, 18092, 'confirmed', 'Pet-friendly villa arıyoruz.', '2025-05-20 16:16:46', '2025-05-17 16:16:46'),
(36, 7, 3, '2025-05-30', '2025-06-03', 1, 17628, 'confirmed', 'Sessiz bir ortam tercih ediliyor.', '2025-05-15 16:16:46', '2025-05-11 16:16:46'),
(37, 7, 3, '2025-06-06', '2025-06-23', 1, 74919, 'confirmed', 'Pet-friendly villa arıyoruz.', '2025-05-17 16:16:46', '2025-05-25 16:16:46'),
(38, 15, 3, '2025-06-24', '2025-07-10', 0, 30240, 'confirmed', NULL, '2025-05-22 16:16:46', '2025-05-15 16:16:46'),
(39, 18, 3, '2025-06-17', '2025-06-23', 0, 32364, 'confirmed', 'Mutfak malzemeleri tam olsun.', '2025-04-27 16:16:46', '2025-05-23 16:16:46'),
(40, 17, 3, '2025-06-09', '2025-06-19', 0, 48480, 'confirmed', 'Geç check-out gerekli.', '2025-05-10 16:16:46', '2025-05-15 16:16:46'),
(41, 16, 3, '2025-06-29', '2025-07-08', 1, 50949, 'cancelled', 'Pet-friendly villa arıyoruz.', '2025-05-25 16:16:46', '2025-05-25 17:53:41'),
(42, 5, 3, '2025-06-26', '2025-07-02', 0, 12282, 'pending', 'Yakın restoran önerileri isteniyor.', '2025-05-19 16:16:46', '2025-05-23 16:16:46'),
(43, 8, 3, '2025-06-22', '2025-06-27', 0, 36620, 'pending', 'İş seyahati.', '2025-05-20 16:16:46', '2025-05-22 16:16:46'),
(44, 13, 3, '2025-06-24', '2025-07-02', 0, 61192, 'pending', 'Sessiz bir ortam tercih ediliyor.', '2025-05-24 16:16:46', '2025-05-25 16:16:46'),
(45, 7, 3, '2025-07-03', '2025-07-07', 1, 17628, 'pending', 'İş seyahati.', '2025-05-23 16:16:46', '2025-05-22 16:16:46'),
(46, 12, 3, '2025-07-09', '2025-07-17', 0, 46032, 'pending', 'Çocuk dostu ortam gerekli.', '2025-05-24 16:16:46', '2025-05-25 16:16:46'),
(47, 13, 3, '2025-06-13', '2025-06-19', 1, 45894, 'pending', 'İş seyahati.', '2025-05-21 16:16:46', '2025-05-25 16:16:46'),
(48, 15, 3, '2025-07-14', '2025-07-17', 0, 5670, 'pending', NULL, '2025-05-21 16:16:46', '2025-05-23 16:16:46'),
(49, 7, 3, '2025-07-07', '2025-07-21', 1, 61698, 'cancelled', NULL, '2025-05-16 16:16:46', '2025-05-24 16:16:46'),
(50, 11, 3, '2025-07-11', '2025-07-25', 1, 51968, 'cancelled', 'Ekstra havlu ve çarşaf gerekli.', '2025-05-04 16:16:46', '2025-05-22 16:16:46'),
(51, 10, 3, '2025-08-04', '2025-08-14', 0, 28130, 'cancelled', 'Pet-friendly villa arıyoruz.', '2025-05-01 16:16:46', '2025-05-18 16:16:46'),
(52, 3, 3, '2025-08-14', '2025-08-17', 0, 5655, 'cancelled', 'Pet-friendly villa arıyoruz.', '2025-05-20 16:16:46', '2025-05-11 16:16:46'),
(53, 2, 3, '2025-06-13', '2025-06-22', 0, 46386, 'cancelled', 'Balayı tatili.', '2025-05-19 16:16:46', '2025-05-23 16:16:46'),
(54, 10, 3, '2025-06-13', '2025-06-16', 1, 8439, 'cancelled', 'Sessiz bir ortam tercih ediliyor.', '2025-05-06 16:16:46', '2025-05-17 16:16:46'),
(55, 9, 3, '2025-08-19', '2025-09-12', 3, 78322, 'confirmed', 'Uzun süreli konaklama - %10 indirim uygulandı. Özel temizlik talep ediliyor.', '2025-05-11 16:16:46', '2025-05-13 16:16:46'),
(56, 10, 3, '2025-06-25', '2025-08-08', 4, 111395, 'confirmed', 'Uzun süreli konaklama - %10 indirim uygulandı. Özel diyet ihtiyacı var.', '2025-04-11 16:16:46', '2025-05-13 16:16:46'),
(57, 6, 3, '2025-06-27', '2025-08-11', 3, 155763, 'confirmed', 'Uzun süreli konaklama - %10 indirim uygulandı. Doğum günü kutlaması için.', '2025-04-26 16:16:46', '2025-05-08 16:16:46'),
(58, 1, 4, '2025-06-24', '2025-06-29', 4, 15000, 'confirmed', NULL, '2025-05-25 17:47:41', '2025-05-25 17:47:41'),
(59, 2, 4, '2025-05-15', '2025-05-20', 2, 8000, 'completed', NULL, '2025-05-25 17:47:41', '2025-05-25 17:47:41'),
(60, 3, 4, '2025-07-24', '2025-07-31', 6, 21000, 'pending', NULL, '2025-05-25 17:47:41', '2025-05-25 17:47:41'),
(61, 1, 3, '2025-05-26', '2025-05-29', 1, 11547, 'confirmed', NULL, '2025-05-25 18:36:52', '2025-05-25 20:56:54'),
(62, 5, 3, '2025-06-03', '2025-06-08', 2, 10235, 'confirmed', NULL, '2025-05-26 04:27:34', '2025-05-26 06:44:34'),
(63, 21, 3, '2025-06-02', '2025-06-07', 4, 15000, 'confirmed', NULL, '2025-05-26 06:20:04', '2025-05-26 06:24:27'),
(64, 21, 3, '2025-06-07', '2025-06-10', 1, 9000, 'pending', NULL, '2025-05-28 07:30:28', '2025-05-28 07:30:28'),
(65, 1, 1, '2025-06-01', '2025-06-04', 1, 11547, 'pending', NULL, '2025-05-28 07:44:54', '2025-05-28 07:44:54');

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

--
-- Tablo döküm verisi `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `reply_message`, `status`, `read_at`, `replied_at`, `created_at`, `updated_at`) VALUES
(1, 'Ahmet Yılmaz', 'ahmet@example.com', '+90 555 123 45 67', 'villa-kiralama', 'Merhaba, Fethiye bölgesinde 4 kişilik villa arıyorum. 15-22 Haziran tarihleri için müsait villalarınız var mı? Denize yakın olması tercihim.', NULL, 'read', '2025-05-28 16:47:25', NULL, '2025-05-28 16:16:27', '2025-05-28 16:47:25'),
(3, 'Sinem Yılmaz', 'nyxsylvaine2@gmail.com', '+905466058308', 'villa-kiralama', 'kiralama nasıl yapılıyor?', 'nasıl istersen öylee', 'replied', '2025-05-28 16:19:50', '2025-05-28 16:45:00', '2025-05-28 16:19:08', '2025-05-28 16:45:00'),
(4, 'Test Kullanıcı', 'test@example.com', '+90 555 123 45 67', 'villa-kiralama', 'Merhaba, Fethiye bölgesinde 4 kişilik villa arıyorum. 15-22 Haziran tarihleri için müsait villalarınız var mı?', 'evet var efendim', 'replied', '2025-05-28 16:46:39', '2025-05-28 16:46:58', '2025-05-28 16:29:33', '2025-05-28 16:46:58'),
(5, 'Sinem Yılmaz', 'nyxsylvaine3@gmail.com', '+905466058308', 'rezervasyon', 'rezervasyon iptal ediliyor mu?', NULL, 'replied', '2025-05-28 16:30:33', NULL, '2025-05-28 16:30:21', '2025-05-28 16:37:39');

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
(1, 4, 1, '2025-05-25 17:47:41', '2025-05-25 17:47:41'),
(2, 4, 2, '2025-05-25 17:47:41', '2025-05-25 17:47:41'),
(38, 3, 1, '2025-05-25 18:12:48', '2025-05-25 18:12:48'),
(39, 3, 4, '2025-05-26 03:49:02', '2025-05-26 03:49:02'),
(40, 3, 2, '2025-05-26 06:20:50', '2025-05-26 06:20:50');

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
(1, 'Özel Havuz', 'swimming-pool', 'Villa\'ya özel yüzme havuzu', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(2, 'Deniz Manzarası', 'water', 'Muhteşem deniz manzarası', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(3, 'Jakuzi', 'hot-tub', 'Özel jakuzi', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(4, 'Bahçe', 'tree', 'Özel bahçe alanı', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(5, 'Barbekü', 'fire', 'Barbekü alanı', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(6, 'Wi-Fi', 'wifi', 'Ücretsiz Wi-Fi', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(7, 'Klima', 'snowflake', 'Merkezi klima sistemi', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(8, 'Otopark', 'parking', 'Özel otopark alanı', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(9, 'Güvenlik', 'shield-alt', '7/24 güvenlik', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(10, 'Oyun Odası', 'gamepad', 'Oyun ve eğlence odası', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(11, 'Özel Havuz', NULL, NULL, '2025-05-26 04:18:44', '2025-05-26 04:18:44');

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
(1, 'Kalkan', 'kalkan', 'Antalya\'nın en güzel tatil beldelerinden biri olan Kalkan, muhteşem koyları ve tarihi dokusuyla öne çıkıyor.', 1, 1, 'location-images/Bj1sunzafUtU9MAb8GvHI4wowD3iD7AHw3knQ3Mi.jpg', '2025-05-25 13:02:22', '2025-05-28 13:05:25'),
(2, 'Kaş', 'kas', 'Akdeniz\'in incisi Kaş, berrak denizi ve antik kentleriyle misafirlerini büyülüyor.', 1, 1, 'location-images/ylwkwan1pJDH5QDbs6JJ8o17fLO6V7nD5X323LWI.jpg', '2025-05-25 13:02:22', '2025-05-25 22:08:56'),
(3, 'Fethiye', 'fethiye', 'Ölüdeniz\'in muhteşem manzarası ve doğal güzellikleriyle ünlü Fethiye, unutulmaz bir tatil vadediyor.', 1, 1, 'location-images/5AYOi9cDYA5CBVJEsqHclnUeyLq3Wttdw7JvAm5T.jpg', '2025-05-25 13:02:22', '2025-05-25 18:39:28'),
(4, 'Bodrum', 'bodrum', 'Türkiye\'nin en popüler tatil destinasyonlarından Bodrum, eğlence ve lüksü bir arada sunuyor.', 1, 1, 'location-images/fWDEZnURJWq2NIKIdMbGglTCrTY3MQC8gyh0lOts.jpg', '2025-05-25 13:02:22', '2025-05-25 18:40:28'),
(5, 'Çeşme', 'cesme', 'İzmir\'in gözde tatil beldesi Çeşme, termal kaynakları ve rüzgar sörfüyle meşhur.', 1, 1, 'location-images/DM5xijpgc3h6u1JM9XTabhA8ZelMIREaxBYfBWKz.jpg', '2025-05-25 13:02:22', '2025-05-25 18:40:31');

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
(11, '2023_01_01_000008_create_favorites_table', 1),
(12, '2024_03_19_add_image_to_locations_table', 1),
(13, '2024_03_20_000000_create_reviews_table', 1),
(14, '2024_03_21_000000_create_settings_table', 1),
(15, '2024_03_22_cleanup_villa_features', 1),
(16, '2025_05_25_204147_add_customer_fields_to_users_table', 2),
(17, '2025_05_28_103830_update_villa_check_times', 3),
(18, '2025_05_28_111349_update_reviews_table_add_booking_id', 4),
(19, '2025_05_28_191019_create_contacts_table', 5),
(20, '2025_05_28_194108_add_reply_message_to_contacts_table', 6);

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
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6);

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
(1, 'view villas', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(2, 'create villa', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(3, 'edit villa', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(4, 'delete villa', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(5, 'manage villa images', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(6, 'manage villa features', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(7, 'view locations', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(8, 'create location', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(9, 'edit location', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(10, 'delete location', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(11, 'view features', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(12, 'create feature', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(13, 'edit feature', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(14, 'delete feature', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(15, 'view bookings', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(16, 'create booking', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(17, 'edit booking', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(18, 'cancel booking', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(19, 'manage booking status', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(20, 'view users', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(21, 'create user', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(22, 'edit user', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(23, 'delete user', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(24, 'manage user roles', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22');

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
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `villa_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `reviews`
--

INSERT INTO `reviews` (`id`, `booking_id`, `user_id`, `villa_id`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 14, 3, 5, 4, 'her şey çok güzeldi çok memnun kaldım', 1, '2025-05-28 08:23:50', '2025-05-28 08:34:20');

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
(1, 'admin', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(2, 'realtor', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(3, 'customer', 'web', '2025-05-25 13:02:22', '2025-05-25 13:02:22');

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

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_title', 'VillaLand', '2025-05-25 19:17:48', '2025-05-25 19:17:48'),
(2, 'site_description', NULL, '2025-05-25 19:17:48', '2025-05-25 19:17:48'),
(3, 'contact_email', 'info@villaland.com', '2025-05-25 19:17:48', '2025-05-25 19:17:48'),
(4, 'contact_phone', '+90 555 555 55 55', '2025-05-25 19:17:48', '2025-05-25 19:18:06'),
(5, 'contact_address', 'Çorum, Türkiye', '2025-05-25 19:17:48', '2025-05-25 19:17:48'),
(6, 'facebook_url', NULL, '2025-05-25 19:17:48', '2025-05-25 19:17:48'),
(7, 'twitter_url', NULL, '2025-05-25 19:17:48', '2025-05-25 19:17:48'),
(8, 'instagram_url', NULL, '2025-05-25 19:17:48', '2025-05-25 19:17:48');

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
(1, 'Admin', 'admin@villaland.com', '2025-05-25 13:02:22', '$2y$10$yDKKY3zZuoI..pNWOVTzOuRvAO1RW5L1vUXAYwzdPyW7CnkPN2N16', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 'tr', 'TRY', 0, 0, NULL, NULL, NULL, NULL, '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(2, 'Realtor', 'realtor@villaland.com', '2025-05-25 13:02:22', '$2y$10$BbpMf3i4HKQy9hIGKzcP5e2PTnPVmD0fDc9pEofpVqwoDG0YHADR2', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 'tr', 'TRY', 0, 0, NULL, NULL, NULL, NULL, '2025-05-25 13:02:22', '2025-05-25 13:02:22'),
(3, 'Customer', 'customer@villaland.com', '2025-05-25 13:02:22', '$2y$10$GTlk.XDvX47erO7xuu3PVuPUGGHchjzEI1n.v8k/yZKPZzv9ABhHy', NULL, NULL, NULL, NULL, 'female', NULL, 1, 0, 'tr', 'TRY', 0, 0, NULL, NULL, 'avatars/AdXjLnwnYN4BGFJOBS0d3b2PpKaVnTUyBadn3Vfq.jpg', NULL, '2025-05-25 13:02:22', '2025-05-28 06:58:13'),
(4, 'Test Müşteri', 'customer@test.com', NULL, '$2y$10$xuSRRWTxlQsdV/RZTD7pkua4Ut9lfgukKvWuWizH5cQ0YfBAPg2HG', '+90 555 123 45 67', NULL, 'İstanbul', '1990-01-01', 'male', 'Test müşteri hesabı', 1, 0, 'tr', 'TRY', 0, 0, NULL, NULL, NULL, NULL, '2025-05-25 17:45:56', '2025-05-25 17:45:56'),
(5, 'Sinem Yılmaz', 'nyxsylvaine3@gmail.com', NULL, '$2y$10$j2CYe3p/8EwBFu95fjR2rOjZtHBH28rYmNCUAbTJ9p4aC.34p0Deu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 'tr', 'TRY', 0, 0, NULL, NULL, NULL, 'N8cfu6gkMU0DA3arI2m5rQqqtW5OYk8AjZfJo2td5VawSh16UIQwPi9GEXLT', '2025-05-25 21:41:23', '2025-05-25 21:46:18'),
(6, 'Sinem Yılmaz', 'nyxsylvaine4@gmail.com', NULL, '$2y$10$rqFxqB9/GtQChAgFOKT/V.Ol/nLBhOau/c7l.LhkiKlaLeWQUiBp6', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 'tr', 'TRY', 0, 0, NULL, NULL, NULL, NULL, '2025-05-30 13:35:51', '2025-05-30 13:35:51');

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
(1, 'Lüks Deniz Manzaralı Villa', 'luks-deniz-manzarali-villa-1', 'Tempora autem dignissimos omnis aut molestiae voluptatem. Magni consectetur quis voluptas consequatur unde. Harum iusto ipsam suscipit dignissimos.\r\n\r\nAut voluptas nihil sed illum esse. Eum hic qui minima nemo itaque qui. Amet nihil aut rerum minima. Occaecati quod et aut cum accusamus. Sed totam corporis rerum voluptatum deleniti qui corrupti.', 2, 2, 5, 1, 10, 380, 3849.00, 0.00, 1, 1, '15:00:00', '11:00:00', 1, '800 Kirk Parkways Suite 547\r\nPort Vickyfort, ND 71965', -6.90107500, 90.28398400, '2025-05-25 13:25:24', '2025-05-28 14:52:05'),
(2, 'Modern Havuzlu Villa', 'modern-havuzlu-villa-2', 'Et nostrum perspiciatis voluptatum quae quam. Sint quisquam est nam ad. Corporis qui error nam veritatis id fuga aut qui. Eius et quia nihil vero earum facilis deserunt. Quod aut voluptatem et repudiandae necessitatibus.\r\n\r\nAut aut sed pariatur sit repellat. Impedit quaerat totam in enim aliquid sed et dolor. Accusantium est quas numquam et est ut.', 2, 2, 2, 2, 12, 185, 5154.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '281 Josianne Crescent Suite 236\r\nSauermouth, TX 98299', 67.08844700, -42.44194000, '2025-05-25 13:25:24', '2025-05-28 15:00:42'),
(3, 'Özel Plajlı Villa', 'ozel-plajli-villa-3', 'Rerum iste aut minus cupiditate. Neque voluptas numquam voluptate dicta. Esse minima ut cumque. Esse perferendis nemo maiores eveniet quisquam quasi harum ducimus.\r\n\r\nDignissimos asperiores quia facere molestiae aut. Velit dolore dolorum odit voluptatibus eum ullam. Incidunt voluptatem repudiandae sapiente nulla. Et dicta adipisci consequatur. Culpa consectetur nihil explicabo.', 3, 2, 5, 3, 12, 140, 1885.00, 0.00, 1, 1, '15:00:00', '11:00:00', 1, '52804 D\'Amore Mews Apt. 853\r\nLuigifort, VT 65027-4037', 26.69456100, -2.84381400, '2025-05-25 13:25:24', '2025-05-28 15:07:01'),
(4, 'Muhteşem Manzaralı Villa', 'muhtesem-manzarali-villa-4', 'Sit non ut quidem non et aspernatur incidunt minus. Mollitia non tenetur fugiat autem et. Minus earum mollitia corporis et.\r\n\r\nEst veritatis molestiae animi saepe magnam. Perspiciatis dolor et ipsam nam quisquam. Dolorem exercitationem quia deleniti sunt suscipit atque.', 2, 2, 3, 1, 9, 236, 7814.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '2936 Beulah Bypass\r\nWest Demario, SD 94856', 81.58021300, -22.88864800, '2025-05-25 13:25:24', '2025-05-28 15:07:22'),
(5, 'Jakuzili Lüks Villa', 'jakuzili-luks-villa-5', 'Et nihil iste non qui alias eius ipsum. In quasi ut id exercitationem. Quasi omnis necessitatibus voluptate molestias dicta in ratione omnis.\r\n\r\nIpsum itaque autem commodi sit beatae. Vitae blanditiis porro numquam quia qui odio dicta vel. Possimus et id qui corporis reiciendis. Tenetur optio voluptates velit veniam id.', 2, 2, 4, 3, 11, 384, 2047.00, 0.00, 1, 1, '15:00:00', '11:00:00', 1, '58040 Buford Mountains Suite 531\r\nSouth Emilia, UT 01907-0952', -38.85813100, 10.59636700, '2025-05-25 13:25:24', '2025-05-28 15:08:52'),
(6, 'Doğa İçinde Villa', 'doga-icinde-villa-6', 'Molestiae fugiat provident eius esse sunt. Quaerat aut voluptas culpa nihil tenetur autem. Vitae molestias odio et officiis.\r\n\r\nLaudantium consectetur at ipsam est itaque qui eveniet animi. Expedita occaecati aut inventore harum aperiam qui sit temporibus. Nostrum eos qui odit nulla minima. Consequuntur culpa aut vero optio quis voluptatem ab sunt.', 2, 2, 5, 4, 4, 362, 3846.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '14509 Lia Ferry\r\nNew Lucie, DE 48336', -23.43874500, -114.93715100, '2025-05-25 13:25:24', '2025-05-28 15:10:08'),
(7, 'Infinity Havuzlu Villa', 'infinity-havuzlu-villa-7', 'Aliquam unde esse laboriosam corporis velit sit eos perferendis. Ab ipsam impedit est possimus voluptatibus ut adipisci. Est adipisci temporibus quia laborum odio rerum itaque at. Maiores possimus minus recusandae minus.\r\n\r\nQuasi earum voluptatem molestiae eius. Dicta vel qui ea et explicabo cum. Consectetur optio pariatur et dicta voluptatibus. Consequatur voluptatem ipsum ut voluptatem aut.', 5, 2, 4, 4, 6, 147, 4407.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '4643 Lowe Cape Apt. 650\r\nNealhaven, NJ 84330-7847', -54.28667900, 49.56865400, '2025-05-25 13:25:24', '2025-05-28 15:14:03'),
(8, 'Sahil Kenarı Villa', 'sahil-kenari-villa-8', 'Quibusdam aut voluptas saepe quod alias. Eum ad cum quidem nemo. Ut et ea quis et iure quo animi. Reiciendis error voluptatem et dolorem blanditiis possimus.\r\n\r\nNihil velit eos reprehenderit quis. Ut explicabo expedita at quae omnis quos dolor. Illo alias voluptates hic voluptatum hic eum. Ut magnam dolore repellendus beatae et aut optio nesciunt.', 4, 2, 6, 1, 4, 380, 7324.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '6456 Ebert Course\r\nPort Gerry, SD 30836', -35.26523400, 134.46472300, '2025-05-25 13:25:24', '2025-05-28 15:17:35'),
(9, 'Panoramik Manzaralı Villa', 'panoramik-manzarali-villa-9', 'Quo quis est qui consequatur aut delectus. Quia velit voluptatem impedit voluptate voluptatem cupiditate. Aperiam qui voluptatum ad nihil illum nobis molestiae.\r\n\r\nIure nihil ea impedit repellendus sequi vel molestias consequatur. Ea doloribus dolorem provident ipsam tempore. Quasi dolor et qui omnis alias. Eum sit et rerum. Iusto ea et iste deserunt et neque vero.', 1, 2, 2, 4, 4, 143, 3626.00, 0.00, 1, 1, '15:00:00', '11:00:00', 1, '1332 Koss Springs Apt. 061\r\nChristyside, WI 44557-2010', 60.57333500, 81.74772100, '2025-05-25 13:25:24', '2025-05-28 15:20:13'),
(10, 'Ultra Lüks Villa', 'ultra-luks-villa-10', 'Quia incidunt incidunt nemo corporis ut. Ut facere voluptas fugiat amet laborum. Quidem non consectetur optio nisi quos numquam.\r\n\r\nMolestiae vel id voluptas magnam quidem blanditiis. Qui eos quia praesentium est optio alias. Rem vitae labore sapiente vel totam voluptatem aliquam. Nobis a aspernatur sit. Vero accusantium nihil fugiat.', 5, 2, 3, 2, 9, 373, 2813.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '4441 Marquardt Gardens Apt. 412\r\nWest Elainafurt, KY 26534', -74.05169900, 77.51038900, '2025-05-25 13:25:24', '2025-05-28 15:36:22'),
(11, 'Özel Tasarım Villa', 'ozel-tasarim-villa-11', 'Tempore ducimus molestias impedit minima velit. Architecto autem id numquam. Labore alias voluptatem omnis architecto cumque neque.\r\n\r\nReprehenderit est eligendi laborum non aut. Fuga quisquam doloribus dolorem non praesentium. Voluptatum omnis dignissimos ea eaque repellat dolores.', 4, 2, 5, 2, 5, 134, 3712.00, 0.00, 1, 1, '15:00:00', '11:00:00', 1, '371 Leif Mission\r\nPollichton, GA 63666', -5.38299100, 105.75406800, '2025-05-25 13:25:24', '2025-05-28 15:36:56'),
(12, 'Bahçeli Müstakil Villa', 'bahceli-mustakil-villa-12', 'Non modi nam quo asperiores delectus. Et ratione quae vel voluptates et et quas. Sapiente mollitia voluptatum minus recusandae consequatur. Sit in doloribus et culpa eos.\r\n\r\nExplicabo cumque dolor qui id. Distinctio eos ex eum quae aut aut. Provident quidem deleniti enim odit. Odio praesentium officia molestiae cum.', 4, 2, 4, 4, 11, 208, 5754.00, 0.00, 1, 1, '15:00:00', '11:00:00', 1, '42940 Jerde Streets\r\nLake Lurline, MA 75744-5027', -49.05935100, 113.29113800, '2025-05-25 13:25:24', '2025-05-28 15:40:10'),
(13, 'Spa & Havuzlu Villa', 'spa-havuzlu-villa-13', 'Nobis voluptatem occaecati eveniet id est. Veritatis dolores voluptatibus delectus. Aut et ex ut nostrum. Debitis dignissimos et aut non enim sunt.\r\n\r\nExplicabo dolor esse officia. Beatae dolor suscipit sit autem ad. Tempora dolore inventore reprehenderit dolores voluptatem adipisci odit. Reprehenderit voluptas vel quidem voluptatem.', 2, 2, 4, 1, 8, 299, 7649.00, 0.00, 1, 1, '15:00:00', '11:00:00', 1, '452 Hammes Ferry\r\nNorth Lelahmouth, ND 76999-5901', 74.01645000, -18.29110200, '2025-05-25 13:25:24', '2025-05-28 15:40:48'),
(14, 'Denize Sıfır Villa', 'denize-sifir-villa-14', 'Numquam neque exercitationem earum maxime. Officiis aliquam eum dolores eos.\r\n\r\nConsequatur aspernatur fuga dolorem dolores sed. Blanditiis sint illo tenetur qui saepe alias provident. Eum facere veniam aut praesentium.', 1, 2, 2, 1, 5, 206, 2260.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '7163 Gutkowski Haven Suite 218\r\nAmayamouth, AZ 60745-3496', -67.80813400, 22.32123400, '2025-05-25 13:25:24', '2025-05-28 15:41:25'),
(15, 'Orman Manzaralı Villa', 'orman-manzarali-villa-15', 'Consequatur nisi voluptas est. Animi eum unde rerum assumenda libero. Praesentium molestiae aut ipsa totam ad earum. Laborum et aut corrupti rerum facilis quas esse et.\r\n\r\nCumque dolor iusto voluptas perspiciatis doloremque quis. Exercitationem consectetur et quos officiis enim ducimus dolor. Reiciendis molestias ut quam error et quisquam. Voluptatum est ea dolorum.', 4, 2, 4, 1, 11, 249, 1890.00, 0.00, 1, 1, '15:00:00', '11:00:00', 1, '87315 Janis Fords Apt. 181\r\nEast Cary, NH 71779', 65.42891400, -20.17475300, '2025-05-25 13:25:24', '2025-05-28 15:51:00'),
(16, 'Teraslı Lüks Villa', 'terasli-luks-villa-16', 'Cum ea molestiae et quos aut similique. Accusantium quos et enim voluptatibus quia. Expedita id dolore dolorum labore ipsa occaecati.\r\n\r\nRepudiandae voluptatem eum ipsam eos. In corporis occaecati rem vel eum. Perspiciatis eveniet vel in fuga neque rerum eligendi. Soluta iure eum suscipit quod nobis eaque id.', 4, 2, 3, 4, 9, 160, 5661.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '799 Gibson Crest Apt. 140\r\nEast Otto, DE 77724', -50.08510200, -49.91325500, '2025-05-25 13:25:24', '2025-05-28 15:51:33'),
(17, 'Özel Havuzlu Villa', 'ozel-havuzlu-villa-17', 'Deserunt ea repellendus inventore provident. Laudantium et et est voluptatibus dicta nesciunt fuga. Consequuntur accusantium qui itaque et sequi. Minima voluptatem modi et voluptatem.\r\n\r\nAlias voluptatem asperiores quo fugiat magni. Architecto minus qui non illum harum. Temporibus tempore laudantium aliquid placeat id commodi non. Harum animi et blanditiis quasi quia assumenda rerum. Rerum rerum voluptatem totam consequuntur.', 1, 2, 5, 3, 9, 324, 4848.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '47135 Kylee Wells Apt. 509\r\nHalleport, WA 15746', 64.36210700, -126.40027200, '2025-05-25 13:25:24', '2025-05-28 15:52:20'),
(18, 'Muhteşem Konumlu Villa', 'muhtesem-konumlu-villa-18', 'Pariatur ut sed voluptatem. Culpa assumenda sint sed accusantium rem. Ut et consequuntur cumque aut. Eos ut vel inventore veritatis ea amet.\r\n\r\nIn quaerat assumenda eos. Temporibus perspiciatis voluptas omnis iusto voluptate ut. Impedit maxime quis et facilis velit.', 1, 2, 5, 3, 9, 121, 5394.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '7946 Leda Villages Apt. 292\r\nPort Saigebury, DC 10375', -11.95181900, 14.65324700, '2025-05-25 13:25:24', '2025-05-28 15:53:06'),
(19, 'Ayrıcalıklı Villa', 'ayricalikli-villa-19', 'Unde deleniti ut voluptatem nemo nam earum aspernatur. Praesentium architecto tempora impedit enim dolores non vel. Est explicabo nemo sapiente eligendi sit qui repellendus. Eligendi explicabo et sit enim impedit delectus eum.\r\n\r\nLaboriosam aliquid dolorem mollitia libero et quia. Recusandae harum expedita molestiae aperiam optio sint. Suscipit nulla corrupti deserunt consequuntur mollitia quo.', 2, 2, 5, 2, 5, 132, 4523.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '718 Magnus Center Suite 912\r\nPort Jaylinburgh, RI 80422-2157', -77.24986200, 161.85585700, '2025-05-25 13:25:24', '2025-05-28 15:53:36'),
(20, 'Premium Villa', 'premium-villa-20', 'Delectus alias quod quia iure est unde autem distinctio. Quasi molestiae blanditiis aut veniam molestias voluptatem. Minus aut repellat rem ab.\r\n\r\nEt quisquam quasi qui aut. Veritatis itaque ducimus labore nihil numquam asperiores error. Illo nemo neque mollitia. Ducimus ipsum eligendi asperiores officia autem soluta molestias.', 1, 2, 3, 2, 6, 128, 4183.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, '7107 Heber Points Suite 561\r\nNorth Maximusport, NY 92728-9120', 76.53602100, 105.83113100, '2025-05-25 13:25:24', '2025-05-28 15:54:14'),
(21, 'yeni villam', 'yeni-villam', 'çok güzel bir villadır', 3, 2, 3, 2, 8, 250, 3000.00, 0.00, 1, 0, '15:00:00', '11:00:00', 1, 'çorum merkez', 27.00000000, 15.00000000, '2025-05-26 04:18:44', '2025-05-28 15:55:08');

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

--
-- Tablo döküm verisi `villa_features`
--

INSERT INTO `villa_features` (`id`, `villa_id`, `feature_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 7, NULL, NULL),
(4, 1, 8, NULL, NULL),
(5, 2, 3, NULL, NULL),
(6, 2, 10, NULL, NULL),
(7, 2, 7, NULL, NULL),
(8, 2, 2, NULL, NULL),
(9, 2, 4, NULL, NULL),
(10, 3, 3, NULL, NULL),
(11, 3, 10, NULL, NULL),
(12, 3, 1, NULL, NULL),
(13, 3, 6, NULL, NULL),
(14, 3, 8, NULL, NULL),
(15, 4, 5, NULL, NULL),
(16, 4, 6, NULL, NULL),
(17, 4, 9, NULL, NULL),
(18, 4, 3, NULL, NULL),
(19, 5, 9, NULL, NULL),
(20, 5, 4, NULL, NULL),
(21, 5, 1, NULL, NULL),
(22, 5, 2, NULL, NULL),
(23, 5, 3, NULL, NULL),
(24, 5, 6, NULL, NULL),
(25, 6, 2, NULL, NULL),
(26, 6, 7, NULL, NULL),
(27, 6, 10, NULL, NULL),
(28, 6, 9, NULL, NULL),
(29, 6, 1, NULL, NULL),
(30, 6, 5, NULL, NULL),
(31, 7, 9, NULL, NULL),
(32, 7, 7, NULL, NULL),
(33, 7, 3, NULL, NULL),
(34, 7, 5, NULL, NULL),
(35, 7, 8, NULL, NULL),
(36, 7, 1, NULL, NULL),
(37, 8, 10, NULL, NULL),
(38, 8, 4, NULL, NULL),
(39, 8, 9, NULL, NULL),
(40, 9, 9, NULL, NULL),
(41, 9, 3, NULL, NULL),
(42, 9, 8, NULL, NULL),
(43, 10, 8, NULL, NULL),
(44, 10, 5, NULL, NULL),
(45, 10, 4, NULL, NULL),
(46, 10, 6, NULL, NULL),
(47, 11, 8, NULL, NULL),
(48, 11, 1, NULL, NULL),
(49, 11, 10, NULL, NULL),
(50, 12, 3, NULL, NULL),
(51, 12, 7, NULL, NULL),
(52, 12, 5, NULL, NULL),
(53, 12, 4, NULL, NULL),
(54, 12, 6, NULL, NULL),
(55, 12, 2, NULL, NULL),
(56, 13, 2, NULL, NULL),
(57, 13, 7, NULL, NULL),
(58, 13, 9, NULL, NULL),
(59, 14, 8, NULL, NULL),
(60, 14, 10, NULL, NULL),
(61, 14, 1, NULL, NULL),
(62, 14, 9, NULL, NULL),
(63, 14, 3, NULL, NULL),
(64, 14, 5, NULL, NULL),
(65, 15, 5, NULL, NULL),
(66, 15, 3, NULL, NULL),
(67, 15, 6, NULL, NULL),
(68, 15, 7, NULL, NULL),
(69, 16, 1, NULL, NULL),
(70, 16, 3, NULL, NULL),
(71, 16, 9, NULL, NULL),
(72, 16, 5, NULL, NULL),
(73, 17, 6, NULL, NULL),
(74, 17, 2, NULL, NULL),
(75, 17, 7, NULL, NULL),
(76, 17, 10, NULL, NULL),
(77, 18, 4, NULL, NULL),
(78, 18, 2, NULL, NULL),
(79, 18, 5, NULL, NULL),
(80, 19, 9, NULL, NULL),
(81, 19, 4, NULL, NULL),
(82, 19, 5, NULL, NULL),
(83, 19, 7, NULL, NULL),
(84, 20, 9, NULL, NULL),
(85, 20, 4, NULL, NULL),
(86, 20, 1, NULL, NULL),
(87, 20, 10, NULL, NULL),
(88, 20, 2, NULL, NULL),
(89, 1, 4, NULL, NULL),
(90, 21, 11, NULL, NULL);

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
(34, 2, 'villa-images/Kjbdh0nymuYV3uzbjJc4KYCPiNlTQbUvnWkPKiUN.jpg', 1, 0, '2025-05-28 15:06:42', '2025-05-28 16:00:53'),
(36, 3, 'villa-images/Q9P8aZNFu006g7MA8Zgx3z2kxDM93SUYuFsKoeZX.jpg', 1, 0, '2025-05-28 15:07:01', '2025-05-28 15:08:17'),
(38, 4, 'villa-images/Tdf2bBtccKJOUUgYkd7kSa9C7qX4kxoV4g0v4jvC.jpg', 1, 0, '2025-05-28 15:07:22', '2025-05-28 15:08:29'),
(40, 5, 'villa-images/O7FWwN2dct5dD6Rydu65SKXZxjmaGTUjJsk1hBH0.jpg', 1, 0, '2025-05-28 15:08:53', '2025-05-28 15:09:10'),
(42, 6, 'villa-images/HD0TXtKmASWDBnm1sidotu9nQ3j0cogDnqLaW1Kb.jpg', 1, 0, '2025-05-28 15:10:08', '2025-05-28 15:13:31'),
(44, 7, 'villa-images/giB0jBcEoJfCPQuLSux0GjKjTykv0Ewc3Et7a78n.jpg', 1, 0, '2025-05-28 15:14:03', '2025-05-28 15:14:24'),
(45, 8, 'villa-images/7aa4d0va5KBW9fQMZ9E6KikBj1bMLXpGmzDN5K4Z.jpg', 1, 0, '2025-05-28 15:17:35', '2025-05-28 15:18:07'),
(50, 9, 'villa-images/6ZfRkqx1gJvDXuierPGHFkcvRwjiaHngFtJQtYWC.jpg', 1, 0, '2025-05-28 15:35:45', '2025-05-28 15:35:45'),
(51, 10, 'villa-images/gJhASmT8hiyhTSMD9XyCkmwNxa0c0YfQRDY0HN16.jpg', 1, 0, '2025-05-28 15:36:22', '2025-05-28 15:36:22'),
(52, 11, 'villa-images/ow8gd3ilMB8HH9XBNhbHU32QJIF5b5CgrcIMbf9c.jpg', 1, 0, '2025-05-28 15:36:56', '2025-05-28 15:36:56'),
(53, 12, 'villa-images/9zPBaHFZLPhPz0Nw5KuT9jHLpTZBhar9ae1u4zfg.jpg', 1, 0, '2025-05-28 15:40:10', '2025-05-28 15:40:10'),
(54, 13, 'villa-images/LkATPosslCQF3VAVrg7DOc6nPcHp63t9x22UyQy2.jpg', 1, 0, '2025-05-28 15:40:48', '2025-05-28 15:40:48'),
(55, 14, 'villa-images/uLMkWddVjHYgfij6bJ7RYCQJL1jvbsjtubd5sePr.jpg', 1, 0, '2025-05-28 15:41:25', '2025-05-28 15:41:25'),
(56, 15, 'villa-images/IdngQDc8yRzRIcJqlBG07FQ26M937cShgdRBWQts.jpg', 1, 0, '2025-05-28 15:51:00', '2025-05-28 15:51:00'),
(57, 16, 'villa-images/IueWfpNwC1pHOwRmqrGjW1z76to1JixC4iPQB54H.jpg', 1, 0, '2025-05-28 15:51:33', '2025-05-28 15:51:33'),
(58, 17, 'villa-images/XlkAqRXrykQ0PAx5VCLhHNP1MVyz5K6qNjBiOgdJ.jpg', 1, 0, '2025-05-28 15:52:21', '2025-05-28 15:52:21'),
(59, 18, 'villa-images/NXOKHfIYj4U3xma3mVGYmgRgmv6DZr2fqxRxFSLR.jpg', 1, 0, '2025-05-28 15:53:06', '2025-05-28 15:53:06'),
(60, 19, 'villa-images/mhy9usnbFdFn5jGW24T2oGuQ11Z0lxr5zqjJrx6W.jpg', 1, 0, '2025-05-28 15:53:37', '2025-05-28 15:53:37'),
(61, 20, 'villa-images/iPcX0O6KEVKaUOMKIwt4iqZLNHeEqYuxSUAXNMPd.jpg', 1, 0, '2025-05-28 15:54:14', '2025-05-28 15:54:14'),
(62, 21, 'villa-images/vG92pj2uRJF5pU45uBH3Fvxd8kGNGndINUUjdtql.jpg', 1, 0, '2025-05-28 15:55:08', '2025-05-28 15:55:08'),
(69, 1, 'villa-images/T96oYwmKHwNVFXaAfm5RcFtHO8hBXEorfgai1z5e.jpg', 0, 0, '2025-05-28 19:10:06', '2025-05-28 19:10:06'),
(70, 1, 'villa-images/7vLQpoNV3VXomXykPgZnExcMIS7KMTrNGKwjKvWE.jpg', 1, 1, '2025-05-28 19:10:06', '2025-05-28 19:10:06'),
(71, 1, 'villa-images/U8tqJ3GMs7w9Sycz7GcnLObAjZhuvlexmkxlCawt.jpg', 0, 2, '2025-05-28 19:10:06', '2025-05-28 19:10:06'),
(72, 1, 'villa-images/vy6inT9Itlu7cqciHkS6OPDVIucF7kTgNalz4H8S.jpg', 0, 3, '2025-05-28 19:10:06', '2025-05-28 19:10:06'),
(73, 1, 'villa-images/MKfyQKfcenM7L8KfoPge5xQue90emoHUxeCgCTQN.jpg', 0, 4, '2025-05-28 19:10:06', '2025-05-28 19:10:06'),
(74, 1, 'villa-images/qCsIkWNJbByMOsgU45w7IP1Z49ktvoSKvfjI1txI.jpg', 0, 5, '2025-05-28 19:10:06', '2025-05-28 19:10:06');

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
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_villa_id_is_approved_index` (`villa_id`,`is_approved`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Tablo için AUTO_INCREMENT değeri `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Tablo için AUTO_INCREMENT değeri `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `villas`
--
ALTER TABLE `villas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `villa_features`
--
ALTER TABLE `villa_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- Tablo için AUTO_INCREMENT değeri `villa_images`
--
ALTER TABLE `villa_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

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
