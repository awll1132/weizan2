<?php
pdo_query("
DROP TABLE IF EXISTS `ims_invitcode`;
CREATE TABLE `ims_invitcode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `rid` int(10) NOT NULL COMMENT '规则id',
  `iacid` int(10) NOT NULL COMMENT '公众号标识',
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(255) NOT NULL COMMENT '用户微信标识',
  `nick` varchar(255) NOT NULL COMMENT '用户昵称',
  `headimg` varchar(255) NOT NULL COMMENT '用户头像',
  `invitcode` int(10) NOT NULL COMMENT '用户邀请码',
  `invitcount` int(10) NOT NULL DEFAULT '0' COMMENT '成功邀请次数',
  `addtime` datetime NOT NULL COMMENT '创建时间',
  `tiket` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_invitcode_reply`;
CREATE TABLE `ims_invitcode_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) DEFAULT NULL,
  `iacid` int(10) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT '活动名称',
  `status` int(11) DEFAULT NULL COMMENT '状态（0=1开启，1=关闭）',
  `starttime` int(10) DEFAULT NULL COMMENT '开始时间',
  `endtime` int(10) DEFAULT NULL COMMENT '结束时间',
  `reimg` varchar(255) DEFAULT NULL COMMENT '回复背景图片',
  `backimg` varchar(255) DEFAULT NULL COMMENT '邀请页背景图片',
  `type` int(1) DEFAULT '1' COMMENT '邀请页背景图片',
  `malllink` varchar(255) DEFAULT NULL COMMENT '商城链接',
  `poserimg` varchar(255) DEFAULT NULL COMMENT '海报背景图',
  `shareimg` varchar(255) NOT NULL COMMENT '分享图片',
  `sharetitle` varchar(255) NOT NULL COMMENT '分享标题',
  `sharedesc` varchar(255) NOT NULL COMMENT '分享描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ims_invitcode_share`;
CREATE TABLE `ims_invitcode_share` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) NOT NULL COMMENT '规则id',
  `iacid` int(10) NOT NULL COMMENT '公众号标识',
  `uniacid` int(10) NOT NULL,
  `fromuserid` varchar(100) NOT NULL COMMENT '分享人微信标识',
  `useropenid` varchar(100) NOT NULL COMMENT '用户微信标识',
  `usernick` varchar(100) DEFAULT NULL COMMENT '用户昵称',
  `userheadimg` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `addtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");