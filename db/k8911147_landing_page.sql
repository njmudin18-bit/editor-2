-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2023 at 09:40 AM
-- Server version: 5.7.37-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `k8911147_landing_page`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_fasilitas_uji`
--

CREATE TABLE `table_fasilitas_uji` (
  `id` int(12) NOT NULL,
  `nama` varchar(125) NOT NULL,
  `image` varchar(125) NOT NULL,
  `deskripsi` text,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` int(11) NOT NULL,
  `insert_by` int(11) NOT NULL,
  `update_date` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_fasilitas_uji`
--

INSERT INTO `table_fasilitas_uji` (`id`, `nama`, `image`, `deskripsi`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(6, 'Mesin Cutting Rubber', 'mesin_cutting_rubber.png', '-', 'TIDAK', 2023, 9, 2023, 9),
(7, 'Mesin Cutting Silicone', 'mesin_cutting_silicone.png', '-', 'TIDAK', 2023, 9, 2023, 9),
(8, 'Alat Test Hardness', 'alat_test_hardness.png', '-', 'TIDAK', 2023, 9, 2023, 9),
(9, 'Mesin Mixing', 'mesin_mixing_a.png', '-', 'AKTIF', 2023, 9, NULL, NULL),
(10, 'Mesin Mixing', 'mesin_mixing_b.png', '-', 'AKTIF', 2023, 9, NULL, NULL),
(11, 'Mesin Press', 'mesin_press_a.png', '-', 'AKTIF', 2023, 9, NULL, NULL),
(12, 'Mesin Press', 'mesin_press_b.png', '-', 'AKTIF', 2023, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_jenis_produk`
--

