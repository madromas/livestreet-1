TRUNCATE TABLE  `prefix_session`;
ALTER TABLE  `prefix_session` DROP INDEX  `user_id` ,
ADD UNIQUE  `user_id` (  `user_id` );