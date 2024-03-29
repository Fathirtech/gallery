-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2024 at 10:29 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `albumid` int NOT NULL,
  `namaalbum` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggaldibuat` date NOT NULL,
  `userid` int NOT NULL,
  `acceslevel` enum('private','public') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'private'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`albumid`, `namaalbum`, `deskripsi`, `tanggaldibuat`, `userid`, `acceslevel`) VALUES
(6, 'game', 'foto game game', '2024-01-27', 2, 'public'),
(7, 'game', 'mantap', '2024-01-29', 3, 'public'),
(10, 'random', 'foto random ', '2024-01-31', 3, 'public'),
(25, 'admin', 'album admin', '2024-02-07', 1, 'public'),
(31, 'foto ', 'saya', '2024-02-09', 4, 'public'),
(53, 'albumku', 'fotoku', '2024-02-20', 6, 'public'),
(56, 'dian', 'album dian', '2024-02-28', 4, 'public');

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `fotoid` int NOT NULL,
  `judulfoto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsifoto` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggalunggah` date NOT NULL,
  `lokasifile` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `albumid` int NOT NULL,
  `userid` int NOT NULL,
  `jumlahlike` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`fotoid`, `judulfoto`, `deskripsifoto`, `tanggalunggah`, `lokasifile`, `albumid`, `userid`, `jumlahlike`) VALUES
