## alter table, add new fields
ALTER TABLE online_identity DROP INDEX combined_index_idx;
TRUNCATE TABLE `user_identity_con`;
TRUNCATE TABLE `online_identity_con`;
ALTER TABLE `online_identity` ADD `original_id` VARCHAR( 16 )  NULL AFTER `user_id` ;
ALTER TABLE `online_identity` ADD `profile_uri` VARCHAR( 255 ) NULL AFTER `identifier`;
ALTER TABLE `online_identity` ADD `friend_ids` TEXT NULL AFTER `social_publishing_enabled` ,
ADD `friend_count` INT( 4 ) NOT NULL DEFAULT '0' AFTER `friend_ids` ;

delete from community where id not in (76,34,47,130);

UPDATE `yiid_original`.`community` SET `social_publishing_possible` = '01' WHERE `community`.`id` =47;
UPDATE `yiid_original`.`community` SET `social_publishing_possible` = '01' WHERE `community`.`id` =130;


## deletes all non necessary oi's
delete from online_identity where user_id IS NULL;
delete from online_identity where community_id NOT IN (34,76);
delete from online_identity where auth_identifier is NULL;

## add unique key
ALTER TABLE `yiid_original`.`online_identity` DROP INDEX `community_id_idx` ,
ADD UNIQUE `community_id_idx` ( `community_id` , `original_id` ) 