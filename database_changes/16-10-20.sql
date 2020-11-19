ALTER TABLE `user_dataset` ADD `run_status` TINYINT NOT NULL DEFAULT '0' COMMENT '0=>not run yet, 1=>running fine, 2=>error' AFTER `selected_values`, ADD `last_successfull_run` DATETIME NULL DEFAULT NULL AFTER `run_status`; 
ALTER TABLE `user_dataset` ADD `formatted_error_message` TEXT NULL AFTER `last_successfull_run`; 
ALTER TABLE `user_connectors` CHANGE `connection_status` `connection_status` TINYINT(4) NULL DEFAULT NULL COMMENT '0->Data source added but no any dataset added, 1->Active, atleast one dataset is working fine, 2->None of the Dataset is active'; 
