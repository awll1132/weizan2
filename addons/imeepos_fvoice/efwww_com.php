<?php
pdo_query("
DROP TABLE IF EXISTS `ims_imeepos_fvoice_advs`;
CREATE TABLE `ims_imeepos_fvoice_advs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `title` varchar(64) DEFAULT '',
  `image` varchar(300) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `link` varchar(320) DEFAULT '',
  `status` tinyint(2) DEFAULT '0',
  `activeid` int(11) DEFAULT '0',
  `position` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_answer`;
CREATE TABLE `ims_imeepos_fvoice_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `question_id` int(11) DEFAULT '0',
  `voice_id` varchar(320) DEFAULT '',
  `timelong` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_category`;
CREATE TABLE `ims_imeepos_fvoice_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  `fid` int(1) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `image` varchar(320) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_chart`;
CREATE TABLE `ims_imeepos_fvoice_chart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `title` varchar(320) DEFAULT '',
  `status` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_chart_listen_log`;
CREATE TABLE `ims_imeepos_fvoice_chart_listen_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `chart_id` int(11) DEFAULT '0',
  `chart_log_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_chart_log`;
CREATE TABLE `ims_imeepos_fvoice_chart_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `voice_id` varchar(320) DEFAULT '',
  `listen_num` int(11) DEFAULT '0',
  `timelong` int(11) DEFAULT '0',
  `chart_id` int(11) DEFAULT '0',
  `isweixin` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_follow`;
CREATE TABLE `ims_imeepos_fvoice_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `to_openid` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_listen_log`;
CREATE TABLE `ims_imeepos_fvoice_listen_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `to_openid` varchar(64) DEFAULT '',
  `question_id` int(11) DEFAULT '0',
  `status` tinyint(2) DEFAULT '0',
  `sn` varchar(64) DEFAULT '',
  `credit` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_member`;
CREATE TABLE `ims_imeepos_fvoice_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `number` int(11) DEFAULT '0' COMMENT '回答个数',
  `follow` int(11) DEFAULT '0' COMMENT '收听人数',
  `tags` varchar(20) DEFAULT '' COMMENT '头衔',
  `desc` varchar(320) DEFAULT '',
  `credit` decimal(10,2) DEFAULT '0.00' COMMENT '提问费用',
  `avatar` varchar(320) DEFAULT '',
  `nickname` varchar(32) DEFAULT '',
  `create_time` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `open_free` tinyint(2) DEFAULT '0',
  `ishot` tinyint(2) DEFAULT '0',
  `isrecommend` tinyint(2) DEFAULT '0',
  `category_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_online`;
CREATE TABLE `ims_imeepos_fvoice_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `to_openid` varchar(64) DEFAULT '',
  `title` varchar(320) DEFAULT '',
  `status` tinyint(2) DEFAULT '0',
  `href` varchar(320) DEFAULT '',
  `content` varchar(1000) DEFAULT '',
  `type` varchar(32) DEFAULT '',
  `image` varchar(320) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_paylog`;
CREATE TABLE `ims_imeepos_fvoice_paylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `credit` decimal(10,2) DEFAULT '0.00',
  `sn` varchar(64) DEFAULT '',
  `openid` varchar(64) DEFAULT '',
  `to_openid` varchar(64) DEFAULT '',
  `question_id` int(11) DEFAULT '0',
  `status` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_question`;
CREATE TABLE `ims_imeepos_fvoice_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `title` varchar(320) DEFAULT '',
  `category_id` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `credit` decimal(10,2) DEFAULT '0.00',
  `listen_num` int(11) DEFAULT '0',
  `good_num` int(11) DEFAULT '0',
  `open` tinyint(2) DEFAULT '0',
  `voice_id` varchar(320) DEFAULT '',
  `to_openid` varchar(64) DEFAULT '',
  `status` tinyint(2) DEFAULT '0',
  `isfree` tinyint(2) DEFAULT '0',
  `free_start_time` int(11) DEFAULT '0',
  `free_end_time` int(11) DEFAULT '0',
  `timelong` int(11) DEFAULT '0',
  `hash` varchar(320) DEFAULT '',
  `key` varchar(320) DEFAULT '',
  `isweixin` tinyint(2) DEFAULT '0',
  `images` varchar(1000) DEFAULT '',
  `sn` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_quickmenu`;
CREATE TABLE `ims_imeepos_fvoice_quickmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  `icon` varchar(320) DEFAULT '',
  `link` varchar(320) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `ido` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_setting`;
CREATE TABLE `ims_imeepos_fvoice_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codename` varchar(32) DEFAULT '',
  `value` text,
  `uniacid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_task`;
CREATE TABLE `ims_imeepos_fvoice_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `title` varchar(100) DEFAULT '',
  `images` varchar(1000) DEFAULT '',
  `open` tinyint(2) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_task_answer`;
CREATE TABLE `ims_imeepos_fvoice_task_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `task_id` int(11) DEFAULT '0',
  `voice_id` varchar(320) DEFAULT '',
  `isweixin` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_task_answer_log`;
CREATE TABLE `ims_imeepos_fvoice_task_answer_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `answer_id` int(11) DEFAULT '0',
  `task_id` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_task_class`;
CREATE TABLE `ims_imeepos_fvoice_task_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_themes`;
CREATE TABLE `ims_imeepos_fvoice_themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  `answer_num` int(11) DEFAULT '0',
  `desc` varchar(1000) DEFAULT '',
  `image` varchar(320) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_imeepos_fvoice_themes_answer`;
CREATE TABLE `ims_imeepos_fvoice_themes_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `themes_id` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");