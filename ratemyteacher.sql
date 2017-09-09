-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Vært: localhost
-- Genereringstid: 08. 09 2017 kl. 10:15:28
-- Serverversion: 10.1.21-MariaDB
-- PHP-version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ratemyteacher`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `rating`
--

CREATE TABLE `rating` (
  `ratingId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `subject`
--

CREATE TABLE `subject` (
  `subjectId` int(11) NOT NULL,
  `subjectName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `teacher`
--

CREATE TABLE `teacher` (
  `teacherId` int(11) NOT NULL,
  `teacherName` varchar(100) NOT NULL,
  `teacherImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `teacherSubject`
--

CREATE TABLE `teacherSubject` (
  `teacherId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `user`
--

INSERT INTO `user` (`userId`, `username`, `password`, `email`) VALUES
(1, 'asd', '$2y$10$4xN7eqZLZGhXFY/N.i4KC.euAAd9F97/RvwjQKk16RcEAesn1jWFq', 'asd@assd.dk'),
(16, 'Ismail', '$2y$10$pTsEkv2ijcFAlXPS8a/qi.1E0xQqwq9PZLzWzTta2ew9XTsBoBVf.', 'ismail@imanov.dk');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ratingId`,`userId`,`teacherId`),
  ADD KEY `user` (`userId`),
  ADD KEY `teacherRating` (`teacherId`);

--
-- Indeks for tabel `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subjectId`);

--
-- Indeks for tabel `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacherId`);

--
-- Indeks for tabel `teacherSubject`
--
ALTER TABLE `teacherSubject`
  ADD PRIMARY KEY (`teacherId`,`subjectId`),
  ADD KEY `subject` (`subjectId`);

--
-- Indeks for tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `rating`
--
ALTER TABLE `rating`
  MODIFY `ratingId` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `subject`
--
ALTER TABLE `subject`
  MODIFY `subjectId` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacherId` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `teacherRating` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`teacherId`),
  ADD CONSTRAINT `user` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);


ALTER TALBE `note`
  ADD CONSTRAINT `
--
-- Begrænsninger for tabel `teacherSubject`
--
ALTER TABLE `teacherSubject`
  ADD CONSTRAINT `subject` FOREIGN KEY (`subjectId`) REFERENCES `subject` (`subjectId`),
  ADD CONSTRAINT `teacher` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`teacherId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
