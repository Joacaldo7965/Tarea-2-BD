-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2023 at 04:33 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tarea2`
--

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `followsId` int(10) NOT NULL,
  `followsUid` varchar(32) NOT NULL,
  `followsUidFollower` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`followsId`, `followsUid`, `followsUidFollower`) VALUES
(15, 'VladimirDostrovieshky', 'JuanPablo'),
(19, 'JuanPablo', 'LaMariaantioneta'),
(20, 'VladimirDostrovieshky', 'LaMariaantioneta'),
(21, 'JuanPablo', 'Br1'),
(23, 'LaMariaantioneta', 'Br1'),
(24, 'VladimirDostrovieshky', 'Br1'),
(26, 'Br1', 'TAFARI'),
(27, 'JuanPablo', 'TAFARI'),
(28, 'LaMariaantioneta', 'TAFARI'),
(29, 'VladimirDostrovieshky', 'TAFARI'),
(30, 'TAFARI', 'Br1'),
(37, 'Br1', 'Miayu'),
(38, 'Yuiovani', 'Miayu'),
(39, 'Krtaxd', 'Miayu'),
(40, 'TAFARI', 'Miayu'),
(42, 'LaMariaantioneta', 'Miayu'),
(43, 'VladimirDostrovieshky', 'Miayu'),
(44, 'JuanPablo', 'Miayu'),
(45, 'Miayu', 'Yuiovani'),
(47, 'Br1', 'Yuiovani'),
(50, 'Yuiovani', 'test3'),
(51, 'Br1', 'test3'),
(52, 'Krtaxd', 'test3'),
(53, 'LaMariaantioneta', 'test3'),
(54, 'VladimirDostrovieshky', 'test3'),
(55, 'JuanPablo', 'test3'),
(56, 'TAFARI', 'test3'),
(57, 'Miayu', 'test3'),
(58, 'Miayu', 'Joacaldo'),
(59, 'Yuiovani', 'Joacaldo'),
(60, 'Krtaxd', 'Joacaldo'),
(63, 'Br1', 'Joacaldo'),
(64, 'TAFARI', 'Joacaldo'),
(65, 'JuanPablo', 'Joacaldo'),
(66, 'LaMariaantioneta', 'Joacaldo'),
(67, 'VladimirDostrovieshky', 'Joacaldo'),
(68, 'yy', 'Joacaldo'),
(69, 'test3', 'Joacaldo'),
(70, 'test3', 'test'),
(71, 'yy', 'test'),
(73, 'Miayu', 'test'),
(74, 'Yuiovani', 'test'),
(75, 'Br1', 'test'),
(76, 'Joacaldo', 'test'),
(77, 'Krtaxd', 'test'),
(78, 'TAFARI', 'test'),
(79, 'LaMariaantioneta', 'test'),
(80, 'JuanPablo', 'test'),
(81, 'VladimirDostrovieshky', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likesId` int(10) NOT NULL,
  `likesUsmitoId` int(10) NOT NULL,
  `likesUserUid` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`likesId`, `likesUsmitoId`, `likesUserUid`) VALUES
(15, 257, 'Br1'),
(16, 258, 'Br1'),
(17, 254, 'Br1'),
(18, 250, 'Br1'),
(21, 255, 'Yuiovani'),
(22, 266, 'Yuiovani'),
(24, 267, 'Miayu'),
(30, 257, 'test3'),
(32, 263, 'Joacaldo'),
(33, 266, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tagsId` varchar(279) NOT NULL,
  `tagsCount` int(10) NOT NULL,
  `tagsRegisterDate` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tagsId`, `tagsCount`, `tagsRegisterDate`) VALUES
