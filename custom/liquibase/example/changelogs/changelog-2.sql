


--
-- Dumping data for table `communities`
--
LOCK TABLES `communities` WRITE;
INSERT INTO `communities` VALUES (1,'kitty One','coffee and tea amateurs of Kitty One');
UNLOCK TABLES;


--
-- Dumping data for table `deposits`
--
LOCK TABLES `deposits` WRITE;
INSERT INTO `deposits` VALUES (1,8,1,'2017-11-15 16:36:34'),(2,5,2,'2017-11-08 13:33:32'),(3,1,2,'2017-11-08 13:33:32');
UNLOCK TABLES;


--
-- Dumping data for table `gdm_aggregations`
--
LOCK TABLES `gdm_aggregations` WRITE;
INSERT INTO `gdm_aggregations` VALUES (1,'deposits','member_id','amount','SUM'),(2,'products','title','number','SUM');
UNLOCK TABLES;


--
-- Dumping data for table `languages`
--
LOCK TABLES `languages` WRITE;
INSERT INTO `languages` VALUES (1,'en','English');
UNLOCK TABLES;


--
-- Dumping data for table `members`
--
LOCK TABLES `members` WRITE;
INSERT INTO `members` VALUES (1,'alice@example.org','Alice','A.','1234',1),(2,'bob@example.org','Bob','B.','5678',1);
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--
LOCK TABLES `migrations` WRITE;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2017_03_28_092426_create_languages_table',1),('2017_11_13_173300_create_aggregations_table',2);
UNLOCK TABLES;

--
-- Dumping data for table `password_resets`
--
LOCK TABLES `password_resets` WRITE;
UNLOCK TABLES;

--
-- Dumping data for table `products`
--
LOCK TABLES `products` WRITE;
INSERT INTO `products` VALUES (1,'coffee','pack',1,'2017-11-15 16:40:57'),(2,'filter','pack',1,'2017-11-15 16:40:57'),(3,'milk','litre',2,'2017-11-15 16:40:57'),(4,'coffee','pack',1,'2017-11-15 16:40:57');
UNLOCK TABLES;


--
-- Dumping data for table `users`
--
LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (1,'Administrator','zeus','zeus@example.org','$2y$10$jxCrS6xpCkHZbCsLO3lTTuvushwE0bJb96jp7z7/TrU65.9TQuIBa','5c900744eab260996111e3b3d5979013',1,1,'en','NTXqfIVLXtVo2fTCLqvhXK4OSoDUbR34qWE2ZTBUWmsmPeRH0g5PaXdiHdqx','2017-10-17 09:03:32','2017-11-06 15:45:37',NULL),(2,'Default Admin','admin','admin@example.org','$2y$10$L5edhQkit77Ltg0eDmr2aekEcS1qUThpCQzI4q8qadcx79rm0WRhe','aad59a040fc48587fb9f75c10fb95ebc',1,1,'en',NULL,'2017-10-17 09:03:32','2017-10-17 09:03:32',NULL);
UNLOCK TABLES;
