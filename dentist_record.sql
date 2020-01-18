-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 18 Oca 2020, 17:17:08
-- Sunucu sürümü: 10.4.8-MariaDB
-- PHP Sürümü: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `dentist_record`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `announcement_content` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `announcement_date` datetime DEFAULT NULL,
  `announcement_created_at` datetime NOT NULL,
  `announcement_updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `announcement_is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `note_record_id` int(11) NOT NULL,
  `note_user_id` int(11) NOT NULL,
  `note_content` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `note_stage` int(11) NOT NULL,
  `note_status` int(11) NOT NULL,
  `note_datetime` datetime DEFAULT NULL,
  `note_created_at` datetime NOT NULL,
  `note_is_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `records`
--

CREATE TABLE `records` (
  `record_id` int(11) NOT NULL,
  `record_user_id` int(11) NOT NULL,
  `record_name_surname` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `record_clinic_name` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `record_phone` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `record_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `record_address` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `record_stage` int(11) NOT NULL DEFAULT 0,
  `record_status` tinyint(4) NOT NULL DEFAULT 0,
  `record_created_at` datetime NOT NULL,
  `record_updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `record_is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stage`
--

CREATE TABLE `stage` (
  `stage_id` int(11) NOT NULL,
  `stage_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `stage_rank` tinyint(4) NOT NULL,
  `stage_is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status_is_deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_type` tinyint(4) NOT NULL,
  `user_name_surname` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_phone` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_email` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_password` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_created_at` datetime NOT NULL,
  `user_updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_is_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`user_id`, `user_type`, `user_name_surname`, `user_phone`, `user_email`, `user_password`, `user_created_at`, `user_updated_at`, `user_is_deleted`) VALUES
(1, 1, 'Admin (Sifre:123)', '1234567891', 'admin@admin.com', '6fd742a61bd034804c00c49b18045020', '2020-01-18 03:15:13', '2020-01-18 19:15:58', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Tablo için indeksler `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`);

--
-- Tablo için indeksler `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`record_id`);

--
-- Tablo için indeksler `stage`
--
ALTER TABLE `stage`
  ADD PRIMARY KEY (`stage_id`);

--
-- Tablo için indeksler `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `records`
--
ALTER TABLE `records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `stage`
--
ALTER TABLE `stage`
  MODIFY `stage_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
