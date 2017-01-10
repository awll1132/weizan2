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
if(pdo_tableexists('ims_bm_movecar_adv')) {
	if(!pdo_fieldexists('ims_bm_movecar_adv',  'id')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adv')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adv')) {
	if(!pdo_fieldexists('ims_bm_movecar_adv',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adv')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adv')) {
	if(!pdo_fieldexists('ims_bm_movecar_adv',  'advname')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adv')." ADD `advname` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adv')) {
	if(!pdo_fieldexists('ims_bm_movecar_adv',  'link')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adv')." ADD `link` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adv')) {
	if(!pdo_fieldexists('ims_bm_movecar_adv',  'enabled')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adv')." ADD `enabled` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adv')) {
	if(!pdo_fieldexists('ims_bm_movecar_adv',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adv')." ADD `displayorder` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adv')) {
	if(!pdo_fieldexists('ims_bm_movecar_adv',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adv')." ADD `thumb` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adver')) {
	if(!pdo_fieldexists('ims_bm_movecar_adver',  'id')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adver')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adver')) {
	if(!pdo_fieldexists('ims_bm_movecar_adver',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adver')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adver')) {
	if(!pdo_fieldexists('ims_bm_movecar_adver',  'advname')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adver')." ADD `advname` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adver')) {
	if(!pdo_fieldexists('ims_bm_movecar_adver',  'link')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adver')." ADD `link` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adver')) {
	if(!pdo_fieldexists('ims_bm_movecar_adver',  'enabled')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adver')." ADD `enabled` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adver')) {
	if(!pdo_fieldexists('ims_bm_movecar_adver',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adver')." ADD `displayorder` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_adver')) {
	if(!pdo_fieldexists('ims_bm_movecar_adver',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_adver')." ADD `thumb` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'id')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'rid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `rid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'from_user')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `from_user` varchar(32) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'username')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `username` text NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'avatar')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `avatar` varchar(500) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'time_reg')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `time_reg` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'province')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `province` varchar(10) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'number')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `number` varchar(40) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'title')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `title` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'mobile')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `mobile` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'status')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `status` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_carlist')) {
	if(!pdo_fieldexists('ims_bm_movecar_carlist',  'userid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_carlist')." ADD `userid` varchar(10) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'id')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'rid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `rid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'from_user')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `from_user` varchar(32) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'username')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `username` text NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'avatar')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `avatar` varchar(500) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'time_reg')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `time_reg` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'title')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `title` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'mobile')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `mobile` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'verifycode')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `verifycode` varchar(10) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'time_verify')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `time_verify` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_member')) {
	if(!pdo_fieldexists('ims_bm_movecar_member',  'status_verify')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_member')." ADD `status_verify` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'id')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'rid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `rid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'carid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `carid` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'from_user')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `from_user` varchar(32) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'username')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `username` text NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'avatar')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `avatar` varchar(500) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'mobile')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `mobile` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'status')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `status` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'time_call')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `time_call` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'time_sms')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `time_sms` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'status_sms')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `status_sms` int(11) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `thumb` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_moved')) {
	if(!pdo_fieldexists('ims_bm_movecar_moved',  'address')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_moved')." ADD `address` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'id')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `id` int(11) NOT NULL AUTO_INCREMENT;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'rid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `rid` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'weid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `weid` int(11) NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'title')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `title` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'desc')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `desc` varchar(500) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'tel')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `tel` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'picurl')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `picurl` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'qrcode')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `qrcode` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'logo')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `logo` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'pictype')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `pictype` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'urlx')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `urlx` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'memo')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `memo` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'urly')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `urly` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'starttime')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `starttime` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'memo1')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `memo1` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'url1')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `url1` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'endtime')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `endtime` datetime NOT NULL;");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'memo2')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `memo2` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'url2')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `url2` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'memo3')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `memo3` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'url3')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `url3` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'templateid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `templateid` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `openid` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'templateid1')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `templateid1` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'templateid2')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `templateid2` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'banner')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `banner` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_sms')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_sms` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'corpid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `corpid` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'pwd')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `pwd` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'pictype1')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `pictype1` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'province')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `province` varchar(10) NOT NULL DEFAULT '苏';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'advurl1')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `advurl1` varchar(200) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'advtitle1')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `advtitle1` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'appkey')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `appkey` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'secretKey')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `secretKey` varchar(100) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'smssignname')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `smssignname` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'smstemplate')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `smstemplate` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'smstype')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `smstype` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_sms_car')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_sms_car` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_sms_move')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_sms_move` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'sms_car')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `sms_car` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'sms_move')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `sms_move` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'sms_car_sign')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `sms_car_sign` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_voice_move')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_voice_move` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'voice_move')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `voice_move` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'voicenumber')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `voicenumber` varchar(20) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'headtitle')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `headtitle` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'car_enable')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `car_enable` int(10) NOT NULL DEFAULT '999';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'name')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `name` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_thumb')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_thumb` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_name')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_name` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'storename')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `storename` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_lbs')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_lbs` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'ak')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `ak` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'verify_type')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `verify_type` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'int_times')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `int_times` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'int_minutes')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `int_minutes` int(10) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_qiniu')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_qiniu` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'qiniu_ak')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `qiniu_ak` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'qiniu_sk')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `qiniu_sk` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'qiniu_bt')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `qiniu_bt` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'qiniu_dm')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `qiniu_dm` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_call')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_call` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'subAccountSid')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `subAccountSid` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'subAccountToken')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `subAccountToken` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'voIPAccount')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `voIPAccount` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'voIPPassword')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `voIPPassword` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'appId')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `appId` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'serverIP')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `serverIP` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'serverPort')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `serverPort` varchar(50) NOT NULL DEFAULT '';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_check')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_check` int(1) NOT NULL DEFAULT '0';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_carno')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_carno` int(1) NOT NULL DEFAULT '1';");
	}	
}
if(pdo_tableexists('ims_bm_movecar_reply')) {
	if(!pdo_fieldexists('ims_bm_movecar_reply',  'is_mobile')) {
		pdo_query("ALTER TABLE ".tablename('ims_bm_movecar_reply')." ADD `is_mobile` int(1) NOT NULL DEFAULT '1';");
	}	
}
