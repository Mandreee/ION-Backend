-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jan 2023 pada 09.58
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `indonesiaopennews_test`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_approval`
--

CREATE TABLE `admin_approval` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_profile_link` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_profile_name` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_profile_path` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `join_at` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_news_approval`
--

CREATE TABLE `admin_news_approval` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_slug` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_picture_link` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_picture_name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_picture_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_topic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `history`
--

CREATE TABLE `history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_09_01_072341_create_topics_table', 1),
(6, '2022_09_01_072342_create_subtopics_table', 1),
(7, '2022_09_01_072347_create_news_table', 1),
(8, '2022_12_12_072635_admin_approval', 1),
(9, '2022_12_14_025009_creaete_history_table', 1),
(10, '2022_12_14_034028_create_admin_news_approval_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `news_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_slug` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_picture_link` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_picture_name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_picture_path` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added_at` bigint(20) UNSIGNED NOT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  `news_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_topic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `news_title`, `news_content`, `news_slug`, `news_picture_link`, `news_picture_name`, `news_picture_path`, `added_at`, `updated_at`, `news_status`, `sub_topic_id`, `user_id`) VALUES
(49, 'Pengganti Mychell Chagas Sudah Kawal PSS Sleman Di Bantul, Seto Bicara Proses Adaptasi', 'INDOSPORT.COM - PSS Sleman sudah mendapatkan pengganti Mychell Chagas untuk putaran kedua Liga 1 2022/2023. Bomber asal Ukraina, Yevhen Bokhashvili, nongol saat PSS melawan Persija Jakarta di Stadion Sultan Agung, Bantul, Minggu (08/01/23).\r\n\r\nPSS merombak jajaran pemain asing pada putaran kedua ini. Selain bomber asal Brasil, Mychell Chagas, PSS juga berpisah dengan gelandang asal Portugal, Ze Valente.\r\n\r\nMasa depan Tallyson Duarte dan Jihad Ayoub juga masih tanda tanya. Duarte absen sepanjang sistem bubble Liga 1 karena mengalami cedera.\r\n\r\nSementara Jihad Ayoub masih tampil saat menghadapi Persija. Pemain berbadan tinggi besar itu bermain penuh saat PSS kalah 0-2 pada laga tunda pekan ke-17 Liga 1.\r\n\r\nMenariknya, dalam laga itu ada sosok spesial di tribun barat. Yevhen yang pernah berjaya bersama PSS pada Liga 1 2019 sudah duduk manis menyaksikan laga ini bersama Irkham Zahrul Milla dkk.\r\n\r\nBaca Juga Liga 1: Seto Ungkap 2 Penyebab PSS Sleman Kalah dari Persija Jakarta\r\nADVERTISEMENT\r\n\r\n\r\nKehadiran Yevhen pun menjadi sinyal kuat bahwa mantan pilar Persipura Jayapura ini akan bergabung lagi. Pada Liga 1 2019 lalu, Yevhen mencatatkan 16 gol dari 33 penampilan.\r\n\r\nSinyal bertambah kencang ketika Yevhen bersalaman dengan seluruh pemain PSS saat hendak naik bus seusai laga. Yevhen sendiri datang ke stadion dengan mobil terpisah bersama staf PSS.\r\n\r\nBaca Juga Taklukkan PSS Sleman di Laga Tunda Liga 1, Pelatih Persija: Awal Indah di Tahun 2023!\r\nTerkait keberadaan pemain baru, pelatih PSS, Seto Nurdiyantoro, belum mau bersuara. Ia baru akan memberi keterangan ketika manajemen PSS sudah meresmikan secara langsung ke publik.\r\n\r\n\r\n\"(Pemain baru) masih dibungkus. Kita tunggu dulu dari manajemen,\" kata Seto usai laga melawan Persija, Minggu (08/01/23) petang.\r\n\r\nBaca selengkapnya: https://www.indosport.com/sepakbola/20230109/pengganti-mychell-chagas-sudah-kawal-pss-sleman-di-bantul-seto-bicara-proses-adaptasi', 'pengganti-mychell-chagas-sudah-kawal-pss-sleman-di-bantul,-seto-bicara-proses-adaptasi-fb530b4', 'http://127.0.0.1:8000/storage/news_image/000181100_1612094311-Timnas_Indonesia_-_Asnawi_Mangkualam__Egy_Maulana_Vikri__Elkan_Baggott_1.jpg', '000181100_1612094311-Timnas_Indonesia_-_Asnawi_Mangkualam__Egy_Maulana_Vikri__Elkan_Baggott_1.jpg', 'storage/news_image', 1673251749179, NULL, 'Paid', 7, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_topics`
--

CREATE TABLE `sub_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_topic_title` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_topic_slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_at` bigint(20) UNSIGNED NOT NULL,
  `updated_at` bigint(20) UNSIGNED DEFAULT NULL,
  `topic_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sub_topics`
--

INSERT INTO `sub_topics` (`id`, `sub_topic_title`, `sub_topic_slug`, `added_at`, `updated_at`, `topic_id`) VALUES
(2, 'Basket', 'basket', 1672896519610, 0, 1),
(3, 'MotoGp2023', 'motogp2023', 1672896563839, 0, 2),
(4, 'Formula 1', 'formula-1', 1672896582236, 0, 2),
(5, 'Partai Demokrat', 'partai-demokrat', 1672896601470, 0, 3),
(6, 'Partai Republik Indonesia', 'partai-republik-indonesia', 1672896617762, 1673157110856, 3),
(7, 'Sepak Bola', 'sepak-bola', 1673247101129, 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `topics`
--

CREATE TABLE `topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `topic_title` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic_slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_at` bigint(20) UNSIGNED NOT NULL,
  `updated_at` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `topics`
--

INSERT INTO `topics` (`id`, `topic_title`, `topic_slug`, `added_at`, `updated_at`) VALUES
(1, 'Olahraga', 'olahraga', 1672896340094, 0),
(2, 'Otomotif', 'otomotif', 1672896391756, 0),
(3, 'Politik', 'politik', 1672896409753, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance_account_number` bigint(20) DEFAULT NULL,
  `balance` double(12,2) UNSIGNED DEFAULT NULL,
  `photo_profile_link` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_profile_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_profile_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `author_description`, `role`, `balance_account_number`, `balance`, `photo_profile_link`, `photo_profile_name`, `photo_profile_path`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', 'adminssss', NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2023-01-04 21:52:17', 'gfs2dMUoww', '2023-01-04 21:52:18', '2023-01-04 21:52:18'),
(2, 'Baihaqiadnan', 'baiadnan123@gmail.com', '123456789', 'My name is M. Baihaqi Adnan. I was born in Kuala Lumpur. I have hobby in reading and writing.', 'author', 123456671222, 10000.00, 'http://127.0.0.1:8000/storage/photo_profile/hannah-busing-vGHMXnD5A0I-unsplash_1_1.jpg', 'hannah-busing-vGHMXnD5A0I-unsplash_1_1.jpg', 'storage/photo_profile', NULL, NULL, '2023-01-04 22:32:42', '2023-01-09 01:08:20'),
(3, 'Joshua Theo Kurniawan Siregar', 'joshuatheo18@gmail.com', 'helloworld', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-06 06:46:38', '2023-01-06 06:46:38'),
(4, 'Joshua Theo Kurniawan Sirgar', 'joshuatheo19@gmail.com', 'helloworld123', 'Hello my name is Joshua Theo Kurniawan Siregar. I\'m realy interested to join as an author in this website.', NULL, NULL, NULL, 'http://127.0.0.1:8000/storage/photo_profile/hannah-busing-vGHMXnD5A0I-unsplash_2_1_1.jpg', 'hannah-busing-vGHMXnD5A0I-unsplash_2_1_1.jpg', 'storage/photo_profile', NULL, NULL, '2023-01-06 17:52:29', '2023-01-07 20:50:22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin_approval`
--
ALTER TABLE `admin_approval`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_approval_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `admin_news_approval`
--
ALTER TABLE `admin_news_approval`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_news_approval_news_title_unique` (`news_title`),
  ADD KEY `admin_news_approval_sub_topic_id_foreign` (`sub_topic_id`),
  ADD KEY `admin_news_approval_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_user_id_foreign` (`user_id`),
  ADD KEY `history_news_id_foreign` (`news_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_sub_topic_id_foreign` (`sub_topic_id`),
  ADD KEY `news_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_topics_sub_topic_title_unique` (`sub_topic_title`),
  ADD KEY `sub_topics_topic_id_foreign` (`topic_id`);

--
-- Indeks untuk tabel `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `topics_topic_title_unique` (`topic_title`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_balance_account_numer_unique` (`balance_account_number`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin_approval`
--
ALTER TABLE `admin_approval`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `admin_news_approval`
--
ALTER TABLE `admin_news_approval`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `history`
--
ALTER TABLE `history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sub_topics`
--
ALTER TABLE `sub_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `topics`
--
ALTER TABLE `topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin_approval`
--
ALTER TABLE `admin_approval`
  ADD CONSTRAINT `admin_approval_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `admin_news_approval`
--
ALTER TABLE `admin_news_approval`
  ADD CONSTRAINT `admin_news_approval_sub_topic_id_foreign` FOREIGN KEY (`sub_topic_id`) REFERENCES `sub_topics` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_news_approval_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_sub_topic_id_foreign` FOREIGN KEY (`sub_topic_id`) REFERENCES `sub_topics` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD CONSTRAINT `sub_topics_topic_id_foreign` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
