CREATE TABLE payment_method (id BIGINT AUTO_INCREMENT, type VARCHAR(255) DEFAULT 'invoice', company VARCHAR(255), contact_name VARCHAR(255), address VARCHAR(255), city VARCHAR(255), zip VARCHAR(255), sf_guard_user_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX sf_guard_user_id_idx (sf_guard_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;

DROP TABLE deal;
CREATE TABLE deal (id BIGINT AUTO_INCREMENT, type VARCHAR(255) DEFAULT 'pool', name VARCHAR(255), tos_accepted TINYINT(1) DEFAULT '0', pool_hits INT DEFAULT 0, email_required TINYINT(1) DEFAULT '0', motivation_title VARCHAR(255), motivation_text TEXT, spread_title VARCHAR(255), spread_text TEXT, spread_url VARCHAR(255), spread_img VARCHAR(255), spread_tos VARCHAR(255), coupon_type VARCHAR(255) DEFAULT 'code', coupon_title VARCHAR(255), coupon_text TEXT, coupon_code VARCHAR(255), coupon_url VARCHAR(255), coupon_redeem_url VARCHAR(255), billing_type VARCHAR(255) DEFAULT 'like', target_quantity INT DEFAULT 0, actual_quantity INT DEFAULT 0, sf_guard_user_id BIGINT, payment_method_id BIGINT, domain_profile_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deal_state VARCHAR(255) DEFAULT 'initial', INDEX sf_guard_user_id_idx (sf_guard_user_id), INDEX payment_method_id_idx (payment_method_id), INDEX domain_profile_id_idx (domain_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
ALTER TABLE deal ADD CONSTRAINT deal_sf_guard_user_id_sf_guard_user_id FOREIGN KEY (sf_guard_user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE deal ADD CONSTRAINT deal_payment_method_id_payment_method_id FOREIGN KEY (payment_method_id) REFERENCES payment_method(id);
ALTER TABLE deal ADD CONSTRAINT deal_domain_profile_id_domain_profile_id FOREIGN KEY (domain_profile_id) REFERENCES domain_profile(id) ON DELETE CASCADE;

DROP TABLE coupon;

ALTER TABLE user ADD participated_deals TEXT;
ALTER TABLE domain_profile ADD tracking_url VARCHAR( 255 ) ;