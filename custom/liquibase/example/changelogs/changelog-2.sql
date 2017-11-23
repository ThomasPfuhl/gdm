

LOCK TABLES `communities` WRITE;
INSERT INTO `communities` VALUES (1,'kitty One','coffee and tea amateurs of Kitty One');
UNLOCK TABLES;

LOCK TABLES `deposits` WRITE;
INSERT INTO `deposits` VALUES (1,8,1,'2017-11-15 16:36:34'),(2,5,2,'2017-11-08 13:33:32'),(3,1,2,'2017-11-08 13:33:32');
UNLOCK TABLES;


LOCK TABLES `members` WRITE;
INSERT INTO `members` VALUES (1,'alice@example.org','Alice','A.','1234',1),(2,'bob@example.org','Bob','B.','5678',1);
UNLOCK TABLES;


LOCK TABLES `products` WRITE;
INSERT INTO `products` VALUES (1,'coffee','pack',1,'2017-11-15 16:40:57'),(2,'filter','pack',1,'2017-11-15 16:40:57'),(3,'milk','litre',2,'2017-11-15 16:40:57'),(4,'coffee','pack',1,'2017-11-15 16:40:57');
UNLOCK TABLES;

