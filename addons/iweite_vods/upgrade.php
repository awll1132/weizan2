<?php
$sql="CREATE TABLE IF NOT EXISTS `ims_iweite_vods_category` (
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
CREATE TABLE IF NOT EXISTS `ims_iweite_vods_guanggao` (
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
CREATE TABLE IF NOT EXISTS `ims_iweite_vods_jiekou` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(4) DEFAULT '0',
  `title` varchar(300) DEFAULT NULL,
  `fdes` mediumtext,
  `dateline` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_iweite_vods_mb` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(4) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `fpic` varchar(300) DEFAULT NULL,
  `sid` int(4) DEFAULT '0',
  `dateline` varchar(80) DEFAULT NULL,
  `fdir` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_iweite_vods_setting` (
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
CREATE TABLE IF NOT EXISTS `ims_iweite_vods_ziyuan` (
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
CREATE TABLE IF NOT EXISTS `ims_iweite_vods_ziyuan_list` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `classid` int(4) DEFAULT NULL,
  `content` mediumtext,
  `dateline` varchar(80) DEFAULT NULL,
  `weid` int(4) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists('iweite_vods_category',  'tid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `tid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('iweite_vods_category',  'title')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `title` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_category',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `sid` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_category',  'dateline')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `dateline` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_category',  'fdes')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `fdes` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_category',  'fpic')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `fpic` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_category',  'weid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `weid` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_category',  'isup')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `isup` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_category',  'isindex')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `isindex` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_category',  'stitle')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_category')." ADD `stitle` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'tid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `tid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'classid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `classid` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'title')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `title` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'fpic')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `fpic` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'flink')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `flink` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `sid` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'dateline')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `dateline` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'weid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `weid` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'apage')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `apage` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'astyle')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `astyle` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'awidth')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `awidth` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_guanggao',  'aheight')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_guanggao')." ADD `aheight` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_jiekou',  'tid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_jiekou')." ADD `tid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('iweite_vods_jiekou',  'weid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_jiekou')." ADD `weid` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_jiekou',  'title')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_jiekou')." ADD `title` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_jiekou',  'fdes')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_jiekou')." ADD `fdes` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_jiekou',  'dateline')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_jiekou')." ADD `dateline` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_mb',  'tid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_mb')." ADD `tid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('iweite_vods_mb',  'weid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_mb')." ADD `weid` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_mb',  'title')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_mb')." ADD `title` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_mb',  'fpic')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_mb')." ADD `fpic` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_mb',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_mb')." ADD `sid` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_mb',  'dateline')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_mb')." ADD `dateline` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_mb',  'fdir')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_mb')." ADD `fdir` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'tid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `tid` int(10) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'weid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `weid` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_setting',  'title')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `title` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'indexpagesize')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `indexpagesize` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_setting',  'pagesize')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `pagesize` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_setting',  'copyright')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `copyright` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'cnzz')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `cnzz` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'share')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `share` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'guanzhu')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `guanzhu` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'mb')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `mb` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'logo')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `logo` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'ck')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `ck` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'shikan')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `shikan` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'passtip')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `passtip` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_setting',  'cpass')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_setting')." ADD `cpass` varchar(100) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'tid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `tid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'classid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `classid` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'title')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `title` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'fpic')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `fpic` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'fdes')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `fdes` varchar(300) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'isok')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `isok` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'recommend')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `recommend` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'sid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `sid` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'dateline')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `dateline` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'views')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `views` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'guanlian')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `guanlian` varchar(350) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'content')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `content` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'weid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `weid` int(4) DEFAULT '0';");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'flag')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `flag` varchar(350) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'cid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `cid` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'fupdate')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `fupdate` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'fkeys')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `fkeys` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'shikan')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `shikan` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan',  'ispass')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan')." ADD `ispass` tinyint(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan_list',  'tid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan_list')." ADD `tid` int(11) NOT NULL AUTO_INCREMENT;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan_list',  'classid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan_list')." ADD `classid` int(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan_list',  'content')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan_list')." ADD `content` mediumtext;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan_list',  'dateline')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan_list')." ADD `dateline` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('iweite_vods_ziyuan_list',  'weid')) {
	pdo_query("ALTER TABLE ".tablename('iweite_vods_ziyuan_list')." ADD `weid` int(4) DEFAULT NULL;");
}

?>