-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2021 at 02:55 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eof_v5`
--

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
(7, 'Tinder logo', 15, 1, '2021-06-11 15:06:48', 'Tinder Logo '),
(8, 'Shoes', 200, 1, '2021-06-14 15:06:03', 'Shoes'),
(9, 'sdjkh', 66, 1, '2021-06-14 15:06:17', 'ajhsgd'),
(10, 'Shoes', 200, 2, '2021-06-15 23:06:43', 'Sneaker'),
(11, 'Pokemon', 100, 1, '2021-06-18 01:06:07', 'Pokemon');

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
(7, 'BÃ¼cher & Filme'),
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
(65, 4, 'am f9 bro.', '2021-06-14 23:16:50', 'buyer', 'Rubas', 2, 'pictures/users/2.jpg'),
(96, 4, 'hello', '2021-06-15 21:34:15', 'seller', 'Farasat', 1, 'pictures/users/1.jpg'),
(97, 4, 'how are you?', '2021-06-15 21:35:03', 'buyer', 'Rubas', 2, 'pictures/users/2.jpg'),
(98, 4, 'test', '2021-06-15 21:36:05', 'seller', 'Farasat', 1, 'pictures/users/1.jpg'),
(99, 4, 'How are you?', '2021-06-15 21:38:11', 'seller', 'Farasat', 1, 'pictures/users/1.jpg'),
(100, 4, 'am f9 n u?', '2021-06-15 21:38:28', 'buyer', 'Rubas', 2, 'pictures/users/2.jpg'),
(101, 6, 'hello', '2021-06-15 21:40:02', 'buyer', 'Farasat', 1, 'pictures/users/1.jpg'),
(102, 6, 'wt ll b the last price?', '2021-06-15 21:40:24', 'buyer', 'Farasat', 1, 'pictures/users/1.jpg'),
(103, 6, 'ds is already the last price....', '2021-06-15 21:40:44', 'seller', 'Rubas', 2, 'pictures/users/2.jpg'),
(104, 8, 'hello', '2021-06-15 22:10:13', 'buyer', 'Muhammad', 4, 'res/images/user.svg'),
(105, 8, 'hey, how may i help u?', '2021-06-15 22:23:26', 'seller', 'Rubas', 2, 'pictures/users/2.jpg'),
(106, 7, 'Hello', '2021-06-15 23:14:35', 'seller', 'Rubas', 2, 'pictures/users/2.jpg'),
(107, 8, 'I am fine', '2021-06-15 23:14:53', 'seller', 'Rubas', 2, 'pictures/users/2.jpg'),
(108, 5, 'whats up', '2021-06-15 23:15:10', 'buyer', 'Rubas', 2, 'pictures/users/2.jpg'),
(109, 6, '?', '2021-06-15 23:15:58', 'buyer', 'Farasat', 1, 'pictures/users/1.jpg'),
(110, 9, 'Hello', '2021-06-17 23:55:32', 'buyer', 'Rubas', 2, 'pictures/users/2.jpg'),
(111, 5, 'hello', '2021-06-19 12:00:30', 'seller', 'Farasat', 1, 'pictures/users/1.jpg'),
(112, 7, '?', '2021-06-19 12:05:42', 'seller', 'Rubas', 2, 'pictures/users/2.jpg'),
(113, 6, 'kk', '2021-06-19 12:06:07', 'seller', 'Rubas', 2, 'pictures/users/2.jpg'),
(114, 6, 'hi wsup', '2021-06-19 12:12:45', 'seller', 'Rubas', 2, 'pictures/users/2.jpg'),
(115, 6, 'hz u doing', '2021-06-19 12:12:56', 'seller', 'Rubas', 2, 'pictures/users/2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `author_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(500) COLLATE utf8_bin NOT NULL,
  `score` int(2) NOT NULL
) ;

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
(4, 2, 1, 7),
(5, 2, 1, 8),
(6, 1, 2, 10),
(7, 3, 2, 10),
(8, 4, 2, 10),
(9, 2, 1, 11);

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
(7, 6),
(8, 5),
(9, 1),
(10, 5),
(11, 8);

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
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `title`, `fname`, `lname`, `address`, `plz`, `city`, `email`, `password`, `picture`, `admin`) VALUES
(1, 'Mrs.', 'Farasat', 'Hussain', 'Agasse 100/212', 1130, 'Wien', 'farasat@yahoo.com', '$2y$10$9p.fvxhTTDIh4HhFJFd0VeoKz70aFu77m9UBN/jw6r.Yd5C0Ft2ue', 'pictures/users/1.jpg', 0),
(2, 'Mr.', 'Rubas', 'Naseem', 'Rokitanskygasse 13/41', 1220, 'Vienna', 'rubas@gmail.com', '$2y$10$0FOeSqZaUWFgPFKGnuz0fep7Mk6EVHshKYuaobMB1kEUqoPhhghEq', 'pictures/users/2.jpg', 0),
(3, 'Mr.', 'Hussain', 'Khan', 'Agasse 100/212', 1120, 'Wien', 'faeez@yahoo.com', '$2y$10$1/LM22066kT2PurG.xG3t.qd5pNBoeCjUVlyxqQIdTwwCPFVd.Pj.', 'pictures/users/3.png', 0),
(4, 'Mr.', 'Muhammad', 'Farasat', 'Rokitanskygasse 13/41', 1170, 'Vienna', 'muhammadfarasat@yahoo.com', '$2y$10$jJHUVk.LSSvVNaBIokLMNu1Vve.M2T.BnKo1WQkfu526sBvIbNk2.', 'res/images/user.svg', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `is_assigned_advert_fk` FOREIGN KEY (`advert_id`) REFERENCES `adverts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_assigned_category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
