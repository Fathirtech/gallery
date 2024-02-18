-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 18, 2024 at 03:37 PM
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
  `userid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`albumid`, `namaalbum`, `deskripsi`, `tanggaldibuat`, `userid`) VALUES
(6, 'game', 'foto game game', '2024-01-27', 2),
(7, 'game', 'mantap', '2024-01-29', 3),
(10, 'random', 'foto random ', '2024-01-31', 3),
(25, 'admin', 'album admin', '2024-02-07', 1),
(31, 'foto ', 'saya', '2024-02-09', 4);

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
(8, 'wallpaper', 'keren', '2024-01-29', '258073463_Screenshot (4).png', 6, 3, 0),
(12, 'wallpaper', 'keren', '2024-01-31', '652696139_Screenshot (28).png', 6, 3, 0),
(13, 'inova', 'mobil gua kece banget', '2024-01-31', '1322180188_inova3.jpg', 6, 2, 0),
(15, 'civic', 'civic type r', '2024-02-07', '1239345363_Screenshot (5).png', 6, 2, 0),
(20, 'barudak', '12 rpl ', '2024-02-07', '1007551567_WhatsApp Image 2024-02-02 at 18.07.46_673a1339.jpg', 25, 1, 1),
(21, 'motor custom', 'motor gua', '2024-02-08', '1640894511_Screenshot (184).png', 6, 2, 0),
(25, 'software 1', 'keren banget', '2024-02-09', '882299358_b9bbf30b-0e9b-4b89-b810-fcf4181e0e6e.jpg', 25, 1, 1);

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
(27, 20, 2, 'well', '2024-02-09'),
(28, 13, 2, 'kece bang', '2024-02-09'),
(30, 12, 2, 'mantap bang', '2024-02-11'),
(31, 13, 4, 'keren', '2024-02-12'),
(40, 25, 1, 'wallpaper elegan', '2024-02-18');

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
(17, 8, 2, '2024-02-02'),
(25, 15, 1, '2024-02-07'),
(27, 20, 2, '2024-02-07'),
(28, 20, 4, '2024-02-08'),
(29, 21, 1, '2024-02-08'),
(34, 20, 1, '2024-02-09'),
(93, 21, 2, '2024-02-09'),
(105, 8, 1, '2024-02-11'),
(121, 21, 4, '2024-02-12'),
(122, 12, 4, '2024-02-12'),
(124, 13, 4, '2024-02-12'),
(127, 15, 4, '2024-02-12'),
(129, 25, 4, '2024-02-12'),
(138, 13, 1, '2024-02-14'),
(143, 15, 2, '2024-02-14'),
(148, 12, 1, '2024-02-16'),
(157, 13, 2, '2024-02-16'),
(159, 12, 2, '2024-02-18');

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
  `role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `email`, `namalengkap`, `alamat`, `role`) VALUES
(1, 'admin', 'adminpassword', 'admin@example.com', 'Admin User', 'Admin Address', 'admin'),
(2, 'fathir', '123', 'abdoelfathir708@gmail.com', 'fathir', 'banjar', 'user'),
(3, 'ryn', '1234567890', 'ryanyanuar184@gmail.com', 'Ryan Yanuar Pradana', 'Jepun', 'user'),
(4, 'dimas', '456', 'dimas06@gmail.com', 'dimas nur', 'cikabu', 'user'),
(6, 'rendi', '123', 'rendi@gmail.com', 'rendi', 'bandung', 'user'),
(7, 'ahmad', '123', 'ahmad@gmail.com', 'ahmad', 'sukarame', 'user');

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
  MODIFY `albumid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `fotoid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  MODIFY `komentarid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `likefoto`
--
ALTER TABLE `likefoto`
  MODIFY `likeid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
