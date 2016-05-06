# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.33)
# Database: ACI
# Generation Time: 2015-10-18 02:25:59 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table t_sys_member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_sys_member`;

CREATE TABLE `t_sys_member` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(100) NOT NULL,
  `password` char(32) NOT NULL,
  `email` char(50) DEFAULT '',
  `group_id` tinyint(3) unsigned DEFAULT '0',
  `is_choose_type` tinyint(1) unsigned DEFAULT '0',
  `open_id` varchar(100) DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `reg_ip` char(15) DEFAULT NULL,
  `reg_time` datetime DEFAULT NULL,
  `last_login_ip` char(15) DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `encrypt` varchar(50) DEFAULT NULL,
  `is_lock` tinyint(1) DEFAULT '0',
  `fullname` varchar(50) DEFAULT NULL,
  `qq` varchar(50) DEFAULT NULL,
  `weixin` varchar(50) DEFAULT NULL,
  `is_seller` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `is_email_validate` tinyint(1) DEFAULT '0',
  `is_mobile_validate` tinyint(1) DEFAULT '0',
  `mobile` varchar(50) DEFAULT NULL,
  `sex` varchar(2) DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `province_code` varchar(10) DEFAULT NULL,
  `city_code` varchar(10) DEFAULT NULL,
  `district_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`(15)),
  KEY `email` (`email`),
  KEY `groupID` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40000 ALTER TABLE `t_sys_member` DISABLE KEYS */;

INSERT INTO `t_sys_member` (`user_id`, `username`, `password`, `email`, `group_id`, `is_choose_type`, `open_id`, `avatar`, `reg_ip`, `reg_time`, `last_login_ip`, `last_login_time`, `encrypt`, `is_lock`, `fullname`, `qq`, `weixin`, `is_seller`, `created`, `modified`, `is_email_validate`, `is_mobile_validate`, `mobile`, `sex`, `birthday`, `province_code`, `city_code`, `district_code`)
VALUES
  (1, 'test', 'fb469d7ef430b0baf0cab6c436e70375', 'hubinjie@live.cn', 1, 0, NULL, 'aci.jpg', NULL, NULL, '180.168.103.162', NULL, NULL, 0, '胡子锅', '5516448', 'dawang', 1, '2015-03-05 18:12:00', '2015-03-10 22:31:19', 1, 1, '13099999999', '男', '1985-10-21', '310000', '310100', '310118'),
  (2, 'xiaoer', 'f1c0334807a3a51724850170326d3b6e', 'lyhuc@163.com', 2, 0, NULL, 'nopic.gif', '::1', NULL, '::1', NULL, 'wOxmG', 1, '小二', NULL, NULL, 0, NULL, NULL, 0, 0, '13099999999', '0', NULL, NULL, NULL, NULL);

/*!40000 ALTER TABLE `t_sys_member` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table t_sys_member_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_sys_member_role`;

CREATE TABLE `t_sys_member_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '组ID',
  `role_name` varchar(45) NOT NULL DEFAULT '' COMMENT '组名',
  `type_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '保留',
  `listorder` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `description` varchar(200) DEFAULT NULL COMMENT '描述',
  `parent_id` smallint(4) DEFAULT '0',
  `arr_childid` varchar(255) DEFAULT NULL,
  `auto_choose` tinyint(1) NOT NULL DEFAULT '1',
  `arr_userid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

LOCK TABLES `t_sys_member_role` WRITE;
/*!40000 ALTER TABLE `t_sys_member_role` DISABLE KEYS */;

INSERT INTO `t_sys_member_role` (`role_id`, `role_name`, `type_id`, `listorder`, `description`, `parent_id`, `arr_childid`, `auto_choose`, `arr_userid`)
VALUES
	(1,'超级管理员',0,0,'超级管理员',0,NULL,1,NULL),
	(2,'普通管理员',0,0,'普通管理员',0,NULL,1,NULL);

/*!40000 ALTER TABLE `t_sys_member_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table t_sys_member_role_priv
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_sys_member_role_priv`;

CREATE TABLE `t_sys_member_role_priv` (
  `role_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `folder` varchar(50) NOT NULL DEFAULT '',
  `controller` varchar(50) NOT NULL DEFAULT '',
  `method` varchar(50) NOT NULL DEFAULT '',
  `data` varchar(50) NOT NULL DEFAULT '',
  `priv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT '0',
  PRIMARY KEY (`priv_id`),
  KEY `role_id` (`role_id`,`folder`,`controller`,`method`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `t_sys_member_role_priv` WRITE;
/*!40000 ALTER TABLE `t_sys_member_role_priv` DISABLE KEYS */;

