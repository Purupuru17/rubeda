-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 27 Okt 2023 pada 11.03
-- Versi server: 10.6.15-MariaDB-cll-lve
-- Versi PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1076483_rubeda`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `fk_like`
--

CREATE TABLE `fk_like` (
  `video_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `status_like` enum('0','1') DEFAULT NULL,
  `create_like` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `fk_like`
--

INSERT INTO `fk_like` (`video_id`, `user_id`, `status_like`, `create_like`) VALUES
('fb5b15e0-fba5-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '1', '2023-05-29 09:11:24'),
('9f72101a-fbb1-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '1', '2023-05-30 14:23:29'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '1', '2023-07-22 10:43:54'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '830ef020-c5ca-46ef-8408-8c3af482c1d7', '1', '2023-09-17 19:24:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fk_riwayat`
--

CREATE TABLE `fk_riwayat` (
  `video_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `create_riwayat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `fk_riwayat`
--

INSERT INTO `fk_riwayat` (`video_id`, `user_id`, `create_riwayat`) VALUES
('5098c246-fba4-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-05-29 08:36:58'),
('fb5b15e0-fba5-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-05-29 08:37:34'),
('9f72101a-fbb1-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-05-29 11:11:53'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-05-30 16:21:45'),
('9f72101a-fbb1-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-05-30 16:23:20'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-06-01 21:30:24'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-06-18 09:55:32'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-07-22 12:42:45'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-07-31 11:53:22'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '830ef020-c5ca-46ef-8408-8c3af482c1d7', '2023-09-17 21:24:47'),
('fb5b15e0-fba5-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-10-03 12:35:18'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '830ef020-c5ca-46ef-8408-8c3af482c1d7', '2023-10-22 06:22:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fk_subscribe`
--

CREATE TABLE `fk_subscribe` (
  `creator_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `create_subscribe` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `fk_subscribe`
--

INSERT INTO `fk_subscribe` (`creator_id`, `user_id`, `create_subscribe`) VALUES
('ad603954-660a-4849-a6af-7dbd6289f621', '913e703a-151d-11ed-9585-d4d2528b454d', '2023-07-27 12:07:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_chat`
--

CREATE TABLE `m_chat` (
  `id_chat` char(36) NOT NULL,
  `room_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `status_chat` enum('0','1','2') DEFAULT NULL,
  `isi_chat` text DEFAULT NULL,
  `file_chat` varchar(100) DEFAULT NULL,
  `create_chat` datetime DEFAULT current_timestamp(),
  `read_chat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `m_chat`
--

INSERT INTO `m_chat` (`id_chat`, `room_id`, `user_id`, `status_chat`, `isi_chat`, `file_chat`, `create_chat`, `read_chat`) VALUES
('eefe792e-61a1-11ee-96ff-813eb3c5c486', '0b8ba622-32e0-45d1-9d7e-db39932300fc', '913e703a-151d-11ed-9585-d4d2528b454d', '1', 'Hai apa kabar ?', NULL, '2023-10-03 13:04:21', '2023-10-22 06:21:26'),
('43c23250-61a2-11ee-96ff-813eb3c5c486', '0eb952cd-21cb-4b01-b935-b375da37bf2b', '913e703a-151d-11ed-9585-d4d2528b454d', '0', 'piu', NULL, '2023-10-03 13:06:44', NULL),
('b1723bc8-7057-11ee-bff4-ad65f4981cc1', '0b8ba622-32e0-45d1-9d7e-db39932300fc', '913e703a-151d-11ed-9585-d4d2528b454d', '1', 'jjjj', NULL, '2023-10-22 06:20:44', '2023-10-22 06:21:26'),
('ce78b628-7057-11ee-bff4-ad65f4981cc1', '0b8ba622-32e0-45d1-9d7e-db39932300fc', '830ef020-c5ca-46ef-8408-8c3af482c1d7', '1', 'bagaimana?', NULL, '2023-10-22 06:21:32', '2023-10-26 12:59:58'),
('36ccb3b5-73b4-11ee-bc00-5958b06b05d9', '0b8ba622-32e0-45d1-9d7e-db39932300fc', '913e703a-151d-11ed-9585-d4d2528b454d', '0', 'bvhhv', NULL, '2023-10-26 13:00:34', NULL),
('889f3c89-73f4-11ee-bc00-5958b06b05d9', '0b8ba622-32e0-45d1-9d7e-db39932300fc', '913e703a-151d-11ed-9585-d4d2528b454d', '0', '', 'app/upload/chat/395321169_866005695251644_526642484510674249_njpeg.jpeg', '2023-10-26 20:40:59', NULL),
('9b85482b-73f4-11ee-bc00-5958b06b05d9', '0b8ba622-32e0-45d1-9d7e-db39932300fc', '913e703a-151d-11ed-9585-d4d2528b454d', '0', '', 'app/upload/chat/ijin-firman-banppdf.pdf', '2023-10-26 20:41:31', NULL),
('e3ab42b7-73f4-11ee-bc00-5958b06b05d9', '0b8ba622-32e0-45d1-9d7e-db39932300fc', '913e703a-151d-11ed-9585-d4d2528b454d', '0', 'filenya sudah ya', NULL, '2023-10-26 20:43:32', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_creator`
--

CREATE TABLE `m_creator` (
  `id_creator` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `nama_creator` varchar(100) DEFAULT NULL,
  `status_creator` enum('0','1','2','3') DEFAULT NULL,
  `slug_creator` varchar(50) DEFAULT NULL,
  `usia_creator` char(5) DEFAULT NULL,
  `telepon_creator` char(15) DEFAULT NULL,
  `kerja_creator` varchar(50) DEFAULT NULL,
  `lokasi_creator` varchar(50) DEFAULT NULL,
  `img_creator` varchar(100) DEFAULT NULL,
  `create_creator` datetime DEFAULT current_timestamp(),
  `update_creator` datetime DEFAULT NULL,
  `log_creator` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `m_creator`
--

INSERT INTO `m_creator` (`id_creator`, `user_id`, `nama_creator`, `status_creator`, `slug_creator`, `usia_creator`, `telepon_creator`, `kerja_creator`, `lokasi_creator`, `img_creator`, `create_creator`, `update_creator`, `log_creator`) VALUES
('75d0ff5f-a125-4159-820c-05b7904a3142', '830ef020-c5ca-46ef-8408-8c3af482c1d7', 'Filzha Muzita', '1', 'filzha-muzita', '23', '082187814617', 'PELAJAR', 'MAGATARUM', NULL, '2023-09-16 11:52:42', '2023-09-17 21:13:22', 'Administrator memvalidasi pendaftaran akun'),
('884fa0d3-2fb2-4cf1-896d-48f076fd755a', '2d59e0d6-8e5f-4a5b-92ad-28cfc6ba30ab', 'Filzha Muzita', '0', 'filzha-muzita', '27', '082187814616', 'WIRASWASTA', 'MALAMOJA', NULL, '2023-07-31 13:28:36', NULL, NULL),
('913e703a-151d-11ed-9585-d4d2528b454e', '913e703a-151d-11ed-9585-d4d2528b454d', 'Galih Bayu', '1', 'galih-bayu-unimuda', '27', NULL, NULL, NULL, NULL, '2023-05-23 12:16:27', NULL, NULL),
('ad603954-660a-4849-a6af-7dbd6289f621', '3161aded-d766-4fb1-bb32-ab8240435dff', 'Firman', '1', 'firman', '25', '082187814616', 'KARYAWAN', 'MAJARAN', NULL, '2023-05-26 20:09:28', NULL, NULL),
('e09fae4e-6e33-408f-8d02-388514f50657', '5741a8d9-634b-465b-82f7-f7a632226a55', 'Filzha Muzita', '0', 'filzha-muzita', '25', '082187814616', 'KARYAWAN', 'MALAMOJA', NULL, '2023-07-31 12:09:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_komen`
--

CREATE TABLE `m_komen` (
  `id_komen` char(36) NOT NULL,
  `video_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `isi_komen` text DEFAULT NULL,
  `create_komen` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_room`
--

CREATE TABLE `m_room` (
  `id_room` char(36) NOT NULL,
  `send_by` char(36) NOT NULL,
  `send_to` char(36) NOT NULL,
  `status_room` enum('0','1','2') DEFAULT NULL,
  `create_room` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `m_room`
--

INSERT INTO `m_room` (`id_room`, `send_by`, `send_to`, `status_room`, `create_room`) VALUES
('0b8ba622-32e0-45d1-9d7e-db39932300fc', '913e703a-151d-11ed-9585-d4d2528b454d', '830ef020-c5ca-46ef-8408-8c3af482c1d7', '1', '2023-10-03 13:04:12'),
('0eb952cd-21cb-4b01-b935-b375da37bf2b', '913e703a-151d-11ed-9585-d4d2528b454d', '2d59e0d6-8e5f-4a5b-92ad-28cfc6ba30ab', '1', '2023-10-03 13:06:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_topik`
--

CREATE TABLE `m_topik` (
  `id_topik` int(11) NOT NULL,
  `parent_topik` int(11) DEFAULT NULL,
  `judul_topik` varchar(50) DEFAULT NULL,
  `img_topik` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `m_topik`
--

INSERT INTO `m_topik` (`id_topik`, `parent_topik`, `judul_topik`, `img_topik`) VALUES
(1, 0, 'Film Action', 'app/upload/topik/action.jpg'),
(2, 0, 'Cerita Anak', 'app/upload/topik/anak.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_video`
--

CREATE TABLE `m_video` (
  `id_video` char(36) NOT NULL,
  `creator_id` char(36) NOT NULL,
  `topik_id` int(11) NOT NULL,
  `judul_video` varchar(100) DEFAULT NULL,
  `status_video` enum('0','1','2') DEFAULT NULL,
  `privasi_video` enum('0','1','2') DEFAULT NULL,
  `usia_video` enum('0','1','2','3') DEFAULT NULL,
  `slug_video` varchar(50) DEFAULT NULL,
  `file_video` varchar(100) DEFAULT NULL,
  `img_video` varchar(100) DEFAULT NULL,
  `tag_video` varchar(50) DEFAULT NULL,
  `deskripsi_video` text DEFAULT NULL,
  `create_video` datetime DEFAULT current_timestamp(),
  `update_video` datetime DEFAULT NULL,
  `log_video` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `m_video`
--

INSERT INTO `m_video` (`id_video`, `creator_id`, `topik_id`, `judul_video`, `status_video`, `privasi_video`, `usia_video`, `slug_video`, `file_video`, `img_video`, `tag_video`, `deskripsi_video`, `create_video`, `update_video`, `log_video`) VALUES
('1636eb24-fc22-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454e', 0, 'Ujicoba', '0', '2', '0', 'ujicoba', 'app/upload/video/ujicoba.mp4', 'app/upload/thumb/ujicoba-4128-2322.jpg', '', 'Heheh ehehhee ehehhehe ehehhehr rhdheb', '2023-05-27 09:04:42', NULL, 'Administrator menambahkan video baru'),
('5098c246-fba4-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454e', 1, 'Shout Baby - Ryokuoushoku Shakai My Hero Academia Ending', '1', '1', '0', 'shout-baby-ryokuoushoku-shakai-my-hero-academia-en', 'app/upload/video/shout-baby-ryokuoushoku-shakai-my-hero-academia-ending.mp4', 'app/upload/thumb/shout-baby-ryokuoushoku-shakai-my-hero-academia-ending-480-360.jpg', 'Anime, Jpop, BNHA', '?TV????????????????4?????????????????\r\n\r\nListen & DL : https://erj.lnk.to/xGfSOAY\r\n\r\n????? New Single?Shout Baby?\r\n2020.02.19 On Sale\r\nhttp://www.ryokushaka.com/discography/\r\n \r\nTwitter : https://twitter.com/ryokushaka \r\nInstagram : https://www.instagram.com/ryokushaka_... \r\nLINE ID : https://line.me/R/ti/p/@ryokushaka\r\n\r\nVideo Staff \r\nDirector / Chinematographer / Editor : Kyotaro Hayashi(DRAWING AND MANUAL)\r\nAssistant Director / Cinematographer : Masaru Ito, Yuka Yamaguchi(DRAWING AND MANUAL)\r\nLighting Director : Naoto Tania\r\nChief Light Assistant : Ryosuke Abe \r\nLight Assistant : Bomata Deo Gracia, Hideetsu Ota, Toshihiko Otsuka\r\nProduction Designer : Mayumi Okamoto\r\nAssistant Production Designer : Hatsune Nakagomi\r\nProp builder  : Kiyohito Wataoka(TUG CREW)\r\nStylist : Masaaki Mitsuzono\r\nHair : Hiroshi Takatoku\r\nHair Assistant : Manami Iwai\r\nMake Up : Asumi Washizuka\r\nPrint, Special Effect & Animation : Kakeru Mizui ( DRAWING AND MANUAL), Kyoko Nitta, Momo Nakamura, Mai Muto, Rin Kuroda(Papers)\r\nVFX : Yoshifumi Hashimoto\r\nProduction Manager : Kaoru Miyachi , Tatsuya Sasaki\r\nProduction Assistant : Kozo Kobayashi\r\nProducer : Satoshi Miyata (Flip-book Inc.)\r\n\r\n???????2020 / Official HP?????\r\nhttps://www.ryokushaka.com/news/archi...\r\n\r\n5/16????? CLUB QUATTRO\r\n5/23????????Rensa\r\n5/29?????DRUM LOGOS\r\n5/31????????MONSTER\r\n6/6?????????????????\r\n6/7?????????CASINO DRIVE\r\n6/12?????LOTS\r\n6/13???????KT Zepp YOKOHAMA\r\n6/20??????Zepp Nagoya\r\n6/21??????Zepp Namba', '2023-05-26 18:04:09', NULL, 'Administrator menambahkan video baru'),
('9f72101a-fbb1-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454e', 2, 'Yui Its All To Much', '1', '1', '1', 'yui-its-all-to-much', 'app/upload/video/yui-its-all-to-much.mp4', 'app/upload/thumb/yui-its-all-to-much-1259-486.png', 'YUI, anime, jpop, bleach', 'The Horde webmail application has been removed in cPanel & WHM version 108. All Horde email, contacts, and calendars will be automatically migrated to Roundcube. For more information, read our cPanel Deprecation Plan documentation.', '2023-05-26 19:39:42', NULL, 'Administrator menambahkan video baru'),
('fb5b15e0-fba5-11ed-9842-2cea7f420f83', '913e703a-151d-11ed-9585-d4d2528b454e', 1, 'Suzanna', '1', '1', '1', 'suzanna', 'app/upload/video/suzanna.mp4', 'app/upload/thumb/suzanna-1080-2340.jpg', 'Horor, Sate', 'Hsjs sjaksk wjsksk sjakakqsb sjsjakal\r\nJdjsks hskskak', '2023-05-26 18:16:22', NULL, 'Administrator menambahkan video baru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_aksi`
--

CREATE TABLE `yk_aksi` (
  `id_aksi` int(11) NOT NULL,
  `nama_aksi` varchar(10) DEFAULT NULL,
  `fungsi` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_aksi`
--

INSERT INTO `yk_aksi` (`id_aksi`, `nama_aksi`, `fungsi`) VALUES
(1, 'Lihat', 'index'),
(2, 'Tambah', 'add'),
(3, 'Ubah', 'edit'),
(4, 'Hapus', 'delete'),
(5, 'Detail', 'detail'),
(6, 'Cetak', 'cetak'),
(7, 'Export', 'export');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_aplikasi`
--

CREATE TABLE `yk_aplikasi` (
  `id_aplikasi` int(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `deskripsi` varchar(250) DEFAULT NULL,
  `cipta` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `tema` varchar(255) DEFAULT NULL,
  `update_aplikasi` datetime DEFAULT NULL,
  `session_aplikasi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_aplikasi`
--

INSERT INTO `yk_aplikasi` (`id_aplikasi`, `judul`, `deskripsi`, `cipta`, `logo`, `tema`, `update_aplikasi`, `session_aplikasi`) VALUES
(1, 'RUBEDA', 'Ruang Belajar Daerah 3T', 'Firman-UNIMUDA Sorong', 'app/img/logo.png', 'skin-1,2,0,0,0,0,0,0,0,0,#226cb4,#2c3e50', '2023-10-03 20:46:20', 'Administrator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_group`
--

CREATE TABLE `yk_group` (
  `id_group` int(11) NOT NULL,
  `nama_group` varchar(50) DEFAULT NULL,
  `level` enum('1','2') DEFAULT NULL,
  `keterangan_group` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_group`
--

INSERT INTO `yk_group` (`id_group`, `nama_group`, `level`, `keterangan_group`) VALUES
(1, 'Administrator', '1', 'Super Admin Sistem'),
(2, 'Operator', '2', 'Operator Aplikasi'),
(4, 'Creator', '2', 'Creator Channel');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_group_menu_aksi`
--

CREATE TABLE `yk_group_menu_aksi` (
  `id_menu_aksi` char(36) NOT NULL,
  `id_group` int(11) DEFAULT NULL,
  `segmen` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_group_menu_aksi`
--

INSERT INTO `yk_group_menu_aksi` (`id_menu_aksi`, `id_group`, `segmen`) VALUES
('a718112f-151a-11ed-9585-d4d2528b454d', 2, 'konten/artikel/index'),
('a71812b8-151a-11ed-9585-d4d2528b454d', 2, 'konten/artikel/add'),
('a71815af-151a-11ed-9585-d4d2528b454d', 2, 'konten/artikel/edit'),
('a7181727-151a-11ed-9585-d4d2528b454d', 2, 'konten/artikel/delete'),
('a71643f8-151a-11ed-9585-d4d2528b454d', 2, 'konten/file/index'),
('a7164572-151a-11ed-9585-d4d2528b454d', 2, 'konten/file/add'),
('a71646f0-151a-11ed-9585-d4d2528b454d', 2, 'konten/file/edit'),
('a71649f6-151a-11ed-9585-d4d2528b454d', 2, 'konten/file/delete'),
('a7169202-151a-11ed-9585-d4d2528b454d', 2, 'konten/galeri/index'),
('a71693b1-151a-11ed-9585-d4d2528b454d', 2, 'konten/galeri/add'),
('a7169566-151a-11ed-9585-d4d2528b454d', 2, 'konten/galeri/edit'),
('a71696da-151a-11ed-9585-d4d2528b454d', 2, 'konten/galeri/delete'),
('a718024a-151a-11ed-9585-d4d2528b454d', 2, 'konten/halaman/index'),
('a71803c5-151a-11ed-9585-d4d2528b454d', 2, 'konten/halaman/add'),
('a71806b6-151a-11ed-9585-d4d2528b454d', 2, 'konten/halaman/edit'),
('a718082f-151a-11ed-9585-d4d2528b454d', 2, 'konten/halaman/delete'),
('a7180a76-151a-11ed-9585-d4d2528b454d', 2, 'konten/jenis/index'),
('a7180c3a-151a-11ed-9585-d4d2528b454d', 2, 'konten/jenis/add'),
('a7180dc8-151a-11ed-9585-d4d2528b454d', 2, 'konten/jenis/edit'),
('a7180f5d-151a-11ed-9585-d4d2528b454d', 2, 'konten/jenis/delete'),
('a7169848-151a-11ed-9585-d4d2528b454d', 2, 'konten/kutipan/index'),
('a71699ad-151a-11ed-9585-d4d2528b454d', 2, 'konten/kutipan/add'),
('a7169b0c-151a-11ed-9585-d4d2528b454d', 2, 'konten/kutipan/edit'),
('a7169c72-151a-11ed-9585-d4d2528b454d', 2, 'konten/kutipan/delete'),
('a716897d-151a-11ed-9585-d4d2528b454d', 2, 'konten/navigasi/index'),
('a7168afd-151a-11ed-9585-d4d2528b454d', 2, 'konten/navigasi/add'),
('a7168c69-151a-11ed-9585-d4d2528b454d', 2, 'konten/navigasi/edit'),
('a7168dd2-151a-11ed-9585-d4d2528b454d', 2, 'konten/navigasi/delete'),
('a7164b75-151a-11ed-9585-d4d2528b454d', 2, 'master/all/index'),
('a716b89e-151a-11ed-9585-d4d2528b454d', 2, 'master/kelas/index'),
('a716bbac-151a-11ed-9585-d4d2528b454d', 2, 'master/kelas/add'),
('a7170a74-151a-11ed-9585-d4d2528b454d', 2, 'master/kelas/detail'),
('a71658a6-151a-11ed-9585-d4d2528b454d', 2, 'master/chat/index'),
('a716b31d-151a-11ed-9585-d4d2528b454d', 2, 'master/topik/index'),
('a7175ada-151a-11ed-9585-d4d2528b454d', 2, 'sistem/akun/index'),
('a7170f02-151a-11ed-9585-d4d2528b454d', 2, 'wisuda/all/index'),
('a7171084-151a-11ed-9585-d4d2528b454d', 2, 'wisuda/calon/index'),
('a71717b9-151a-11ed-9585-d4d2528b454d', 2, 'wisuda/calon/edit'),
('a718112f-151a-11ed-9585-d4d2528b454d', 1, 'konten/artikel/index'),
('a71812b8-151a-11ed-9585-d4d2528b454d', 1, 'konten/artikel/add'),
('a71815af-151a-11ed-9585-d4d2528b454d', 1, 'konten/artikel/edit'),
('a7181727-151a-11ed-9585-d4d2528b454d', 1, 'konten/artikel/delete'),
('a71643f8-151a-11ed-9585-d4d2528b454d', 1, 'konten/file/index'),
('a7164572-151a-11ed-9585-d4d2528b454d', 1, 'konten/file/add'),
('a71646f0-151a-11ed-9585-d4d2528b454d', 1, 'konten/file/edit'),
('a71649f6-151a-11ed-9585-d4d2528b454d', 1, 'konten/file/delete'),
('a718024a-151a-11ed-9585-d4d2528b454d', 1, 'konten/halaman/index'),
('a71803c5-151a-11ed-9585-d4d2528b454d', 1, 'konten/halaman/add'),
('a71806b6-151a-11ed-9585-d4d2528b454d', 1, 'konten/halaman/edit'),
('a718082f-151a-11ed-9585-d4d2528b454d', 1, 'konten/halaman/delete'),
('a7180a76-151a-11ed-9585-d4d2528b454d', 1, 'konten/jenis/index'),
('a7180c3a-151a-11ed-9585-d4d2528b454d', 1, 'konten/jenis/add'),
('a7180dc8-151a-11ed-9585-d4d2528b454d', 1, 'konten/jenis/edit'),
('a7180f5d-151a-11ed-9585-d4d2528b454d', 1, 'konten/jenis/delete'),
('a7173d28-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/aktivitas/index'),
('a7173e97-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/aktivitas/add'),
('a717402e-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/aktivitas/edit'),
('a7174288-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/aktivitas/delete'),
('a7175104-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/aktivitas/detail'),
('a71752d7-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/aktivitas/cetak'),
('a7175458-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/aktivitas/export'),
('a717f1af-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/jurnal/index'),
('a717f330-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/jurnal/add'),
('a717f63d-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/jurnal/edit'),
('a717f7be-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/jurnal/delete'),
('a717f936-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/jurnal/detail'),
('a717fac2-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/jurnal/cetak'),
('a717fc3a-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/jurnal/export'),
('a7173486-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/krs/index'),
('a7173651-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/krs/add'),
('a717381e-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/krs/edit'),
('a71739c7-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/krs/delete'),
('a71728cc-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/nilai/index'),
('a7172b2e-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/nilai/add'),
('a7172dfb-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/nilai/edit'),
('a7173276-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/nilai/detail'),
('f51de31a-a83d-11ed-9f8e-109836aef400', 1, 'kuliah/nilai/cetak'),
('f51e03b5-a83d-11ed-9f8e-109836aef400', 1, 'kuliah/nilai/export'),
('a717440d-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/skripsi/index'),
('a7174607-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/skripsi/add'),
('a71747ea-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/skripsi/edit'),
('a7174971-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/skripsi/delete'),
('a7174ae4-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/skripsi/detail'),
('a9beeb1c-d9a3-11ed-a6c1-109836aef400', 1, 'kuliah/skripsi/cetak'),
('a9bf08dc-d9a3-11ed-a6c1-109836aef400', 1, 'kuliah/skripsi/export'),
('a717e89c-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/khs/index'),
('a717ea44-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/khs/add'),
('a717ebc0-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/khs/edit'),
('a717ed3f-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/khs/detail'),
('a717eeb8-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/khs/cetak'),
('a717f033-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/khs/export'),
('205c78ee-4b9f-11ed-82ca-525400802704', 1, 'mahasiswa/magang/index'),
('205c8302-4b9f-11ed-82ca-525400802704', 1, 'mahasiswa/magang/edit'),
('205c89f9-4b9f-11ed-82ca-525400802704', 1, 'mahasiswa/magang/detail'),
('205c9000-4b9f-11ed-82ca-525400802704', 1, 'mahasiswa/magang/cetak'),
('205c99d0-4b9f-11ed-82ca-525400802704', 1, 'mahasiswa/magang/export'),
('a7175e48-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/profil/index'),
('a717e0e0-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/profil/edit'),
('a717e33c-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/profil/detail'),
('a717e50f-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/profil/cetak'),
('a717e6a9-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/profil/export'),
('a7164b75-151a-11ed-9585-d4d2528b454d', 1, 'master/all/index'),
('a7167723-151a-11ed-9585-d4d2528b454d', 1, 'master/channel/index'),
('a7167894-151a-11ed-9585-d4d2528b454d', 1, 'master/channel/add'),
('a71679fd-151a-11ed-9585-d4d2528b454d', 1, 'master/channel/edit'),
('a7167b61-151a-11ed-9585-d4d2528b454d', 1, 'master/channel/delete'),
('6cdcb4a1-fcec-11ed-9842-2cea7f420f83', 1, 'master/channel/detail'),
('a71658a6-151a-11ed-9585-d4d2528b454d', 1, 'master/chat/index'),
('a7165d07-151a-11ed-9585-d4d2528b454d', 1, 'master/chat/add'),
('a7165fa2-151a-11ed-9585-d4d2528b454d', 1, 'master/chat/edit'),
('a7166354-151a-11ed-9585-d4d2528b454d', 1, 'master/chat/delete'),
('a716b31d-151a-11ed-9585-d4d2528b454d', 1, 'master/topik/index'),
('a716b4ca-151a-11ed-9585-d4d2528b454d', 1, 'master/topik/add'),
('a716b683-151a-11ed-9585-d4d2528b454d', 1, 'master/topik/edit'),
('a7174f46-151a-11ed-9585-d4d2528b454d', 1, 'master/topik/delete'),
('a716afe6-151a-11ed-9585-d4d2528b454d', 1, 'master/video/index'),
('a7166b6c-151a-11ed-9585-d4d2528b454d', 1, 'master/video/add'),
('a7166ce9-151a-11ed-9585-d4d2528b454d', 1, 'master/video/edit'),
('a7166e60-151a-11ed-9585-d4d2528b454d', 1, 'master/video/delete'),
('a716b1ae-151a-11ed-9585-d4d2528b454d', 1, 'master/video/detail'),
('d546f50d-4b9f-11ed-82ca-525400802704', 1, 'mengajar/pembimbing/index'),
('d546ff0b-4b9f-11ed-82ca-525400802704', 1, 'mengajar/pembimbing/add'),
('d547070a-4b9f-11ed-82ca-525400802704', 1, 'mengajar/pembimbing/edit'),
('d5471662-4b9f-11ed-82ca-525400802704', 1, 'mengajar/pembimbing/delete'),
('d5548993-4b9f-11ed-82ca-525400802704', 1, 'mengajar/pembimbing/detail'),
('d554944a-4b9f-11ed-82ca-525400802704', 1, 'mengajar/pembimbing/cetak'),
('d5549f6d-4b9f-11ed-82ca-525400802704', 1, 'mengajar/pembimbing/export'),
('f6f6a821-4b9f-11ed-82ca-525400802704', 1, 'mengajar/penilaian/index'),
('f6f6b613-4b9f-11ed-82ca-525400802704', 1, 'mengajar/penilaian/edit'),
('f6f6be02-4b9f-11ed-82ca-525400802704', 1, 'mengajar/penilaian/detail'),
('f6f6c404-4b9f-11ed-82ca-525400802704', 1, 'mengajar/penilaian/cetak'),
('f6f6c8ef-4b9f-11ed-82ca-525400802704', 1, 'mengajar/penilaian/export'),
('b10f2f32-4b9f-11ed-82ca-525400802704', 1, 'mengajar/peserta/index'),
('b10f3923-4b9f-11ed-82ca-525400802704', 1, 'mengajar/peserta/add'),
('b10f43e5-4b9f-11ed-82ca-525400802704', 1, 'mengajar/peserta/edit'),
('b10f4ee8-4b9f-11ed-82ca-525400802704', 1, 'mengajar/peserta/delete'),
('b10f5503-4b9f-11ed-82ca-525400802704', 1, 'mengajar/peserta/detail'),
('b10f5c1b-4b9f-11ed-82ca-525400802704', 1, 'mengajar/peserta/cetak'),
('b10f6447-4b9f-11ed-82ca-525400802704', 1, 'mengajar/peserta/export'),
('a716715b-151a-11ed-9585-d4d2528b454d', 1, 'sistem/akses/index'),
('a7168f35-151a-11ed-9585-d4d2528b454d', 1, 'sistem/akses/add'),
('a7167e5b-151a-11ed-9585-d4d2528b454d', 1, 'sistem/akses/edit'),
('a716909e-151a-11ed-9585-d4d2528b454d', 1, 'sistem/akses/delete'),
('a7175ada-151a-11ed-9585-d4d2528b454d', 1, 'sistem/akun/index'),
('a7175c9a-151a-11ed-9585-d4d2528b454d', 1, 'sistem/akun/edit'),
('a7163441-151a-11ed-9585-d4d2528b454d', 1, 'sistem/all/index'),
('a7173b5b-151a-11ed-9585-d4d2528b454d', 1, 'sistem/aplikasi/index'),
('d96335fd-fb9f-11ed-b6da-109836aef400', 1, 'sistem/aplikasi/add'),
('a7174dce-151a-11ed-9585-d4d2528b454d', 1, 'sistem/aplikasi/edit'),
('d9636eb5-fb9f-11ed-b6da-109836aef400', 1, 'sistem/aplikasi/delete'),
('a7171248-151a-11ed-9585-d4d2528b454d', 1, 'sistem/group/index'),
('a717fdaf-151a-11ed-9585-d4d2528b454d', 1, 'sistem/group/add'),
('a717ff3f-151a-11ed-9585-d4d2528b454d', 1, 'sistem/group/edit'),
('a7180538-151a-11ed-9585-d4d2528b454d', 1, 'sistem/group/delete'),
('a7163a39-151a-11ed-9585-d4d2528b454d', 1, 'sistem/menu/index'),
('a7163c26-151a-11ed-9585-d4d2528b454d', 1, 'sistem/menu/add'),
('a7164871-151a-11ed-9585-d4d2528b454d', 1, 'sistem/menu/edit'),
('a716612e-151a-11ed-9585-d4d2528b454d', 1, 'sistem/menu/delete'),
('a7163dc8-151a-11ed-9585-d4d2528b454d', 1, 'sistem/notif/index'),
('a7163f5b-151a-11ed-9585-d4d2528b454d', 1, 'sistem/notif/add'),
('a71640e0-151a-11ed-9585-d4d2528b454d', 1, 'sistem/notif/delete'),
('a7171446-151a-11ed-9585-d4d2528b454d', 1, 'sistem/password/index'),
('a7172526-151a-11ed-9585-d4d2528b454d', 1, 'sistem/password/edit'),
('a7181433-151a-11ed-9585-d4d2528b454d', 1, 'sistem/user/index'),
('a7181899-151a-11ed-9585-d4d2528b454d', 1, 'sistem/user/add'),
('a7181a1a-151a-11ed-9585-d4d2528b454d', 1, 'sistem/user/edit'),
('a7181c05-151a-11ed-9585-d4d2528b454d', 1, 'sistem/user/delete'),
('a7164270-151a-11ed-9585-d4d2528b454d', 1, 'sistem/user/detail'),
('ac2c401b-2547-11ed-a44b-525400802704', 1, 'transaksi/beasiswa/index'),
('ac2c5e03-2547-11ed-a44b-525400802704', 1, 'transaksi/beasiswa/add'),
('ac2c6759-2547-11ed-a44b-525400802704', 1, 'transaksi/beasiswa/edit'),
('ac2c6eba-2547-11ed-a44b-525400802704', 1, 'transaksi/beasiswa/delete'),
('ac2c7580-2547-11ed-a44b-525400802704', 1, 'transaksi/beasiswa/detail'),
('ac2c7b9f-2547-11ed-a44b-525400802704', 1, 'transaksi/beasiswa/cetak'),
('ac2c8070-2547-11ed-a44b-525400802704', 1, 'transaksi/beasiswa/export'),
('a7164e14-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/biaya/index'),
('a716a6ec-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/biaya/add'),
('a7164f95-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/biaya/edit'),
('a716a866-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/biaya/delete'),
('a7165111-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/biaya/detail'),
('a716528d-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/biaya/cetak'),
('a7165606-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/biaya/export'),
('a716823c-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/rekap/index'),
('a716841c-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/rekap/add'),
('a71685a3-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/rekap/edit'),
('a716874f-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/rekap/delete'),
('a716aaf3-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/rekap/detail'),
('a716aca0-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/rekap/cetak'),
('a716ae73-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/rekap/export'),
('a7171084-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/calon/index'),
('a7171647-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/calon/add'),
('a71717b9-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/calon/edit'),
('a7171928-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/calon/delete'),
('a7171aa4-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/calon/detail'),
('a7171c15-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/calon/cetak'),
('a7171d82-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/calon/export'),
('a7171f3e-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/matkul/index'),
('a71720d8-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/matkul/add'),
('a7172246-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/matkul/edit'),
('a71723b1-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/matkul/delete'),
('a7164b75-151a-11ed-9585-d4d2528b454d', 4, 'master/all/index'),
('a7167723-151a-11ed-9585-d4d2528b454d', 4, 'master/channel/index'),
('a71679fd-151a-11ed-9585-d4d2528b454d', 4, 'master/channel/edit'),
('a71658a6-151a-11ed-9585-d4d2528b454d', 4, 'master/chat/index'),
('a7165d07-151a-11ed-9585-d4d2528b454d', 4, 'master/chat/add'),
('a716afe6-151a-11ed-9585-d4d2528b454d', 4, 'master/video/index'),
('a7166ce9-151a-11ed-9585-d4d2528b454d', 4, 'master/video/edit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_group_role`
--

CREATE TABLE `yk_group_role` (
  `group_id` int(11) NOT NULL,
  `user_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_group_role`
--

INSERT INTO `yk_group_role` (`group_id`, `user_id`) VALUES
(2, '913e703a-151d-11ed-9585-d4d2528b454d'),
(1, '913e703a-151d-11ed-9585-d4d2528b454d'),
(4, '913e703a-151d-11ed-9585-d4d2528b454d');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_menu`
--

CREATE TABLE `yk_menu` (
  `id_menu` int(11) NOT NULL,
  `parent_menu` int(11) DEFAULT NULL,
  `nama_menu` varchar(150) DEFAULT NULL,
  `module_menu` varchar(150) DEFAULT NULL,
  `status_menu` enum('1','0') DEFAULT NULL,
  `icon_menu` varchar(30) DEFAULT 'fa fa-list',
  `order_menu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_menu`
--

INSERT INTO `yk_menu` (`id_menu`, `parent_menu`, `nama_menu`, `module_menu`, `status_menu`, `icon_menu`, `order_menu`) VALUES
(1, 0, 'Sistem', 'sistem/all', '1', 'fa fa-cogs', 3),
(2, 1, 'Group', 'sistem/group', '1', 'fa fa-list', 2),
(3, 1, 'User', 'sistem/user', '1', 'fa fa-list', 3),
(4, 1, 'Menu', 'sistem/menu', '1', 'fa fa-list', 4),
(5, 1, 'Hak Akses', 'sistem/akses', '1', 'fa fa-list', 5),
(7, 1, 'Ubah Password', 'sistem/password', '0', 'fa fa-list', 6),
(8, 1, 'Aplikasi', 'sistem/aplikasi', '1', 'fa fa-list', 7),
(9, 1, 'Akun Saya', 'sistem/akun', '0', 'fa fa-list', 8),
(15, 0, 'Konten', 'konten/all', '1', 'fa  fa-inbox', 1),
(16, 15, 'Halaman', 'konten/halaman', '1', 'fa fa-book', 2),
(17, 15, 'Jenis Artikel', 'konten/jenis', '1', 'fa fa-bookmark', 3),
(18, 15, 'Artikel', 'konten/artikel', '1', 'fa fa-newspaper-o', 4),
(28, 1, 'Notifikasi', 'sistem/notif', '1', 'fa fa-bell', 9),
(29, 15, 'File Server', 'konten/file', '1', 'fa fa-file', 5),
(30, 0, 'Master', 'master/all', '1', 'fa fa-pencil-square-o', 1),
(31, 36, 'Pembiayaan', 'transaksi/biaya', '1', 'fa fa-credit-card', 1),
(32, 30, 'Obrolan', 'master/chat', '1', 'fa fa-comments', 4),
(33, 30, 'Video', 'master/video', '1', 'fa fa-video-camera', 3),
(34, 30, 'Sumber Dana', 'master/dana', '1', 'fa fa-file', 6),
(35, 30, 'Channel', 'master/channel', '1', 'fa fa-users', 2),
(36, 0, 'Transaksi', 'transaksi/all', '1', 'fa fa-calendar', 4),
(37, 0, 'UNIMUDA', 'mahasiswa/all', '1', 'fa fa-graduation-cap', 3),
(38, 36, 'Rekap', 'transaksi/rekap', '1', 'fa fa-undo', 2),
(39, 15, 'Navigasi', 'konten/navigasi', '1', 'fa fa-list', 1),
(40, 15, 'Galeri', 'konten/galeri', '1', 'fa fa-image', 6),
(41, 15, 'Kutipan', 'konten/kutipan', '1', 'fa fa-book', 8),
(42, 30, 'Rincian', 'master/rincian', '1', 'fa fa-check-square-o', 7),
(43, 30, 'Topik', 'master/topik', '1', 'fa fa-tags', 1),
(44, 30, 'Kelas Kuliah', 'master/kelas', '1', 'fa fa-list-alt', 5),
(45, 0, 'Wisuda', 'wisuda/all', '1', 'fa fa-graduation-cap', 5),
(46, 45, 'Calon', 'wisuda/calon', '1', 'fa fa-users', 1),
(47, 45, 'Mata Kuliah', 'wisuda/matkul', '1', 'fa fa-list-alt', 2),
(48, 0, 'Akademik', 'kuliah/all', '1', 'fa fa-check-square-o', 2),
(49, 48, 'Perkuliahan', 'kuliah/nilai', '1', 'fa fa-gavel', 2),
(50, 48, 'KRS', 'kuliah/krs', '1', 'fa fa-flag', 1),
(51, 48, 'Aktivitas Kuliah', 'kuliah/aktivitas', '1', 'fa fa-exchange', 3),
(52, 48, 'Tugas Akhir', 'kuliah/skripsi', '1', 'fa fa-book', 5),
(53, 37, 'Profil', 'mahasiswa/profil', '1', 'fa fa-pencil', 1),
(54, 37, 'KRS & KHS', 'mahasiswa/khs', '1', 'fa fa-paste', 2),
(55, 48, 'Jurnal', 'kuliah/jurnal', '1', 'fa fa-book', 4),
(56, 36, 'Beasiswa', 'transaksi/beasiswa', '1', 'fa fa-users', 3),
(57, 30, 'Tempat', 'master/tempat', '1', 'fa fa-building-o', 8),
(58, 37, 'KPM', 'mahasiswa/magang', '1', 'fa fa-users', 4),
(59, 0, 'KPM LP3M', 'mengajar/all', '1', 'fa fa-external-link', 6),
(60, 59, 'Peserta', 'mengajar/peserta', '1', 'fa fa-users', 1),
(61, 59, 'Pembimbing', 'mengajar/pembimbing', '1', 'fa fa-exchange', 2),
(62, 59, 'Penilaian', 'mengajar/penilaian', '1', 'fa fa-paste', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_menu_aksi`
--

CREATE TABLE `yk_menu_aksi` (
  `id_menu_aksi` char(36) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `id_aksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_menu_aksi`
--

INSERT INTO `yk_menu_aksi` (`id_menu_aksi`, `id_menu`, `id_aksi`) VALUES
('205c78ee-4b9f-11ed-82ca-525400802704', 58, 1),
('205c8302-4b9f-11ed-82ca-525400802704', 58, 3),
('205c89f9-4b9f-11ed-82ca-525400802704', 58, 5),
('205c9000-4b9f-11ed-82ca-525400802704', 58, 6),
('205c99d0-4b9f-11ed-82ca-525400802704', 58, 7),
('6cdcb4a1-fcec-11ed-9842-2cea7f420f83', 35, 5),
('8a51a3e5-4b9f-11ed-82ca-525400802704', 59, 1),
('a7163441-151a-11ed-9585-d4d2528b454d', 1, 1),
('a7163a39-151a-11ed-9585-d4d2528b454d', 4, 1),
('a7163c26-151a-11ed-9585-d4d2528b454d', 4, 2),
('a7163dc8-151a-11ed-9585-d4d2528b454d', 28, 1),
('a7163f5b-151a-11ed-9585-d4d2528b454d', 28, 2),
('a71640e0-151a-11ed-9585-d4d2528b454d', 28, 4),
('a7164270-151a-11ed-9585-d4d2528b454d', 3, 5),
('a71643f8-151a-11ed-9585-d4d2528b454d', 29, 1),
('a7164572-151a-11ed-9585-d4d2528b454d', 29, 2),
('a71646f0-151a-11ed-9585-d4d2528b454d', 29, 3),
('a7164871-151a-11ed-9585-d4d2528b454d', 4, 3),
('a71649f6-151a-11ed-9585-d4d2528b454d', 29, 4),
('a7164b75-151a-11ed-9585-d4d2528b454d', 30, 1),
('a7164e14-151a-11ed-9585-d4d2528b454d', 31, 1),
('a7164f95-151a-11ed-9585-d4d2528b454d', 31, 3),
('a7165111-151a-11ed-9585-d4d2528b454d', 31, 5),
('a716528d-151a-11ed-9585-d4d2528b454d', 31, 6),
('a7165606-151a-11ed-9585-d4d2528b454d', 31, 7),
('a71658a6-151a-11ed-9585-d4d2528b454d', 32, 1),
('a7165d07-151a-11ed-9585-d4d2528b454d', 32, 2),
('a7165fa2-151a-11ed-9585-d4d2528b454d', 32, 3),
('a716612e-151a-11ed-9585-d4d2528b454d', 4, 4),
('a7166354-151a-11ed-9585-d4d2528b454d', 32, 4),
('a7166b6c-151a-11ed-9585-d4d2528b454d', 33, 2),
('a7166ce9-151a-11ed-9585-d4d2528b454d', 33, 3),
('a7166e60-151a-11ed-9585-d4d2528b454d', 33, 4),
('a7166fe0-151a-11ed-9585-d4d2528b454d', 34, 2),
('a716715b-151a-11ed-9585-d4d2528b454d', 5, 1),
('a716732a-151a-11ed-9585-d4d2528b454d', 34, 3),
('a716759f-151a-11ed-9585-d4d2528b454d', 34, 4),
('a7167723-151a-11ed-9585-d4d2528b454d', 35, 1),
('a7167894-151a-11ed-9585-d4d2528b454d', 35, 2),
('a71679fd-151a-11ed-9585-d4d2528b454d', 35, 3),
('a7167b61-151a-11ed-9585-d4d2528b454d', 35, 4),
('a7167cc8-151a-11ed-9585-d4d2528b454d', 36, 1),
('a7167e5b-151a-11ed-9585-d4d2528b454d', 5, 3),
('a71680b4-151a-11ed-9585-d4d2528b454d', 37, 1),
('a716823c-151a-11ed-9585-d4d2528b454d', 38, 1),
('a716841c-151a-11ed-9585-d4d2528b454d', 38, 2),
('a71685a3-151a-11ed-9585-d4d2528b454d', 38, 3),
('a716874f-151a-11ed-9585-d4d2528b454d', 38, 4),
('a716897d-151a-11ed-9585-d4d2528b454d', 39, 1),
('a7168afd-151a-11ed-9585-d4d2528b454d', 39, 2),
('a7168c69-151a-11ed-9585-d4d2528b454d', 39, 3),
('a7168dd2-151a-11ed-9585-d4d2528b454d', 39, 4),
('a7168f35-151a-11ed-9585-d4d2528b454d', 5, 2),
('a716909e-151a-11ed-9585-d4d2528b454d', 5, 4),
('a7169202-151a-11ed-9585-d4d2528b454d', 40, 1),
('a71693b1-151a-11ed-9585-d4d2528b454d', 40, 2),
('a7169566-151a-11ed-9585-d4d2528b454d', 40, 3),
('a71696da-151a-11ed-9585-d4d2528b454d', 40, 4),
('a7169848-151a-11ed-9585-d4d2528b454d', 41, 1),
('a71699ad-151a-11ed-9585-d4d2528b454d', 41, 2),
('a7169b0c-151a-11ed-9585-d4d2528b454d', 41, 3),
('a7169c72-151a-11ed-9585-d4d2528b454d', 41, 4),
('a7169dd2-151a-11ed-9585-d4d2528b454d', 42, 1),
('a7169f89-151a-11ed-9585-d4d2528b454d', 42, 2),
('a716a11a-151a-11ed-9585-d4d2528b454d', 42, 3),
('a716a292-151a-11ed-9585-d4d2528b454d', 42, 4),
('a716a4e7-151a-11ed-9585-d4d2528b454d', 34, 1),
('a716a6ec-151a-11ed-9585-d4d2528b454d', 31, 2),
('a716a866-151a-11ed-9585-d4d2528b454d', 31, 4),
('a716aaf3-151a-11ed-9585-d4d2528b454d', 38, 5),
('a716aca0-151a-11ed-9585-d4d2528b454d', 38, 6),
('a716ae73-151a-11ed-9585-d4d2528b454d', 38, 7),
('a716afe6-151a-11ed-9585-d4d2528b454d', 33, 1),
('a716b1ae-151a-11ed-9585-d4d2528b454d', 33, 5),
('a716b31d-151a-11ed-9585-d4d2528b454d', 43, 1),
('a716b4ca-151a-11ed-9585-d4d2528b454d', 43, 2),
('a716b683-151a-11ed-9585-d4d2528b454d', 43, 3),
('a716b89e-151a-11ed-9585-d4d2528b454d', 44, 1),
('a716bbac-151a-11ed-9585-d4d2528b454d', 44, 2),
('a716be16-151a-11ed-9585-d4d2528b454d', 44, 3),
('a7170890-151a-11ed-9585-d4d2528b454d', 44, 4),
('a7170a74-151a-11ed-9585-d4d2528b454d', 44, 5),
('a7170c03-151a-11ed-9585-d4d2528b454d', 44, 6),
('a7170d89-151a-11ed-9585-d4d2528b454d', 44, 7),
('a7170f02-151a-11ed-9585-d4d2528b454d', 45, 1),
('a7171084-151a-11ed-9585-d4d2528b454d', 46, 1),
('a7171248-151a-11ed-9585-d4d2528b454d', 2, 1),
('a7171446-151a-11ed-9585-d4d2528b454d', 7, 1),
('a7171647-151a-11ed-9585-d4d2528b454d', 46, 2),
('a71717b9-151a-11ed-9585-d4d2528b454d', 46, 3),
('a7171928-151a-11ed-9585-d4d2528b454d', 46, 4),
('a7171aa4-151a-11ed-9585-d4d2528b454d', 46, 5),
('a7171c15-151a-11ed-9585-d4d2528b454d', 46, 6),
('a7171d82-151a-11ed-9585-d4d2528b454d', 46, 7),
('a7171f3e-151a-11ed-9585-d4d2528b454d', 47, 1),
('a71720d8-151a-11ed-9585-d4d2528b454d', 47, 2),
('a7172246-151a-11ed-9585-d4d2528b454d', 47, 3),
('a71723b1-151a-11ed-9585-d4d2528b454d', 47, 4),
('a7172526-151a-11ed-9585-d4d2528b454d', 7, 3),
('a71726a6-151a-11ed-9585-d4d2528b454d', 48, 1),
('a71728cc-151a-11ed-9585-d4d2528b454d', 49, 1),
('a7172b2e-151a-11ed-9585-d4d2528b454d', 49, 2),
('a7172dfb-151a-11ed-9585-d4d2528b454d', 49, 3),
('a717305e-151a-11ed-9585-d4d2528b454d', 49, 4),
('a7173276-151a-11ed-9585-d4d2528b454d', 49, 5),
('a7173486-151a-11ed-9585-d4d2528b454d', 50, 1),
('a7173651-151a-11ed-9585-d4d2528b454d', 50, 2),
('a717381e-151a-11ed-9585-d4d2528b454d', 50, 3),
('a71739c7-151a-11ed-9585-d4d2528b454d', 50, 4),
('a7173b5b-151a-11ed-9585-d4d2528b454d', 8, 1),
('a7173d28-151a-11ed-9585-d4d2528b454d', 51, 1),
('a7173e97-151a-11ed-9585-d4d2528b454d', 51, 2),
('a717402e-151a-11ed-9585-d4d2528b454d', 51, 3),
('a7174288-151a-11ed-9585-d4d2528b454d', 51, 4),
('a717440d-151a-11ed-9585-d4d2528b454d', 52, 1),
('a7174607-151a-11ed-9585-d4d2528b454d', 52, 2),
('a71747ea-151a-11ed-9585-d4d2528b454d', 52, 3),
('a7174971-151a-11ed-9585-d4d2528b454d', 52, 4),
('a7174ae4-151a-11ed-9585-d4d2528b454d', 52, 5),
('a7174dce-151a-11ed-9585-d4d2528b454d', 8, 3),
('a7174f46-151a-11ed-9585-d4d2528b454d', 43, 4),
('a7175104-151a-11ed-9585-d4d2528b454d', 51, 5),
('a71752d7-151a-11ed-9585-d4d2528b454d', 51, 6),
('a7175458-151a-11ed-9585-d4d2528b454d', 51, 7),
('a71756d6-151a-11ed-9585-d4d2528b454d', 50, 5),
('a7175808-151a-11ed-9585-d4d2528b454d', 50, 6),
('a71759a6-151a-11ed-9585-d4d2528b454d', 50, 7),
('a7175ada-151a-11ed-9585-d4d2528b454d', 9, 1),
('a7175c9a-151a-11ed-9585-d4d2528b454d', 9, 3),
('a7175e48-151a-11ed-9585-d4d2528b454d', 53, 1),
('a717e0e0-151a-11ed-9585-d4d2528b454d', 53, 3),
('a717e33c-151a-11ed-9585-d4d2528b454d', 53, 5),
('a717e50f-151a-11ed-9585-d4d2528b454d', 53, 6),
('a717e6a9-151a-11ed-9585-d4d2528b454d', 53, 7),
('a717e89c-151a-11ed-9585-d4d2528b454d', 54, 1),
('a717ea44-151a-11ed-9585-d4d2528b454d', 54, 2),
('a717ebc0-151a-11ed-9585-d4d2528b454d', 54, 3),
('a717ed3f-151a-11ed-9585-d4d2528b454d', 54, 5),
('a717eeb8-151a-11ed-9585-d4d2528b454d', 54, 6),
('a717f033-151a-11ed-9585-d4d2528b454d', 54, 7),
('a717f1af-151a-11ed-9585-d4d2528b454d', 55, 1),
('a717f330-151a-11ed-9585-d4d2528b454d', 55, 2),
('a717f63d-151a-11ed-9585-d4d2528b454d', 55, 3),
('a717f7be-151a-11ed-9585-d4d2528b454d', 55, 4),
('a717f936-151a-11ed-9585-d4d2528b454d', 55, 5),
('a717fac2-151a-11ed-9585-d4d2528b454d', 55, 6),
('a717fc3a-151a-11ed-9585-d4d2528b454d', 55, 7),
('a717fdaf-151a-11ed-9585-d4d2528b454d', 2, 2),
('a717ff3f-151a-11ed-9585-d4d2528b454d', 2, 3),
('a71800c5-151a-11ed-9585-d4d2528b454d', 15, 1),
('a718024a-151a-11ed-9585-d4d2528b454d', 16, 1),
('a71803c5-151a-11ed-9585-d4d2528b454d', 16, 2),
('a7180538-151a-11ed-9585-d4d2528b454d', 2, 4),
('a71806b6-151a-11ed-9585-d4d2528b454d', 16, 3),
('a718082f-151a-11ed-9585-d4d2528b454d', 16, 4),
('a7180a76-151a-11ed-9585-d4d2528b454d', 17, 1),
('a7180c3a-151a-11ed-9585-d4d2528b454d', 17, 2),
('a7180dc8-151a-11ed-9585-d4d2528b454d', 17, 3),
('a7180f5d-151a-11ed-9585-d4d2528b454d', 17, 4),
('a718112f-151a-11ed-9585-d4d2528b454d', 18, 1),
('a71812b8-151a-11ed-9585-d4d2528b454d', 18, 2),
('a7181433-151a-11ed-9585-d4d2528b454d', 3, 1),
('a71815af-151a-11ed-9585-d4d2528b454d', 18, 3),
('a7181727-151a-11ed-9585-d4d2528b454d', 18, 4),
('a7181899-151a-11ed-9585-d4d2528b454d', 3, 2),
('a7181a1a-151a-11ed-9585-d4d2528b454d', 3, 3),
('a7181c05-151a-11ed-9585-d4d2528b454d', 3, 4),
('a9beeb1c-d9a3-11ed-a6c1-109836aef400', 52, 6),
('a9bf08dc-d9a3-11ed-a6c1-109836aef400', 52, 7),
('ac2c401b-2547-11ed-a44b-525400802704', 56, 1),
('ac2c5e03-2547-11ed-a44b-525400802704', 56, 2),
('ac2c6759-2547-11ed-a44b-525400802704', 56, 3),
('ac2c6eba-2547-11ed-a44b-525400802704', 56, 4),
('ac2c7580-2547-11ed-a44b-525400802704', 56, 5),
('ac2c7b9f-2547-11ed-a44b-525400802704', 56, 6),
('ac2c8070-2547-11ed-a44b-525400802704', 56, 7),
('b10f2f32-4b9f-11ed-82ca-525400802704', 60, 1),
('b10f3923-4b9f-11ed-82ca-525400802704', 60, 2),
('b10f43e5-4b9f-11ed-82ca-525400802704', 60, 3),
('b10f4ee8-4b9f-11ed-82ca-525400802704', 60, 4),
('b10f5503-4b9f-11ed-82ca-525400802704', 60, 5),
('b10f5c1b-4b9f-11ed-82ca-525400802704', 60, 6),
('b10f6447-4b9f-11ed-82ca-525400802704', 60, 7),
('d42b24f6-4b9e-11ed-82ca-525400802704', 57, 1),
('d42b98cf-4b9e-11ed-82ca-525400802704', 57, 2),
('d42ba0c6-4b9e-11ed-82ca-525400802704', 57, 3),
('d42ba778-4b9e-11ed-82ca-525400802704', 57, 4),
('d546f50d-4b9f-11ed-82ca-525400802704', 61, 1),
('d546ff0b-4b9f-11ed-82ca-525400802704', 61, 2),
('d547070a-4b9f-11ed-82ca-525400802704', 61, 3),
('d5471662-4b9f-11ed-82ca-525400802704', 61, 4),
('d5548993-4b9f-11ed-82ca-525400802704', 61, 5),
('d554944a-4b9f-11ed-82ca-525400802704', 61, 6),
('d5549f6d-4b9f-11ed-82ca-525400802704', 61, 7),
('d96335fd-fb9f-11ed-b6da-109836aef400', 8, 2),
('d9636eb5-fb9f-11ed-b6da-109836aef400', 8, 4),
('f51de31a-a83d-11ed-9f8e-109836aef400', 49, 6),
('f51e03b5-a83d-11ed-9f8e-109836aef400', 49, 7),
('f6f6a821-4b9f-11ed-82ca-525400802704', 62, 1),
('f6f6b613-4b9f-11ed-82ca-525400802704', 62, 3),
('f6f6be02-4b9f-11ed-82ca-525400802704', 62, 5),
('f6f6c404-4b9f-11ed-82ca-525400802704', 62, 6),
('f6f6c8ef-4b9f-11ed-82ca-525400802704', 62, 7);

--
-- Trigger `yk_menu_aksi`
--
DELIMITER $$
CREATE TRIGGER `init_uuid_menu_aksi` BEFORE INSERT ON `yk_menu_aksi` FOR EACH ROW SET NEW.id_menu_aksi = UUID()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_notif`
--

CREATE TABLE `yk_notif` (
  `id_notif` char(36) NOT NULL,
  `from_id` char(36) DEFAULT NULL,
  `send_id` char(36) DEFAULT NULL,
  `status_notif` enum('0','1') DEFAULT NULL,
  `subject_notif` varchar(50) DEFAULT NULL,
  `msg_notif` text DEFAULT NULL,
  `buat_notif` timestamp NULL DEFAULT current_timestamp(),
  `link_notif` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_site_log`
--

CREATE TABLE `yk_site_log` (
  `site_log_id` char(36) NOT NULL,
  `no_of_visits` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `requested_url` tinytext NOT NULL,
  `referer_page` tinytext NOT NULL,
  `page_name` tinytext NOT NULL,
  `query_string` tinytext NOT NULL,
  `user_agent` tinytext NOT NULL,
  `is_unique` tinyint(1) NOT NULL DEFAULT 0,
  `access_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_site_log`
--

INSERT INTO `yk_site_log` (`site_log_id`, `no_of_visits`, `ip_address`, `requested_url`, `referer_page`, `page_name`, `query_string`, `user_agent`, `is_unique`, `access_date`) VALUES
('be1903c3-747d-11ee-bc00-5958b06b05d9', 1, '110.137.49.46', '/home/auth', 'https://rubeda.pusdatinunimuda.com/home/login', 'home/auth', '', '110.137.49.46 | Desktop  - Linux | Chrome 117.0.0.0', 0, '2023-10-27 06:03:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_user`
--

CREATE TABLE `yk_user` (
  `id_user` char(36) NOT NULL,
  `id_group` int(11) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status_user` enum('1','0') DEFAULT '0',
  `buat_user` timestamp NULL DEFAULT current_timestamp(),
  `update_user` datetime DEFAULT NULL,
  `log_user` varchar(50) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `ip_user` varchar(100) DEFAULT NULL,
  `foto_user` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_user`
--

INSERT INTO `yk_user` (`id_user`, `id_group`, `fullname`, `username`, `email`, `password`, `status_user`, `buat_user`, `update_user`, `log_user`, `last_login`, `ip_user`, `foto_user`) VALUES
('2d59e0d6-8e5f-4a5b-92ad-28cfc6ba30ab', 4, 'Filzha Muzita', '082187814616', NULL, '$2y$10$.HRKg6xSuCsVz1qDMNV86.QpP3cHfeJJ5PuTgl/aWR95SXyMlujb2', '1', '2023-07-31 06:28:36', NULL, 'Pendaftaran Akun', NULL, '180.249.154.166 | Desktop  - Mac OS X | Safari 605.1.15', NULL),
('830ef020-c5ca-46ef-8408-8c3af482c1d7', 4, 'Filzha Muzita', '082187814617', NULL, '$2y$10$09cWIhaORP9uBFVeNTEM9eeV.ZI/Yzo8Y2VZNYIltYaBVDM4eyxbW', '1', '2023-09-16 04:52:42', NULL, 'Filzha Muzita Login Sistem', '2023-10-22 06:24:00', '180.249.152.151 | Desktop  - Mac OS X | Chrome 118.0.0.0', NULL),
('913e6b48-151d-11ed-9585-d4d2528b454d', 2, 'Operator Website', 'oppmb', 'info@unimudasorong.ac.id', '$2y$10$Vy26x7dVhrEHsdImV7JK/.dOlj5xHUEWdryPKZthQW48T1EVfDwYC', '1', '2018-12-17 09:01:12', '2019-02-22 15:44:52', 'Operator Website Login Sistem', '2021-03-24 19:46:27', '182.2.198.5 | Desktop  - Windows 10 | Chrome 89.0.4389.90', 'app/upload/profil/operator-website-szqn.png'),
('913e703a-151d-11ed-9585-d4d2528b454d', 1, 'Administrator', 'admin', 'galihbayu17@gmail.com', '$2y$10$N010YC5ydWwayt9GkL0wN.AijJy8osU4mZDyN1AllhSGImuOX3/ty', '1', '2017-07-18 05:12:37', '2022-07-28 16:31:44', 'Administrator Login Sistem with Switch Account', '2023-10-27 13:03:24', '110.137.49.46 | Desktop  - Linux | Chrome 117.0.0.0', 'app/upload/profil/administrator-rc5p.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_user_log`
--

CREATE TABLE `yk_user_log` (
  `user_id` char(36) NOT NULL,
  `ip_log` varchar(100) DEFAULT NULL,
  `buat_log` timestamp NULL DEFAULT current_timestamp(),
  `msg_log` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `yk_user_log`
--

INSERT INTO `yk_user_log` (`user_id`, `ip_log`, `buat_log`, `msg_log`) VALUES
('913e703a-151d-11ed-9585-d4d2528b454d', '110.137.49.46 | Desktop  - Linux | Chrome 117.0.0.0', '2023-10-27 06:03:10', 'Administrator Login Sistem'),
('913e703a-151d-11ed-9585-d4d2528b454d', '110.137.49.46 | Desktop  - Linux | Chrome 117.0.0.0', '2023-10-27 06:03:23', 'Administrator Login Sistem with Switch Account');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `m_creator`
--
ALTER TABLE `m_creator`
  ADD PRIMARY KEY (`id_creator`);

--
-- Indeks untuk tabel `m_komen`
--
ALTER TABLE `m_komen`
  ADD PRIMARY KEY (`id_komen`);

--
-- Indeks untuk tabel `m_room`
--
ALTER TABLE `m_room`
  ADD PRIMARY KEY (`id_room`);

--
-- Indeks untuk tabel `m_topik`
--
ALTER TABLE `m_topik`
  ADD PRIMARY KEY (`id_topik`);

--
-- Indeks untuk tabel `m_video`
--
ALTER TABLE `m_video`
  ADD PRIMARY KEY (`id_video`);

--
-- Indeks untuk tabel `yk_aksi`
--
ALTER TABLE `yk_aksi`
  ADD PRIMARY KEY (`id_aksi`);

--
-- Indeks untuk tabel `yk_aplikasi`
--
ALTER TABLE `yk_aplikasi`
  ADD PRIMARY KEY (`id_aplikasi`);

--
-- Indeks untuk tabel `yk_group`
--
ALTER TABLE `yk_group`
  ADD PRIMARY KEY (`id_group`);

--
-- Indeks untuk tabel `yk_group_menu_aksi`
--
ALTER TABLE `yk_group_menu_aksi`
  ADD KEY `id_group` (`id_group`),
  ADD KEY `id_menu_aksi` (`id_menu_aksi`);

--
-- Indeks untuk tabel `yk_group_role`
--
ALTER TABLE `yk_group_role`
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `yk_menu`
--
ALTER TABLE `yk_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `yk_menu_aksi`
--
ALTER TABLE `yk_menu_aksi`
  ADD PRIMARY KEY (`id_menu_aksi`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_aksi` (`id_aksi`);

--
-- Indeks untuk tabel `yk_notif`
--
ALTER TABLE `yk_notif`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `send_id` (`send_id`),
  ADD KEY `from_id` (`from_id`);

--
-- Indeks untuk tabel `yk_site_log`
--
ALTER TABLE `yk_site_log`
  ADD PRIMARY KEY (`site_log_id`);

--
-- Indeks untuk tabel `yk_user`
--
ALTER TABLE `yk_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_group` (`id_group`);

--
-- Indeks untuk tabel `yk_user_log`
--
ALTER TABLE `yk_user_log`
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `m_topik`
--
ALTER TABLE `m_topik`
  MODIFY `id_topik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `yk_aksi`
--
ALTER TABLE `yk_aksi`
  MODIFY `id_aksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `yk_aplikasi`
--
ALTER TABLE `yk_aplikasi`
  MODIFY `id_aplikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `yk_group`
--
ALTER TABLE `yk_group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `yk_menu`
--
ALTER TABLE `yk_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `yk_group_menu_aksi`
--
ALTER TABLE `yk_group_menu_aksi`
  ADD CONSTRAINT `yk_group_menu_aksi_ibfk_1` FOREIGN KEY (`id_menu_aksi`) REFERENCES `yk_menu_aksi` (`id_menu_aksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yk_group_menu_aksi_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `yk_group` (`id_group`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `yk_group_role`
--
ALTER TABLE `yk_group_role`
  ADD CONSTRAINT `yk_group_role_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `yk_group` (`id_group`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yk_group_role_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `yk_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `yk_menu_aksi`
--
ALTER TABLE `yk_menu_aksi`
  ADD CONSTRAINT `yk_menu_aksi_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `yk_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `yk_menu_aksi_ibfk_2` FOREIGN KEY (`id_aksi`) REFERENCES `yk_aksi` (`id_aksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `yk_user`
--
ALTER TABLE `yk_user`
  ADD CONSTRAINT `yk_user_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `yk_group` (`id_group`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `yk_user_log`
--
ALTER TABLE `yk_user_log`
  ADD CONSTRAINT `yk_user_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yk_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
