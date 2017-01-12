<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
global $_W;
global $_GPC;
$operation = ((!empty($_GPC['op']) ? $_GPC['op'] : 'display'));
$openid = m('user')->getOpenid();
$uniacid = $_W['uniacid'];
$orderid = intval($_GPC['id']);
if ($_W['isajax']) 
{
	if ($operation == 'display') 
	{
		$order = pdo_fetch('select refundid from ' . tablename('sz_yi_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
		if (empty($order)) 
		{
			show_json(0);
		}
		$refundid = $order['refundid'];
		$refund = pdo_fetch('select * from ' . tablename('sz_yi_order_refund') . ' where id=:id and uniacid=:uniacid  limit 1', array(':id' => $refundid, ':uniacid' => $uniacid));
		$set = set_medias(m('common')->getSysset('shop'), 'logo');
		show_json(1, array('order' => $order, 'refund' => $refund, 'set' => $set));
	}
	else if ($operation == 'step') 
	{
		$express = trim($_GPC['express']);
		$expresssn = trim($_GPC['expresssn']);
		$arr = getlist($express, $expresssn);
		if (!$arr) 
		{
			$arr = getlist($express, $expresssn);
			if (!$arr) 
			{
				show_json(1, array( 'list' => array() ));
			}
		}
		$len = count($arr);
		$step1 = explode('<br />', str_replace('&middot;', '', $arr[0]));
		$step2 = explode('<br />', str_replace('&middot;', '', $arr[$len - 1]));
		$i = 0;
		while ($i < $len) 
		{
			if (strtotime(trim($step2[0])) < strtotime(trim($step1[0]))) 
			{
				$row = $arr[$i];
			}
			else 
			{
				$row = $arr[$len - $i - 1];
			}
			$step = explode('<br />', str_replace('&middot;', '', $row));
			$list[] = array('time' => trim($step[0]), 'step' => trim($step[1]), 'ts' => strtotime(trim($step[0])));
			++$i;
		}
		show_json(1, array('list' => $list));
	}
}
include $this->template('order/refundexpress');
function sortByTime($_var_0, $_var_1) 
{
	if ($_var_0['ts'] == $_var_1['ts']) 
	{
		return 0;
	}
	return ($_var_1['ts'] < $_var_0['ts'] ? 1 : -1);
}
function getList($_var_2, $_var_3) 
{
	$_obfuscate_DSYxHxAKOwcxOSYkDA0QIiYWDAIyExE = 'http://wap.kuaidi100.com/wap_result.jsp?rand=' . time() . '&id=' . $_var_2 . '&fromWeb=null&postid=' . $_var_3;
	load()->func('communication');
	$_obfuscate_DTgJEgNAOzQLS0mHQMBXDVAKjEyIzI = ihttp_request($_obfuscate_DSYxHxAKOwcxOSYkDA0QIiYWDAIyExE);
	$_obfuscate_DQZcQAkcCh4EIQU1BhAPF0AwFQRbKCI = $_obfuscate_DTgJEgNAOzQLS0mHQMBXDVAKjEyIzI['content'];
	if (empty($_obfuscate_DQZcQAkcCh4EIQU1BhAPF0AwFQRbKCI)) 
	{
		return array();
	}
	preg_match_all('/\\<p\\>&middot;(.*)\\<\\/p\\>/U', $_obfuscate_DQZcQAkcCh4EIQU1BhAPF0AwFQRbKCI, $_obfuscate_DRg4BQohQBM_KzkJGykrLQciMDUaCgE);
	if (!isset($_obfuscate_DRg4BQohQBM_KzkJGykrLQciMDUaCgE[1])) 
	{
		return false;
	}
	return $_obfuscate_DRg4BQohQBM_KzkJGykrLQciMDUaCgE[1];
}
?>