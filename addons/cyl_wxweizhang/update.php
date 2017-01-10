<?php
pdo_query("CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `kid` int(10) unsigned NOT NULL,
  `iscommend` tinyint(1) NOT NULL,
  `ishot` tinyint(1) unsigned NOT NULL,
  `pcate` int(10) unsigned NOT NULL,
  `ccate` int(10) unsigned NOT NULL,
  `template` varchar(300) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `incontent` tinyint(1) NOT NULL,
  `source` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `displayorder` int(10) unsigned NOT NULL,
  `linkurl` varchar(500) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL,
  `ly` int(20) NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL,
  `credit` varchar(255) NOT NULL,
  `sourcelink` varchar(255) NOT NULL,
  `sharelink` varchar(255) NOT NULL,
  `articlegg` varchar(255) NOT NULL,
  `articlelink` varchar(255) NOT NULL,
  `articledsfgg` text NOT NULL,
  `pic` text NOT NULL,
  `uid` varchar(25) NOT NULL DEFAULT '',
  `status` int(2) NOT NULL DEFAULT '1',
  `zongjia` varchar(255) NOT NULL DEFAULT '',
  `jiage` varchar(255) NOT NULL DEFAULT '',
  `jifen` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_iscommend` (`iscommend`),
  KEY `idx_ishot` (`ishot`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_article_gg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `time` varchar(25) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `zongjia` varchar(25) NOT NULL,
  `jiage` varchar(25) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_article_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(25) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `uid` varchar(25) NOT NULL,
  `article_id` int(11) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `member_uid` varchar(25) NOT NULL,
  `time` varchar(25) NOT NULL,
  `sharenum` int(10) NOT NULL,
  `credit_value` varchar(25) NOT NULL,
  `formuid` varchar(255) NOT NULL,
  `action` varchar(25) NOT NULL,
  `amount` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `nid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `parentid` int(10) unsigned NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL,
  `icon` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `linkurl` varchar(500) NOT NULL,
  `ishomepage` tinyint(1) NOT NULL,
  `icontype` tinyint(1) unsigned NOT NULL,
  `css` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_message` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(20) NOT NULL,
  `uniacid` int(20) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `huifu` text NOT NULL,
  `time` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_shang` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(20) NOT NULL,
  `uniacid` int(20) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `fee` varchar(20) NOT NULL,
  `time` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  `tid` varchar(25) NOT NULL DEFAULT '',
  `uid` varchar(25) NOT NULL DEFAULT '',
  `memberuid` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_styles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `templateid` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_styles_vars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `templateid` int(10) unsigned NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  `variable` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `version` varchar(64) NOT NULL,
  `description` varchar(500) NOT NULL,
  `author` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `sections` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_cyl_wxwenzhang_tixian` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `uniacid` int(25) NOT NULL,
  `title` varchar(25) NOT NULL,
  `wxh` varchar(25) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `uid` varchar(25) NOT NULL,
  `createtime` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `id` int(10) unsigned NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `uniacid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'rid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `rid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'kid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `kid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'iscommend')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `iscommend` tinyint(1) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'ishot')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `ishot` tinyint(1) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'pcate')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `pcate` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'ccate')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `ccate` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'template')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `template` varchar(300) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'title')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `title` varchar(100) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'description')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `description` varchar(100) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'content')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `content` mediumtext NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `thumb` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'incontent')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `incontent` tinyint(1) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'source')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `source` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'author')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `author` varchar(50) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `displayorder` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'linkurl')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `linkurl` varchar(500) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `createtime` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'click')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `click` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'ly')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `ly` int(20) NOT NULL  DEFAULT 0 COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'type')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `type` varchar(10) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'credit')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `credit` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'sourcelink')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `sourcelink` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'sharelink')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `sharelink` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'articlegg')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `articlegg` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'articlelink')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `articlelink` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'articledsfgg')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `articledsfgg` text NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'pic')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `pic` text NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `uid` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'status')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `status` int(2) NOT NULL  DEFAULT 1 COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'zongjia')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `zongjia` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'jiage')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `jiage` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article',  'jifen')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article')." ADD `jifen` int(2) NOT NULL  DEFAULT 1 COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `uid` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'title')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `title` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'thumb')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `thumb` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'link')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `link` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `openid` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `uniacid` int(11) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'time')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `time` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `nickname` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'zongjia')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `zongjia` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'jiage')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `jiage` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_gg')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_gg',  'status')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_gg')." ADD `status` int(2) NOT NULL  DEFAULT 2 COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `uniacid` int(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `openid` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `uid` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'article_id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `article_id` int(11) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `nickname` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'title')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `title` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'member_uid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `member_uid` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'time')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `time` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'sharenum')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `sharenum` int(10) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'credit_value')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `credit_value` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'formuid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `formuid` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'action')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `action` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_article_share')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_article_share',  'amount')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_article_share')." ADD `amount` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `id` int(10) unsigned NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `uniacid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'nid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `nid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'name')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `name` varchar(50) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'parentid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `parentid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'displayorder')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `displayorder` tinyint(3) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'enabled')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `enabled` tinyint(1) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'icon')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `icon` varchar(100) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'description')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `description` varchar(100) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'styleid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `styleid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'linkurl')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `linkurl` varchar(500) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'ishomepage')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `ishomepage` tinyint(1) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'icontype')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `icontype` tinyint(1) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_category')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_category',  'css')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_category')." ADD `css` varchar(500) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `id` int(20) unsigned NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'article_id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `article_id` int(20) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `uniacid` int(20) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `openid` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `nickname` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'avatar')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `avatar` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'content')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `content` text NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'huifu')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `huifu` text NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'time')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `time` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_message')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_message',  'status')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_message')." ADD `status` int(2) NOT NULL  DEFAULT 1 COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `id` int(20) unsigned NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'article_id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `article_id` int(20) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `uniacid` int(20) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `openid` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `nickname` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'avatar')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `avatar` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'fee')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `fee` varchar(20) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'time')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `time` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'status')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `status` int(2) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'tid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `tid` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `uid` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_shang')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_shang',  'memberuid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_shang')." ADD `memberuid` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles')." ADD `id` int(10) unsigned NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles')." ADD `uniacid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles',  'templateid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles')." ADD `templateid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles',  'name')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles')." ADD `name` varchar(50) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles_vars')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles_vars',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles_vars')." ADD `id` int(10) unsigned NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles_vars')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles_vars',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles_vars')." ADD `uniacid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles_vars')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles_vars',  'templateid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles_vars')." ADD `templateid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles_vars')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles_vars',  'styleid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles_vars')." ADD `styleid` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles_vars')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles_vars',  'variable')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles_vars')." ADD `variable` varchar(50) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles_vars')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles_vars',  'content')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles_vars')." ADD `content` text NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_styles_vars')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_styles_vars',  'description')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_styles_vars')." ADD `description` varchar(50) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_templates')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_templates',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_templates')." ADD `id` int(10) unsigned NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_templates')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_templates',  'name')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_templates')." ADD `name` varchar(30) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_templates')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_templates',  'title')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_templates')." ADD `title` varchar(30) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_templates')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_templates',  'version')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_templates')." ADD `version` varchar(64) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_templates')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_templates',  'description')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_templates')." ADD `description` varchar(500) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_templates')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_templates',  'author')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_templates')." ADD `author` varchar(50) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_templates')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_templates',  'url')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_templates')." ADD `url` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_templates')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_templates',  'type')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_templates')." ADD `type` varchar(20) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_templates')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_templates',  'sections')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_templates')." ADD `sections` int(10) unsigned NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'id')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `id` int(2) NOT NULL auto_increment  COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'uniacid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `uniacid` int(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'title')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `title` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'wxh')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `wxh` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'nickname')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `nickname` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'openid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `openid` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'amount')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `amount` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'uid')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `uid` varchar(25) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'createtime')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `createtime` varchar(255) NOT NULL   COMMENT '';");
	}	
}
if(pdo_tableexists('cyl_wxwenzhang_tixian')) {
	if(!pdo_fieldexists('cyl_wxwenzhang_tixian',  'status')) {
		pdo_query("ALTER TABLE ".tablename('cyl_wxwenzhang_tixian')." ADD `status` int(2) NOT NULL   COMMENT '';");
	}	
}
