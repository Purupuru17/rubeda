-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 17 Mei 2023 pada 17.02
-- Versi Server: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rubeda_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `fk_like`
--

CREATE TABLE `fk_like` (
  `video_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `status_like` enum('0','1') DEFAULT NULL,
  `create_like` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fk_riwayat`
--

CREATE TABLE `fk_riwayat` (
  `video_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `create_riwayat` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fk_subscribe`
--

CREATE TABLE `fk_subscribe` (
  `creator_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `create_subscribe` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_chat`
--

CREATE TABLE `m_chat` (
  `id_chat` char(36) NOT NULL,
  `room_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `status_chat` enum('0','1','2') DEFAULT NULL,
  `isi_chat` text,
  `file_chat` varchar(100) DEFAULT NULL,
  `create_chat` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `create_creator` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_creator` datetime DEFAULT NULL,
  `log_creator` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_komen`
--

CREATE TABLE `m_komen` (
  `id_komen` char(36) NOT NULL,
  `video_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `isi_komen` text,
  `create_komen` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_room`
--

CREATE TABLE `m_room` (
  `id_room` char(36) NOT NULL,
  `send_by` char(36) NOT NULL,
  `send_to` char(36) NOT NULL,
  `status_room` enum('0','1','2') DEFAULT NULL,
  `create_room` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_topik`
--

CREATE TABLE `m_topik` (
  `id_topik` int(11) NOT NULL,
  `parent_topik` int(11) DEFAULT NULL,
  `judul_topik` varchar(50) DEFAULT NULL,
  `img_topik` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_video`
--

CREATE TABLE `m_video` (
  `id_video` char(36) NOT NULL,
  `creator_id` char(36) NOT NULL,
  `topik_id` int(11) NOT NULL,
  `judul_video` varchar(100) DEFAULT NULL,
  `status_video` enum('0','1','2','3') DEFAULT NULL,
  `usia_video` enum('0','1','2','3') DEFAULT NULL,
  `slug_video` varchar(50) DEFAULT NULL,
  `file_video` varchar(100) DEFAULT NULL,
  `img_video` varchar(100) DEFAULT NULL,
  `tag_video` varchar(50) DEFAULT NULL,
  `deskripsi_video` text,
  `create_video` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_video` datetime DEFAULT NULL,
  `log_video` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rf_artikel`
--

CREATE TABLE `rf_artikel` (
  `id_artikel` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `judul_artikel` varchar(200) DEFAULT NULL,
  `slug_artikel` varchar(250) DEFAULT NULL,
  `status_artikel` enum('0','1') DEFAULT '1',
  `is_popular` enum('0','1') DEFAULT '0',
  `is_breaking` enum('0','1') DEFAULT '0',
  `view_artikel` int(11) DEFAULT '0',
  `isi_artikel` text,
  `foto_artikel` varchar(200) DEFAULT NULL,
  `update_artikel` timestamp NULL DEFAULT NULL,
  `log_artikel` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rf_artikel`
--

INSERT INTO `rf_artikel` (`id_artikel`, `jenis_id`, `judul_artikel`, `slug_artikel`, `status_artikel`, `is_popular`, `is_breaking`, `view_artikel`, `isi_artikel`, `foto_artikel`, `update_artikel`, `log_artikel`) VALUES
(1, 1, 'Apa saja yang terbaru ?', 'apa-saja-yang-terbaru', '1', '1', '1', 6, '', NULL, '2022-10-31 15:22:48', 'Administrator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rf_file`
--

CREATE TABLE `rf_file` (
  `id_file` int(11) NOT NULL,
  `nama_file` varchar(200) DEFAULT NULL,
  `type_file` varchar(50) DEFAULT NULL,
  `size_file` varchar(50) DEFAULT NULL,
  `url_file` varchar(200) DEFAULT NULL,
  `update_file` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log_file` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rf_galeri`
--

CREATE TABLE `rf_galeri` (
  `id_galeri` int(11) NOT NULL,
  `judul_galeri` varchar(200) DEFAULT NULL,
  `slug_galeri` varchar(250) DEFAULT NULL,
  `jenis_galeri` enum('0','1') DEFAULT '0',
  `isi_galeri` text,
  `status_galeri` enum('0','1') DEFAULT '1',
  `is_header` enum('0','1') DEFAULT '0',
  `foto_galeri` varchar(200) DEFAULT NULL,
  `update_galeri` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log_galeri` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rf_jenis_artikel`
--

CREATE TABLE `rf_jenis_artikel` (
  `id_jenis` int(11) NOT NULL,
  `judul_jenis` varchar(100) DEFAULT NULL,
  `slug_jenis` varchar(150) DEFAULT NULL,
  `icon_jenis` char(20) DEFAULT NULL,
  `color_jenis` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rf_jenis_artikel`
--

INSERT INTO `rf_jenis_artikel` (`id_jenis`, `judul_jenis`, `slug_jenis`, `icon_jenis`, `color_jenis`) VALUES
(1, 'Berita', 'berita', 'fa fa-newspaper-o', '#00439d'),
(2, 'Pengumuman', 'pengumuman', 'fa fa-check-square-o', '#d50000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rf_kutipan`
--

CREATE TABLE `rf_kutipan` (
  `id_kutipan` int(11) NOT NULL,
  `oleh` varchar(100) DEFAULT NULL,
  `quote` text,
  `update_kutipan` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log_kutipan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rf_nav`
--

CREATE TABLE `rf_nav` (
  `id_nav` int(11) NOT NULL,
  `parent_nav` int(11) NOT NULL,
  `judul_nav` varchar(100) NOT NULL,
  `url_nav` varchar(200) NOT NULL,
  `link_nav` enum('0','1') DEFAULT '0',
  `status_nav` enum('0','1') NOT NULL DEFAULT '1',
  `order_nav` int(11) NOT NULL,
  `icon_nav` varchar(20) NOT NULL,
  `update_nav` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log_nav` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rf_page`
--

CREATE TABLE `rf_page` (
  `id_page` int(11) NOT NULL,
  `judul_page` varchar(200) DEFAULT NULL,
  `slug_page` varchar(250) DEFAULT NULL,
  `status_page` enum('0','1') DEFAULT '1',
  `isi_page` text,
  `foto_page` varchar(200) DEFAULT NULL,
  `update_page` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log_page` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rf_page`
--

INSERT INTO `rf_page` (`id_page`, `judul_page`, `slug_page`, `status_page`, `isi_page`, `foto_page`, `update_page`, `log_page`) VALUES
(1, '2. Fitur Dosen Pengampu & PA', '2-fitur-dosen-pengampu-pa', '1', '<ol style=\"margin-left:35px\">\r\n	<li><span style=\"font-size:14px\">Export Jurnal</span>\r\n	<ul style=\"margin-left:30px\">\r\n		<li><span style=\"font-size:14px\">Dapat di akses melalui menu&nbsp;<strong>Akademik &gt; Jurnal &gt;&nbsp;<input name=\"export-jurnal\" type=\"button\" value=\"Export Jurnal\" /></strong></span></li>\r\n		<li><span style=\"font-size:14px\">Data yang di export berupa file excel dengan detail pertemuan dari awal hingga pertemuan terakhir saat di inputkan</span></li>\r\n		<li><span style=\"font-size:14px\">Data excel masih menggunakan format standar, silahkan di perbarui sesuai kebutuhan</span></li>\r\n		<li><span style=\"font-size:14px\"><strong><input name=\"rekap\" type=\"button\" value=\"Rekap\" />&nbsp;</strong>adalah tombol&nbsp;khusus untuk bagian Keuangan yang digunakan untuk merekap jurnal perkuliahan perbulan per program studi, dosen tidak di beri akses untuk fitur tersebut.</span></li>\r\n	</ul>\r\n	</li>\r\n	<li><span style=\"font-size:14px\">Input&nbsp;Presensi&nbsp;Kolektif</span>\r\n	<ul style=\"margin-left:30px\">\r\n		<li><span style=\"font-size:14px\">Dapat di akses melalui menu&nbsp;<strong>Akademik &gt; Jurnal &gt; Presensi&nbsp;</strong>(<em>pilih salah satu pertemuan</em>)&nbsp;<strong>&gt;&nbsp;<input name=\"presensi\" type=\"button\" value=\"Input Presensi Kolektif\" /></strong></span></li>\r\n		<li><span style=\"font-size:14px\">Pilih&nbsp;<strong>Status Presensi&nbsp;</strong>yang akan di kolektifkan untuk beberapa mahasiswa</span></li>\r\n		<li><span style=\"font-size:14px\">Check list beberapa mahasiswa dengan kriteria tersebut (<em>sesuai status presensi di atas</em>), lalu klik&nbsp;<strong><input name=\"simpan-pre\" type=\"button\" value=\"Simpan Presensi\" /></strong></span></li>\r\n		<li><span style=\"font-size:14px\">Ubah status presensi<strong>&nbsp;</strong>secara manual atau per mahasiswa masih dapat dilakukan</span></li>\r\n	</ul>\r\n	</li>\r\n</ol>\r\n', NULL, '2022-11-16 06:24:51', 'Administrator'),
(2, '3. Fitur Program Studi', '3-fitur-program-studi', '1', '', NULL, '2022-11-03 06:22:47', 'Administrator'),
(3, '5. Saran & Masukan', '5-saran-masukan', '1', '<p><span style=\"color:rgb(32, 33, 36); font-family:roboto,arial,sans-serif; font-size:14.6667px\"><strong>Link Form, <a href=\"https://forms.gle/jAukUeWEdxjqPx236\" target=\"_blank\">klik disini</a></strong><br />\r\nSilahkan sampaikan beberapa saran dan masukan terkait Sistem SIAKAD UNIMUDA. Kami harap dari hal tersebut dapat menjadikan sistem ini jauh lebih baik kedepannya.</span><br />\r\n<span style=\"color:rgb(32, 33, 36); font-family:roboto,arial,sans-serif; font-size:14.6667px\">Terimakasih.</span><br />\r\n<br />\r\n<em>PUSDATIN UNIMUDA</em></p>\r\n', NULL, '2022-11-03 06:24:12', 'Administrator'),
(4, '1. Update Fitur Terbaru', '1-update-fitur-terbaru', '1', '<p><span style=\"color:rgb(70, 77, 105); font-family:heebo,sans-serif; font-size:12px\">Tanggal Rilis : 16</span><span style=\"color:rgb(70, 77, 105); font-family:heebo,sans-serif; font-size:12px\">&nbsp;November 2022</span></p>\r\n\r\n<p><strong><span style=\"font-size:16px\">DOSEN</span></strong></p>\r\n\r\n<ol style=\"margin-left:35px\">\r\n	<li><span style=\"color:#FF0000\"><span style=\"font-size:14px\">Kuliah Pengabdian Masyarakat (<strong>KPM</strong>) LP3M</span></span>\r\n\r\n	<ul style=\"margin-left:40px\">\r\n		<li><span style=\"color:#FF0000\"><span style=\"font-size:14px\">Dapat di akses melalui menu :&nbsp;<strong>KPM LP3M &gt; Penilaian</strong></span></span></li>\r\n		<li><span style=\"color:#FF0000\"><span style=\"font-size:14px\">Dosen dapat melihat Penempatan KPM beserta nama-nama&nbsp;Mahasiswa dari kelompok tersebut</span></span></li>\r\n		<li><span style=\"color:#FF0000\"><span style=\"font-size:14px\">Apabila KPM telah selesai, mahasiswa wajib mengupload laporan KPM lalu dosen dapat memberikan penilaian</span></span></li>\r\n	</ul>\r\n	</li>\r\n	<li><span style=\"font-size:14px\">Export Presensi</span>\r\n	<ul style=\"margin-left:30px\">\r\n		<li><span style=\"font-size:14px\">Dapat di akses melalui menu&nbsp;<strong>Akademik &gt; Jurnal &gt;&nbsp;<input name=\"export-presensi\" type=\"button\" value=\"Export Presensi\" /></strong></span></li>\r\n		<li><span style=\"font-size:14px\">Data yang di export berupa file excel berisi daftar mahasiswa yang mengambil kelas kuliah tersebut beserta keterangan presensi tiap pertemuan</span></li>\r\n		<li><span style=\"font-size:14px\">Data excel masih menggunakan format standar, silahkan di perbarui sesuai kebutuhan</span></li>\r\n	</ul>\r\n	</li>\r\n</ol>\r\n\r\n<p><strong><span style=\"font-size:16px\">PROGRAM STUDI</span></strong></p>\r\n\r\n<ol style=\"margin-left:35px\">\r\n	<li><span style=\"color:#FF0000\"><span style=\"font-size:14px\">Kuliah Pengabdian Masyarakat (<strong>KPM</strong>) LP3M</span></span>\r\n\r\n	<ul style=\"margin-left:40px\">\r\n		<li><span style=\"color:#FF0000\"><span style=\"font-size:14px\">Dapat di akses melalui menu :&nbsp;<strong>KPM LP3M &gt; Peserta</strong></span></span></li>\r\n		<li><span style=\"color:#FF0000\"><span style=\"font-size:14px\">Program Studi dapat melihat daftar mahasiswa yang telah mendaftarkan diri sebagai peserta KPM LP3M tahun ini</span></span></li>\r\n		<li><span style=\"color:#FF0000\"><span style=\"font-size:14px\">Klik tombol detail untuk melihat data secara lengkap</span></span></li>\r\n	</ul>\r\n	</li>\r\n	<li><span style=\"font-size:14px\">Dosen Non-NIDN dan Praktisi</span>\r\n	<ul style=\"margin-left:30px\">\r\n		<li><span style=\"font-size:14px\">Bagi&nbsp;<strong>Dosen&nbsp;belum memiliki NIDN</strong>,&nbsp;<strong>Dosen tidak tetap</strong>&nbsp;(luar) maupun&nbsp;<strong>Praktisi&nbsp;</strong>yang sampai saat ini belum memiliki&nbsp;<strong>Akses/Akun</strong>&nbsp;SIAKAD, dimohon untuk mengisi&nbsp;<strong>Form Pendaftaran</strong>,&nbsp;<strong><a href=\"https://bit.ly/praktisi-dosen-non-nidn\" target=\"_blank\">klik disini</a></strong>. Pusdatin akan segera membuatkan akun berdasarkan data pada Form tersebut</span></li>\r\n		<li><span style=\"font-size:14px\">Program studi diharapkan dapat membantu proses pendataan tersebut dengan menginfokan kepada yang bersangkutan (<em>di bantu menginputkan lebih baik</em>)</span></li>\r\n		<li><span style=\"font-size:14px\">Link form yang dapat di copy paste,&nbsp; &nbsp;&nbsp;&nbsp;<strong>https://bit.ly/praktisi-dosen-non-nidn</strong></span></li>\r\n	</ul>\r\n	</li>\r\n</ol>\r\n', NULL, '2022-11-16 06:26:05', 'Administrator'),
(5, '4. Fitur Mahasiswa', '4-fitur-mahasiswa', '1', '', NULL, '2022-11-03 06:23:59', 'Administrator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_aksi`
--

CREATE TABLE `yk_aksi` (
  `id_aksi` int(11) NOT NULL,
  `nama_aksi` varchar(10) DEFAULT NULL,
  `fungsi` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `yk_aplikasi`
--

INSERT INTO `yk_aplikasi` (`id_aplikasi`, `judul`, `deskripsi`, `cipta`, `logo`, `tema`, `update_aplikasi`, `session_aplikasi`) VALUES
(1, 'SATU UNIMUDA', 'Sistem Akademik Terintegrasi UNIMUDA', 'UNIMUDA Sorong', 'app/img/logo.png', 'no-skin,3,0,0,0,0,0,0,0,0,#226cb4,#2c3e50', '2022-08-23 14:45:31', 'Administrator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_group`
--

CREATE TABLE `yk_group` (
  `id_group` int(11) NOT NULL,
  `nama_group` varchar(50) DEFAULT NULL,
  `level` enum('1','2') DEFAULT NULL,
  `keterangan_group` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `yk_group`
--

INSERT INTO `yk_group` (`id_group`, `nama_group`, `level`, `keterangan_group`) VALUES
(1, 'Administrator', '1', 'Super Admin Sistem'),
(2, 'Operator', '2', 'Operator Aplikasi'),
(3, 'Program Studi', '2', 'Program Studi'),
(4, 'Mahasiswa', '2', 'Akun Mahasiswa'),
(5, 'Dosen', '2', 'Dosen Biasa & PA'),
(6, 'Keuangan', '2', 'Keuangan UNIMUDA'),
(7, 'KPM', '2', 'KPM LP3M'),
(8, 'Pimpinan', '2', 'Pimpinan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_group_menu_aksi`
--

CREATE TABLE `yk_group_menu_aksi` (
  `id_menu_aksi` char(36) NOT NULL,
  `id_group` int(11) DEFAULT NULL,
  `segmen` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `yk_group_menu_aksi`
--

INSERT INTO `yk_group_menu_aksi` (`id_menu_aksi`, `id_group`, `segmen`) VALUES
('a7164b75-151a-11ed-9585-d4d2528b454d', 7, 'master/all/index'),
('a716afe6-151a-11ed-9585-d4d2528b454d', 7, 'master/dosen/index'),
('a71658a6-151a-11ed-9585-d4d2528b454d', 7, 'master/mahasiswa/index'),
('a716651e-151a-11ed-9585-d4d2528b454d', 7, 'master/mahasiswa/detail'),
('d42b24f6-4b9e-11ed-82ca-525400802704', 7, 'master/tempat/index'),
('d42b98cf-4b9e-11ed-82ca-525400802704', 7, 'master/tempat/add'),
('d42ba0c6-4b9e-11ed-82ca-525400802704', 7, 'master/tempat/edit'),
('8a51a3e5-4b9f-11ed-82ca-525400802704', 7, 'mengajar/all/index'),
('d546f50d-4b9f-11ed-82ca-525400802704', 7, 'mengajar/pembimbing/index'),
('d546ff0b-4b9f-11ed-82ca-525400802704', 7, 'mengajar/pembimbing/add'),
('d547070a-4b9f-11ed-82ca-525400802704', 7, 'mengajar/pembimbing/edit'),
('d5548993-4b9f-11ed-82ca-525400802704', 7, 'mengajar/pembimbing/detail'),
('d554944a-4b9f-11ed-82ca-525400802704', 7, 'mengajar/pembimbing/cetak'),
('d5549f6d-4b9f-11ed-82ca-525400802704', 7, 'mengajar/pembimbing/export'),
('b10f2f32-4b9f-11ed-82ca-525400802704', 7, 'mengajar/peserta/index'),
('b10f3923-4b9f-11ed-82ca-525400802704', 7, 'mengajar/peserta/add'),
('b10f43e5-4b9f-11ed-82ca-525400802704', 7, 'mengajar/peserta/edit'),
('b10f5503-4b9f-11ed-82ca-525400802704', 7, 'mengajar/peserta/detail'),
('b10f5c1b-4b9f-11ed-82ca-525400802704', 7, 'mengajar/peserta/cetak'),
('b10f6447-4b9f-11ed-82ca-525400802704', 7, 'mengajar/peserta/export'),
('a7171446-151a-11ed-9585-d4d2528b454d', 7, 'sistem/password/index'),
('a7172526-151a-11ed-9585-d4d2528b454d', 7, 'sistem/password/edit'),
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
('a71658a6-151a-11ed-9585-d4d2528b454d', 2, 'master/mahasiswa/index'),
('a716651e-151a-11ed-9585-d4d2528b454d', 2, 'master/mahasiswa/detail'),
('a716b31d-151a-11ed-9585-d4d2528b454d', 2, 'master/semester/index'),
('a7174c58-151a-11ed-9585-d4d2528b454d', 2, 'master/semester/detail'),
('a7175ada-151a-11ed-9585-d4d2528b454d', 2, 'sistem/akun/index'),
('a7170f02-151a-11ed-9585-d4d2528b454d', 2, 'wisuda/all/index'),
('a7171084-151a-11ed-9585-d4d2528b454d', 2, 'wisuda/calon/index'),
('a71717b9-151a-11ed-9585-d4d2528b454d', 2, 'wisuda/calon/edit'),
('a7173d28-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/aktivitas/index'),
('a7173e97-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/aktivitas/add'),
('a717402e-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/aktivitas/edit'),
('a7174288-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/aktivitas/delete'),
('a7175104-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/aktivitas/detail'),
('a71752d7-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/aktivitas/cetak'),
('a7175458-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/aktivitas/export'),
('a71726a6-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/all/index'),
('a717f1af-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/jurnal/index'),
('a717f936-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/jurnal/detail'),
('a717fac2-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/jurnal/cetak'),
('a717fc3a-151a-11ed-9585-d4d2528b454d', 6, 'kuliah/jurnal/export'),
('a7164b75-151a-11ed-9585-d4d2528b454d', 6, 'master/all/index'),
('a716a4e7-151a-11ed-9585-d4d2528b454d', 6, 'master/dana/index'),
('a716afe6-151a-11ed-9585-d4d2528b454d', 6, 'master/dosen/index'),
('a716b1ae-151a-11ed-9585-d4d2528b454d', 6, 'master/dosen/detail'),
('a71658a6-151a-11ed-9585-d4d2528b454d', 6, 'master/mahasiswa/index'),
('a716651e-151a-11ed-9585-d4d2528b454d', 6, 'master/mahasiswa/detail'),
('a7169dd2-151a-11ed-9585-d4d2528b454d', 6, 'master/rincian/index'),
('8a51a3e5-4b9f-11ed-82ca-525400802704', 6, 'mengajar/all/index'),
('b10f2f32-4b9f-11ed-82ca-525400802704', 6, 'mengajar/peserta/index'),
('b10f5503-4b9f-11ed-82ca-525400802704', 6, 'mengajar/peserta/detail'),
('a7175ada-151a-11ed-9585-d4d2528b454d', 6, 'sistem/akun/index'),
('a7171446-151a-11ed-9585-d4d2528b454d', 6, 'sistem/password/index'),
('a7172526-151a-11ed-9585-d4d2528b454d', 6, 'sistem/password/edit'),
('a7167cc8-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/all/index'),
('ac2c401b-2547-11ed-a44b-525400802704', 6, 'transaksi/beasiswa/index'),
('ac2c5e03-2547-11ed-a44b-525400802704', 6, 'transaksi/beasiswa/add'),
('ac2c6759-2547-11ed-a44b-525400802704', 6, 'transaksi/beasiswa/edit'),
('ac2c6eba-2547-11ed-a44b-525400802704', 6, 'transaksi/beasiswa/delete'),
('ac2c7580-2547-11ed-a44b-525400802704', 6, 'transaksi/beasiswa/detail'),
('ac2c7b9f-2547-11ed-a44b-525400802704', 6, 'transaksi/beasiswa/cetak'),
('ac2c8070-2547-11ed-a44b-525400802704', 6, 'transaksi/beasiswa/export'),
('a7164e14-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/biaya/index'),
('a716a6ec-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/biaya/add'),
('a7164f95-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/biaya/edit'),
('a716a866-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/biaya/delete'),
('a7165111-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/biaya/detail'),
('a716528d-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/biaya/cetak'),
('a7165606-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/biaya/export'),
('a716823c-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/rekap/index'),
('a716aaf3-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/rekap/detail'),
('a716aca0-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/rekap/cetak'),
('a716ae73-151a-11ed-9585-d4d2528b454d', 6, 'transaksi/rekap/export'),
('a7173d28-151a-11ed-9585-d4d2528b454d', 8, 'kuliah/aktivitas/index'),
('a7175104-151a-11ed-9585-d4d2528b454d', 8, 'kuliah/aktivitas/detail'),
('a71726a6-151a-11ed-9585-d4d2528b454d', 8, 'kuliah/all/index'),
('a7164b75-151a-11ed-9585-d4d2528b454d', 8, 'master/all/index'),
('a71658a6-151a-11ed-9585-d4d2528b454d', 8, 'master/mahasiswa/index'),
('a716651e-151a-11ed-9585-d4d2528b454d', 8, 'master/mahasiswa/detail'),
('a71680b4-151a-11ed-9585-d4d2528b454d', 4, 'mahasiswa/all/index'),
('a717e89c-151a-11ed-9585-d4d2528b454d', 4, 'mahasiswa/khs/index'),
('a717ea44-151a-11ed-9585-d4d2528b454d', 4, 'mahasiswa/khs/add'),
('a717ed3f-151a-11ed-9585-d4d2528b454d', 4, 'mahasiswa/khs/detail'),
('205c78ee-4b9f-11ed-82ca-525400802704', 4, 'mahasiswa/magang/index'),
('205c8302-4b9f-11ed-82ca-525400802704', 4, 'mahasiswa/magang/edit'),
('205c9000-4b9f-11ed-82ca-525400802704', 4, 'mahasiswa/magang/cetak'),
('205c99d0-4b9f-11ed-82ca-525400802704', 4, 'mahasiswa/magang/export'),
('a7175e48-151a-11ed-9585-d4d2528b454d', 4, 'mahasiswa/profil/index'),
('a717e0e0-151a-11ed-9585-d4d2528b454d', 4, 'mahasiswa/profil/edit'),
('a7173d28-151a-11ed-9585-d4d2528b454d', 3, 'kuliah/aktivitas/index'),
('a7175104-151a-11ed-9585-d4d2528b454d', 3, 'kuliah/aktivitas/detail'),
('a71752d7-151a-11ed-9585-d4d2528b454d', 3, 'kuliah/aktivitas/cetak'),
('a7175458-151a-11ed-9585-d4d2528b454d', 3, 'kuliah/aktivitas/export'),
('a71726a6-151a-11ed-9585-d4d2528b454d', 3, 'kuliah/all/index'),
('a71728cc-151a-11ed-9585-d4d2528b454d', 3, 'kuliah/nilai/index'),
('a7172b2e-151a-11ed-9585-d4d2528b454d', 3, 'kuliah/nilai/add'),
('a7172dfb-151a-11ed-9585-d4d2528b454d', 3, 'kuliah/nilai/edit'),
('a7173276-151a-11ed-9585-d4d2528b454d', 3, 'kuliah/nilai/detail'),
('a7164b75-151a-11ed-9585-d4d2528b454d', 3, 'master/all/index'),
('a716afe6-151a-11ed-9585-d4d2528b454d', 3, 'master/dosen/index'),
('a716b1ae-151a-11ed-9585-d4d2528b454d', 3, 'master/dosen/detail'),
('a71658a6-151a-11ed-9585-d4d2528b454d', 3, 'master/mahasiswa/index'),
('a7165d07-151a-11ed-9585-d4d2528b454d', 3, 'master/mahasiswa/add'),
('a716651e-151a-11ed-9585-d4d2528b454d', 3, 'master/mahasiswa/detail'),
('a7166862-151a-11ed-9585-d4d2528b454d', 3, 'master/mahasiswa/cetak'),
('a71669ec-151a-11ed-9585-d4d2528b454d', 3, 'master/mahasiswa/export'),
('8a51a3e5-4b9f-11ed-82ca-525400802704', 3, 'mengajar/all/index'),
('b10f2f32-4b9f-11ed-82ca-525400802704', 3, 'mengajar/peserta/index'),
('a71726a6-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/all/index'),
('a717f1af-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/jurnal/index'),
('a717f330-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/jurnal/add'),
('a717f63d-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/jurnal/edit'),
('a717f7be-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/jurnal/delete'),
('a717f936-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/jurnal/detail'),
('a717fc3a-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/jurnal/export'),
('a7173486-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/krs/index'),
('a7173651-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/krs/add'),
('a717381e-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/krs/edit'),
('a71728cc-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/nilai/index'),
('a7172b2e-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/nilai/add'),
('a7172dfb-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/nilai/edit'),
('a717305e-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/nilai/delete'),
('a7173276-151a-11ed-9585-d4d2528b454d', 5, 'kuliah/nilai/detail'),
('a716651e-151a-11ed-9585-d4d2528b454d', 5, 'master/mahasiswa/detail'),
('8a51a3e5-4b9f-11ed-82ca-525400802704', 5, 'mengajar/all/index'),
('f6f6a821-4b9f-11ed-82ca-525400802704', 5, 'mengajar/penilaian/index'),
('f6f6be02-4b9f-11ed-82ca-525400802704', 5, 'mengajar/penilaian/detail'),
('f6f6c404-4b9f-11ed-82ca-525400802704', 5, 'mengajar/penilaian/cetak'),
('f6f6c8ef-4b9f-11ed-82ca-525400802704', 5, 'mengajar/penilaian/export'),
('a71800c5-151a-11ed-9585-d4d2528b454d', 1, 'konten/all/index'),
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
('a71726a6-151a-11ed-9585-d4d2528b454d', 1, 'kuliah/all/index'),
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
('a71680b4-151a-11ed-9585-d4d2528b454d', 1, 'mahasiswa/all/index'),
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
('a716a4e7-151a-11ed-9585-d4d2528b454d', 1, 'master/dana/index'),
('a7166fe0-151a-11ed-9585-d4d2528b454d', 1, 'master/dana/add'),
('a716732a-151a-11ed-9585-d4d2528b454d', 1, 'master/dana/edit'),
('a716759f-151a-11ed-9585-d4d2528b454d', 1, 'master/dana/delete'),
('a716afe6-151a-11ed-9585-d4d2528b454d', 1, 'master/dosen/index'),
('a7166b6c-151a-11ed-9585-d4d2528b454d', 1, 'master/dosen/add'),
('a7166ce9-151a-11ed-9585-d4d2528b454d', 1, 'master/dosen/edit'),
('a7166e60-151a-11ed-9585-d4d2528b454d', 1, 'master/dosen/delete'),
('a716b1ae-151a-11ed-9585-d4d2528b454d', 1, 'master/dosen/detail'),
('a716b89e-151a-11ed-9585-d4d2528b454d', 1, 'master/kelas/index'),
('a716bbac-151a-11ed-9585-d4d2528b454d', 1, 'master/kelas/add'),
('a716be16-151a-11ed-9585-d4d2528b454d', 1, 'master/kelas/edit'),
('a7170890-151a-11ed-9585-d4d2528b454d', 1, 'master/kelas/delete'),
('a7170a74-151a-11ed-9585-d4d2528b454d', 1, 'master/kelas/detail'),
('a7170c03-151a-11ed-9585-d4d2528b454d', 1, 'master/kelas/cetak'),
('a7170d89-151a-11ed-9585-d4d2528b454d', 1, 'master/kelas/export'),
('a71658a6-151a-11ed-9585-d4d2528b454d', 1, 'master/mahasiswa/index'),
('a7165d07-151a-11ed-9585-d4d2528b454d', 1, 'master/mahasiswa/add'),
('a7165fa2-151a-11ed-9585-d4d2528b454d', 1, 'master/mahasiswa/edit'),
('a7166354-151a-11ed-9585-d4d2528b454d', 1, 'master/mahasiswa/delete'),
('a716651e-151a-11ed-9585-d4d2528b454d', 1, 'master/mahasiswa/detail'),
('a7166862-151a-11ed-9585-d4d2528b454d', 1, 'master/mahasiswa/cetak'),
('a71669ec-151a-11ed-9585-d4d2528b454d', 1, 'master/mahasiswa/export'),
('a7167723-151a-11ed-9585-d4d2528b454d', 1, 'master/prodi/index'),
('a7167894-151a-11ed-9585-d4d2528b454d', 1, 'master/prodi/add'),
('a71679fd-151a-11ed-9585-d4d2528b454d', 1, 'master/prodi/edit'),
('a7167b61-151a-11ed-9585-d4d2528b454d', 1, 'master/prodi/delete'),
('a7169dd2-151a-11ed-9585-d4d2528b454d', 1, 'master/rincian/index'),
('a7169f89-151a-11ed-9585-d4d2528b454d', 1, 'master/rincian/add'),
('a716a11a-151a-11ed-9585-d4d2528b454d', 1, 'master/rincian/edit'),
('a716a292-151a-11ed-9585-d4d2528b454d', 1, 'master/rincian/delete'),
('a716b31d-151a-11ed-9585-d4d2528b454d', 1, 'master/semester/index'),
('a716b4ca-151a-11ed-9585-d4d2528b454d', 1, 'master/semester/add'),
('a716b683-151a-11ed-9585-d4d2528b454d', 1, 'master/semester/edit'),
('a7174f46-151a-11ed-9585-d4d2528b454d', 1, 'master/semester/delete'),
('a7174c58-151a-11ed-9585-d4d2528b454d', 1, 'master/semester/detail'),
('d42b24f6-4b9e-11ed-82ca-525400802704', 1, 'master/tempat/index'),
('d42b98cf-4b9e-11ed-82ca-525400802704', 1, 'master/tempat/add'),
('d42ba0c6-4b9e-11ed-82ca-525400802704', 1, 'master/tempat/edit'),
('d42ba778-4b9e-11ed-82ca-525400802704', 1, 'master/tempat/delete'),
('8a51a3e5-4b9f-11ed-82ca-525400802704', 1, 'mengajar/all/index'),
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
('a7174dce-151a-11ed-9585-d4d2528b454d', 1, 'sistem/aplikasi/edit'),
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
('a7167cc8-151a-11ed-9585-d4d2528b454d', 1, 'transaksi/all/index'),
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
('a7170f02-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/all/index'),
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
('a71723b1-151a-11ed-9585-d4d2528b454d', 1, 'wisuda/matkul/delete');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_group_role`
--

CREATE TABLE `yk_group_role` (
  `group_id` int(11) NOT NULL,
  `user_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `yk_group_role`
--

INSERT INTO `yk_group_role` (`group_id`, `user_id`) VALUES
(2, '913e703a-151d-11ed-9585-d4d2528b454d'),
(5, '913e703a-151d-11ed-9585-d4d2528b454d'),
(1, '913e703a-151d-11ed-9585-d4d2528b454d'),
(3, '913e703a-151d-11ed-9585-d4d2528b454d'),
(4, '913e703a-151d-11ed-9585-d4d2528b454d'),
(6, '913e703a-151d-11ed-9585-d4d2528b454d'),
(7, '913e703a-151d-11ed-9585-d4d2528b454d');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(32, 30, 'Mahasiswa', 'master/mahasiswa', '1', 'fa fa-users', 4),
(33, 30, 'Dosen', 'master/dosen', '1', 'fa fa-users', 3),
(34, 30, 'Sumber Dana', 'master/dana', '1', 'fa fa-file', 6),
(35, 30, 'Program Studi', 'master/prodi', '1', 'fa fa-building', 2),
(36, 0, 'Transaksi', 'transaksi/all', '1', 'fa fa-calendar', 4),
(37, 0, 'UNIMUDA', 'mahasiswa/all', '1', 'fa fa-graduation-cap', 3),
(38, 36, 'Rekap', 'transaksi/rekap', '1', 'fa fa-undo', 2),
(39, 15, 'Navigasi', 'konten/navigasi', '1', 'fa fa-list', 1),
(40, 15, 'Galeri', 'konten/galeri', '1', 'fa fa-image', 6),
(41, 15, 'Kutipan', 'konten/kutipan', '1', 'fa fa-book', 8),
(42, 30, 'Rincian', 'master/rincian', '1', 'fa fa-check-square-o', 7),
(43, 30, 'Semester', 'master/semester', '1', 'fa fa-exchange', 1),
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `yk_menu_aksi`
--

INSERT INTO `yk_menu_aksi` (`id_menu_aksi`, `id_menu`, `id_aksi`) VALUES
('205c78ee-4b9f-11ed-82ca-525400802704', 58, 1),
('205c8302-4b9f-11ed-82ca-525400802704', 58, 3),
('205c89f9-4b9f-11ed-82ca-525400802704', 58, 5),
('205c9000-4b9f-11ed-82ca-525400802704', 58, 6),
('205c99d0-4b9f-11ed-82ca-525400802704', 58, 7),
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
('a716651e-151a-11ed-9585-d4d2528b454d', 32, 5),
('a7166862-151a-11ed-9585-d4d2528b454d', 32, 6),
('a71669ec-151a-11ed-9585-d4d2528b454d', 32, 7),
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
('a7174c58-151a-11ed-9585-d4d2528b454d', 43, 5),
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
  `msg_notif` text,
  `buat_notif` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `link_notif` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `is_unique` tinyint(1) NOT NULL DEFAULT '0',
  `access_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `buat_user` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_user` datetime DEFAULT NULL,
  `log_user` varchar(50) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `ip_user` varchar(100) DEFAULT NULL,
  `foto_user` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `yk_user`
--

INSERT INTO `yk_user` (`id_user`, `id_group`, `fullname`, `username`, `email`, `password`, `status_user`, `buat_user`, `update_user`, `log_user`, `last_login`, `ip_user`, `foto_user`) VALUES
('913e6b48-151d-11ed-9585-d4d2528b454d', 2, 'Operator Website', 'oppmb', 'info@unimudasorong.ac.id', '$2y$10$Vy26x7dVhrEHsdImV7JK/.dOlj5xHUEWdryPKZthQW48T1EVfDwYC', '1', '2018-12-17 09:01:12', '2019-02-22 15:44:52', 'Operator Website Login Sistem', '2021-03-24 19:46:27', '182.2.198.5 | Desktop  - Windows 10 | Chrome 89.0.4389.90', 'app/upload/profil/operator-website-szqn.png'),
('913e703a-151d-11ed-9585-d4d2528b454d', 1, 'Administrator', 'admin', 'galihbayu17@gmail.com', '$2y$10$N010YC5ydWwayt9GkL0wN.AijJy8osU4mZDyN1AllhSGImuOX3/ty', '1', '2017-07-18 05:12:37', '2022-07-28 16:31:44', 'Administrator Login Sistem', '2023-05-12 17:07:56', '::1 | Desktop  - Linux | Chrome 112.0.0.0', 'app/upload/profil/administrator-rc5p.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `yk_user_log`
--

CREATE TABLE `yk_user_log` (
  `user_id` char(36) NOT NULL,
  `ip_log` varchar(100) DEFAULT NULL,
  `buat_log` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `msg_log` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_creator`
--
ALTER TABLE `m_creator`
  ADD PRIMARY KEY (`id_creator`);

--
-- Indexes for table `m_komen`
--
ALTER TABLE `m_komen`
  ADD PRIMARY KEY (`id_komen`);

--
-- Indexes for table `m_room`
--
ALTER TABLE `m_room`
  ADD PRIMARY KEY (`id_room`);

--
-- Indexes for table `m_topik`
--
ALTER TABLE `m_topik`
  ADD PRIMARY KEY (`id_topik`);

--
-- Indexes for table `m_video`
--
ALTER TABLE `m_video`
  ADD PRIMARY KEY (`id_video`);

--
-- Indexes for table `rf_artikel`
--
ALTER TABLE `rf_artikel`
  ADD PRIMARY KEY (`id_artikel`),
  ADD KEY `jenis_artikel` (`jenis_id`);

--
-- Indexes for table `rf_file`
--
ALTER TABLE `rf_file`
  ADD PRIMARY KEY (`id_file`);

--
-- Indexes for table `rf_galeri`
--
ALTER TABLE `rf_galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `rf_jenis_artikel`
--
ALTER TABLE `rf_jenis_artikel`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `rf_kutipan`
--
ALTER TABLE `rf_kutipan`
  ADD PRIMARY KEY (`id_kutipan`);

--
-- Indexes for table `rf_nav`
--
ALTER TABLE `rf_nav`
  ADD PRIMARY KEY (`id_nav`);

--
-- Indexes for table `rf_page`
--
ALTER TABLE `rf_page`
  ADD PRIMARY KEY (`id_page`);

--
-- Indexes for table `yk_aksi`
--
ALTER TABLE `yk_aksi`
  ADD PRIMARY KEY (`id_aksi`);

--
-- Indexes for table `yk_aplikasi`
--
ALTER TABLE `yk_aplikasi`
  ADD PRIMARY KEY (`id_aplikasi`);

--
-- Indexes for table `yk_group`
--
ALTER TABLE `yk_group`
  ADD PRIMARY KEY (`id_group`);

--
-- Indexes for table `yk_group_menu_aksi`
--
ALTER TABLE `yk_group_menu_aksi`
  ADD KEY `id_group` (`id_group`),
  ADD KEY `id_menu_aksi` (`id_menu_aksi`);

--
-- Indexes for table `yk_group_role`
--
ALTER TABLE `yk_group_role`
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `yk_menu`
--
ALTER TABLE `yk_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `yk_menu_aksi`
--
ALTER TABLE `yk_menu_aksi`
  ADD PRIMARY KEY (`id_menu_aksi`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_aksi` (`id_aksi`);

--
-- Indexes for table `yk_notif`
--
ALTER TABLE `yk_notif`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `send_id` (`send_id`),
  ADD KEY `from_id` (`from_id`);

--
-- Indexes for table `yk_site_log`
--
ALTER TABLE `yk_site_log`
  ADD PRIMARY KEY (`site_log_id`);

--
-- Indexes for table `yk_user`
--
ALTER TABLE `yk_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_group` (`id_group`);

--
-- Indexes for table `yk_user_log`
--
ALTER TABLE `yk_user_log`
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rf_artikel`
--
ALTER TABLE `rf_artikel`
  MODIFY `id_artikel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rf_file`
--
ALTER TABLE `rf_file`
  MODIFY `id_file` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rf_galeri`
--
ALTER TABLE `rf_galeri`
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rf_jenis_artikel`
--
ALTER TABLE `rf_jenis_artikel`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `rf_kutipan`
--
ALTER TABLE `rf_kutipan`
  MODIFY `id_kutipan` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rf_nav`
--
ALTER TABLE `rf_nav`
  MODIFY `id_nav` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rf_page`
--
ALTER TABLE `rf_page`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `yk_aksi`
--
ALTER TABLE `yk_aksi`
  MODIFY `id_aksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `yk_aplikasi`
--
ALTER TABLE `yk_aplikasi`
  MODIFY `id_aplikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `yk_group`
--
ALTER TABLE `yk_group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `yk_menu`
--
ALTER TABLE `yk_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `rf_artikel`
--
ALTER TABLE `rf_artikel`
  ADD CONSTRAINT `rf_artikel_ibfk_1` FOREIGN KEY (`jenis_id`) REFERENCES `rf_jenis_artikel` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
