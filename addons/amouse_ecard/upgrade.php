<?php
$sql = "
CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(100) DEFAULT '' COMMENT '用户ID',
  `mobile` varchar(20) DEFAULT '' COMMENT '手机',
  `name` varchar(20) DEFAULT ' ',
  `email` varchar(200) DEFAULT '',
  `createtime` int(10) DEFAULT '0',
  `qq` varchar(255) DEFAULT '',
  `job` varchar(255) DEFAULT '',
  `department` varchar(255) DEFAULT '',
  `company` varchar(255) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `area` varchar(255) DEFAULT '',
  `myattention` varchar(255) DEFAULT NULL,
  `myfocus` varchar(255) DEFAULT NULL,
  `weixin` varchar(255) DEFAULT '',
  `pbweixin` varchar(255) DEFAULT '',
  `siteurl` varchar(255) DEFAULT '',
  `joincount` int(11) DEFAULT '0',
  `template` varchar(300) NOT NULL DEFAULT '',
  `templatefile` varchar(300) NOT NULL DEFAULT '' COMMENT '是否开启',
  `headimg` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_zan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `mid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `from_user` varchar(255) NOT NULL,
  `zan_mid` int(10) NOT NULL,
  `zan_cid` int(10) NOT NULL,
  `zan_from_user` varchar(255) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_amouse_weijob_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `from_user` varchar(50) DEFAULT '' COMMENT '在微信端添加公司',
  `title` varchar(50) NOT NULL COMMENT '公司名称',
  `short` varchar(10) NOT NULL COMMENT '公司简称',
  `thumb` varchar(255) NOT NULL COMMENT '公司缩略图',
  `linkman` varchar(20) NOT NULL DEFAULT '' COMMENT '联系人',
  `tel` varchar(255) NOT NULL COMMENT '固定电话',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `qq` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL COMMENT '简历投递邮箱',
  `content` text NOT NULL COMMENT '公司简介',
  `companyorder` int(11) unsigned DEFAULT '0' COMMENT '排序',
  `province` varchar(50) NOT NULL COMMENT '省',
  `city` varchar(50) NOT NULL COMMENT '市',
  `dist` varchar(50) NOT NULL COMMENT '区',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `lng` varchar(255) NOT NULL COMMENT '经度',
  `lat` varchar(255) NOT NULL COMMENT '纬度',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_amouse_weijob_employ` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned NOT NULL,
  `companyid` int(11) unsigned NOT NULL COMMENT '公司id',
  `jobname` varchar(50) NOT NULL COMMENT '岗位名称',
  `hits` int(11) NOT NULL DEFAULT '0',
  `type` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '工作类型：1为全职 2为兼职 3为实习',
  `description` text NOT NULL COMMENT '岗位描述',
  `employorder` int(11) unsigned DEFAULT '0' COMMENT '排序',
  `number` int(11) unsigned NOT NULL COMMENT '人数',
  `edu` varchar(11) DEFAULT '不限' COMMENT '学历要求：不限，初中，高中，中专，大专，本科，硕士，博士',
  `offer` int(11) NOT NULL DEFAULT '0' COMMENT '薪水 0为面议',
  `workplace` varchar(100) NOT NULL COMMENT '工作地点',
  `workyear` varchar(50) NOT NULL COMMENT '工作年限',
  `endtime` int(11) NOT NULL DEFAULT '0',
  `createtime` int(11) NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_amouse_weijob_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL,
  `companyid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_amouse_weijob_resume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `from_user` varchar(100) NOT NULL,
  `name` varchar(20) DEFAULT NULL COMMENT '简历姓名',
  `sex` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '性别，0为男1为女',
  `age` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `major` varchar(20) NOT NULL DEFAULT '' COMMENT '专业',
  `college` varchar(10) DEFAULT NULL COMMENT '毕业院校',
  `home` varchar(255) DEFAULT NULL COMMENT '生源地',
  `skill` varchar(255) DEFAULT NULL COMMENT '专业技能',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `status` varchar(10) DEFAULT NULL COMMENT '政治面貌',
  `self` varchar(255) NOT NULL DEFAULT '' COMMENT '自我评价',
  `experience` varchar(255) NOT NULL DEFAULT '' COMMENT '工作经历',
  `education` varchar(255) NOT NULL DEFAULT '' COMMENT '教育经历',
  `job_direction` varchar(255) NOT NULL DEFAULT '' COMMENT '求职方向',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_amouse_weijob_resume_recod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned NOT NULL DEFAULT '0',
  `jobid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '投简工作id',
  `cvid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '简历id',
  `from_user` varchar(100) NOT NULL DEFAULT '0',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '投简时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='投简管理';
";
pdo_run($sql);
 if(!pdo_fieldexists('amouse_weicard_sysset', 'isoauth')) {
	pdo_query("ALTER TABLE ".tablename('amouse_weicard_sysset')." ADD `isoauth` int(2) unsigned NOT NULL DEFAULT '1';");
}

 if(!pdo_fieldexists('amouse_weicard_card', 'templateFile')) {
	pdo_query("ALTER TABLE ".tablename('amouse_weicard_card')." ADD   `templateFile` varchar(300) DEFAULT 'qianx_index';");
}
 if(!pdo_fieldexists('amouse_weicard_industry', 'weid')) {
	pdo_query("ALTER TABLE ".tablename('amouse_weicard_industry')." ADD  `weid` int(10) NOT NULL;");
}

