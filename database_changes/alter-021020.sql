ALTER TABLE `subscription_plans` ADD `max_team_size` INT NOT NULL DEFAULT '1' COMMENT 'this is a temp column, need to remove after making the changes as per new pricing plans' AFTER `stripe_prod_id`;
ALTER TABLE `roles` ADD `isForTeam` TINYINT NOT NULL DEFAULT '1' COMMENT 'if 1 then this role applicable for team (frontend users)' AFTER `permitted_urls`;
ALTER TABLE `teams` CHANGE `plan_id` `plan_id` INT(11) NOT NULL DEFAULT '0' COMMENT '0 is free trial plan'; 