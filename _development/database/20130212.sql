-- Stores session information for each active user and allows the controll of 
-- expired logins
CREATE TABLE `SessionData` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY ,
`token` VARCHAR( 32 ) NULL, 
`tokenExpires` DATETIME NULL ,
`lastActivity` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- User information is store in this table, all fields register standard profile 
-- information.
CREATE TABLE `User` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`username` VARCHAR( 25 ) NOT NULL UNIQUE ,
`password` VARCHAR( 40 ) NOT NULL ,
`email` VARCHAR( 255 ) NOT NULL UNIQUE ,
`role` ENUM('user', 'moderator', 'administrator') NOT NULL DEFAULT 'user' ,
`language` VARCHAR( 5 ) NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Card status are made hardcoded because they are considered control information
-- to be used by the platform and not edited by users. Any other status that is
-- needed will probably require code changes to be effective thus they are out 
-- of the user's reach.
CREATE TABLE `Card` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`status` ENUM('concept', 'discussion', 'playtest', 'approved', 'rejected') NOT NULL DEFAULT 'concept' ,
`active` TINYINT NOT NULL DEFAULT 1 ,
`userId` INT UNSIGNED NOT NULL ,
`ancestorId` INT UNSIGNED NOT NULL DEFAULT 0, -- ID of card from which this card is derived from
CONSTRAINT `fkCardUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`) ,
CONSTRAINT `fkCardCard` FOREIGN KEY (`ancestorId`) REFERENCES `Card`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Card attributes that were created by administratos for the current Cardscape 
-- system. Except for the name, all card attributes are unknown until an administrator
-- creates them. From there on all cards will contain those attributes.
CREATE TABLE `Attribute` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`multivalue` TINYINT NOT NULL DEFAULT 0 ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Stores attribute names' translations providing a way to have attribute names/labels 
-- in various languages.
CREATE TABLE `AttributeI18N` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`string` VARCHAR( 150 ) NOT NULL ,
`isoCode` VARCHAR( 5 ) NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkAttributeOptionAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- If the attribute is a "multi" attribute, meaning that there are various
-- possible values for a given attribute, then each value is stored here.
CREATE TABLE `AttributeOption` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`key` VARCHAR( 15 ) NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkAOptionAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Attribute options translations. Does the same thing as the AttributeI18N table 
-- but this one allows translation of the attribute options for multivalue attributes.
CREATE TABLE `AttributeOptionI18N` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`string` VARCHAR( 150 ) NOT NULL ,
`isoCode` VARCHAR( 5 ) NOT NULL ,
`attributeOptionId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkAOI18NAttributeOption` FOREIGN KEY (`attributeOptionId`) REFERENCES `AttributeOption`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Relation R2
-- Connects a card with its attributes. A card only has the attributes that are 
-- registered in this table, even if other attributes exist in the attribute's table.
CREATE TABLE `CardAttribute` (
`cardId` INT UNSIGNED NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`cardId`, `attributeId`) ,
CONSTRAINT `fkCardAttributee` FOREIGN KEY (`cardId`) REFERENCES `Card`(`id`) ,
CONSTRAINT `fkCardAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Stores each card revision. There is at least one revision, that is created 
-- when the card is suggested.
CREATE TABLE `Revision` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`date` DATETIME NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
`cardId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkRevisionCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`id`) ,
CONSTRAINT `fkRevisionUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Relation R3
-- Stores the value for each attribute for the card's revision.
CREATE TABLE `RevisionAttribute` (
`revisionId` INT UNSIGNED NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
`value` TEXT NOT NULL ,
PRIMARY KEY (`revisionId`, `attributeId`) ,
CONSTRAINT `fkRevisionAttributeRevision` FOREIGN KEY (`revisionId`) REFERENCES `Revision`(`id`) ,
CONSTRAINT `fkRevisionAttributeAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Registers comments made to a card by a user.
-- //TODO: //NOTE: THIS TABLE IS NOT VALIDATED/USED YET.
CREATE TABLE `Comment` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`userId` INT UNSIGNED NOT NULL ,
`cardId` INT UNSIGNED NOT NULL ,
`date` DATETIME NOT NULL ,
`message` TEXT NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
CONSTRAINT `fkCommentUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`) ,
CONSTRAINT `fkCommentCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Stores card development projects if the admins have activated the feature.
-- Projects are simple names + description for a set of goals, they aim to provide 
-- some structure/organization to developing a set of related cards.
CREATE TABLE `Project` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 50 ) NOT NULL ,
`description` VARCHAR( 255 ) NULL ,
`expires` DATETIME NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
`userId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkProjectUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R4
-- Stores the goals that will mark a project as complete.
-- //TODO: //NOTE: THIS TABLE IS NOT VALIDATED/USED YET.
CREATE TABLE `ProjectAttribute`(
`projectId` INT UNSIGNED NOT NULL ,
`attributeId` INT UNSIGNED NOT NULL ,
`objective` SMALLINT UNSIGNED NOT NULL ,
PRIMARY KEY (`projectId`, `attributeId`) ,
CONSTRAINT `fkProjectAttributeProject` FOREIGN KEY (`projectId`) REFERENCES `Project`(`id`) ,
CONSTRAINT `fkProjectAttributeAttribute` FOREIGN KEY (`attributeId`) REFERENCES `Attribute`(`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R1
-- Stores cards on which a user requested notification
-- //TODO: //NOTE: THIS TABLE IS NOT VALIDATED/USED YET.
CREATE TABLE `CardUser`(
`cardId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`cardId`, `userId`) ,
CONSTRAINT `fkCardUserCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`id`) ,
CONSTRAINT `fkCardUserUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R5
-- Stores local project administrators.
-- //TODO: //NOTE: THIS TABLE IS NOT VALIDATED/USED YET.
CREATE TABLE `ProjectUser` (
`projectId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`projectId`, `userId`) ,
CONSTRAINT `fkProjectUserProject` FOREIGN KEY (`projectId`) REFERENCES `Project`(`id`) ,
CONSTRAINT `fkProjectUserUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R6
-- Identifies the project from where the card came.
-- //TODO: //NOTE: THIS TABLE IS NOT VALIDATED/USED YET.
CREATE TABLE `ProjectCard` (
`cardId` INT UNSIGNED NOT NULL PRIMARY KEY ,
`projectId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkProjectCardCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`id`) ,
CONSTRAINT `fkProjectCardProject` FOREIGN KEY (`projectId`) REFERENCES `Project`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- R7
-- Stores projects a user requested notification on.
-- //TODO: //NOTE: THIS TABLE IS NOT VALIDATED/USED YET.
CREATE TABLE `ProjectUserNotify`(
`projectId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
PRIMARY KEY (`projectId`, `userId`) ,
CONSTRAINT `fkProjectUserNotifyProject` FOREIGN KEY (`projectId`) REFERENCES `Project`(`id`) ,
CONSTRAINT `fkProjectUserNotifyUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Stores notification messages based on user settings.
-- A notification needs always a revision ID and a user that owns the notification 
-- (the user that will see it). When a user request notification on a project 
-- what he will get is notifications for changes to every card that exists or 
-- is added to that project or when the card that completes the project is marked as 
-- complete (this needs to be added in code).
-- //TODO: //NOTE: THIS TABLE IS NOT VALIDATED/USED YET.
CREATE TABLE `Notification` (
`notificationId` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`message` VARCHAR( 255 ) NOT NULL , -- //NOTE: this value is probably too small
`date` DATETIME NOT NULL ,
`shown` TINYINT NOT NULL DEFAULT 0 ,
`revisionId` INT UNSIGNED NOT NULL ,
`userId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkNotificationRevision` FOREIGN KEY (`revisionId`) REFERENCES `Revision`(`id`) ,
CONSTRAINT `fkNotificationUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Stores password recovery requests
-- //TODO: //NOTE: THIS TABLE IS NOT VALIDATED/USED YET.
CREATE TABLE `PasswordRecover` (
`userId` INT UNSIGNED NOT NULL PRIMARY KEY ,
`key` VARCHAR( 32 ) NOT NULL UNIQUE ,
`requested` DATETIME NOT NULL ,
CONSTRAINT `fkPassworRecoverUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
