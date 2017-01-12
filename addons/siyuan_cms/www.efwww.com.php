<?php
pdo_query("
DROP TABLE IF EXISTS `ims_siyuan_cms_ad`;
CREATE TABLE `ims_siyuan_cms_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `attachment` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_ad
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_admin
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_admin`;
CREATE TABLE `ims_siyuan_cms_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `state` int(2) NOT NULL,
  `uid` int(11) NOT NULL,
  `status` int(1) DEFAULT '0',
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_admin
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_api
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_api`;
CREATE TABLE `ims_siyuan_cms_api` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `baidu_key` varchar(100) NOT NULL,
  `city` varchar(20) NOT NULL,
  `place_key` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_api
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_black_list
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_black_list`;
CREATE TABLE `ims_siyuan_cms_black_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `openid` varchar(200) NOT NULL,
  `beizhu` varchar(500) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_black_list
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_bottom_menu
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_bottom_menu`;
CREATE TABLE `ims_siyuan_cms_bottom_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `xian` int(1) NOT NULL DEFAULT '0',
  `icon` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_bottom_menu
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_city
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_city`;
CREATE TABLE `ims_siyuan_cms_city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_city
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_flash
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_flash`;
CREATE TABLE `ims_siyuan_cms_flash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `attachment` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_flash
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_house
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_house`;
CREATE TABLE `ims_siyuan_cms_house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `price` int(10) NOT NULL DEFAULT '0',
  `phone` varchar(32) NOT NULL DEFAULT '',
  `address` varchar(512) NOT NULL DEFAULT '',
  `province` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `district` varchar(50) NOT NULL DEFAULT '',
  `opentime` int(10) unsigned NOT NULL DEFAULT '0',
  `hotmsg` varchar(255) NOT NULL DEFAULT '',
  `longitude` varchar(255) NOT NULL DEFAULT '',
  `latitude` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `descimgs` mediumtext,
  `description` mediumtext,
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fenxiang` varchar(255) NOT NULL,
  `video` varchar(2000) NOT NULL,
  `biaoti` varchar(255) NOT NULL,
  `youhui` varchar(100) NOT NULL,
  `fenji` varchar(20) NOT NULL,
  `huxingimgs` mediumtext,
  `tj` int(1) DEFAULT '0',
  `zt` varchar(10) NOT NULL,
  `flash` mediumtext,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_house
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_house_flash
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_house_flash`;
CREATE TABLE `ims_siyuan_cms_house_flash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `thumb` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_house_flash
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_house_guwen
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_house_guwen`;
CREATE TABLE `ims_siyuan_cms_house_guwen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `hid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL DEFAULT '',
  `zhiwei` varchar(30) NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `tel` varchar(20) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `pic` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_houseid` (`hid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_house_guwen
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_house_guwen_body
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_house_guwen_body`;
CREATE TABLE `ims_siyuan_cms_house_guwen_body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `hid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `body` varchar(500) DEFAULT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  `openid` varchar(150) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`),
  KEY `indx_lookid` (`hid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_house_guwen_body
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_house_kv
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_house_kv`;
CREATE TABLE `ims_siyuan_cms_house_kv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `houseid` int(11) NOT NULL DEFAULT '0',
  `key` varchar(512) NOT NULL DEFAULT '',
  `value` varchar(512) NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_houseid` (`houseid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_house_kv
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_house_map_nav
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_house_map_nav`;
CREATE TABLE `ims_siyuan_cms_house_map_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `icon_1` varchar(200) DEFAULT NULL,
  `icon_2` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_house_map_nav
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_house_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_house_news`;
CREATE TABLE `ims_siyuan_cms_house_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loupanid` int(10) DEFAULT NULL,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容配图',
  `laiyuan` varchar(50) NOT NULL DEFAULT '' COMMENT '来源',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击积分奖励',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_house_news
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_huodong
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_huodong`;
CREATE TABLE `ims_siyuan_cms_huodong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `feiyong` int(10) NOT NULL DEFAULT '0',
  `tel` varchar(32) NOT NULL DEFAULT '',
  `address` varchar(512) NOT NULL DEFAULT '',
  `province` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `district` varchar(50) NOT NULL DEFAULT '',
  `longitude` varchar(255) NOT NULL DEFAULT '',
  `latitude` varchar(255) NOT NULL DEFAULT '',
  `descimgs` mediumtext,
  `body` text,
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  `fenxiang` varchar(255) NOT NULL,
  `video` varchar(2000) NOT NULL,
  `biaoti` varchar(255) NOT NULL,
  `ad` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `shop` varchar(20) NOT NULL,
  `blei` int(10) DEFAULT NULL,
  `slei` int(10) DEFAULT NULL,
  `time` int(10) DEFAULT NULL,
  `endtime` int(10) DEFAULT NULL,
  `xianzhi` int(10) NOT NULL DEFAULT '1000',
  `thumb` varchar(200) DEFAULT NULL,
  `music` varchar(200) DEFAULT NULL,
  `renshu` int(10) NOT NULL DEFAULT '0',
  `yuedu` int(15) NOT NULL DEFAULT '0',
  `open` int(1) NOT NULL DEFAULT '0',
  `shopid` int(10) NOT NULL DEFAULT '0',
  `pinglun` int(10) DEFAULT '0',
  `bm_time` int(10) DEFAULT NULL,
  `lx` varchar(20) NOT NULL,
  `pic` varchar(250) NOT NULL,
  `flash` int(1) DEFAULT '0',
  `num` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_huodong
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_huodong_fenlei
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_huodong_fenlei`;
CREATE TABLE `ims_siyuan_cms_huodong_fenlei` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `nid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联导航id',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `thumb` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_huodong_fenlei
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_huodong_kv
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_huodong_kv`;
CREATE TABLE `ims_siyuan_cms_huodong_kv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `huodongid` int(11) NOT NULL DEFAULT '0',
  `key` varchar(512) NOT NULL DEFAULT '',
  `value` varchar(512) NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_houseid` (`huodongid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_huodong_kv
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_huodong_pinglun
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_huodong_pinglun`;
CREATE TABLE `ims_siyuan_cms_huodong_pinglun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar` varchar(300) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `huodongid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `content` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) NOT NULL DEFAULT '0',
  `openid` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_lookid` (`huodongid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_huodong_pinglun
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_huodong_users
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_huodong_users`;
CREATE TABLE `ims_siyuan_cms_huodong_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `huodongid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `tel` varchar(20) NOT NULL DEFAULT '',
  `body` varchar(1000) DEFAULT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `avatar` varchar(300) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `ordersn` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`),
  KEY `indx_lookid` (`huodongid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_huodong_users
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_index
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_index`;
CREATE TABLE `ims_siyuan_cms_index` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `ad_1` varchar(200) NOT NULL DEFAULT '',
  `ad_2` varchar(200) NOT NULL DEFAULT '',
  `ad_url_1` varchar(200) NOT NULL DEFAULT '',
  `ad_url_2` varchar(200) NOT NULL DEFAULT '',
  `city` int(1) DEFAULT '0',
  `qiandao` varchar(250) NOT NULL,
  `color_open` int(1) DEFAULT '1',
  `anniu` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_index
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_index_flash
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_index_flash`;
CREATE TABLE `ims_siyuan_cms_index_flash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `thumb` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_index_flash
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_index_list
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_index_list`;
CREATE TABLE `ims_siyuan_cms_index_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `nid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联导航id',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `thumb` varchar(300) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `body` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_index_list
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_index_nav
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_index_nav`;
CREATE TABLE `ims_siyuan_cms_index_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `icon` varchar(200) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_index_nav
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_index_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_index_set`;
CREATE TABLE `ims_siyuan_cms_index_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `news_logo` varchar(250) DEFAULT NULL,
  `news_name` varchar(20) NOT NULL DEFAULT '最新资讯',
  `news_num` int(10) NOT NULL DEFAULT '5',
  `news_xs` int(1) NOT NULL DEFAULT '0',
  `weixin_logo` varchar(250) NOT NULL,
  `weixin_name` varchar(20) NOT NULL DEFAULT '微信头条',
  `weixin_num` int(10) NOT NULL DEFAULT '5',
  `weixin_xs` int(1) NOT NULL DEFAULT '0',
  `huodong_logo` varchar(250) NOT NULL,
  `huodong_name` varchar(20) NOT NULL DEFAULT '最新活动',
  `huodong_num` int(10) NOT NULL DEFAULT '5',
  `huodong_xs` int(1) NOT NULL DEFAULT '0',
  `shop_logo` varchar(250) NOT NULL,
  `shop_name` varchar(20) NOT NULL DEFAULT '星级商家',
  `shop_num` int(10) NOT NULL DEFAULT '8',
  `shop_xs` int(1) NOT NULL DEFAULT '0',
  `house_logo` varchar(250) NOT NULL,
  `house_name` varchar(20) NOT NULL DEFAULT '楼盘大全',
  `house_num` int(10) NOT NULL DEFAULT '5',
  `house_xs` int(1) NOT NULL DEFAULT '0',
  `fang_logo` varchar(250) NOT NULL,
  `zufang_logo` varchar(250) NOT NULL,
  `job_logo` varchar(250) NOT NULL,
  `geren_logo` varchar(250) NOT NULL,
  `car_logo` varchar(250) NOT NULL,
  `ershou_logo` varchar(250) NOT NULL,
  `chongwu_logo` varchar(250) NOT NULL,
  `fang_name` varchar(20) NOT NULL DEFAULT '房屋出售',
  `zufang_name` varchar(20) NOT NULL DEFAULT '房屋出租',
  `job_name` varchar(20) NOT NULL DEFAULT '企业招聘',
  `geren_name` varchar(20) NOT NULL DEFAULT '个人求职',
  `car_name` varchar(20) NOT NULL DEFAULT '车辆交易',
  `ershou_name` varchar(20) NOT NULL DEFAULT '二手交易',
  `chongwu_name` varchar(20) NOT NULL DEFAULT '宠物世界',
  `fang_num` int(10) NOT NULL DEFAULT '5',
  `zufang_num` int(10) NOT NULL DEFAULT '5',
  `job_num` int(10) NOT NULL DEFAULT '5',
  `geren_num` int(10) NOT NULL DEFAULT '5',
  `car_num` int(10) NOT NULL DEFAULT '5',
  `ershou_num` int(10) NOT NULL DEFAULT '5',
  `chongwu_num` int(10) NOT NULL DEFAULT '5',
  `fang_xs` int(1) NOT NULL DEFAULT '0',
  `zufang_xs` int(1) NOT NULL DEFAULT '0',
  `car_xs` int(1) NOT NULL DEFAULT '0',
  `job_xs` int(1) NOT NULL DEFAULT '0',
  `geren_xs` int(1) NOT NULL DEFAULT '0',
  `ershou_xs` int(1) NOT NULL DEFAULT '0',
  `chongwu_xs` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_index_set
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_menu
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_menu`;
CREATE TABLE `ims_siyuan_cms_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `xian` int(1) NOT NULL DEFAULT '0',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_menu
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_my_nav
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_my_nav`;
CREATE TABLE `ims_siyuan_cms_my_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `icon` varchar(30) DEFAULT NULL,
  `body` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_my_nav
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_nav
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_nav`;
CREATE TABLE `ims_siyuan_cms_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url_1` varchar(250) NOT NULL DEFAULT '',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `url_2` varchar(250) NOT NULL,
  `icon_1` varchar(200) DEFAULT NULL,
  `icon_2` varchar(200) DEFAULT NULL,
  `bs` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `title_2` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_nav
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_news`;
CREATE TABLE `ims_siyuan_cms_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '缩略图1',
  `laiyuan` varchar(50) NOT NULL DEFAULT '' COMMENT '来源',
  `zuozhe` varchar(50) NOT NULL COMMENT '作者',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `zan` int(11) NOT NULL,
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `cai` int(11) NOT NULL,
  `pinglun` int(11) NOT NULL DEFAULT '0',
  `tuijian` int(2) NOT NULL DEFAULT '0',
  `weid` int(10) NOT NULL,
  `blei` int(10) DEFAULT '0',
  `slei` int(10) DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `descimgs` mediumtext,
  `flash` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_news
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_news_fenlei
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_news_fenlei`;
CREATE TABLE `ims_siyuan_cms_news_fenlei` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `nid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联导航id',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `thumb` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_news_fenlei
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_news_pinglun
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_news_pinglun`;
CREATE TABLE `ims_siyuan_cms_news_pinglun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar` varchar(300) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `newsid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `content` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_lookid` (`newsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_news_pinglun
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_news_zhuanti
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_news_zhuanti`;
CREATE TABLE `ims_siyuan_cms_news_zhuanti` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recommendation` text NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `video` varchar(600) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容配图',
  `fenxiang` varchar(1024) NOT NULL DEFAULT '' COMMENT '分享缩率图',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `zan` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `cai` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_news_zhuanti
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_order
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_order`;
CREATE TABLE `ims_siyuan_cms_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `title` varchar(300) DEFAULT NULL,
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `paytype` tinyint(1) unsigned NOT NULL,
  `transid` varchar(30) NOT NULL DEFAULT '0',
  `remark` varchar(1000) NOT NULL DEFAULT '',
  `createtime` int(10) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_order
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_pk
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_pk`;
CREATE TABLE `ims_siyuan_cms_pk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `body` varchar(5000) NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '缩略图1',
  `fenxiang` varchar(1024) NOT NULL DEFAULT '' COMMENT '分享缩率图',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `red` int(11) NOT NULL DEFAULT '0',
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pinglun` int(11) NOT NULL DEFAULT '0',
  `weid` int(10) unsigned NOT NULL,
  `red_guandian` varchar(200) NOT NULL,
  `blue_guandian` varchar(200) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `blue` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_pk
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_pk_pinglun
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_pk_pinglun`;
CREATE TABLE `ims_siyuan_cms_pk_pinglun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar` varchar(300) NOT NULL,
  `weid` int(11) NOT NULL DEFAULT '0',
  `newsid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `content` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`),
  KEY `indx_lookid` (`newsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_pk_pinglun
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_pk_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_pk_user`;
CREATE TABLE `ims_siyuan_cms_pk_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `openid` varchar(200) NOT NULL,
  `newsid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_pk_user
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_quan
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_quan`;
CREATE TABLE `ims_siyuan_cms_quan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned NOT NULL DEFAULT '0',
  `body` text,
  `openid` varchar(120) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `time` int(10) DEFAULT NULL,
  `vod` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_quan
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_quan_flash
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_quan_flash`;
CREATE TABLE `ims_siyuan_cms_quan_flash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `thumb` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_quan_flash
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_quan_img
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_quan_img`;
CREATE TABLE `ims_siyuan_cms_quan_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` varchar(500) DEFAULT NULL,
  `qid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_quan_img
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_quan_pinglun
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_quan_pinglun`;
CREATE TABLE `ims_siyuan_cms_quan_pinglun` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned NOT NULL DEFAULT '0',
  `body` text,
  `openid` varchar(120) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `pid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_quan_pinglun
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_sai
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_sai`;
CREATE TABLE `ims_siyuan_cms_sai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `pic` varchar(200) DEFAULT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `fengmian` varchar(300) DEFAULT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `sai` varchar(100) DEFAULT NULL,
  `indexbg` varchar(300) DEFAULT NULL,
  `listbg` varchar(300) DEFAULT NULL,
  `topbg` varchar(300) DEFAULT NULL,
  `listbgcolor` varchar(30) NOT NULL DEFAULT '#ec3c05',
  `listcolor` varchar(30) NOT NULL DEFAULT '#ffffff',
  `fx_title` varchar(200) DEFAULT NULL,
  `fx_tubiao` varchar(250) DEFAULT NULL,
  `banquan_url` varchar(250) DEFAULT NULL,
  `banquan` varchar(100) DEFAULT NULL,
  `bg_color` varchar(30) NOT NULL DEFAULT '#005192',
  `bottom_color` varchar(30) NOT NULL DEFAULT '#feda0d',
  `nr_color` varchar(30) NOT NULL DEFAULT '#057ac9',
  `paddtop` int(10) NOT NULL DEFAULT '400',
  `size_color` varchar(30) DEFAULT '#ffffff',
  `baoming_1` varchar(50) DEFAULT NULL,
  `baoming_2` varchar(50) DEFAULT NULL,
  `baoming_3` varchar(50) DEFAULT NULL,
  `baoming_4` varchar(50) DEFAULT NULL,
  `baoming_5` varchar(50) DEFAULT NULL,
  `baoming_6` varchar(50) DEFAULT NULL,
  `baoming_7` varchar(50) DEFAULT NULL,
  `baoming_8` varchar(50) DEFAULT NULL,
  `baoming_tishi` text,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_sai
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_sai_danye
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_sai_danye`;
CREATE TABLE `ims_siyuan_cms_sai_danye` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容配图',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pinglun` int(11) NOT NULL DEFAULT '0',
  `sid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_sai_danye
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_sai_menu
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_sai_menu`;
CREATE TABLE `ims_siyuan_cms_sai_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `url` varchar(300) NOT NULL,
  `left` int(10) NOT NULL,
  `top` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_sai_menu
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_sai_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_sai_news`;
CREATE TABLE `ims_siyuan_cms_sai_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容配图',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pinglun` int(11) NOT NULL DEFAULT '0',
  `sid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_sai_news
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_sai_user
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_sai_user`;
CREATE TABLE `ims_siyuan_cms_sai_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `avatar` varchar(300) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `baoming_1` varchar(200) DEFAULT NULL,
  `baoming_2` varchar(200) DEFAULT NULL,
  `baoming_3` varchar(200) DEFAULT NULL,
  `baoming_4` varchar(200) DEFAULT NULL,
  `baoming_5` varchar(200) DEFAULT NULL,
  `baoming_6` varchar(200) DEFAULT NULL,
  `baoming_7` varchar(200) DEFAULT NULL,
  `baoming_8` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`),
  KEY `indx_lookid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_sai_user
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_sai_zanzhu
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_sai_zanzhu`;
CREATE TABLE `ims_siyuan_cms_sai_zanzhu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `sid` int(10) NOT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_sai_zanzhu
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_setting
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_setting`;
CREATE TABLE `ims_siyuan_cms_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `qnsk` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `weixin` varchar(100) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `zhuangxiu_xiaoxi` varchar(100) NOT NULL,
  `tougao_xiaoxi` varchar(100) NOT NULL,
  `color` varchar(50) NOT NULL DEFAULT '#fb9032',
  `logo` varchar(300) NOT NULL,
  `qr` varchar(300) NOT NULL,
  `qnscode` varchar(200) NOT NULL,
  `qnym` varchar(200) NOT NULL,
  `qnak` varchar(200) NOT NULL,
  `apiclient_cert` varchar(500) NOT NULL,
  `apiclient_key` varchar(500) NOT NULL,
  `video` varchar(20) NOT NULL,
  `tel_pay` decimal(10,2) NOT NULL DEFAULT '0.00',
  `xinxi_pay` decimal(10,2) NOT NULL DEFAULT '0.00',
  `city` varchar(20) NOT NULL,
  `shop_pay` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_setting
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_share_set
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_share_set`;
CREATE TABLE `ims_siyuan_cms_share_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `quan_title` varchar(100) DEFAULT NULL,
  `quan_pic` varchar(250) DEFAULT NULL,
  `index_title` varchar(100) DEFAULT NULL,
  `index_pic` varchar(250) DEFAULT NULL,
  `xinxi_title` varchar(100) DEFAULT NULL,
  `xinxi_pic` varchar(250) DEFAULT NULL,
  `news_title` varchar(100) DEFAULT NULL,
  `news_pic` varchar(250) DEFAULT NULL,
  `weixin_title` varchar(100) DEFAULT NULL,
  `weixin_pic` varchar(250) DEFAULT NULL,
  `vod_title` varchar(100) DEFAULT NULL,
  `vod_pic` varchar(250) DEFAULT NULL,
  `huodong_title` varchar(100) DEFAULT NULL,
  `huodong_pic` varchar(250) DEFAULT NULL,
  `tel_title` varchar(100) DEFAULT NULL,
  `tel_pic` varchar(250) DEFAULT NULL,
  `zhibo_title` varchar(100) DEFAULT NULL,
  `zhibo_pic` varchar(250) DEFAULT NULL,
  `baoliao_title` varchar(100) DEFAULT NULL,
  `baoliao_pic` varchar(250) DEFAULT NULL,
  `shop_title` varchar(100) DEFAULT NULL,
  `shop_pic` varchar(250) DEFAULT NULL,
  `house_title` varchar(100) DEFAULT NULL,
  `house_pic` varchar(250) DEFAULT NULL,
  `zhuangxiu_title` varchar(100) DEFAULT NULL,
  `zhuangxiu_pic` varchar(250) DEFAULT NULL,
  `xinxi_house_title` varchar(100) DEFAULT NULL,
  `xinxi_house_pic` varchar(250) DEFAULT NULL,
  `xinxi_zufang_title` varchar(100) DEFAULT NULL,
  `xinxi_zufang_pic` varchar(250) DEFAULT NULL,
  `xinxi_job_title` varchar(100) DEFAULT NULL,
  `xinxi_geren_title` varchar(100) DEFAULT NULL,
  `xinxi_geren_pic` varchar(250) DEFAULT NULL,
  `xinxi_ershou_title` varchar(100) DEFAULT NULL,
  `xinxi_ershou_pic` varchar(250) DEFAULT NULL,
  `xinxi_car_title` varchar(100) DEFAULT NULL,
  `xinxi_car_pic` varchar(250) DEFAULT NULL,
  `xinxi_chongwu_title` varchar(100) DEFAULT NULL,
  `xinxi_chongwu_pic` varchar(250) DEFAULT NULL,
  `house_list_title` varchar(100) DEFAULT NULL,
  `house_list_pic` varchar(250) DEFAULT NULL,
  `house_news_title` varchar(100) DEFAULT NULL,
  `house_news_pic` varchar(250) DEFAULT NULL,
  `xinxi_job_pic` varchar(250) DEFAULT NULL,
  `gongzhonghao_title` varchar(100) DEFAULT NULL,
  `gongzhonghao_pic` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_share_set
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_shop
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_shop`;
CREATE TABLE `ims_siyuan_cms_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `tel` varchar(32) NOT NULL DEFAULT '',
  `address` varchar(512) NOT NULL DEFAULT '',
  `longitude` varchar(255) NOT NULL DEFAULT '',
  `latitude` varchar(255) NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `fenxiang` varchar(255) NOT NULL,
  `video` varchar(2000) NOT NULL,
  `biaoti` varchar(255) NOT NULL,
  `ad` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `youhui` varchar(100) NOT NULL,
  `blei` int(10) NOT NULL,
  `slei` int(10) NOT NULL,
  `ding` int(1) NOT NULL DEFAULT '0',
  `descimgs` mediumtext,
  `thumb` varchar(250) NOT NULL,
  `body` text,
  `yuedu` int(20) NOT NULL DEFAULT '0',
  `pinglun` int(10) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `yingye` varchar(100) DEFAULT NULL,
  `weixin` varchar(200) DEFAULT NULL,
  `openid` varchar(100) NOT NULL,
  `zi` varchar(2) NOT NULL,
  `flash` varchar(250) NOT NULL,
  `color` varchar(20) NOT NULL DEFAULT '#ec6c53',
  `ordersn` varchar(20) NOT NULL,
  `fans` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_shop
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_shop_fenlei
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_shop_fenlei`;
CREATE TABLE `ims_siyuan_cms_shop_fenlei` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `nid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联导航id',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `thumb` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_shop_fenlei
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_shop_img
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_shop_img`;
CREATE TABLE `ims_siyuan_cms_shop_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pic` varchar(500) NOT NULL DEFAULT '',
  `mid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_shop_img
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_shop_kv
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_shop_kv`;
CREATE TABLE `ims_siyuan_cms_shop_kv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `shopid` int(11) NOT NULL DEFAULT '0',
  `key` varchar(512) NOT NULL DEFAULT '',
  `value` varchar(512) NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_shopid` (`shopid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_shop_kv
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_shop_pinglun
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_shop_pinglun`;
CREATE TABLE `ims_siyuan_cms_shop_pinglun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar` varchar(300) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `shopid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `content` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_lookid` (`shopid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_shop_pinglun
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_tel
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_tel`;
CREATE TABLE `ims_siyuan_cms_tel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `tel` varchar(100) NOT NULL DEFAULT '',
  `weixin` varchar(100) NOT NULL DEFAULT '',
  `address` varchar(200) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `ding` int(1) NOT NULL DEFAULT '0',
  `blei` int(10) NOT NULL,
  `slei` int(10) NOT NULL,
  `qr` varchar(300) NOT NULL,
  `openid` varchar(100) NOT NULL,
  `ordersn` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_tel
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_tel_fenlei
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_tel_fenlei`;
CREATE TABLE `ims_siyuan_cms_tel_fenlei` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `nid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联导航id',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `thumb` varchar(300) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_tel_fenlei
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_tougao
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_tougao`;
CREATE TABLE `ims_siyuan_cms_tougao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `pic` text,
  `weixin` varchar(100) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `uid` int(10) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `yuedu` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_tougao
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_tougao_img
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_tougao_img`;
CREATE TABLE `ims_siyuan_cms_tougao_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pic` varchar(500) NOT NULL DEFAULT '',
  `mid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_tougao_img
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_tuan
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_tuan`;
CREATE TABLE `ims_siyuan_cms_tuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `thumb` varchar(200) DEFAULT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `fx_title` varchar(300) DEFAULT NULL,
  `fx_tubiao` varchar(300) DEFAULT NULL,
  `top_pic` varchar(300) DEFAULT NULL,
  `ka_pic` varchar(300) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT '0.00',
  `time` varchar(300) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `body` text,
  `ka_pic_bottom` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_tuan
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_tuan_gongsi
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_tuan_gongsi`;
CREATE TABLE `ims_siyuan_cms_tuan_gongsi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `sid` int(10) NOT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_tuan_gongsi
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_tuan_huodong
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_tuan_huodong`;
CREATE TABLE `ims_siyuan_cms_tuan_huodong` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `body` varchar(200) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `sid` int(10) NOT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_tuan_huodong
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_tuan_pinpai
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_tuan_pinpai`;
CREATE TABLE `ims_siyuan_cms_tuan_pinpai` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `sid` int(10) NOT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_tuan_pinpai
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_vod
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_vod`;
CREATE TABLE `ims_siyuan_cms_vod` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `blei` int(11) DEFAULT NULL,
  `video` varchar(1000) NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '缩略图1',
  `fenxiang` varchar(1024) NOT NULL DEFAULT '' COMMENT '分享缩率图',
  `laiyuan` varchar(50) NOT NULL DEFAULT '' COMMENT '来源',
  `zuozhe` varchar(50) NOT NULL COMMENT '作者',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `zan` int(11) NOT NULL,
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `cai` int(11) NOT NULL,
  `pinglun` int(11) NOT NULL DEFAULT '0',
  `tuijian` int(2) NOT NULL DEFAULT '0',
  `weid` int(10) unsigned NOT NULL,
  `slei` int(11) DEFAULT NULL,
  `content` text,
  `url` varchar(300) NOT NULL,
  `flash` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_vod
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_vod_fenlei
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_vod_fenlei`;
CREATE TABLE `ims_siyuan_cms_vod_fenlei` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `nid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联导航id',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `thumb` varchar(200) NOT NULL,
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_vod_fenlei
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_vod_pinglun
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_vod_pinglun`;
CREATE TABLE `ims_siyuan_cms_vod_pinglun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar` varchar(300) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `newsid` int(11) NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `content` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_lookid` (`newsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_vod_pinglun
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_vod_zhuanti
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_vod_zhuanti`;
CREATE TABLE `ims_siyuan_cms_vod_zhuanti` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recommendation` text NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `video` varchar(600) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容配图',
  `fenxiang` varchar(1024) NOT NULL DEFAULT '' COMMENT '分享缩率图',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `zan` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `cai` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_vod_zhuanti
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_weixin
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_weixin`;
CREATE TABLE `ims_siyuan_cms_weixin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `pic` varchar(200) DEFAULT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `weixin` varchar(100) DEFAULT NULL,
  `flash` varchar(200) NOT NULL,
  `zhuti` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_weixin
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_weixin_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_weixin_news`;
CREATE TABLE `ims_siyuan_cms_weixin_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容配图',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `zan` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数',
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pinglun` int(11) NOT NULL DEFAULT '0',
  `cai` int(11) NOT NULL DEFAULT '0',
  `weixinid` int(10) DEFAULT NULL,
  `laiyuan` varchar(50) DEFAULT NULL,
  `url` varchar(300) NOT NULL,
  `descimgs` mediumtext,
  `flash` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_weixin_news
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_weixin_news_pinglun
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_weixin_news_pinglun`;
CREATE TABLE `ims_siyuan_cms_weixin_news_pinglun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar` varchar(300) NOT NULL,
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `newsid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `content` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) NOT NULL DEFAULT '0',
  `openid` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_lookid` (`newsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_weixin_news_pinglun
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_xiaoxi
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_xiaoxi`;
CREATE TABLE `ims_siyuan_cms_xiaoxi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `guwen_xiaoxi` varchar(100) DEFAULT NULL,
  `house_xiaoxi` varchar(100) DEFAULT NULL,
  `pinglun_xiaoxi` varchar(100) DEFAULT NULL,
  `huodong_xiaoxi` varchar(100) DEFAULT NULL,
  `tougao_xiaoxi` varchar(100) DEFAULT NULL,
  `zhuangxiu_xiaoxi` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_xiaoxi
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_xinxi_car
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_xinxi_car`;
CREATE TABLE `ims_siyuan_cms_xinxi_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `pic` text,
  `phone` varchar(20) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `uid` int(10) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `blei` int(10) DEFAULT NULL,
  `slei` int(10) DEFAULT NULL,
  `chengse` varchar(50) DEFAULT NULL,
  `leixing` varchar(50) DEFAULT NULL,
  `biansu` varchar(50) DEFAULT NULL,
  `jiage` varchar(20) DEFAULT NULL,
  `pinpai` varchar(50) DEFAULT NULL,
  `yuedu` int(10) NOT NULL DEFAULT '0',
  `ding` int(1) NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ding_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_xinxi_car
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_xinxi_chongwu
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_xinxi_chongwu`;
CREATE TABLE `ims_siyuan_cms_xinxi_chongwu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `pic` text,
  `phone` varchar(20) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `uid` int(10) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `blei` int(10) DEFAULT NULL,
  `slei` int(10) DEFAULT NULL,
  `jiage` int(10) DEFAULT NULL,
  `leixing` varchar(20) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `yuedu` int(10) NOT NULL DEFAULT '0',
  `ding` int(1) NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ding_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_xinxi_chongwu
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_xinxi_ershou
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_xinxi_ershou`;
CREATE TABLE `ims_siyuan_cms_xinxi_ershou` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `pic` text,
  `phone` varchar(20) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `avatar` varchar(200) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `blei` int(10) DEFAULT NULL,
  `slei` int(10) DEFAULT NULL,
  `jiage` int(12) NOT NULL DEFAULT '0',
  `xinjiu` varchar(50) DEFAULT NULL,
  `yuedu` int(10) NOT NULL DEFAULT '0',
  `ding` int(1) NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ding_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_xinxi_ershou
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_xinxi_geren
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_xinxi_geren`;
CREATE TABLE `ims_siyuan_cms_xinxi_geren` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `pic` text,
  `phone` varchar(20) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `qiye` varchar(100) DEFAULT NULL,
  `renshu` int(10) DEFAULT NULL,
  `zhiwei` varchar(100) DEFAULT NULL,
  `xueli` varchar(50) DEFAULT NULL,
  `gongzi` varchar(50) DEFAULT NULL,
  `uid` int(10) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `blei` int(10) DEFAULT NULL,
  `slei` int(10) DEFAULT NULL,
  `yuedu` int(10) NOT NULL DEFAULT '0',
  `ding` int(1) NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ding_time` int(10) unsigned NOT NULL DEFAULT '0',
  `gongzuo` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_xinxi_geren
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_xinxi_house
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_xinxi_house`;
CREATE TABLE `ims_siyuan_cms_xinxi_house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `pic` text,
  `phone` varchar(20) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `huxing` varchar(100) DEFAULT NULL,
  `mianji` varchar(100) DEFAULT NULL,
  `louceng_1` varchar(10) DEFAULT NULL,
  `louceng_2` varchar(10) DEFAULT NULL,
  `zhuangxiu` varchar(100) DEFAULT NULL,
  `jiage` varchar(20) NOT NULL DEFAULT '0',
  `yuedu` int(10) NOT NULL DEFAULT '0',
  `ding` int(1) NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ding_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_xinxi_house
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_xinxi_img
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_xinxi_img`;
CREATE TABLE `ims_siyuan_cms_xinxi_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` varchar(500) DEFAULT NULL,
  `mid` int(10) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_xinxi_img
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_xinxi_job
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_xinxi_job`;
CREATE TABLE `ims_siyuan_cms_xinxi_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `pic` text,
  `qiye` varchar(100) DEFAULT NULL,
  `renshu` int(10) DEFAULT NULL,
  `zhiwei` varchar(100) DEFAULT NULL,
  `xueli` varchar(50) DEFAULT NULL,
  `gongzi` varchar(50) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `yuedu` int(10) NOT NULL DEFAULT '0',
  `ding` int(1) NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ding_time` int(10) unsigned NOT NULL DEFAULT '0',
  `gongzuo` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_xinxi_job
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_xinxi_zufang
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_xinxi_zufang`;
CREATE TABLE `ims_siyuan_cms_xinxi_zufang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(100) NOT NULL,
  `huxing` varchar(100) DEFAULT NULL,
  `mianji` varchar(100) DEFAULT NULL,
  `louceng_1` varchar(10) DEFAULT NULL,
  `zhuangxiu` varchar(100) DEFAULT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `louceng_2` varchar(10) DEFAULT NULL,
  `pic` text,
  `jiage` int(11) NOT NULL DEFAULT '0',
  `name` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `zujin` varchar(200) DEFAULT NULL,
  `yuedu` int(10) NOT NULL DEFAULT '0',
  `ding` int(1) NOT NULL DEFAULT '0',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ding_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_xinxi_zufang
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhibo
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhibo`;
CREATE TABLE `ims_siyuan_cms_zhibo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(320) DEFAULT NULL,
  `thumb` varchar(200) DEFAULT NULL,
  `renshu` int(11) DEFAULT '0',
  `starttime` int(10) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0',
  `shua` int(10) NOT NULL DEFAULT '30',
  `fenxiang` varchar(200) DEFAULT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `zan` int(11) NOT NULL DEFAULT '0',
  `cai` int(11) NOT NULL DEFAULT '0',
  `yuedu` int(11) NOT NULL DEFAULT '0',
  `zhiboid` varchar(100) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `appkey` varchar(100) NOT NULL,
  `lx` int(1) DEFAULT '0',
  `qiniu_tuiliu` varchar(300) NOT NULL,
  `qiniu_play` varchar(300) NOT NULL,
  `body` text,
  `zhibo_url` varchar(300) NOT NULL,
  `tuwen_url` varchar(300) NOT NULL,
  `zb_lx` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhibo
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhibo_admin
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhibo_admin`;
CREATE TABLE `ims_siyuan_cms_zhibo_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `openid` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `state` int(2) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `zid` int(10) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhibo_admin
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhibo_body
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhibo_body`;
CREATE TABLE `ims_siyuan_cms_zhibo_body` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned NOT NULL DEFAULT '0',
  `body` text,
  `username` varchar(64) DEFAULT NULL,
  `avatar` varchar(250) DEFAULT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  `zan` int(10) NOT NULL DEFAULT '0',
  `openid` varchar(100) DEFAULT NULL,
  `pic` text,
  `vod` varchar(500) DEFAULT NULL,
  `zhiboid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhibo_body
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhibo_pinglun
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhibo_pinglun`;
CREATE TABLE `ims_siyuan_cms_zhibo_pinglun` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned NOT NULL DEFAULT '0',
  `body` varchar(500) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `avatar` varchar(250) DEFAULT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  `zhiboid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhibo_pinglun
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhuangxiu_baojia
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhuangxiu_baojia`;
CREATE TABLE `ims_siyuan_cms_zhuangxiu_baojia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `tel` varchar(100) DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  `xiaoqu` varchar(100) DEFAULT NULL,
  `mianji` varchar(100) DEFAULT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  `gongsi` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhuangxiu_baojia
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhuangxiu_flash
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhuangxiu_flash`;
CREATE TABLE `ims_siyuan_cms_zhuangxiu_flash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(200) NOT NULL DEFAULT '',
  `attachment` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhuangxiu_flash
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhuangxiu_gonglve
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhuangxiu_gonglve`;
CREATE TABLE `ims_siyuan_cms_zhuangxiu_gonglve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `pic` varchar(200) DEFAULT NULL,
  `body` varchar(1000) DEFAULT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `ad` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhuangxiu_gonglve
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhuangxiu_gonglve_news
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhuangxiu_gonglve_news`;
CREATE TABLE `ims_siyuan_cms_zhuangxiu_gonglve_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容配图',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pinglun` int(11) NOT NULL DEFAULT '0',
  `gonglveid` int(10) DEFAULT NULL,
  `n_title` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhuangxiu_gonglve_news
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhuangxiu_gongsi
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhuangxiu_gongsi`;
CREATE TABLE `ims_siyuan_cms_zhuangxiu_gongsi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `pic` varchar(200) DEFAULT NULL,
  `body` text,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `ad` varchar(100) DEFAULT NULL,
  `thumb` varchar(200) DEFAULT NULL,
  `gongdi` int(10) DEFAULT '0',
  `anli` int(10) DEFAULT '0',
  `yezhu` int(10) DEFAULT '0',
  `openid` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhuangxiu_gongsi
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhuangxiu_gongsi_anli
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhuangxiu_gongsi_anli`;
CREATE TABLE `ims_siyuan_cms_zhuangxiu_gongsi_anli` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容配图',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `yuedu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读数',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pinglun` int(11) NOT NULL DEFAULT '0',
  `gongsiid` int(10) DEFAULT NULL,
  `gongsi` varchar(50) DEFAULT NULL,
  `sheji` varchar(100) DEFAULT NULL,
  `huxing` varchar(200) DEFAULT NULL,
  `shejiid` int(10) DEFAULT NULL,
  `xiaoqu` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhuangxiu_gongsi_anli
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhuangxiu_gongsi_sheji
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhuangxiu_gongsi_sheji`;
CREATE TABLE `ims_siyuan_cms_zhuangxiu_gongsi_sheji` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `thumb` varchar(1024) NOT NULL DEFAULT '' COMMENT '内容配图',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `pinglun` int(11) NOT NULL DEFAULT '0',
  `gongsiid` int(10) DEFAULT NULL,
  `touxiang` varchar(200) DEFAULT NULL,
  `gongsi` varchar(100) DEFAULT NULL,
  `tedian` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhuangxiu_gongsi_sheji
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhuangxiu_yanfang
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhuangxiu_yanfang`;
CREATE TABLE `ims_siyuan_cms_zhuangxiu_yanfang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `tel` varchar(100) DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  `xiaoqu` varchar(100) DEFAULT NULL,
  `mianji` varchar(100) DEFAULT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  `gongsi` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of ims_siyuan_cms_zhuangxiu_yanfang
-- ----------------------------

-- ----------------------------
-- Table structure for ims_siyuan_cms_zhuangxiu_yuyue
-- ----------------------------
DROP TABLE IF EXISTS `ims_siyuan_cms_zhuangxiu_yuyue`;
CREATE TABLE `ims_siyuan_cms_zhuangxiu_yuyue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `tel` varchar(100) DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  `xiaoqu` varchar(100) DEFAULT NULL,
  `mianji` varchar(100) DEFAULT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  `gongsi` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

");