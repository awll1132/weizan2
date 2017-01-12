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
		$order = pdo_fetch('select * from ' . tablename('sz_yi_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
		if (empty($order)) 
		{
			show_json(0);
		}
		$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.storeids  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));
		$goods = set_medias($goods, 'thumb');
		$order['goodstotal'] = count($goods);
		$set = set_medias(m('common')->getSysset('shop'), 'logo');
		show_json(1, array('order' => $order, 'goods' => $goods, 'set' => $set));
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
include $this->template('order/express');
function sortByTime($a, $b) 
{
	if ($a['ts'] == $b['ts']) 
	{
		return 0;
	}
	return ($b['ts'] < $a['ts'] ? 1 : -1);
}
function getList($express, $expresssn) 
{
	$_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE = 'http://wap.kuaidi100.com/wap_result.jsp?rand=' . time() . '&id=' . $express . '&fromWeb=null&postid=' . $expresssn;
	load()->func('communication');
	$_obfuscate_DR0ECztcGwU5MCU9GgM0HxAfDAMQFjI = ihttp_request($_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE);
	$_obfuscate_DTY2FTY1NR0PO1saWy0PJykSLj8KPCI = $_obfuscate_DR0ECztcGwU5MCU9GgM0HxAfDAMQFjI['content'];
	if (empty($_obfuscate_DTY2FTY1NR0PO1saWy0PJykSLj8KPCI)) 
	{
		return array();
	}
	preg_match_all('/\\<p\\>&middot;(.*)\\<\\/p\\>/U', $_obfuscate_DTY2FTY1NR0PO1saWy0PJykSLj8KPCI, $_obfuscate_DRIQHR5bBhImHA0UGyg4JCg2FygUIwE);
	if (!isset($_obfuscate_DRIQHR5bBhImHA0UGyg4JCg2FygUIwE[1])) 
	{
		return false;
	}
	return $_obfuscate_DRIQHR5bBhImHA0UGyg4JCg2FygUIwE[1];
}
?>