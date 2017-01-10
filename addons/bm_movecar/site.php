<?php
/**
 * 扫码会务管理模块处理程序
 *
 * 美丽心情
 * QQ:513316788 
 */
defined('IN_IA') or exit('Access Denied');
class bm_movecarModuleSite extends WeModuleSite {
    public $weid;
    public function __construct() {
        global $_W;
        $this->weid = IMS_VERSION<0.6?$_W['weid']:$_W['uniacid'];
    }

	public function doWebAdv() {
		global $_W, $_GPC;
		load()->func('tpl');
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display') {
			$list = pdo_fetchall("SELECT * FROM " . tablename('bm_movecar_adv') . " WHERE weid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
		} elseif ($operation == 'post') {
			$id = intval($_GPC['id']);
			if (checksubmit('submit')) {
				$data = array(
					'weid' => $_W['uniacid'],
					'advname' => $_GPC['advname'],
					'link' => $_GPC['link'],
					'enabled' => intval($_GPC['enabled']),
					'displayorder' => intval($_GPC['displayorder']),
					'thumb'=>$_GPC['thumb']
				);
				if (!empty($id)) {
					pdo_update('bm_movecar_adv', $data, array('id' => $id));
				} else {
					pdo_insert('bm_movecar_adv', $data);
					$id = pdo_insertid();
				}
				message('更新幻灯片成功！', $this->createWebUrl('adv', array('op' => 'display')), 'success');
			}
			$adv = pdo_fetch("select * from " . tablename('bm_movecar_adv') . " where id=:id and weid=:weid limit 1", array(":id" => $id, ":weid" => $_W['uniacid']));
		} elseif ($operation == 'delete') {
			$id = intval($_GPC['id']);
			$adv = pdo_fetch("SELECT id FROM " . tablename('bm_movecar_adv') . " WHERE id = '$id' AND weid=" . $_W['uniacid'] . "");
			if (empty($adv)) {
				message('抱歉，幻灯片不存在或是已经被删除！', $this->createWebUrl('adv', array('op' => 'display')), 'error');
			}
			pdo_delete('bm_movecar_adv', array('id' => $id));
			message('幻灯片删除成功！', $this->createWebUrl('adv', array('op' => 'display')), 'success');
		} else {
			message('请求方式不存在');
		}
		include $this->template('adv');
	}

	public function doWebAdver() {
		global $_W, $_GPC;
		load()->func('tpl');
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display') {
			$list = pdo_fetchall("SELECT * FROM " . tablename('bm_movecar_adver') . " WHERE weid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
		} elseif ($operation == 'post') {
			$id = intval($_GPC['id']);
			if (checksubmit('submit')) {
				$data = array(
					'weid' => $_W['uniacid'],
					'advname' => $_GPC['advname'],
					'link' => $_GPC['link'],
					'enabled' => intval($_GPC['enabled']),
					'displayorder' => intval($_GPC['displayorder']),
					'thumb'=>$_GPC['thumb']
				);
				if (!empty($id)) {
					pdo_update('bm_movecar_adver', $data, array('id' => $id));
				} else {
					pdo_insert('bm_movecar_adver', $data);
					$id = pdo_insertid();
				}
				message('更新广告成功！', $this->createWebUrl('adver', array('op' => 'display')), 'success');
			}
			$adv = pdo_fetch("select * from " . tablename('bm_movecar_adver') . " where id=:id and weid=:weid limit 1", array(":id" => $id, ":weid" => $_W['uniacid']));
		} elseif ($operation == 'delete') {
			$id = intval($_GPC['id']);
			$adv = pdo_fetch("SELECT id FROM " . tablename('bm_movecar_adver') . " WHERE id = '$id' AND weid=" . $_W['uniacid'] . "");
			if (empty($adv)) {
				message('抱歉，广告不存在或是已经被删除！', $this->createWebUrl('adver', array('op' => 'display')), 'error');
			}
			pdo_delete('bm_movecar_adver', array('id' => $id));
			message('广告删除成功！', $this->createWebUrl('adver', array('op' => 'display')), 'success');
		} else {
			message('请求方式不存在');
		}
		include $this->template('adver');
	}
	
