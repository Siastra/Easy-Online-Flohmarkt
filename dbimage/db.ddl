-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2021 at 11:21 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(64) NOT NULL,
  `lname` int(64) NOT NULL,
  `address` varchar(128) NOT NULL,
  `plz` int(11) NOT NULL,
  `city` varchar(64) NOT NULL,
  `email` int(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `adv` (
    id          int(11) NOT NULL,
    title       VARCHAR(64) NOT NULL,
    price       int(64) NOT NULL,
    path        VARCHAR(128) NOT NULL,
    user_id     int(11) NOT NULL,
    createdAt   DATETIME NOT NULL,
    text        VARCHAR(128) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `adv`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `adv`
    ADD CONSTRAINT post_user_fk FOREIGN KEY ( user_id )
        REFERENCES `users` ( id );
--
-- AUTO_INCREMENT for dumped tables
--
ALTER TABLE `adv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;