(8, 'harimau putih', 'harimau yang langka', '2024-01-29', '738981920_pexels-james-lee-4661795.jpg', 7, 3, 0),
(12, 'tupai', 'tupai yang membawa kacang dimulutnya', '2024-01-31', '1370292093_pexels-skyler-ewing-5627781.jpg', 7, 3, 0),
(13, 'mobil classic', 'mobil tua berwarna putih', '2024-01-31', '428679827_pexels-harry-cunningham-harrydigital-3508085.jpg', 6, 2, 0),
(25, 'kupu kupu', 'kupu kupu yang mendekati bunga', '2024-02-09', '790345276_pexels-pixabay-87452.jpg', 25, 1, 0),
(33, 'bunga matahari', 'bunga  matahari di pagi hari', '2024-02-20', '1273614168_pexels-pixabay-33044.jpg', 31, 4, 0),
(35, 'citylight', 'kota di malam hari', '2024-02-20', '1449956907_pexels-maxime-francis-2246476.jpg', 31, 4, 0),
(38, 'kucing', 'kucing di dahan kayu', '2024-02-20', '1599898805_pexels-pixabay-35888.jpg', 53, 6, 0),
(42, 'astronout', 'astronout diluar angkasa', '2024-02-21', '1939431125_pexels-pixabay-2156.jpg', 6, 2, 0),
(45, 'gunung everest', 'gunung tertinggi di dunia', '2024-02-21', '145574884_pexels-tyler-lastovich-772803.jpg', 25, 1, 0),
(46, 'air terjun', 'air terjun yang indah', '2024-02-21', '1516617529_pexels-pixabay-237321.jpg', 6, 2, 0),
(48, 'gajah', 'gajah di hutan', '2024-02-21', '466372879_pexels-pixabay-247431.jpg', 6, 2, 0),
(51, 'burung ', 'burung berkicau', '2024-03-02', '916642454_pexels-jean-van-der-meulen-1526410.jpg', 6, 2, 0),
(52, 'pantai', 'pantai dari atas', '2024-03-05', '1256423289_pexels-pok-rie-697313.jpg', 53, 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `komentarfoto`
--

CREATE TABLE `komentarfoto` (
  `komentarid` int NOT NULL,
  `fotoid` int NOT NULL,
  `userid` int NOT NULL,
  `isikomentar` text COLLATE utf8mb4_general_ci NOT NULL,
  `tanggalkomentar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentarfoto`
--

INSERT INTO `komentarfoto` (`komentarid`, `fotoid`, `userid`, `isikomentar`, `tanggalkomentar`) VALUES
(6, 8, 3, 'mantap bang', '2024-01-29'),
(23, 8, 4, 'keren', '2024-02-08'),
(28, 13, 2, 'kece bang', '2024-02-09'),
(31, 13, 4, 'keren', '2024-02-12'),
(41, 25, 1, 'keren', '2024-02-19'),
(47, 35, 4, 'kurang bagus poto nya', '2024-02-28'),
(59, 13, 2, 'widiih', '2024-03-05'),
(62, 42, 3, 'kece bang', '2024-03-05'),
(63, 42, 4, 'keren', '2024-03-05'),
(64, 42, 6, 'mantap', '2024-03-05'),
(65, 42, 7, 'mantap', '2024-03-05'),
(66, 42, 1, 'well', '2024-03-05'),
(67, 42, 2, 'mantap', '2024-03-05'),
(69, 12, 2, 'tupainya lucu', '2024-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `likefoto`
--

CREATE TABLE `likefoto` (
  `likeid` int NOT NULL,
  `fotoid` int NOT NULL,
  `userid` int NOT NULL,
  `tanggallike` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likefoto`
--

INSERT INTO `likefoto` (`likeid`, `fotoid`, `userid`, `tanggallike`) VALUES
(7, 8, 3, '2024-01-29'),
(13, 8, 4, '2024-01-31'),
(105, 8, 1, '2024-02-11'),
(122, 12, 4, '2024-02-12'),
(124, 13, 4, '2024-02-12'),
(163, 25, 2, '2024-02-18'),
(164, 25, 1, '2024-02-19'),
(176, 35, 1, '2024-02-20'),
(179, 13, 3, '2024-02-20'),
(182, 13, 6, '2024-02-20'),
(183, 35, 6, '2024-02-20'),
(211, 42, 2, '2024-03-03'),
(216, 42, 6, '2024-03-04'),
(219, 51, 6, '2024-03-04'),
(224, 12, 1, '2024-03-04'),
(227, 42, 1, '2024-03-04'),
(241, 8, 2, '2024-03-05'),
(242, 52, 2, '2024-03-05'),
(245, 52, 7, '2024-03-05'),
(246, 51, 7, '2024-03-05'),
(250, 46, 1, '2024-03-05'),
(256, 48, 6, '2024-03-06'),
(257, 33, 6, '2024-03-06');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `reset_code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reset_password`
--

INSERT INTO `reset_password` (`id`, `email`, `reset_code`) VALUES
(1, 'ryanyanuar184@gmail.com', '960485'),
(2, 'abdoelfathir708@gmail.com', '027134');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namalengkap` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `profile_photo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `email`, `namalengkap`, `alamat`, `role`, `profile_photo`) VALUES
(1, 'admin', 'adminpassword', 'admin@gmail.com', 'Admin User', 'adminadress', 'admin', 'gambar/3135715.png'),
(2, 'fathir', '123', 'abdoelfathir708@gmail.com', 'fathir', 'banjar', 'user', 'gambar/icon-256x256.png'),
(3, 'ryn', '1234567890', 'ryanyanuar184@gmail.com', 'Ryan Yanuar Pradana', 'Jepun', 'user', 'gambar/WhatsApp Image 2024-03-05 at 09.27.38.jpeg'),
(4, 'dimas', '456', 'dadidimas6@gmail.com', 'dimas nur', 'cikabu', 'user', 'gambar/WhatsApp Image 2024-03-05 at 09.25.11.jpeg'),
(6, 'rendi', '123', 'raihanrairendi@gmail.com', 'rendi', 'bandung', 'user', 'gambar/RENDI RAIHANRAI.jpg'),
(7, 'ahmad', '123', 'ahmadnurfdllh0306@gmail.com', 'ahmad', 'sukarame', 'user', 'gambar/WhatsApp Image 2024-03-05 at 09.38.10.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`albumid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`fotoid`),
  ADD KEY `albumid` (`albumid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD PRIMARY KEY (`komentarid`),
  ADD KEY `fotoid` (`fotoid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD PRIMARY KEY (`likeid`),
  ADD KEY `fotoid` (`fotoid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `albumid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `fotoid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  MODIFY `komentarid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `likefoto`
--
ALTER TABLE `likefoto`
  MODIFY `likeid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- AUTO_INCREMENT for table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`albumid`) REFERENCES `album` (`albumid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD CONSTRAINT `komentarfoto_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentarfoto_ibfk_2` FOREIGN KEY (`fotoid`) REFERENCES `foto` (`fotoid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD CONSTRAINT `likefoto_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likefoto_ibfk_2` FOREIGN KEY (`fotoid`) REFERENCES `foto` (`fotoid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
