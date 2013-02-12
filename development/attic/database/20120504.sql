-- Adding user preferences
ALTER TABLE `User` ADD `language` VARCHAR( 5 ) NULL ;

-- Making ISO codes smaller
ALTER TABLE `AttributeI18N` CHANGE `isoCode` `isoCode` VARCHAR( 5 ) NOT NULL ;
ALTER TABLE `AttributeOptionI18N` CHANGE `isoCode` `isoCode` VARCHAR( 5 ) NOT NULL ;