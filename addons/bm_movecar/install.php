<?php
pdo_query("CREATE TABLE IF NOT EXISTS `ims_bm_movecar_adv` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`advname` varchar(20) NOT NULL DEFAULT '',
`link` varchar(200) NOT NULL DEFAULT '',
`enabled` int(1) NOT NULL DEFAULT '0',
`displayorder` int(10) NOT NULL DEFAULT '0',
`thumb` varchar(200) NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_bm_movecar_adver` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`weid` int(11) NOT NULL,
`advname` varchar(20) NOT NULL DEFAULT '',
`link` varchar(200) NOT NULL DEFAULT '',
`enabled` int(1) NOT NULL DEFAULT '0',
`displayorder` int(10) NOT NULL DEFAULT '0',
`thumb` varchar(200) NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_bm_movecar_carlist` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rid` int(11) NOT NULL DEFAULT '0',
`weid` int(11) NOT NULL,
`from_user` varchar(32) NOT NULL DEFAULT '',
`username` text NOT NULL,
`avatar` varchar(500) NOT NULL DEFAULT '',
`time_reg` int(11) NOT NULL DEFAULT '0',
`province` varchar(10) NOT NULL DEFAULT '',
`number` varchar(40) NOT NULL DEFAULT '',
`title` varchar(20) NOT NULL DEFAULT '',
`mobile` varchar(20) NOT NULL DEFAULT '',
`status` int(1) NOT NULL DEFAULT '0',
`userid` varchar(10) NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_bm_movecar_member` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rid` int(11) NOT NULL DEFAULT '0',
`weid` int(11) NOT NULL,
`from_user` varchar(32) NOT NULL DEFAULT '',
`username` text NOT NULL,
`avatar` varchar(500) NOT NULL DEFAULT '',
`time_reg` int(11) NOT NULL DEFAULT '0',
`title` varchar(20) NOT NULL DEFAULT '',
`mobile` varchar(20) NOT NULL DEFAULT '',
`verifycode` varchar(10) NOT NULL DEFAULT '',
`time_verify` int(11) NOT NULL DEFAULT '0',
`status_verify` int(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_bm_movecar_moved` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rid` int(11) NOT NULL DEFAULT '0',
`weid` int(11) NOT NULL,
`carid` int(11) NOT NULL DEFAULT '0',
`from_user` varchar(32) NOT NULL DEFAULT '',
`username` text NOT NULL,
`avatar` varchar(500) NOT NULL DEFAULT '',
`mobile` varchar(20) NOT NULL DEFAULT '',
`status` int(1) NOT NULL DEFAULT '0',
`time_call` int(11) NOT NULL DEFAULT '0',
`time_sms` int(11) NOT NULL DEFAULT '0',
`status_sms` int(11) NOT NULL DEFAULT '0',
`thumb` varchar(200) NOT NULL DEFAULT '',
`address` varchar(200) NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_bm_movecar_reply` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rid` int(10) NOT NULL DEFAULT '0',
`weid` int(11) NOT NULL,
`title` varchar(100) NOT NULL DEFAULT '',
`desc` varchar(500) NOT NULL DEFAULT '',
`tel` varchar(50) NOT NULL DEFAULT '',
`picurl` varchar(200) NOT NULL DEFAULT '',
`qrcode` varchar(100) NOT NULL DEFAULT '',
`logo` varchar(200) NOT NULL DEFAULT '',
`pictype` int(1) NOT NULL DEFAULT '0',
`urlx` varchar(200) NOT NULL DEFAULT '',
`memo` varchar(100) NOT NULL DEFAULT '',
`urly` varchar(200) NOT NULL DEFAULT '',
`starttime` datetime NOT NULL,
`memo1` varchar(100) NOT NULL DEFAULT '',
`url1` varchar(200) NOT NULL DEFAULT '',
`endtime` datetime NOT NULL,
`memo2` varchar(100) NOT NULL DEFAULT '',
`url2` varchar(200) NOT NULL DEFAULT '',
`memo3` varchar(100) NOT NULL DEFAULT '',
`url3` varchar(200) NOT NULL DEFAULT '',
`templateid` varchar(100) NOT NULL DEFAULT '',
`openid` varchar(100) NOT NULL DEFAULT '',
`templateid1` varchar(100) NOT NULL DEFAULT '',
`templateid2` varchar(100) NOT NULL DEFAULT '',
`banner` varchar(200) NOT NULL DEFAULT '',
`is_sms` int(1) NOT NULL DEFAULT '0',
`corpid` varchar(50) NOT NULL DEFAULT '',
`pwd` varchar(50) NOT NULL DEFAULT '',
`pictype1` int(1) NOT NULL DEFAULT '0',
`province` varchar(10) NOT NULL DEFAULT '苏',
`advurl1` varchar(200) NOT NULL DEFAULT '',
`advtitle1` varchar(20) NOT NULL DEFAULT '',
`appkey` varchar(50) NOT NULL DEFAULT '',
`secretKey` varchar(100) NOT NULL DEFAULT '',
`smssignname` varchar(50) NOT NULL DEFAULT '',
`smstemplate` varchar(20) NOT NULL DEFAULT '',
`smstype` int(1) NOT NULL DEFAULT '0',
`is_sms_car` int(1) NOT NULL DEFAULT '0',
`is_sms_move` int(1) NOT NULL DEFAULT '0',
`sms_car` varchar(20) NOT NULL DEFAULT '',
`sms_move` varchar(20) NOT NULL DEFAULT '',
`sms_car_sign` varchar(50) NOT NULL DEFAULT '',
`is_voice_move` int(1) NOT NULL DEFAULT '0',
`voice_move` varchar(20) NOT NULL DEFAULT '',
`voicenumber` varchar(20) NOT NULL DEFAULT '',
`headtitle` varchar(50) NOT NULL DEFAULT '',
`car_enable` int(10) NOT NULL DEFAULT '999',
`name` varchar(50) NOT NULL DEFAULT '',
`is_thumb` int(1) NOT NULL DEFAULT '0',
`is_name` int(1) NOT NULL DEFAULT '0',
`storename` varchar(50) NOT NULL DEFAULT '',
`is_lbs` int(1) NOT NULL DEFAULT '0',
`ak` varchar(50) NOT NULL DEFAULT '',
`verify_type` int(1) NOT NULL DEFAULT '0',
`int_times` int(10) NOT NULL DEFAULT '0',
`int_minutes` int(10) NOT NULL DEFAULT '0',
`is_qiniu` int(1) NOT NULL DEFAULT '0',
`qiniu_ak` varchar(50) NOT NULL DEFAULT '',
`qiniu_sk` varchar(50) NOT NULL DEFAULT '',
`qiniu_bt` varchar(50) NOT NULL DEFAULT '',
`qiniu_dm` varchar(50) NOT NULL DEFAULT '',
`is_call` int(1) NOT NULL DEFAULT '0',
`subAccountSid` varchar(50) NOT NULL DEFAULT '',
`subAccountToken` varchar(50) NOT NULL DEFAULT '',
`voIPAccount` varchar(50) NOT NULL DEFAULT '',
`voIPPassword` varchar(50) NOT NULL DEFAULT '',
`appId` varchar(50) NOT NULL DEFAULT '',
`serverIP` varchar(50) NOT NULL DEFAULT '',
`serverPort` varchar(50) NOT NULL DEFAULT '',
`is_check` int(1) NOT NULL DEFAULT '0',
`is_carno` int(1) NOT NULL DEFAULT '1',
`is_mobile` int(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");