-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Apr 2025 um 19:58
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `solirestaurant`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `nomCl` varchar(50) NOT NULL,
  `prenomCl` varchar(50) DEFAULT NULL,
  `telCl` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `client`
--

INSERT INTO `client` (`idClient`, `nomCl`, `prenomCl`, `telCl`) VALUES
(1, 'El Amrani', 'Youssef', '0612345678'),
(2, 'Bennani', 'Salma', '0623456789'),
(3, 'Mouline', 'Omar', '0634567890'),
(4, 'Zahraoui', 'Fatima', '0645678901'),
(5, 'Ouazzani', 'Rachid', '0656789012'),
(6, 'Tahiri', 'Kawtar', '0667890123'),
(7, 'Naciri', 'Hamza', '0678901234'),
(8, 'Jabri', 'Imane', '0689012345'),
(9, 'Fassi', 'Mehdi', '0690123456'),
(10, 'Belkadi', 'Hajar', '0601122334'),
(11, 'Abdelhay', 'MALLOULI', '0635848683'),
(12, 'ahmed', 'mallouli', '062030456');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `commande`
--

CREATE TABLE `commande` (
  `idCmd` char(4) NOT NULL,
  `dateCmd` datetime DEFAULT current_timestamp(),
  `Statut` varchar(100) DEFAULT 'en attente',
  `idCl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `commande`
--

INSERT INTO `commande` (`idCmd`, `dateCmd`, `Statut`, `idCl`) VALUES
('C001', '2025-02-18 12:30:00', 'en attente', 1),
('C002', '2025-02-17 14:15:00', 'en cours', 2),
('C003', '2025-02-16 19:45:00', 'expédiée', 3),
('C004', '2025-02-15 11:20:00', 'livrée', 4),
('C005', '2025-02-14 13:05:00', 'annulée', 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `commande_plat`
--

CREATE TABLE `commande_plat` (
  `idPlat` int(11) NOT NULL,
  `idCmd` char(4) NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `commande_plat`
--

INSERT INTO `commande_plat` (`idPlat`, `idCmd`, `qte`) VALUES
(1, 'C001', 2),
(2, 'C001', 1),
(3, 'C002', 3),
(4, 'C003', 1),
(5, 'C004', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `plat`
--

CREATE TABLE `plat` (
  `idPlat` int(11) NOT NULL,
  `nomPlat` varchar(100) NOT NULL,
  `categoriePlat` varchar(100) NOT NULL,
  `TypeCuisine` varchar(250) NOT NULL,
  `prix` decimal(6,2) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `plat`
--

INSERT INTO `plat` (`idPlat`, `nomPlat`, `categoriePlat`, `TypeCuisine`, `prix`, `image`) VALUES
(1, 'Couscous Royal', 'plat principal', 'Marocaine', 120.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT8t4SgVIia2vBss_ziLpBE09Rkzfdkl3eWQA&s'),
(2, 'Tajine de Poulet aux Citrons', 'plat principal', 'Marocaine', 110.00, 'https://www.auxdelicesdupalais.net/wp-content/uploads/2016/10/Couscous-royal-expressDSC04914.jpg'),
(3, 'Harira', 'entrée', 'Marocaine', 40.00, 'https://tasteofmaroc.com/wp-content/uploads/2017/05/harira-2-moroccan-soup-picturepartners-bigstock.jpg'),
(4, 'Briouates au Fromage', 'entrée', 'Marocaine', 50.00, 'https://www.thespruceeats.com/thmb/co_44Mr_wDhikxNC4xvtq4NnNzA=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/moroccan-kefta-ground-meat-briouat-recipe-2394906-hero-01-efb72461dd044f3392460e5a2254c366.jpg'),
(5, 'Sellou', 'dessert', 'Marocaine', 45.00, 'https://tasteofmaroc.com/wp-content/uploads/2018/05/sellou-picturepartners-bigstock-Traditional-Moroccan-dish-with-124901411-1.jpg'),
(6, 'Chebakia', 'dessert', 'Marocaine', 35.00, 'https://tasteofmaroc.com/wp-content/uploads/2020/04/chebakia-picturepartners-bigstock-scaled.jpg'),
(7, 'Pizza Margherita', 'plat principal', 'Italienne', 95.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Pizza_Margherita_stu_spivack.jpg/640px-Pizza_Margherita_stu_spivack.jpg'),
(8, 'Lasagnes à la Bolognaise', 'plat principal', 'Italienne', 110.00, 'https://assets.afcdn.com/recipe/20180119/76936_w1024h768c1cx2680cy1786cxt0cyt0cxb5361cyb3573.jpg'),
(9, 'Bruschetta', 'entrée', 'Italienne', 55.00, 'https://www.allrecipes.com/thmb/QSsjryxShEx1L6o0HLer1Nn4jwA=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/54165-balsamic-bruschetta-DDMFS-4x3-e2b55b5ca39b4c1783e524a2461634ea.jpg'),
(10, 'Carpaccio de Bœuf', 'entrée', 'Italienne', 70.00, 'https://images.radio-canada.ca/v1/alimentation/recette/4x3/carpaccio-bouf.jpg'),
(11, 'Tiramisu', 'dessert', 'Italienne', 50.00, 'https://zhangcatherine.com/wp-content/uploads/2023/05/12001200-2.jpg'),
(12, 'Panna Cotta', 'dessert', 'Italienne', 45.00, 'https://www.jocooks.com/wp-content/uploads/2024/02/panna-cotta-1-22.jpg'),
(13, 'Canard Laqué', 'plat principal', 'Chinoise', 150.00, 'https://api.croq-kilos.com/media/cache/article_banner_webp/uploads/medias/66f81f23983d4381190452.webp'),
(14, 'Riz Cantonais', 'plat principal', 'Chinoise', 80.00, 'https://www.autourduriz.com/asianfood/wp-content/uploads/2023/02/Riz-cantonais-4.jpeg'),
(15, 'Nems au Poulet', 'entrée', 'Chinoise', 60.00, 'https://epicesetdelices.fr/wp-content/uploads/2023/01/nem-au-poulet.jpg'),
(16, 'Dim Sum', 'entrée', 'Chinoise', 75.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_o0RJF3M4pTXjHYP5pP9Oz7DD-yvrTJtzPffid3M7dMwTdpCewDVxRne-p_oWY7xRsVQ&usqp=CAU'),
(17, 'Perles de Coco', 'dessert', 'Chinoise', 40.00, 'https://fac.img.pmdstatic.net/fit/~1~fac~2018~07~30~caf6151e-3639-44d7-8d8e-9ca8c841ec0f.jpeg/750x562/quality/80/crop-from/center/cr/wqkgU3lsIGQnQUIvU3VjcsOpIFNhbMOpIC8gRmVtbWUgQWN0dWVsbGU%3D/perles-de-coco.jpeg'),
(18, 'Nougat Chinois', 'dessert', 'Chinoise', 45.00, 'https://img-3.journaldesfemmes.fr/LMUQ946f5q9QIkR856V3PwdC_gA=/800x600/1f3aa2d74f8f457d806dbc8d9522f1c9/ccmcms-jdf/39900115.jpg'),
(19, 'Paella Royale', 'plat principal', 'Espagnole', 130.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT43z1EZFU7heraaHF01QAle0Vk3ickdS_AgA&s'),
(20, 'Gazpacho', 'entrée', 'Espagnole', 50.00, 'https://www.acouplecooks.com/wp-content/uploads/2021/07/Gazpacho-002s.jpg'),
(21, 'Tortilla Espagnole', 'entrée', 'Espagnole', 55.00, 'https://assets.afcdn.com/recipe/20131108/39788_w1024h768c1cx320cy220.webp'),
(22, 'Churros au Chocolat', 'dessert', 'Espagnole', 40.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbCt0d1VKsBs_TqAlYWjVCDZxxAx6djTa9yg&s'),
(23, 'Flan Espagnol', 'dessert', 'Espagnole', 45.00, 'https://img.cuisineaz.com/660x660/2013/12/20/i13495-flan-aux-oeufs-espagnol.jpeg'),
(24, 'Crema Catalana', 'dessert', 'Espagnole', 50.00, 'https://spanishsabores.com/wp-content/uploads/2023/08/Crema-Catalana-Featured.jpg'),
(25, 'Bœuf Bourguignon', 'plat principal', 'Francaise', 140.00, 'https://www.thespruceeats.com/thmb/gEH_GL4ianQny5H8tfa_dBbF6qc=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/SES-classic-beef-bourguignon-recipe-7498352-hero-A-f3d470b196ee4c97acb778bc068eec13.jpg'),
(26, 'Coq au Vin', 'plat principal', 'Francaise', 135.00, 'https://www.recipetineats.com/tachyon/2021/09/Coq-au-Vin_00-SQ.jpg'),
(27, 'Soupe à l’Oignon', 'entrée', 'Francaise', 65.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2fz2V-fOhN6WtldX1-0-dE1YxbP0PZD_QGQ&s'),
(28, 'Escargots de Bourgogne', 'entrée', 'Francaise', 85.00, 'https://img.cuisineaz.com/1024x768/2024/12/05/i202880-escargots-de-bourgogne.webp'),
(29, 'Crème Brûlée', 'dessert', 'Francaise', 55.00, 'https://www.markal.fr/application/files/medias_markal/recettes/988-recette-creme-brulee.jpg'),
(30, 'Tarte Tatin', 'dessert', 'Francaise', 50.00, 'https://assets.afcdn.com/recipe/20210203/117779_w1024h1024c1cx1060cy707cxt0cyt0cxb2121cyb1414.webp'),
(31, 'Mochi', 'dessert', 'Chinoise', 400.00, 'https://images.getrecipekit.com/20240411054015-peach-mochi.webp?class=16x9');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `telCl` (`telCl`);

--
-- Indizes für die Tabelle `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`idCmd`),
  ADD KEY `idCl` (`idCl`);

--
-- Indizes für die Tabelle `commande_plat`
--
ALTER TABLE `commande_plat`
  ADD PRIMARY KEY (`idPlat`,`idCmd`),
  ADD KEY `idCmd` (`idCmd`);

--
-- Indizes für die Tabelle `plat`
--
ALTER TABLE `plat`
  ADD PRIMARY KEY (`idPlat`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `plat`
--
ALTER TABLE `plat`
  MODIFY `idPlat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`idCl`) REFERENCES `client` (`idClient`);

--
-- Constraints der Tabelle `commande_plat`
--
ALTER TABLE `commande_plat`
  ADD CONSTRAINT `commande_plat_ibfk_1` FOREIGN KEY (`idPlat`) REFERENCES `plat` (`idPlat`),
  ADD CONSTRAINT `commande_plat_ibfk_2` FOREIGN KEY (`idCmd`) REFERENCES `commande` (`idCmd`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
