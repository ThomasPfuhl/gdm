
CREATE TABLE `communities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL COMMENT 'Title of the community',
  `description` text COMMENT 'Description of the community',
  PRIMARY KEY (`id`)
) ENGINE InnoDB AUTO_INCREMENT 1 DEFAULT CHARACTER SET utf8 COMMENT 'communities table';
