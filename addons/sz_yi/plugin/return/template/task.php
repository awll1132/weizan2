<?php
global $_W;
global $_GPC;
$set = $this->getSet();
if ($set['isreturn']) 
{
	function getmoney($orderprice, $uniacid) 
	{
		$_obfuscate_DQoCwRALg8hBD8jFQg0GxMOG1syCDI = pdo_fetchall('select * from ' . tablename('sz_yi_return_money') . ' where uniacid = \'' . $uniacid . '\' and money >= \'' . $orderprice . '\' ');
		foreach ($_obfuscate_DQoCwRALg8hBD8jFQg0GxMOG1syCDI as $_obfuscate_DQMWMSQWEiMMQMCLiMOJCQLMykjLTI => $_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE ) 
		{
			if ($orderprice <= $_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE['money']) 
			{
				$_obfuscate_DQ0SCDgzIyoiBEADLjIENyE4Nx0vKzI = array('uniacid' => $_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE['uniacid'], 'mid' => $_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE['mid'], 'money' => $orderprice, 'create_time' => time());
				pdo_insert('sz_yi_return', $_obfuscate_DQ0SCDgzIyoiBEADLjIENyE4Nx0vKzI);
				pdo_update('sz_yi_return_money', array('money' => $_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE['money'] - $orderprice), array('id' => $_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE['id'], 'uniacid' => $uniacid));
				getmoney($orderprice, $uniacid);
			}
		}
	}
	getmoney($set['orderprice'], $_W['uniacid']);
	$daytime = strtotime(date('Y-m-d 00:00:00'));
	$stattime = $daytime - 86400;
	$endtime = $daytime - 1;
	$sql = 'select sum(o.price) from ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_order_refund') . ' r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid=' . $_W['uniacid'] . ' and  o.finishtime >=' . $stattime . ' and o.finishtime < ' . $endtime . '  ORDER BY o.finishtime DESC,o.status DESC';
	$ordermoney = pdo_fetchcolumn($sql);
	$ordermoney = floatval($ordermoney);
	$r_ordermoney = ($ordermoney * $set['percentage']) / 100;
	$data_money = pdo_fetchall('select * from ' . tablename('sz_yi_return') . ' where uniacid = \'' . $_W['uniacid'] . '\' and status = 0');
	$r_each = $r_ordermoney / count($data_money);
	$r_each = sprintf('%.2f', $r_each);
	foreach ($data_money as $key => $value ) 
	{
		$member = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where uniacid = \'' . $_W['uniacid'] . '\' and id = \'' . $value['mid'] . '\'');
		if (($value['money'] - $value['return_money']) < $r_each) 
		{
			pdo_update('sz_yi_return', array('return_money' => $value['money'], 'status' => '1'), array('id' => $value['id'], 'uniacid' => $_W['uniacid']));
			m('member')->setCredit($member['openid'], 'credit2', $value['money'] - $value['return_money']);
			$messages = array( 'keyword1' => array('value' => '返现通知', 'color' => '#73a68d'), 'keyword2' => array('value' => (('本次返现金额' . $value['money']) - $value['return_money']) . '元！', 'color' => '#73a68d'), 'keyword3' => array('value' => '此返单已经全部返现完成！', 'color' => '#73a68d') );
			m('message')->sendCustomNotice($member['openid'], $messages);
		}
		else 
		{
			pdo_update('sz_yi_return', array('return_money' => $value['return_money'] + $r_each), array('id' => $value['id'], 'uniacid' => $_W['uniacid']));
			m('member')->setCredit($member['openid'], 'credit2', $r_each);
			$messages = array( 'keyword1' => array('value' => '返现通知', 'color' => '#73a68d'), 'keyword2' => array('value' => '本次返现金额' . $r_each, 'color' => '#73a68d'), 'keyword3' => array('value' => (('此返单剩余返现金额' . $value['money']) - $value['return_money']) + $r_each, 'color' => '#73a68d') );
			m('message')->sendCustomNotice($member['openid'], $messages);
		}
	}
}
?>