INSERT INTO `t_sys_member_role_priv` (`role_id`, `folder`, `controller`, `method`, `data`, `priv_id`, `menu_id`)
VALUES
	(2,'adminpanel','helloWorld','index','',60,38),
	(2,'adminpanel','manage','go_15','',59,15),
	(2,'adminpanel','manage','logout','',58,8),
	(2,'adminpanel','profile','change_pwd','',57,7),
	(2,'adminpanel','manage','index','',56,6),
	(2,'adminpanel','manage','go_5','',55,5),
	(2,'adminpanel','manage','go_4','',54,4),
	(2,'adminpanel','manage','go_1','',53,1);

/*!40000 ALTER TABLE `t_sys_member_role_priv` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table t_sys_module_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_sys_module_menu`;

CREATE TABLE `t_sys_module_menu` (
  `menu_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` char(40) NOT NULL DEFAULT '',
  `parent_id` smallint(6) NOT NULL DEFAULT '0',
  `list_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_display` tinyint(1) NOT NULL DEFAULT '1',
  `controller` varchar(50) DEFAULT NULL,
  `folder` varchar(50) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `flag_id` varchar(50) NOT NULL DEFAULT '0',
  `is_side_menu` tinyint(1) DEFAULT '0',
  `is_system` tinyint(1) DEFAULT '0',
  `is_works` tinyint(1) DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `css_icon` varchar(50) DEFAULT NULL,
  `arr_parentid` varchar(250) DEFAULT NULL,
  `arr_childid` varchar(250) DEFAULT NULL,
  `is_parent` tinyint(1) DEFAULT '0',
  `show_where` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`menu_id`) USING BTREE,
  KEY `list_order` (`list_order`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `t_sys_module_menu` WRITE;
/*!40000 ALTER TABLE `t_sys_module_menu` DISABLE KEYS */;

