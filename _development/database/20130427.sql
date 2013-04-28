
-- Creating a table to store translated names, same as for every other attribute 
-- but since we can consider that every card has, at least, the name as an attribute 
-- we're handling it in a special way.
CREATE TABLE `CardNameI18N` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`isoCode` VARCHAR( 5 ) NOT NULL ,
`string` VARCHAR( 150 ) NOT NULL ,
`cardId` INT UNSIGNED NOT NULL ,
CONSTRAINT `fkCardCardNameI18N` FOREIGN KEY (`cardId`) REFERENCES `Card`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

-- Adding revision number to revision table
ALTER TABLE `Revision` ADD `number` SMALLINT NOT NULL DEFAULT 1 ;