CREATE TABLE `table_jenis_produk` (
  `id` int(12) NOT NULL,
  `jenis_produk` varchar(75) NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_jenis_produk`
--

INSERT INTO `table_jenis_produk` (`id`, `jenis_produk`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(1, 'Rubber', 'AKTIF', '2023-02-08 07:42:29', '9', '2023-05-31 14:27:57', '6'),
(2, 'Silicone', 'AKTIF', '2023-02-08 07:42:40', '9', '2023-05-31 14:26:16', '6');

-- --------------------------------------------------------

--
-- Table structure for table `table_logo_pelanggan`
--

CREATE TABLE `table_logo_pelanggan` (
  `id` int(12) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `logo` varchar(150) NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(25) NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_logo_pelanggan`
--

INSERT INTO `table_logo_pelanggan` (`id`, `nama`, `logo`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(14, 'Miyako', 'logo-miyako-new.webp', 'AKTIF', '2023-05-30 11:23:45', '9', '2023-07-25 10:29:45', '9'),
(15, 'Polytron', 'logo-polytron.webp', 'AKTIF', '2023-05-30 11:24:04', '9', '2023-07-25 10:29:52', '9'),
(16, 'Rinnai', 'logo-rinnai.webp', 'AKTIF', '2023-05-30 11:24:21', '9', '2023-07-25 10:30:00', '9'),
(17, 'Shimizu', 'logo-shimizu.webp', 'AKTIF', '2023-05-30 11:24:38', '9', '2023-07-25 10:30:09', '9'),
(18, 'Sanken', 'logo-sanken.webp', 'AKTIF', '2023-05-30 11:25:03', '9', '2023-07-25 10:30:16', '9'),
(19, 'Turbo', 'logo-turbo.webp', 'AKTIF', '2023-05-31 15:52:59', '9', '2023-07-25 10:30:23', '9'),
(20, 'Lion Star', 'logo-lion-star.webp', 'AKTIF', '2023-05-31 15:54:14', '9', '2023-07-25 10:30:29', '9'),
(21, 'Millionaire Group Indonesia', 'logo-mgi.webp', 'AKTIF', '2023-06-06 13:07:05', '9', '2023-07-25 10:30:36', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_main_slider`
--

CREATE TABLE `table_main_slider` (
  `id` int(12) NOT NULL,
  `urutan` int(12) DEFAULT NULL,
  `slider_name` varchar(75) DEFAULT NULL,
  `slider_image` varchar(75) DEFAULT NULL,
  `main_title` varchar(75) DEFAULT NULL,
  `sub_title` varchar(75) DEFAULT NULL,
  `button_text` varchar(25) DEFAULT NULL,
  `button_link` text,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime DEFAULT NULL,
  `insert_by` varchar(25) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_main_slider`
--

INSERT INTO `table_main_slider` (`id`, `urutan`, `slider_name`, `slider_image`, `main_title`, `sub_title`, `button_text`, `button_link`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(1, 1, 'Slider 1', 'Banner_Satu.webp', 'PT. Multi Arta Industri', 'Manufactur Rubber dan Silicone', 'Selengkapnya', 'company-profile', 'AKTIF', '2023-02-03 08:49:09', NULL, '2023-07-25 09:24:40', '9'),
(2, 2, 'Slider 2', 'Banner_Dua.webp', 'PT. Multi Arta Industri', 'Silicone terbaik untuk spare part anda', 'Selengkapnya', 'silicone', 'AKTIF', '2023-02-03 13:08:15', NULL, '2023-07-25 09:25:02', '9'),
(3, 3, 'Slider 3', 'Banner_Tiga.webp', 'PT. Multi Arta Industri', 'Rubber terbaik untuk sparet part anda', 'Selengkapnya', 'rubber', 'AKTIF', '2023-06-08 14:05:02', '9', '2023-07-25 09:25:10', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_metode_pdca`
--

CREATE TABLE `table_metode_pdca` (
  `id` int(12) NOT NULL,
  `text` text NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_metode_pdca`
--

INSERT INTO `table_metode_pdca` (`id`, `text`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(2, 'Pengembangan dimulai dari individu dengan usaha dan komunikasi yang baik serta training dan dukungan data yang benar dan tepat.', 'AKTIF', '2023-02-08 11:23:56', '9', '0000-00-00 00:00:00', ''),
(3, 'Pengembangan dimulai dari hal yang terkecil dan harus dilakukan secara rutin dengan semangat serta tujuan yang baik untuk segenap karyawan tanpa terkecuali.', 'AKTIF', '2023-02-08 11:24:30', '9', '0000-00-00 00:00:00', ''),
(4, 'Pengembangan terjadi dengan kerjasama yang baik dengan Pelanggan dalam mengikuti tuntutan pasar dan menerapkan kemajuan teknologi.', 'AKTIF', '2023-02-08 11:24:40', '9', '0000-00-00 00:00:00', ''),
(5, 'Lingkungan kerja adalah rumah kedua kami yang bersih, sehat dan menunjang produktivas usaha.', 'AKTIF', '2023-02-08 11:24:47', '9', '0000-00-00 00:00:00', ''),
(6, 'Qualitas dan ketepatan waktu adalah kunci dari kepuasan pelanggan kami.', 'AKTIF', '2023-02-08 11:24:55', '9', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `table_misi`
--

CREATE TABLE `table_misi` (
  `id` int(12) NOT NULL,
  `text` text NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_misi`
--

INSERT INTO `table_misi` (`id`, `text`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(1, 'Menetapkan, menerapkan, memelihara & melakukan perbaikan terus menerus terhadap sistem manajemen mutu.', 'AKTIF', '2023-02-08 11:08:29', '9', '2023-06-02 15:08:44', '9'),
(2, 'Meningkatkan sarana dan prasarana pendukung untuk mewujudkan mutu produk yang diharapkan pelanggan.', 'AKTIF', '2023-02-08 11:08:42', '9', '2023-06-02 15:08:22', '9'),
(3, 'Melakukan training untuk meningkatkan sumber daya manusia.', 'AKTIF', '2023-02-08 11:08:52', '9', '2023-06-02 15:08:05', '9'),
(4, 'Menciptakan inovasi berkelanjutan untuk pengembangan dan perbaikan produk.', 'AKTIF', '2023-02-08 11:09:05', '9', '2023-06-02 15:07:51', '9'),
(5, 'Menghasilkan produk berkualitas dengan harga baik, mutu yang terjamin & waktu pengiriman yang tepat  waktu.', 'AKTIF', '2023-02-08 11:09:12', '9', '2023-06-02 15:07:39', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_pertanyaan`
--

CREATE TABLE `table_pertanyaan` (
  `id` int(12) NOT NULL,
  `pengirim` varchar(150) NOT NULL,
  `email` varchar(75) DEFAULT NULL,
  `phone` varchar(11) NOT NULL,
  `type` enum('NORMAL','CALL BACK') NOT NULL DEFAULT 'NORMAL',
  `status_answer` enum('ASK','ANSWER','HOLD') DEFAULT 'ASK',
  `judul` varchar(250) NOT NULL,
  `isi` text,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_pertanyaan`
--

INSERT INTO `table_pertanyaan` (`id`, `pengirim`, `email`, `phone`, `type`, `status_answer`, `judul`, `isi`, `create_date`, `update_date`, `update_by`) VALUES
(48, 'Rudi', 'admin@mail.com', '', 'NORMAL', 'ANSWER', 'Test from localhost', 'Lengkapi dan submit form pelanggan di samping dan Tim sales kami akan menghubungi anda, diwaktu yang nyaman bagi anda.', '2023-02-10 13:45:12', '2023-02-13 09:32:14', '9'),
(49, 'Mudin', NULL, '08129806112', 'CALL BACK', 'ASK', 'Cara memesan produk', NULL, '2023-02-10 13:45:39', NULL, NULL),
(50, 'Dewa', NULL, '08129806112', 'CALL BACK', 'ASK', 'Pertanyaan seputar produk', NULL, '2023-02-13 09:26:40', NULL, NULL),
(51, 'Dewa', 'dewa@gmail.com', '', 'NORMAL', 'ASK', 'Kirimin dong please', 'Lengkapi dan submit form pelanggan di samping dan Tim sales kami akan menghubungi anda, diwaktu yang nyaman bagi anda.', '2023-02-13 09:29:31', '2023-02-13 10:17:22', '9'),
(52, 'Dwi', 'dwi@gmail.com', '', 'NORMAL', 'ASK', 'Hi, saya dwi', 'Kirimi kami permintaan Anda kapan saja!', '2023-02-13 09:30:58', NULL, NULL),
(53, 'Server', NULL, '08134500123', 'CALL BACK', 'ASK', 'Pertanyaan seputar produk', NULL, '2023-02-13 12:53:01', NULL, NULL),
(54, 'Reza', NULL, '08153000400', 'CALL BACK', 'HOLD', 'Hubungi saya', NULL, '2023-02-13 13:51:02', '2023-02-13 13:51:43', '9'),
(55, 'NJ', NULL, '08129806112', 'CALL BACK', 'ASK', 'Hi, Salam kenal', NULL, '2023-02-28 15:14:45', NULL, NULL),
(56, 'NJ 12', 'nj.mudin18@gmail.com', '', 'NORMAL', 'ASK', 'Hi, Salam kenal', 'Isi kenalan dong', '2023-02-28 15:14:51', NULL, NULL),
(57, 'Coki ku', 'nj.mudin@gmai.com', '', 'NORMAL', 'ASK', 'Judul pesan', 'test test test test test test', '2023-06-07 08:13:09', NULL, NULL),
(58, 'Coki ku', 'nj.mudin@gmai.com', '', 'NORMAL', 'ASK', 'Judul pesan', 'test test test test test test', '2023-06-07 08:14:56', NULL, NULL),
(59, 'Coki ku', 'nj.mudin@gmai.com', '', 'NORMAL', 'ASK', 'Judul pesan', 'test test test test test test', '2023-06-07 08:15:48', NULL, NULL),
(60, 'Coki ku', 'nj.mudin@gmai.com', '', 'NORMAL', 'ASK', 'Judul pesan', 'test test test test test test', '2023-06-07 08:24:34', NULL, NULL),
(61, 'Coki ku', 'nj.mudin@gmai.com', '', 'NORMAL', 'ASK', 'Judul pesan', 'test test test test test test', '2023-06-07 08:26:37', NULL, NULL),
(62, 'Coki ku', 'nj.mudin@gmai.com', '', 'NORMAL', 'ASK', 'Judul pesan', 'test test test test test test', '2023-06-07 08:27:16', NULL, NULL),
(63, 'Coki ku', 'nj.mudin@gmai.com', '', 'NORMAL', 'ASK', 'Judul pesan', 'test test test test test test', '2023-06-07 08:28:22', NULL, NULL),
(64, 'Coki ku', 'nj.mudin@gmai.com', '', 'NORMAL', 'ASK', 'Judul pesan', 'test test test test test test', '2023-06-07 08:29:32', NULL, NULL),
(65, 'Coki ku', 'nj.mudin@gmai.com', '', 'NORMAL', 'ASK', 'Judul pesan', 'test test test test test test', '2023-06-07 08:31:12', NULL, NULL),
(66, 'Coki Coki', 'njmudin@gmail.com', '', 'NORMAL', 'ASK', 'Mau tanya dong', 'Lengkapi dan submit form pelanggan di samping dan Tim sales kami akan menghubungi anda, diwaktu yang nyaman bagi anda.', '2023-06-07 08:40:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `table_perusahaan`
--

CREATE TABLE `table_perusahaan` (
  `id` int(12) NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `nama` varchar(75) NOT NULL,
  `telepon` varchar(25) NOT NULL,
  `handphone` varchar(25) NOT NULL,
  `fax` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `maps` text,
  `icon_name` varchar(100) DEFAULT NULL,
  `logo_name` varchar(100) NOT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `pinterest` varchar(100) DEFAULT NULL,
  `youtube` varchar(100) DEFAULT NULL,
  `skype` varchar(100) DEFAULT NULL,
  `insert_date` date NOT NULL,
  `insert_by` varchar(25) NOT NULL,
  `update_date` date DEFAULT NULL,
  `update_by` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_perusahaan`
--

INSERT INTO `table_perusahaan` (`id`, `aktivasi`, `nama`, `telepon`, `handphone`, `fax`, `email`, `alamat`, `maps`, `icon_name`, `logo_name`, `twitter`, `facebook`, `instagram`, `pinterest`, `youtube`, `skype`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(5, 'AKTIF', 'PT. Multi Arta Industri', '+6221 5940 6210', '+6281298061129', '+6221 5940 6210', 'sales@main-mfg.com', 'Jl. Raya Serang KM 18,6 Cikupa Tangerang, Banten - Indonesia.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15865.322356984145!2d106.4941249!3d-6.2200645!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e4201d6bf3a6515%3A0xdfddd6cdf3f59bd3!2sPT.%20MULTI%20ARTA%20INDUSTRI!5e0!3m2!1sid!2sid!4v1685580589729!5m2!1sid!2sid\" title=\"PT. Multi Arta Industri\" width=\"100%\" height=\"250\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'logo2.webp', 'Logo_main.webp', 'tw', 'fb', 'in', 'pin', 'yt', 'sk', '2023-02-06', '9', '2023-07-25', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_produk`
--

CREATE TABLE `table_produk` (
  `id` int(12) NOT NULL,
  `id_jenis` int(12) NOT NULL,
  `nama_produk` varchar(250) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `images` varchar(150) NOT NULL,
  `nominal_voltage` varchar(50) NOT NULL,
  `available_types` text NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') DEFAULT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_produk`
--

INSERT INTO `table_produk` (`id`, `id_jenis`, `nama_produk`, `slug`, `images`, `nominal_voltage`, `available_types`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(16, 2, 'Selang Panas Dingin - Dispenser', 'selang-panas-dingin---dispenser', 'Dispenser-Selang-Panas-Dingin.webp', '-', '-', 'AKTIF', '2023-05-31 14:31:26', '6', '2023-07-25 11:13:55', '9'),
(17, 2, 'Seal - Rice Cooker', 'seal---rice-cooker', 'Rice-Cooker-Seals.webp', '-', '-', 'AKTIF', '2023-05-31 14:34:27', '6', '2023-07-25 11:14:10', '9'),
(18, 2, 'Seal Gelas - Blender', 'seal-gelas---blender', 'Blender-Seal-Gelas.webp', '-', '-', 'AKTIF', '2023-05-31 14:37:02', '6', '2023-07-25 11:14:25', '9'),
(19, 2, 'Seal Water Tap - Dispenser', 'seal-water-tap---dispenser', 'Dispenser-Seal-Water-Tap.webp', '-', '-', 'AKTIF', '2023-05-31 14:38:51', '6', '2023-07-25 11:14:40', '9'),
(20, 2, 'Silicone Bio Glass', 'silicone-bio-glass', 'Pelindung-Kaca-Bioglas.webp', '-', '-', 'AKTIF', '2023-05-31 14:42:26', '6', '2023-07-25 11:15:19', '9'),
(21, 2, 'Cetakan Es Batu', 'cetakan-es-batu', 's21.webp', '-', '-', 'AKTIF', '2023-05-31 15:17:01', '9', '2023-07-25 12:43:49', '9'),
(22, 2, 'Sarung Tangan', 'sarung-tangan', 's22.webp', '-', '-', 'AKTIF', '2023-05-31 15:18:08', '9', '2023-07-25 12:43:37', '9'),
(23, 2, 'Insole Sepatu', 'insole-sepatu', 's23.jpg', '-', '-', 'TIDAK', '2023-05-31 15:18:45', '9', '2023-07-11 15:14:48', '9'),
(24, 2, 'Tatakan Panci', 'tatakan-panci', 's24.webp', '-', '-', 'AKTIF', '2023-05-31 15:19:32', '9', '2023-07-25 12:42:45', '9'),
(25, 2, 'Tutup Mangkok', 'tutup-mangkok', 's25.webp', '-', '-', 'AKTIF', '2023-05-31 15:20:02', '9', '2023-07-25 12:45:12', '9'),
(26, 1, 'Front Rubber Shock - Kipas Angin', 'front-rubber-shock---kipas-angin', 'Front-Rubber-Shock-Kipas-Angin.webp', '-', '-', 'AKTIF', '2023-06-01 11:09:53', '9', '2023-07-25 11:02:39', '9'),
(27, 1, 'Kaki Kompor Gas - Kompor Gas', 'kaki-kompor-gas---kompor-gas', 'Kaki-Kompor-Gas.webp', '-', '-', 'AKTIF', '2023-06-01 11:10:37', '9', '2023-07-25 11:02:25', '9'),
(28, 1, 'Karet Accumulator - Pompa Air', 'karet-accumulator---pompa-air', 'Karet-Accumulator-Pompa-Air.webp', '-', '-', 'AKTIF', '2023-06-01 11:11:21', '9', '2023-07-25 11:02:07', '9'),
(29, 1, 'Lead Bushing - Seal', 'lead-bushing---seal', 'Lead-Bushing-Sealed.webp', '-', '-', 'AKTIF', '2023-06-01 11:11:45', '9', '2023-07-25 11:01:53', '9'),
(30, 2, 'Silicone LF Hose for Ovoweflow RDB', 'silicone-lf-hose-for-ovoweflow-rdb', 'Silicone-LF-Hose-for-Ovoweflow-RDB.webp', '-', '-', 'AKTIF', '2023-07-11 14:16:14', '9', '2023-07-25 12:51:21', '9'),
(31, 2, 'Silicone J2', 'silicone-j2', 'Silicone-J2.webp', '-', '-', 'AKTIF', '2023-07-11 14:30:12', '9', '2023-07-25 12:50:46', '9'),
(32, 2, 'Silicone LF Hose for Inlet Hot Tank RDA', 'silicone-lf-hose-for-inlet-hot-tank-rda', 'Silicone-LF-Hose-for-Inlet-Hot-Tank-RDA.webp', '-', '-', 'AKTIF', '2023-07-11 15:13:35', '9', '2023-07-25 12:50:35', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_produk_tags`
--

CREATE TABLE `table_produk_tags` (
  `id` int(12) NOT NULL,
  `urutan` int(12) DEFAULT NULL,
  `main_title` varchar(75) NOT NULL,
  `sub_title` text NOT NULL,
  `icon` varchar(25) NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_produk_tags`
--

INSERT INTO `table_produk_tags` (`id`, `urutan`, `main_title`, `sub_title`, `icon`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(5, 1, 'Berkualitas', 'Produk yang kami hasilkan telah melewati inspeksi Quality Control yang ketat, sehingga memastikan bahwa produk yang anda terima adalah produk dengan kualitas terbaik.', 'kualitas-color.webp', 'AKTIF', '2023-05-30 11:00:34', '9', '2023-07-25 10:11:59', '9'),
(6, 2, 'Bergaransi', 'Produk yang anda terima mendapatkan garansi pengembalian produk dari kami, sehingga memberikan ketenangan dan kenyamanan bagi anda dalam menggunakan produk kami.', 'garansi-color.webp', 'AKTIF', '2023-05-30 11:01:01', '9', '2023-07-25 10:11:52', '9'),
(7, 3, 'Berlisensi', 'Produk yang kami hasilkan telah mendapatkan lisensi Standar Nasional Indonesia (SNI) dari pemerintah RI dan Sucofindo. Sehingga memastikan produk kami terdaftar.', 'lisensi-color.webp', 'AKTIF', '2023-05-30 11:01:20', '9', '2023-07-25 10:11:44', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_produk_trust`
--

CREATE TABLE `table_produk_trust` (
  `id` int(12) NOT NULL,
  `main_title` varchar(75) NOT NULL,
  `sub_title` text NOT NULL,
  `button_text` varchar(25) NOT NULL,
  `button_link` text,
  `images` varchar(150) NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_produk_trust`
--

INSERT INTO `table_produk_trust` (`id`, `main_title`, `sub_title`, `button_text`, `button_link`, `images`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(1, 'Kami dipercaya oleh banyak perusahaan besar', 'PT. Multi Arta Industri telah memproduksi Rubber dan Silicone yang telah digunakan oleh banyak perusahaan besar yang tersebar diseluruh Indonesia.', 'Learn More', 'our-customer', 'wetrusted.jpg', 'AKTIF', '2023-02-07 09:42:06', '9', '2023-05-30 11:02:08', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_profile`
--

CREATE TABLE `table_profile` (
  `id` int(12) NOT NULL,
  `main_title` varchar(150) NOT NULL,
  `contents` text NOT NULL,
  `images` varchar(125) NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_profile`
--

INSERT INTO `table_profile` (`id`, `main_title`, `contents`, `images`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(1, 'Kepuasan anda adalah tujuan kami', '<p>Sejalan dengan perkembangan dan pertumbuhan industri rumah tangga di Indonesia, <b>PT. MAiN (Multi Arta Industri)</b> berawal dengan membuat produk setangah jadi dan produk jadi, dari bahan baku karet&nbsp; dan silicon untuk pelanggan produsen alat rumah tangga. </p><p>Operasional sudah dirintis sejak tahun 2013 dengan mengikuti standar management <i>ISO</i>, <b>PT. MAiN</b> saat ini telah berkembang dengan luas bangunan 2.600 m2 dan jumlah pegawai lebih dari 150 orang.</p>', 'pabrik_main.webp', 'AKTIF', '2023-02-14 09:03:06', '9', '2023-07-25 13:11:22', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_profile_header`
--

CREATE TABLE `table_profile_header` (
  `id` int(12) NOT NULL,
  `nama` varchar(75) NOT NULL,
  `url` text NOT NULL,
  `images` varchar(150) NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_profile_header`
--

INSERT INTO `table_profile_header` (`id`, `nama`, `url`, `images`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(1, 'Profil Perusahaan', 'company-profile', 'company-profile-bg.webp', 'AKTIF', '2023-02-06 13:09:08', '9', '2023-07-25 13:02:23', '9'),
(2, 'Visi Dan Misi', 'visi-dan-misi', 'visi-misi-bg.webp', 'AKTIF', '2023-02-06 13:09:54', '9', '2023-07-25 13:01:09', '9'),
(3, 'Pelanggan Kami', 'our-customer', 'our-customers-bg.webp', 'AKTIF', '2023-02-06 13:10:13', '9', '2023-07-25 13:01:16', '9'),
(4, 'Fasilitas Uji', '', 'services_hero.jpg', 'AKTIF', '2023-02-06 13:10:59', '9', NULL, NULL),
(6, 'Kontak Kami', 'contact-us', 'contact-us-bg.webp', 'AKTIF', '2023-02-09 08:53:15', '9', '2023-07-25 11:08:49', '9'),
(7, 'Karir', 'career', 'career-bg.webp', 'AKTIF', '2023-02-09 09:14:40', '9', '2023-07-25 11:08:42', '9'),
(8, 'Silicone', 'silicone', 'silicone-bg.webp', 'AKTIF', '2023-02-09 09:22:59', '9', '2023-07-25 11:06:55', '9'),
(9, 'Rubber', 'rubber', 'rubber-bg.webp', 'AKTIF', '2023-02-09 10:28:32', '9', '2023-07-25 11:06:47', '9'),
(10, 'Tidak ditemukan', '404', 'contact_hero2.jpg', 'AKTIF', '2023-02-15 09:46:41', '9', '2023-06-02 09:14:36', '9'),
(11, 'Produk Detail', 'view', 'fasilitas-uji-bg.webp', 'AKTIF', '2023-06-01 12:50:05', '9', '2023-07-25 13:20:02', '9'),
(12, 'Mesin kami', 'our-machine', 'machine-bg.webp', 'AKTIF', '2023-06-06 13:36:17', '9', '2023-07-25 13:00:52', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_sertified_by`
--

CREATE TABLE `table_sertified_by` (
  `id` int(12) NOT NULL,
  `urutan` int(12) DEFAULT NULL,
  `nama` varchar(75) NOT NULL,
  `nomor_lisensi` varchar(50) NOT NULL,
  `images` varchar(150) NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_sertified_by`
--

INSERT INTO `table_sertified_by` (`id`, `urutan`, `nama`, `nomor_lisensi`, `images`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(1, 1, 'Sucofindo QSC', 'QSC 01290', 'sertifikasi_1.png', 'AKTIF', '2023-02-07 11:00:47', '9', '2023-02-10 09:29:12', '9'),
(3, 2, 'Sucofindo', 'PCS 00114.01', 'sertifikasi_2.png', 'AKTIF', '2023-02-10 09:23:41', '9', '2023-02-10 09:29:17', '9'),
(4, 3, 'SNI', 'IEC 60884-1', 'sertifikasi_3.png', 'AKTIF', '2023-02-10 09:24:11', '9', '2023-02-10 09:33:33', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_sinopsis_produk`
--

CREATE TABLE `table_sinopsis_produk` (
  `id` int(12) NOT NULL,
  `urutan` int(12) DEFAULT NULL,
  `product_name` varchar(125) NOT NULL,
  `product_desc` text NOT NULL,
  `product_images` varchar(150) DEFAULT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `types` enum('IMAGES','TEXT') NOT NULL,
  `link` text NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(25) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_sinopsis_produk`
--

INSERT INTO `table_sinopsis_produk` (`id`, `urutan`, `product_name`, `product_desc`, `product_images`, `aktivasi`, `types`, `link`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(19, 3, 'Apa yang bisa kami lakukan untuk Anda', 'PT. Multi Arta Industri merupakan perusahaan manufaktur untuk mensupply rubber dan silicone kepada perusahaan - perusahaan yang memproduksi alat - alat listrik rumah tangga terutama di Indonesia.', '', 'AKTIF', 'TEXT', 'company-profile', '2023-02-04 10:09:05', '9', '2023-05-31 08:24:48', '9'),
(24, 1, 'Rubber', 'Kami memproduksi rubber dengan kualitas tinggi yang telah dipakai oleh banyak perusahaan besar di Indonesia.', 'Rubber_.webp', 'AKTIF', 'IMAGES', 'rubber', '2023-05-30 11:14:39', '9', '2023-07-14 08:53:43', '9'),
(25, 2, 'Silicone', 'Kami juga memproduksi silicone yang digunakan oleh banyak perusahaan elektronik didalam produk-produk buatan nya.', 'Silicone_one.webp', 'AKTIF', 'IMAGES', 'silicone', '2023-05-30 11:15:34', '9', '2023-07-14 08:53:26', '9');

-- --------------------------------------------------------

--
-- Table structure for table `table_user`
--

CREATE TABLE `table_user` (
  `id` int(12) NOT NULL,
  `nip` varchar(75) NOT NULL,
  `email_pegawai` varchar(75) NOT NULL,
  `username` varchar(75) NOT NULL,
  `password` varchar(150) NOT NULL,
  `level` enum('sa','admin','user') NOT NULL,
  `aktivasi` enum('Aktif','Block') NOT NULL,
  `last_login` datetime NOT NULL,
  `insert_date` date NOT NULL,
  `insert_by` varchar(25) NOT NULL,
  `update_date` date NOT NULL,
  `update_by` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_user`
--

INSERT INTO `table_user` (`id`, `nip`, `email_pegawai`, `username`, `password`, `level`, `aktivasi`, `last_login`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(9, '2022111401', 'nj.mudin18@gmail.com', 'njmudin', '$2y$10$j.xoSAQieiUIl9nJAzd0F.DrbJlNLdiFAu1QLRBIEtct8Y2w37ZN.', 'sa', 'Aktif', '2023-07-25 09:18:04', '2023-02-01', 'nj.mudin18@gmail.com', '2023-02-13', '9'),
(10, '0988888', 'riki@gmail.com', 'riki', '$2y$10$/e/OekEIyHV2Tylnj8h6Ee25jpdMpH1.dN8Qaa3V0ry6iVbwYJcrS', 'sa', 'Aktif', '0000-00-00 00:00:00', '2023-02-02', '9', '0000-00-00', ''),
(13, '2022110001', 'reza@gmail.com', 'reza', '$2y$10$apz866DPn8Uq6BZpm5OG8u91CJNJT2t0fiJhLEdzESqiPdpU1MLk.', 'user', 'Block', '0000-00-00 00:00:00', '2023-02-02', '9', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `table_visi`
--

CREATE TABLE `table_visi` (
  `id` int(12) NOT NULL,
  `text` text NOT NULL,
  `aktivasi` enum('AKTIF','TIDAK') NOT NULL,
  `insert_date` datetime NOT NULL,
  `insert_by` varchar(15) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_by` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_visi`
--

INSERT INTO `table_visi` (`id`, `text`, `aktivasi`, `insert_date`, `insert_by`, `update_date`, `update_by`) VALUES
(1, 'Membangun kepercayaan pelanggan dengan harga, kualitas & waktu pengiriman yang <strong>TERBAIK</strong>.', 'AKTIF', '2023-02-08 10:58:31', '9', '2023-06-02 13:39:54', '9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_fasilitas_uji`
--
ALTER TABLE `table_fasilitas_uji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_jenis_produk`
--
ALTER TABLE `table_jenis_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_logo_pelanggan`
--
ALTER TABLE `table_logo_pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_main_slider`
--
ALTER TABLE `table_main_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_metode_pdca`
--
ALTER TABLE `table_metode_pdca`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_misi`
--
ALTER TABLE `table_misi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_pertanyaan`
--
ALTER TABLE `table_pertanyaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_perusahaan`
--
ALTER TABLE `table_perusahaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_produk`
--
ALTER TABLE `table_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_produk_tags`
--
ALTER TABLE `table_produk_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_produk_trust`
--
ALTER TABLE `table_produk_trust`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_profile`
--
ALTER TABLE `table_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_profile_header`
--
ALTER TABLE `table_profile_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_sertified_by`
--
ALTER TABLE `table_sertified_by`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_sinopsis_produk`
--
ALTER TABLE `table_sinopsis_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_visi`
--
ALTER TABLE `table_visi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `table_fasilitas_uji`
--
ALTER TABLE `table_fasilitas_uji`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `table_jenis_produk`
--
ALTER TABLE `table_jenis_produk`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_logo_pelanggan`
--
ALTER TABLE `table_logo_pelanggan`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `table_main_slider`
--
ALTER TABLE `table_main_slider`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table_metode_pdca`
--
ALTER TABLE `table_metode_pdca`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `table_misi`
--
ALTER TABLE `table_misi`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table_pertanyaan`
--
ALTER TABLE `table_pertanyaan`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `table_perusahaan`
--
ALTER TABLE `table_perusahaan`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table_produk`
--
ALTER TABLE `table_produk`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `table_produk_tags`
--
ALTER TABLE `table_produk_tags`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `table_produk_trust`
--
ALTER TABLE `table_produk_trust`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `table_profile`
--
ALTER TABLE `table_profile`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_profile_header`
--
ALTER TABLE `table_profile_header`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `table_sertified_by`
--
ALTER TABLE `table_sertified_by`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_sinopsis_produk`
--
ALTER TABLE `table_sinopsis_produk`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `table_user`
--
ALTER TABLE `table_user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `table_visi`
--
ALTER TABLE `table_visi`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
