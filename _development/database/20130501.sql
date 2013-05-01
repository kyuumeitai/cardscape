ALTER TABLE `User` ADD `activationCompleted` TINYINT NOT NULL DEFAULT 0 ;

CREATE TABLE `Activation` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY ,
`token` VARCHAR( 32 ) NULL , 
`requestedAt` DATETIME NOT NULL ,
`administratorRequested` TINYINT NOT NULL DEFAULT 0 ,
`userId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkActivationUser` FOREIGN KEY (`userId`) REFERENCES `User`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

DROP TABLE `PasswordRecover` ;