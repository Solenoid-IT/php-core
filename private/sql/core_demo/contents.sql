--
-- Current Database: `core_demo`
--

USE `core_demo`;



--
-- Dumping data for table `type_test`
--

LOCK TABLES `type_test` WRITE;
/*!40000 ALTER TABLE `type_test` DISABLE KEYS */;
INSERT INTO `type_test` VALUES (16,1.230,'Hello World !',1,'2023-11-02 22:20:36');
/*!40000 ALTER TABLE `type_test` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'user','$2y$10$IsVIUyd1uWwWX/GM8F5nFObCwJqvwfGXAMpf2yXDdHQG8ZwY0nPfq','App','X',NULL,'2023-11-05 19:30:45');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;