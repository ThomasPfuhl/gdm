
CREATE TABLE `members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(200) DEFAULT NULL,
  `firstname` varchar(200) DEFAULT NULL,
  `familyname` varchar(200) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `community_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE InnoDB AUTO_INCREMENT 1 DEFAULT CHARACTER SET utf8 COMMENT 'members table';
