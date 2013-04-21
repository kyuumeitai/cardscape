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