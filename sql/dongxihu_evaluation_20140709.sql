# Host: 115.28.105.41  (Version: 5.6.15-log)
# Date: 2014-07-09 14:21:18
# Generator: MySQL-Front 5.3  (Build 4.128)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "admin_user"
#

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '后台管理员的id',
  `username` varchar(255) DEFAULT NULL COMMENT '后台管理员的登陆账号',
  `password` char(40) NOT NULL DEFAULT '' COMMENT '后台管理员的密码，四十位的HASH数值',
  `salt` char(10) DEFAULT NULL COMMENT '密码生成的salt数值',
  `realname` varchar(255) DEFAULT NULL COMMENT '系统管理员的真实姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存储计算管理员的数据表';

#
# Structure for table "evaluate_result"
#

DROP TABLE IF EXISTS `evaluate_result`;
CREATE TABLE `evaluate_result` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) DEFAULT NULL COMMENT '教学评价的id',
  `evaluate_username` varchar(255) DEFAULT NULL COMMENT '参加测评用户账号，因为完全没有比较做关联查询，无记名的，所以直接插入用户的账号名称',
  `json_result` varchar(255) DEFAULT NULL COMMENT '对于前台表格填写之后序列化的结果，因为数据的维度太多，实在没有必要搞关系型数据库存储',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for table "evaluate_school"
#

DROP TABLE IF EXISTS `evaluate_school`;
CREATE TABLE `evaluate_school` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '单位的id',
  `name` varchar(100) DEFAULT NULL COMMENT '单位的名称',
  `create_admin_user` int(5) NOT NULL DEFAULT '0' COMMENT '后台管理用户的真实姓名',
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '测评单位添加的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存储参加民主评价的单位的相关数据';

#
# Structure for table "evaluate_user"
#

DROP TABLE IF EXISTS `evaluate_user`;
CREATE TABLE `evaluate_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '参加测评的随机分配的人员的id',
  `evaluation_id` int(11) DEFAULT NULL COMMENT '民主评价的id，当前用户只能用以哪次民主评价',
  `username` varchar(255) DEFAULT NULL COMMENT '参加测评的随机分配的人员的账号名称，这个数据表中没有真实姓名',
  `password` char(6) DEFAULT NULL COMMENT '6位的登录密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='每次被自动生成参加教学评价的随机用户的数据表';

#
# Structure for table "evaluated_person"
#

DROP TABLE IF EXISTS `evaluated_person`;
CREATE TABLE `evaluated_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '测评对象的id',
  `realname` varchar(100) NOT NULL DEFAULT '' COMMENT '测评对象的真实姓名，因为这类用户不能登录后台，所以不需要账号名称',
  `position` varchar(255) DEFAULT NULL COMMENT '测评对象的职位，汉字，不是关联id',
  `school_id` varchar(255) DEFAULT NULL COMMENT '测评对象所属的单位id',
  `create_admin_user` varchar(255) DEFAULT NULL COMMENT '后台管理用户的真实姓名',
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='每个单位的测评对象，就是被评价的人，学校领导的数据表';

#
# Structure for table "evaluation"
#

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '测评的名称',
  `evaluated_person` text NOT NULL COMMENT '测评对象的id列表，表明一个测评是评价谁，json数组或序列化数组',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `duration` int(11) NOT NULL DEFAULT '0' COMMENT '持续时间，单位为分钟',
  `evaluate_user_count` varchar(255) DEFAULT NULL COMMENT '参加测评的人数，用以生成随机分配的账号名',
  `status` char(1) NOT NULL DEFAULT 'N' COMMENT '民主评价的状态，未开始N，进行中P，已完成F',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存储民主评价的数据表，就是一个民主评价的相关信息都可以在里面找到';
