
-- Remove any "special" attribute, all attributes are to be stored the same way,
-- the difference may be specified in some of the attribute's details
DROP TABLE `CardDescriptionI18N` ;
DROP TABLE `CardNameI18N` ;

ALTER TABLE `Attribute` ADD `searchable` TINYINT NOT NULL DEFAULT 0 ,
    ADD `identity` TINYINT NOT NULL DEFAULT 0 ,
    ADD `order` TINYINT NOT NULL DEFAULT 0 ;