<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
global $_W;
global $_GPC;
$op = $operation = (($_GPC['op'] ? $_GPC['op'] : 'display'));
$id = intval($_GPC['id']);
$profile = m('member')->getMember($id);
if ($op == 'credit1') 
{
	ca('finance.recharge.credit1');
	if ($_W['ispost']) 
	{
		m('member')->setCredit($profile['openid'], 'credit1', $_GPC['num'], array($_W['uid'], '后台会员充值积分'));
		plog('finance.recharge.credit1', '积分充值 充值积分: ' . $_GPC['num'] . ' <br/>会员信息: ID: ' . $profile['id'] . ' /  ' . $profile['openid'] . '/' . $profile['nickname'] . '/' . $profile['realname'] . '/' . $profile['mobile']);
		$msg = array( 'first' => array('value' => '后台会员充值积分！', 'color' => '#4a5077'), 'keyword1' => array('title' => '积分充值', 'value' => '后台会员充值积分:' . $_GPC['num'] . '积分!', 'color' => '#4a5077'), 'remark' => array('value' => "\r\n" . '我们已为您充值积分，请您登录个人中心查看。', 'color' => '#4a5077') );
		$detailurl = $this->createMobileUrl('member');
		m('message')->sendCustomNotice($profile['openid'], $msg, $detailurl);
		message('充值成功!', referer(), 'success');
	}
	$profile['credit1'] = m('member')->getCredit($profile['openid'], 'credit1');
}
else if ($op == 'credit2') 
{
	ca('finance.recharge.credit2');
	if ($_W['ispost']) 
	{
		m('member')->setCredit($profile['openid'], 'credit2', $_GPC['num'], array($_W['uid'], '后台会员充值余额'));
		$set = m('common')->getSysset('shop');
		$logno = m('common')->createNO('member_log', 'logno', 'RC');
		$data = array('openid' => $profile['openid'], 'logno' => $logno, 'uniacid' => $_W['uniacid'], 'type' => '0', 'createtime' => TIMESTAMP, 'status' => '1', 'title' => $set['name'] . '会员充值', 'money' => $_GPC['num'], 'rechargetype' => 'system');
		pdo_insert('sz_yi_member_log', $data);
		$logid = pdo_insertid();
		m('member')->setRechargeCredit($openid, $log['money']);
		if (p('sale')) 
		{
			$data['id'] = $logid;
			p('sale')->setRechargeActivity($data);
		}
		if (0 < floatval($_GPC['num'])) 
		{
			m('notice')->sendMemberLogMessage($logid);
		}
		plog('finance.recharge.credit2', '余额充值 充值金额: ' . $_GPC['num'] . ' <br/>会员信息:  ID: ' . $profile['id'] . ' / ' . $profile['openid'] . '/' . $profile['nickname'] . '/' . $profile['realname'] . '/' . $profile['mobile']);
		message('充值成功!', referer(), 'success');
	}
	$set = m('common')->getSysset();
	$profile['credit2'] = m('member')->getCredit($profile['openid'], 'credit2');
}
load()->func('tpl');
include $this->template('web/finance/recharge');
function writelog($str, $title = 'Error') 
{
	$_obfuscate_DUASCjMpGTYMKhYECBI2WwYFMBMzDDI = fopen($title . '.txt', 'a');
	fwrite($_obfuscate_DUASCjMpGTYMKhYECBI2WwYFMBMzDDI, $str);
	fclose($_obfuscate_DUASCjMpGTYMKhYECBI2WwYFMBMzDDI);
}
?>