
-- Changing ancestor relation to be optional as new cards may not have any 
-- ancestor.
--
-- Adding new image attribute to store the image file name.
ALTER TABLE `Card` CHANGE `ancestorId` `ancestorId` INT UNSIGNED NULL ,
    ADD `image` VARCHAR( 255 ) NULL ;
