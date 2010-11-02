ALTER TABLE `online_identity` ADD `birthdate` DATE NULL DEFAULT NULL;
ALTER TABLE `online_identity` ADD `gender` VARCHAR( 1 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ;
ALTER TABLE `online_identity` ADD `relationship_state` INTEGER( 4 ) NULL DEFAULT 0 ;
ALTER TABLE `online_identity` ADD `location_raw` varchar( 255 ) NULL DEFAULT NULL ;

ALTER TABLE `online_identity` DROP `identifier`; 
ALTER TABLE `user` ADD `relationship_state` INTEGER( 4 ) NULL DEFAULT 0 ;
