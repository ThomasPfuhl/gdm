
CREATE TABLE `deposits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `amount` float unsigned DEFAULT '0',
  `member_id` bigint(20) unsigned DEFAULT NULL,
  `spent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE InnoDB AUTO_INCREMENT 1 DEFAULT CHARACTER SET utf8 COMMENT 'deposits table';