INSERT INTO `t_sys_module_menu` (`menu_id`, `menu_name`, `parent_id`, `list_order`, `is_display`, `controller`, `folder`, `method`, `flag_id`, `is_side_menu`, `is_system`, `is_works`, `user_id`, `css_icon`, `arr_parentid`, `arr_childid`, `is_parent`, `show_where`)
VALUES
	(1,'首页',0,1,1,'manage','adminpanel','go_1','0',1,0,1,1,'home','0','1,5,40,41,6,7,8',1,1),
	(2,'用户管理',0,2,1,'manage','adminpanel','go_2','0',1,0,1,1,'street-view','0','2,9,31,32,33,34,35,36,37,10,26,27,28,29,30',1,1),
	(3,'栏目管理',0,3,1,'manage','adminpanel','go_3','0',1,0,1,1,'list-ol','0','3,11,16,17,18,19,20,12,13,14,21,22,23,24,25,39',1,1),
	(4,'扩展模块',0,4,1,'manage','adminpanel','go_4','0',1,0,1,1,'dropbox','0','4,15,38',1,1),
	(5,'我的',1,5,1,'manage','adminpanel','go_5','0',1,0,1,1,'','0,1','5,40,41,6,7,8',1,1),
	(6,'控制面板',5,6,1,'manage','adminpanel','index','0',1,0,1,1,'','0,1,5','6',0,1),
	(7,'修改密码',5,7,1,'profile','adminpanel','change_pwd','0',1,0,1,1,'','0,1,5','7',0,1),
	(8,'注销',5,8,1,'manage','adminpanel','logout','0',1,0,1,1,'','0,1,5','8',0,1),
	(16,'栏目列表',11,16,1,'moduleMenu','adminpanel','index','0',1,0,1,1,'','0,3,11','16,17,18,19,20',1,1),
	(9,'管理用户',2,9,1,'manage','adminpanel','go_9','0',1,0,1,1,'','0,2','9,31,32,33,34,35,36,37',1,1),
	(10,'管理用户组',2,10,1,'manage','adminpanel','go_10','0',1,0,1,1,'','0,2','10,26,27,28,29,30',1,1),
	(11,'管理栏目',3,11,1,'manage','adminpanel','go_11','0',1,0,1,1,'','0,3','11,16,17,18,19,20',1,1),
	(12,'管理模块',3,12,1,'manage','adminpanel','go_12','0',1,0,1,1,'','0,3','12,13,14,21,22,23,24,25,39',1,1),
	(13,'已安装模块列表',12,13,1,'moduleManage','adminpanel','index','0',1,0,1,1,'','0,3,12','13',0,1),
	(14,'安装新模块',12,14,1,'moduleInstall','adminpanel','index','0',1,0,1,1,'','0,3,12','14,21,22,23,24,25,39',1,1),
	(15,'模块列表',4,15,1,'manage','adminpanel','go_15','0',1,0,1,1,'','0,4','15,38',1,1),
	(17,'新增',16,17,1,'moduleMenu','adminpanel','add','0',1,0,1,1,'','0,3,11,16','17',0,1),
	(18,'修改',16,18,1,'moduleMenu','adminpanel','edit','0',1,0,1,1,'','0,3,11,16','18',0,1),
	(19,'删除',16,19,1,'moduleMenu','adminpanel','delete','0',1,0,1,1,'','0,3,11,16','19',0,1),
	(20,'设置左侧菜单',16,20,1,'moduleMenu','adminpanel','set_menu','0',1,0,1,1,'','0,3,11,16','20',0,1),
	(21,'安装',14,21,1,'moduleInstall','adminpanel','setup','0',1,0,1,1,'','0,3,12,14','21',0,1),
	(22,'检查',14,22,1,'moduleInstall','adminpanel','check','0',1,0,1,1,'','0,3,12,14','22',0,1),
	(23,'重装',14,23,1,'moduleInstall','adminpanel','reinstall','0',1,0,1,1,'','0,3,12,14','23',0,1),
	(24,'卸载',14,24,1,'moduleInstall','adminpanel','uninstall','0',1,0,1,1,'','0,3,12,14','24',0,1),
	(38,'Hello Word',15,38,1,'helloWorld','adminpanel','index','0',1,0,1,1,'','0,4,15','38',0,1),
	(25,'删除',14,25,1,'moduleInstall','adminpanel','delete','0',1,0,1,1,'','0,3,12,14','25',0,1),
	(26,'用户组列表',10,26,1,'role','adminpanel','index','0',1,0,1,1,'','0,2,10','26,27,28,29,30',1,1),
	(27,'新增',26,27,1,'role','adminpanel','add','0',1,0,1,1,'','0,2,10,26','27',0,1),
	(28,'编辑',26,28,1,'role','adminpanel','edit','0',1,0,1,1,'','0,2,10,26','28',0,1),
	(29,'删除',26,29,1,'role','adminpanel','delete_one','0',1,0,1,1,'','0,2,10,26','29',0,1),
	(30,'设置权限',26,30,1,'role','adminpanel','setting','0',1,0,1,1,'','0,2,10,26','30',0,1),
	(31,'用户列表',9,31,1,'user','adminpanel','index','0',1,0,1,1,'','0,2,9','31,32,33,34,35,36,37',1,1),
	(32,'新增',31,32,1,'user','adminpanel','add','0',1,0,1,1,'','0,2,9,31','32',0,1),
	(33,'编辑',31,33,1,'user','adminpanel','edit','0',1,0,1,1,'','0,2,9,31','33',0,1),
	(34,'检测用户名',31,34,1,'user','adminpanel','check_username','0',1,0,1,1,'','0,2,9,31','34',0,1),
	(35,'删除',31,35,1,'user','adminpanel','delete','0',1,0,1,1,'','0,2,9,31','35',0,1),
	(36,'锁定/解锁',31,36,1,'user','adminpanel','lock','0',1,0,1,1,'','0,2,9,31','36',0,1),
	(37,'上传头像',31,37,1,'user','adminpanel','upload','0',1,0,1,1,'','0,2,9,31','37',0,1),
	(39,'上传安装包',14,39,1,'moduleInstall','adminpanel','index','0',1,0,1,1,'','0,3,12,14','39',0,1),
	(41,'全局缓存',5,7,1,'manage','adminpanel','cache','0',1,0,1,1,'','0,1,5','41',0,1);

/*!40000 ALTER TABLE `t_sys_module_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table t_sys_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_sys_sessions`;


CREATE TABLE IF NOT EXISTS `t_sys_sessions` (
    `id` varchar(40) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
    `data` blob NOT NULL,
    KEY `ci_sessions_timestamp` (`timestamp`)
);

# Dump of table t_sys_times
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_sys_times`;

CREATE TABLE `t_sys_times` (
  `times_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `login_ip` char(15) DEFAULT NULL COMMENT 'ip',
  `login_time` int(10) unsigned DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `failure_times` int(10) unsigned DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`times_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
