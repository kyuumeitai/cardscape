-- Stores the localized description of a card, this will be the card's text if 
-- provided. Works the same way as the localized card's name except that as a business 
-- rule the card may not have a description
CREATE TABLE `CardDescriptionI18N` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`isoCode` VARCHAR( 5 ) NOT NULL ,
`string` TEXT NOT NULL ,
`cardId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkCardCardDescriptionI18N` FOREIGN KEY (`cardId`) REFERENCES `Card`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;