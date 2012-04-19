-- Roles: user, moderator, gamemaker, admin
CREATE TABLE `User` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`username` VARCHAR( 25 ) NOT NULL UNIQUE ,
`password` VARCHAR( 40 ) NOT NULL ,
`email` VARCHAR( 255 ) NOT NULL ,
`role` TINYINT NOT NULL DEFAULT 0
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

CREATE TABLE `Card` (
`cardId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
--  `revision` float DEFAULT '0.01',
--  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--  `author` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
--  `status` enum('concept','discuss','playtest','approved','official','halt','restricted','rejected') COLLATE utf8_unicode_ci DEFAULT 'concept',
--  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
--  `cardname` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
--  `faction` enum('Gaia','House of Nobles','Undead','Red Banner','Empire') COLLATE utf8_unicode_ci DEFAULT NULL,
--  `type` enum('unit','event','spell','enchantment','equipment','artifact') COLLATE utf8_unicode_ci DEFAULT NULL,
--  `subtype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
--  `cost` int(11) DEFAULT NULL,
--  `threshold` int(11) DEFAULT NULL,
--  `attack` int(11) DEFAULT NULL,
--  `defense` int(11) DEFAULT NULL,
--  `rules` text COLLATE utf8_unicode_ci,
--  `flavor` text COLLATE utf8_unicode_ci,
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- CREATE TABLE `Comment` (
-- 	id INT AUTO_increment PRIMARY KEY,
--	user INT,
--	card INT,
--	parent INT,
--	date TIMESTAMP,
--	text TEXT );
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
-- CREATE TABLE posting(
-- 	id INT AUTO_increment PRIMARY KEY,
-- 	user INT,
--	card INT,
--	revision INT,
--	text VARCHAR(255) );
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- CREATE TABLE official(
-- 	id INT AUTO_INCREMENT PRIMARY KEY,
-- 	revision INT DEFAULT 0,
--	dev_id INT,
--	img_url VARCHAR(63),
--	promotion TIMESTAMP );

-- CREATE TABLE last_revision(
--	card_id INT PRIMARY KEY,
--	revision INT );

-- CREATE TABLE history(
--	id INT AUTO_INCREMENT PRIMARY KEY,
--	user INT,
--	card INT,
--	action VARCHAR(31),
--	date TIMESTAMP );
--