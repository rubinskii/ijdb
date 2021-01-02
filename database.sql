--создаю пользователя
CREATE USER 'ijdb_user'@'localhost' IDENTIFIED BY 'mypassword';

создаю бд
CREATE DATABASE `ijdb` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci`;

--предоставляю ему доступ к конкретной бд
GRANT ALL PRIVILEGES ON ijdb.* TO 'ijdb_user'@'localhost';

--обновляю привелегии
FLUSH PRIVILEGES;

--использую БД
USE `ijdb`;

--создаю таблицу
CREATE TABLE `ijdb`.`joke`
(
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `joketext` TEXT,
  `jokedate` DATE,
  `authorid` INT
)

--добавляю рыбу
INSERT INTO `ijdb`.`joke` SET
`joketext` = "смешная шутка про водку и алкоголь в целом",
`jokedate` = "2017-06-01",
`authorid` = 1;

INSERT INTO `ijdb`.`joke`
(`joketext`, `jokedate`, `authorid`) 
VALUES
(
  "смешная шутка про пиво и алкоголь в целом",
  "2017-06-01",
  1
);

INSERT INTO `ijdb`.`joke`
(`joketext`, `jokedate`, `authorid`) VALUES
(
  "смешная шутка про учёбу",
  "2017-06-01",
  2
);

--проверяю, что все добавилось
SELECT * FROM `joke`;

--создаю таблицу для хранения авторов
CREATE TABLE `author`
(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255),
  `email` VARCHAR(255)
);

--добавляю авторов
INSERT INTO `author` SET
`id` = 1,
`name` = 'Kostia Rubinskii',
`email` = 'rubinsky@yandex.ru';

INSERT INTO `author` (`id`, `name`, `email`)
VALUES (2, 'Kolia Rubinskii', 'no email');


--таблица категорий
CREATE TABLE `category`
(
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255)
);

--данные для таблицы
INSERT INTO `category` (`name`)
VALUES
('алкоголь'),
('учеба');

--таблица для категорий
CREATE TABLE `jokecategory`
(
  `jokeid` INT NOT NULL,
  `categoryid` INT NOT NULL,
  PRIMARY KEY (`jokeid`, `categoryid`)
);

--добавляю данные
INSERT INTO `jokecategory` (`jokeid`, `categoryid`)
VALUES (1, 1),
(2, 1),
(3, 2);