-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Okt 2024 pada 07.43
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
-- Database: `kasirr`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `profit_margin` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `product_id`, `profit_margin`) VALUES
(71, 'TV', 9200000.00, 2, 0, 15.00),
(72, 'MONITOR', 5600000.00, 5, 0, 12.00),
(73, 'PC', 18900000.00, 1, 0, 5.00),
(74, 'HP', 5250000.00, 2, 0, 5.00),
(75, 'IPAD', 8960000.00, 6, 0, 12.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `purchase_history`
--

INSERT INTO `purchase_history` (`id`, `username`, `product_id`, `product_name`, `quantity`, `total_price`, `purchase_date`) VALUES
(9, 'pandjie', 72, 'MONITOR', 4, 22400000.00, '2024-10-24 05:34:05'),
(10, 'pandjie', 71, 'TV', 2, 18400000.00, '2024-10-24 05:36:21'),
(11, 'pandjie', 71, 'TV', 2, 18400000.00, '2024-10-24 05:37:47'),
(12, 'pandjie', 71, 'TV', 1, 9200000.00, '2024-10-24 05:38:20'),
(13, 'pandjie', 71, 'TV', 1, 9200000.00, '2024-10-24 05:38:34'),
(14, 'pandjie', 71, 'TV', 1, 9200000.00, '2024-10-24 05:38:44'),
(15, 'pandjie', 75, 'IPAD', 1, 8960000.00, '2024-10-24 05:38:53'),
(16, 'pandjie', 75, 'IPAD', 1, 8960000.00, '2024-10-24 05:39:04'),
(17, 'pandjie', 72, 'MONITOR', 1, 5600000.00, '2024-10-24 05:39:12'),
(18, 'Segu', 71, 'TV', 1, 9200000.00, '2024-10-24 05:40:17'),
(19, 'Segu', 75, 'IPAD', 2, 17920000.00, '2024-10-24 05:40:21'),
(20, 'muko', 74, 'HP', 2, 10500000.00, '2024-10-24 05:41:24'),
(21, 'muko', 73, 'PC', 1, 18900000.00, '2024-10-24 05:41:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(3, 'panjie', '$2y$10$KRauypmrzsnA6R6igiDXqeTGNKOLffsDt1N/PVd0L1Ez/1OjtrZPW'),
(22, 'pandjie', '$2y$10$P.SXFFlRG0FIZL9E0gq.VOjRBNH.UEp0YWem/9gRIBE3p3FnZoSbC'),
(23, 'Segu', '$2y$10$L5yQl3w8qT3V2N3a4.7fH.MRVOwnAsLW8u8BbtdqehsJXWvihu3tm'),
(24, 'muko', '$2y$10$0C7wMx3HR.A5UVck7uB8Uu9uYUCwoFPb5bFv1tBGCS0uQjeNd46eO');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
