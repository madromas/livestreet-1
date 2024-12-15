CREATE TABLE IF NOT EXISTS `prefix_chat` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_login` varchar(250) DEFAULT NULL,
  `chat_text` text,
  `chat_date_add` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `chat_date_edit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `chat_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;