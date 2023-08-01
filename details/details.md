
/****Query for All****/
ALTER TABLE `service_types` ADD `isDeleted` INT NOT NULL DEFAULT '0' AFTER `Status`, ADD `CreatedBy` INT NOT NULL  AFTER `isDeleted`,  ADD `CreatedAt` DATETIME NOT NULL  AFTER `CreatedBy`,  ADD `UpdatedBy` INT NOT NULL  AFTER `CreatedAt`,  ADD `UpdatedAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  AFTER `UpdatedBy`;


ALTER TABLE `user_services` ADD `ProgressStatus` VARCHAR(50) NOT NULL DEFAULT 'On Going' AFTER `ServiceStatus`;
ALTER TABLE `user_services` ADD `Reason` VARCHAR(255) NOT NULL AFTER `ProgressStatus`;