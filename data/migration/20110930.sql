ALTER TABLE sf_guard_user ADD access_token VARCHAR(255), api_price_like FLOAT, api_price_media_penetration FLOAT;
ALTER TABLE deal ADD coupon_webhook_url VARCHAR(255);
ALTER TABLE payment_method ADD api_method TINYINT(1);

ALTER TABLE deal ADD price FLOAT;