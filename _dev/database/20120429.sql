-- Changing the User table to remove birth year and activation key.
-- The contact info continues to be part of the User table since we have a 
-- set number of different contact fields, they are not expected to change and so 
-- using one single table makes it easier to use (this is not normalized data 
-- as NULL values will exist in the table).
ALTER TABLE `User` DROP `birthYear`, DROP `activationKey` ;