('AguanteBioBio', 1, '04/08/21'),
('AguanteColoColo', 1, '03/08/21'),
('asasajskaj', 1, '23/08/21'),
('gentee', 0, '03/08/21'),
('hashtag', 0, '06/08/21'),
('helloworld', 0, '03/08/21'),
('SAVENIGERIA', 1, '03/08/21'),
('SEACABOLACUARENTENA', 1, '04/08/21'),
('shsjak', 1, '23/08/21'),
('test', 0, '03/08/21'),
('tres', 1, '23/08/21'),
('twitter', 0, '03/08/21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersUid` varchar(32) NOT NULL,
  `usersEmail` varchar(50) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `fecha_reg` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usersUid`, `usersEmail`, `usersPwd`, `fecha_reg`) VALUES
('Br1', 'bruno.fuentes@uniacc.edu', '$2y$10$GBb4YBXQg676J0sS7nhPJ.lHtfF3NEUE.TWd8LdHpCdaehRKlZPMi', '03/08/21'),
('Joacaldo', 'joacaldo2303@gmail.com', '$2y$10$lOE8r6GaM.eqQDBxEL8Tue3rYzF/PAt9hE8zkrqgIOcDvGJbIDZQy', '06/08/21'),
('JuanPablo', 'correogenerico@123mail.hot', '$2y$10$/ZgNPos3W5AmoeRJSbR7iezledWkhx/OozE6f78ftOBP2aNPbQMUG', '03/08/21'),
('Krtaxd', 'Hector.castaneda1224@outlook.cl', '$2y$10$Pvp/QCpywQ4Knw4U9hFsVeQ.pO6daYMn5DGV.1XY0u4y8/L26XlR.', '03/08/21'),
('LaMariaantioneta', 'correoparanadainventado@nofalse.cl', '$2y$10$4IW9P/v4JJ0OSNQcvp42XOS33Xsy1120l5b6aIWRUUWSN35ekNcZW', '03/08/21'),
('Miayu', 'conni6035@gmail.com', '$2y$10$Bza31V2ub4PcYfsS0BnjkelYk9iBZOU6659qwT4M8LjBL31CBshka', '04/08/21'),
('TAFARI', 'ammecomiunsapito@sapito.cum', '$2y$10$odZxehcbqhrSS3nwfNEnF.ry8wmITD9qULVEUPZMwNBHokEHzEu2K', '03/08/21'),
('test', 'xd@gmail.com', '$2y$10$OJasxsEyIRITO22sw6e1oeocRwv/hAl5vK6N/7wlP7hEV.lKLhGdq', '20/04/23'),
('test3', 'test@gmail.com', '$2y$10$YPfHNOaJ6/oSUsD.Pq4X0OfimfK/9jjYMlbRREr6.tRlEvDWjHs9y', '23/08/21'),
('VladimirDostrovieshky', '12345@correohot.com', '$2y$10$43bmdFNxbwKTfoE.pFu.FuV7hNEXFaxBN6XcLyWo2qxVLrcgeHnhG', '03/08/21'),
('Yuiovani', 'ashelprimero@gmail.com', '$2y$10$HmUMEk6SA01oyR.3Clch9eQBvyMYhbwsteslnLlNZ9OdugqLNZu.2', '04/08/21'),
('yy', 'ben@gmai.com', '$2y$10$Mmb.Gu8LUQKxT5VE2Gw.vejuoFWL0.F7ClrOHL/3C3JF9ScsE18nC', '13/07/22');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `delete_tag_trigger` AFTER DELETE ON `users` FOR EACH ROW UPDATE tags 
SET tagsCount=
(SELECT COUNT(*) FROM usmitos_tags 
 WHERE usmitos_tags.usmitos_tagsTagId=tags.tagsId)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insert_tag_trigger` AFTER INSERT ON `users` FOR EACH ROW UPDATE tags 
SET tagsCount=
(SELECT COUNT(*) FROM usmitos_tags 
 WHERE usmitos_tags.usmitos_tagsTagId=tags.tagsId)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_tag_trigger` AFTER UPDATE ON `users` FOR EACH ROW UPDATE tags 
SET tagsCount=
(SELECT COUNT(*) FROM usmitos_tags 
 WHERE usmitos_tags.usmitos_tagsTagId=tags.tagsId)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usmitos`
--

CREATE TABLE `usmitos` (
  `usmitosId` int(10) NOT NULL,
  `usmitosUid` varchar(32) NOT NULL,
  `usmitosMessage` text NOT NULL,
  `usmitosLikes` int(10) NOT NULL,
  `usmitosTags` text NOT NULL,
  `usmitosTipo` varchar(32) NOT NULL,
  `usmitosIdPadre` int(11) DEFAULT NULL,
  `usmitosCloseFriends` tinyint(1) DEFAULT NULL,
  `usmitosFechaPub` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usmitos`
--

INSERT INTO `usmitos` (`usmitosId`, `usmitosUid`, `usmitosMessage`, `usmitosLikes`, `usmitosTags`, `usmitosTipo`, `usmitosIdPadre`, `usmitosCloseFriends`, `usmitosFechaPub`) VALUES
(250, 'JuanPablo', 'Hola mundo o/', 0, '', 'USMITO', NULL, 0, '03/08/21 - 22:22:55'),
(251, 'VladimirDostrovieshky', 'Russia (Russian: Россия, Rossiya, Russian pronunciation: [rɐˈsʲijə]), or the Russian Federation,[b] is a country spanning Eastern Europe and Northern Asia. It is the largest country in the world, covering over 17 million square kilometres (6.6×106 sq mi)', 0, '', 'USMITO', NULL, 0, '03/08/21 - 22:25:02'),
(254, 'LaMariaantioneta', 'Hola chiquitos mios ✌ me es de mi agrado informarles mi pime sobre mis productos para alineamiento de ✨✨energías y chacras ✨✨ envios por todo chile 🌟🌟', 0, '', 'USMITO', NULL, 0, '03/08/21 - 22:30:18'),
(255, 'Br1', 'buenas tardes busco actores para representar la obra el quijote de la mancha: comuníquese al correo de mi bio porfavor difundir si conoce a laguien', 0, '', 'USMITO', NULL, 0, '03/08/21 - 22:32:52'),
(257, 'TAFARI', 'HOLA SOY LA ORDEN DE NIGERIA, TE PUEDO DAR MAS GOBIERNO PERO NECESITO QUE ME DIGAS LA SIGUIENTE INFORMACION HERMANOS: TAFARI MAMADOU NOLLO OSSAS RUT GENEALOLOGICAL NIGERIAN 12321-2\r\nES UNA GRAN RESPONSABILIDAD APRESURARTE EN ESTE LUGAR PARA QUE PUEDA TOMAR EL RELOJ DE MUJERES...', 0, '', 'USMITO', NULL, 0, '03/08/21 - 22:37:06'),
(258, 'TAFARI', 'TU TRIBU Y TU FAMILIA Y HACERLO UN PUEBLO.\r\nHonestamente se despide:\r\nTAFARI MAMADOU NOLLO OSSAS #SAVENIGERIA', 0, 'SAVENIGERIA', 'USMITO', NULL, 0, '03/08/21 - 22:37:38'),
(263, 'Krtaxd', '#AguanteColoColo', 0, 'AguanteColoColo', 'USMITO', NULL, 0, '03/08/21 - 23:44:10'),
(264, 'Br1', 'CUIDADO QUE SE QUEMA !!!!!', 0, '', 'USMITO', NULL, 1, '03/08/21 - 23:56:16'),
(265, 'Yuiovani', '#AguanteBioBio', 0, 'AguanteBioBio', 'USMITO', NULL, 0, '04/08/21 - 01:23:49'),
(266, 'Miayu', 'Usen el código MIAYU en Rappi!! Van a tener 5 envíos totalmente gratis 😄🍣🍕🌮', 0, '', 'USMITO', NULL, 0, '04/08/21 - 01:24:47'),
(267, 'Yuiovani', 'Abro Hilo, No les que aveces cuando están en la escuelita online, quieren desaparecer?', 0, '', 'USMITO', NULL, 0, '04/08/21 - 01:25:45'),
(268, 'Miayu', '#SEACABOLACUARENTENA ...El cuerpo lo sabe, la calle está llena??????  Hoy se sale 🤝😎', 0, 'SEACABOLACUARENTENA', 'USMITO', NULL, 0, '04/08/21 - 01:28:11'),
(272, 'test3', '#shsjak #asasajskaj #tres', 0, 'shsjak,asasajskaj,tres', 'USMITO', NULL, 0, '23/08/21 - 22:06:24');

--
-- Triggers `usmitos`
--
DELIMITER $$
CREATE TRIGGER `delete_tag_trigger_usmito` AFTER DELETE ON `usmitos` FOR EACH ROW UPDATE tags 
SET tagsCount=
(SELECT COUNT(*) FROM usmitos_tags 
 WHERE usmitos_tags.usmitos_tagsTagId=tags.tagsId)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usmitos_tags`
--

CREATE TABLE `usmitos_tags` (
  `usmitos_tagsId` int(10) NOT NULL,
  `usmitos_tagsUsmitoId` int(10) NOT NULL,
  `usmitos_tagsTagId` varchar(279) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usmitos_tags`
--

INSERT INTO `usmitos_tags` (`usmitos_tagsId`, `usmitos_tagsUsmitoId`, `usmitos_tagsTagId`) VALUES
(30, 258, 'SAVENIGERIA'),
(35, 263, 'AguanteColoColo'),
(37, 265, 'AguanteBioBio'),
(40, 268, 'SEACABOLACUARENTENA'),
(44, 272, 'shsjak'),
(45, 272, 'asasajskaj'),
(46, 272, 'tres');

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop10trends`
-- (See below for the actual view)
--
CREATE TABLE `viewtop10trends` (
`tagsId` varchar(279)
,`tagsCount` int(10)
,`tagsRegisterDate` varchar(30)
);

-- --------------------------------------------------------

--
-- Structure for view `viewtop10trends`
--
DROP TABLE IF EXISTS `viewtop10trends`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop10trends`  AS SELECT `tags`.`tagsId` AS `tagsId`, `tags`.`tagsCount` AS `tagsCount`, `tags`.`tagsRegisterDate` AS `tagsRegisterDate` FROM `tags` WHERE `tags`.`tagsCount` > 0 ORDER BY `tags`.`tagsCount` DESC LIMIT 0, 10 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`followsId`),
  ADD KEY `fkFollower` (`followsUidFollower`),
  ADD KEY `fkFollowed` (`followsUid`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likesId`),
  ADD KEY `fkUserUid` (`likesUserUid`),
  ADD KEY `fkUsmitoId_` (`likesUsmitoId`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tagsId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersUid`);

--
-- Indexes for table `usmitos`
--
ALTER TABLE `usmitos`
  ADD PRIMARY KEY (`usmitosId`),
  ADD KEY `fkUsers` (`usmitosUid`);

--
-- Indexes for table `usmitos_tags`
--
ALTER TABLE `usmitos_tags`
  ADD PRIMARY KEY (`usmitos_tagsId`),
  ADD KEY `fkUsmitoId` (`usmitos_tagsUsmitoId`),
  ADD KEY `fkTagId` (`usmitos_tagsTagId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `followsId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likesId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `usmitos`
--
ALTER TABLE `usmitos`
  MODIFY `usmitosId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `usmitos_tags`
--
ALTER TABLE `usmitos_tags`
  MODIFY `usmitos_tagsId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `fkFollowed` FOREIGN KEY (`followsUid`) REFERENCES `users` (`usersUid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkFollower` FOREIGN KEY (`followsUidFollower`) REFERENCES `users` (`usersUid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fkUserUid` FOREIGN KEY (`likesUserUid`) REFERENCES `users` (`usersUid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkUsmitoId_` FOREIGN KEY (`likesUsmitoId`) REFERENCES `usmitos` (`usmitosId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usmitos`
--
ALTER TABLE `usmitos`
  ADD CONSTRAINT `fkUsers` FOREIGN KEY (`usmitosUid`) REFERENCES `users` (`usersUid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usmitos_tags`
--
ALTER TABLE `usmitos_tags`
  ADD CONSTRAINT `fkTagId` FOREIGN KEY (`usmitos_tagsTagId`) REFERENCES `tags` (`tagsId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkUsmitoId` FOREIGN KEY (`usmitos_tagsUsmitoId`) REFERENCES `usmitos` (`usmitosId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
