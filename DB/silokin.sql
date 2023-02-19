-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Nov 2022 pada 18.30
-- Versi server: 10.4.8-MariaDB
-- Versi PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `silokin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aplikasi`
--

CREATE TABLE `aplikasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_owner` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tlp` varchar(50) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `nama_aplikasi` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `copy_right` varchar(50) DEFAULT NULL,
  `versi` varchar(20) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `aplikasi`
--

INSERT INTO `aplikasi` (`id`, `nama_owner`, `alamat`, `tlp`, `title`, `nama_aplikasi`, `logo`, `copy_right`, `versi`, `tahun`) VALUES
(1, 'DPMD Kab Subang', 'Jl. Subang', '085156328213', 'SILOKIN', 'SILOKIN', 'Lambang_Kabupaten_Subang-removebg-preview.png', 'Copy Right &copy;', '1.0.0.0', 2022);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) UNSIGNED NOT NULL,
  `kdbarang` varchar(15) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `satuan` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kat` int(11) UNSIGNED NOT NULL,
  `nama_kat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int(10) UNSIGNED NOT NULL,
  `jenis_kendaraan` varchar(50) NOT NULL,
  `merk` varchar(100) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `tahun_penerbitan` year(4) NOT NULL,
  `warna` varchar(30) NOT NULL,
  `nomor_polisi` varchar(30) NOT NULL,
  `no_rangka` varchar(50) NOT NULL,
  `bahan_bakar` varchar(50) NOT NULL,
  `pemilik` varchar(100) NOT NULL,
  `berita` varchar(100) NOT NULL,
  `stnk` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `jenis_kendaraan`, `merk`, `tipe`, `tahun_penerbitan`, `warna`, `nomor_polisi`, `no_rangka`, `bahan_bakar`, `pemilik`, `berita`, `stnk`) VALUES
(8, 'Mobil', 'Toyota New Avanza', '1300 G M/T', 2012, 'Putih', 'T 1186 T', 'MHKM1BA3JCJ000066', 'Bensin', 'Drs. Tatang AK', '-', 'doc.pdf'),
(9, 'Mobil', 'Toyota New Avanza', '1300 G M/T', 2012, '-', 'T 360 T', 'MHKM1BA2JCK003589', 'Bensin', 'Drs. Wawan Suwirta', '-', 'doc1.pdf'),
(10, 'Motor', 'Honda Supra Fit', 'NF 100 SE', 2007, '-', 'T 4515 T', 'MH1HB711X7K087055', 'Bensin', 'Eva Farida Utami', '-', 'doc2.pdf'),
(11, 'Motor', 'Supra 125 CW', 'Supra 125 CW', 2017, '-', 'T 2787 T', 'MH1JBP115HK559102', 'Bensin', 'Yudhi Sopiana, S.Sos', '-', 'doc3.pdf'),
(12, 'Motor', 'Supra 125 CW', 'Supra 125 CW', 2017, '-', 'T 2792 T', 'MH1JB115HK559830', 'Bensin', 'Iif Arif Rosyidi, S.Sos', '-', 'doc4.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(10) NOT NULL,
  `ringkas` varchar(100) NOT NULL,
  `nomor_polisi` varchar(100) NOT NULL,
  `dari` varchar(100) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `berkas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `ringkas`, `nomor_polisi`, `dari`, `tgl_masuk`, `berkas`) VALUES
