<?php
global $_W;
global $_GPC;
$sets = $this->getSet();
$set = $sets['ranking'];
$order_goods = pdo_fetchall('select og.*, o.agentid from ' . tablename('sz_yi_order_goods') . ' og ' . "\n" . ' left join ' . tablename('sz_yi_order') . ' o on( og.orderid = o.id ) ' . "\n" . '  where og.rankingstatus = 0 and og.uniacid = \'' . $_W['uniacid'] . '\' ');
foreach ($order_goods as $key => $value ) 
{
	pdo_update('sz_yi_order_goods', array('rankingstatus' => 1), array('id' => $value['id'], 'uniacid' => $_W['uniacid']));
	$level1 = p('ranking')->getMember($value['agentid']);
	$commission1 = iunserializer($value['commission1']);
	$level[] = array('mid' => $level1['id'], 'credit' => $commission1['default']);
	$level2 = p('ranking')->getMember($level1['agentid']);
	$commission2 = iunserializer($value['commission2']);
	$level[] = array('mid' => $level2['id'], 'credit' => $commission2['default']);
	$level3 = p('ranking')->getMember($level2['agentid']);
	$commission3 = iunserializer($value['commission3']);
	$level[] = array('mid' => $level3['id'], 'credit' => $commission3['default']);
}
if ($level) 
{
	foreach ($level as $key => $value ) 
	{
		$list = pdo_fetch('select * from ' . tablename('sz_yi_ranking') . ' where uniacid = \'' . $_W['uniacid'] . '\' and mid = \'' . $value['mid'] . '\'');
		if ($list) 
		{
			pdo_update('sz_yi_ranking', array('credit' => $list['credit'] + $value['credit']), array('mid' => $value['mid'], 'uniacid' => $_W['uniacid']));
		}
		else 
		{
			$data = array('uniacid' => $_W['uniacid'], 'mid' => $value['mid'], 'credit' => $value['credit']);
			pdo_insert('sz_yi_ranking', $data);
		}
	}
}
if (!empty($_GPC['type'])) 
{
	message('更新佣金排名成功!', $this->createPluginWebUrl('ranking/set'), 'success');
	exit();
	return 1;
}
echo '<pre>';
print_r('更新佣金排名成功');
exit();
?>