// lokalen dump erstellen
mysqldump -u communipedia_dev -pfdsmolds32dfs -n -t -q  --complete-insert communipedia_dev user community oauth_consumer_token oauth_nonce oauth_service_token online_identity online_identity_con persistent_object persistent_variable short_url short_url_intern user_avatar user_identity_con user_email_address > test.sql

// dump von live->dev
mysqldump --host=donkeykong -u communipedia -pWzcScrcd9z4nMJWJ -n -t -q  yiid user community oauth_consumer_token oauth_nonce oauth_service_token online_identity online_identity_con persistent_object persistent_variable short_url short_url_intern user_avatar user_identity_con user_email_address > test.sql