-- Roles: user, moderator, gamemaker, admin
CREATE TABLE `User` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`username` VARCHAR( 25 ) NOT NULL UNIQUE ,
`password` VARCHAR( 40 ) NOT NULL ,
`email` VARCHAR( 255 ) NOT NULL UNIQUE ,
`role` TINYINT NOT NULL DEFAULT 0 ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

CREATE TABLE `Faction` (
`factionId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 50 ) NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

CREATE TABLE `Type` (
`typeId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 50 ) NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- STATUS: concept, discuss, playtest, approved, official, halt, restricted, rejected
CREATE TABLE `Card` (
`cardId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`revision` FLOAT DEFAULT '0.01',
`updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
`name` VARCHAR( 50 ) NULL ,
`subtype` VARCHAR( 50 ) NULL ,
`cost` INT NULL ,
`threshold` INT NULL ,
`attack` INT NULL ,
`defense` INT NULL ,
`rules` TEXT NULL ,
`flavor` TEXT NULL ,
`imagefile` VARCHAR( 255 ) NULL ,
`status` TINYINT NOT NULL DEFAULT 0 ,
`userId` INT UNSIGNED NOT NULL ,
`factionId` INT UNSIGNED NOT NULL ,
`typeId` INT UNSIGNED NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
CONSTRAINT `fkCardUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkCardFaction` FOREIGN KEY (`factionId`) REFERENCES `Faction`(`factionId`) ,
CONSTRAINT `fkCardType` FOREIGN KEY (`typeId`) REFERENCES `Type`(`typeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

CREATE TABLE `Comment` (
`commentId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`userId` INT UNSIGNED NOT NULL ,
`cardId` INT UNSIGNED NOT NULL ,
`date` DATETIME NOT NULL ,
`message` TEXT NOT NULL ,
CONSTRAINT `fkCommentUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkCommentCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`factionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

CREATE TABLE `SessionData` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY ,
`token` VARCHAR( 32 ) NULL, 
`tokenExpires` DATETIME NULL ,
`lastActivity` DATETIME NULL
) ENGINE=MyISAM ;

-- INSERT DEFAULT DATA
INSERT INTO `Faction` (`name`) VALUES ('Gaia'), ('House of Nobles'), ('Undead'), ('Red Banner'), ('Empire') ;
INSERT INTO `Type` (`name`) VALUES ('Unit'), ('Event'), ('Spell'), ('Enchantment'), ('Equipment'), ('Artifact') ;