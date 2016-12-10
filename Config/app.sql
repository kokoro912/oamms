/*
MySQL Data Transfer
Source Host: localhost
Source Database: oamms
Target Host: localhost
Target Database: oamms
Date: 2016/12/03 13:15:26
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for ib_cake_sessions
-- ----------------------------
CREATE TABLE `ib_cake_sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `data` text NOT NULL,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_events
-- ----------------------------
CREATE TABLE `ib_events` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `group_id` int(8) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `started` date DEFAULT NULL,
  `ended` date DEFAULT NULL,
  `opened` date DEFAULT NULL,
  `closed` date DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `sort_no` int(8) NOT NULL DEFAULT '0',
  `content` text,
  `comment` text,
  `user_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_groups
-- ----------------------------
CREATE TABLE `ib_groups` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `comment` text,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `logo` varchar(200) DEFAULT NULL,
  `copyright` varchar(200) DEFAULT NULL,
  `module` varchar(50) DEFAULT '00000000',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_infos
-- ----------------------------
CREATE TABLE `ib_infos` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `body` text,
  `opened` datetime DEFAULT NULL,
  `closed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(8) NOT NULL,
  `group_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_infos_groups
-- ----------------------------
CREATE TABLE `ib_infos_groups` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `info_id` int(8) NOT NULL DEFAULT '0',
  `group_id` int(8) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for ib_logs
-- ----------------------------
CREATE TABLE `ib_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_type` varchar(50) DEFAULT NULL,
  `log_content` varchar(1000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_ip` varchar(50) DEFAULT NULL,
  `user_agent` varchar(1000) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=309 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_members
-- ----------------------------
CREATE TABLE `ib_members` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `kana` varchar(50) DEFAULT NULL,
  `gender` varchar(1) NOT NULL DEFAULT '',
  `birthday` datetime DEFAULT NULL,
  `nation_id` int(11) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `prefecture` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `tel_no` varchar(255) DEFAULT NULL,
  `fax_no` varchar(255) DEFAULT NULL,
  `work_zip` varchar(255) DEFAULT NULL,
  `work_prefecture` varchar(255) DEFAULT NULL,
  `work_address1` varchar(255) DEFAULT NULL,
  `work_address2` varchar(255) DEFAULT NULL,
  `work_name1` varchar(255) DEFAULT NULL,
  `work_name2` varchar(255) DEFAULT NULL,
  `work_title` varchar(255) DEFAULT NULL,
  `work_tel_no` varchar(255) DEFAULT NULL,
  `work_fax_no` varchar(255) DEFAULT NULL,
  `intro_username` varchar(255) DEFAULT NULL,
  `intro_name` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `graduated` date DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `comment` text,
  `group_id` int(11) DEFAULT NULL,
  `send_type` smallint(6) DEFAULT NULL,
  `subscription` smallint(6) DEFAULT NULL,
  `member_kind` smallint(6) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `joined` date DEFAULT NULL,
  `last_logined` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=687 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_members_events
-- ----------------------------
CREATE TABLE `ib_members_events` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `event_id` int(8) NOT NULL DEFAULT '0',
  `member_id` int(8) NOT NULL DEFAULT '0',
  `status` tinyint(4) DEFAULT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_members_groups
-- ----------------------------
CREATE TABLE `ib_members_groups` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `member_id` int(8) NOT NULL DEFAULT '0',
  `group_id` int(8) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=226 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_nations
-- ----------------------------
CREATE TABLE `ib_nations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_settings
-- ----------------------------
CREATE TABLE `ib_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_name` varchar(100) NOT NULL,
  `setting_value` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ib_users
-- ----------------------------
CREATE TABLE `ib_users` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `role` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `comment` text,
  `last_logined` datetime DEFAULT NULL,
  `started` datetime DEFAULT NULL,
  `ended` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_id` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=347 DEFAULT CHARSET=utf8;

