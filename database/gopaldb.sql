-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Bulan Mei 2025 pada 02.25
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gopaldb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `password_admin` varchar(50) NOT NULL,
  `foto_admin` varchar(255) DEFAULT NULL,
  `no_hp_admin` varchar(20) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `password_admin`, `foto_admin`, `no_hp_admin`, `jenis_kelamin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'face6.jpg', '085813640260', 'Perempuan'),
(2, 'adam', '1d7c2923c1684726dc23d2901c4d8157', '829701423_IMG-20231013-WA0039.jpg', '081293564998', 'Laki-laki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayar`
--

CREATE TABLE `bayar` (
  `id_bayar` int(11) NOT NULL,
  `id_utang` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `jumlah_bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bayar`
--

INSERT INTO `bayar` (`id_bayar`, `id_utang`, `id_admin`, `tanggal_bayar`, `jumlah_bayar`) VALUES
(22, 27, 2, '2025-05-21', 23500),
(23, 26, 2, '2025-05-21', 30000),
(24, 25, 2, '2025-05-21', 10000),
(25, 30, 2, '2025-05-21', 20000),
(26, 31, 2, '2025-05-21', 100000),
(27, 34, 2, '2025-05-23', 14800);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `no_hp_pelanggan` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `no_hp_pelanggan`, `email`, `alamat`) VALUES
(14, 'Binar', '08321738131', '', '0'),
(15, 'Adai', '083910293123', '', '0'),
(18, 'Hapis', '089211005937', '', '0'),
(31, 'Anomali', '12345678910', '', '0'),
(40, 'Ainun', '08321738131', '', '0'),
(41, 'tes', '08321738131', '', '0'),
(42, 'Onay', '083910293123', '', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemilik`
--

CREATE TABLE `pemilik` (
  `id_pemilik` int(11) NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL,
  `password_pemilik` varchar(50) NOT NULL,
  `no_hp_pemilik` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemilik`
--

INSERT INTO `pemilik` (`id_pemilik`, `nama_pemilik`, `password_pemilik`, `no_hp_pemilik`) VALUES
(1, 'gopal', 'gopal', '085813640261');

-- --------------------------------------------------------

--
-- Struktur dari tabel `utang`
--

CREATE TABLE `utang` (
  `id_utang` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `jumlah_utang` int(11) NOT NULL,
  `status` enum('sudah_lunas','belum_lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `utang`
--

INSERT INTO `utang` (`id_utang`, `id_pelanggan`, `id_admin`, `tanggal`, `jatuh_tempo`, `jumlah_utang`, `status`) VALUES
(25, 14, 2, '2025-05-21', '2025-05-22', 10000, 'sudah_lunas'),
(26, 15, 2, '2025-05-20', '2025-05-22', 30000, 'sudah_lunas'),
(27, 18, 2, '2025-05-14', '2025-05-22', 50000, 'belum_lunas'),
(28, 31, 2, '2025-05-16', '2025-05-22', 65500, 'belum_lunas'),
(29, 40, 2, '2025-05-21', '2025-05-22', 78300, 'belum_lunas'),
(30, 31, 2, '2025-05-24', '2025-05-22', 20000, 'sudah_lunas'),
(31, 14, 2, '2025-05-23', '2025-05-22', 100000, 'sudah_lunas'),
(32, 14, 2, '2025-05-21', '2025-05-22', 20000, 'belum_lunas'),
(33, 31, 2, '2025-05-21', '2025-05-22', 18000, 'belum_lunas'),
(34, 42, 2, '2025-05-23', '2025-05-24', 14800, 'sudah_lunas'),
(35, 42, 2, '2025-05-23', '2025-05-24', 30000, 'belum_lunas');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `bayar`
--
ALTER TABLE `bayar`
  ADD PRIMARY KEY (`id_bayar`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pemilik`
--
ALTER TABLE `pemilik`
  ADD PRIMARY KEY (`id_pemilik`);

--
-- Indeks untuk tabel `utang`
--
ALTER TABLE `utang`
  ADD PRIMARY KEY (`id_utang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `bayar`
--
ALTER TABLE `bayar`
  MODIFY `id_bayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `pemilik`
--
ALTER TABLE `pemilik`
  MODIFY `id_pemilik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `utang`
--
ALTER TABLE `utang`
  MODIFY `id_utang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
