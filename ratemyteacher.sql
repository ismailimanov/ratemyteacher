--
-- Struktur-dump for tabellen `rating`
--

CREATE TABLE `rating` (
  `ratingId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `rating`
--

INSERT INTO `rating` (`ratingId`, `userId`, `rating`, `teacherId`) VALUES
(41, 17, 5, 2),
(42, 17, 4, 3),
(43, 17, 4, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `subject`
--

CREATE TABLE `subject` (
  `subjectId` int(11) NOT NULL,
  `subjectName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `subject`
--

INSERT INTO `subject` (`subjectId`, `subjectName`) VALUES
(1, 'Dansk'),
(2, 'Engelsk'),
(3, 'Matematik'),
(4, 'Geografi'),
(5, 'Fysik'),
(6, 'Idræt'),
(7, 'Biologi'),
(8, 'Kristendom'),
(9, 'Tysk'),
(10, 'Fransk'),
(11, 'Sløjd');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `teacher`
--

CREATE TABLE `teacher` (
  `teacherId` int(11) NOT NULL,
  `teacherName` varchar(100) NOT NULL,
  `teacherImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `teacher`
--

INSERT INTO `teacher` (`teacherId`, `teacherName`, `teacherImage`) VALUES
(1, 'Jens', 'uploads/1504989540886-favicon.png'),
(2, 'Søren', 'uploads/1504989872271-favicon.png'),
(3, 'Peter', 'uploads/1504991278850-slide1-c.png');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `teacherSubject`
--

CREATE TABLE `teacherSubject` (
  `teacherId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `teacherSubject`
--

INSERT INTO `teacherSubject` (`teacherId`, `subjectId`) VALUES
(1, 1),
(2, 4),
(3, 7);

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
(1, 'ismail', '$2y$10$AQZMszzCVUbb3muLiztL8Om5DwqFo4Xi1m2q/xqNFaYB.7gcJA0eq', 'ismail@imanov.dk'),
(2, 'asd', '$2y$10$4xN7eqZLZGhXFY/N.i4KC.euAAd9F97/RvwjQKk16RcEAesn1jWFq', 'asd@asd.dk'),
(17, 'drake', '$2y$10$wUZE6ZSBNNB..c347l7sPeAscqOmGoT09Uca.jfpUePbGlcQmFrKm', 'drake@startedfromthebottom.com');

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
  MODIFY `ratingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- Tilføj AUTO_INCREMENT i tabel `subject`
--
ALTER TABLE `subject`
  MODIFY `subjectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Tilføj AUTO_INCREMENT i tabel `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacherId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Tilføj AUTO_INCREMENT i tabel `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `teacherRating` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`teacherId`),
  ADD CONSTRAINT `user` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Begrænsninger for tabel `teacherSubject`
--
ALTER TABLE `teacherSubject`
  ADD CONSTRAINT `subject` FOREIGN KEY (`subjectId`) REFERENCES `subject` (`subjectId`),
  ADD CONSTRAINT `teacher` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`teacherId`);
COMMIT;
