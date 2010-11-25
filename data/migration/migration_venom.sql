#########################################################################
#########################################################################
#######   NUR FELDER HINZUFÜGEN, DROPS IN das *_nachrelease.sql  ########
#########################################################################
#########################################################################

CREATE TABLE social_advertisement_translation (id BIGINT, title VARCHAR(40), description VARCHAR(255), lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE social_advertisement (id BIGINT AUTO_INCREMENT, url VARCHAR(255), so_id VARCHAR(40), is_active TINYINT(1) DEFAULT '0', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
ALTER TABLE social_advertisement_translation ADD CONSTRAINT social_advertisement_translation_id_social_advertisement_id FOREIGN KEY (id) REFERENCES social_advertisement(id) ON UPDATE CASCADE ON DELETE CASCADE;

INSERT INTO `social_advertisement` (`id`, `url`, `so_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'https://addons.mozilla.org/de/firefox/addon/232693/', '4c9c532f7f8b9a856ec30b00', 1, '2010-11-25 12:00:00', '2010-11-25 12:00:00'),
(2, 'https://chrome.google.com/extensions/detail/leclmjclggfnkhdpkgnagcdnhnomapda', '4c3232337f8b9ac51d6f0000', 1, '2010-11-25 12:00:00', '2010-11-25 12:00:00');

INSERT INTO `social_advertisement_translation` (`id`, `title`, `description`, `lang`) VALUES
(1, 'YIID: Firefox Addon', 'Share web pages you like or dislike through Yiid and post it to Twitter and/or Facebook.', 'de'),
(1, 'YIID: Firefox Addon', 'Share web pages you like or dislike through Yiid and post it to Twitter and/or Facebook.', 'en'),
(2, 'YIID: Chrome Addon', 'Use the new Yiid Like feature to recommend any page on the web.', 'de'),
(2, 'YIID: Chrome Addon', 'Use the new Yiid Like feature to recommend any page on the web.', 'en');