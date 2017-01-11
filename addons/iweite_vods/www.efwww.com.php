<?php
pdo_query("
DROP TABLE IF EXISTS `ims_iweite_vods_category`;
CREATE TABLE `ims_iweite_vods_category` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) DEFAULT NULL,
  `sid` int(4) DEFAULT '0',
  `dateline` varchar(80) DEFAULT NULL,
  `fdes` mediumtext,
  `fpic` varchar(300) DEFAULT NULL,
  `weid` int(4) DEFAULT NULL,
  `isup` int(4) DEFAULT NULL,
  `isindex` int(4) DEFAULT NULL,
  `stitle` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_iweite_vods_category
-- ----------------------------

-- ----------------------------
-- Table structure for ims_iweite_vods_guanggao
-- ----------------------------
DROP TABLE IF EXISTS `ims_iweite_vods_guanggao`;
CREATE TABLE `ims_iweite_vods_guanggao` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `classid` int(4) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `fpic` varchar(300) DEFAULT NULL,
  `flink` mediumtext,
  `sid` int(4) DEFAULT '0',
  `dateline` varchar(80) DEFAULT NULL,
  `weid` int(4) DEFAULT '0',
  `apage` int(4) DEFAULT NULL,
  `astyle` int(4) DEFAULT NULL,
  `awidth` int(4) DEFAULT NULL,
  `aheight` int(4) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_iweite_vods_guanggao
-- ----------------------------

-- ----------------------------
-- Table structure for ims_iweite_vods_jiekou
-- ----------------------------
DROP TABLE IF EXISTS `ims_iweite_vods_jiekou`;
CREATE TABLE `ims_iweite_vods_jiekou` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(4) DEFAULT '0',
  `title` varchar(300) DEFAULT NULL,
  `fdes` mediumtext,
  `dateline` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_iweite_vods_jiekou
-- ----------------------------

-- ----------------------------
-- Table structure for ims_iweite_vods_mb
-- ----------------------------
DROP TABLE IF EXISTS `ims_iweite_vods_mb`;
CREATE TABLE `ims_iweite_vods_mb` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(4) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `fpic` varchar(300) DEFAULT NULL,
  `sid` int(4) DEFAULT '0',
  `dateline` varchar(80) DEFAULT NULL,
  `fdir` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_iweite_vods_mb
-- ----------------------------
INSERT INTO `ims_iweite_vods_mb` VALUES ('3', '0', '简约版', '../addons/iweite_vods/template/themes/images/jianyue.jpg', '0', '1480929246', 'jianyue');
INSERT INTO `ims_iweite_vods_mb` VALUES ('2', '0', '绿色版', '../addons/iweite_vods/template/themes/images/green.jpg', '0', '1480929225', 'green');
INSERT INTO `ims_iweite_vods_mb` VALUES ('1', '0', '蓝色版', '../addons/iweite_vods/template/themes/images/blue.jpg', '0', '1480929201', 'blue');

-- ----------------------------
-- Table structure for ims_iweite_vods_setting
-- ----------------------------
DROP TABLE IF EXISTS `ims_iweite_vods_setting`;
CREATE TABLE `ims_iweite_vods_setting` (
  `tid` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(4) DEFAULT '0',
  `title` varchar(300) DEFAULT NULL,
  `indexpagesize` int(4) DEFAULT '0',
  `pagesize` int(4) DEFAULT '0',
  `copyright` mediumtext,
  `cnzz` varchar(300) DEFAULT NULL,
  `share` mediumtext,
  `guanzhu` mediumtext,
  `mb` int(4) DEFAULT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `ck` mediumtext,
  `shikan` mediumtext,
  `passtip` mediumtext,
  `cpass` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_iweite_vods_setting
-- ----------------------------

-- ----------------------------
-- Table structure for ims_iweite_vods_ziyuan
-- ----------------------------
DROP TABLE IF EXISTS `ims_iweite_vods_ziyuan`;
CREATE TABLE `ims_iweite_vods_ziyuan` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `classid` int(4) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `fpic` varchar(300) DEFAULT NULL,
  `fdes` varchar(300) DEFAULT NULL,
  `isok` int(4) DEFAULT '0',
  `recommend` int(4) DEFAULT '0',
  `sid` int(4) DEFAULT '0',
  `dateline` varchar(80) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `guanlian` varchar(350) DEFAULT NULL,
  `content` mediumtext,
  `weid` int(4) DEFAULT '0',
  `flag` varchar(350) DEFAULT NULL,
  `cid` int(4) DEFAULT NULL,
  `fupdate` varchar(80) DEFAULT NULL,
  `fkeys` varchar(80) DEFAULT NULL,
  `shikan` int(4) DEFAULT NULL,
  `ispass` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ims_iweite_vods_ziyuan
-- ----------------------------

-- ----------------------------
-- Table structure for ims_iweite_vods_ziyuan_list
-- ----------------------------
DROP TABLE IF EXISTS `ims_iweite_vods_ziyuan_list`;
CREATE TABLE `ims_iweite_vods_ziyuan_list` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `classid` int(4) DEFAULT NULL,
  `content` mediumtext,
  `dateline` varchar(80) DEFAULT NULL,
  `weid` int(4) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");