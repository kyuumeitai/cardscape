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