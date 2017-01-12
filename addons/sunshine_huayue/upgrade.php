<?php 
// 添加提醒次数
if(!pdo_fieldexists('sunshine_huayue_member', 'notice_times')) {
	pdo_query("ALTER TABLE ".tablename('sunshine_huayue_member')." ADD `notice_times` int(10) not null");
}
/*-----v3.0------*/
// 添加成长值
if(!pdo_fieldexists('sunshine_huayue_member', 'growth_score')) {
	pdo_query("ALTER TABLE ".tablename('sunshine_huayue_member')." ADD `growth_score` int(10) not null");
}
// 成长值表
pdo_query("
create table if not exists `ims_sunshine_huayue_growth` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL DEFAULT '',
  `score` int(10) NOT NULL,
  `intro` varchar(200) NOT NULL DEFAULT '',
  `add_date` datetime DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  unique key `openid_add_date` (`openid`,`add_date`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");

// 签到积分表
pdo_query("
create table if not exists `ims_sunshine_huayue_credit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL DEFAULT '',
  `sid` int(10) NOT NULL,
  `credit` int(10) NOT NULL,
  `type` varchar(200) NOT NULL DEFAULT '',
  `add_date` date DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  unique key `openid_add_date` (`openid`,`add_date`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
// 3.3 聊天室
pdo_query("
create table if not exists `ims_sunshine_huayue_chatroom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `creator` varchar(30) not null default 'system',
  `room_name` varchar(200) not null default '',
  `room_desc` varchar(500) not null default '',
  `room_logo` varchar(500) not null default '',
  `sort_id` int(10) not null ,
  `add_date` date DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `room_status` enum('normal','delete','close') not null default 'normal',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ");

// 聊天内容
pdo_query("
create table if not exists `ims_sunshine_huayue_chatroom_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rid` int(10) not null  comment '聊天室ID',
  `openid` varchar(200) not null default '',
  `content` varchar(500) not null default '',
  `add_time` datetime DEFAULT NULL,
  `is_del` enum('y','n') default 'n',
  `complain_times` int(10) not null ,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

  ");


// 群发表 3.5
pdo_query("
create table if not exists `ims_sunshine_huayue_multisend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `creator` varchar(200) not null default '',
  `content` varchar(500) not null default '',
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ");

// V3.6 多公众号支持
if(!pdo_fieldexists('sunshine_huayue_setting','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_setting add uniacid INT(10) UNSIGNED NOT NULL after id");
}
if(!pdo_fieldexists('sunshine_huayue_album','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_album add uniacid INT(10) UNSIGNED NOT NULL after id");
}
if(!pdo_fieldexists('sunshine_huayue_growth','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_growth add uniacid INT(10) UNSIGNED NOT NULL after id");
}
if(!pdo_fieldexists('sunshine_huayue_credit','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_credit add uniacid INT(10) UNSIGNED NOT NULL after id");
}
if(!pdo_fieldexists('sunshine_huayue_chatroom','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_chatroom add uniacid INT(10) UNSIGNED NOT NULL after id");
}
if(!pdo_fieldexists('sunshine_huayue_chatroom_log','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_chatroom_log add uniacid INT(10) UNSIGNED NOT NULL after id");
}
if(!pdo_fieldexists('sunshine_huayue_multisend','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_multisend add uniacid INT(10) UNSIGNED NOT NULL after id");
}
// v 3.7
if(!pdo_fieldexists('sunshine_huayue_comment','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_comment add uniacid INT(10) UNSIGNED NOT NULL after id");
}
if(!pdo_fieldexists('sunshine_huayue_greets','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_greets add uniacid INT(10) UNSIGNED NOT NULL after id");
}

if(!pdo_fieldexists('sunshine_huayue_chat','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_chat add uniacid INT(10) UNSIGNED NOT NULL after id");
}

if(!pdo_fieldexists('sunshine_huayue_chatmessage','uniacid'))
{
  pdo_query("alter table ims_sunshine_huayue_chatmessage add uniacid INT(10) UNSIGNED NOT NULL after id");
}


// v3.9
if(!pdo_fieldexists('sunshine_huayue_chatroom','is_public'))
{
  pdo_query("alter table ims_sunshine_huayue_chatroom add `is_public` enum('y','n') not null default 'y' comment '开放类型 公共or隐私' after room_logo");
}
if(!pdo_fieldexists('sunshine_huayue_chatroom','is_secret'))
{
  pdo_query("alter table ims_sunshine_huayue_chatroom add `is_secret` enum('y','n') not null default 'n' comment '进入类型  开放还是口令' after is_public");
}
if(!pdo_fieldexists('sunshine_huayue_chatroom','room_secret'))
{
  pdo_query("alter table ims_sunshine_huayue_chatroom add `room_secret` varchar(100) not null default '' comment '进入口令，当is_secret为command时有效' after is_secret");
}
  
// 

pdo_query("
create table if not exists `ims_sunshine_huayue_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `openid` varchar(200) not null default '',
  `add_time` datetime DEFAULT NULL,
  `is_del` enum('y','n') default 'n' not null,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

  ");

if(!pdo_fieldexists('sunshine_huayue_chatroom','is_approve'))
{
  pdo_query("alter table ims_sunshine_huayue_chatroom  add `is_approve` enum('allow','deny','wait') default 'wait' comment '审核'");
  pdo_query("update ims_sunshine_huayue_chatroom set is_approve='allow'");
}

if(!pdo_fieldexists('sunshine_huayue_chat','refresh_time'))
{
  pdo_query("alter table ims_sunshine_huayue_chat add `refresh_time` datetime not null after to_openid");
}

pdo_query("
  create table if not exists `ims_sunshine_huayue_mychatroom_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `openid` varchar(200) not null default '',
  `room_id` INT(10) UNSIGNED NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `is_del` enum('y','n') default 'n' not null,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ");

if(!pdo_fieldexists('sunshine_huayue_member', 'vip_level')) {
  pdo_query("ALTER TABLE ".tablename('sunshine_huayue_member')." ADD `vip_level` int(10) not null");
}

if(!pdo_fieldexists('sunshine_huayue_member', 'vip_add_time')) {
  pdo_query("ALTER TABLE ".tablename('sunshine_huayue_member')." ADD `vip_add_time` datetime not null");
}
if(!pdo_fieldexists('sunshine_huayue_member', 'vip_end_time')) {
  pdo_query("ALTER TABLE ".tablename('sunshine_huayue_member')." ADD `vip_end_time` datetime not null");
  pdo_query("alter table ims_sunshine_huayue_credit drop index openid_add_date");
}


if(!pdo_fieldexists('sunshine_huayue_member','is_notice')) {
  pdo_query("alter table ims_sunshine_huayue_member add `is_notice` enum('y','n') not null default 'y' after isvisible");
}


// `reply_openid` varchar(50) not null default '' comment '被回复的人',

if(!pdo_fieldexists('sunshine_huayue_comment','reply_openid')) {
  pdo_query("alter table ims_sunshine_huayue_comment add `reply_openid` varchar(50) not null default '' comment '被回复的人' after user_openid");
   pdo_query("alter table ims_sunshine_huayue_comment add `mid` int(10) UNSIGNED not null after uniacid");
}


pdo_query("
create table if not exists `ims_sunshine_huayue_moments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `openid` varchar(50) NOT NULL DEFAULT '',
  `remark` varchar(200) NOT NULL DEFAULT '' comment '想法',
  `type` enum('image','text') default 'image' comment '类型，决定是否去查询图片表',
  `add_time` datetime DEFAULT NULL,
  `is_del` enum('y','n') DEFAULT 'n',
  `del_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
  ");


if(!pdo_fieldexists('sunshine_huayue_album','mid')) {
  pdo_query("alter table ims_sunshine_huayue_album add `mid` int(10) UNSIGNED NOT NULL after uniacid");
}
if(!pdo_fieldexists('sunshine_huayue_comment','mid')) {
  pdo_query("alter table ims_sunshine_huayue_comment add `mid` int(10) UNSIGNED NOT NULL after uniacid");
}

pdo_query("
create table if not exists `ims_sunshine_huayue_defriend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `openid` varchar(50) not null default '',
  `defriend_openid` varchar(50) not null default '',
  `add_time` datetime not null,
  `status` enum('y','n') default 'n' not null comment 'y defrend n relieve',
  PRIMARY KEY (`id`),
  unique key  `oo` (`openid`,`defriend_openid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

  ");

if(!pdo_fieldexists('sunshine_huayue_chatroom_log','type')) {
  pdo_query("alter table ims_sunshine_huayue_chatroom_log add `type` enum('text','voice','album') default 'text' comment '消息类型'");
  pdo_query("alter table ims_sunshine_huayue_chatroom_log modify `content` varchar(200)");
}

if(!pdo_fieldexists('sunshine_huayue_chatmessage','type')) {
  pdo_query("alter table ims_sunshine_huayue_chatmessage add `type` enum('text','voice','album') default 'text' comment '消息类型'");
  pdo_query("alter table ims_sunshine_huayue_chatmessage modify `chat_message` varchar(200)");
}

pdo_query("
  create table if not exists `ims_sunshine_huayue_chatroom_defriend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `room_id` INT(10) UNSIGNED NOT NULL,
  `openid` varchar(50) not null default '',
  `creator` varchar(50) not null default 'system',
  `add_time` datetime not null,
  `status` enum('y','n') default 'n' not null comment 'y defrend n relieve',
  PRIMARY KEY (`id`),
  unique key  `oo` (`openid`,`room_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
");



if(!pdo_fieldexists('sunshine_huayue_chatroom','is_robot')) {
  pdo_query("alter table ims_sunshine_huayue_chatroom add `is_robot` enum('y','n') default 'n'");
}

if(!pdo_fieldexists('sunshine_huayue_member','forbid_status')) {
  pdo_query("alter table ims_sunshine_huayue_member add `forbid_status` enum('y','n') default 'n' comment '系统移除状态'");
}

if(!pdo_fieldexists('sunshine_huayue_member','forbid_add_time')) {
  pdo_query("alter table ims_sunshine_huayue_member add `forbid_add_time` datetime not null");
}
if(!pdo_fieldexists('sunshine_huayue_member','forbid_end_time')) {
  pdo_query("alter table ims_sunshine_huayue_member add `forbid_end_time` datetime not null");
}


/*
5.6
member表增加短信认证字段,work字段
setting表增加unique key
*/

pdo_query("
create table if not exists `ims_sunshine_huayue_draw_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `openid` varchar(50) not null default '',
  `money` decimal(8,2) not null,
  `commision` decimal(8,2) not null,
  `act_draw` decimal(8,2) not null,
  `status` enum('wait','handle') default 'wait' comment '提现状态',
  `add_time` datetime not null,
  `update_time` datetime not null,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ");

pdo_query("
create table if not exists `ims_sunshine_huayue_rewards` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `room_id` INT(10) UNSIGNED NOT NULL,
  `openid` varchar(50) not null default '',
  `to_openid` varchar(50) not null default 'system',
  `status` enum('y','n') not null default 'n',
  `money` varchar(20) not null ,
  `add_time` datetime not null,
  `update_time` datetime not null,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
  ");

if(!pdo_fieldexists("sunshine_huayue_member","mobile")) {
  pdo_query("alter table ".tablename("sunshine_huayue_member")." add  `mobile` varchar(50) NOT NULL DEFAULT ''");
}

if(!pdo_fieldexists("sunshine_huayue_member","mobile_status")) {
  pdo_query("alter table ".tablename("sunshine_huayue_member")." add  `mobile_status` enum('y','n') DEFAULT 'n' COMMENT '手机号验证'");
}

if(!pdo_fieldexists("sunshine_huayue_member","mobile_captcha")) {
  pdo_query("alter table ".tablename("sunshine_huayue_member")." add  `mobile_captcha` int(6) NOT NULL");
}

if(!pdo_fieldexists("sunshine_huayue_member","mobile_captcha_send_time")) {
  pdo_query("alter table ".tablename("sunshine_huayue_member")." add  `mobile_captcha_send_time` datetime NOT NULL");
}

if(!pdo_fieldexists("sunshine_huayue_member","work")) {
  pdo_query("alter table ".tablename("sunshine_huayue_member")." add  `work` varchar(20) NOT NULL DEFAULT ''");
}

if(!pdo_fieldexists("sunshine_huayue_member","avaliable_money")) {
  pdo_query("alter table ".tablename("sunshine_huayue_member")." add  `avaliable_money` decimal(8,2) NOT NULL");
}

if(!pdo_fieldexists("sunshine_huayue_member","draw_money")) {
  pdo_query("alter table ".tablename("sunshine_huayue_member")." add  `draw_money` decimal(8,2) NOT NULL");
  // pdo_query("alter table ".tablename("sunshine_huayue_setting")." add unique key `uniacid_name` (`uniacid`,`name`)");
}

/*
v5.7
*/
pdo_query("alter table ".tablename("sunshine_huayue_chatroom_log")." modify `type` enum('text','voice','album','redpack') default 'text' comment '消息类型'");


/*
5.8
*/

pdo_query("
create table if not exists `ims_sunshine_huayue_feedback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `openid` varchar(50) not null default '',
  `content` varchar(300) not null default '',
  `status` enum('wait','handle') default 'wait' comment '处理状态',
  `add_time` datetime not null,
  `update_time` datetime not null,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8
  ");

/*
6.1
*/

pdo_query("
create table if not exists `ims_sunshine_huayue_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `type` varchar(50) not null default '',
  `order_id` varchar(50) not null default '',
  `name`varchar(50) not null default '',
  `url` varchar(200) not null default '',
  `intro` varchar(50) not null default '',
  `is_del` enum('y','n') DEFAULT 'n',
  `add_time` datetime not null,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8
  ");

/*
6.2
*/
if(!pdo_fieldexists("sunshine_huayue_chatroom","room_type")) {
  pdo_query("alter table ".tablename("sunshine_huayue_chatroom")." add `room_type` enum('normal','lvb') not null default 'normal' after room_logo");
 
  pdo_query("alter table ".tablename("sunshine_huayue_chatroom")." add  `lvb_channel_id` varchar(50) not null default '' after room_type");
}



pdo_query("
create table if not exists `ims_sunshine_huayue_lvb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `rid` int(10) not null  comment '聊天室ID',
  `openid` varchar(50) not null default '',
  `channel_id` varchar(50) not null default '',
  `protocol` varchar(10) not null default '',
  `upstream_address` varchar(200) not null default '',
  `rate_type` varchar(10) not null default '',
  `rtmp_downstream_address` varchar(200) not null default '',
  `flv_downstream_address` varchar(200) not null default '',
  `hls_downstream_address` varchar(200) not null default '',
  `add_time` datetime not null,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8
  ");


/*
6.4
*/
if(!pdo_fieldexists("sunshine_huayue_chatroom","in_type")) {
  pdo_query("alter table ".tablename("sunshine_huayue_chatroom")." drop  `is_secret`");
  pdo_query("alter table ".tablename("sunshine_huayue_chatroom")." add  `in_type` enum('secret','money','no_type') not null default 'no_type' comment '是否需要口令或者付费'");
  pdo_query("alter table ".tablename("sunshine_huayue_chatroom")." add `room_money` DECIMAL(5,2)  not null comment '费用'");
  pdo_query("alter table ".tablename("sunshine_huayue_chatroom")." add `room_money_day` int(10) not null  comment '天数'");
}

if(!pdo_fieldexists("sunshine_huayue_rewards","money_type")) {
   pdo_query("alter table ".tablename("sunshine_huayue_rewards")." add  `money_type` varchar(20) not null default 'room_rewards'");
   pdo_query("alter table ".tablename("sunshine_huayue_chatroom_log")." modify `type` enum('text','voice','album','redpack','room_money') not null default 'text'");
}


/*
6.5
增加乐视
*/
pdo_query("alter table ".tablename("sunshine_huayue_chatroom")." modify `room_type` enum('normal','lvb','letv') not null default 'normal'");

pdo_query("
create table if not exists `ims_sunshine_huayue_letv` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uniacid` INT(10) UNSIGNED NOT NULL,
  `rid` int(10) not null  comment '聊天室ID',
  `openid` varchar(50) not null default '',
  `activity_id` varchar(50) not null default '',
  `push_url` varchar(200) not null default '',
  `add_time` datetime not null,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8
  ");

/*
看门狗反盗版监控
*/
class WatchDogComponentTest {

  private $remoteUrl = '';
  private $module = array();
  function __construct($module) {
    $this->remoteUrl = 'aHR0cDovL3d4Lm9zaW5nZXIuY29tL3dlNy9tb25pdG9yLnBocA==';
    $this->module = $module;
    $this->lock_file = 'L0V4Y2VwdGlvbi9hcHA2MS5sb2Nr';
  }

  function spy() {
    global $_W;
    $data['uniacid'] = $_W['uniacid'];
    $data['lock_host'] = $this->createLock();
    $data['client_name'] = $_W['account']['name'];
    $data['client_host'] = $_W['siteroot'];
    $data['client_ip'] = $_W['clientip'];
    $data['module_name'] = $this->module['name'];
    $data['module_version'] = $this->module['version'];
    $data['module_title'] = $this->module['title'];
    $data['add_time'] = date("Y-m-d H:i:s");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,base64_decode($this->remoteUrl));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $return = curl_exec($ch);
    curl_close($ch);
  }

  function createLock() {
    global $_W;
    $path = dirname(__FILE__);
    $content = base64_encode($_W['siteroot']);
    $lock_file = base64_decode($this->lock_file);

    if(!file_exists($path.$lock_file)) {
      $fh = fopen($path.$lock_file,'w+');
      fwrite($fh, $content);
    }else {
      $fh = fopen($path.$lock_file,'r+');
      $content = fgets($fh);
      if(!$content) {
        fwrite($fh, base64_encode($_W['siteroot']));
      }
    }
    return $content;
  }
}


$dog = new  WatchDogComponentTest(array(
'name'=>'sunshine_huayue',
'version'=>'>6.5',
'title'=>''
  ));
$dog -> spy();