	public function doWebMember(){
		global $_GPC, $_W;
		checklogin();
		load()->func('tpl');
		$id = intval($_GPC['id']);
		$mid = intval($_GPC['mid']);
		$op = !empty($_GPC['op'])?$_GPC['op']:'display';
		if ($op == 'post') {
			if (!empty($_GPC['mid'])) {
				$item = pdo_fetch("SELECT * FROM ".tablename('bm_movecar_member')." WHERE id='{$_GPC['mid']}' order by id desc");
			}
			$data = array(
				'rid'        => $id,
				'weid'       => $weid,
				'title'      => $_GPC['title'],
				'mobile'     => $_GPC['mobile'],
			);
			if ($_W['ispost']) {
				if (empty($_GPC['mid'])) {
					pdo_insert('bm_movecar_member',$data);
				}else{
					pdo_update('bm_movecar_member',$data,array("id" => $_GPC['mid']));
				}
				message("更新成功",referer(),'success');
			}
		}elseif ($op == 'delete') {
			pdo_delete('bm_movecar_member',array("id" => intval($_GPC['mid'])));
			message("更新成功");
		}
		$condition = '';
		if (!empty($_GPC['username'])) {
			$condition .= " AND username like '%{$_GPC['username']}%' ";
		}
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = TIMESTAMP;
		}
		if (!empty($_GPC['time'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']) + 86399;
			$condition .= " AND time_reg >= '{$starttime}' AND time_reg <= '{$endtime}' ";
		}
		
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("SELECT * FROM ".tablename('bm_movecar_member')." WHERE rid = '$id' $condition ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','.$psize);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('bm_movecar_member') . " WHERE rid = '$id' $condition");
		$pager = pagination($total, $pindex, $psize);
		include $this->template('member');
	}

	public function doWebCar(){
		global $_GPC, $_W;
		checklogin();
		load()->func('tpl');
		$id = intval($_GPC['id']);
		$mid = intval($_GPC['mid']);
		$op = !empty($_GPC['op'])?$_GPC['op']:'display';
		if ($op == 'post') {
			if (!empty($_GPC['mid'])) {
				$item = pdo_fetch("SELECT * FROM ".tablename('bm_movecar_carlist')." WHERE id='{$_GPC['mid']}' order by id desc");
			}
			$data = array(
				'rid'        => $id,
				'weid'       => $weid,
				'province'   => $_GPC['province'],
				'number'     => $_GPC['number'],
				'title'      => $_GPC['title'],
				'mobile'     => $_GPC['mobile'],
				'status'     => $_GPC['status'],
				'userid'     => $_GPC['userid'],
			);
			if ($_W['ispost']) {
				if (empty($_GPC['mid'])) {
					pdo_insert('bm_movecar_carlist',$data);
				}else{
					pdo_update('bm_movecar_carlist',$data,array("id" => $_GPC['mid']));
					if ($data['status']!=$item['status']) {
						if ($reply['is_name'] == 1) {
							$title=$reply['storename'];
						} else {
							$title=$_W['account']['name'];
						}
						if ($data['status']==0) {
							$status ='未通过';
						} elseif ($data['status']==1) {
							$status ='通过';
						} elseif ($data['status']==9) {
							$status ='已注销';
						}
						$reply = pdo_fetch("SELECT * FROM ".tablename('bm_movecar_reply')." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $id));
						$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('movecar',array('rid' => $id,'id' => $mid));
						$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid';
						$row = pdo_fetch($sql, array(':uniacid' => $reply['weid']));
						$appid = $row['key'];
						$appsecret = $row['secret'];
						$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
						$res = $this->http_request($url);
						$result = json_decode($res, true);
						$access_token = $result["access_token"];
						$template = array('touser' => $item['from_user'],
										'template_id' => $reply['templateid'],
										'url' => $urlrpt,
										'topcolor' => "#7B68EE",
										'data' => array('first'	=> array('value' => urlencode('感谢您使用'.$title.'扫码挪车！'),
																		 'color' => "#743A3A",
																		  ),
													  'keyword1' => array('value' => urlencode('车辆登记审核'),
																		 'color' => "#FF0000",
																		  ),
													  'keyword2' 	=> array('value' => urlencode($data['province'].$data['number']),
																		 'color' => "#0000FF",
																		  ),
													  'keyword3' 	=> array('value' => urlencode(date('Y-m-d H:i:s',time())),
																		 'color' => "#0000FF",
																		  ),
													  'keyword4' 	=> array('value' => urlencode('审核结果：'.$status),
																		 'color' => "#0000FF",
																		  ),															  
													  'remark' 	=> array('value' => urlencode("状态已更新！"),
																		 'color' => "#008000",
																		  ),
													  )
										);
						$x=$this->send_template_message(urldecode(json_encode($template)),$access_token);						
					}					
				}
				message("更新成功",referer(),'success');
			}
		}elseif ($op == 'delete') {
			pdo_delete('bm_movecar_carlist',array("id" => intval($_GPC['mid'])));
			message("更新成功");
		}
		$condition = '';
		if (!empty($_GPC['username'])) {
			$condition .= " AND username like '%{$_GPC['username']}%' ";
		}
		if (!empty($_GPC['mobile'])) {
			$condition .= " AND mobile like '%{$_GPC['mobile']}%' ";
		}
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = TIMESTAMP;
		}
		if (!empty($_GPC['time'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']) + 86399;
			$condition .= " AND time_reg >= '{$starttime}' AND time_reg <= '{$endtime}' ";
		}
		if ($_GPC['xls']=="xls") {
			$list = pdo_fetchall("SELECT * FROM ".tablename('bm_movecar_carlist')." WHERE rid = '$id' $condition ORDER BY id DESC");
			foreach ($list as &$row) {
				if ((empty($row['status']))||($row['status']==0)) {
					$row['status']='未提交';
				} elseif ($row['status']==1) {
					$row['status']='正常';
				} elseif ($row['status']==2) {
					$row['status']='删除';
				}
				$row['time_reg']=date("Y-m-d H:i:s" , $row['time_reg'] );
			}
			error_reporting(0);//屏蔽提示信息
			Header( "Content-type:   application/octet-stream "); 
			Header( "Accept-Ranges:   bytes "); 
			Header( "Content-type:application/vnd.ms-excel ;charset=utf-8");//自己写编码   
			Header( "Content-Disposition:attachment;filename=Report.xls"); //名字
			echo "<table width='100%' border='1' >"; //边框
			echo"<tr>";
			echo "<td  style='color:red' align='center'>  <font size=4>编号 </font></td>";
			echo "<td  style='color:red' align='center'>  <font size=4>识别码 </font></td>";
			echo "<td  style='color:red' align='center'>  <font size=4>车主昵称 </font></td>"; 
			echo "<td  style='color:red' align='center'>  <font size=4>Openid </font></td>"; 
			echo "<td  style='color:red' align='center'>  <font size=4>车牌缩写 </font></td>";
			echo "<td  style='color:red' align='center'>  <font size=4>车辆牌号 </font></td>";
			echo "<td  style='color:red' align='center'>  <font size=4>车主称呼 </font></td>";
			echo "<td  style='color:red' align='center'>  <font size=4>车主电话 </font> </td>";
			echo "<td  style='color:red' align='center'>  <font size=4>登记状态 </font> </td>";
			echo "<td  style='color:red' align='center'>  <font size=4>登记时间 </font> </td>";
			echo "</tr>";
			foreach ($list as $value) {
			echo"<tr>";
			echo "<td  align='center'>  <font size=4>" .$value['id'] . " </font></td>";
			echo "<td  align='center'>  <font size=4>" .$value['userid'] . " </font></td>";
			echo "<td  align='center'>  <font size=4>" .$value['username'] . " </font></td>";
			echo "<td  align='center'>  <font size=4>" .$value['from_user'] . " </font></td>";
			echo "<td  align='center'>  <font size=4>" .$value['province'] . " </font></td>";
			echo "<td  align='center'>  <font size=4>" .$value['number'] . " </font></td>";
			echo "<td  align='center'>  <font size=4>" .$value['title'] . " </font></td>";
			echo "<td  align='center'>  <font size=4>" .$value['mobile'] . " </font></td>";
			echo "<td  align='center'>  <font size=4>" .$value['status'] . " </font></td>";
			echo "<td  align='center'>  <font size=4>" .$value['time_reg'] . " </font></td>";
			echo "</tr>";
			}
			exit;
		}		
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("SELECT * FROM ".tablename('bm_movecar_carlist')." WHERE rid = '$id' $condition ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','.$psize);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('bm_movecar_carlist') . " WHERE rid = '$id' $condition ");
		$pager = pagination($total, $pindex, $psize);
		include $this->template('car');
	}

	public function doWebMove(){
		global $_GPC, $_W;
		checklogin();
		load()->func('tpl');
		$id = intval($_GPC['id']);
		$mid = intval($_GPC['mid']);
		$op = !empty($_GPC['op'])?$_GPC['op']:'display';
		$reply = pdo_fetch("SELECT * FROM ".tablename('bm_movecar_reply')." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $id));
		if ($op == 'post') {
			if (!empty($_GPC['mid'])) {
				$item = pdo_fetch("SELECT * FROM ".tablename('bm_movecar_moved')." WHERE id='{$_GPC['mid']}' order by id desc");
			}
			$data = array(
				'rid'        => $id,
				'weid'       => $weid,
				'mobile'     => $_GPC['mobile'],
				'status'     => $_GPC['status'],
				'address'    => $_GPC['address'],
			);
			if ($_W['ispost']) {
				if (empty($_GPC['mid'])) {
					pdo_insert('bm_movecar_moved',$data);
				}else{
					pdo_update('bm_movecar_moved',$data,array("id" => $_GPC['mid']));
				}
				message("更新成功",referer(),'success');
			}
		}elseif ($op == 'delete') {
			pdo_delete('bm_movecar_moved',array("id" => intval($_GPC['mid'])));
			message("更新成功");
		}
		$condition = '';
		if (!empty($_GPC['username'])) {
			$condition .= " AND a.username like '%{$_GPC['username']}%' ";
		}
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = TIMESTAMP;
		}
		if (!empty($_GPC['time'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']) + 86399;
			$condition .= " AND a.time_call >= '{$starttime}' AND a.time_call <= '{$endtime}' ";
		}
		
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("SELECT a.*,b.mobile as mobile1,b.title,b.province,b.number FROM ".tablename('bm_movecar_moved')." a inner join ".tablename('bm_movecar_carlist')." b on a.carid=b.id WHERE a.rid = '$id' $condition ORDER BY a.id DESC LIMIT ".($pindex - 1) * $psize.','.$psize);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('bm_movecar_moved') . " a WHERE a.rid = '$id' $condition ");
		$pager = pagination($total, $pindex, $psize);
		include $this->template('move');
	}

    //https请求（支持GET和POST）
    private function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }		

    //发送模版消息
	private function send_template_message($data,$access_token)
    {
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $res = $this->http_request($url, $data);
        return json_decode($res, true);
	}	

	private function qiniu_upload($accessKey,$secretKey,$bucket,$filePath,$key)
	{
		global $_W,$_GPC;
		require_once 'qiniu/autoload.php';		
		$auth = new Qiniu\Auth($accessKey, $secretKey);
		$token = $auth->uploadToken($bucket);
		$uploadMgr = new Qiniu\Storage\UploadManager();
		list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
		if ($err !== null) {
			return 'x';
		} else {
			return 'y';
		}
	}
	
	public function doMobileHome() {
		global $_W,$_GPC;
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
		load()->func('tpl');
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
			message('非法访问，请通过微信打开！');
			die();
        }		
		$rid = trim($_GPC['rid']);
		$reply = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$advers = pdo_fetchall("select * from " . tablename('bm_movecar_adver') . " where enabled=1 and weid= '{$_W['uniacid']}' order by displayorder asc");
		$advs = pdo_fetchall("select * from " . tablename('bm_movecar_adv') . " where enabled=1 and weid= '{$_W['uniacid']}' order by displayorder asc");
		foreach ($advs as &$adv) {
			if (substr($adv['link'], 0, 5) != 'http:') {
				$adv['link'] = "http://" . $adv['link'];
			}
		}
		unset($adv);
		if (time() > strtotime($reply['endtime'])) {
			if (empty($reply['memo2'])) {
				$msg='对不起，活动已经于' . $reply['endtime'] . '结束，感谢您的参与！！！';
			} else {
				$msg=$reply['memo2'];
			}
			message($msg,$reply['url2'],'success');
		}
		if (time() < strtotime($reply['starttime'])) {
			if (empty($reply['memo1'])) {
				$msg='对不起，活动将于' . $reply['starttime'] . '开始，敬请期待！！！';
			} else {
				$msg=$reply['memo1'];
			}
			message($msg,$reply['url1'],'success');
		}	
		if (empty($_W['fans']['nickname'])) {
			mc_oauth_userinfo();
		}
		if ($reply['pictype1'] == 1) {
			if ((empty($_W['fans']['follow'])) || ($_W['fans']['follow'] == 0)){
				header("Location: " . $reply['urlx']); 
				exit;
			}
		}
		$weid=$_W['uniacid'];
		$from_user = $_W['fans']['openid'];
		$member = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_member') . " WHERE rid = :rid and from_user = :from_user ORDER BY `id` DESC", array(':rid' => $rid,':from_user' => $from_user));
		if (checksubmit('submit')) {
			if ($reply['is_thumb'] == 1) {
				$filePath = '../attachment/images/bm_movecar/';
				$time = date("y-m-d-H-i-s");
				$extend = strrchr($_FILES['doc']['name'], '.');
				$name = $time . $extend;
				$tmp_name = $_FILES['doc']['tmp_name'];
				if ($reply['is_qiniu'] == 1) {
					$ret_qiniu = $this->qiniu_upload($reply['qiniu_ak'],$reply['qiniu_sk'],$reply['qiniu_bt'],$tmp_name,$name);
					$uploadfile = $reply['qiniu_dm'] . $name;
				} else {
					$uploadfile = $filePath . $name;
					$result = move_uploaded_file($tmp_name, $uploadfile);
				}

			}
			$bindprovince=$_GPC['bindprovince'];
			$callcarNum=$_GPC['callcarNum'];
			$totel=$_GPC['totel'];			
			$verifycode=$_GPC['code'];			
			$thumb=$_GPC['thumb'];			
			$address=$_GPC['address'];			
			$userid=$_GPC['userid'];			
			if ($reply['is_sms'] == 1) {
				if ($reply['is_sms_move'] == 1) {
					if (($member['mobile'] != $totel)||($member['status_verify'] == 0)||(empty($member))) {
						if (($member['verifycode'] == $verifycode)&&(!empty($member['verifycode']))) {
							pdo_update('bm_movecar_member', array('status_verify'=>1), array('from_user' => $from_user));
						} else {
							$msg='对不起，请先验证您的手机号码后再提交挪车信息！';
							$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('home',array('rid' => $rid));
							message($msg,$urlrpt,'success');
						}
					}
				}
			}
			if ($reply['verify_type']==0) {
				$car = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and province = :province and upper(number) = :number and status=1 ORDER BY `id` DESC", array(':rid' => $rid,':province' => $bindprovince,':number' => strtoupper($callcarNum)));
			} elseif ($reply['verify_type']==1) {
				$car = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and userid = :userid and status=1 ORDER BY `id` DESC", array(':rid' => $rid,':userid' => $userid));
			} elseif ($reply['verify_type']==2) {
				$car = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and userid = :userid and province = :province and upper(number) = :number and status=1 ORDER BY `id` DESC", array(':rid' => $rid,':userid' => $userid,':province' => $bindprovince,':number' => strtoupper($callcarNum)));
			} elseif ($reply['verify_type']==3) {
				$car = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and ((userid = :userid and userid<>'') or (province = :province and upper(number) = :number) and province<>'' and number<>'') and status=1 ORDER BY `id` DESC", array(':rid' => $rid,':userid' => $userid,':province' => $bindprovince,':number' => strtoupper($callcarNum)));
			}
			if ($reply['int_times']>0) {
				if ($reply['verify_type']==0) {
					$movetimes = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('bm_movecar_moved') . " a inner join " . tablename('bm_movecar_carlist') . " b on a.rid=b.rid and a.carid=b.id WHERE a.from_user = :from_user and a.rid = :rid and b.province = :province and upper(b.number) = :number and date_format(FROM_UNIXTIME(a.time_call),'%Y-%m-%d') = curdate() ", array(':from_user' => $from_user,':rid' => $rid,':province' => $bindprovince,':number' => strtoupper($callcarNum)));
				} elseif ($reply['verify_type']==1) {
					$movetimes = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('bm_movecar_moved') . " a inner join " . tablename('bm_movecar_carlist') . " b on a.rid=b.rid and a.carid=b.id WHERE a.from_user = :from_user and a.rid = :rid and b.userid = :userid and date_format(FROM_UNIXTIME(a.time_call),'%Y-%m-%d') = curdate() ", array(':from_user' => $from_user,':rid' => $rid,':userid' => $userid));
				} elseif ($reply['verify_type']==2) {
					$movetimes = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('bm_movecar_moved') . " a inner join " . tablename('bm_movecar_carlist') . " b on a.rid=b.rid and a.carid=b.id WHERE a.from_user = :from_user and a.rid = :rid and b.userid = :userid and b.province = :province and upper(b.number) = :number and date_format(FROM_UNIXTIME(a.time_call),'%Y-%m-%d') = curdate() ", array(':from_user' => $from_user,':rid' => $rid,':userid' => $userid,':province' => $bindprovince,':number' => strtoupper($callcarNum)));
				} elseif ($reply['verify_type']==3) {
					$movetimes = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('bm_movecar_moved') . " a inner join " . tablename('bm_movecar_carlist') . " b on a.rid=b.rid and a.carid=b.id WHERE a.from_user = :from_user and a.rid = :rid and ((b.userid = :userid and b.userid<>'') or (b.province = :province and upper(b.number) = :number) and b.province<>'' and b.number<>'') and date_format(FROM_UNIXTIME(a.time_call),'%Y-%m-%d') = curdate() ", array(':from_user' => $from_user,':rid' => $rid,':userid' => $userid,':province' => $bindprovince,':number' => strtoupper($callcarNum)));
				}
				if ($reply['int_times']<=$movetimes) {
					$msg='对不起，您今天已经给这辆车发了'.$movetimes.'次挪车提示，请稍等车主联系您！';
					$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('home',array('rid' => $rid));
					message($msg,$urlrpt,'success');					
				}
			}
			if ($reply['int_minutes']>0) {
				$time=TIMESTAMP-$reply['int_minutes']*60;
				if ($reply['verify_type']==0) {
					$movetime = pdo_fetch("SELECT a.* FROM " . tablename('bm_movecar_moved') . " a inner join " . tablename('bm_movecar_carlist') . " b on a.rid=b.rid and a.carid=b.id WHERE a.from_user = :from_user and a.rid = :rid and b.province = :province and upper(b.number) = :number and a.time_call>:time ORDER BY a.id DESC", array(':from_user' => $from_user,':rid' => $rid,':time' => $time,':province' => $bindprovince,':number' => strtoupper($callcarNum)));
				} elseif ($reply['verify_type']==1) {
					$movetime = pdo_fetch("SELECT a.* FROM " . tablename('bm_movecar_moved') . " a inner join " . tablename('bm_movecar_carlist') . " b on a.rid=b.rid and a.carid=b.id WHERE a.from_user = :from_user and a.rid = :rid and b.userid = :userid and a.time_call>:time ORDER BY a.id DESC", array(':from_user' => $from_user,':rid' => $rid,':time' => $time,':userid' => $userid));
				} elseif ($reply['verify_type']==2) {
					$movetime = pdo_fetch("SELECT a.* FROM " . tablename('bm_movecar_moved') . " a inner join " . tablename('bm_movecar_carlist') . " b on a.rid=b.rid and a.carid=b.id WHERE a.from_user = :from_user and a.rid = :rid and b.userid = :userid and b.province = :province and upper(b.number) = :number and a.time_call>:time ORDER BY a.id DESC", array(':from_user' => $from_user,':rid' => $rid,':userid' => $userid,':time' => $time,':province' => $bindprovince,':number' => strtoupper($callcarNum)));
				} elseif ($reply['verify_type']==3) {
					$movetime = pdo_fetch("SELECT a.* FROM " . tablename('bm_movecar_moved') . " a inner join " . tablename('bm_movecar_carlist') . " b on a.rid=b.rid and a.carid=b.id WHERE a.from_user = :from_user and a.rid = :rid and ((b.userid = :userid and b.userid<>'') or (b.province = :province and upper(b.number) = :number) and b.province<>'' and b.number<>'') and a.time_call>:time ORDER BY a.id DESC", array(':from_user' => $from_user,':rid' => $rid,':userid' => $userid,':time' => $time,':province' => $bindprovince,':number' => strtoupper($callcarNum)));
				}
				if (!empty($movetime)) {
					$msg='对不起，您在'.$reply['int_minutes'].'分钟内刚向此车主发过挪车提示，请稍等车主联系您！';
					$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('home',array('rid' => $rid));
					message($msg,$urlrpt,'success');					
				}
			}
			if (!empty($car)) {
				$data = array(
					'rid' => $rid,
					'weid' => $weid,
					'carid' => $car['id'],
					'from_user' => $from_user,
					'username' => $_W['fans']['nickname'],
					'avatar' => $_W['fans']['tag']['avatar'],
					'mobile' => $totel,
					'status' => 1,
					'time_call' => TIMESTAMP,					
					'thumb' => $uploadfile,					
					'address' => $address,					
				);
				pdo_insert('bm_movecar_moved', $data);
				$mid = pdo_InsertId();
				if (empty($member)) {
					$mem = array(
						'rid' => $rid,
						'weid' => $weid,
						'from_user' => $from_user,
						'username' => $_W['fans']['nickname'],
						'avatar' => $_W['fans']['tag']['avatar'],
						'time_reg' => TIMESTAMP,
						'mobile' => $totel,
					);
					pdo_insert('bm_movecar_member', $mem);		
				} else {
					$mem = array(
						'username' => $_W['fans']['nickname'],
						'avatar' => $_W['fans']['tag']['avatar'],
						'time_reg' => TIMESTAMP,
						'mobile' => $totel,
					);
					pdo_update('bm_movecar_member', $mem, array('from_user' => $from_user));
				}
				if ($reply['is_call'] == 1) {
					$url = "http://we6.lionsoft.net.cn/app/index.php?i=1&c=entry&rid=85&do=call&m=bm_center";
					$ch = curl_init ();
					$package = array (
						'subAccountSid' => $reply['subAccountSid'],
						'subAccountToken' => $reply['subAccountToken'],
						'voIPAccount' => $reply['voIPAccount'],
						'voIPPassword' => $reply['voIPPassword'],
						'appId' => $reply['appId'],
						'serverIP' => $reply['serverIP'],
						'serverPort' => $reply['serverPort'],
						'from' => $data['mobile'],
						'to' => $car['mobile'],
					);
					curl_setopt ( $ch, CURLOPT_URL, $url );
					curl_setopt ( $ch, CURLOPT_POST, 1 );
					curl_setopt ( $ch, CURLOPT_HEADER, 0 );
					curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
					curl_setopt ( $ch, CURLOPT_POSTFIELDS, $package );
					$return = curl_exec ( $ch );
					curl_close ( $ch );
					$procResult=json_decode($return,true);
				}
				if ($reply['is_voice_move'] == 1) {
					if ($reply['is_lbs'] == 1) {
						$url = "http://we6.lionsoft.net.cn/app/index.php?i=1&c=entry&rid=85&do=dayuvoicelbs&m=bm_center";
						$ch = curl_init ();
						$number=$car['province'].$car['number'];
						$pos = strpos($data['address'], '市') + 3;
						$address = substr($data['address'], $pos);
						$package = array (
							'appkey' => $reply['appkey'],
							'secretKey' => $reply['secretKey'],
							'setExtend' => $reply['bm_movecar'],
							'time' => date("H点i分" , time()),
							'name' => $car['title'],
							'tel' => $data['mobile'],
							'number' => $number,
							'setCalledNum' => $car['mobile'],
							'setCalledShowNum' => $reply['voicenumber'],
							'setTtsCode' => $reply['voice_move'],
							'addr' => $address,
						);
						curl_setopt ( $ch, CURLOPT_URL, $url );
						curl_setopt ( $ch, CURLOPT_POST, 1 );
						curl_setopt ( $ch, CURLOPT_HEADER, 0 );
						curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
						curl_setopt ( $ch, CURLOPT_POSTFIELDS, $package );
						$return = curl_exec ( $ch );
						curl_close ( $ch );
						$procResult=json_decode($return,true);
					} else {
						$url = "http://we6.lionsoft.net.cn/app/index.php?i=1&c=entry&rid=85&do=dayuvoice&m=bm_center";
						$ch = curl_init ();
						$number=$car['province'].$car['number'];
						$package = array (
							'appkey' => $reply['appkey'],
							'secretKey' => $reply['secretKey'],
							'setExtend' => $reply['bm_movecar'],
							'time' => date("H点i分" , time()),
							'name' => $car['title'],
							'tel' => $data['mobile'],
							'number' => $number,
							'setCalledNum' => $car['mobile'],
							'setCalledShowNum' => $reply['voicenumber'],
							'setTtsCode' => $reply['voice_move'],
						);
						curl_setopt ( $ch, CURLOPT_URL, $url );
						curl_setopt ( $ch, CURLOPT_POST, 1 );
						curl_setopt ( $ch, CURLOPT_HEADER, 0 );
						curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
						curl_setopt ( $ch, CURLOPT_POSTFIELDS, $package );
						$return = curl_exec ( $ch );
						curl_close ( $ch );
						$procResult=json_decode($return,true);
					}
				}
				if ($reply['is_sms'] == 1) {
					if ($reply['smstype'] == 0) {
						if ($reply['is_lbs'] == 1) {
							$uid=$reply['corpid'];
							$passwd=$reply['pwd'];
							$num=$car['mobile'];
							$message=$car['title'].'您好，'.date("Y-m-d H:i" , time()).'有手机号'.$data['mobile'].'反应您的爱车'.$car['province'].$car['number'].'位于'.$data['address'].'妨碍道路通行了！';
							header("Content-type: text/html; charset=utf-8");
							date_default_timezone_set('PRC'); //设置默认时区为北京时间
							$msg = rawurlencode(mb_convert_encoding($message, "gb2312", "utf-8"));
							$gateway = "http://inolink.com/WS/BatchSend2.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$num}&Content={$msg}&Cell=&SendTime=";
							$result = file_get_contents($gateway);					
						} else {
							$uid=$reply['corpid'];
							$passwd=$reply['pwd'];
							$num=$car['mobile'];
							$message=$car['title'].'您好，'.date("Y-m-d H:i" , time()).'有手机号'.$data['mobile'].'反应您的爱车'.$car['province'].$car['number'].'妨碍道路通行了！';
							header("Content-type: text/html; charset=utf-8");
							date_default_timezone_set('PRC'); //设置默认时区为北京时间
							$msg = rawurlencode(mb_convert_encoding($message, "gb2312", "utf-8"));
							$gateway = "http://inolink.com/WS/BatchSend2.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$num}&Content={$msg}&Cell=&SendTime=";
							$result = file_get_contents($gateway);					
						}
					} else {
						if ($reply['is_lbs'] == 1) {
							$url = "http://we6.lionsoft.net.cn/app/index.php?i=1&c=entry&rid=85&do=dayusmslbs&m=bm_center";
							$ch = curl_init ();
							$pos = strpos($data['address'], '市') + 3;
							$address = substr($data['address'], $pos);							
							$package = array (
								'appkey' => $reply['appkey'],
								'secretKey' => $reply['secretKey'],
								'setExtend' => $reply['bm_movecar'],
								'time' => date("H点i分" , time()),
								'name' => $car['title'],
								'tel' => $data['mobile'],
								'number' => $number,
								'setRecNum' => $car['mobile'],
								'setSmsTemplateCode' => $reply['smstemplate'],
								'setSmsFreeSignName' => $reply['smssignname'],
								'addr' => $address,
							);
							curl_setopt ( $ch, CURLOPT_URL, $url );
							curl_setopt ( $ch, CURLOPT_POST, 1 );
							curl_setopt ( $ch, CURLOPT_HEADER, 0 );
							curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
							curl_setopt ( $ch, CURLOPT_POSTFIELDS, $package );
							$return = curl_exec ( $ch );
							curl_close ( $ch );
							$procResult=json_decode($return,true);	
						} else {
							$url = "http://we6.lionsoft.net.cn/app/index.php?i=1&c=entry&rid=85&do=dayusms&m=bm_center";
							$ch = curl_init ();
							$package = array (
								'appkey' => $reply['appkey'],
								'secretKey' => $reply['secretKey'],
								'setExtend' => $reply['bm_movecar'],
								'time' => date("H点i分" , time()),
								'name' => $car['title'],
								'tel' => $data['mobile'],
								'number' => $number,
								'setRecNum' => $car['mobile'],
								'setSmsTemplateCode' => $reply['smstemplate'],
								'setSmsFreeSignName' => $reply['smssignname'],
							);
							curl_setopt ( $ch, CURLOPT_URL, $url );
							curl_setopt ( $ch, CURLOPT_POST, 1 );
							curl_setopt ( $ch, CURLOPT_HEADER, 0 );
							curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
							curl_setopt ( $ch, CURLOPT_POSTFIELDS, $package );
							$return = curl_exec ( $ch );
							curl_close ( $ch );
							$procResult=json_decode($return,true);						
						}
					}
				}
				if ($reply['is_name'] == 1) {
					$title=$reply['storename'];
				} else {
					$title=$_W['account']['name'];
				}
				$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('movecar',array('rid' => $rid,'id' => $mid));
				$template = array('touser' => $reply['openid'],
								'template_id' => $reply['templateid'],
								'url' => $urlrpt,
								'topcolor' => "#7B68EE",
								'data' => array('first'	=> array('value' => urlencode($title.'有客户提交挪车请求！'),
																 'color' => "#743A3A",
																  ),
											  'keyword1' => array('value' => urlencode('挪车呼叫'),
																 'color' => "#FF0000",
																  ),
											  'keyword2' 	=> array('value' => urlencode($car['province'].$car['number']),
																 'color' => "#0000FF",
																  ),
											  'keyword3' 	=> array('value' => urlencode(date('Y-m-d H:i:s',time())),
																 'color' => "#0000FF",
																  ),
											  'keyword4' 	=> array('value' => urlencode('客户电话：'.$data['mobile'].',车主称呼：'.$car['title'].'，车主电话：'.$car['mobile']),
																 'color' => "#0000FF",
																  ),															  
											  'remark' 	=> array('value' => urlencode("挪车请求信息已登记！"),
																 'color' => "#008000",
																  ),
											  )
								);
				$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid';
				$row = pdo_fetch($sql, array(':uniacid' => $reply['weid']));
				$appid = $row['key'];
				$appsecret = $row['secret'];
				$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
				$res = $this->http_request($url);
				$result = json_decode($res, true);
				$access_token = $result["access_token"];
				$lasttime = time();
				$x=$this->send_template_message(urldecode(json_encode($template)),$access_token);
				$template = array('touser' => $data['from_user'],
								'template_id' => $reply['templateid'],
								'url' => $urlrpt,
								'topcolor' => "#7B68EE",
								'data' => array('first'	=> array('value' => urlencode('感谢您使用'.$title.'呼叫挪车！'),
																 'color' => "#743A3A",
																  ),
											  'keyword1' => array('value' => urlencode('挪车呼叫'),
																 'color' => "#FF0000",
																  ),
											  'keyword2' 	=> array('value' => urlencode($car['province'].$car['number']),
																 'color' => "#0000FF",
																  ),
											  'keyword3' 	=> array('value' => urlencode(date('Y-m-d H:i:s',time())),
																 'color' => "#0000FF",
																  ),
											  'keyword4' 	=> array('value' => urlencode('您的电话：'.$data['mobile']),
																 'color' => "#0000FF",
																  ),															  
											  'remark' 	=> array('value' => urlencode("您的挪车信息已发送给车主！"),
																 'color' => "#008000",
																  ),
											  )
								);
				$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
				$res = $this->http_request($url);
				$result = json_decode($res, true);
				$access_token = $result["access_token"];
				$moved = time();
				$x=$this->send_template_message(urldecode(json_encode($template)),$access_token);	

				$template = array('touser' => $car['from_user'],
								'template_id' => $reply['templateid'],
								'url' => $urlrpt,
								'topcolor' => "#7B68EE",
								'data' => array('first'	=> array('value' => urlencode('感谢您使用'.$title.'扫码挪车！'),
																 'color' => "#743A3A",
																  ),
											  'keyword1' => array('value' => urlencode('挪车呼叫'),
																 'color' => "#FF0000",
																  ),
											  'keyword2' 	=> array('value' => urlencode($car['province'].$car['number']),
																 'color' => "#0000FF",
																  ),
											  'keyword3' 	=> array('value' => urlencode(date('Y-m-d H:i:s',time())),
																 'color' => "#0000FF",
																  ),
											  'keyword4' 	=> array('value' => urlencode('对方电话：'.$data['mobile']),
																 'color' => "#0000FF",
																  ),															  
											  'remark' 	=> array('value' => urlencode("烦请您尽快挪车，谢谢！"),
																 'color' => "#008000",
																  ),
											  )
								);
				$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
				$res = $this->http_request($url);
				$result = json_decode($res, true);
				$access_token = $result["access_token"];
				$lasttime = time();
				$x=$this->send_template_message(urldecode(json_encode($template)),$access_token);
				message("已经向车主发送挪车通知，请稍后！",$reply['urly'],'success');
			} else {
				if ($reply['verify_type']==0) {
					message("平台无车牌为".$bindprovince.$callcarNum."的车辆记录，请核实车辆信息后重新提交，谢谢！",$reply['urly'],'success');
				} elseif ($reply['verify_type']==1) {
					message("平台无编号为".$userid."的车辆记录，请核实车辆信息后重新提交，谢谢！",$reply['urly'],'success');
				} elseif ($reply['verify_type']==2) {
					message("平台无车牌为".$bindprovince.$callcarNum."、编号为".$userid."的车辆记录，请核实车辆信息后重新提交，谢谢！",$reply['urly'],'success');
				} elseif ($reply['verify_type']==3) {
					message("未找到您提交的车辆信息，请核实车辆信息后重新提交，谢谢！",$reply['urly'],'success');
				}				
			}
		}
		if (!empty($reply['picurl'])){
			$qrpicurl = $_W['attachurl'] . $reply['picurl'];
		} else {
			$qrpicurl = $_W['attachurl'] . $reply['qrcode'];
		}		
		include $this->template('home');
	}
	
