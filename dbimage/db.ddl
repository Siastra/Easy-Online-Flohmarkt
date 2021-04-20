DROP TABLE `adverts`;
DROP TABLE `users`;

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


CREATE TABLE `adverts` (
    id          int(11) NOT NULL,
    title       VARCHAR(64) NOT NULL,
    price       int(64) NOT NULL,
    user_id     int(11) NOT NULL,
    createdAt   DATETIME NOT NULL,
    text        VARCHAR(128) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `adverts`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `adverts`
  ADD CONSTRAINT post_user_fk FOREIGN KEY ( user_id )
 REFERENCES `users` ( id );

ALTER TABLE `adverts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

