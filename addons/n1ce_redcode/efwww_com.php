<?php
pdo_query("
DROP TABLE IF EXISTS `ims_n1ce_red_code`;
CREATE TABLE `ims_n1ce_red_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `code` varchar(64) NOT NULL DEFAULT '1',
  `pici` int(10) NOT NULL DEFAULT '0',
  `time` varchar(16) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `iscqr` tinyint(4) NOT NULL DEFAULT '1',
  `salt` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_n1ce_red_msgid
-- ----------------------------
DROP TABLE IF EXISTS `ims_n1ce_red_msgid`;
CREATE TABLE `ims_n1ce_red_msgid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `msgid` varchar(64) NOT NULL DEFAULT '0',
  `time` varchar(16) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_n1ce_red_pic
-- ----------------------------
DROP TABLE IF EXISTS `ims_n1ce_red_pic`;
CREATE TABLE `ims_n1ce_red_pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `bgimg` varchar(64) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_n1ce_red_pici
-- ----------------------------
DROP TABLE IF EXISTS `ims_n1ce_red_pici`;
CREATE TABLE `ims_n1ce_red_pici` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `pici` int(10) NOT NULL DEFAULT '0',
  `codenum` varchar(64) NOT NULL DEFAULT '0',
  `time` varchar(16) NOT NULL DEFAULT '1',
  `time_limit` int(1) NOT NULL DEFAULT '0',
  `starttime` int(10) DEFAULT '0',
  `endtime` int(10) DEFAULT '0',
  `miss_start` varchar(200) DEFAULT NULL,
  `miss_end` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_n1ce_red_prize
-- ----------------------------
DROP TABLE IF EXISTS `ims_n1ce_red_prize`;
CREATE TABLE `ims_n1ce_red_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) DEFAULT '0',
  `prizeodds` int(10) NOT NULL DEFAULT '0',
  `prizesum` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `min_money` varchar(16) DEFAULT '',
  `max_money` varchar(16) DEFAULT '',
  `cardid` varchar(100) DEFAULT '',
  `url` varchar(100) DEFAULT '',
  `time` varchar(32) NOT NULL DEFAULT '1',
  `pici` int(10) NOT NULL DEFAULT '0',
  `credit` int(10) NOT NULL DEFAULT '0',
  `txt` varchar(255) DEFAULT '',
  `name` varchar(100) DEFAULT '',
  `total_num` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_n1ce_red_scanuser
-- ----------------------------
DROP TABLE IF EXISTS `ims_n1ce_red_scanuser`;
CREATE TABLE `ims_n1ce_red_scanuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `openid` varchar(64) NOT NULL DEFAULT '1',
  `nickname` varchar(64) NOT NULL DEFAULT '1',
  `code` varchar(64) DEFAULT '',
  `pici` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `time` varchar(16) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for ims_n1ce_red_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_n1ce_red_user`;
CREATE TABLE `ims_n1ce_red_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `openid` varchar(64) NOT NULL DEFAULT '1',
  `nickname` varchar(64) NOT NULL DEFAULT '1',
  `money` varchar(16) NOT NULL DEFAULT '100',
  `time` varchar(16) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `name` varchar(100) DEFAULT '',
  `bopenid` varchar(64) NOT NULL DEFAULT '1',
  `code` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");