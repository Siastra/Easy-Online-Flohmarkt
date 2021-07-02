-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2021 at 05:32 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eof`
--
CREATE DATABASE IF NOT EXISTS `eof` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `eof`;

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

CREATE TABLE `adverts` (
  `id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `price` int(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `text` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adverts`
--

INSERT INTO `adverts` (`id`, `title`, `price`, `user_id`, `createdAt`, `text`) VALUES
(1, 'Samsung 138 cm (55 Zoll) LED Fernseher', 450, 2, '2021-06-30 20:06:46', 'Verkaufe Samsung Smart TV 55 Zoll um 450€'),
(2, 'Spiel des Lebens', 20, 2, '2021-07-01 09:07:27', 'Verkaufe noch nie benutztes Spiel des Lebens.'),
(3, 'Leiter', 25, 3, '2021-07-01 09:07:18', 'Verkaufe nagelneue Leiter. Erst vor kurzem gekauft und noch originalverpackt. Rechnung auch noch verhanden. Bitte keine \"Letzte Preis\" Anfragen.'),
(4, 'Smoker BBQ Grill Grillwagen Holzkohlegrill Kamingrill XL 32 kg', 200, 3, '2021-07-01 09:07:54', 'Grillen und Smokern wie die Profis in 2 Kammern, mit 2 Ablageflächen für Ihre Grillutensilien, 2 Grillroste Aus hitzebeständigem Stahlblech 1-1,5mm mit Rundrohrgestell, mit 2 Transporträdern damit Ihr Grill überall im Garten oder auf der Terrasse zum Einsatz kommen kann. Mit Thermometer an der Grillkammer und Drosselklappen für eine perfekte Temperatur beim Zubereiten der Speisen Hitzeisolierte, mit Holz verkleidete Griffe, schwenkbarer Warmhalterost aus Edelstahl Gesamtmaß ca. 120x65x135 cm, Ge'),
(5, 'Sommerkleid', 15, 4, '2021-07-01 09:07:35', 'Verkaufe kaum getragenes Sommerkleid.'),
(7, 'Inline Skates', 30, 4, '2021-07-01 09:07:34', 'Verkaufe LED Inline Skates.'),
(8, 'McAfee Virenschutz', 5, 5, '2021-07-01 09:07:03', 'Verkaufe McAfee Virenschutz gültig für ein Jahr und 5 Geräte.'),
(9, 'Trinkbecher 6 Stk.', 5, 5, '2021-07-01 09:07:10', 'Verkaufe 6 Stück Plastik Trinkbecher.'),
(10, 'Percy Jackson Buchreihe', 60, 1, '2021-07-01 09:07:07', 'Hallo, ich verkaufe ein Percy Jackson Taschenbuchschuber um 30€  Bitte nur Nachrichten, danke  Abholung auch in 1100 Wien möglich!!!'),
(11, 'VW Golf 5 BJ 2005 140k km', 2500, 1, '2021-07-01 09:07:40', 'Verkaufe meinen geliebten Golf 5 1.4 TSI Benzin, km-Stand: 144.325, BJ 2005. Pickerl wurde im Jänner 2021 gemacht und Vignette wäre auch dabei. Anfragen bitte nur telefonisch und bitte keine \"Was ist letzte Preis\" Anfragen!\"');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Technik'),
(2, 'Wohnen & Haushalt'),
(3, 'Auto & Motor'),
(4, 'Haus & Garten'),
(5, 'Kleidung'),
(6, 'Spielzeug'),
(7, 'Bücher & Filme'),
(8, 'Freizeit');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timesstamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `sender` varchar(25) NOT NULL,
  `senderName` varchar(25) NOT NULL,
  `senderId` int(11) NOT NULL,
  `senderPic` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `f_id`, `message`, `timesstamp`, `sender`, `senderName`, `senderId`, `senderPic`) VALUES
(1, 1, 'Hallo! Ich würde mich für Ihre Anzeige interessieren und fragen, ob es möglich wäre, dass ich ihn morgen um 400€ holen komme? LG Marcel', '2021-07-01 08:00:50', 'buyer', 'Marcel', 1, 'pictures/users/1.png'),
(2, 2, 'Hallo! Ist die Leiter noch zu haben? LG', '2021-07-01 08:02:00', 'buyer', 'Marcel', 1, 'pictures/users/1.png'),
(3, 2, 'Ja ist noch verfügbar! LG', '2021-07-01 08:03:25', 'seller', 'Lukas', 3, 'pictures/users/3.png'),
(4, 3, 'Hallo! Könnte ich die Becher morgen gleich abholen? LG', '2021-07-01 08:04:28', 'buyer', 'Lukas', 3, 'pictures/users/3.png'),
(5, 2, 'Super könnte ich sie mir gleich am Freitag um 15 Uhr abholen?', '2021-07-01 08:05:27', 'buyer', 'Marcel', 1, 'pictures/users/1.png'),
(6, 2, 'Ja würde passen!', '2021-07-01 08:10:56', 'seller', 'Lukas', 3, 'pictures/users/3.png'),
(7, 3, 'Ja würde passen! Würde aber nur von 16-20 Uhr gehen. LG', '2021-07-01 08:12:02', 'seller', 'Muhammad Farasat', 5, 'pictures/users/5.png'),
(8, 4, 'Hallo! Ich würde mich für Ihre Anzeige interessieren! Was wäre denn Ihre Schmerzgrenze beim Preis? LG', '2021-07-01 08:15:15', 'buyer', 'Muhammad Farasat', 5, 'pictures/users/5.png'),
(9, 5, 'Hallo! Ich würde mich für Ihr Auto interessieren! Wäre es möglich es am Samstag Nachmittag zu besichtigen? LG', '2021-07-01 16:45:16', 'buyer', 'Kristina', 4, 'pictures/users/4.png'),
(10, 6, 'Hallo! Ist dieses Spiel vollständig, also fehlt auch nichts?', '2021-07-01 16:46:27', 'buyer', 'Kristina', 4, 'pictures/users/4.png'),
(11, 5, 'Ja würde passen! LG', '2021-07-02 11:08:01', 'seller', 'Marcel', 1, 'pictures/users/1.png'),
(12, 2, 'Super!', '2021-07-02 11:08:11', 'buyer', 'Marcel', 1, 'pictures/users/1.png'),
(13, 1, 'Ja hab morgen den ganzen Tag Zeit, also einfach Bescheid geben!', '2021-07-02 12:29:26', 'seller', 'Sebastian', 2, 'pictures/users/2.png'),
(14, 4, 'Tut mir leid, ist schon reserviert.', '2021-07-02 12:30:20', 'seller', 'Sebastian', 2, 'pictures/users/2.png'),
(15, 6, 'Ja das Spiel ist vollständig! Alles in Ordnung. LG', '2021-07-02 12:30:58', 'seller', 'Sebastian', 2, 'pictures/users/2.png'),
(16, 7, 'Hallo! Sind die Trinkbecher benutzt? LG', '2021-07-02 12:32:12', 'buyer', 'Sebastian', 2, 'pictures/users/2.png');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `author_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(500) COLLATE utf8_bin NOT NULL,
  `score` int(2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`author_id`, `user_id`, `comment`, `score`, `created_at`) VALUES
(1, 2, 'Hat alles gepasst!', 4, '2021-07-02 13:08:38'),
(1, 3, 'Super schnelle Antwort und umkomplizierte Kaufabwicklung!', 5, '2021-07-01 10:02:41'),
(2, 3, 'War alles in Ordnung.', 3, '2021-07-02 16:06:56'),
(2, 5, 'Immer noch keine Antwort seit einer Woche!', 1, '2021-07-02 14:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `advert_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`id`, `user_id`, `advert_id`, `created_at`) VALUES
(1, 1, 1, '2021-07-01 10:00:58'),
(2, 1, 3, '2021-07-01 10:01:03'),
(3, 4, 2, '2021-07-01 18:46:30'),
(4, 4, 11, '2021-07-01 18:46:36'),
(5, 2, 9, '2021-07-02 14:33:04');

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE `friend` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`id`, `buyer_id`, `seller_id`, `post_id`) VALUES
(1, 1, 2, 1),
(2, 1, 3, 3),
(3, 3, 5, 9),
(4, 5, 2, 1),
(5, 4, 1, 11),
(6, 4, 2, 2),
(7, 2, 5, 9);

-- --------------------------------------------------------

--
-- Table structure for table `is_assigned`
--

CREATE TABLE `is_assigned` (
  `advert_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `is_assigned`
--

INSERT INTO `is_assigned` (`advert_id`, `category_id`) VALUES
(1, 1),
(2, 6),
(3, 4),
(4, 4),
(5, 5),
(7, 8),
(8, 1),
(9, 2),
(10, 7),
(11, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `title` varchar(16) NOT NULL,
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `address` varchar(128) NOT NULL,
  `plz` int(11) NOT NULL,
  `city` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `picture` varchar(64) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `title`, `fname`, `lname`, `address`, `plz`, `city`, `email`, `password`, `picture`, `admin`, `created_at`) VALUES
(1, 'Mr.', 'Marcel', 'Glavanits', 'Teststraße 12', 1100, 'Wien', 'marcel.glavanits@technikum-wien.at', '$2y$10$5Z5s/1sKCe9VLioefgp9EegF3DLgVI0jJTMfivOPU1XAShoUn6bcO', 'pictures/users/1.png', 0, '2021-07-01 18:55:08'),
(2, 'Mr.', 'Sebastian', 'Schramm', 'Teststraße 222', 1100, 'Wien', 'sebastian.schramm@technikum-wien.at', '$2y$10$Ng1muCaSRZ3hoDHldjMAXecYI/PoCGlDfN14ljJ6ypciw99zLX8cC', 'pictures/users/2.png', 0, '2021-07-01 18:55:08'),
(3, 'Mr.', 'Lukas', 'Koller', 'Testgasse 124', 1100, 'Wien', 'lukas.koller@technikum-wien.at', '$2y$10$HA/lCV.tz4tXzd7qEPq6xOV7kYKa9KxXBQzy2fyJ6N.sX/9otSTwy', 'pictures/users/3.png', 0, '2021-07-01 18:55:08'),
(4, 'Mrs.', 'Kristina', 'Tserkovnaya', 'Teststraße 2', 1100, 'Wien', 'kristina.tserkovnaya@technikum-wien.at', '$2y$10$cIzb9kDyfM6QTkh1V/w3MOmQMG1rdCoaaY4NdktWBwUPq5a6WATqC', 'pictures/users/4.png', 0, '2021-07-01 18:55:08'),
(5, 'Mr.', 'Muhammad Farasat', 'Hussain', 'Teststraße 5', 1100, 'Wien', 'muhammad.farasat.hussain@technikum-wien.at', '$2y$10$fTruMOv3b/9l.S3dPuTDoeMbb05BQKWEjkr9wqY0RCPDCRMo87ZW.', 'pictures/users/5.png', 0, '2021-07-01 18:55:08'),
(6, 'Mr.', 'Harald', 'Wahl', 'Teststraße 76', 1100, 'Wien', 'harald.wahl@technikum-wien.at', '$2y$10$2NloB3u3aHHBkHgpJbJBC.jdI70N4FWj9IeC/D4iU2bzJrbYHXbim', 'res/images/user.svg', 0, '2021-07-01 18:55:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adverts`
--
ALTER TABLE `adverts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_user_fk` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `f_id` (`f_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`author_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `is_assigned`
--
ALTER TABLE `is_assigned`
  ADD PRIMARY KEY (`advert_id`,`category_id`),
  ADD KEY `is_assigned_category_fk` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adverts`
--
ALTER TABLE `adverts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adverts`
--
ALTER TABLE `adverts`
  ADD CONSTRAINT `post_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `friend` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friend_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `adverts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `is_assigned`
--
ALTER TABLE `is_assigned`
  ADD CONSTRAINT `is_assigned_advert_fk` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`id`),
  ADD CONSTRAINT `is_assigned_category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
