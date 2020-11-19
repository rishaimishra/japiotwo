ALTER TABLE `temp_data_connection` ADD `input_credentials` TEXT NULL AFTER `datasource_id`; 

ALTER TABLE `temp_data_connection` ADD `updated_at` DATETIME NULL AFTER `created_at`; 