	public function doMobileMycar() {
		global $_W,$_GPC;
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
			message('非法访问，请通过微信打开！');
			die();
        }
		$rid = trim($_GPC['rid']);
		$reply = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$advs = pdo_fetchall("select * from " . tablename('bm_movecar_adv') . " where enabled=1 and weid= '{$_W['uniacid']}' order by displayorder asc");
		foreach ($advs as &$adv) {
			if (substr($adv['link'], 0, 5) != 'http:') {
				$adv['link'] = "http://" . $adv['link'];
			}
		}
		unset($adv);
		if (time() > strtotime($reply['endtime'])) {
			if (empty($reply['memo2'])) {
				$msg='对不起，活动已经于' . $reply['endtime'] . '结束，感谢您的参与！！！';
			} else {
				$msg=$reply['memo2'];
			}
			message($msg,$reply['url2'],'success');
		}
		if (time() < strtotime($reply['starttime'])) {
			if (empty($reply['memo1'])) {
				$msg='对不起，活动将于' . $reply['starttime'] . '开始，敬请期待！！！';
			} else {
				$msg=$reply['memo1'];
			}
			message($msg,$reply['url1'],'success');
		}	
		if (empty($_W['fans']['nickname'])) {
			mc_oauth_userinfo();
		}
		if ($reply['pictype'] == 1) {
			if ((empty($_W['fans']['follow'])) || ($_W['fans']['follow'] == 0)){
				//print_r($reply['urlx']);
				//header("Location: " . $reply['urlx']); 
				//确保重定向后，后续代码不会被执行 
				//exit;
			}
		}
		$weid=$_W['uniacid'];
		$from_user = $_W['fans']['openid'];
		if ($_GPC['op'] == 'delete') {
			pdo_delete('bm_movecar_carlist',array("id" => intval($_GPC['id']),"rid" => intval($_GPC['rid'])));
			message('车辆已经取消绑定！',$reply['urly'],'success');
		}
		$list = pdo_fetchall("SELECT * FROM ".tablename('bm_movecar_carlist')." WHERE rid = '$rid' and from_user = '$from_user' ORDER BY id DESC");
		include $this->template('mycar');
	}
	
	public function doMobileVerifycar() {
		global $_W,$_GPC;
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
			message('非法访问，请通过微信打开！');
			die();
        }
		$rid = trim($_GPC['rid']);
		$carid = trim($_GPC['carid']);
		$op = trim($_GPC['op']);
		$status = trim($_GPC['status']);
		$reply = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$advs = pdo_fetchall("select * from " . tablename('bm_movecar_adv') . " where enabled=1 and weid= '{$_W['uniacid']}' order by displayorder asc");
		foreach ($advs as &$adv) {
			if (substr($adv['link'], 0, 5) != 'http:') {
				$adv['link'] = "http://" . $adv['link'];
			}
		}
		unset($adv);
		if (time() > strtotime($reply['endtime'])) {
			if (empty($reply['memo2'])) {
				$msg='对不起，活动已经于' . $reply['endtime'] . '结束，感谢您的参与！！！';
			} else {
				$msg=$reply['memo2'];
			}
			message($msg,$reply['url2'],'success');
		}
		if (time() < strtotime($reply['starttime'])) {
			if (empty($reply['memo1'])) {
				$msg='对不起，活动将于' . $reply['starttime'] . '开始，敬请期待！！！';
			} else {
				$msg=$reply['memo1'];
			}
			message($msg,$reply['url1'],'success');
		}	
		if (empty($_W['fans']['nickname'])) {
			mc_oauth_userinfo();
		}
		if ($reply['pictype'] == 1) {
			if ((empty($_W['fans']['follow'])) || ($_W['fans']['follow'] == 0)){
				//print_r($reply['urlx']);
				//header("Location: " . $reply['urlx']); 
				//确保重定向后，后续代码不会被执行 
				//exit;
			}
		}
		$weid=$_W['uniacid'];
		$from_user = $_W['fans']['openid'];
		$car = pdo_fetch("SELECT * FROM ".tablename('bm_movecar_carlist')." WHERE rid = '$rid' and id = '$carid'");
		if (($from_user == $reply['openid'])&&(!empty($reply['openid']))) {
			if (empty($car)) {
				$urly=$_W['siteroot'].'app/'.$this->createMobileUrl('home',array('rid' => $rid));
				message('无此车辆登记信息！',$urly,'info');
			}
			if (($op=='check')&&($status='1')) {
				pdo_update('bm_movecar_carlist',array("status" => 1),array("id" => $carid));
				if ($reply['is_name'] == 1) {
					$title=$reply['storename'];
				} else {
					$title=$_W['account']['name'];
				}
				$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('mycar',array('rid' => $rid));
				$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid';
				$row = pdo_fetch($sql, array(':uniacid' => $reply['weid']));
				$appid = $row['key'];
				$appsecret = $row['secret'];
				$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
				$res = $this->http_request($url);
				$result = json_decode($res, true);
				$access_token = $result["access_token"];
				$template = array('touser' => $car['from_user'],
								'template_id' => $reply['templateid'],
								'url' => $urlrpt,
								'topcolor' => "#7B68EE",
								'data' => array('first'	=> array('value' => urlencode('感谢您使用'.$title.'扫码挪车！'),
																 'color' => "#743A3A",
																  ),
											  'keyword1' => array('value' => urlencode('车辆登记审核'),
																 'color' => "#FF0000",
																  ),
											  'keyword2' 	=> array('value' => urlencode($data['province'].$data['number']),
																 'color' => "#0000FF",
																  ),
											  'keyword3' 	=> array('value' => urlencode(date('Y-m-d H:i:s',time())),
																 'color' => "#0000FF",
																  ),
											  'keyword4' 	=> array('value' => urlencode('审核结果：已通过'),
																 'color' => "#0000FF",
																  ),															  
											  'remark' 	=> array('value' => urlencode("状态已更新！"),
																 'color' => "#008000",
																  ),
											  )
								);
				$x=$this->send_template_message(urldecode(json_encode($template)),$access_token);
				$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('verifycar',array('rid' => $rid,'carid'=>$carid));
				message('车辆已信息审核通过！',$urlrpt,'success');
			}
		} else {
			$urly=$_W['siteroot'].'app/'.$this->createMobileUrl('home',array('rid' => $rid));
			message('请联系管理员授权！',$urly,'info');
		}
		include $this->template('verifycar');
	}

	public function doMobileMovecar() {
		global $_W,$_GPC;
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
			message('非法访问，请通过微信打开！');
			die();
        }
		$rid = trim($_GPC['rid']);
		$id = trim($_GPC['id']);
		$reply = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$advs = pdo_fetchall("select * from " . tablename('bm_movecar_adv') . " where enabled=1 and weid= '{$_W['uniacid']}' order by displayorder asc");
		foreach ($advs as &$adv) {
			if (substr($adv['link'], 0, 5) != 'http:') {
				$adv['link'] = "http://" . $adv['link'];
			}
		}
		unset($adv);		
		if (time() > strtotime($reply['endtime'])) {
			if (empty($reply['memo2'])) {
				$msg='对不起，活动已经于' . $reply['endtime'] . '结束，感谢您的参与！！！';
			} else {
				$msg=$reply['memo2'];
			}
			message($msg,$reply['url2'],'success');
		}
		if (time() < strtotime($reply['starttime'])) {
			if (empty($reply['memo1'])) {
				$msg='对不起，活动将于' . $reply['starttime'] . '开始，敬请期待！！！';
			} else {
				$msg=$reply['memo1'];
			}
			message($msg,$reply['url1'],'success');
		}	
		if (empty($_W['fans']['nickname'])) {
			mc_oauth_userinfo();
		}
		if ($reply['pictype'] == 1) {
			if ((empty($_W['fans']['follow'])) || ($_W['fans']['follow'] == 0)){
				//print_r($reply['urlx']);
				//header("Location: " . $reply['urlx']); 
				//确保重定向后，后续代码不会被执行 
				//exit;
			}
		}
		$weid=$_W['uniacid'];
		$from_user = $_W['fans']['openid'];
		if (!empty($id)) {
			$row = pdo_fetch("SELECT a.*,b.province,b.number,b.from_user as fromuser FROM ".tablename('bm_movecar_moved')." a inner join ".tablename('bm_movecar_carlist')." b on a.carid=b.id WHERE a.rid = '$rid' and a.id='$id' ORDER BY id DESC");
			if (($row['fromuser']!=$from_user)&&($row['fromuser']!=$from_user)&&($row['fromuser']==$from_user)) {
				message('对不起，此条挪车记录似乎与您无关，如有疑问请联系管理员！',$reply['urly'],'success');
			}
		} else {
			$rows = pdo_fetchall("SELECT a.*,b.province,b.number,b.from_user as fromuser FROM ".tablename('bm_movecar_moved')." a inner join ".tablename('bm_movecar_carlist')." b on a.carid=b.id WHERE a.rid = '$rid' and b.from_user='$from_user' ORDER BY id DESC");
		}			
		include $this->template('movecar');
	}

	public function doMobileVerifycode() {
		global $_W,$_GPC;
		$mobile = $_GPC['mobile'];
		$type = $_GPC['type'];
		$rid = $_GPC['rid'];
		$from_user = urldecode($_GPC['from_user']);
		$code= random(6,1);
		$reply = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		$member = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_member') . " WHERE rid = :rid and from_user = :from_user ORDER BY `id` DESC", array(':rid' => $rid,':from_user' => $from_user));		
		if (empty($member)) {
			$mem = array(
				'rid' => $rid,
				'weid' => $reply['weid'],
				'from_user' => $from_user,
				'time_verify' => TIMESTAMP,
				'mobile' => $mobile,
				'status_verify' => 0,
				'verifycode' => $code,
			);
			pdo_insert('bm_movecar_member', $mem);		
		} else {
			$mem = array(
				'time_verify' => TIMESTAMP,
				'mobile' => $mobile,
				'status_verify' => 0,
				'verifycode' => $code,
			);
			pdo_update('bm_movecar_member', $mem, array('from_user' => $from_user));
		}
		$member = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_member') . " WHERE rid = :rid and from_user = :from_user ORDER BY `id` DESC", array(':rid' => $rid,':from_user' => $from_user));
		if ((empty($member))||(empty($member['verifycode']))||($member['mobile']!=$mobile)||($member['status_verify']==0)) {
			if ($reply['is_sms'] == 1) {
				if ($reply['smstype'] == 0) {	
					$uid=$reply['corpid'];
					$passwd=$reply['pwd'];
					$message='您的验证码是：'.$code.'，　请不要将验证码提供给其他人！';
					header("Content-type: text/html; charset=utf-8");
					date_default_timezone_set('PRC'); //设置默认时区为北京时间
					$msg = rawurlencode(mb_convert_encoding($message, "gb2312", "utf-8"));
					$gateway = "http://inolink.com/WS/BatchSend2.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$mobile}&Content={$msg}&Cell=&SendTime=";
					$result = file_get_contents($gateway);
					if ($result>1) {
						$result=999;
					} else {
						$result='xxx';
					}
				} else {
					$url = "http://we6.lionsoft.net.cn/app/index.php?i=1&c=entry&rid=85&do=dayuverify&m=bm_center";
					$ch = curl_init ();
					$package = array (
						'appkey' => $reply['appkey'],
						'secretKey' => $reply['secretKey'],
						'setExtend' => $reply['bm_movecar'],
						'code' => $code,
						'product' => '扫码挪车手机号',
						'setRecNum' => $mobile,
						'setSmsTemplateCode' => $reply['sms_car'],
						'setSmsFreeSignName' => $reply['sms_car_sign'],
					);
					curl_setopt ( $ch, CURLOPT_URL, $url );
					curl_setopt ( $ch, CURLOPT_POST, 1 );
					curl_setopt ( $ch, CURLOPT_HEADER, 0 );
					curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
					curl_setopt ( $ch, CURLOPT_POSTFIELDS, $package );
					$procResult = curl_exec ( $ch );
					curl_close ( $ch );
					$result=json_decode($procResult,true);
					$filename = '../addons/bm_movecar/verify.txt';
				}
			}	
		} else {
			$result ='xxx';
		}
		die(json_encode(array('message'=>$result)));
	}
	
	public function doMobileBindcar() {
		global $_W,$_GPC;
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
			message('非法访问，请通过微信打开！');
			die();
        }
		$rid = trim($_GPC['rid']);
		$reply = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		if (time() > strtotime($reply['endtime'])) {
			if (empty($reply['memo2'])) {
				$msg='对不起，活动已经于' . $reply['endtime'] . '结束，感谢您的参与！！！';
			} else {
				$msg=$reply['memo2'];
			}
			message($msg,$reply['url2'],'success');
		}
		if (time() < strtotime($reply['starttime'])) {
			if (empty($reply['memo1'])) {
				$msg='对不起，活动将于' . $reply['starttime'] . '开始，敬请期待！！！';
			} else {
				$msg=$reply['memo1'];
			}
			message($msg,$reply['url1'],'success');
		}	
		if (empty($_W['fans']['nickname'])) {
			mc_oauth_userinfo();
		}
		if ($reply['pictype'] == 1) {
			if ((empty($_W['fans']['follow'])) || ($_W['fans']['follow'] == 0)){
				header("Location: " . $reply['urlx']); 
				exit;
			}
		}
		$weid=$_W['uniacid'];
		$from_user = $_W['fans']['openid'];
		$member = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_member') . " WHERE rid = :rid and from_user = :from_user ORDER BY `id` DESC", array(':rid' => $rid,':from_user' => $from_user));
		if (empty($_GPC['car_code'])) {
			$car_code=mt_rand(100000,999999);
			$carx = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and userid = :userid ORDER BY `id` DESC", array(':rid' => $rid,':userid' => $userid));
			while (!empty($carx)) {
				$car_code=mt_rand(100000,999999);
				$carx = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and userid = :userid ORDER BY `id` DESC", array(':rid' => $rid,':userid' => $userid));
			}
		}
		if (checksubmit('submit')) {
			if (empty($_GPC['car_code'])) {
				$userid=mt_rand(100000,999999);
				$carx = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and userid = :userid ORDER BY `id` DESC", array(':rid' => $rid,':userid' => $userid));
				while (!empty($carx)) {
					$userid=mt_rand(100000,999999);
					$carx = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and userid = :userid ORDER BY `id` DESC", array(':rid' => $rid,':userid' => $userid));
				}
			} else {
				$userid=$_GPC['car_code'];
			}
			if (!empty($reply['car_enable'])) {
				$car_enable=$reply['car_enable'];
				$car_binded = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and from_user = :from_user ", array(':rid' => $rid,':from_user' => $from_user));
				if ($car_binded>=$car_enable) {
					$msg='对不起，您已经在平台绑定了'.$car_binded.'个车牌，不可以再增加！';
					$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('mycar',array('rid' => $rid));
					message($msg,$urlrpt,'success');		
				}
			}
			$bindtruename=$_GPC['bindtruename'];
			$bindtel=$_GPC['bindtel'];
			$bindprovince=$_GPC['bindprovince'];
			$bindcarNum=$_GPC['bindcarNum'];
			$verifycode=$_GPC['verifycode'];
			$car = pdo_fetch("SELECT * FROM " . tablename('bm_movecar_carlist') . " WHERE rid = :rid and province = :province and upper(number) = :number ORDER BY `id` DESC", array(':rid' => $rid,':province' => $bindprovince,':number' => strtoupper($bindcarNum)));
			if ($reply['is_sms'] == 1) {
				if ($reply['is_sms_car'] == 1) {
					if (($member['mobile'] != $bindtel)||($member['status_verify'] == 0)||(empty($member))) {
						if (($member['verifycode'] == $verifycode)&&(!empty($member['verifycode']))) {
							pdo_update('bm_movecar_member', array('status_verify'=>1), array('from_user' => $from_user));
						} else {
							$msg='对不起，请先验证您的手机号码后再提交挪车信息！';
							$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('bindcar',array('rid' => $rid));
							message($msg,$urlrpt,'success');
						}
					}
				}
			}
			if (empty($car)) {
				if ($reply['is_check']==1) {
					$data = array(
						'rid' => $rid,
						'weid' => $weid,
						'from_user' => $from_user,
						'username' => $_W['fans']['nickname'],
						'avatar' => $_W['fans']['tag']['avatar'],
						'time_reg' => TIMESTAMP,					
						'province' => $bindprovince,
						'number' => $bindcarNum,
						'title' => $bindtruename,
						'mobile' => $bindtel,
						'status' => 0,
						'userid' => $userid,
					);					
				} else {
					$data = array(
						'rid' => $rid,
						'weid' => $weid,
						'from_user' => $from_user,
						'username' => $_W['fans']['nickname'],
						'avatar' => $_W['fans']['tag']['avatar'],
						'time_reg' => TIMESTAMP,					
						'province' => $bindprovince,
						'number' => $bindcarNum,
						'title' => $bindtruename,
						'mobile' => $bindtel,
						'status' => 1,
						'userid' => $userid,
					);					
				}
				pdo_insert('bm_movecar_carlist', $data);
				$carid = pdo_insertid();
				if (empty($member)) {
					$mem = array(
						'rid' => $rid,
						'weid' => $weid,
						'from_user' => $from_user,
						'username' => $_W['fans']['nickname'],
						'avatar' => $_W['fans']['tag']['avatar'],
						'time_reg' => TIMESTAMP,
						'title' => $bindtruename,
						'mobile' => $bindtel,
					);
					pdo_insert('bm_movecar_member', $mem);		
				} else {
					$mem = array(
						'username' => $_W['fans']['nickname'],
						'avatar' => $_W['fans']['tag']['avatar'],
						'time_reg' => TIMESTAMP,
						'title' => $bindtruename,
						'mobile' => $bindtel,
					);
					pdo_update('bm_movecar_member', $mem, array('from_user' => $from_user));
				}			
				if ($reply['is_name'] == 1) {
					$title=$reply['storename'];
				} else {
					$title=$_W['account']['name'];
				}
				$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('verifycar',array('rid' => $rid,'carid'=>$carid));
				$template = array('touser' => $reply['openid'],
								'template_id' => $reply['templateid'],
								'url' => $urlrpt,
								'topcolor' => "#7B68EE",
								'data' => array('first'	=> array('value' => urlencode($title.'有客户提交车辆登记！'),
																 'color' => "#743A3A",
																  ),
											  'keyword1' => array('value' => urlencode('车辆登记'),
																 'color' => "#FF0000",
																  ),
											  'keyword2' 	=> array('value' => urlencode($data['province'].$data['number']),
																 'color' => "#0000FF",
																  ),
											  'keyword3' 	=> array('value' => urlencode(date('Y-m-d H:i:s',time())),
																 'color' => "#0000FF",
																  ),
											  'keyword4' 	=> array('value' => urlencode('客户称呼：'.$data['title'].'，客户电话：'.$data['mobile']),
																 'color' => "#0000FF",
																  ),															  
											  'remark' 	=> array('value' => urlencode("信息已登记！"),
																 'color' => "#008000",
																  ),
											  )
								);
				$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid';
				$row = pdo_fetch($sql, array(':uniacid' => $reply['weid']));
				$appid = $row['key'];
				$appsecret = $row['secret'];
				$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
				$res = $this->http_request($url);
				$result = json_decode($res, true);
				$access_token = $result["access_token"];
				$x=$this->send_template_message(urldecode(json_encode($template)),$access_token);
				$urlrpt=$_W['siteroot'].'app/'.$this->createMobileUrl('mycar',array('rid' => $rid));
				$template = array('touser' => $data['from_user'],
								'template_id' => $reply['templateid'],
								'url' => $urlrpt,
								'topcolor' => "#7B68EE",
								'data' => array('first'	=> array('value' => urlencode('感谢您使用'.$title.'登记信息！'),
																 'color' => "#743A3A",
																  ),
											  'keyword1' => array('value' => urlencode('车辆登记'),
																 'color' => "#FF0000",
																  ),
											  'keyword2' 	=> array('value' => urlencode($data['province'].$data['number']),
																 'color' => "#0000FF",
																  ),
											  'keyword3' 	=> array('value' => urlencode(date('Y-m-d H:i:s',time())),
																 'color' => "#0000FF",
																  ),
											  'keyword4' 	=> array('value' => urlencode('客户称呼：'.$data['title'].'，客户电话：'.$data['mobile']),
																 'color' => "#0000FF",
																  ),															  
											  'remark' 	=> array('value' => urlencode("您的信息已登记！"),
																 'color' => "#008000",
																  ),
											  )
								);
				$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
				$res = $this->http_request($url);
				$result = json_decode($res, true);
				$access_token = $result["access_token"];
				$lasttime = time();
				$x=$this->send_template_message(urldecode(json_encode($template)),$access_token);								
				//message("车辆已经完成登记，您可以使用我们的二维码了，谢谢！",$reply['urly'],'success');
				if (($reply['verify_type']==1)||($reply['verify_type']==2)||($reply['verify_type']==3)) {
					if ($reply['is_voice_move'] == 1) {
						if ($reply['is_check'] == 1) {
							message("车辆信息审核中！请保存我们的挪车语音通知电话号码【".$reply['voicenumber']."】设置，您的车辆识别码是【".$userid."】，您可以使用我们的二维码了，谢谢！",$reply['urly'],'success');
						} else {
							message("车辆已经完成登记！请保存我们的挪车语音通知电话号码【".$reply['voicenumber']."】设置，您的车辆识别码是【".$userid."】，您可以使用我们的二维码了，谢谢！",$reply['urly'],'success');
						}
					} else {
						if ($reply['is_check'] == 1) {
							message("车辆信息审核中！您的车辆识别码是【".$userid."】，您可以使用我们的二维码了，谢谢！",$reply['urly'],'success');
						} else {
							message("车辆已经完成登记，您的车辆识别码是【".$userid."】，您可以使用我们的二维码了，谢谢！",$reply['urly'],'success');
						}
					}
				} else {
					if ($reply['is_voice_move'] == 1) {
						if ($reply['is_check'] == 1) {
							message("车辆信息审核中！请保存我们的挪车语音通知电话号码【".$reply['voicenumber']."】，您可以使用我们的二维码了，谢谢！",$reply['urly'],'success');
						} else {
							message("车辆已经完成登记！请保存我们的挪车语音通知电话号码【".$reply['voicenumber']."】，您可以使用我们的二维码了，谢谢！",$reply['urly'],'success');
						}						
					} else {
						if ($reply['is_check'] == 1) {
							message("车辆信息审核中！您可以使用我们的二维码了，谢谢！",$reply['urly'],'success');
						} else {
							message("车辆已经完成登记，您可以使用我们的二维码了，谢谢！",$reply['urly'],'success');
						}						
					}
				}				
			} else {
				message("此车已经登记过，不能重复登记，谢谢！",$reply['urly'],'success');
			}
		}
		if (!empty($reply['picurl'])){
			$qrpicurl = $_W['attachurl'] . $reply['picurl'];
		} else {
			$qrpicurl = $_W['attachurl'] . $reply['qrcode'];
		}		
		include $this->template('bindcar');
	}
}