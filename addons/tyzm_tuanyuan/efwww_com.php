<?php
pdo_query("

DROP TABLE IF EXISTS `ims_tyzm_tuanyuan_count`;
CREATE TABLE `ims_tyzm_tuanyuan_count` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `pv_total` int(1) NOT NULL,
  `share_total` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_tyzm_tuanyuan_joinuser`;
CREATE TABLE `ims_tyzm_tuanyuan_joinuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `oauth_openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `user_ip` varchar(15) NOT NULL COMMENT '客户端ip',
  `msg` varchar(255) DEFAULT NULL COMMENT '留言',
  `reward` varchar(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`),
  KEY `indx_oauth_openid` (`oauth_openid`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_tyzm_tuanyuan_redpack`;
CREATE TABLE `ims_tyzm_tuanyuan_redpack` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `unionid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户unionid',
  `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `user_ip` varchar(15) NOT NULL COMMENT '客户端ip',
  `mch_billno` varchar(28) DEFAULT '',
  `total_amount` int(10) DEFAULT '0',
  `total_num` int(3) NOT NULL,
  `client_ip` varchar(15) NOT NULL,
  `send_time` varchar(14) DEFAULT '0',
  `send_listid` varchar(32) DEFAULT '0',
  `return_data` text,
  `return_code` varchar(16) NOT NULL,
  `return_msg` varchar(256) NOT NULL,
  `result_code` varchar(16) NOT NULL,
  `err_code` varchar(32) NOT NULL,
  `err_code_des` varchar(128) NOT NULL,
  `rewards` varchar(20) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_tyzm_tuanyuan_reply`;
CREATE TABLE `ims_tyzm_tuanyuan_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `title` varchar(100) DEFAULT '',
  `thumb` varchar(255) DEFAULT '' COMMENT '封面',
  `description` varchar(255) DEFAULT '',
  `starttime` int(10) DEFAULT '0',
  `endtime` int(10) DEFAULT '0',
  `deskimg` varchar(255) DEFAULT '' COMMENT '圆桌图片',
  `bgimg` varchar(255) DEFAULT '' COMMENT '背景图片',
  `bgcolor` varchar(255) DEFAULT '' COMMENT '背景颜色',
  `details` mediumtext COMMENT '详情',
  `awardmsg` mediumtext COMMENT '奖品',
  `configdata` mediumtext COMMENT '设置数据',
  `slidedata` mediumtext COMMENT '幻灯片',
  `styledata` mediumtext COMMENT '样式数据',
  `bill_data` mediumtext COMMENT '海报数据',
  `status` tinyint(1) DEFAULT '0',
  `shareimg` varchar(255) DEFAULT '' COMMENT '分享图标',
  `sharetitle` varchar(100) DEFAULT '' COMMENT '分享标题',
  `sharedesc` varchar(300) DEFAULT '' COMMENT '分享简介',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_tyzm_tuanyuan_userdata`;
CREATE TABLE `ims_tyzm_tuanyuan_userdata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `oauth_openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `openid` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户openid',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `user_ip` varchar(15) NOT NULL COMMENT '客户端ip',
  `prize` varchar(1) DEFAULT NULL,
  `inputdata` mediumtext COMMENT '输入信息',
  `finishnum` int(1) NOT NULL DEFAULT '0' COMMENT '完成数量',
  `cash` int(1) DEFAULT NULL COMMENT '兑奖',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态',
  `locktime` int(10) DEFAULT '0' COMMENT '锁定时间',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`),
  KEY `indx_oauth_openid` (`oauth_openid`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");