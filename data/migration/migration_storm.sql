## deletes all non necessary oi's
delete from online_identity where user_id IS NULL OR community_id NOT IN (34,76) OR auth_identifier is NULL;