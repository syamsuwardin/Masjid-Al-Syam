-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 11 Apr 2025 pada 11.48
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `al_syam_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` enum('berita','pengumuman','artikel') NOT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `featured` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author_id` int DEFAULT NULL,
  `views` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `content`, `image`, `category`, `status`, `featured`, `created_at`, `updated_at`, `author_id`, `views`) VALUES
(1, 'Pembangunan Menara Masjid', 'pembangunan-menara-masjid', 'Konten artikel...', NULL, 'berita', 'published', 1, '2025-04-11 07:42:42', '2025-04-11 07:42:42', NULL, 0),
(2, 'Jadwal Kajian Ramadhan', 'jadwal-kajian-ramadhan', 'Konten artikel...', NULL, 'pengumuman', 'published', 1, '2025-04-11 07:42:42', '2025-04-11 07:42:42', NULL, 0),
(28, 'Pembangunan Menara Masjid Tahap 1', 'pembangunan-menara-masjid-tahap-1', 'Alhamdulillah, pembangunan menara masjid tahap pertama telah dimulai. Pembangunan ini direncanakan akan selesai dalam waktu 6 bulan ke depan...', 'menara-1.jpg', 'berita', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(29, 'Jadwal Kajian Ramadhan 1445 H', 'jadwal-kajian-ramadhan-1445-h', 'Berikut adalah jadwal kajian selama bulan Ramadhan 1445 H di Masjid Al-Syam...', 'kajian-1.jpg', 'pengumuman', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(30, 'Keutamaan Sholat Berjamaah', 'keutamaan-sholat-berjamaah', 'Sholat berjamaah memiliki keutamaan yang sangat besar dalam Islam. Rasulullah SAW bersabda...', 'sholat-1.jpg', 'artikel', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(31, 'Renovasi Tempat Wudhu', 'renovasi-tempat-wudhu', 'Dalam rangka meningkatkan kenyamanan jamaah, Masjid Al-Syam melakukan renovasi tempat wudhu...', 'wudhu-1.jpg', 'berita', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(32, 'Program Santunan Anak Yatim', 'program-santunan-anak-yatim', 'Masjid Al-Syam mengadakan program santunan rutin untuk anak yatim setiap bulan...', 'santunan-1.jpg', 'pengumuman', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(33, 'Adab Memasuki Masjid', 'adab-memasuki-masjid', 'Sebagai muslim, penting bagi kita untuk mengetahui adab-adab ketika memasuki masjid...', 'adab-1.jpg', 'artikel', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(34, 'Pemasangan Panel Surya', 'pemasangan-panel-surya', 'Masjid Al-Syam mulai menggunakan energi ramah lingkungan dengan memasang panel surya...', 'panel-1.jpg', 'berita', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(35, 'Pembukaan Pendaftaran TPA', 'pembukaan-pendaftaran-tpa', 'Telah dibuka pendaftaran Taman Pendidikan Al-Quran (TPA) untuk semester baru...', 'tpa-1.jpg', 'pengumuman', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(36, 'Panduan Sholat Tahajjud', 'panduan-sholat-tahajjud', 'Sholat tahajjud merupakan salah satu ibadah sunnah yang memiliki keutamaan besar...', 'tahajjud-1.jpg', 'artikel', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(37, 'Perbaikan Sistem Audio', 'perbaikan-sistem-audio', 'Demi meningkatkan kualitas suara adzan dan kajian, dilakukan perbaikan sistem audio masjid...', 'audio-1.jpg', 'berita', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(38, 'Jadwal Khatib Jumat', 'jadwal-khatib-jumat', 'Berikut adalah jadwal khatib Jumat untuk bulan Syawal 1445 H...', 'khatib-1.jpg', 'pengumuman', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0),
(39, 'Pentingnya Memakmurkan Masjid', 'pentingnya-memakmurkan-masjid', 'Allah SWT menjanjikan pahala yang besar bagi orang-orang yang memakmurkan masjid...', 'makmur-1.jpg', 'artikel', 'draft', 0, '2025-04-11 08:51:37', '2025-04-11 08:51:37', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