(36, 'Surat Perawatan Kendaraan', 'T 1186 T', 'Bengkel Toyota', '2022-11-01', 'doc.pdf'),
(37, 'Surat Perawatan Kendaraan', 'T 360 T', 'Bengkel Toyota', '2022-11-01', 'doc1.pdf'),
(38, 'Surat Perawatan Kendaraan', 'T 2787 T', 'Bengkel Honda', '2022-11-01', 'doc2.pdf'),
(39, 'Surat Pajak dan STNK', 'T 2792 T', 'Samsat Subang', '2022-11-01', 'doc3.pdf'),
(40, 'Surat Pajak dan STNK', 'T 2787 T', 'Samsat Subang', '2022-11-01', 'doc4.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pajak`
--

CREATE TABLE `pajak` (
  `id` int(10) NOT NULL,
  `pajak` bigint(30) NOT NULL,
  `tgl_pkb` date NOT NULL,
  `nomor_polisi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pajak`
--

INSERT INTO `pajak` (`id`, `pajak`, `tgl_pkb`, `nomor_polisi`) VALUES
(59, 2000000, '2023-01-25', 'T 1186 T'),
(60, 2000000, '2023-04-12', 'T 360 T'),
(61, 2000000, '2023-01-16', 'T 4515 T'),
(62, 2000000, '2022-11-27', 'T 2787 T'),
(63, 2000000, '2022-11-27', 'T 2792 T');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` int(30) NOT NULL,
  `id_user` int(12) NOT NULL,
  `permintaansurat` text NOT NULL,
  `tgl_diajukan` date NOT NULL,
  `keterangan` text NOT NULL,
  `id_status_permintaan` int(12) NOT NULL,
  `alasan_verifikasi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `permintaan`
--

INSERT INTO `permintaan` (`id_permintaan`, `id_user`, `permintaansurat`, `tgl_diajukan`, `keterangan`, `id_status_permintaan`, `alasan_verifikasi`) VALUES
(21, 12, 'Surat Perawatan Kendaraan', '2022-10-22', 'dsadsa', 1, NULL),
(22, 12, 'Surat Perpanjangan STNK', '2022-10-22', 'dsadasd', 1, NULL),
(30, 14, 'Surat Perawatan Kendaraan', '2022-11-01', 'T 2792 T\r\n-Ganti Oli', 2, 'Silahkan ambil surat pengantar di bagian umum'),
(31, 9, 'Surat Perawatan Kendaraan', '2022-11-01', 'T 360 T\r\n- Ganti Oli\r\n', 1, NULL),
(32, 9, 'Surat Perpanjangan STNK', '2022-11-01', 'T 1186 T', 3, 'Belum jatuh tempo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_permintaan`
--

CREATE TABLE `status_permintaan` (
  `id_status_permintaan` int(11) NOT NULL,
  `status_permintaan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status_permintaan`
--

INSERT INTO `status_permintaan` (`id_status_permintaan`, `status_permintaan`) VALUES
(1, 'Menunggu Konfirmasi'),
(2, 'Diterima'),
(3, 'Ditolak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_akses_menu`
--

CREATE TABLE `tbl_akses_menu` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `view_level` enum('Y','N') DEFAULT 'N',
  `add_level` enum('Y','N') DEFAULT 'N',
  `edit_level` enum('Y','N') DEFAULT 'N',
  `delete_level` enum('Y','N') DEFAULT 'N',
  `print_level` enum('Y','N') DEFAULT 'N',
  `upload_level` enum('Y','N') DEFAULT 'N',
  `v_btn` enum('Y','N') DEFAULT 'N',
  `v_btn1` enum('Y','N') DEFAULT 'N',
  `v_btn2` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_akses_menu`
--

INSERT INTO `tbl_akses_menu` (`id`, `id_level`, `id_menu`, `view_level`, `add_level`, `edit_level`, `delete_level`, `print_level`, `upload_level`, `v_btn`, `v_btn1`, `v_btn2`) VALUES
(1, 1, 1, 'Y', 'N', 'N', 'N', 'N', 'N', 'Y', 'Y', 'N'),
(2, 1, 2, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(43, 4, 1, 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(44, 4, 2, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(73, 1, 55, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(74, 4, 55, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(76, 6, 1, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(77, 6, 2, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(78, 6, 55, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(79, 1, 56, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(80, 4, 56, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(81, 6, 56, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(82, 1, 57, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(83, 4, 57, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(84, 6, 57, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(85, 1, 1, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(86, 4, 1, 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(87, 6, 1, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_akses_submenu`
--

CREATE TABLE `tbl_akses_submenu` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_level` int(11) NOT NULL,
  `id_submenu` int(11) NOT NULL,
  `view_level` enum('Y','N') DEFAULT 'N',
  `add_level` enum('Y','N') DEFAULT 'N',
  `edit_level` enum('Y','N') DEFAULT 'N',
  `delete_level` enum('Y','N') DEFAULT 'N',
  `print_level` enum('Y','N') DEFAULT 'N',
  `upload_level` enum('Y','N') DEFAULT 'N',
  `v_btn` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_akses_submenu`
--

INSERT INTO `tbl_akses_submenu` (`id`, `id_level`, `id_submenu`, `view_level`, `add_level`, `edit_level`, `delete_level`, `print_level`, `upload_level`, `v_btn`) VALUES
(2, 1, 2, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(4, 1, 1, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(6, 1, 7, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(7, 1, 8, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(9, 1, 10, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(59, 4, 1, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(60, 4, 2, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(61, 4, 7, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(62, 4, 8, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(63, 4, 10, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(141, 1, 47, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(142, 4, 47, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(144, 1, 48, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(145, 4, 48, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(147, 1, 49, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(148, 4, 49, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(150, 1, 50, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(151, 4, 50, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(153, 6, 1, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(154, 6, 2, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(155, 6, 7, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(156, 6, 8, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(157, 6, 10, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(158, 6, 47, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(159, 6, 48, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(160, 6, 49, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(161, 6, 50, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(162, 1, 51, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(163, 4, 51, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(165, 6, 51, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(166, 1, 52, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(167, 4, 52, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(168, 6, 52, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(169, 1, 53, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(170, 4, 53, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(171, 6, 53, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(172, 1, 54, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(173, 4, 54, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(174, 6, 54, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(175, 1, 55, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(176, 4, 55, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(177, 6, 55, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(178, 1, 56, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(179, 4, 56, 'N', 'N', 'N', 'N', 'N', 'N', 'N'),
(180, 6, 56, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_ket`
--

CREATE TABLE `tbl_ket` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_ket`
--

INSERT INTO `tbl_ket` (`id`, `nama`, `keterangan`) VALUES
(2, 'Tujuan Service', 'Golden AHASS (07298)'),
(3, 'Tujuan Service', 'Suzuki Lima Motor'),
(4, 'No Ketentuan', 'PL.07/26/Honda-DPMD/2022, tanggal 05 Januari 2021.'),
(5, 'No Ketentuan', 'PL.07/23/Toyota-DPMD/2021, tanggal 05 Januari 2021.'),
(6, 'No Ketentuan', 'PL.07/25/Suzuki-DPMD/2022, tanggal 05 Januari 2021.'),
(7, 'Tujuan Service', 'Wijaya Toyota');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(50) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `urutan` bigint(11) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `parent` enum('Y') DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_menu`
--

INSERT INTO `tbl_menu` (`id_menu`, `nama_menu`, `link`, `icon`, `urutan`, `is_active`, `parent`) VALUES
(1, 'Dashboard', 'dashboard', 'fas fa-tachometer-alt', 1, 'Y', 'Y'),
(2, 'System', '#', 'fas fa-cogs', 10, 'Y', 'Y'),
(55, 'Inventaris', '#', 'fa fa-database', 3, 'Y', 'Y'),
(56, 'Pemeliharaan', '#', 'fa fa-book', 4, 'Y', 'Y'),
(58, 'Dashboard', 'dashboard_user', 'fas fa-tachometer-alt', 2, 'Y', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_submenu`
--

CREATE TABLE `tbl_submenu` (
  `id_submenu` int(11) NOT NULL,
  `nama_submenu` varchar(50) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_submenu`
--

INSERT INTO `tbl_submenu` (`id_submenu`, `nama_submenu`, `link`, `icon`, `id_menu`, `is_active`) VALUES
(1, 'Menu', 'menu', 'far fa-circle', 2, 'Y'),
(2, 'SubMenu', 'submenu', 'far fa-circle', 2, 'Y'),
(7, 'Aplikasi', 'aplikasi', 'far fa-circle', 2, 'Y'),
(8, 'User', 'user', 'far fa-circle', 2, 'Y'),
(10, 'User Level', 'userlevel', 'far fa-circle', 2, 'Y'),
(48, 'Data Kendaraan Dinas', 'datakendaraan', 'far fa-circle', 55, 'Y'),
(49, 'Data Pajak Kendaraan', 'datapajak', 'far fa-circle', 55, 'Y'),
(50, 'Surat Pajak dan STNK', 'perpanjangstnk', 'far fa-circle', 56, 'Y'),
(51, 'Laporan', 'laporan', 'far fa-circle', 56, 'Y'),
(52, 'Surat Perawatan', 'pengajuanperawatan', 'far fa-circle', 56, 'Y'),
(53, 'Permintaan Surat', 'permintaansurat', 'far fa-circle', 56, 'Y'),
(54, 'Data Permintaan', 'datapermintaan_u', 'far fa-circle', 56, 'Y'),
(55, 'Data Permintaan', 'datapermintaan_a', 'far fa-circle', 56, 'Y'),
(56, 'Keterangan', 'keterangan', 'far fa-circle', 2, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(30) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_level` int(11) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `id_loket` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `full_name`, `password`, `id_level`, `image`, `is_active`, `id_loket`) VALUES
(1, 'admin', 'Administrator', '$2y$05$iKY4j6YutFUcFov6Cyv4du9kokPpP52zHgNwFNFpA1QCimo25l83m', 1, 'admin1.jpg', 'Y', NULL),
(9, 'user', 'User', '$2y$05$SyonsXtruzjE/CsN5jAlWOmWEciO1AWg3W73.gI5B8uD5a5raFa5C', 4, 'user1.jpg', 'Y', NULL),
(10, 'bayubiantara', 'Bayu Biantara', '$2y$05$Xkgf8qy4jNYAes/tHemEl.pM9DGoTlg.2fTarWswHaaGZUI.9o0ku', 6, 'bayubiantara.jpg', 'Y', NULL),
(14, 'user1', 'User1', '$2y$05$iAMBPrXgC1vnhrttG73iye7T1l7FaDWJkhceSW0aeFqGikU7LpKda', 4, 'user11.jpg', 'Y', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_userlevel`
--

CREATE TABLE `tbl_userlevel` (
  `id_level` int(11) UNSIGNED NOT NULL,
  `nama_level` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_userlevel`
--

INSERT INTO `tbl_userlevel` (`id_level`, `nama_level`) VALUES
(1, 'admin'),
(4, 'user'),
(6, 'superadmin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kat`);

--
-- Indeks untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pajak`
--
ALTER TABLE `pajak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomor_polisi` (`nomor_polisi`);

--
-- Indeks untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indeks untuk tabel `status_permintaan`
--
ALTER TABLE `status_permintaan`
  ADD PRIMARY KEY (`id_status_permintaan`);

--
-- Indeks untuk tabel `tbl_akses_menu`
--
ALTER TABLE `tbl_akses_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_level` (`id_level`);

--
-- Indeks untuk tabel `tbl_akses_submenu`
--
ALTER TABLE `tbl_akses_submenu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_submenu` (`id_submenu`),
  ADD KEY `id_level` (`id_level`);

--
-- Indeks untuk tabel `tbl_ket`
--
ALTER TABLE `tbl_ket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `tbl_submenu`
--
ALTER TABLE `tbl_submenu`
  ADD PRIMARY KEY (`id_submenu`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_level` (`id_level`);

--
-- Indeks untuk tabel `tbl_userlevel`
--
ALTER TABLE `tbl_userlevel`
  ADD PRIMARY KEY (`id_level`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aplikasi`
--
ALTER TABLE `aplikasi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kat` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `pajak`
--
ALTER TABLE `pajak`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id_permintaan` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `status_permintaan`
--
ALTER TABLE `status_permintaan`
  MODIFY `id_status_permintaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_akses_menu`
--
ALTER TABLE `tbl_akses_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT untuk tabel `tbl_akses_submenu`
--
ALTER TABLE `tbl_akses_submenu`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT untuk tabel `tbl_ket`
--
ALTER TABLE `tbl_ket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `tbl_submenu`
--
ALTER TABLE `tbl_submenu`
  MODIFY `id_submenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tbl_userlevel`
--
ALTER TABLE `tbl_userlevel`
  MODIFY `id_level` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_submenu`
--
ALTER TABLE `tbl_submenu`
  ADD CONSTRAINT `tbl_submenu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `tbl_menu` (`id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
