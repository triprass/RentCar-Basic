-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Des 2020 pada 13.33
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rental_mobil`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank`
--

CREATE TABLE `bank` (
  `id_bank` int(11) NOT NULL,
  `kode_bank` char(9) NOT NULL,
  `nama_bank` varchar(50) NOT NULL,
  `logo_bank` varchar(200) NOT NULL DEFAULT 'bank_default.png',
  `no_rekening` varchar(30) NOT NULL,
  `nama_rekening` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bank`
--

INSERT INTO `bank` (`id_bank`, `kode_bank`, `nama_bank`, `logo_bank`, `no_rekening`, `nama_rekening`) VALUES
(26, 'B0001', 'BANK NASIONAL INDONESIA', '1200px-BNI_logo.svg.png', '334454545', 'Setiawan Dimas Arimurti'),
(29, 'B0027', 'BANK CENTRAL ASIA', 'bca.png', '3245454532', 'Setiawan Dimas Arimurti'),
(30, 'B0030', 'BANK RAKYAK INDONESIA', 'bank bri.png', '4545499912892', 'Setiawan Dimas Arimurti'),
(31, 'B0031', 'Mandiri', 'Mandiri_logo.png', '9823100928', 'Setiawan Dimas Arimurti');

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_sewa`
--

CREATE TABLE `biaya_sewa` (
  `id_biaya_sewa` int(11) NOT NULL,
  `id_mobil` int(11) NOT NULL,
  `biaya_sewa` bigint(20) NOT NULL,
  `biaya_supir` bigint(11) NOT NULL DEFAULT 0,
  `biaya_bbm` bigint(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `biaya_sewa`
--

INSERT INTO `biaya_sewa` (`id_biaya_sewa`, `id_mobil`, `biaya_sewa`, `biaya_supir`, `biaya_bbm`) VALUES
(173, 35, 250000, 7800, 67000),
(176, 34, 256000, 78787, 78888),
(177, 33, 256000, 100000, 100000),
(182, 38, 13000, 5000, 150000),
(183, 37, 9000, 2000, 150000),
(184, 39, 7800, 5000, 4000),
(186, 57, 150002, 75007676, 200000),
(191, 54, 12000, 4500, 250000),
(192, 53, 16000, 4500, 300000),
(194, 52, 14000, 3000, 78000),
(195, 0, 45000, 8900, 89000),
(201, 58, 16000, 6000, 300000),
(204, 46, 11500, 4000, 150000),
(205, 44, 13500, 4500, 200000),
(206, 43, 13000, 4200, 200000),
(209, 56, 14000, 5000, 300000),
(210, 47, 13000, 4000, 200000),
(211, 42, 13800, 5200, 250000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `kode_transaksi` varchar(10) NOT NULL,
  `id_mobil` int(11) NOT NULL,
  `mulai_sewa` datetime NOT NULL DEFAULT current_timestamp(),
  `akhir_sewa` datetime NOT NULL,
  `lama_sewa` int(11) NOT NULL,
  `supir` int(11) NOT NULL,
  `bbm` int(11) NOT NULL,
  `total_biaya` mediumint(11) NOT NULL,
  `denda` mediumint(9) NOT NULL,
  `status_penyewaan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `kode_transaksi`, `id_mobil`, `mulai_sewa`, `akhir_sewa`, `lama_sewa`, `supir`, `bbm`, `total_biaya`, `denda`, `status_penyewaan`) VALUES
(291, '201215223', 39, '2020-12-19 19:41:00', '2020-12-21 19:41:00', 48, 1, 0, 614400, 0, 0),
(295, '201215224', 38, '2020-12-22 22:19:00', '2020-12-24 22:19:00', 48, 1, 0, 624000, 0, 2),
(300, '201215224', 37, '2020-12-19 00:00:00', '2020-12-20 00:00:00', 24, 1, 0, 264000, 0, 1),
(301, '201215223', 44, '2020-12-19 23:04:00', '2020-12-20 23:04:00', 24, 0, 0, 324000, 0, 0),
(302, '20121701', 38, '2020-12-26 22:54:00', '2020-12-27 22:54:00', 24, 1, 1, 462000, 0, 1),
(303, '20121701', 46, '2020-12-18 08:05:00', '2020-12-20 08:05:00', 48, 1, 0, 744000, 0, 2),
(304, '20121801', 37, '2020-12-16 20:37:00', '2020-12-18 20:37:00', 48, 1, 0, 528000, 0, 0),
(305, '201218229', 46, '2020-12-11 20:39:00', '2020-12-13 20:39:00', 48, 1, 0, 744000, 0, 0),
(306, '201218230', 42, '2020-12-19 20:41:00', '2020-12-22 20:41:00', 72, 0, 1, 1243600, 0, 0),
(307, '201218231', 47, '2020-12-18 20:41:00', '2020-12-20 20:41:00', 48, 1, 0, 816000, 0, 0),
(308, '201218232', 42, '2020-12-17 20:40:00', '2020-12-18 20:40:00', 24, 0, 0, 331200, 0, 0),
(309, '201218233', 46, '2020-12-16 20:41:00', '2020-12-17 20:41:00', 24, 1, 0, 372000, 0, 0),
(310, '201218234', 42, '2020-12-23 20:42:00', '2020-12-25 20:42:00', 48, 1, 0, 902400, 0, 0),
(313, '201218235', 46, '2020-12-26 20:49:00', '2020-12-27 20:49:00', 24, 0, 0, 276000, 0, 2),
(314, '201218235', 47, '2020-12-24 20:49:00', '2020-12-25 20:49:00', 24, 0, 0, 312000, 0, 0),
(315, '201218235', 38, '2020-12-09 20:49:00', '2020-12-10 20:49:00', 24, 0, 0, 312000, 0, 0),
(317, '201218235', 44, '2020-12-26 19:27:00', '2020-12-27 19:27:00', 24, 0, 1, 524000, 0, 0),
(319, '201218235', 42, '2020-12-12 19:36:00', '2020-12-13 19:36:00', 24, 1, 0, 456000, 0, 0),
(320, '20121901', 43, '2020-12-12 20:15:00', '2020-12-13 20:15:00', 24, 1, 1, 612800, 0, 1),
(322, '20121901', 42, '2020-12-05 20:21:00', '2020-12-06 20:21:00', 24, 1, 0, 456000, 0, 0),
(323, '201219238', 44, '2020-12-12 21:24:00', '2020-12-13 21:24:00', 24, 0, 0, 324000, 0, 0),
(324, '201219240', 42, '2020-12-27 21:28:00', '2020-12-30 21:28:00', 72, 0, 0, 993600, 0, 0),
(325, '201219241', 58, '2020-12-19 21:43:00', '2020-12-20 21:43:00', 24, 0, 0, 384000, 0, 0),
(326, '201219241', 43, '2020-12-02 21:49:00', '2020-12-03 21:49:00', 24, 1, 0, 412800, 0, 0),
(327, '20122001', 38, '2020-12-19 12:59:00', '2020-12-20 12:59:00', 24, 0, 0, 312000, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_aktivitas` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `aktivitas` varchar(300) NOT NULL,
  `id_pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_aktivitas`, `waktu`, `aktivitas`, `id_pengguna`) VALUES
(132, '2020-09-09 11:34:54', 'Tambah Produk # ', 0),
(133, '2020-09-09 11:35:40', 'Tambah Produk # ', 0),
(134, '2020-09-09 11:40:31', 'Tambah Produk # ', 0),
(136, '2020-09-09 11:43:05', 'Tambah Produk # ', 0),
(137, '2020-09-09 11:46:08', 'Tambah Produk # ', 0),
(138, '2020-09-09 11:47:46', 'Tambah Produk # ', 0),
(139, '2020-09-09 11:50:12', 'Tambah Produk # ', 0),
(140, '2020-09-09 11:50:47', 'Tambah Produk # ', 0),
(141, '2020-09-09 11:54:52', 'Tambah Produk # ', 0),
(142, '2020-09-09 01:33:17', 'Tambah Produk # ', 0),
(143, '2020-09-09 07:01:04', 'Hapus mobil #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistmobilhapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(144, '2020-09-09 07:01:09', 'Hapus mobil #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistmobilhapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(145, '2020-09-09 07:01:12', 'Hapus mobil #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistmobilhapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(146, '2020-09-09 07:02:16', 'Hapus mobil #M0009 ', 0),
(147, '2020-09-09 07:05:41', 'Hapus mobil #M0008 ', 0),
(148, '2020-09-09 07:05:50', 'Hapus mobil #M0001 ', 0),
(149, '2020-09-09 07:05:59', 'Hapus mobil #M0002 ', 0),
(150, '2020-09-09 07:32:51', 'Edit mobil #M0005 ', 0),
(151, '2020-09-09 07:32:59', 'Edit mobil #M0007 ', 0),
(152, '2020-09-09 07:33:15', 'Edit mobil #M0007 ', 0),
(153, '2020-09-09 07:35:55', 'Edit mobil #M0007 ', 0),
(154, '2020-09-09 07:36:06', 'Edit mobil #M0007 ', 0),
(155, '2020-09-09 08:01:01', 'Tambah Produk # ', 0),
(156, '2020-09-09 08:01:13', 'Edit mobil #M0008 ', 0),
(157, '2020-09-09 08:01:25', 'Edit mobil #M0008 ', 0),
(158, '2020-09-09 08:15:32', 'Tambah Pelanggan #PN0019 ', 0),
(159, '2020-09-09 08:16:43', 'Tambah Pelanggan #PN0023 ', 0),
(160, '2020-09-09 08:18:03', 'Tambah Pelanggan #PN0024 ', 0),
(161, '2020-09-09 08:18:25', 'Tambah Pelanggan #PN0025 ', 0),
(162, '2020-09-09 09:23:30', 'Hapus pelanggan #PN0025 ', 0),
(163, '2020-09-09 09:23:33', 'Hapus pelanggan #PN0024 ', 0),
(164, '2020-09-09 09:23:36', 'Hapus pelanggan #PN0023 ', 0),
(165, '2020-09-09 09:23:38', 'Hapus pelanggan #PN0019 ', 0),
(166, '2020-09-09 09:26:11', 'Edit Pelanggan #PN0018 ', 0),
(167, '2020-09-09 09:26:31', 'Tambah Pelanggan #PN0019 ', 0),
(168, '2020-09-09 09:26:34', 'Hapus pelanggan #PN0019 ', 0),
(169, '2020-09-09 09:26:37', 'Hapus pelanggan #PN0018 ', 0),
(170, '2020-09-09 09:39:35', 'Hapus mobil #M0008 ', 0),
(171, '2020-09-09 09:39:38', 'Hapus mobil #M0007 ', 0),
(172, '2020-09-09 09:39:44', 'Edit mobil #M0005 ', 0),
(173, '2020-09-09 09:49:54', 'Hapus pelanggan #P0007 ', 0),
(174, '2020-09-10 10:34:09', 'Edit mobil #M0005 ', 0),
(175, '2020-09-10 02:02:14', 'Edit mobil #M0005 ', 0),
(176, '2020-09-10 11:09:17', 'Edit mobil #M0004 ', 0),
(177, '2020-09-11 08:07:40', 'Hapus mobil #M0003 ', 0),
(178, '2020-09-11 08:07:43', 'Hapus mobil #M0004 ', 0),
(179, '2020-09-11 11:57:47', 'Tambah Produk # ', 0),
(180, '2020-09-11 10:01:26', 'Tambah Produk # ', 0),
(181, '2020-09-11 10:01:56', 'Edit mobil #M0015 ', 0),
(182, '2020-09-11 11:03:09', 'Tambah Produk # ', 0),
(183, '2020-09-11 11:03:53', 'Tambah Produk # ', 0),
(184, '2020-09-11 11:06:47', 'Hapus mobil #M0005 ', 0),
(185, '2020-09-11 11:06:50', 'Hapus mobil #M0007 ', 0),
(186, '2020-09-11 11:06:52', 'Hapus mobil #M0015 ', 0),
(187, '2020-09-11 11:06:55', 'Hapus mobil #M0016 ', 0),
(188, '2020-09-11 11:06:57', 'Hapus mobil #M0017 ', 0),
(189, '2020-09-11 11:07:51', 'Tambah Produk # ', 0),
(190, '2020-09-11 11:35:00', 'Edit mobil #M0001 ', 0),
(191, '2020-09-11 11:37:37', 'Tambah Produk # ', 0),
(192, '2020-09-12 10:07:35', 'Hapus mobil #M0001 ', 0),
(193, '2020-09-12 10:10:08', 'Tambah Produk # ', 0),
(194, '2020-09-12 10:10:56', 'Tambah Produk # ', 0),
(195, '2020-09-12 11:50:15', 'Hapus pengaturan sewa #M0020 ', 0),
(196, '2020-09-12 11:50:28', 'Hapus pengaturan sewa #M0019 ', 0),
(197, '2020-09-12 11:51:26', 'Hapus pengaturan sewa #M0019 ', 0),
(198, '2020-09-12 11:51:32', 'Hapus pengaturan sewa #M0019 ', 0),
(199, '2020-09-12 11:54:14', 'Hapus pengaturan sewa #M0020 ', 0),
(200, '2020-09-12 11:54:17', 'Hapus pengaturan sewa #M0021 ', 0),
(201, '2020-09-12 11:54:18', 'Hapus pengaturan sewa #M0019 ', 0),
(202, '2020-09-12 12:03:16', 'Hapus pengaturan sewa #M0021 ', 0),
(203, '2020-09-12 12:35:42', 'Hapus pengaturan sewa #M0021 ', 0),
(204, '2020-09-12 12:37:20', 'Hapus pengaturan sewa #M0019 ', 0),
(205, '2020-09-12 12:37:22', 'Hapus pengaturan sewa #M0020 ', 0),
(206, '2020-09-12 12:37:24', 'Hapus pengaturan sewa #M0021 ', 0),
(207, '2020-09-12 12:52:56', 'Hapus pengaturan sewa #M0021 ', 0),
(208, '2020-09-12 02:28:23', 'Hapus pengaturan sewa #M0020 ', 0),
(209, '2020-09-12 02:56:58', 'Hapus pengaturan sewa #M0021 ', 0),
(210, '2020-09-12 02:58:36', 'Hapus pengaturan sewa #M0020 ', 0),
(211, '2020-09-12 03:16:06', 'Hapus pengaturan sewa #M0019 ', 0),
(212, '2020-09-12 03:16:08', 'Hapus pengaturan sewa #M0021 ', 0),
(213, '2020-09-12 03:16:10', 'Hapus pengaturan sewa #M0020 ', 0),
(214, '2020-09-12 03:17:36', 'Hapus pengaturan sewa #M0021 ', 0),
(215, '2020-09-12 03:22:26', 'Hapus pengaturan sewa #M0020 ', 0),
(216, '2020-09-12 03:22:28', 'Hapus pengaturan sewa #M0020 ', 0),
(217, '2020-09-12 03:22:46', 'Hapus pengaturan sewa #M0021 ', 0),
(218, '2020-09-12 06:29:44', 'Hapus pengaturan sewa #M0021 ', 0),
(219, '2020-09-12 06:31:13', 'Hapus pengaturan sewa #M0021 ', 0),
(220, '2020-09-12 08:45:44', 'Hapus pengaturan sewa #M0021 ', 0),
(221, '2020-09-12 08:52:06', 'Hapus pengaturan sewa #M0021 ', 0),
(222, '2020-09-14 10:15:42', 'Hapus pengaturan sewa #M0021 ', 0),
(223, '2020-09-14 10:15:44', 'Hapus pengaturan sewa #M0020 ', 0),
(224, '2020-09-14 10:16:23', 'Hapus pengaturan sewa #M0019 ', 0),
(225, '2020-09-16 03:02:13', 'Hapus pengaturan sewa #M0021 ', 0),
(228, '2020-09-16 09:36:06', 'Tambah Bank #B0001 ', 0),
(229, '2020-09-16 09:37:16', 'Tambah Bank #B0002 ', 0),
(230, '2020-09-16 09:39:36', 'Tambah Bank #B0003 ', 0),
(231, '2020-09-16 09:40:08', 'Hapus bank #B0003 ', 0),
(232, '2020-09-16 09:41:18', 'Tambah Bank #B0003 ', 0),
(242, '2020-09-16 09:56:31', 'Edit bank #B0003 ', 0),
(243, '2020-09-17 11:21:19', 'Edit bank #B0003 ', 0),
(244, '2020-09-17 11:21:25', 'Hapus bank #B00 ', 0),
(245, '2020-09-17 11:21:27', 'Hapus bank #B00 ', 0),
(246, '2020-09-17 11:24:21', 'Tambah Bank #B0005 ', 0),
(247, '2020-09-17 11:27:01', 'Hapus bank #B0005 ', 0),
(248, '2020-09-17 11:27:26', 'Tambah Bank #B0005 ', 0),
(249, '2020-09-17 11:30:33', 'Hapus bank #B0003 ', 0),
(250, '2020-09-17 11:55:11', 'Tambah Bank #B0007 ', 0),
(251, '2020-09-17 11:55:28', 'Hapus bank #B0007 ', 0),
(252, '2020-09-17 11:55:32', 'Tambah Bank #B0007 ', 0),
(253, '2020-09-17 11:59:16', 'Tambah Bank #B0009 ', 0),
(254, '2020-09-17 01:18:11', 'Tambah Bank #B0010 ', 0),
(255, '2020-09-17 01:27:52', 'Hapus bank #B0010 ', 0),
(256, '2020-09-17 02:20:51', 'Hapus bank #B0007 ', 0),
(257, '2020-09-17 02:43:19', 'Tambah Bank #B0010 ', 0),
(258, '2020-09-17 02:43:25', 'Hapus bank #B0010 ', 0),
(259, '2020-09-17 02:46:57', 'Hapus bank #B0009 ', 0),
(260, '2020-09-17 02:47:12', 'Hapus bank #B0005 ', 0),
(261, '2020-09-17 02:47:30', 'Tambah Bank #B0001 ', 0),
(262, '2020-09-17 02:48:11', 'Hapus bank #B0001 ', 0),
(263, '2020-09-17 07:14:01', 'Tambah Bank #B0001 ', 0),
(264, '2020-09-17 07:14:26', 'Edit bank #B0001 ', 0),
(265, '2020-09-18 01:23:40', 'Login', 16),
(266, '2020-09-18 01:27:43', 'Logout', 16),
(267, '2020-09-18 01:28:06', 'Login', 15),
(268, '2020-09-18 01:28:55', 'Logout', 15),
(269, '2020-09-18 01:29:10', 'Login', 16),
(270, '2020-09-18 01:32:41', 'Tambah Bank #B0014 ', 0),
(271, '2020-09-18 01:42:14', 'Edit bank #B0014 ', 0),
(272, '2020-09-18 08:18:10', 'Login', 16),
(273, '2020-09-18 08:31:43', 'Edit bank #B0014 ', 0),
(274, '2020-09-18 08:31:59', 'Edit bank #B0014 ', 0),
(275, '2020-09-18 08:32:42', 'Edit bank #B0014 ', 0),
(276, '2020-09-18 08:32:54', 'Edit bank #B0014 ', 0),
(278, '2020-09-18 08:34:14', 'Edit bank #B0014 ', 0),
(279, '2020-09-18 08:35:54', 'Edit bank #B0014 ', 0),
(283, '2020-09-18 08:39:19', 'Edit bank #B0014 ', 0),
(284, '2020-09-18 08:43:17', 'Tambah Bank #B0015 ', 0),
(285, '2020-09-18 08:43:31', 'Tambah Bank #B0016 ', 0),
(286, '2020-09-18 08:43:48', 'Edit bank #B0016 ', 0),
(287, '2020-09-18 08:43:51', 'Hapus bank #B0015 ', 0),
(289, '2020-09-18 08:44:23', 'Edit bank #B0016 ', 0),
(290, '2020-09-18 08:46:03', 'Tambah Bank #B0017 ', 0),
(291, '2020-09-18 08:46:09', 'Hapus bank #B0017 ', 0),
(292, '2020-09-18 08:46:19', 'Hapus bank #B0016 ', 0),
(293, '2020-09-18 08:48:02', 'Hapus bank #B0014 ', 0),
(294, '2020-09-18 08:48:16', 'Edit bank #B0001 ', 0),
(295, '2020-09-18 08:48:21', 'Hapus bank #B0001 ', 0),
(296, '2020-09-18 08:49:17', 'Tambah Bank #B0001 ', 0),
(297, '2020-09-18 08:49:25', 'Edit bank #B0001 ', 0),
(298, '2020-09-18 08:49:48', 'Hapus bank #B0001 ', 0),
(299, '2020-09-18 08:52:19', 'Tambah Bank #B0001 ', 0),
(300, '2020-09-18 08:52:21', 'Hapus bank #B0001 ', 0),
(301, '2020-09-18 08:52:58', 'Tambah Bank #B0001 ', 0),
(303, '2020-09-18 08:54:49', 'Tambah Bank #B0021 ', 0),
(309, '2020-09-18 08:57:18', 'Hapus bank #B0021 ', 0),
(310, '2020-09-18 08:57:21', 'Hapus bank #B0001 ', 0),
(311, '2020-09-18 08:58:16', 'Tambah Bank #B0001 ', 0),
(312, '2020-09-18 08:58:20', 'Hapus bank #B0001 ', 0),
(313, '2020-09-18 09:12:12', 'Tambah Bank #B0001 ', 0),
(314, '2020-09-18 09:12:29', 'Hapus bank #B0001 ', 0),
(315, '2020-09-18 09:12:50', 'Tambah Bank #B0001 ', 0),
(316, '2020-09-18 09:12:54', 'Hapus bank #B0001 ', 0),
(317, '2020-09-18 10:07:18', 'Tambah Produk # ', 0),
(318, '2020-09-18 10:14:19', 'Edit mobil #M0020 ', 0),
(319, '2020-09-18 10:14:46', 'Edit mobil #M0019 ', 0),
(320, '2020-09-18 10:15:11', 'Edit mobil #M0020 ', 0),
(321, '2020-09-18 10:16:54', 'Edit mobil #M0022 ', 0),
(322, '2020-09-18 10:17:06', 'Edit mobil #M0022 ', 0),
(323, '2020-09-18 10:21:42', 'Hapus mobil #M0022 ', 0),
(324, '2020-09-18 10:24:23', 'Tambah Bank #B0001 ', 0),
(325, '2020-09-18 10:24:32', 'Edit bank #B0001 ', 0),
(326, '2020-09-18 10:25:42', 'Hapus bank #B0001 ', 0),
(327, '2020-09-18 10:26:04', 'Tambah Bank #B0001 ', 0),
(328, '2020-09-18 10:39:34', 'Edit mobil #M0019 ', 0),
(329, '2020-09-18 10:39:40', 'Edit mobil #M0019 ', 0),
(330, '2020-09-18 10:40:09', 'Edit mobil #M0019 ', 0),
(331, '2020-09-18 10:40:13', 'Edit mobil #M0020 ', 0),
(332, '2020-09-19 09:23:17', 'Login', 16),
(333, '2020-09-19 09:24:18', 'Edit mobil #M0021 ', 0),
(336, '2020-09-19 10:00:22', 'Tambah Merek #A0001 ', 0),
(337, '2020-09-19 02:35:24', 'Login', 16),
(338, '2020-09-19 02:36:54', 'Tambah Merek #A0002 ', 0),
(339, '2020-09-19 02:38:31', 'Tambah Merek #A0003 ', 0),
(340, '2020-09-19 02:47:08', 'Logout', 16),
(341, '2020-09-19 02:47:14', 'Login', 16),
(342, '2020-09-19 02:53:21', 'Login', 16),
(343, '2020-09-19 03:47:27', 'Hapus pengaturan sewa #M0019 ', 0),
(344, '2020-09-19 03:47:31', 'Hapus pengaturan sewa #M0020 ', 0),
(345, '2020-09-19 03:47:34', 'Hapus pengaturan sewa #M0021 ', 0),
(346, '2020-09-20 08:29:28', 'Login', 16),
(347, '2020-09-20 08:30:14', 'Edit mobil #M0021 ', 0),
(349, '2020-09-20 08:34:38', 'Tambah Merek #A0004 ', 0),
(350, '2020-09-20 08:34:58', 'Tambah Merek #A0005 ', 0),
(351, '2020-09-20 08:35:57', 'Tambah Merek #A0006 ', 0),
(352, '2020-09-20 08:36:37', 'Tambah Merek #A0007 ', 0),
(353, '2020-09-20 08:37:24', 'Tambah Merek #A0008 ', 0),
(354, '2020-09-20 08:38:29', 'Tambah Merek #A0009 ', 0),
(356, '2020-09-20 08:41:19', 'Tambah Merek #A0010 ', 0),
(357, '2020-09-20 08:41:52', 'Tambah Produk # ', 0),
(358, '2020-09-20 10:11:51', 'Hapus pengaturan sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistpengaturan-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(359, '2020-09-20 10:29:39', 'Edit mobil #M0022 ', 0),
(360, '2020-09-21 09:29:47', 'Login', 16),
(361, '2020-09-21 12:35:57', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(362, '2020-09-21 12:35:59', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(363, '2020-09-21 08:13:48', 'Edit mobil #M0022 ', 0),
(364, '2020-09-21 08:17:19', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(365, '2020-09-21 08:17:21', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(366, '2020-09-21 08:17:23', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(367, '2020-09-21 08:17:26', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(368, '2020-09-22 11:45:37', 'Login', 16),
(369, '2020-09-25 11:26:46', 'Login', 16),
(370, '2020-09-25 11:28:37', 'Tambah Merek #A0011 ', 0),
(371, '2020-09-25 07:26:50', 'Tambah Bank # ', 0),
(372, '2020-09-29 07:41:16', 'Login', 16),
(373, '2020-10-01 01:19:35', 'Login', 16),
(374, '2020-10-01 03:18:55', 'Logout', 16),
(375, '2020-10-01 03:19:49', 'Login', 16),
(377, '2020-10-01 03:23:50', 'Tambah Merek #A0012 ', 0),
(378, '2020-10-01 03:24:06', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(379, '2020-10-01 03:24:09', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(380, '2020-10-01 03:24:24', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(381, '2020-10-01 03:24:30', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(382, '2020-10-02 07:52:04', 'Login', 16),
(383, '2020-10-02 02:18:35', 'Login', 16),
(384, '2020-10-02 10:54:38', 'Login', 16),
(385, '2020-10-04 07:28:14', 'Login', 16),
(386, '2020-10-04 07:43:07', 'Tambah Bank #B0028 ', 0),
(387, '2020-10-04 07:43:12', 'Hapus bank #B0028 ', 0),
(388, '2020-10-05 08:24:51', 'Login', 16),
(389, '2020-10-05 10:17:24', 'Hapus bank # ', 0),
(391, '2020-10-05 10:18:18', 'Tambah Merek #A0013 ', 0),
(392, '2020-10-05 10:18:26', 'Hapus mobil #M0022 ', 0),
(393, '2020-10-05 10:18:38', 'Edit mobil #M0021 ', 0),
(394, '2020-10-05 10:18:47', 'Edit mobil #M0021 ', 0),
(395, '2020-10-05 10:18:52', 'Edit mobil #M0021 ', 0),
(396, '2020-10-05 10:18:59', 'Edit mobil #M0021 ', 0),
(397, '2020-10-05 10:21:05', 'Tambah Produk # ', 0),
(398, '2020-10-05 10:31:54', 'Hapus mobil #M0022 ', 0),
(399, '2020-10-05 10:40:30', 'Edit mobil #M0021 ', 0),
(400, '2020-10-05 10:52:08', 'Tambah Merek #A0001 ', 0),
(401, '2020-10-05 10:52:51', 'Tambah Merek #A0001 ', 0),
(402, '2020-10-05 10:53:15', 'Tambah Merek #A0001 ', 0),
(403, '2020-10-05 10:53:33', 'Tambah Merek #A0001 ', 0),
(404, '2020-10-05 11:06:31', 'Edit mobil #M0021 ', 0),
(405, '2020-10-05 12:46:58', 'Tambah Merek #A0001 ', 0),
(406, '2020-10-05 01:08:34', 'Edit bank #B0001 ', 0),
(407, '2020-10-05 01:54:01', 'Edit merek #A0001 ', 0),
(408, '2020-10-05 01:54:41', 'Edit merek #A0001 ', 0),
(409, '2020-10-05 01:55:04', 'Edit merek #A0001 ', 0),
(410, '2020-10-05 01:55:33', 'Edit merek #A0001 ', 0),
(411, '2020-10-05 01:55:38', 'Edit merek #A0001 ', 0),
(412, '2020-10-05 01:55:51', 'Edit merek #A0001 ', 0),
(413, '2020-10-05 02:02:36', 'Tambah Merek #A0019 ', 0),
(414, '2020-10-05 02:04:32', 'Tambah Merek #A0020 ', 0),
(415, '2020-10-05 02:05:06', 'Tambah Merek #A0021 ', 0),
(416, '2020-10-05 02:05:23', 'Tambah Merek #A0022 ', 0),
(417, '2020-10-05 02:06:33', 'Tambah Merek #A0023 ', 0),
(418, '2020-10-05 02:06:47', 'Tambah Merek #A0024 ', 0),
(419, '2020-10-05 02:06:58', 'Tambah Merek #A0025 ', 0),
(420, '2020-10-05 02:07:48', 'Tambah Merek #A0026 ', 0),
(421, '2020-10-05 02:13:12', 'Tambah Produk # ', 0),
(423, '2020-10-05 02:36:51', 'Edit mobil #M0022 ', 0),
(424, '2020-10-05 02:52:25', 'Edit mobil #M0022 ', 0),
(425, '2020-10-05 02:52:42', 'Edit mobil #M0022 ', 0),
(426, '2020-10-05 02:54:29', 'Edit bank #B0001 ', 0),
(427, '2020-10-05 02:54:45', 'Tambah Bank #B0027 ', 0),
(428, '2020-10-05 02:55:05', 'Tambah Bank #B0030 ', 0),
(429, '2020-10-05 02:55:14', 'Edit bank #B0027 ', 0),
(430, '2020-10-05 02:55:25', 'Edit bank #B0001 ', 0),
(431, '2020-10-05 02:55:49', 'Tambah Bank #B0031 ', 0),
(432, '2020-10-05 02:56:18', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(433, '2020-10-05 02:56:21', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(434, '2020-10-05 02:59:04', 'Tambah Produk # ', 0),
(435, '2020-10-05 08:20:23', 'Login', 16),
(436, '2020-10-05 08:26:12', 'Edit mobil #M0026 ', 0),
(437, '2020-10-05 10:27:58', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(438, '2020-10-05 10:36:33', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(439, '2020-10-05 10:37:02', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(440, '2020-10-05 10:37:36', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(441, '2020-10-05 11:23:10', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(442, '2020-10-05 11:25:57', 'Edit mobil #M0026 ', 0),
(443, '2020-10-05 11:41:13', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(444, '2020-10-06 09:12:21', 'Login', 16),
(445, '2020-10-06 10:05:00', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(446, '2020-10-06 09:09:24', 'Login', 16),
(447, '2020-10-06 10:30:11', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(448, '2020-10-06 10:36:08', 'Logout', 16),
(449, '2020-10-07 08:44:21', 'Login', 16),
(450, '2020-10-07 02:20:03', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(451, '2020-10-07 02:20:06', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(452, '2020-10-07 02:27:27', 'Edit mobil #M0026 ', 0),
(453, '2020-10-08 08:15:35', 'Login', 16),
(454, '2020-10-08 01:46:27', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(455, '2020-10-08 02:51:30', 'Login', 16),
(456, '2020-10-08 05:49:15', 'Login', 16),
(457, '2020-10-08 09:10:20', 'Login', 16),
(458, '2020-10-09 06:59:08', 'Login', 16),
(459, '2020-10-12 07:29:09', 'Login', 16),
(460, '2020-10-13 09:34:05', 'Login', 16),
(461, '2020-10-13 07:32:29', 'Login', 16),
(462, '2020-10-13 11:00:55', 'Tambah Produk # ', 0),
(463, '2020-10-13 11:02:38', 'Tambah Produk # ', 0),
(464, '2020-10-13 11:04:18', 'Tambah Produk # ', 0),
(465, '2020-10-13 11:06:02', 'Tambah Produk # ', 0),
(466, '2020-10-13 11:07:10', 'Tambah Produk # ', 0),
(467, '2020-10-13 11:08:10', 'Tambah Produk # ', 0),
(468, '2020-10-13 11:08:19', 'Edit mobil #M0032 ', 0),
(469, '2020-10-13 11:08:25', 'Edit mobil #M0031 ', 0),
(470, '2020-10-13 11:08:30', 'Edit mobil #M0030 ', 0),
(471, '2020-10-13 11:08:35', 'Edit mobil #M0029 ', 0),
(472, '2020-10-13 11:08:40', 'Edit mobil #M0028 ', 0),
(473, '2020-10-13 11:08:47', 'Edit mobil #M0027 ', 0),
(474, '2020-10-13 11:09:53', 'Tambah Produk # ', 0),
(475, '2020-10-13 11:10:47', 'Tambah Produk # ', 0),
(476, '2020-10-13 11:11:33', 'Tambah Produk # ', 0),
(477, '2020-10-14 08:24:48', 'Login', 16),
(478, '2020-10-14 07:19:48', 'Login', 16),
(479, '2020-10-24 06:50:20', 'Login', 16),
(480, '2020-11-12 06:19:39', 'Login', 16),
(481, '2020-11-15 08:29:52', 'Login', 16),
(482, '2020-11-16 01:58:40', 'Login', 16),
(483, '2020-11-16 02:40:30', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(484, '2020-11-16 02:40:32', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(485, '2020-11-16 02:40:34', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(486, '2020-11-16 02:40:37', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(487, '2020-11-16 03:14:22', 'Edit bank #B0031 ', 0),
(488, '2020-11-16 04:57:10', 'Login', 16),
(489, '2020-11-16 04:58:32', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(490, '2020-11-16 05:00:03', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(491, '2020-11-16 05:04:19', 'Edit bank #B0031 ', 0),
(497, '2020-11-16 06:07:50', 'Edit Biaya ID #173 ', 0),
(498, '2020-11-16 06:08:07', 'Edit Biaya ID #173 ', 0),
(499, '2020-11-16 06:11:30', 'Edit Biaya ID #176 ', 0),
(500, '2020-11-16 06:11:38', 'Edit Biaya ID #176 ', 0),
(501, '2020-11-16 06:11:47', 'Edit Biaya ID #176 ', 0),
(502, '2020-11-16 06:27:55', 'Edit Biaya ID #177 ', 0),
(503, '2020-11-16 08:06:29', 'Edit mobil #M0035 ', 0),
(504, '2020-11-16 08:07:02', 'Edit mobil #M0035 ', 0),
(505, '2020-11-16 08:07:09', 'Edit mobil #M0035 ', 0),
(506, '2020-11-16 08:16:25', 'Tambah Produk # ', 0),
(507, '2020-11-16 08:21:29', 'Edit mobil #M0036 ', 0),
(508, '2020-11-16 08:22:55', 'Edit mobil #M0036 ', 0),
(509, '2020-11-16 08:23:14', 'Edit mobil #M0035 ', 0),
(510, '2020-11-16 08:23:25', 'Edit mobil #M0032 ', 0),
(511, '2020-11-16 08:23:35', 'Edit mobil #M0031 ', 0),
(512, '2020-11-16 08:23:43', 'Edit mobil #M0026 ', 0),
(513, '2020-11-16 08:23:48', 'Edit mobil #M0022 ', 0),
(514, '2020-11-16 08:23:59', 'Edit mobil #M0030 ', 0),
(515, '2020-11-16 08:24:05', 'Edit mobil #M0029 ', 0),
(516, '2020-11-16 08:24:10', 'Edit mobil #M0028 ', 0),
(517, '2020-11-16 08:24:16', 'Edit mobil #M0031 ', 0),
(518, '2020-11-16 08:24:37', 'Hapus mobil #M0036 ', 0),
(519, '2020-11-16 08:25:26', 'Edit Biaya ID #177 ', 0),
(520, '2020-11-16 08:40:24', 'Tambah Produk # ', 0),
(521, '2020-11-16 08:40:57', 'Tambah Produk # ', 0),
(522, '2020-11-16 09:19:46', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(523, '2020-11-16 09:19:48', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(524, '2020-11-16 09:24:21', 'Edit Biaya ID #180 ', 0),
(525, '2020-11-16 09:32:11', 'Edit Biaya ID #180 ', 0),
(526, '2020-11-16 10:40:21', 'Edit Biaya ID #181 ', 0),
(527, '2020-11-16 10:40:27', 'Edit Biaya ID #180 ', 0),
(528, '2020-11-16 11:27:44', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(529, '2020-11-16 11:27:56', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(530, '2020-11-16 11:46:16', 'Edit mobil #M0001 ', 0),
(531, '2020-11-17 07:33:52', 'Login', 16),
(532, '2020-11-17 07:34:51', 'Edit mobil #M0038 ', 0),
(533, '2020-11-17 07:35:00', 'Edit mobil #M0038 ', 0),
(534, '2020-11-17 01:30:30', 'Login', 16),
(535, '2020-11-20 04:42:37', 'Login', 16),
(536, '2020-11-23 01:18:11', 'Login', 16),
(537, '2020-11-23 06:28:37', 'Login', 16),
(538, '2020-11-23 06:58:12', 'Logout', 16),
(539, '2020-11-23 06:58:18', 'Login', 16),
(540, '2020-11-24 11:13:21', 'Login', 16),
(541, '2020-11-24 01:03:48', 'Tambah Produk # ', 0),
(542, '2020-11-24 06:55:03', 'Login', 16),
(543, '2020-11-24 07:25:26', 'Edit Profil', 16),
(544, '2020-11-24 07:30:32', 'Edit Profil', 16),
(545, '2020-11-24 07:30:49', 'Edit Profil', 16),
(546, '2020-11-24 07:30:56', 'Edit Profil', 16),
(547, '2020-11-24 07:33:57', 'Logout', 16),
(548, '2020-11-24 07:34:14', 'Login', 16),
(549, '2020-11-24 07:42:27', 'Update Profil Aplikasi', 16),
(550, '2020-11-24 07:43:16', 'Update Profil Aplikasi', 16),
(551, '2020-11-24 07:43:29', 'Update Profil Aplikasi', 16),
(552, '2020-11-24 07:47:36', 'Update Profil Aplikasi', 16),
(553, '2020-11-24 07:52:20', 'Update Profil Aplikasi', 16),
(554, '2020-11-24 09:40:06', 'Update Profil Aplikasi', 16),
(555, '2020-11-24 09:41:03', 'Update Profil Aplikasi', 16),
(556, '2020-11-24 09:41:18', 'Update Profil Aplikasi', 16),
(557, '2020-11-24 09:42:05', 'Update Profil Aplikasi', 16),
(558, '2020-11-24 09:42:28', 'Update Profil Aplikasi', 16),
(559, '2020-11-24 09:44:20', 'Update Profil Aplikasi', 16),
(560, '2020-11-24 09:44:58', 'Update Profil Aplikasi', 16),
(561, '2020-11-24 10:10:55', 'Tambah Merek #A0027 ', 0),
(562, '2020-11-25 08:45:46', 'Login', 16),
(563, '2020-11-25 12:01:21', 'Login', 16),
(564, '2020-11-25 07:17:48', 'Login', 16),
(565, '2020-11-25 09:21:41', 'Login', 15),
(566, '2020-11-25 09:26:54', 'Logout', 16),
(567, '2020-11-25 09:34:30', 'Logout', 15),
(568, '2020-11-25 09:34:33', 'Login', 15),
(569, '2020-11-25 09:35:04', 'Login', 15),
(570, '2020-11-25 09:41:19', 'Login', 16),
(571, '2020-11-25 09:45:11', 'Login', 16),
(572, '2020-11-25 09:45:16', 'Logout', 16),
(573, '2020-11-25 09:47:21', 'Login', 16),
(574, '2020-11-25 09:47:39', 'Logout', 16),
(575, '2020-11-25 09:47:50', 'Login', 16),
(576, '2020-11-25 09:48:41', 'Login', 16),
(577, '2020-11-25 10:02:07', 'Login', 15),
(578, '2020-11-25 10:16:32', 'Edit pengguna  #U017 ', 16),
(579, '2020-11-25 10:18:47', 'Edit pengguna  #U011 ', 16),
(580, '2020-11-25 10:40:05', 'Tambah pengguna #U017 ', 16),
(581, '2020-11-25 10:44:22', 'Edit pengguna  #U017 ', 16),
(582, '2020-11-25 10:44:59', 'Edit pengguna  #U017 ', 16),
(584, '2020-11-25 10:46:05', 'Tambah pengguna #U022 ', 16),
(586, '2020-11-25 10:46:45', 'Tambah pengguna #U023 ', 16),
(587, '2020-11-25 10:46:54', 'Edit pengguna  #U023 ', 16),
(590, '2020-11-25 10:50:20', 'Tambah pengguna #U024 ', 16),
(591, '2020-11-25 10:54:50', 'Edit Profil', 16),
(592, '2020-11-25 11:01:22', 'Tambah Merek #A0027 ', 0),
(593, '2020-11-25 11:01:32', 'Tambah Produk # ', 0),
(594, '2020-11-25 11:02:04', 'Hapus mobil #M0040 ', 0),
(595, '2020-11-26 08:05:03', 'Login', 16),
(596, '2020-11-26 08:06:03', 'Edit pengguna  #U017 ', 16),
(597, '2020-11-26 08:06:13', 'Edit pengguna  #U017 ', 16),
(598, '2020-11-26 08:07:46', 'Logout', 16),
(599, '2020-11-26 08:16:09', 'Login', 16),
(600, '2020-11-26 08:16:18', 'Update Profil Aplikasi', 16),
(601, '2020-11-26 08:16:45', 'Logout', 16),
(602, '2020-11-26 08:21:01', 'Login', 16),
(603, '2020-11-26 08:22:35', 'Logout', 16),
(604, '2020-11-26 08:52:05', 'Login', 16),
(605, '2020-11-26 10:25:02', 'Logout', 16),
(606, '2020-11-26 10:25:08', 'Login', 16),
(607, '2020-11-26 10:31:12', 'Tambah Produk # ', 0),
(608, '2020-11-26 10:31:24', 'Tambah Merek #A0027 ', 0),
(609, '2020-11-26 10:31:37', 'Hapus mobil #M0040 ', 0),
(610, '2020-11-26 10:36:26', 'Tambah Merek #A0027 ', 0),
(611, '2020-11-26 10:37:22', 'Tambah Merek #A0031 ', 0),
(612, '2020-11-26 10:40:27', 'Tambah Produk # ', 0),
(613, '2020-11-26 10:41:05', 'Tambah Produk # ', 0),
(614, '2020-11-26 10:41:34', 'Tambah Produk # ', 0),
(615, '2020-11-26 10:44:14', 'Tambah Produk # ', 0),
(616, '2020-11-26 10:44:43', 'Tambah Produk # ', 0),
(617, '2020-11-26 10:45:09', 'Tambah Produk # ', 0),
(618, '2020-11-26 10:45:33', 'Tambah Produk # ', 0),
(619, '2020-11-26 10:46:01', 'Tambah Produk # ', 0),
(620, '2020-11-26 10:49:18', 'Edit mobil #M0040 ', 0),
(621, '2020-11-26 10:49:32', 'Edit mobil #M0043 ', 0),
(622, '2020-11-26 10:49:40', 'Edit mobil #M0040 ', 0),
(623, '2020-11-26 10:50:13', 'Tambah Produk # ', 0),
(624, '2020-11-26 10:50:40', 'Tambah Produk # ', 0),
(625, '2020-11-26 10:51:05', 'Tambah Produk # ', 0),
(626, '2020-11-26 10:51:35', 'Tambah Produk # ', 0),
(627, '2020-11-26 10:51:45', 'Edit mobil #M0039 ', 0),
(628, '2020-11-26 10:52:19', 'Tambah Produk # ', 0),
(629, '2020-11-26 10:55:37', 'Tambah Merek #A0031 ', 0),
(630, '2020-11-26 10:56:57', 'Tambah Merek #A0031 ', 0),
(631, '2020-11-26 10:58:59', 'Tambah Produk # ', 0),
(632, '2020-11-26 10:59:25', 'Tambah Produk # ', 0),
(633, '2020-11-26 11:01:10', 'Tambah Produk # ', 0),
(634, '2020-11-26 11:01:33', 'Tambah Produk # ', 0),
(635, '2020-11-26 11:15:00', 'Login', 16),
(636, '2020-11-26 11:21:10', 'Edit Biaya ID #186 ', 0),
(637, '2020-11-26 01:16:36', 'Login', 16),
(638, '2020-11-26 01:40:04', 'Logout', 16),
(639, '2020-11-26 02:22:02', 'Login', 16),
(640, '2020-12-08 03:29:06', 'Login', 16),
(641, '2020-12-11 04:20:56', 'Login', 16),
(642, '2020-12-11 04:22:47', 'Edit Profil', 16),
(643, '2020-12-11 04:24:58', 'Edit Profil', 16),
(644, '2020-12-11 04:27:35', 'Edit Biaya ID #188 ', 0),
(645, '2020-12-11 04:27:47', 'Edit Biaya ID #188 ', 0),
(646, '2020-12-11 04:33:29', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(647, '2020-12-11 04:33:44', 'Edit Biaya ID #188 ', 0),
(648, '2020-12-11 04:37:11', 'Edit Biaya ID #189 ', 0),
(649, '2020-12-11 04:38:15', 'Edit Biaya ID #189 ', 0),
(650, '2020-12-11 04:40:21', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(651, '2020-12-11 06:35:20', 'Login', 16),
(652, '2020-12-11 06:54:31', 'Edit pengguna  #U011 ', 16),
(653, '2020-12-11 06:55:16', 'Edit Profil', 16),
(654, '2020-12-11 06:56:19', 'Edit pengguna  #U017 ', 16),
(655, '2020-12-11 06:57:20', 'Edit pengguna  #U011 ', 16),
(656, '2020-12-11 06:58:23', 'Logout', 16),
(657, '2020-12-11 06:58:42', 'Login', 16),
(658, '2020-12-11 07:16:08', 'Edit Profil', 16),
(659, '2020-12-11 07:16:12', 'Logout', 16),
(660, '2020-12-11 07:16:16', 'Login', 16),
(661, '2020-12-11 07:16:23', 'Edit Profil', 16),
(662, '2020-12-11 07:16:26', 'Logout', 16),
(663, '2020-12-11 07:16:30', 'Login', 16),
(664, '2020-12-11 07:16:41', 'Edit Profil', 16),
(665, '2020-12-11 23:34:00', 'Input transaksi Kode #201211202 ', 16),
(666, '2020-12-12 11:15:00', 'Input transaksi Kode #20121201 ', 16),
(667, '2020-12-12 11:16:00', 'Input transaksi Kode #201212205 ', 16),
(668, '2020-12-12 11:17:00', 'Input transaksi Kode #20121201 ', 16),
(669, '2020-12-12 11:21:00', 'Input transaksi Kode #20121201 ', 16),
(670, '2020-12-12 11:49:00', 'Input transaksi Kode #201212208 ', 16),
(671, '2020-12-12 14:13:00', 'Input transaksi Kode #201212209 ', 16),
(672, '2020-12-12 14:15:00', 'Input transaksi Kode #201212210 ', 16),
(673, '2020-12-12 14:43:00', 'Input transaksi Kode #201212211 ', 16),
(674, '2020-12-12 14:44:00', 'Input transaksi Kode #201212212 ', 16),
(675, '2020-12-12 20:12:00', 'Input transaksi Kode #201212213 ', 16),
(676, '2020-12-12 20:13:00', 'Input transaksi Kode #201212214 ', 16),
(677, '2020-12-12 21:12:00', 'Input transaksi Kode #201212215 ', 16),
(678, '2020-12-12 23:56:00', 'Input transaksi Kode #20121201 ', 16),
(679, '2020-12-13 00:28:00', 'Input transaksi Kode #20121301 ', 16),
(680, '2020-12-13 16:19:00', 'Input transaksi Kode #201213218 ', 16),
(681, '2020-12-13 19:33:00', 'Input transaksi Kode #201213218 ', 16),
(682, '2020-12-13 21:25:00', 'Input transaksi Kode #201213220 ', 16),
(684, '2020-12-15 14:51:00', 'Input transaksi Kode #20121501 ', 16),
(685, '2020-12-15 14:51:00', 'Input transaksi Kode #201215222 ', 16),
(686, '2020-12-15 14:53:00', 'Input transaksi Kode #201215223 ', 16),
(687, '2020-12-15 14:54:00', 'Input transaksi Kode #201215224 ', 16),
(688, '2020-12-15 07:09:42', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(689, '2020-12-15 07:09:59', 'Edit Biaya ID #192 ', 0),
(690, '2020-12-15 07:15:42', 'Edit Biaya ID #194 ', 0),
(691, '2020-12-15 07:26:08', 'Edit Biaya ID #197 ', 0),
(692, '2020-12-15 07:27:29', 'Edit Biaya ID #197 ', 0),
(693, '2020-12-15 07:28:43', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 0),
(694, '2020-12-15 07:28:55', 'Edit Biaya ID #191 ', 0),
(695, '2020-12-15 07:53:59', 'Tambah Produk # ', 0),
(696, '2020-12-15 07:57:36', 'Hapus mobil #M0059 ', 0),
(697, '2020-12-15 07:57:56', 'Edit mobil #M0044 ', 0),
(698, '2020-12-15 08:01:48', 'Tambah Merek #A0034 ', 0),
(699, '2020-12-15 08:06:08', 'Tambah Merek #A0037 ', 0),
(700, '2020-12-15 08:06:20', 'Tambah Merek #A0034 ', 0),
(701, '2020-12-15 08:09:07', 'Edit Profil', 16),
(702, '2020-12-15 08:09:13', 'Edit Profil', 16),
(703, '2020-12-15 08:10:45', 'Edit Biaya ID #190 ', 0),
(704, '2020-12-15 08:11:33', 'Edit pengguna  #U017 ', 16),
(705, '2020-12-15 08:12:30', 'Edit pengguna  #U011 ', 16),
(706, '2020-12-15 08:12:57', 'Edit Profil', 16),
(707, '2020-12-15 08:13:36', 'Edit pengguna  #U017 ', 16),
(708, '2020-12-15 20:15:00', 'Input transaksi Kode #201215224 ', 16),
(709, '2020-12-15 08:21:52', 'Edit Profil', 16),
(710, '2020-12-15 08:22:09', 'Edit pengguna  #U017 ', 16),
(711, '2020-12-15 08:22:19', 'Edit Profil', 16),
(712, '2020-12-16 22:20:00', 'Input transaksi Kode #20121601 ', 16),
(713, '2020-12-16 10:40:00', 'Edit Biaya ID #198 ', 16),
(714, '2020-12-16 10:43:28', 'Edit Biaya ID #198 ', 16),
(715, '2020-12-16 10:43:40', 'Edit Biaya ID #198 ', 16),
(716, '2020-12-16 10:44:08', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 16),
(717, '2020-12-16 10:44:13', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 16),
(718, '2020-12-16 10:44:20', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 16),
(719, '2020-12-16 10:44:34', 'Edit Biaya ID #187 ', 16),
(720, '2020-12-16 10:44:43', 'Edit Biaya ID #187 ', 16),
(721, '2020-12-16 10:45:10', 'Edit Biaya ID #187 ', 16),
(722, '2020-12-16 10:45:15', 'Edit Biaya ID #187 ', 16),
(723, '2020-12-17 08:53:25', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 16),
(724, '2020-12-17 08:53:30', 'Edit Biaya ID #186 ', 16),
(725, '2020-12-17 09:53:32', 'Siman Biaya Sewa ID # ', 16),
(726, '2020-12-17 09:53:38', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 16),
(727, '2020-12-17 09:53:47', 'Siman Biaya Sewa ID # ', 16),
(728, '2020-12-17 09:53:55', 'Edit Biaya ID #200 ', 16),
(729, '2020-12-17 09:53:58', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 16),
(730, '2020-12-17 09:54:42', 'Edit Biaya ID #186 ', 16),
(731, '2020-12-17 09:54:51', 'Siman Biaya Sewa ID # ', 16),
(732, '2020-12-17 09:56:38', 'Siman Biaya Sewa ID # ', 16),
(733, '2020-12-17 09:56:47', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 16),
(734, '2020-12-17 10:00:38', 'Siman Biaya Sewa ID # ', 16),
(735, '2020-12-17 11:01:34', 'Siman Biaya Sewa ID # ', 16),
(736, '2020-12-17 11:01:55', 'Siman Biaya Sewa ID # ', 16),
(737, '2020-12-17 11:02:17', 'Siman Biaya Sewa ID # ', 16),
(738, '2020-12-17 23:03:00', 'Input transaksi Kode #20121701 ', 16),
(739, '2020-12-18 08:29:16', 'Siman Biaya Sewa ID # ', 16),
(740, '2020-12-18 08:29:28', 'Siman Biaya Sewa ID # ', 16),
(741, '2020-12-18 08:29:38', 'Siman Biaya Sewa ID # ', 16),
(742, '2020-12-18 20:37:00', 'Input transaksi Kode #20121801 ', 16),
(743, '2020-12-18 20:38:00', 'Input transaksi Kode #201218229 ', 16),
(744, '2020-12-18 08:38:34', 'Siman Biaya Sewa ID # ', 16),
(745, '2020-12-18 08:38:51', 'Siman Biaya Sewa ID # ', 16),
(746, '2020-12-18 20:39:00', 'Input transaksi Kode #201218230 ', 16),
(747, '2020-12-18 20:40:00', 'Input transaksi Kode #201218231 ', 16),
(748, '2020-12-18 20:41:00', 'Input transaksi Kode #201218232 ', 16),
(749, '2020-12-18 20:41:00', 'Input transaksi Kode #201218233 ', 16),
(750, '2020-12-18 20:43:00', 'Input transaksi Kode #201218234 ', 16),
(751, '2020-12-18 08:43:47', 'Edit Biaya ID #209 ', 16),
(752, '2020-12-18 08:44:10', 'Edit Biaya ID #201 ', 16),
(753, '2020-12-18 08:44:25', 'Edit Biaya ID #182 ', 16),
(754, '2020-12-18 20:47:00', 'Input transaksi Kode #201218235 ', 16),
(755, '2020-12-18 09:18:02', 'Update Profil Aplikasi', 16),
(756, '2020-12-18 09:18:16', 'Update Profil Aplikasi', 16),
(757, '2020-12-18 09:18:41', 'Edit Biaya ID #211 ', 16),
(758, '2020-12-18 09:19:40', 'Simpan Biaya Sewa ID # ', 16),
(759, '2020-12-18 09:20:16', 'Hapus biaya sewa #&lt;br /&gt;\r\n&lt;b&gt;Notice&lt;/b&gt;:  Undefined index: kode_mobil in &lt;b&gt;C:xampphtdocsrental_mbldistbiaya-sewahapus.php&lt;/b&gt; on line &lt;b&gt;11&lt;/b&gt;&lt;br /&gt; ', 16),
(760, '2020-12-18 09:21:39', 'Simpan Biaya Sewa ID Mobil #55 ', 16),
(761, '2020-12-18 09:21:49', 'Hapus biaya sewa ID #55 ', 16),
(762, '2020-12-18 09:23:41', 'Tambah Mobil #M0059 ', 0),
(763, '2020-12-18 09:24:25', 'Hapus mobil #M0059 ', 0),
(764, '2020-12-18 09:24:32', 'Tambah Mobil #M0059 ', 16),
(765, '2020-12-18 09:25:23', 'Edit mobil #M0059 ', 16),
(766, '2020-12-18 09:26:07', 'Hapus mobil #M0059 ', 16),
(767, '2020-12-18 09:28:53', 'Tambah Merek Mobil #A0034', 16),
(768, '2020-12-18 09:30:24', 'Hapus Merek Mobil ID #39 ', 16),
(769, '2020-12-18 09:32:23', 'Tambah pengguna #U022 ', 16),
(770, '2020-12-18 09:32:48', 'Edit pengguna #U022 ', 16),
(771, '2020-12-18 09:33:09', 'Edit pengguna #U022 ', 16),
(772, '2020-12-18 09:34:28', 'Tambah pengguna #U022 ', 16),
(773, '2020-12-18 09:34:32', 'Edit pengguna # ', 16),
(774, '2020-12-18 09:35:18', 'Tambah pengguna #U022 ', 16),
(775, '2020-12-18 09:35:21', 'Hapus pengguna ID #16', 16),
(776, '2020-12-18 21:37:00', 'Input transaksi Kode #201218236', 16),
(777, '2020-12-18 21:38:00', 'Hapus transaksi Kode #201218236', 16),
(778, '2020-12-18 21:44:00', 'Update Status ID Detail #312', 16),
(779, '2020-12-18 09:48:53', 'Edit Data Penyewa - ID Transaksi #235 ', 16),
(780, '2020-12-18 21:51:00', 'Edit Pembayaran ID #235', 16),
(781, '2020-12-18 21:53:00', 'Hapus Pembayaran ID #235', 16),
(782, '2020-12-19 19:25:00', 'Hapus Pembayaran ID #235', 16),
(783, '2020-12-19 19:25:00', 'Update Status Penyewaan ID Detail Transaksi #313', 16),
(784, '2020-12-19 07:26:31', 'Edit Data Penyewa - ID Transaksi #235 ', 16),
(785, '2020-12-19 19:26:00', 'Edit Pembayaran ID #235', 16),
(786, '2020-12-19 07:31:23', 'Hapus Penyewaan ID #$ 318 ', 16),
(787, '2020-12-19 07:34:24', 'Tambah Penyewaan Kode #201218235', 16),
(788, '2020-12-19 20:16:00', 'Input transaksi Kode #20121901', 16),
(789, '2020-12-19 20:18:00', 'Input transaksi Kode #201219238', 16),
(790, '2020-12-19 20:18:00', 'Hapus transaksi Kode #201219238', 16),
(791, '2020-12-19 08:19:11', 'Tambah Penyewaan Kode #20121901', 16),
(792, '2020-12-19 20:19:00', 'Update Status Penyewaan ID Detail Transaksi #320', 16),
(793, '2020-12-19 08:19:59', 'Edit mobil #M0040 ', 16),
(794, '2020-12-19 08:20:06', 'Edit mobil #M0043 ', 16),
(795, '2020-12-19 08:20:12', 'Edit mobil #M0044 ', 16),
(796, '2020-12-19 08:55:06', 'Edit mobil #M0043 ', 16),
(797, '2020-12-19 08:57:11', 'Tambah pengguna #U022 ', 16),
(798, '2020-12-19 09:01:03', 'Edit pengguna #U017 ', 16),
(799, '2020-12-19 21:21:00', 'Input transaksi Kode #201219238', 16),
(800, '2020-12-19 21:23:00', 'Input transaksi Kode #201219240', 16),
(801, '2020-12-19 21:42:00', 'Input transaksi Kode #201219241', 16),
(802, '2020-12-19 09:49:38', 'Tambah Penyewaan Kode #201219241', 16),
(803, '2020-12-19 10:11:32', 'Hapus pengguna ID #16', 16),
(804, '2020-12-20 12:50:33', 'Edit pengguna #U017 ', 16),
(805, '2020-12-20 12:50:51', 'Edit pengguna #U017 ', 16),
(806, '2020-12-20 12:51:30', 'Edit pengguna #U016 ', 16),
(807, '2020-12-20 12:51:39', 'Edit pengguna #U017 ', 16),
(808, '2020-12-20 12:52:06', 'Edit pengguna #U011 ', 16),
(809, '2020-12-20 12:52:15', 'Edit pengguna #U011 ', 16),
(810, '2020-12-20 12:52:38', 'Edit Data Penyewa - ID Transaksi #240 ', 16),
(811, '2020-12-20 12:55:42', 'Edit Data Penyewa - ID Transaksi #240 ', 16),
(812, '2020-12-20 12:59:00', 'Input transaksi Kode #20122001', 21),
(813, '2020-12-20 13:00:00', 'Edit Pembayaran ID #242', 21),
(814, '2020-12-20 01:01:55', 'Edit pengguna #U016 ', 11),
(815, '2020-12-20 01:05:00', 'Edit pengguna #U011 ', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `merek_mobil`
--

CREATE TABLE `merek_mobil` (
  `id_merek` int(11) NOT NULL,
  `kode_merek` char(9) NOT NULL,
  `merek` varchar(50) NOT NULL,
  `gambar_merek` varchar(100) NOT NULL DEFAULT 'gambar.png',
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `merek_mobil`
--

INSERT INTO `merek_mobil` (`id_merek`, `kode_merek`, `merek`, `gambar_merek`, `keterangan`) VALUES
(20, 'A0020', 'Mitsubishi', 'iconfindermitsubishilogo4141793-115967_115914.png', ''),
(26, 'A0026', 'Honda', 'honda_logo_icon_145821.png', ''),
(30, 'A0027', 'Nissan', 'iconfindernissanlogo4142910-115961_115919.png', ''),
(33, 'A0031', 'BMW', 'iconfinderbmwlogo4140436-115966_115915.png', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

CREATE TABLE `mobil` (
  `id_mobil` int(11) NOT NULL,
  `kode_mobil` char(9) NOT NULL,
  `nama_mobil` varchar(100) NOT NULL,
  `id_merek` int(11) NOT NULL,
  `warna` varchar(20) NOT NULL,
  `jumlah_kursi` int(11) NOT NULL,
  `tahun_produksi` year(4) NOT NULL,
  `nomor_polisi` char(12) NOT NULL,
  `gambar_mobil` varchar(200) NOT NULL,
  `status_mobil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`id_mobil`, `kode_mobil`, `nama_mobil`, `id_merek`, `warna`, `jumlah_kursi`, `tahun_produksi`, `nomor_polisi`, `gambar_mobil`, `status_mobil`) VALUES
(37, 'M0001', 'Honda Mobilio', 26, 'Putih', 6, 2020, 'AB 1255 KA', 'MOBILIO.PNG', 0),
(38, 'M0038', 'Honda HR-V', 26, 'Putih', 4, 2020, 'AB 12AS KA', 'HONDA HR-V.PNG', 2),
(42, 'M0040', 'Pajero Sport', 20, 'Abu-abu', 6, 2020, 'AB 7364 KA', 'Mitsubishi Pajero Sport.PNG', 0),
(43, 'M0043', 'Xpander', 20, 'Putih', 6, 2020, 'AB 7712 KA', 'Mitsubishi Xpander.PNG', 0),
(44, 'M0044', 'Eclipse Cross', 20, 'Merah', 5, 2020, 'AB 5590 KA', 'Mitsubishi Eclipse Cross.PNG', 0),
(45, 'M0045', 'Honda City', 26, 'Abu-abu', 4, 2020, 'AB 9099 KA', 'Honda City.PNG', 0),
(46, 'M0046', 'Honda Brio', 26, 'Orange', 4, 2020, 'AB 8988 KA', 'Honda Brio.PNG', 0),
(47, 'M0047', 'Honda BR-V', 26, 'Putih', 4, 2020, 'AB 2309 KA', 'Honda BR-V.PNG', 0),
(48, 'M0048', 'Honda Jazz', 26, 'Orange', 4, 2020, 'AB 6721 KA', 'Honda Jazz.PNG', 0),
(49, 'M0049', 'Honda Mobilio', 26, 'Merah', 6, 2020, 'AB 6988 KA', 'Honda Mobilio.PNG', 0),
(55, 'M0055', 'Nissan Livina', 30, 'Hitam', 5, 2020, 'AB 7790 KA', 'Nissan Livina.PNG', 0),
(56, 'M0056', 'Nissan X-Trail', 30, 'Putih', 5, 2020, 'AB 6611 KA', 'Nissan X-Trail.PNG', 0),
(57, 'M0057', 'BMW 320i', 33, 'Biru', 4, 2020, 'AB 1898 KA', 'Bmw 320i.PNG', 0),
(58, 'M0058', 'BMW 330i', 33, 'Hitam', 4, 2020, 'AB 1154 KA', 'Bmw 330i.PNG', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `kode_pelanggan` char(9) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `alamat_pelanggan` varchar(50) NOT NULL,
  `jenis_kelamin` int(11) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `kode_pelanggan`, `nama_pelanggan`, `no_telp`, `alamat_pelanggan`, `jenis_kelamin`, `tanggal_lahir`, `status`) VALUES
(8, 'P0008', 'Mila Supriani', '082322233', 'Jl maya no 76', 2, '2000-02-22', 1),
(9, 'P0009', 'Wahyu Atmajaya', '087823293222', 'Jl batu no 98', 1, '1997-11-11', 1),
(10, 'P0010', 'Rizki Kurniawan', '08237484492', 'Jl mantrijeron no 67', 1, '1996-08-11', 1),
(11, 'P0011', 'Ilham Sanjaya', '087823293233', 'Jl sukuarjo no 89', 1, '1998-12-19', 1),
(12, 'PN001', 'Rini Mustika', '082322230343', 'Jl cendana no 78', 2, '1991-08-26', 1),
(17, 'PN0013', 'Ferrry Setiawan', '08923274242', 'Jl banguntapan no 22', 1, '1993-11-11', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `kode_pengguna` char(9) NOT NULL,
  `nama_pengguna` varchar(50) NOT NULL,
  `email` varchar(35) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `level` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `kode_pengguna`, `nama_pengguna`, `email`, `no_telp`, `foto`, `username`, `password`, `level`, `status`) VALUES
(11, 'U011', 'Wahyu', 'manajer@gmail.com', '089242323220', 'marshel.png', 'manajer_rental_mobil', '827ccb0eea8a706c4c34a16891f84e7b', 'Manajer', 1),
(16, 'U016', 'Dimas', 'super_admin@gmail.com', '082322230343', 'dimas.png', 'super_admin_rental_mobil', '827ccb0eea8a706c4c34a16891f84e7b', 'Super Admin', 1),
(21, 'U017', 'Rini', 'admin@gmail.com', '082322230343', 'safitri ayu.png', 'admin_rental_mobil', '827ccb0eea8a706c4c34a16891f84e7b', 'Admin', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_aplikasi`
--

CREATE TABLE `profil_aplikasi` (
  `id` int(11) NOT NULL,
  `nama_aplikasi` varchar(30) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `website` varchar(50) NOT NULL,
  `logo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `profil_aplikasi`
--

INSERT INTO `profil_aplikasi` (`id`, `nama_aplikasi`, `alamat`, `no_telp`, `website`, `logo`) VALUES
(0, 'Rama Rental Mobil', 'Jl Ahmad Yani No 56, Tegalrejo, Yogyakarta', '082322230300', 'www.ramamobil.com', 'logo_apps.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `kode_transaksi` char(10) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama_penyewa` varchar(100) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `identitas` varchar(100) NOT NULL,
  `foto_identitas` varchar(100) NOT NULL DEFAULT 'foto_default.png',
  `total_bayar` mediumint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `kode_transaksi`, `id_pengguna`, `tanggal_transaksi`, `nama_penyewa`, `no_telp`, `alamat`, `identitas`, `foto_identitas`, `total_bayar`) VALUES
(223, '201215223', 0, '2020-11-10 19:53:41', 'Riski Kurniawan', '08232922823', 'Jl Solo no 77', 'SIM A', 'identitas2.png', 44466),
(225, '201215224', 0, '2020-10-22 01:15:31', 'Dimas Agung', '08239824343', 'Jl Masjid no 45', 'KTP', 'identitas2.png', 0),
(227, '20121701', 16, '2020-09-23 04:03:24', 'Budi Ardi', '08934343554', 'Jl Malaka no 44', 'KTP', 'identitas3.png', 100000),
(228, '20121801', 0, '2020-08-14 01:37:11', 'Ari', '083984343334', 'Jl Raya janti no 45', 'KTP', 'identitas2.png', 528000),
(229, '201218229', 0, '2020-07-06 01:38:02', 'Bayu Widya', '08443445976', 'Jl Agung No 77', 'SIM A', 'identitas1.png', 0),
(230, '201218230', 0, '2020-06-17 01:39:42', 'Ayu Widya', '08983487535', 'Jl Raya Batu No 88', 'KTP', 'identitas2.png', 100000),
(231, '201218231', 0, '2020-05-09 01:40:21', 'Daniel', '08768298345', 'Jl Mangkubumi no 55', 'KTP', 'identitas2.png', 0),
(232, '201218232', 0, '2020-04-21 01:41:06', 'Brian', '08972283934', 'Jl ManggaDua No 90', 'KTP', 'identitas2.png', 0),
(233, '201218233', 0, '2020-03-14 01:41:48', 'Manda', '08973987483', 'Jl Sudirman No 77', 'KTP', 'identitas2.png', 372000),
(234, '201218234', 0, '2020-02-03 01:43:09', 'Rian Andra', '08923823354', 'Jl Masjid No 55', 'KTP', 'identitas1.png', 50000),
(235, '201218235', 0, '2020-12-18 01:47:51', 'Dian Kurniawan', '08974843434', 'Jl Buru No 88', 'KTP', 'identitas3.png', 4545),
(237, '20121901', 0, '2020-12-19 01:16:13', 'Dimas', '08239323233', 'Jl riadi no 45', 'KTP', 'identitas3.png', 612800),
(239, '201219238', 0, '0000-00-00 00:00:00', 'Dimas', '3243243', '34', 'KTP', 'foto_default.png', 34343),
(240, '201219240', 0, '2020-12-19 02:23:12', '232', '232', '232', 'Lainnya', 'foto_default.png', 0),
(241, '201219241', 16, '2020-12-19 02:42:27', '34', '34', '34', 'KTP', 'foto_default.png', 0),
(242, '20122001', 21, '2020-12-20 05:59:52', 'Dimas', '08938343433', 'Jl Raya Janti no 55', 'KTP', 'identitas3.png', 300000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indeks untuk tabel `biaya_sewa`
--
ALTER TABLE `biaya_sewa`
  ADD PRIMARY KEY (`id_biaya_sewa`),
  ADD UNIQUE KEY `id_mobil` (`id_mobil`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_aktivitas`);

--
-- Indeks untuk tabel `merek_mobil`
--
ALTER TABLE `merek_mobil`
  ADD PRIMARY KEY (`id_merek`),
  ADD UNIQUE KEY `kode_merek` (`kode_merek`);

--
-- Indeks untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `kode_pelanggan` (`kode_pelanggan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `profil_aplikasi`
--
ALTER TABLE `profil_aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `no_invoice` (`tanggal_transaksi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bank`
--
ALTER TABLE `bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `biaya_sewa`
--
ALTER TABLE `biaya_sewa`
  MODIFY `id_biaya_sewa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_aktivitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=816;

--
-- AUTO_INCREMENT untuk tabel `merek_mobil`
--
ALTER TABLE `merek_mobil`
  MODIFY `id_merek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
