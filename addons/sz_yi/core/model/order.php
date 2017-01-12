<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Sz_DYi_Order 
{
	public function getDispatchPrice($dephp_0, $dephp_1, $dephp_2 = -1) 
	{
		if (empty($dephp_1)) 
		{
			return 0;
		}
		$_obfuscate_DSg_EjMUKD4lHCcoKFshEBdbIhs4CxE = 0;
		if ($dephp_2 == -1) 
		{
			$dephp_2 = $dephp_1['calculatetype'];
		}
		if ($dephp_2 == 1) 
		{
			if ($dephp_0 <= $dephp_1['firstnum']) 
			{
				$_obfuscate_DSg_EjMUKD4lHCcoKFshEBdbIhs4CxE = floatval($dephp_1['firstnumprice']);
			}
			else 
			{
				$_obfuscate_DSg_EjMUKD4lHCcoKFshEBdbIhs4CxE = floatval($dephp_1['firstnumprice']);
				$_obfuscate_DR4RJyctDwUUHT4iLCQKxYyJDwBOCI = $dephp_0 - floatval($dephp_1['firstnum']);
				$_obfuscate_DQQdLwYdMB03FCgMGC4NPxALDD4xDwE = ((floatval($dephp_1['secondnum']) <= 0 ? 1 : floatval($dephp_1['secondnum'])));
				$_obfuscate_DTcJHzMmBhAbNCEeLhgvOBMbXCoiJAE = 0;
				if (($_obfuscate_DR4RJyctDwUUHT4iLCQKxYyJDwBOCI % $_obfuscate_DQQdLwYdMB03FCgMGC4NPxALDD4xDwE) == 0) 
				{
					$_obfuscate_DTcJHzMmBhAbNCEeLhgvOBMbXCoiJAE = ($_obfuscate_DR4RJyctDwUUHT4iLCQKxYyJDwBOCI / $_obfuscate_DQQdLwYdMB03FCgMGC4NPxALDD4xDwE) * floatval($dephp_1['secondnumprice']);
				}
				else 
				{
					$_obfuscate_DTcJHzMmBhAbNCEeLhgvOBMbXCoiJAE = ((int) $_obfuscate_DR4RJyctDwUUHT4iLCQKxYyJDwBOCI / $_obfuscate_DQQdLwYdMB03FCgMGC4NPxALDD4xDwE + 1) * floatval($dephp_1['secondnumprice']);
				}
				$_obfuscate_DSg_EjMUKD4lHCcoKFshEBdbIhs4CxE += $_obfuscate_DTcJHzMmBhAbNCEeLhgvOBMbXCoiJAE;
			}
		}
		else if ($dephp_0 <= $dephp_1['firstweight']) 
		{
			$_obfuscate_DSg_EjMUKD4lHCcoKFshEBdbIhs4CxE = floatval($dephp_1['firstprice']);
		}
		else 
		{
			$_obfuscate_DSg_EjMUKD4lHCcoKFshEBdbIhs4CxE = floatval($dephp_1['firstprice']);
			$_obfuscate_DR4RJyctDwUUHT4iLCQKxYyJDwBOCI = $dephp_0 - floatval($dephp_1['firstweight']);
			$_obfuscate_DQQdLwYdMB03FCgMGC4NPxALDD4xDwE = ((floatval($dephp_1['secondweight']) <= 0 ? 1 : floatval($dephp_1['secondweight'])));
			$_obfuscate_DTcJHzMmBhAbNCEeLhgvOBMbXCoiJAE = 0;
			if (($_obfuscate_DR4RJyctDwUUHT4iLCQKxYyJDwBOCI % $_obfuscate_DQQdLwYdMB03FCgMGC4NPxALDD4xDwE) == 0) 
			{
				$_obfuscate_DTcJHzMmBhAbNCEeLhgvOBMbXCoiJAE = ($_obfuscate_DR4RJyctDwUUHT4iLCQKxYyJDwBOCI / $_obfuscate_DQQdLwYdMB03FCgMGC4NPxALDD4xDwE) * floatval($dephp_1['secondprice']);
			}
			else 
			{
				$_obfuscate_DTcJHzMmBhAbNCEeLhgvOBMbXCoiJAE = ((int) $_obfuscate_DR4RJyctDwUUHT4iLCQKxYyJDwBOCI / $_obfuscate_DQQdLwYdMB03FCgMGC4NPxALDD4xDwE + 1) * floatval($dephp_1['secondprice']);
			}
			$_obfuscate_DSg_EjMUKD4lHCcoKFshEBdbIhs4CxE += $_obfuscate_DTcJHzMmBhAbNCEeLhgvOBMbXCoiJAE;
		}
		return $_obfuscate_DSg_EjMUKD4lHCcoKFshEBdbIhs4CxE;
	}
	public function getCityDispatchPrice($dephp_7, $dephp_8, $dephp_0, $dephp_1) 
	{
		if (is_array($dephp_7) && (0 < count($dephp_7))) 
		{
			foreach ($dephp_7 as $_obfuscate_DQEYLy4oFQsCMxYVPxY0KBgXBzA5FwE ) 
			{
				$_obfuscate_DTEpLg4WDBwyGTg0FDQ3HxwcKQUTOTI = explode(';', $_obfuscate_DQEYLy4oFQsCMxYVPxY0KBgXBzA5FwE['citys']);
				return $this->getDispatchPrice($dephp_0, $_obfuscate_DQEYLy4oFQsCMxYVPxY0KBgXBzA5FwE, $dephp_1['calculatetype']);
			}
		}
		return $this->getDispatchPrice($dephp_0, $dephp_1);
	}
	public function payResult($params) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DREWJTs9CywhDR0sHgQMLAQnDz8DJBE = $params['fee'];
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('status' => ($params['result'] == 'success' ? 1 : 0));
		$_obfuscate_DTUQOSQNKRoLOR0lEhQwKRQ5AiE9NRE = $params['tid'];
		$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select * from ' . tablename('sz_yi_order') . ' where  ordersn=:ordersn and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':ordersn' => $_obfuscate_DTUQOSQNKRoLOR0lEhQwKRQ5AiE9NRE));
		$_obfuscate_DT0fPQwrPT0_BTIVKA4wOwM9BBMRBCI = pdo_fetch('select * from ' . tablename('core_paylog') . ' where `uniacid`=:uniacid and (fee=:fee OR fee=:oldprice) and `module`=:module and `tid`=:tid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':module' => 'sz_yi', ':fee' => $_obfuscate_DREWJTs9CywhDR0sHgQMLAQnDz8DJBE, ':oldprice' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['oldprice'], ':tid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn']));
		if (empty($_obfuscate_DT0fPQwrPT0_BTIVKA4wOwM9BBMRBCI)) 
		{
			show_json(-1, '订单金额错误, 请重试!');
			exit();
		}
		$_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI = $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id'];
		if ($params['from'] == 'return') 
		{
			$_obfuscate_DS8REDAzHCUIygpMBcZMzcNEz8wDwE = false;
			if (empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['dispatchtype'])) 
			{
				$_obfuscate_DS8REDAzHCUIygpMBcZMzcNEz8wDwE = pdo_fetch('select realname,mobile,address from ' . tablename('sz_yi_member_address') . ' where id=:id limit 1', array(':id' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['addressid']));
			}
			$_obfuscate_DT0lIjcmKwMqGC0PBy8JPwgtOSQ5HTI = false;
			if (($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['dispatchtype'] == 1) || ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['isvirtual'] == 1)) 
			{
				$_obfuscate_DT0lIjcmKwMqGC0PBy8JPwgtOSQ5HTI = unserialize($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['carrier']);
			}
			if ($params['type'] == 'cash') 
			{
				return array('result' => 'success', 'order' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE, 'address' => $_obfuscate_DS8REDAzHCUIygpMBcZMzcNEz8wDwE, 'carrier' => $_obfuscate_DT0lIjcmKwMqGC0PBy8JPwgtOSQ5HTI);
			}
			if ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['status'] == 0) 
			{
				$_obfuscate_DQkRHxw1GioMMgIOIyM0FCkZFTdcFhE = p('virtual');
				if (!empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['virtual']) && $_obfuscate_DQkRHxw1GioMMgIOIyM0FCkZFTdcFhE) 
				{
					$_obfuscate_DQkRHxw1GioMMgIOIyM0FCkZFTdcFhE->pay($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE);
				}
				else 
				{
					pdo_update('sz_yi_order', array('status' => 1, 'paytime' => time()), array('id' => $_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI));
					if (0 < $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductcredit2']) 
					{
						$_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE = m('common')->getSysset('shop');
						m('member')->setCredit($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'], 'credit2', -$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductcredit2'], array(0, $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '余额抵扣: ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductcredit2'] . ' 订单号: ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn']));
					}
					$this->setStocksAndCredits($_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI, 1);
					if (p('coupon') && !empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['couponid'])) 
					{
						p('coupon')->backConsumeCoupon($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']);
					}
					m('notice')->sendOrderMessage($_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI);
					if (p('commission')) 
					{
						p('commission')->checkOrderPay($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']);
					}
				}
			}
			if (p('supplier')) 
			{
				p('supplier')->order_split($_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI);
			}
			$_obfuscate_DQwhOQkIgE8KiElP0AsJQRAPAobMQE = pdo_fetch('select o.dispatchprice,o.ordersn,o.price,og.optionname as optiontitle,og.optionid,og.total from ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_order_goods') . 'og on og.orderid = o.id  where o.id = :id and o.uniacid=:uniacid', array(':id' => $_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'SELECT og.goodsid,og.total,g.title,g.thumb,og.price,og.optionname as optiontitle,og.optionid FROM ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on og.goodsid = g.id ' . ' where og.orderid=:orderid order by og.id asc';
			$_obfuscate_DQwhOQkIgE8KiElP0AsJQRAPAobMQE['goods1'] = set_medias(pdo_fetchall($_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI, array(':orderid' => $_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI)), 'thumb');
			$_obfuscate_DQwhOQkIgE8KiElP0AsJQRAPAobMQE['goodscount'] = count($_obfuscate_DQwhOQkIgE8KiElP0AsJQRAPAobMQE['goods1']);
			return array('result' => 'success', 'order' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE, 'address' => $_obfuscate_DS8REDAzHCUIygpMBcZMzcNEz8wDwE, 'carrier' => $_obfuscate_DT0lIjcmKwMqGC0PBy8JPwgtOSQ5HTI, 'virtual' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['virtual'], 'goods' => $_obfuscate_DQwhOQkIgE8KiElP0AsJQRAPAobMQE);
		}
	}
	public function setStocksAndCredits($orderid = '', $type = 0) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select id,ordersn,price,openid,dispatchtype,addressid,carrier,status from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $orderid));
		$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = pdo_fetchall('select og.goodsid,og.total,g.totalcnf,og.realprice, g.credit,og.optionid,g.total as goodstotal,og.optionid,g.sales,g.salesreal from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $orderid));
		$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE = 0;
		foreach ($_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE as $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE ) 
		{
			$_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI = 0;
			if ($type == 0) 
			{
				if ($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['totalcnf'] == 0) 
				{
					$_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI = -1;
				}
			}
			else if ($type == 1) 
			{
				if ($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['totalcnf'] == 1) 
				{
					$_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI = -1;
				}
			}
			else if ($type == 2) 
			{
				if (1 <= $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['status']) 
				{
					if ($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['totalcnf'] == 1) 
					{
						$_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI = 1;
					}
				}
				else if ($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['totalcnf'] == 0) 
				{
					$_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI = 1;
				}
			}
			if (!empty($_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI)) 
			{
				if (!empty($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['optionid'])) 
				{
					$_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI = m('goods')->getOption($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodsid'], $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['optionid']);
					if (!empty($_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI) && ($_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI['stock'] != -1)) 
					{
						$_obfuscate_DSImFTkqDTsUDz0_ChQuGC0ZAwUFJxE = -1;
						if ($_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI == 1) 
						{
							$_obfuscate_DSImFTkqDTsUDz0_ChQuGC0ZAwUFJxE = $_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI['stock'] + $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['total'];
						}
						else if ($_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI == -1) 
						{
							$_obfuscate_DSImFTkqDTsUDz0_ChQuGC0ZAwUFJxE = $_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI['stock'] - $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['total'];
							($_obfuscate_DSImFTkqDTsUDz0_ChQuGC0ZAwUFJxE <= 0) && ($_obfuscate_DSImFTkqDTsUDz0_ChQuGC0ZAwUFJxE = 0);
						}
						if ($_obfuscate_DSImFTkqDTsUDz0_ChQuGC0ZAwUFJxE != -1) 
						{
							pdo_update('sz_yi_goods_option', array('stock' => $_obfuscate_DSImFTkqDTsUDz0_ChQuGC0ZAwUFJxE), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'goodsid' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodsid'], 'id' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['optionid']));
						}
					}
				}
				if (!empty($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodstotal']) && ($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodstotal'] != -1)) 
				{
					$_obfuscate_DSQrOwoNDQojOwUwMjkYWxIaGAQZHyI = -1;
					if ($_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI == 1) 
					{
						$_obfuscate_DSQrOwoNDQojOwUwMjkYWxIaGAQZHyI = $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodstotal'] + $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['total'];
					}
					else if ($_obfuscate_DSoGPwErJTQhLR4BBxo4EA4CPzQFJjI == -1) 
					{
						$_obfuscate_DSQrOwoNDQojOwUwMjkYWxIaGAQZHyI = $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodstotal'] - $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['total'];
						($_obfuscate_DSQrOwoNDQojOwUwMjkYWxIaGAQZHyI <= 0) && ($_obfuscate_DSQrOwoNDQojOwUwMjkYWxIaGAQZHyI = 0);
					}
					if ($_obfuscate_DSQrOwoNDQojOwUwMjkYWxIaGAQZHyI != -1) 
					{
						pdo_update('sz_yi_goods', array('total' => $_obfuscate_DSQrOwoNDQojOwUwMjkYWxIaGAQZHyI), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodsid']));
					}
				}
			}
			$_obfuscate_DSo0Ajw4Mi4EKwwZXAw_GAkrDwhcGhE = trim($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['credit']);
			if (!empty($_obfuscate_DSo0Ajw4Mi4EKwwZXAw_GAkrDwhcGhE)) 
			{
				if (strexists($_obfuscate_DSo0Ajw4Mi4EKwwZXAw_GAkrDwhcGhE, '%')) 
				{
					$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE += intval((floatval(str_replace('%', '', $_obfuscate_DSo0Ajw4Mi4EKwwZXAw_GAkrDwhcGhE)) / 100) * $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['realprice']);
				}
				else 
				{
					$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE += intval($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['credit']) * $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['total'];
				}
			}
			if ($type == 0) 
			{
				pdo_update('sz_yi_goods', array('sales' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['sales'] + $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['total']), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodsid']));
			}
			else if ($type == 1) 
			{
				if (1 <= $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['status']) 
				{
					$_obfuscate_DQEhPDkIAxgLPwoQOy8YW1wvMjErCTI = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where og.goodsid=:goodsid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':goodsid' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodsid'], ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
					pdo_update('sz_yi_goods', array('salesreal' => $_obfuscate_DQEhPDkIAxgLPwoQOy8YW1wvMjErCTI), array('id' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['goodsid']));
				}
			}
		}
		if (0 < $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE) 
		{
			$_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE = m('common')->getSysset('shop');
			if ($type == 1) 
			{
				m('member')->setCredit($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'], 'credit1', $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE, array(0, $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '购物积分 订单号: ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn']));
				return NULL;
			}
			if ($type == 2) 
			{
				if (1 <= $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['status']) 
				{
					m('member')->setCredit($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'], 'credit1', -$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE, array(0, $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '购物取消订单扣除积分 订单号: ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn']));
				}
			}
		}
	}
	public function getDefaultDispatch($supplier_uid = 0) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'select * from ' . tablename('sz_yi_dispatch') . ' where isdefault=1 and uniacid=:uniacid and enabled=1 and supplier_uid=:supplier_uid Limit 1';
		$_obfuscate_DSssMTkNJgkTCR4dIT8LASIbLSsOKCI = array(':supplier_uid' => $supplier_uid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
		$_obfuscate_DQguISQsFTMsDTM7PhctMRcoWwE4EDI = pdo_fetch($_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI, $_obfuscate_DSssMTkNJgkTCR4dIT8LASIbLSsOKCI);
		return $_obfuscate_DQguISQsFTMsDTM7PhctMRcoWwE4EDI;
	}
	public function getNewDispatch($supplier_uid = 0) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'select * from ' . tablename('sz_yi_dispatch') . ' where uniacid=:uniacid and enabled=1 and supplier_uid=:supplier_uid order by id desc Limit 1';
		$_obfuscate_DSssMTkNJgkTCR4dIT8LASIbLSsOKCI = array(':supplier_uid' => $supplier_uid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
		$_obfuscate_DQEvJh1ACj0KKFw4PiQVJi4jGxYePzI = pdo_fetch($_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI, $_obfuscate_DSssMTkNJgkTCR4dIT8LASIbLSsOKCI);
		return $_obfuscate_DQEvJh1ACj0KKFw4PiQVJi4jGxYePzI;
	}
	public function getOneDispatch($dispatch_id, $supplier_uid = 0) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'select * from ' . tablename('sz_yi_dispatch') . ' where id=:id and uniacid=:uniacid and enabled=1 and supplier_uid=:supplier_uid Limit 1';
		$_obfuscate_DSssMTkNJgkTCR4dIT8LASIbLSsOKCI = array(':supplier_uid' => $supplier_uid, ':id' => $dispatch_id, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
		$_obfuscate_DT0VWxAICkAxDy0OFz0VIQ4SBQk_LTI = pdo_fetch($_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI, $_obfuscate_DSssMTkNJgkTCR4dIT8LASIbLSsOKCI);
		return $_obfuscate_DT0VWxAICkAxDy0OFz0VIQ4SBQk_LTI;
	}
}
?>