
/****Query for All****/
ALTER TABLE `service_types` ADD `isDeleted` INT NOT NULL DEFAULT '0' AFTER `Status`, ADD `CreatedBy` INT NOT NULL  AFTER `isDeleted`,  ADD `CreatedAt` DATETIME NOT NULL  AFTER `CreatedBy`,  ADD `UpdatedBy` INT NOT NULL  AFTER `CreatedAt`,  ADD `UpdatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  AFTER `UpdatedBy`;

ALTER TABLE `users` ADD `compnay_name` VARCHAR(255) NOT NULL AFTER `dob`;
ALTER TABLE `user_services` ADD `SID` VARCHAR(255) NOT NULL AFTER `ID`;
ALTER TABLE `user_services` ADD `CompnayName` VARCHAR(255) NOT NULL AFTER `ServiceID`;
