<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
if (!class_exists('ReturnModel')) 
{
	class ReturnModel extends PluginModel 
	{
		public function getSet() 
		{
			$_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE = parent::getSet();
			return $_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE;
		}
		public function setGoodsQueue($orderid, $_var_0 = array(), $uniacid = '') 
		{
			$_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI = pdo_fetchall('SELECT og.orderid,og.goodsid,og.total,og.price,g.isreturnqueue,o.openid,m.id as mid FROM ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_member') . ' m  on o.openid = m.openid left join ' . tablename('sz_yi_order_goods') . ' og on og.orderid = o.id  left join ' . tablename('sz_yi_goods') . ' g on g.id = og.goodsid WHERE o.id = :orderid and o.uniacid = :uniacid and m.uniacid = :uniacid', array(':orderid' => $orderid, ':uniacid' => $uniacid));
			foreach ($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI as $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI ) 
			{
				if ($_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['isreturnqueue'] == 1) 
				{
					$_obfuscate_DTcEOSwzJz4sCBlcND44OwsiPisiMBE = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_order_goods_queue') . ' where uniacid = ' . $uniacid . ' and goodsid = ' . $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['goodsid'] . ' order by queue desc limit 1');
					$_obfuscate_DTk0OAc_KjkeHBIEJyQzHQE0EyISMzI = '';
					$_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI = 1;
					while ($_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI <= $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['total']) 
					{
						$_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI1 = $_obfuscate_DTcEOSwzJz4sCBlcND44OwsiPisiMBE['queue'] + $_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI;
						$_obfuscate_DTk0OAc_KjkeHBIEJyQzHQE0EyISMzI .= $_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI1 . '、';
						$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('uniacid' => $uniacid, 'openid' => $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['openid'], 'goodsid' => $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['goodsid'], 'orderid' => $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['orderid'], 'price' => $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['price'] / $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['total'], 'queue' => $_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI1, 'create_time' => time());
						pdo_insert('sz_yi_order_goods_queue', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI);
						$_obfuscate_DTUYMRYsPiw1OQkbEj8lKwg8HikNPBE = pdo_insertid();
						
						$shenmegui = $_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI1 % $_var_0['queue'];
						if (empty($shenmegui))
						{
							$_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_order_goods_queue') . ' where uniacid = ' . $uniacid . ' and goodsid = ' . $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['goodsid'] . ' and status = 0 order by queue asc limit 1');
							pdo_update('sz_yi_order_goods_queue', array('returnid' => $_obfuscate_DTUYMRYsPiw1OQkbEj8lKwg8HikNPBE, 'status' => '1'), array('id' => $_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI['id'], 'uniacid' => $uniacid));
							m('member')->setCredit($_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI['openid'], 'credit2', $_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI['price']);
							$_obfuscate_DRc2FjEbWzkQERtcODQdKDs3JD02GCI = array( 'keyword1' => array('value' => '排列返现通知', 'color' => '#73a68d'), 'keyword2' => array('value' => '本次返现金额' . $_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI['price'] . '元！', 'color' => '#73a68d'), 'keyword3' => array('value' => '排列返现完成！', 'color' => '#73a68d') );
							m('message')->sendCustomNotice($_obfuscate_DRIrAx0EHD0lXBs1HT4DCjgSJ1wyJDI['openid'], $_obfuscate_DRc2FjEbWzkQERtcODQdKDs3JD02GCI);
						}
						++$_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI;
					}
					$_obfuscate_DQYaFTEQBQQiBg0yGQMNBhwtLyMPWyI = array( 'keyword1' => array('value' => '加入排列通知', 'color' => '#73a68d'), 'keyword2' => array('value' => '您已加入排列，排列号为' . $_obfuscate_DTk0OAc_KjkeHBIEJyQzHQE0EyISMzI . '号！', 'color' => '#73a68d'), 'keyword3' => array('value' => '加入排列完成，请等待返现！', 'color' => '#73a68d') );
					m('message')->sendCustomNotice($_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['openid'], $_obfuscate_DQYaFTEQBQQiBg0yGQMNBhwtLyMPWyI);
				}
			}
		}
		public function setMembeerLevel($orderid, $_var_0 = array(), $uniacid = '') 
		{
			$_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI = pdo_fetchall('SELECT og.price,og.total,g.isreturn,g.returns,o.openid,m.id as mid ,m.level FROM ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_member') . ' m  on o.openid = m.openid left join ' . tablename('sz_yi_order_goods') . ' og on og.orderid = o.id  left join ' . tablename('sz_yi_goods') . ' g on g.id = og.goodsid WHERE o.id = :orderid and o.uniacid = :uniacid and m.uniacid = :uniacid', array(':orderid' => $orderid, ':uniacid' => $uniacid));
			foreach ($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
			{
				$_obfuscate_DRYKKCcDAxslEjwtMzkuQAMONAw2CgE = json_decode($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['returns'], true);
				if ($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['level'] == '0') 
				{
					$_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE += (($_obfuscate_DRYKKCcDAxslEjwtMzkuQAMONAw2CgE['default'] ? $_obfuscate_DRYKKCcDAxslEjwtMzkuQAMONAw2CgE['default'] * $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['total'] : '0'));
				}
				else 
				{
					$_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE += (($_obfuscate_DRYKKCcDAxslEjwtMzkuQAMONAw2CgE['level' . $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['level']] ? $_obfuscate_DRYKKCcDAxslEjwtMzkuQAMONAw2CgE['level' . $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['level']] * $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['total'] : '0'));
				}
			}
			if (0 < $_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE) 
			{
				$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('uniacid' => $uniacid, 'mid' => $_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI[0]['mid'], 'openid' => $_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI[0]['openid'], 'money' => $_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE, 'status' => 1, 'returntype' => 1, 'create_time' => time());
				pdo_insert('sz_yi_return_log', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI);
				m('member')->setCredit($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI[0]['openid'], 'credit2', $_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE);
				$_obfuscate_DRlABRsuLEA7IxY5EQwJGwctDD8DLTI = '您的订单(' . $orderid . ')已返现完成。';
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => '购物返现通知', 'color' => '#73a68d'), 'keyword2' => array('value' => '[返现金额]' . $_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE . '元,已存到您的余额', 'color' => '#73a68d'), 'remark' => array('value' => $_obfuscate_DRlABRsuLEA7IxY5EQwJGwctDD8DLTI) );
				m('message')->sendCustomNotice($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI[0]['openid'], $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
			}
		}
		public function cumulative_order_amount($orderid) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE = $this->getSet();
			if ($_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE['islevelreturn']) 
			{
				$this->setMembeerLevel($orderid, $_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE, $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
			}
			if ($_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE['isqueue']) 
			{
				$this->setGoodsQueue($orderid, $_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE, $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
			}
			if ($_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE['isreturn'] == 1) 
			{
				if (empty($orderid)) 
				{
					return false;
				}
				$_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI = pdo_fetchall('SELECT og.price,g.isreturn,o.openid,m.id as mid FROM ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_member') . ' m  on o.openid = m.openid left join ' . tablename('sz_yi_order_goods') . ' og on og.orderid = o.id  left join ' . tablename('sz_yi_goods') . ' g on g.id = og.goodsid WHERE o.id = :orderid and o.uniacid = :uniacid and m.uniacid = :uniacid', array(':orderid' => $orderid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
				$_obfuscate_DSUOLDcpNyYmAh00JSobKjNAI1wyMSI = 0;
				$_obfuscate_DQENGyMaAR8dERkRAwEEEgojPg0EIiI = false;
				foreach ($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI as $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI ) 
				{
					if ($_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['isreturn'] == 1) 
					{
						$_obfuscate_DSUOLDcpNyYmAh00JSobKjNAI1wyMSI += $_obfuscate_DTAFNxQXNgQ0KjQUKg0EHCsTLxYSPSI['price'];
						$_obfuscate_DQENGyMaAR8dERkRAwEEEgojPg0EIiI = true;
					}
				}
				if (!$_obfuscate_DQENGyMaAR8dERkRAwEEEgojPg0EIiI) 
				{
					return false;
				}
				if (empty($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI)) 
				{
					return false;
				}
				if ($_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE['returnrule'] == 1) 
				{
					$this->setOrderRule($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI, $_obfuscate_DSUOLDcpNyYmAh00JSobKjNAI1wyMSI, $_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE, $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
					return NULL;
				}
				if ($_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE['returnrule'] == 2) 
				{
					$this->setOrderMoneyRule($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI, $_obfuscate_DSUOLDcpNyYmAh00JSobKjNAI1wyMSI, $_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE, $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
				}
			}
		}
		public function setOrderRule($order_goods, $order_price, $_var_0 = array(), $uniacid = '') 
		{
			$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('mid' => $order_goods[0]['mid'], 'uniacid' => $uniacid, 'money' => $order_price, 'returnrule' => $_var_0['returnrule'], 'create_time' => time());
			pdo_insert('sz_yi_return', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI);
			$_obfuscate_DRlABRsuLEA7IxY5EQwJGwctDD8DLTI = '您的订单以加入全返机制，等待全返。';
			$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => '订单全返通知', 'color' => '#73a68d'), 'keyword2' => array('value' => '[订单返现金额]' . $_obfuscate_DTwEMCYJNw4rFz8fQDsGFiUHwYNGyI, 'color' => '#73a68d'), 'remark' => array('value' => $_obfuscate_DRlABRsuLEA7IxY5EQwJGwctDD8DLTI) );
			m('message')->sendCustomNotice($order_goods[0]['openid'], $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
		}
		public function setOrderMoneyRule($order_goods, $order_price, $_var_0 = array(), $uniacid = '') 
		{
			$_obfuscate_DTkoDywSGzgMPA8LGT0nPRs8MBUmMxE = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_return_money') . ' WHERE mid = :mid and uniacid = :uniacid', array(':mid' => $order_goods[0]['mid'], ':uniacid' => $uniacid));
			if (!empty($_obfuscate_DTkoDywSGzgMPA8LGT0nPRs8MBUmMxE)) 
			{
				$_obfuscate_DQgUPTstCzYnNDUwPC0qBzckDRwDMAE = $_obfuscate_DTkoDywSGzgMPA8LGT0nPRs8MBUmMxE['id'];
				$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('money' => $_obfuscate_DTkoDywSGzgMPA8LGT0nPRs8MBUmMxE['money'] + $order_price);
				pdo_update('sz_yi_return_money', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI, array('id' => $_obfuscate_DQgUPTstCzYnNDUwPC0qBzckDRwDMAE));
			}
			else 
			{
				$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('mid' => $order_goods[0]['mid'], 'uniacid' => $uniacid, 'money' => $order_price);
				pdo_insert('sz_yi_return_money', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI);
				$_obfuscate_DQgUPTstCzYnNDUwPC0qBzckDRwDMAE = pdo_insertid();
			}
			$_obfuscate_DTwEMCYJNw4rFz8fQDsGFiUHwYNGyI = pdo_fetchcolumn('SELECT money FROM ' . tablename('sz_yi_return_money') . ' WHERE id = :id and uniacid = :uniacid', array(':id' => $_obfuscate_DQgUPTstCzYnNDUwPC0qBzckDRwDMAE, ':uniacid' => $uniacid));
			$this->setmoney($_var_0['orderprice'], $_var_0, $uniacid);
			if ($_var_0['orderprice'] <= $_obfuscate_DTwEMCYJNw4rFz8fQDsGFiUHwYNGyI) 
			{
				$_obfuscate_DRlABRsuLEA7IxY5EQwJGwctDD8DLTI = '您的订单累计金额已经超过' . $_var_0['orderprice'] . '元，每' . $_var_0['orderprice'] . '元可以加入全返机制，等待全返。';
			}
			else 
			{
				$_obfuscate_DRlABRsuLEA7IxY5EQwJGwctDD8DLTI = '您的订单累计金额还差' . ($_var_0['orderprice'] - $_obfuscate_DTwEMCYJNw4rFz8fQDsGFiUHwYNGyI) . '元达到' . $_var_0['orderprice'] . '元，订单累计金额每达到' . $_var_0['orderprice'] . '元就可以加入全返机制，等待全返。继续加油！';
			}
			$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => '订单金额累计通知', 'color' => '#73a68d'), 'keyword2' => array('value' => '[订单累计金额]' . $_obfuscate_DTwEMCYJNw4rFz8fQDsGFiUHwYNGyI, 'color' => '#73a68d'), 'remark' => array('value' => $_obfuscate_DRlABRsuLEA7IxY5EQwJGwctDD8DLTI) );
			m('message')->sendCustomNotice($order_goods[0]['openid'], $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
		}
		public function setOrderReturn($_var_0 = array(), $uniacid = '') 
		{
			$_obfuscate_DSUOIjwExUPAh8EES0TOCMXLh4ZJgE = pdo_fetchall('select * from ' . tablename('sz_yi_return') . ' where uniacid = \'' . $uniacid . '\' and status = 0 and returnrule = \'' . $_var_0['returnrule'] . '\'');
			$_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE = array();
			foreach ($_obfuscate_DSUOIjwExUPAh8EES0TOCMXLh4ZJgE as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
			{
				$_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE = ($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] * $_var_0['percentage']) / 100;
				$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where uniacid = \'' . $uniacid . '\' and id = \'' . $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['mid'] . '\'');
				if (($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] - $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money']) < $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE) 
				{
					pdo_update('sz_yi_return', array('return_money' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'], 'status' => '1'), array('id' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['id'], 'uniacid' => $uniacid));
					m('member')->setCredit($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid'], 'credit2', $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] - $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money']);
					$_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE[$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid']][$_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE]['return_money_totle'] = $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] - $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money'];
				}
				else 
				{
					pdo_update('sz_yi_return', array('return_money' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money'] + $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE), array('id' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['id'], 'uniacid' => $uniacid));
					m('member')->setCredit($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid'], 'credit2', $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE);
					$_obfuscate_DRYwEFwyOyUPFA8iDhoxGDsGLiIxNTI = $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] - $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money'] - $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE;
					$_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE[$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid']][$_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE]['return_money_totle'] = $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE;
					$_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE[$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid']][$_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE]['surplus_money_totle'] = $_obfuscate_DRYwEFwyOyUPFA8iDhoxGDsGLiIxNTI;
				}
			}
			foreach ($_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE ) 
			{
				$_obfuscate_DVspGh8mGBM0LjwQBhUfHy0vPSkxAQE = 0;
				$_obfuscate_DTcrHR0KAgMrHC0TJBsLJx8CAS8fKgE = 0;
				foreach ($_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE as $_obfuscate_DT0HPAMVLDs9DlsQXAoROA0yHwMzHAE => $_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE ) 
				{
					$_obfuscate_DVspGh8mGBM0LjwQBhUfHy0vPSkxAQE += $_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE['return_money_totle'];
					$_obfuscate_DTcrHR0KAgMrHC0TJBsLJx8CAS8fKgE += $_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE['surplus_money_totle'];
				}
				if (0 < $_obfuscate_DVspGh8mGBM0LjwQBhUfHy0vPSkxAQE) 
				{
					$_obfuscate_DRc2FjEbWzkQERtcODQdKDs3JD02GCI = array( 'keyword1' => array('value' => '返现通知', 'color' => '#73a68d'), 'keyword2' => array('value' => '本次返现金额' . $_obfuscate_DVspGh8mGBM0LjwQBhUfHy0vPSkxAQE . '元', 'color' => '#73a68d'), 'keyword3' => array('value' => '此返单剩余返现金额' . $_obfuscate_DTcrHR0KAgMrHC0TJBsLJx8CAS8fKgE . '元', 'color' => '#73a68d') );
					m('message')->sendCustomNotice($_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE, $_obfuscate_DRc2FjEbWzkQERtcODQdKDs3JD02GCI);
				}
			}
		}
		public function setOrderMoneyReturn($_var_0 = array(), $uniacid = '') 
		{
			$_obfuscate_DQlcOwIPFxATLisiBTsFFlshEzQHyI = strtotime(date('Y-m-d 00:00:00'));
			$_obfuscate_DRklXCcNFhYOEiowAQwPHRUoHBsPOBE = $_obfuscate_DQlcOwIPFxATLisiBTsFFlshEzQHyI - 86400;
			$_obfuscate_DQYTFgoCJyQrCw01FCoNWwkCIjs1BhE = $_obfuscate_DQlcOwIPFxATLisiBTsFFlshEzQHyI - 1;
			$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'select sum(o.price) from ' . tablename('sz_yi_order') . ' o left join ' . tablename('sz_yi_order_refund') . ' r on r.orderid=o.id and ifnull(r.status,-1)<>-1 where 1 and o.status>=3 and o.uniacid=' . $uniacid . ' and  o.finishtime >=' . $_obfuscate_DRklXCcNFhYOEiowAQwPHRUoHBsPOBE . ' and o.finishtime < ' . $_obfuscate_DQYTFgoCJyQrCw01FCoNWwkCIjs1BhE . '  ORDER BY o.finishtime DESC,o.status DESC';
			$_obfuscate_DTkKCxEYNBsQDS4FDhczEh0iKSc_JzI = pdo_fetchcolumn($_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI);
			$_obfuscate_DTkKCxEYNBsQDS4FDhczEh0iKSc_JzI = floatval($_obfuscate_DTkKCxEYNBsQDS4FDhczEh0iKSc_JzI);
			$_obfuscate_DTwVCRQEDxsaMQ8PLBUVBysWIQQXKCI = ($_obfuscate_DTkKCxEYNBsQDS4FDhczEh0iKSc_JzI * $_var_0['percentage']) / 100;
			$_obfuscate_DSUOIjwExUPAh8EES0TOCMXLh4ZJgE = pdo_fetchall('select * from ' . tablename('sz_yi_return') . ' where uniacid = \'' . $uniacid . '\' and status = 0 and returnrule = \'' . $_var_0['returnrule'] . '\'');
			if ((0 < $_obfuscate_DTwVCRQEDxsaMQ8PLBUVBysWIQQXKCI) && $_obfuscate_DSUOIjwExUPAh8EES0TOCMXLh4ZJgE) 
			{
				$_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE = $_obfuscate_DTwVCRQEDxsaMQ8PLBUVBysWIQQXKCI / count($_obfuscate_DSUOIjwExUPAh8EES0TOCMXLh4ZJgE);
				$_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE = sprintf('%.2f', $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE);
				$_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE = array();
				foreach ($_obfuscate_DSUOIjwExUPAh8EES0TOCMXLh4ZJgE as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
				{
					$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where uniacid = \'' . $uniacid . '\' and id = \'' . $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['mid'] . '\'');
					if (($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] - $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money']) < $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE) 
					{
						pdo_update('sz_yi_return', array('return_money' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'], 'status' => '1'), array('id' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['id'], 'uniacid' => $uniacid));
						m('member')->setCredit($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid'], 'credit2', $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] - $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money']);
						$_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE[$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid']][$_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE]['return_money_totle'] = $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] - $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money'];
					}
					else 
					{
						pdo_update('sz_yi_return', array('return_money' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money'] + $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE), array('id' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['id'], 'uniacid' => $uniacid));
						m('member')->setCredit($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid'], 'credit2', $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE);
						$_obfuscate_DRYwEFwyOyUPFA8iDhoxGDsGLiIxNTI = $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] - $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['return_money'] - $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE;
						$_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE[$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid']][$_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE]['return_money_totle'] = $_obfuscate_DTMDDT0ZCRgeFCgyOxpbFx8QIx8YLAE;
						$_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE[$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid']][$_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE]['surplus_money_totle'] = $_obfuscate_DRYwEFwyOyUPFA8iDhoxGDsGLiIxNTI;
					}
				}
				foreach ($_obfuscate_DSwLCBErIj4EFAgjLRIUQCE1LRYsDgE as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE ) 
				{
					$_obfuscate_DVspGh8mGBM0LjwQBhUfHy0vPSkxAQE = 0;
					$_obfuscate_DTcrHR0KAgMrHC0TJBsLJx8CAS8fKgE = 0;
					foreach ($_obfuscate_DTYEJBAiEiYkDhlAFzEfFgQ_GSMmGRE as $_obfuscate_DT0HPAMVLDs9DlsQXAoROA0yHwMzHAE => $_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE ) 
					{
						$_obfuscate_DVspGh8mGBM0LjwQBhUfHy0vPSkxAQE += $_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE['return_money_totle'];
						$_obfuscate_DTcrHR0KAgMrHC0TJBsLJx8CAS8fKgE += $_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE['surplus_money_totle'];
					}
					if (0 < $_obfuscate_DVspGh8mGBM0LjwQBhUfHy0vPSkxAQE) 
					{
						$_obfuscate_DRc2FjEbWzkQERtcODQdKDs3JD02GCI = array( 'keyword1' => array('value' => '返现通知', 'color' => '#73a68d'), 'keyword2' => array('value' => '本次返现金额' . $_obfuscate_DVspGh8mGBM0LjwQBhUfHy0vPSkxAQE . '元', 'color' => '#73a68d'), 'keyword3' => array('value' => '此返单剩余返现金额' . $_obfuscate_DTcrHR0KAgMrHC0TJBsLJx8CAS8fKgE . '元', 'color' => '#73a68d') );
						m('message')->sendCustomNotice($_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE, $_obfuscate_DRc2FjEbWzkQERtcODQdKDs3JD02GCI);
					}
				}
			}
		}
		public function setmoney($orderprice, $_var_0 = array(), $uniacid = '') 
		{
			$_obfuscate_DSUOIjwExUPAh8EES0TOCMXLh4ZJgE = pdo_fetchall('select * from ' . tablename('sz_yi_return_money') . ' where uniacid = \'' . $uniacid . '\' and money >= \'' . $orderprice . '\' ');
			if ($_obfuscate_DSUOIjwExUPAh8EES0TOCMXLh4ZJgE) 
			{
				foreach ($_obfuscate_DSUOIjwExUPAh8EES0TOCMXLh4ZJgE as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
				{
					if ($orderprice <= $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money']) 
					{
						$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('uniacid' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['uniacid'], 'mid' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['mid'], 'money' => $orderprice, 'returnrule' => $_var_0['returnrule'], 'create_time' => time());
						pdo_insert('sz_yi_return', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI);
						pdo_update('sz_yi_return_money', array('money' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['money'] - $orderprice), array('id' => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['id'], 'uniacid' => $uniacid));
					}
				}
				$this->setmoney($orderprice, $_var_0, $uniacid);
			}
		}
	}
}
?>