-- 2020-07-01
ALTER TABLE `mutual_fund_user` ADD `user_plan_id` BIGINT NULL AFTER `investment_through`;


-- 2020-07-10
ALTER TABLE `premium_master` ADD `paid_at` DATE NULL AFTER `premium_date`;

-- 2020-07-10
-- Create table database\policy_benefits.sql


-- Add due date in mutual_fund_investment_hist
ALTER TABLE `mutual_fund_investment_hist` ADD `due_date` DATE NULL AFTER `invested_date`;

-- Date 19-10-2020
ALTER TABLE `life_insurance_traditionals`  ADD `maturity_date` DATE NULL  AFTER `issue_date`;

ALTER TABLE `life_insurance_traditionals` ADD `maturity_amount` DOUBLE NOT NULL AFTER `maturity_date`;

ALTER TABLE `life_insurance_traditionals` ADD `investment_through` ENUM('patel_consultancy','other') NULL DEFAULT NULL AFTER `user_id`;


-- Date 08-05-2021
ALTER TABLE `user_document` CHANGE `user_id` `user_id` BIGINT NOT NULL;
