
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `unit` varchar(200) DEFAULT NULL,
  `number` int(10) unsigned DEFAULT '0',
  `bought_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE InnoDB AUTO_INCREMENT 1 DEFAULT CHARACTER SET utf8 COMMENT 'products table';
