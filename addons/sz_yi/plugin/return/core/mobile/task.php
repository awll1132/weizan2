<?php
global $_W;
global $_GPC;
set_time_limit(0);
$sets = pdo_fetchall('select uniacid from ' . tablename('sz_yi_sysset'));
foreach ($sets as $val ) 
{
	$_W['uniacid'] = $val['uniacid'];
	if (empty($_W['uniacid'])) 
	{
		continue;
	}
	$set = m('plugin')->getpluginSet('return', $_W['uniacid']);
	if (!empty($set)) 
	{
		$isexecute = false;
		if ($set['returnlaw'] == 1) 
		{
			if (date('H') == $set['returntime']) 
			{
				if (!isset($set['current_d']) || ($set['current_d'] != date('d'))) 
				{
					$set['current_d'] = date('d');
					$this->updateSet($set);
					$isexecute = true;
				}
			}
		}
		else if ($set['returnlaw'] == 2) 
		{
			if (!isset($set['current_m']) || ($set['current_m'] != date('m'))) 
			{
				$set['current_m'] = date('m');
				$this->updateSet($set);
				$isexecute = true;
			}
		}
		if (($set['isreturn'] || $set['isqueue']) && $isexecute) 
		{
			if ($set['returnrule'] == 1) 
			{
				p('return')->setOrderReturn($set, $_W['uniacid']);
			}
			else 
			{
				p('return')->setOrderMoneyReturn($set, $_W['uniacid']);
			}
			echo '<pre>';
			print_r('成功');
		}
	}
}
echo 'ok...';
?>