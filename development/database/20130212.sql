-- Stores session information for each active user and allows the controll of 
-- expired logins
CREATE TABLE `SessionData` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY ,
`token` VARCHAR( 32 ) NULL, 
`tokenExpires` DATETIME NULL ,
`lastActivity` DATETIME NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- User information is store in this table, all fields register standad profile 
-- information. The role field will be used to determine the user's role within 
-- the system. Possible rules are: user(0), moderator(1), admin(2)
CREATE TABLE `User` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`username` VARCHAR( 25 ) NOT NULL UNIQUE ,
`password` VARCHAR( 40 ) NOT NULL ,
`email` VARCHAR( 255 ) NOT NULL UNIQUE ,
`role` TINYINT NOT NULL DEFAULT 0 ,
`location` VARCHAR( 255 ) NULL ,
`birthYear` SMALLINT NULL ,
`msn` VARCHAR( 255 ) NULL ,
`skype` VARCHAR( 255 ) NULL ,
`twitter` VARCHAR( 50 ) NULL ,
`avatar` VARCHAR( 255 ) NULL ,
`showEmail` TINYINT NOT NULL DEFAULT 0 ,
`about` VARCHAR( 255 ) NULL ,
`activationKey` VARCHAR( 32 ) NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- STATUS: concept(0), discussion(1), playtest(2), approved(3), rejected(4)
-- Card status are made hardcoded because they are considered control information
-- to be used by the platform and not edited by users. Any other status that is
-- needed will probably require code changes to be effective thus they are out 
-- of the user reach.
CREATE TABLE `Card` (
`cardId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`status` TINYINT NOT NULL DEFAULT 0 ,
`active` TINYINT NOT NULL DEFAULT 1 ,
`userId` INT UNSIGNED NOT NULL ,
`ancestor` INT UNSIGNED NOT NULL DEFAULT 0, -- ID of card from which this card is derived from
CONSTRAINT `fkCardUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Card attributes.
CREATE TABLE `Attribute` (
`attributeId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`multivalue` TINYINT NOT NULL DEFAULT 0 ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Attribute translations.
CREATE TABLE `AttributeI18N` (
`attributeI18NId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`string` VARCHAR( 150 ) NOT NULL ,
`isoCode` VARCHAR( 7 ) NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkAttributeOptionAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`attributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- If the attribute is a "multi" attribute, meaning that there are various
-- possible values for a given attribute, then each value is stored here.
CREATE TABLE `AttributeOption` (
`attributeOptionId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`key` VARCHAR( 15 ) NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkAOptionAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`attributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Attribute options translations.
CREATE TABLE `AttributeOptionI18N` (
`attributeOptionI18NId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`string` VARCHAR( 150 ) NOT NULL ,
`isoCode` VARCHAR( 7 ) NOT NULL ,
`attributeOptionId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkAOI18NAttributeOption` FOREIGN KEY (`attributeOptionId`) REFERENCES `AttributeOption`(`attributeOptionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R2
-- Joins a card with its attributes
CREATE TABLE `CardAttribute` (
`cardId` INT UNSIGNED NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`cardId`, `attributeId`) ,
CONSTRAINT `fkCardAttributee` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`) ,
CONSTRAINT `fkCardAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`attributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Stores each card revision. There is at least one revision, that is created 
-- when the card is suggested.
CREATE TABLE `Revision` (
`revisionId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`date` DATETIME NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
`cardId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkRevisionCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`) ,
CONSTRAINT `fkRevisionUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R3
-- Stores the value for each attribute for the card's revision.
CREATE TABLE `RevisionAttribute` (
`revisionId` INT UNSIGNED NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
`value` VARCHAR( 255 ) NOT NULL ,
PRIMARY KEY (`revisionId`, `attributeId`) ,
CONSTRAINT `fkRevisionAttributeRevision` FOREIGN KEY (`revisionId`) REFERENCES `Revision`(`RevisionId`) ,
CONSTRAINT `fkRevisionAttributeAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`attributeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Registers comments made to a card by a user.
CREATE TABLE `Comment` (
`commentId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`userId` INT UNSIGNED NOT NULL ,
`cardId` INT UNSIGNED NOT NULL ,
`date` DATETIME NOT NULL ,
`message` TEXT NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
CONSTRAINT `fkCommentUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) ,
CONSTRAINT `fkCommentCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Stores card development projects if the admins have activated the feature.
CREATE TABLE `Project` (
`projectId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 50 ) NOT NULL ,
`description` VARCHAR( 255 ) NULL ,
`expires` DATETIME NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
`userId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkProjectUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R4
-- Stores the goals that will mark a project as complete.
CREATE TABLE `ProjectAttribute`(
`projectId` INT UNSIGNED NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
`objective` SMALLINT UNSIGNED NOT NULL ,
PRIMARY KEY (`projectId`, `attributeId`) ,
CONSTRAINT `fkProjectAttributeProject` FOREIGN KEY (`projectId`) REFERENCES `Project`(`projectId`) ,
CONSTRAINT `fkProjectAttributeAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`attributeId`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R1
-- Stores cards on which a user requested notification
CREATE TABLE `CardUser`(
`cardId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`cardId`, `userId`) ,
CONSTRAINT `fkCardUserCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`) ,
CONSTRAINT `fkCardUserUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R5
-- Stores local project administrators.
CREATE TABLE `ProjectUser` (
`projectId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`projectId`, `userId`) ,
CONSTRAINT `fkProjectUserProject` FOREIGN KEY (`projectId`) REFERENCES `Project`(`projectId`) ,
CONSTRAINT `fkProjectUserUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R6
-- Identifies the project from where the card came.
CREATE TABLE `ProjectCard` (
`cardId` INT UNSIGNED NOT NULL PRIMARY KEY ,
`projectId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkProjectCardCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`cardId`) ,
CONSTRAINT `fkProjectCardProject` FOREIGN KEY (`projectId`) REFERENCES `Project`(`projectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Stores system wide settings controlled by administrators.
CREATE TABLE `Setting` (
`key` VARCHAR( 50 ) NOT NULL PRIMARY KEY ,
`value` VARCHAR( 255 ) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Insert default data
INSERT INTO `Setting` VALUES ('captcha', 0), ('registration', 1), ('minnick', 3), ('projects', 0) ;


-- Changing the User table to remove birth year and activation key.
-- The contact info continues to be part of the User table since we have a 
-- set number of different contact fields, they are not expected to change and so 
-- using one single table makes it easier to use (this is not normalized data 
-- as NULL values will exist in the table).
ALTER TABLE `User` DROP `birthYear`, DROP `activationKey` ;

-- R7
-- Stores projects a user requested notification on.
CREATE TABLE `ProjectUserNotify`(
`projectId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`projectId`, `userId`) ,
CONSTRAINT `fkProjectUserNotifyProject` FOREIGN KEY (`projectId`) REFERENCES `Project`(`projectId`) ,
CONSTRAINT `fkProjectUserNotifyUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Stores notification messages based on user settings.
-- A notification needs always a revision ID and a user that owns the notification 
-- (the user that will see it). When a user request notification on a project 
-- what he will get is notifications for changes to every card that exists or 
-- is added to that project or when the card that completes the project is marked as 
-- complete (this needs to be added in code).
CREATE TABLE `Notification` (
`notificationId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`message` VARCHAR( 255 ) NOT NULL , -- //NOTE: this value is probably too small
`date` DATETIME NOT NULL ,
`shown` TINYINT NOT NULL DEFAULT 0 ,
`revisionId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkNotificationRevision` FOREIGN KEY (`revisionId`) REFERENCES `Revision`(`revisionId`) ,
CONSTRAINT `fkNotificationUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Changing the ancestor attribute to a proper FK referencing the Card table.
ALTER TABLE `Card` DROP `ancestor`, ADD `ancestorId` INT UNSIGNED NULL ;
ALTER TABLE `Card` ADD CONSTRAINT `fkCardCard` FOREIGN KEY (`ancestorId`) REFERENCES `Card`(`cardId`) ;

-- Correcting mistake for the type of the value attribute of RevisionAttribute
ALTER TABLE `RevisionAttribute` CHANGE `value` `value` TEXT NOT NULL ;

-- Stores password recovery requests
CREATE TABLE `PasswordRecover` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY ,
`key` VARCHAR( 32 ) NOT NULL UNIQUE ,
`requested` DATETIME NOT NULL ,
CONSTRAINT `fkPassworRecoverUser` FOREIGN KEY (`userId`) REFERENCES `User`(`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Adding user preferences
ALTER TABLE `User` ADD `language` VARCHAR( 5 ) NULL ;

-- Making ISO codes smaller
ALTER TABLE `AttributeI18N` CHANGE `isoCode` `isoCode` VARCHAR( 5 ) NOT NULL ;
ALTER TABLE `AttributeOptionI18N` CHANGE `isoCode` `isoCode` VARCHAR( 5 ) NOT NULL ;