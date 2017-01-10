<?php
/**
 * 助力平台模块处理程序
 *
 * @author 天涯织梦
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Tyzm_pintuModuleProcessor extends WeModuleProcessor {
	public $table_fans   = 'tyzm_pintu_fansdata';
	public $tableuser = 'tyzm_pintu_userdata';
	public function respond() {
		global $_W;
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
		$message = $this->message;
		$openid= $message['from'];
       $fans = pdo_fetch("SELECT follow FROM " . tablename('mc_mapping_fans') . " WHERE openid = :openid AND uniacid=:uniacid", array(':openid' => $openid,':uniacid' => $_W['uniacid']));
       if(empty($fans)){
		   $user = pdo_fetch("SELECT id FROM " . tablename($this->table_fans) . " WHERE openid = :openid AND uniacid=:uniacid", array(':openid' => $openid,':uniacid' => $_W['uniacid']));
		   if(empty($user)){
			   $insert=array(
					'uniacid'=>$_W['uniacid'],
					'openid'=>$openid, 
					'createtime'=>time(), 
				);
				pdo_insert($this->table_fans, $insert);
		   }
	   }
		$rid = $this->rule;
		$sql = "SELECT title,description,thumb,status,starttime,awardtotal FROM " . tablename('tyzm_pintu_reply') . " WHERE `rid`=:rid LIMIT 1";
		$row = pdo_fetch($sql, array(':rid' => $rid));

		if ($row == false) {
			return $this->respText("活动已取消...");
		}

		if ($row['isshow'] == 1) {
			return $this->respText("活动暂停，请稍后...");
		}

		if ($row['starttime'] > time()) {
			return $this->respText("活动未开始，请等待...");
		}

		$finishtotal = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tableuser) . " WHERE uniacid = '{$_W['uniacid']}' AND rid = '{$rid}' AND tid=0 AND finishnum=6");
		
		if($finishtotal >= $row['awardtotal'] ) {
			$row['title']="【活动已结束】".$row['title'];
			$row['Description']="活动已结束，请继续关注其他活动！";
		}

		$openid=authcode($openid,'ENCODE',$_W['account']['uniaccount']['token']);
		
		return $this->respNews(array(
			'Title' => $row['title'],
			'Description' => $row['Description'],
			'PicUrl' => toimage($row['thumb']),
			'Url' => $this->createMobileUrl('index', array('id' => $rid,'from_useropenid'=>$openid)),
		));

	}
}