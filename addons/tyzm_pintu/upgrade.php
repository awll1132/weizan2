<?php
/**
 * 助力平台模块微站定义
 *
 * @author 天涯织梦
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

load()->model('mc');
$module_version = pdo_fetchcolumn("SELECT version FROM " . tablename('modules') . " WHERE name = :name", array(':name' => $_GPC['m']));

if (!pdo_fieldexists('tyzm_pintu_reply', 'mutualjoin')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_reply') . " ADD `mutualjoin` tinyint( 10 ) NOT NULL AFTER  `follow`";
    pdo_query($sql);
}



if (!pdo_fieldexists('tyzm_pintu_reply', 'usepwd')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_reply') . " ADD `usepwd` varchar( 6 ) NOT NULL AFTER  `status`";
    pdo_query($sql);
}

if (!pdo_fieldexists('tyzm_pintu_reply', 'awardtotal')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_reply') . " ADD `probability` INT( 10 ) NOT NULL AFTER  `follow`";
    pdo_query($sql);
}
if (!pdo_fieldexists('tyzm_pintu_reply', 'awardtotal')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_reply') . " ADD `awardtotal` INT( 10 ) NOT NULL AFTER  `follow`";
    pdo_query($sql);
}
if (!pdo_fieldexists('tyzm_pintu_reply', 'followjoin')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_reply') . " ADD `followjoin` tinyint( 1 ) NOT NULL AFTER  `follow`";
    pdo_query($sql);
}

if (!pdo_fieldexists('tyzm_pintu_reply', 'rankingnum')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_reply') . " ADD `rankingnum` int(10) NOT NULL AFTER  `probability`";
    pdo_query($sql);
}
if (!pdo_fieldexists('tyzm_pintu_reply', 'isreg')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_reply') . " ADD `isreg` tinyint( 1 ) NOT NULL AFTER  `probability`";
    pdo_query($sql);
}

if (!pdo_fieldexists('tyzm_pintu_reply', 'ptdata')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_reply') . " ADD `ptdata` mediumtext AFTER  `usepwd`";
    pdo_query($sql);
}

if (!pdo_fieldexists('tyzm_pintu_reply', 'admodel')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_reply') . " ADD `admodel` mediumtext AFTER  `usepwd`";
    pdo_query($sql);
}
//---------------
if (!pdo_fieldexists('tyzm_pintu_userdata', 'isexchange')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_userdata') . " ADD `isexchange` INT( 1 ) NOT NULL AFTER  `status`";
    pdo_query($sql);
}
if (!pdo_fieldexists('tyzm_pintu_userdata', 'finishnum')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_userdata') . " ADD `finishnum` INT( 1 ) NOT NULL AFTER  `status`";
    pdo_query($sql);
}
if (!pdo_fieldexists('tyzm_pintu_userdata', 'formatdata')) {
    $sql = 'ALTER TABLE ' . tablename('tyzm_pintu_userdata') . " ADD `formatdata` text( 1 ) NOT NULL AFTER  `status`";
    pdo_query($sql);
}



if ($module_version < 2.0) {
    	$list = pdo_fetchall("SELECT * FROM " . tablename('tyzm_pintu_userdata') . " WHERE  tid=:tid AND finishnum='' ", array(':tid' => 0));
		foreach ($list as &$item) {
			$helplist = pdo_fetchall("SELECT pttype FROM " . tablename('tyzm_pintu_userdata') . " WHERE tid = :tid ORDER BY `id` DESC", array(':tid' => $item['id']));
			if(empty($helplist)){
				$formatdata = array('0' => $item['pttype']);
			}else{
				$zlarray=array();
				foreach ($helplist as $key => $value){ 
			         $zlarray[]=$value['pttype'];
				}
			    $formatdata = array_unique(array_merge(array('0' => $item['pttype']),$zlarray));
			}

			if(empty($item['formatdata'])){//更改拼图状态
			    $joinupdata=array(
				  'formatdata'=>iserializer($formatdata),
				  'finishnum'=>count($formatdata),
				);
					pdo_update("tyzm_pintu_userdata",$joinupdata, array('id' =>$item['id'],'tid'=>0));
			}
		}
}

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `ims_tyzm_pintu_fansdata`(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(50) NOT NULL COMMENT '用户openid',
  `createtime` int(10) DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `indx_openid` (`openid`),
  KEY `indx_uniacid` (`uniacid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
EOF;
pdo_run($sql);
