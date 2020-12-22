-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 21 Des 2020 pada 17.57
-- Versi server: 8.0.22-0ubuntu0.20.04.3
-- Versi PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `nis` varchar(10) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jk` varchar(2) DEFAULT NULL,
  `ttl` date DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`nis`, `nama`, `jk`, `ttl`, `kelas`, `image`) VALUES
('12192842', 'Taufik Maulana', 'L', '1979-07-13', '12 MM', 'default.png'),
('12192933', 'Andhika Ferrial Putra', 'L', '1997-03-03', '12.3C.39', 'default.png'),
('18827304', 'Enci Nursyamsyi', 'L', '1989-06-07', '12.1C.29', 'default.png'),
('19298837', 'Febryana Nabilla Setiawaty', 'P', '2000-02-05', '12.19.E3', 'default.png'),
('19299289', 'Rimba Dewangga Alamsyah', 'L', '2000-07-13', '12.2C.88', 'default.png'),
('19927739', 'Siti Harfiah Mailian', 'P', '1999-03-16', '12.3C.99', 'default.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `kode_buku` varchar(5) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `pengarang` varchar(50) DEFAULT NULL,
  `klasifikasi` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`kode_buku`, `judul`, `pengarang`, `klasifikasi`, `image`) VALUES
('001', 'Aplikasi Praktis Asuhan Keperawatan Keluarga', 'Komang Ayu Heni', 'buku tentang praktik asuhan', 'default.png'),
('002', 'Bangsa gagal ; Mencari identitas kebangsaan', 'Nasruddin Anshoriy', 'buku tentang mencari identitas kebangsaan', 'default.png'),
('003', 'Cedera Kepala', 'M. Z. Arifin', 'Buku tentang cedera kepala', 'default.png'),
('004', 'Akutanis Pengatar 1', 'Supardi', 'Buku tentang akutansi', 'default.png'),
('005', 'Buku ajar tumbuh kembang remaja & permasalahanya', 'Soetjiningsih', 'Buku tentang tumbuh kembang remaja', 'default.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` tinyint UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `menu_group` tinyint UNSIGNED DEFAULT NULL,
  `position` tinyint UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `title`, `url`, `icon`, `menu_group`, `position`, `created_at`, `deleted_at`) VALUES
(1, 'Data Master', NULL, ' icon-docs', 1, 1, '2020-12-18 20:34:45', NULL),
(2, 'Transaksi', NULL, 'icon-cloud-upload', 1, 2, '2020-12-20 21:05:23', NULL),
(3, 'Laporan', NULL, 'icon-paper-plane', 1, 3, '2020-12-20 21:05:23', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_group`
--

CREATE TABLE `menu_group` (
  `id` tinyint UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `position` tinyint UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `menu_group`
--

INSERT INTO `menu_group` (`id`, `title`, `position`, `created_at`, `deleted_at`) VALUES
(1, 'Main Menu', 1, '2020-12-18 20:33:50', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_sub`
--

CREATE TABLE `menu_sub` (
  `id` tinyint UNSIGNED NOT NULL,
  `menu` tinyint UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `position` tinyint UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `menu_sub`
--

INSERT INTO `menu_sub` (`id`, `menu`, `title`, `url`, `position`, `created_at`, `deleted_at`) VALUES
(1, 1, 'Buku', 'buku/', 1, '2020-12-18 20:36:02', NULL),
(2, 1, 'Anggota', 'anggota/', 2, '2020-12-18 20:36:02', NULL),
(3, 1, 'Petugas', 'petugas/', 3, '2020-12-18 20:36:02', NULL),
(6, 2, 'Peminjaman', 'peminjaman/', 1, '2020-12-20 21:06:40', NULL),
(7, 2, 'Pengembalian', 'pengembalian/', 2, '2020-12-20 21:06:40', NULL),
(13, 3, 'Buku', 'laporan/buku', 1, '2020-12-20 21:16:15', NULL),
(14, 3, 'Anggota', 'laporan/anggota', 2, '2020-12-20 21:16:15', NULL),
(16, 3, 'Peminjaman', 'laporan/peminjaman/', 4, '2020-12-20 21:16:15', NULL),
(17, 3, 'Pengembalian', 'laporan/pengembalian', 5, '2020-12-20 21:16:15', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_transaksi` varchar(12) DEFAULT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `denda` varchar(2) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `id_petugas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`id_transaksi`, `tgl_pengembalian`, `denda`, `nominal`, `id_petugas`) VALUES
('20201221001', '2020-12-21', 'Y', 100, NULL),
('20201221001', '2020-12-21', 'Y', 100, NULL),
('20201221002', '2020-12-21', 'Y', 100000, NULL),
('20201221002', '2020-12-21', 'Y', 100000, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int NOT NULL,
  `user` varchar(45) DEFAULT NULL,
  `password` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `user`, `password`) VALUES
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(5, 'user21', 'd9b1d7db4cd6e70935368a1efb10e377');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` smallint UNSIGNED NOT NULL,
  `nis` varchar(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` tinyint UNSIGNED NOT NULL,
  `nama` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aktif` enum('Y','T') NOT NULL DEFAULT 'T',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `nama`, `aktif`, `created_at`, `deleted_at`) VALUES
(1, '2020/2021', 'Y', '2020-12-19 00:24:15', NULL),
(2, '2019/2020', 'T', '2020-12-19 00:25:39', NULL),
(3, '2018/2019', 'T', '2020-12-19 00:25:53', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp`
--

CREATE TABLE `tmp` (
  `kode_buku` varchar(5) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `pengarang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(12) DEFAULT NULL,
  `nis` varchar(10) DEFAULT NULL,
  `kode_buku` varchar(5) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `id_petugas` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `nis`, `kode_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `id_petugas`) VALUES
('20201221001', '12192842', '001', '2020-12-21', '2020-12-28', 'Y', NULL),
('20201221002', '12192842', '001', '2020-12-21', '2020-12-28', 'Y', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`nis`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`kode_buku`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_group` (`menu_group`);

--
-- Indeks untuk tabel `menu_group`
--
ALTER TABLE `menu_group`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menu_sub`
--
ALTER TABLE `menu_sub`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu` (`menu`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- Indeks untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `menu_group`
--
ALTER TABLE `menu_group`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `menu_sub`
--
ALTER TABLE `menu_sub`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`menu_group`) REFERENCES `menu_group` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `menu_sub`
--
ALTER TABLE `menu_sub`
  ADD CONSTRAINT `menu_sub_ibfk_1` FOREIGN KEY (`menu`) REFERENCES `menu` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
