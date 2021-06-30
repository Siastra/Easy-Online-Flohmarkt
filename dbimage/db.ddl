DROP TABLE IF EXISTS `is_assigned`;
DROP TABLE IF EXISTS `comment`;
DROP TABLE IF EXISTS `favorite`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `adverts`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id`       int(11)      NOT NULL,
    `title`    varchar(16)  NOT NULL,
    `fname`    varchar(64)  NOT NULL,
    `lname`    varchar(64)  NOT NULL,
    `address`  varchar(128) NOT NULL,
    `plz`      int(11)      NOT NULL,
    `city`     varchar(64)  NOT NULL,
    `email`    varchar(128) NOT NULL,
    `password` varchar(128) NOT NULL,
    `picture`  varchar(64)  NOT NULL,
    `admin`    tinyint(1)   NOT NULL DEFAULT 0
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


CREATE TABLE `adverts`
(
    id        int(11)      NOT NULL,
    title     VARCHAR(64)  NOT NULL,
    price     int(64)      NOT NULL,
    user_id   int(11)      NOT NULL,
    createdAt DATETIME     NOT NULL,
    text      VARCHAR(128) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
    ADD CONSTRAINT users_email_unique UNIQUE (email);

ALTER TABLE `adverts`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `adverts`
    ADD CONSTRAINT post_user_fk FOREIGN KEY (user_id)
        REFERENCES `users` (id);

ALTER TABLE `adverts`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `adverts`
    CHANGE `text` `text` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

CREATE TABLE `favorite`
(
    `id`         int(11)  NOT NULL AUTO_INCREMENT,
    `user_id`    int(11)  NOT NULL,
    `advert_id`  int(11)  NOT NULL,
    `created_at` datetime NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

CREATE TABLE `categories`
(
    `id`   int(11)      NOT NULL PRIMARY KEY,
    `name` VARCHAR(128) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


CREATE TABLE `is_assigned`
(
    `advert_id`   int(11) NOT NULL,
    `category_id` int(11) NOT NULL,
    PRIMARY KEY (`advert_id`, `category_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;


ALTER TABLE `is_assigned`
    ADD CONSTRAINT is_assigned_advert_fk FOREIGN KEY (advert_id)
        REFERENCES `adverts` (id);

ALTER TABLE `is_assigned`
    ADD CONSTRAINT is_assigned_category_fk FOREIGN KEY (category_id)
        REFERENCES `categories` (id);

CREATE TABLE `comment`
(
    `author_id` int(11)                       NOT NULL,
    `user_id`   int(11)                       NOT NULL,
    `comment`   varchar(500) COLLATE utf8_bin NOT NULL,
    `score`     int(2)                        NOT NULL,
    PRIMARY KEY (`author_id`, `user_id`),
    foreign key (`author_id`) references users (`id`),
    foreign key (`user_id`) references users (`id`),
    CHECK ( `score` between 1 and 5),
    CHECK ( `author_id` != `user_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

INSERT INTO `categories` (`id`, `name`)
VALUES (1, 'Technik');
INSERT INTO `categories` (`id`, `name`)
VALUES (2, 'Wohnen & Haushalt');
INSERT INTO `categories` (`id`, `name`)
VALUES (3, 'Auto & Motor');
INSERT INTO `categories` (`id`, `name`)
VALUES (4, 'Haus & Garten');
INSERT INTO `categories` (`id`, `name`)
VALUES (5, 'Kleidung');
INSERT INTO `categories` (`id`, `name`)
VALUES (6, 'Spielzeug');
INSERT INTO `categories` (`id`, `name`)
VALUES (7, 'Bücher & Filme');
INSERT INTO `categories` (`id`, `name`)
VALUES (8, 'Freizeit');

ALTER TABLE `comment` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `score`;

CREATE TABLE `friend` (
                          `id` int(11) NOT NULL,
                          `buyer_id` int(11) NOT NULL,
                          `seller_id` int(11) NOT NULL,
                          `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for table `friend`
--
ALTER TABLE `friend`
    ADD PRIMARY KEY (`id`),
    ADD KEY `buyer_id` (`buyer_id`),
    ADD KEY `seller_id` (`seller_id`),
    ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT for table `friend`
--
ALTER TABLE `friend`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for table `friend`
--
ALTER TABLE `friend`
    ADD CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `friend_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `adverts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


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
-- Indexes for table `chat`
--
ALTER TABLE `chat`
    ADD PRIMARY KEY (`id`),
    ADD KEY `f_id` (`f_id`);

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
    ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`f_id`) REFERENCES `friend` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `users` ADD `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `admin`;