# Host: 115.28.105.41  (Version: 5.6.15-log)
# Date: 2014-07-17 19:51:05
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "admin_user"
#

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` char(60) NOT NULL DEFAULT '',
  `salt` char(32) DEFAULT NULL,
  `realname` varchar(100) DEFAULT NULL,
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='存储计算管理员的数据表';

#
# Data for table "admin_user"
#

INSERT INTO `admin_user` VALUES (14,'zhaomeng','$2y$15$82bc00ea2dcb61f117d90uzHYycnFY1Cu3UgdqyFquBdkmDt.2/0W','82bc00ea2dcb61f117d905f214d6e930','zhaomeng','2014-07-14 13:41:38'),(15,'hengleike','U/zaz9xjxIsnVy6zdVYw/oKth8eEtMp3ZY5loaVYeOJ7BsVZpKVXRQ==','84a39c1666eeef3cc16e374dea8dd0b8','赵安国','2014-07-14 13:56:20'),(16,'mataoit','4vPLqd6rw1ni+KFMXys9IOeloHcgQssrVgknH+bMiNviuOs3bit5lQ==','c156d50d82021cfe70471e238811c8a5','马涛matao','2014-07-14 22:20:55');

#
# Structure for table "evaluate_school"
#

DROP TABLE IF EXISTS `evaluate_school`;
CREATE TABLE `evaluate_school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` longtext NOT NULL,
  `create_admin_user` varchar(100) DEFAULT NULL,
  `insert_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `名称唯一索引` (`name`),
  KEY `插入时间索引` (`insert_time`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

#
# Data for table "evaluate_school"
#

INSERT INTO `evaluate_school` VALUES (23,'东西湖教育句14','东西湖教育句1','admin','2014-07-12 11:59:20'),(26,'东西湖教育句1','东西湖教育句1','admin','2014-07-12 12:43:26'),(28,'东西湖教育句2d','东西湖教育句1','admin','2014-07-12 12:43:35'),(30,'东西湖教育句2dsds','东西湖教育句1','admin','2014-07-12 12:43:41'),(31,'东西湖教育句2dsdssd','东西湖教育句1','admin','2014-07-12 12:43:44'),(32,'东西湖教育句2dsdssddsf','东西湖教育句1','admin','2014-07-12 12:43:48'),(33,'东西湖教育句2dsdssddsfsdf','东西湖教育句1','admin','2014-07-12 12:43:50'),(34,'东西湖教育句2dsdssddsfsdfsfd','东西湖教育句1','admin','2014-07-12 12:43:54'),(35,'东西湖教育句2dsdssddsfsdfsfdsfd','东西湖教育句1','admin','2014-07-12 12:43:56'),(37,'fdgdfgfdgdf','fdgdfgfdgdf','赵安国','2014-07-14 14:25:01'),(39,'东西湖区教育局','东西湖区教育局','admin','2014-07-14 22:16:16');

#
# Structure for table "evaluate_user"
#

DROP TABLE IF EXISTS `evaluate_user`;
CREATE TABLE `evaluate_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=utf8 COMMENT='每次被自动生成参加教学评价的随机用户的数据表';

#
# Data for table "evaluate_user"
#

INSERT INTO `evaluate_user` VALUES (21,14,'023014000','191c8a'),(22,14,'023014001','b3896c'),(23,14,'023014002','3ae965'),(24,14,'023014003','d29074'),(25,14,'023014004','513e06'),(26,14,'023014005','e36252'),(27,14,'023014006','f2258d'),(28,14,'023014007','ffd1af'),(29,14,'023014008','c33692'),(30,14,'023014009','1737af'),(31,15,'002300150000','a3f9d6'),(32,15,'002300150001','cac0dc'),(33,15,'002300150002','d47157'),(34,15,'002300150003','99e502'),(35,15,'002300150004','7f477c'),(36,15,'002300150005','0188f5'),(37,15,'002300150006','a52577'),(38,15,'002300150007','106080'),(39,15,'002300150008','9210dd'),(40,15,'002300150009','8f555d'),(41,15,'002300150010','b20b27'),(42,15,'002300150011','75e7b2'),(43,15,'002300150012','015a49'),(44,15,'002300150013','3480a3'),(45,15,'002300150014','63407f'),(46,15,'002300150015','a92f7f'),(47,15,'002300150016','fbcef4'),(48,15,'002300150017','7187ae'),(49,15,'002300150018','51a423'),(50,15,'002300150019','5db0a5'),(51,16,'023016000','3ada42'),(52,16,'023016001','30203e'),(53,16,'023016002','b4ae11'),(54,16,'023016003','0af40b'),(55,16,'023016004','3a32e5'),(56,16,'023016005','8ae7e5'),(57,16,'023016006','a357b2'),(58,16,'023016007','804bb3'),(59,16,'023016008','acea25'),(60,16,'023016009','2a7459'),(61,16,'023016010','9130c6'),(62,16,'023016011','83dd5f'),(63,16,'023016012','820114'),(64,16,'023016013','6d893f'),(65,16,'023016014','d696e0'),(66,16,'023016015','f4993e'),(67,16,'023016016','339031'),(68,16,'023016017','a77baa'),(69,16,'023016018','c78668'),(70,16,'023016019','a5994d'),(71,16,'023016020','bb7dbd'),(72,16,'023016021','69c9df'),(73,16,'023016022','a84cd7'),(74,16,'023016023','78c552'),(75,16,'023016024','93e428'),(76,16,'023016025','31d974'),(77,16,'023016026','638ab4'),(78,16,'023016027','89fd30'),(79,16,'023016028','ef8f6c'),(80,16,'023016029','41fd41'),(81,16,'023016030','a463b5'),(82,16,'023016031','797463'),(83,16,'023016032','6c06d7'),(84,16,'023016033','2b10dc'),(85,16,'023016034','289a35'),(86,16,'023016035','42dbf7'),(87,16,'023016036','13e60f'),(88,16,'023016037','2d7beb'),(89,16,'023016038','79ac59'),(90,16,'023016039','5cf7ef'),(91,16,'023016040','a3779a'),(92,16,'023016041','bd07dc'),(93,16,'023016042','b69088'),(94,16,'023016043','37267c'),(95,16,'023016044','d7462e'),(96,16,'023016045','02e606'),(97,16,'023016046','4bbe57'),(98,16,'023016047','47a274'),(99,16,'023016048','c03cfa'),(100,16,'023016049','4abe6c'),(101,16,'023016050','1efbf0'),(102,16,'023016051','c18708'),(103,16,'023016052','9ca394'),(104,16,'023016053','d0355e'),(105,16,'023016054','ff1543'),(106,16,'023016055','1a9729'),(107,16,'023016056','c825ce'),(108,16,'023016057','e9985d'),(109,16,'023016058','4b3e2b'),(110,16,'023016059','40b2db'),(111,16,'023016060','a6fb34'),(112,16,'023016061','7cd600'),(113,16,'023016062','e75c66'),(114,16,'023016063','d76bf2'),(115,16,'023016064','81b345'),(116,16,'023016065','209666'),(117,16,'023016066','fd5eba'),(118,16,'023016067','1bf9b6'),(119,16,'023016068','1c3c5b'),(120,16,'023016069','cffa30'),(121,16,'023016070','993279'),(122,16,'023016071','f1f4e7'),(123,16,'023016072','54e6c7'),(124,16,'023016073','0566ee'),(125,16,'023016074','073324'),(126,16,'023016075','32f894'),(127,16,'023016076','fab28b'),(128,16,'023016077','59c7e5'),(129,16,'023016078','640706'),(130,16,'023016079','931ce2'),(131,16,'023016080','d3968e'),(132,16,'023016081','f14a4a'),(133,16,'023016082','786ae4'),(134,16,'023016083','618895'),(135,16,'023016084','ddb7ec'),(136,16,'023016085','5ab82f'),(137,16,'023016086','9cec7f'),(138,16,'023016087','bde785'),(139,16,'023016088','e63e34'),(140,16,'023016089','cb1064'),(141,16,'023016090','d77fa2'),(142,16,'023016091','4ce2d4'),(143,16,'023016092','da18ae'),(144,16,'023016093','58202e'),(145,16,'023016094','c62621'),(146,16,'023016095','a53ec4'),(147,16,'023016096','06fa70'),(148,16,'023016097','18fc36'),(149,16,'023016098','3e9569'),(150,16,'023016099','631ce3'),(151,17,'039017000','d92a5e'),(152,17,'039017001','3f7486'),(153,17,'039017002','674fe7'),(154,17,'039017003','ee92d5'),(155,17,'039017004','5a3b1b'),(156,17,'039017005','8d4cbb'),(157,17,'039017006','82cc08'),(158,17,'039017007','a381dc'),(159,17,'039017008','edb718'),(160,17,'039017009','883137'),(161,17,'039017010','5e4016'),(162,17,'039017011','5ef986'),(163,17,'039017012','578db9'),(164,17,'039017013','968e0e'),(165,17,'039017014','62789e'),(166,17,'039017015','9fd419'),(167,17,'039017016','bb9c24'),(168,17,'039017017','002a0e'),(169,17,'039017018','2111bd'),(170,17,'039017019','b6e1b8');

#
# Structure for table "evaluated_person"
#

DROP TABLE IF EXISTS `evaluated_person`;
CREATE TABLE `evaluated_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realname` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL DEFAULT '',
  `school_id` int(11) NOT NULL,
  `create_admin_user` varchar(100) NOT NULL DEFAULT '',
  `insert_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `单位和姓名联合组件` (`school_id`,`realname`) COMMENT '防止一个学校有重名的领导存在',
  KEY `时间查询索引` (`insert_time`),
  KEY `学校id插入索引` (`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='每个单位的测评对象，就是被评价的人，学校领导的数据表';

#
# Data for table "evaluated_person"
#

INSERT INTO `evaluated_person` VALUES (12,'衡磊砢','校长',22,'admin','2014-07-13 21:00:14'),(14,'沈总','工会主席',22,'admin','2014-07-13 21:06:45'),(17,'陈老师','教导主任',23,'hengleike','2014-07-14 14:07:26'),(18,'李老师','校长',23,'hengleike','2014-07-14 14:08:37'),(19,'李老师1','工会主席',23,'hengleike','2014-07-14 14:08:55'),(20,'王老师','教导主任',23,'hengleike','2014-07-14 14:10:06'),(21,'dfgfgfdgdf','年级主任',23,'赵安国','2014-07-14 14:11:25');

#
# Structure for table "evaluated_person_result"
#

DROP TABLE IF EXISTS `evaluated_person_result`;
CREATE TABLE `evaluated_person_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) DEFAULT NULL,
  `school_name` varchar(100) DEFAULT NULL COMMENT '学校的名称',
  `realname` varchar(100) DEFAULT '' COMMENT '测评对象的真实姓名',
  `position` varchar(100) DEFAULT NULL COMMENT '民主评价的时候，测评对象当时的职位',
  `score` tinyint(1) DEFAULT NULL COMMENT '学校的分数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "evaluated_person_result"
#

INSERT INTO `evaluated_person_result` VALUES (1,16,'东西湖教育句14','衡磊砢','校长',1),(2,16,'东西湖教育句14','沈总','工会主席',1),(3,16,'东西湖教育句14','李老师','校长',1),(4,16,'东西湖教育句14','李老师1','工会主席',1),(5,16,'东西湖教育句14','王老师','教导主任',1);

#
# Structure for table "evaluated_school_result"
#

DROP TABLE IF EXISTS `evaluated_school_result`;
CREATE TABLE `evaluated_school_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) DEFAULT NULL,
  `school_name` varchar(100) DEFAULT NULL COMMENT '学校的名称',
  `score` tinyint(1) DEFAULT NULL COMMENT '学校的分数',
  `comment` text COMMENT '学校的评价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "evaluated_school_result"
#

INSERT INTO `evaluated_school_result` VALUES (1,16,'东西湖教育句14',1,'fdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsd'),(2,16,'东西湖教育句14',1,'fdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsdfdsfdsfdsfsd');

#
# Structure for table "evaluation"
#

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '民主评价的名称',
  `school_id` int(11) NOT NULL,
  `evaluated_person` text NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `evaluate_user_count` int(11) DEFAULT NULL,
  `description` longtext,
  `create_admin_user` varchar(100) DEFAULT NULL COMMENT '创建教学评价的超级管理员',
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '民主评价的插入时间',
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='存储民主评价的数据表，就是一个民主评价的相关信息都可以在里面找到';

#
# Data for table "evaluation"
#

INSERT INTO `evaluation` VALUES (6,'的发送到发送到',23,'a:4:{i:0;i:14;i:1;i:18;i:2;i:19;i:3;i:21;}','2014-07-03 06:20:00','2014-07-14 19:28:00',10,'非的规范的规范的','admin','2014-07-14 11:35:04','N'),(7,'的发送到发送到',23,'a:4:{i:0;i:14;i:1;i:18;i:2;i:19;i:3;i:21;}','2014-07-03 06:20:00','2014-07-14 19:28:00',10,'非的规范的规范的','admin','2014-07-14 11:36:05','N'),(8,'梵蒂冈梵蒂冈',23,'a:4:{i:0;i:12;i:1;i:17;i:2;i:18;i:3;i:19;}','2014-07-05 07:40:00','2014-07-20 09:40:00',10,'蛋糕店风格大方','admin','2014-07-14 11:49:40','N'),(9,'dfgfdgdfgfd',23,'a:3:{i:0;i:14;i:1;i:18;i:2;i:20;}','2014-07-14 20:18:00','2014-07-19 02:10:00',10,'fdgfdgfdgdfgdf','admin','2014-07-14 12:18:53','N'),(14,'dfgfdgdfgfd',23,'a:3:{i:0;i:14;i:1;i:18;i:2;i:20;}','2014-07-14 20:18:00','2014-07-19 02:10:00',10,'fdgfdgfdgdfgdf','admin','2014-07-14 12:33:49','N'),(15,'sdfsfdfsdfsdf',23,'a:5:{i:0;i:12;i:1;i:14;i:2;i:18;i:3;i:19;i:4;i:20;}','2014-07-02 01:10:00','2014-07-13 01:50:00',20,'fdgfdgfdgdfgdfg','admin','2014-07-14 12:35:39','N'),(16,'sdfsfdfsdfsdf',23,'a:5:{i:0;i:12;i:1;i:14;i:2;i:18;i:3;i:19;i:4;i:20;}','2014-07-02 01:10:00','2014-07-13 01:50:00',100,'fdgfdgfdgdfgdfg','admin','2014-07-14 12:36:36','N'),(17,'干部考核',39,'a:1:{i:0;i:14;}','2014-07-14 22:17:00','2014-07-14 22:19:09',20,'校级干部考核','admin','2014-07-14 22:19:09','N');
