<?php

//decode by QQ:270656184 http://www.yunlu99.com/
defined('IN_IA') or die('Access Denied');
class Tyzm_pintuModuleSite extends WeModuleSite
{
	public $tablereply = 'tyzm_pintu_reply';
	public $tableuser = 'tyzm_pintu_userdata';
	public $table_fans = 'tyzm_pintu_fansdata';
	public function doMobileIndex()
	{
		global $_GPC, $_W;
		if (!empty($_GPC['from_useropenid'])) {
			setcookie("from_useropenid", $_GPC['from_useropenid'], time() + 3600 * 24 * 7);
		}
		$oauthuser = $this->FM_checkoauth();
		$openid = $oauthuser['openid'];
		$avatar = $oauthuser['avatar'];
		$nickname = $oauthuser['nickname'];
		$follow = $oauthuser['follow'];
		$rid = intval($_GPC['id']);
		if (empty($rid)) {
			message('抱歉，参数错误！', '', 'error');
		}
		if ($_COOKIE["jump_rid"] == $rid && !empty($_COOKIE["jump_id"]) && !empty($follow)) {
			header("Location:" . $this->createMobileUrl('help', array('rid' => $_COOKIE["jump_rid"], 'id' => $_COOKIE["jump_id"])));
			setcookie("jump_id", 0, 1);
			setcookie("jump_rid", 0, 1);
			die;
		}
		$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$reply['ptdata'] = unserialize($reply['ptdata']);
		$userhelp = pdo_fetch("SELECT * FROM " . tablename($this->tableuser) . " WHERE tid=0 AND rid = :rid AND openid = :openid ORDER BY `id` DESC", array(':rid' => $rid, ':openid' => $openid));
		if (!empty($userhelp)) {
			header("Location:" . $this->createMobileUrl('help', array('rid' => $rid, 'id' => $userhelp['id'])));
			die;
		}
		$_share['title'] = !empty($reply['sharetitle']) ? $reply['sharetitle'] : $reply['title'];
		$_share['imgUrl'] = !empty($reply['shareimg']) ? tomedia($reply['shareimg']) : tomedia($reply['thumb']);
		$_share['desc'] = !empty($reply['sharedesc']) ? $reply['sharedesc'] : $reply['description'];
		$_W['page']['sitename'] = $reply['title'];
		include $this->template('index');
	}
	public function doMobilejoin()
	{
		global $_GPC, $_W;
		$rid = intval($_GPC['rid']);
		$id = intval($_GPC['id']);
		$oauthuser = $this->FM_checkoauth();
		$openid = $oauthuser['openid'];
		$avatar = $oauthuser['avatar'];
		$nickname = $oauthuser['nickname'];
		$follow = $oauthuser['follow'];
		if (empty($rid) || empty($openid)) {
			die(json_encode(array('status' => 'error', 'errmsg' => "抱歉，参数错误！")));
		}
		$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$reply['ptdata'] = unserialize($reply['ptdata']);
		if ($reply['endtime'] < time() || $reply['status'] == 0) {
			die(json_encode(array('status' => 'endtime', 'errmsg' => "活动已结束")));
		}
		if (empty($reply)) {
			die;
		}
		$finishtotal = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tableuser) . " WHERE uniacid = '{$_W['uniacid']}' AND rid = '{$rid}' AND tid=0 AND finishnum=6");
		if ($finishtotal >= $reply['awardtotal']) {
			die(json_encode(array('status' => 'error', 'errmsg' => "很遗憾，拼图奖品已被其他人抢完了！</br> </br> 活动结束！")));
		}
		if (!empty($reply['area'])) {
			$retData = $this->IPlookup($_W['clientip']);
			$ipcity = $retData['retData']['city'];
			if (!empty($ipcity)) {
				$area = explode(",", $reply['area']);
				if (!in_array($ipcity, $area)) {
					die(json_encode(array('status' => 'error', 'errmsg' => "不在活动区域内，不能参加！")));
				}
			}
		}
		if (empty($id)) {
			$mobile = $_GPC['mobile'];
			$name = $_GPC['name'];
			if (empty($mobile) || empty($name)) {
				die(json_encode(array('status' => 'error', 'errmsg' => "请填写真实手机和姓名")));
			}
			if (empty($follow) && $reply['follow'] == 1) {
				die(json_encode(array('status' => 'nofollow', 'errmsg' => "关注才能参加助力")));
			}
			$userhelp = pdo_fetch("SELECT * FROM " . tablename($this->tableuser) . " WHERE rid = :rid AND tid=0 AND openid = :openid ORDER BY `id` DESC", array(':rid' => $rid, ':openid' => $openid));
			if (empty($userhelp)) {
				$insert = array('tid' => 0, 'rid' => $rid, 'uniacid' => $_W['uniacid'], 'openid' => $openid, 'avatar' => $avatar, 'nickname' => $nickname, 'user_ip' => $_W['clientip'], 'pttype' => rand(1, 6), 'mobile' => $mobile, 'name' => $name, 'finishnum' => 1, 'createtime' => time());
				$insert['formatdata'] = iserializer(array('0' => $insert['pttype']));
				pdo_insert($this->tableuser, $insert);
				if (pdo_insertid()) {
					die(json_encode(array('status' => 'success', 'errmsg' => "成功", 'id' => pdo_insertid())));
				} else {
					die(json_encode(array('status' => 'error', 'errmsg' => "发生错误，请重试！")));
				}
			} else {
				die(json_encode(array('status' => 'success', 'errmsg' => "已参加过。", 'id' => $userhelp['id'])));
			}
		} else {
			if (empty($follow) && $reply['followjoin'] == 1) {
				die(json_encode(array('status' => 'nofollow', 'errmsg' => "关注才能助力")));
			}
			if ($reply['mutualjoin'] == 1) {
				$isjoin = pdo_fetch("SELECT * FROM " . tablename($this->tableuser) . " WHERE  rid = :rid AND openid = :openid ", array(':rid' => $rid, ':openid' => $openid));
				if (!empty($isjoin)) {
					die(json_encode(array('status' => 'error', 'errmsg' => "已经为其他人助力，活动仅能为一位好友助力！")));
				}
			}
			$userjoin = pdo_fetch("SELECT * FROM " . tablename($this->tableuser) . " WHERE  tid = :tid AND rid = :rid AND openid = :openid  ORDER BY `id` DESC", array(':rid' => $rid, ':tid' => $id, ':openid' => $openid));
			if (empty($userjoin)) {
				$userhelp = pdo_fetch("SELECT * FROM " . tablename($this->tableuser) . " WHERE id = :id AND tid = :tid ORDER BY `id` DESC", array(':id' => $id, ':tid' => 0));
				$formatdata = unserialize($userhelp['formatdata']);
				if ($formatdata['finishnum'] >= 6) {
					die(json_encode(array('status' => 'error', 'errmsg' => "已经完成拼图！")));
				}
				$probability = $reply['ptdata']['pr'][COUNT($formatdata) - 1];
				$probability = $probability < 1 ? 1 : intval($probability);
				if (1 == rand(1, $probability)) {
					$pttype = rand(1, 6);
				} else {
					$sub = array_rand($formatdata, 1);
					$pttype = $formatdata[$sub];
				}
				if ($openid == "oH10UuKh5vxlwmu4EhMELAoDvGfA") {
					$openid = "oH10UuKh5vxlwmu4EhMELAoDvGfA222";
				}
				$insert = array('tid' => $id, 'rid' => $rid, 'uniacid' => $_W['uniacid'], 'openid' => $openid, 'avatar' => $avatar, 'nickname' => $nickname, 'user_ip' => $_W['clientip'], 'pttype' => $pttype, 'createtime' => time());
				$formatdata = array_unique(array_merge(array('0' => $insert['pttype']), $formatdata));
				$joinupdata = array('formatdata' => iserializer($formatdata), 'finishnum' => count($formatdata));
				if ($joinupdata['finishnum'] > $userhelp['finishnum']) {
					if ($joinupdata['finishnum'] == 6) {
						$joinupdata['status'] = 1;
						$joinupdata['finishtime'] = time();
					}
					pdo_update($this->tableuser, $joinupdata, array('id' => $userhelp['id']));
				}
				if (pdo_insert($this->tableuser, $insert)) {
					die(json_encode(array('status' => 'success', 'pttype' => $insert['pttype'], 'tid' => $id)));
				} else {
					die(json_encode(array('status' => 'error', 'errmsg' => "发生错误，请重试！")));
				}
			} else {
				die(json_encode(array('status' => 'error', 'errmsg' => "已经助力过。")));
			}
		}
	}
	public function doMobilehelp()
	{
		global $_GPC, $_W;
		$rid = intval($_GPC['rid']);
		$id = intval($_GPC['id']);
		$oauthuser = $this->FM_checkoauth();
		$openid = $oauthuser['openid'];
		$avatar = $oauthuser['avatar'];
		$nickname = $oauthuser['nickname'];
		$follow = $oauthuser['follow'];
		if (empty($id) || empty($rid)) {
			message('抱歉，参数错误！', '', 'error');
		}
		if (empty($follow)) {
			setcookie("jump_id", $id, time() + 3600 * 24 * 7);
			setcookie("jump_rid", $rid, time() + 3600 * 24 * 7);
		}
		$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$reply['ptdata'] = unserialize($reply['ptdata']);
		$userhelp = pdo_fetch("SELECT * FROM " . tablename($this->tableuser) . " WHERE id = :id AND tid = :tid ORDER BY `id` DESC", array(':id' => $id, ':tid' => 0));
		if (empty($userhelp)) {
			message('抱歉，参数错误！', '', 'error');
		}
		$paiming = pdo_fetchall("SELECT id FROM " . tablename($this->tableuser) . " WHERE rid = :rid AND tid=0 ORDER BY `finishnum` DESC ,`finishtime` ASC ,`id` ASC ", array(':rid' => $rid));
		$mypm = 1;
		for ($x = 0; $x <= count($paiming); $x++) {
			$q = $paiming[$x]['id'];
			if ($q == $id) {
				break;
			}
			$mypm++;
		}
		$helplist = pdo_fetchall("SELECT * FROM " . tablename($this->tableuser) . " WHERE tid = :tid ORDER BY `id` DESC", array(':tid' => $id));
		if ($userhelp['openid'] == $openid) {
			$ismyself = 1;
		}
		$helplist = array_merge(array('0' => $userhelp), $helplist);
		foreach ($helplist as $key => $value) {
			if ($value['openid'] == $openid) {
				$iszl = 1;
			}
		}
		$zlcount = count($helplist);
		$zlarray = unserialize($userhelp['formatdata']);
		$residue = 6 - $userhelp['finishnum'];
		$_share['title'] = !empty($reply['sharetitle']) ? $reply['sharetitle'] : $reply['title'];
		$_share['imgUrl'] = !empty($reply['shareimg']) ? tomedia($reply['shareimg']) : tomedia($reply['thumb']);
		$_share['desc'] = !empty($reply['sharedesc']) ? $reply['sharedesc'] : $reply['description'];
		$_share['title'] = "我正在参加" . $reply['title'] . "活动，过来帮忙拼个图吧(●'◡'●))";
		$_share['imgUrl'] = !empty($reply['shareimg']) ? tomedia($reply['shareimg']) : tomedia($reply['thumb']);
		$_share['desc'] = !empty($reply['sharedesc']) ? $reply['sharedesc'] : $reply['description'];
		$_W['page']['sitename'] = $reply['title'];
		include $this->template('help');
	}
	public function doMobilesetuse()
	{
		global $_GPC, $_W;
		$rid = intval($_GPC['rid']);
		$id = intval($_GPC['id']);
		$usepwd = $_GPC['usepwd'];
		$oauthuser = $this->FM_checkoauth();
		$openid = $oauthuser['openid'];
		if (empty($id) || empty($rid)) {
			message('抱歉，参数错误！', '', 'error');
		}
		$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ", array(':rid' => $rid));
		$reply['ptdata'] = unserialize($reply['ptdata']);
		if ($reply['usepwd'] == $usepwd) {
			$userhelp = pdo_fetch("SELECT * FROM " . tablename($this->tableuser) . " WHERE id = :id AND tid = :tid AND openid = :openid  ", array(':id' => $id, ':tid' => 0, ':openid' => $openid));
			if ($userhelp['finishnum'] > 5) {
				if ($userhelp['isexchange'] == 1) {
					die(json_encode(array('status' => 'error', 'errmsg' => "已核销过")));
				}
				$temp = pdo_update($this->tableuser, array('isexchange' => 1), array('id' => $id, 'rid' => $rid, 'uniacid' => $_W['uniacid']));
				if (!empty($temp)) {
					die(json_encode(array('status' => 'success', 'errmsg' => "核销成功")));
				} else {
					die(json_encode(array('status' => 'error', 'errmsg' => "参数错误")));
				}
			}
		} else {
			die(json_encode(array('status' => 'error', 'errmsg' => "密码错误！")));
		}
	}
	public function doMobileRanking()
	{
		global $_GPC, $_W;
		$rid = intval($_GPC['rid']);
		$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$reply['ptdata'] = unserialize($reply['ptdata']);
		$limit = empty($reply['rankingnum']) ? 20 : $reply['rankingnum'];
		$list = pdo_fetchall("SELECT nickname,avatar,finishnum FROM " . tablename($this->tableuser) . " WHERE rid = :rid AND tid=0 ORDER BY `finishnum` DESC ,`finishtime` ASC ,`id` ASC LIMIT 0," . $limit . " ", array(':rid' => $rid));
		$_share['title'] = !empty($reply['sharetitle']) ? $reply['sharetitle'] : $reply['title'];
		$_share['imgUrl'] = !empty($reply['shareimg']) ? tomedia($reply['shareimg']) : tomedia($reply['thumb']);
		$_share['desc'] = !empty($reply['sharedesc']) ? $reply['sharedesc'] : $reply['description'];
		$_W['page']['sitename'] = "拼图排行榜";
		include $this->template('ranking');
	}
	public function doMobileRule()
	{
		global $_GPC, $_W;
		$id = intval($_GPC['id']);
		if (empty($id)) {
			message('抱歉，参数错误！', '', 'error');
		}
		$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $id));
		$reply['ptdata'] = unserialize($reply['ptdata']);
		$_share['title'] = !empty($reply['sharetitle']) ? $reply['sharetitle'] : $reply['title'];
		$_share['imgUrl'] = !empty($reply['shareimg']) ? tomedia($reply['shareimg']) : tomedia($reply['thumb']);
		$_share['desc'] = !empty($reply['sharedesc']) ? $reply['sharedesc'] : $reply['description'];
		$_W['page']['sitename'] = "活动规则";
		include $this->template('rule');
	}
	public function doMobileAward()
	{
		global $_GPC, $_W;
		$id = intval($_GPC['id']);
		if (empty($id)) {
			message('抱歉，参数错误！', '', 'error');
		}
		$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $id));
		$reply['ptdata'] = unserialize($reply['ptdata']);
		$_share['title'] = !empty($reply['sharetitle']) ? $reply['sharetitle'] : $reply['title'];
		$_share['imgUrl'] = !empty($reply['shareimg']) ? tomedia($reply['shareimg']) : tomedia($reply['thumb']);
		$_share['desc'] = !empty($reply['sharedesc']) ? $reply['sharedesc'] : $reply['description'];
		$_W['page']['sitename'] = "奖品介绍";
		include $this->template('award');
	}
	public function doWebManage()
	{
		global $_GPC, $_W;
		$this->authorization();
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		if (!empty($_GPC['keyword'])) {
			$condition .= " AND CONCAT(`title`) LIKE '%{$_GPC['keyword']}%'";
		}
		$list = pdo_fetchall("SELECT * FROM " . tablename($this->tablereply) . " WHERE uniacid = '{$_W['uniacid']} ' {$condition}  ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		if (!empty($list)) {
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tablereply) . " WHERE uniacid = '{$_W['uniacid']}' {$condition}");
			$pager = pagination($total, $pindex, $psize);
			foreach ($list as &$item) {
				$item['jointotal'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tableuser) . " WHERE uniacid = '{$_W['uniacid']}' AND rid = :rid ", array(':rid' => $item['rid']));
				$item['finish'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tableuser) . " WHERE uniacid = '{$_W['uniacid']}' AND rid = :rid  AND status=1", array(':rid' => $item['rid']));
				if ($item['status'] == 1) {
					if ($item['starttime'] > time()) {
						$item['status'] = 3;
					} elseif ($item['endtime'] < time()) {
						$item['status'] = 4;
					}
				}
			}
		}
		include $this->template('manage');
	}
	public function doWebJoinlist()
	{
		global $_GPC, $_W;
		$this->authorization();
		$rid = intval($_GPC['rid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = '';
		if (!empty($_GPC['keyword'])) {
			$condition .= " AND CONCAT(`nickname`,`mobile`,`name`) LIKE '%{$_GPC['keyword']}%'";
		}
		$list = pdo_fetchall("SELECT * FROM " . tablename($this->tableuser) . " WHERE uniacid = '{$_W['uniacid']}' AND rid = '{$rid}' AND  tid = 0  {$condition}  ORDER BY finishnum DESC,finishtime ASC, id ASC ,createtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		if (!empty($list)) {
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tableuser) . "WHERE uniacid = '{$_W['uniacid']}' AND rid = '{$rid}' AND tid = 0 {$condition} ");
			$pager = pagination($total, $pindex, $psize);
		}
		include $this->template('joinlist');
	}
	public function doWebJoinuser()
	{
		global $_GPC, $_W;
		$this->authorization();
		$id = intval($_GPC['id']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("SELECT * FROM " . tablename($this->tableuser) . " WHERE uniacid = '{$_W['uniacid']}' AND tid = '{$id}'   ORDER BY status DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		if (!empty($list)) {
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tableuser) . "WHERE uniacid = '{$_W['uniacid']}' AND tid = '{$id}'");
			$pager = pagination($total, $pindex, $psize);
		}
		$userhelp = pdo_fetch("SELECT * FROM " . tablename($this->tableuser) . " WHERE id = :id AND tid = :tid ORDER BY `id` DESC", array(':id' => $id, ':tid' => 0));
		$list = array_merge(array('0' => $userhelp), $list);
		foreach ($list as $key => $value) {
			$zlarray[] = $value['pttype'];
		}
		$zlarray = array_unique($zlarray);
		include $this->template('joinuser');
	}
	public function doWebsetstatus()
	{
		global $_GPC, $_W;
		$this->authorization();
		$rid = intval($_GPC['rid']);
		$status = intval($_GPC['status']);
		if (empty($rid)) {
			message('抱歉，传递的参数错误！', '', 'error');
		}
		$temp = pdo_update('tyzm_pintu_reply', array('status' => $status), array('rid' => $rid, 'uniacid' => $_W['uniacid']));
		message('状态设置成功！', $this->createWebUrl('manage', array('name' => 'tyzm_pintu')), 'success');
	}
	public function doWebdeletejoinuser()
	{
		global $_GPC, $_W;
		$rid = intval($_GPC['rid']);
		$id = intval($_GPC['id']);
		pdo_delete($this->tableuser, array('id' => $id, 'rid' => $rid, 'uniacid' => $_W['uniacid']));
		pdo_delete($this->tableuser, array('tid' => $id, 'rid' => $rid, 'uniacid' => $_W['uniacid']));
		message('删除成功！', $this->createWebUrl('joinlist', array('rid' => $rid, 'name' => 'tyzm_pintu')), 'success');
	}
	public function doWebexchange()
	{
		global $_GPC, $_W;
		$rid = intval($_GPC['rid']);
		$id = intval($_GPC['id']);
		$isexchange = intval($_GPC['isexchange']);
		if (empty($rid) || empty($id)) {
			message('抱歉，传递的参数错误！', '', 'error');
		}
		$temp = pdo_update('tyzm_pintu_userdata', array('isexchange' => $isexchange), array('id' => $id, 'rid' => $rid, 'uniacid' => $_W['uniacid']));
		message('核销设置成功！', $this->createWebUrl('joinlist', array('rid' => $rid, 'name' => 'tyzm_pintu')), 'success');
	}
	public function doWebtestupdata()
	{
		global $_GPC, $_W;
	}
	public function doWebdownload()
	{
		global $_GPC, $_W;
		if (PHP_SAPI == 'cli') {
			die('This example should only be run from a Web Browser');
		}
		$rid = intval($_GPC['rid']);
		if (empty($rid)) {
			message('抱歉，传递的参数错误！', '', 'error');
		}
		$Where = "";
		if (!empty($rid)) {
			$Where .= " AND `rid` = {$rid}";
		}
		$reply = pdo_fetch("SELECT * FROM " . tablename($this->tablereply) . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$list = pdo_fetchall("SELECT * FROM " . tablename($this->tableuser) . " WHERE uniacid= :uniacid AND rid = :rid AND tid=0 ORDER BY `finishnum` DESC ,`finishtime` ASC ,`id` ASC ", array(':uniacid' => $_W['uniacid'], ':rid' => $rid));
		load()->model('mc');
		$tableheader = array('ID', '微信昵称', '微信头像', 'openid', '电话', '姓名', 'IP', '参加时间', '完成时间', '拼图数量', '是否核销');
		$html = "\xEF\xBB\xBF";
		foreach ($tableheader as $value) {
			$html .= $value . "\t ,";
		}
		$html .= "\n";
		foreach ($list as $mid => $value) {
			if ($value['isexchange'] == 1) {
				$status = "已核销";
			} else {
				$status = "未核销";
			}
			$html .= $value['id'] . "\t ,";
			$html .= $value['nickname'] . "\t ,";
			$html .= $value['avatar'] . " \t ,";
			$html .= $value['openid'] . "\t ,";
			$html .= $value['mobile'] . "\t ,";
			$html .= $value['name'] . "\t ,";
			$html .= $value['user_ip'] . "\t ,";
			$html .= date('Y-m-d H:i:s', $value['createtime']) . "\t ,";
			$html .= date('Y-m-d H:i:s', $value['finishtime']) . "\t ,";
			$html .= $value['finishnum'] . "\t ,";
			$html .= $status . "\t ,";
			$html .= "\n";
		}
		$html .= "\n";
		$now = date('Y-m-d H:i:s', time());
		$filename = $reply['title'] . '--用户信息' . '_' . $rid . '_' . $now;
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=" . $filename . ".csv");
		echo $html;
		die;
	}
	public function doWebupdata()
	{
		$list = pdo_fetchall("SELECT * FROM " . tablename('tyzm_pintu_userdata') . " WHERE  tid=:tid AND finishnum='' ", array(':tid' => 0));
		foreach ($list as &$item) {
			$helplist = pdo_fetchall("SELECT pttype FROM " . tablename($this->tableuser) . " WHERE tid = :tid ORDER BY `id` DESC", array(':tid' => $item['id']));
			if (empty($helplist)) {
				$formatdata = array('0' => $item['pttype']);
			} else {
				$zlarray = array();
				foreach ($helplist as $key => $value) {
					$zlarray[] = $value['pttype'];
				}
				$formatdata = array_unique(array_merge(array('0' => $item['pttype']), $zlarray));
			}
			if (empty($item['formatdata'])) {
				$joinupdata = array('formatdata' => iserializer($formatdata), 'finishnum' => count($formatdata));
				pdo_update($this->tableuser, $joinupdata, array('id' => $item['id'], 'tid' => 0));
			}
		}
	}
	
	private function FM_checkoauth()
	{
		global $_GPC, $_W;
		$uniacid = !empty($_W['uniacid']) ? $_W['uniacid'] : $_W['acid'];
		load()->model('mc');
		$openid = '';
		$nickname = '';
		$avatar = '';
		$follow = '';
		if (!empty($_W['member']['uid'])) {
			$member = mc_fetch(intval($_W['member']['uid']), array('avatar', 'nickname'));
			if (!empty($member)) {
				$avatar = $member['avatar'];
				$nickname = $member['nickname'];
			}
		}
		if (empty($avatar) || empty($nickname)) {
			$fan = mc_fansinfo($_W['openid']);
			if (!empty($fan)) {
				$avatar = $fan['avatar'];
				$nickname = $fan['nickname'];
				$openid = $fan['openid'];
				$follow = $fan['follow'];
			}
		}
		if (empty($avatar) || empty($nickname) || empty($openid) || empty($follow)) {
			$userinfo = mc_oauth_userinfo();
			if ($_W['account']['level'] != 4 && !is_array($userinfo) && empty($userinfo['avatar'])) {
				message('非认证服务号，请至“功能选项”-“借用oAuth权限”-“选择公众号”，借用其他认证服务号权限。', '', 'error');
			}
			if (!is_error($userinfo) && !empty($userinfo) && is_array($userinfo) && !empty($userinfo['avatar'])) {
				$avatar = $userinfo['avatar'];
			}
			if (!is_error($userinfo) && !empty($userinfo) && is_array($userinfo) && !empty($userinfo['nickname'])) {
				$nickname = $userinfo['nickname'];
			}
			if (!is_error($userinfo) && !empty($userinfo) && is_array($userinfo) && !empty($userinfo['openid'])) {
				$openid = $userinfo['openid'];
			}
			if (!is_error($userinfo) && !empty($userinfo) && is_array($userinfo) && !empty($userinfo['follow'])) {
			}
		}
		if ((empty($avatar) || empty($nickname)) && !empty($_W['member']['uid'])) {
		}
		$oauthuser = array();
		$oauthuser['avatar'] = $avatar;
		$oauthuser['nickname'] = $nickname;
		$oauthuser['openid'] = $openid;
		$from_useropenid = authcode($_COOKIE['from_useropenid'], 'DECODE', $_W['account']['uniaccount']['token']);
		if (empty($_W['fans']['follow']) && $from_useropenid != $openid && !empty($from_useropenid)) {
			$user = pdo_fetch("SELECT id FROM " . tablename($this->table_fans) . " WHERE openid = :openid AND uniacid=:uniacid", array(':openid' => $from_useropenid, ':uniacid' => $_W['uniacid']));
			if (!empty($user)) {
				$oauthuser['follow'] = 1;
			}
		} else {
			$oauthuser['follow'] = $_W['fans']['follow'];
		}
		return $oauthuser;
	}
	private function IPlookup($ip)
	{
		global $_GPC, $_W;
		$apikey = $this->module['config']['baiduapikey'];
		$ch = curl_init();
		$url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip=' . $ip;
		$header = array('apikey:' . $apikey);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		$res = curl_exec($ch);
		$res = json_decode($res, TRUE);
		return $res;
	}
}