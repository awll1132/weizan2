<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
if (!class_exists('CashierModel')) 
{
	class CashierModel extends PluginModel 
	{
		public function payResult($params) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DREWJTs9CywhDR0sHgQMLAQnDz8DJBE = $params['fee'];
			$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('status' => ($params['result'] == 'success' ? 1 : 0));
			$_obfuscate_DTUQOSQNKRoLOR0lEhQwKRQ5AiE9NRE = $params['tid'];
			$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select * from ' . tablename('sz_yi_order') . ' where  ordersn=:ordersn and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':ordersn' => $_obfuscate_DTUQOSQNKRoLOR0lEhQwKRQ5AiE9NRE));
			$_obfuscate_DT0fPQwrPT0_BTIVKA4wOwM9BBMRBCI = pdo_fetch('select * from ' . tablename('core_paylog') . ' where `uniacid`=:uniacid and fee=:fee and `module`=:module and `tid`=:tid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':module' => 'sz_yi', ':fee' => $_obfuscate_DREWJTs9CywhDR0sHgQMLAQnDz8DJBE, ':tid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn']));
			if (empty($_obfuscate_DT0fPQwrPT0_BTIVKA4wOwM9BBMRBCI)) 
			{
				show_json(-1, '订单金额错误, 请重试!');
				exit();
			}
			$_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI = $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id'];
			if ($params['from'] == 'return') 
			{
				if (($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['status'] == 0) || ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['status'] == 1)) 
				{
					pdo_update('sz_yi_order', array('status' => 3, 'paytime' => time(), 'finishtime' => time()), array('id' => $_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI));
					if (0 < $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductcredit2']) 
					{
						$_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE = m('common')->getSysset('shop');
						m('member')->setCredit($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'], 'credit2', -$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductcredit2'], array(0, $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '余额抵扣: ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductcredit2'] . ' 订单号: ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn']));
					}
					$this->setCredits($_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI);
					if ($params['type'] != 'wechat') 
					{
						m('notice')->sendOrderMessage($_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI);
					}
					if (p('commission')) 
					{
						$this->calculateCommission($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']);
					}
					$this->setCoupon($_obfuscate_DVwiNR8SQB84NRUWXDQUMwUsDhkCGyI);
				}
			}
		}
		public function setCredits($orderid, $forStatistics = false) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select id,ordersn,openid,price from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $orderid));
			$_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE = pdo_fetch('select * from ' . tablename('sz_yi_cashier_order') . ' o inner join ' . tablename('sz_yi_cashier_store') . ' s on o.cashier_store_id = s.id where o.order_id=:orderid and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $orderid));
			$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE = 0;
			if (0 < $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['credit1']) 
			{
				$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE += ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['price'] * $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['credit1']) / 100;
			}
			if (0 < $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE) 
			{
				if ($forStatistics) 
				{
					return $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE;
				}
				m('member')->setCredit($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'], 'credit1', $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE, array(0, '收银台奖励积分 订单号: ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn']));
			}
		}
		public function setCredits2($orderid, $forStatistics = false) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select id,ordersn,openid,price from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $orderid));
			$_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE = pdo_fetch('select * from ' . tablename('sz_yi_cashier_order') . ' o inner join ' . tablename('sz_yi_cashier_store') . ' s on o.cashier_store_id = s.id where o.order_id=:orderid and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $orderid));
			$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE = 0;
			if (0 < $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['creditpack']) 
			{
				$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE += ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['price'] * $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['creditpack']) / 100;
			}
			if (0 < $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE) 
			{
				if ($forStatistics) 
				{
					return $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE;
				}
				m('member')->setCredit($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'], 'credit2', $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE, array(0, '收银台奖励余额 订单号: ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn']));
			}
		}
		public function setCoupon($orderid) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DRgNCcPNhcGDCceDiYOMTsOMxI0ChE = p('coupon');
			if (!$_obfuscate_DRgNCcPNhcGDCceDiYOMTsOMxI0ChE) 
			{
				return NULL;
			}
			$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select * from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $orderid));
			$_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE = pdo_fetch('select * from ' . tablename('sz_yi_cashier_order') . ' o inner join ' . tablename('sz_yi_cashier_store') . ' s on o.cashier_store_id = s.id where o.order_id=:orderid and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $orderid));
			$_obfuscate_DR88FAkNOD45GhA1NigCi4yWwYeNyI = $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['coupon_id'];
			if (!$_obfuscate_DR88FAkNOD45GhA1NigCi4yWwYeNyI) 
			{
				return NULL;
			}
			$_obfuscate_DQ8NJC5cGjQ5BgkyJg4BJFsrHyY1GQE = $_obfuscate_DRgNCcPNhcGDCceDiYOMTsOMxI0ChE->getCoupon($_obfuscate_DR88FAkNOD45GhA1NigCi4yWwYeNyI);
			if (empty($_obfuscate_DQ8NJC5cGjQ5BgkyJg4BJFsrHyY1GQE)) 
			{
				return NULL;
			}
			$_obfuscate_DTYwKRMwKQUkGB45IyQbMxIqIRkWOBE = array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'openid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'], 'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'), 'couponid' => $_obfuscate_DR88FAkNOD45GhA1NigCi4yWwYeNyI, 'status' => 1, 'paystatus' => -1, 'creditstatus' => -1, 'createtime' => time(), 'getfrom' => 0);
			pdo_insert('sz_yi_coupon_log', $_obfuscate_DTYwKRMwKQUkGB45IyQbMxIqIRkWOBE);
			$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'openid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'], 'couponid' => $_obfuscate_DR88FAkNOD45GhA1NigCi4yWwYeNyI, 'gettype' => 0, 'gettime' => time());
			pdo_insert('sz_yi_coupon_data', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI);
		}
		public function calculateCommission($orderid, $forStatistics = false) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DTsLMTsnBgMiDjMNNAsCKiULCBwXKDI = p('commission');
			if (!$_obfuscate_DTsLMTsnBgMiDjMNNAsCKiULCBwXKDI) 
			{
				return NULL;
			}
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $_obfuscate_DTsLMTsnBgMiDjMNNAsCKiULCBwXKDI->getSet();
			$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select * from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $orderid));
			$_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE = pdo_fetch('select * from ' . tablename('sz_yi_cashier_order') . ' o inner join ' . tablename('sz_yi_cashier_store') . ' s on o.cashier_store_id = s.id where o.order_id=:orderid and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $orderid));
			if (0 < $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level']) 
			{
				$_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE = $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['price'];
				$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI = array();
				$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission1'] = array('default' => 0);
				$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission2'] = array('default' => 0);
				$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission3'] = array('default' => 0);
				if ((1 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level']) && (0 < $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['commission1_rate'])) 
				{
					$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission1'] = array('default' => round(($_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['commission1_rate'] * $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE) / 100, 2));
				}
				if ((2 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level']) && (0 < $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['commission2_rate'])) 
				{
					$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission2'] = array('default' => round(($_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['commission2_rate'] * $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE) / 100, 2));
				}
				if ((3 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level']) && (0 < $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['commission3_rate'])) 
				{
					$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission3'] = array('default' => round(($_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['commission3_rate'] * $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE) / 100, 2));
				}
				$_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE = array('level1' => 0, 'level2' => 0, 'level3' => 0);
				if (!empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'])) 
				{
					$_obfuscate_DQ8bFgcHgkiBwQdBzIrKAUoPwgVKDI = m('member')->getMember($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid']);
					$_obfuscate_DTkKBjZcCggfGwNbKggPJxVcJi8zNRE = array();
					if (($_obfuscate_DQ8bFgcHgkiBwQdBzIrKAUoPwgVKDI['isagent'] == 1) && ($_obfuscate_DQ8bFgcHgkiBwQdBzIrKAUoPwgVKDI['status'] == 1)) 
					{
						$_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE['level1'] = round($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission1']['default'], 2);
						$_obfuscate_DTkKBjZcCggfGwNbKggPJxVcJi8zNRE['commission1'] = iserializer($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission1']);
						if (!empty($_obfuscate_DQ8bFgcHgkiBwQdBzIrKAUoPwgVKDI['agentid'])) 
						{
							$_obfuscate_DRVcBzEJWwg3DiYuCi8XPQI1ER4KLiI = m('member')->getMember($_obfuscate_DQ8bFgcHgkiBwQdBzIrKAUoPwgVKDI['agentid']);
							$_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE['level2'] = round($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission2']['default'], 2);
							$_obfuscate_DTkKBjZcCggfGwNbKggPJxVcJi8zNRE['commission1'] = iserializer($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission1']);
							$_obfuscate_DTkKBjZcCggfGwNbKggPJxVcJi8zNRE['commission2'] = iserializer($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission2']);
							if (!empty($_obfuscate_DRVcBzEJWwg3DiYuCi8XPQI1ER4KLiI['agentid'])) 
							{
								$_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE['level3'] = round($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission3']['default'], 2);
								$_obfuscate_DTkKBjZcCggfGwNbKggPJxVcJi8zNRE['commission1'] = iserializer($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission1']);
								$_obfuscate_DTkKBjZcCggfGwNbKggPJxVcJi8zNRE['commission2'] = iserializer($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission2']);
								$_obfuscate_DTkKBjZcCggfGwNbKggPJxVcJi8zNRE['commission3'] = iserializer($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['commission3']);
							}
						}
					}
					$_obfuscate_DTkKBjZcCggfGwNbKggPJxVcJi8zNRE['commissions'] = iserializer($_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE);
					if ($forStatistics) 
					{
						$_obfuscate_DR8CXCRAWx1AOzE0NCQKW1whESIhAhE = 0;
						foreach ($_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE as $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI => $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE ) 
						{
							$_obfuscate_DR8CXCRAWx1AOzE0NCQKW1whESIhAhE += $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE;
						}
						return NULL;
					}
					pdo_update('sz_yi_order_goods', $_obfuscate_DTkKBjZcCggfGwNbKggPJxVcJi8zNRE, array('orderid' => $orderid));
				}
			}
		}
		public function redpack($openid, $orderid, $desc = '', $act_name = '', $remark = '') 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select id,ordersn,openid,price from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $orderid));
			$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = m('member')->getMember($openid);
			$_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE = pdo_fetch('select * from ' . tablename('sz_yi_cashier_order') . ' o inner join ' . tablename('sz_yi_cashier_store') . ' s on o.cashier_store_id = s.id where o.order_id=:orderid and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $orderid));
			if ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['price'] < $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['redpack_min']) 
			{
				return NULL;
			}
			$_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE = ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['price'] * $_obfuscate_DQ0DMiI5LwM1NCMRFzYXHCobKTcVFQE['redpack']) / 100;
			if (($_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE < 1) || (200 < $_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE)) 
			{
				$_obfuscate_DVxbOAY1EREoMxMtDTgLMQQbKi4rNgE = $_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE;
				m('member')->setCredit($openid, 'credit2', $_obfuscate_DVxbOAY1EREoMxMtDTgLMQQbKi4rNgE, array(0, '收银台红包奖励(超过红包最大金额限制,直接加到余额) 订单号: ' . $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn']));
				return NULL;
			}
			if (empty($openid)) 
			{
				return error(-1, 'openid不能为空');
			}
			$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = m('member')->getInfo($openid);
			if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI)) 
			{
				return error(-1, '未找到用户');
			}
			load()->model('payment');
			$_obfuscate_DR8GIywTBBEGKjwFDykVQD4nAhwnMyI = uni_setting($_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], array('payment'));
			if (!is_array($_obfuscate_DR8GIywTBBEGKjwFDykVQD4nAhwnMyI['payment'])) 
			{
				return error(1, '没有设定支付参数');
			}
			$_obfuscate_DQsoLyMTCjYmLgU8AkA3FRAEIxsIExE = m('common')->getSysset('pay');
			$_obfuscate_DREfIwMJAiMWAyYuQCU0Pz8lJDsLDQE = $_obfuscate_DR8GIywTBBEGKjwFDykVQD4nAhwnMyI['payment']['wechat'];
			$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'SELECT `key`,`secret`,`name` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
			$_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI = pdo_fetch($_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI, array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			$_obfuscate_DS4zHycKOScZFQQKh0tNBwOXD4lKhE = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
			$_obfuscate_DTIPASo8FiY_HFwrLCs4IRAjDAcCAwE = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			$_obfuscate_DVsTWyUnEFwbBhU9HRkwHB4WIhc0HyI = '';
			$_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI = 0;
			while ($_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI < 32) 
			{
				$_obfuscate_DVsTWyUnEFwbBhU9HRkwHB4WIhc0HyI .= substr($_obfuscate_DTIPASo8FiY_HFwrLCs4IRAjDAcCAwE, mt_rand(0, strlen($_obfuscate_DTIPASo8FiY_HFwrLCs4IRAjDAcCAwE) - 1), 1);
				++$_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI;
			}
			$_obfuscate_DTw3MC4GFT8yNyFbGxU2MBYoIS8hOxE = array('wxappid' => $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['key'], 'mch_id' => $_obfuscate_DREfIwMJAiMWAyYuQCU0Pz8lJDsLDQE['mchid'], 'mch_billno' => $_obfuscate_DRoLEywUFRxcOS0SKDILJUAICAoLHxE . date('YmdHis') . rand(1000, 9999), 'client_ip' => gethostbyname($_SERVER['HTTP_HOST']), 're_openid' => $openid, 'total_amount' => $_obfuscate_DTcIKjM0Ax9AMhs1BAIyFjg4MCYsIxE * 100, 'total_num' => 1, 'send_name' => $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['name'], 'wishing' => (empty($desc) ? '微信红包奖励' : $desc), 'act_name' => (empty($act_name) ? '红包奖励' : $act_name), 'remark' => (empty($remark) ? '红包奖励' : $remark), 'nonce_str' => $_obfuscate_DVsTWyUnEFwbBhU9HRkwHB4WIhc0HyI);
			ksort($_obfuscate_DTw3MC4GFT8yNyFbGxU2MBYoIS8hOxE);
			$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI = array();
			foreach ($_obfuscate_DTw3MC4GFT8yNyFbGxU2MBYoIS8hOxE as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DRU4BCk5K1sSPjE1BxcLKS0UJy0JEBE ) 
			{
				if (($_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE != 'sign') && ($_obfuscate_DRU4BCk5K1sSPjE1BxcLKS0UJy0JEBE != NULL) && ($_obfuscate_DRU4BCk5K1sSPjE1BxcLKS0UJy0JEBE != 'null')) 
				{
					$_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI[] = $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE . '=' . $_obfuscate_DRU4BCk5K1sSPjE1BxcLKS0UJy0JEBE;
				}
			}
			$_obfuscate_DQM8DxU0KRoHGDAHLwckXAVcDDsQNyI = implode('&', $_obfuscate_DQI7CBIMLCsOMQYLOCsTGgcKFD83NCI);
			$_obfuscate_DTxcETcJiISOShAIjQxNjkQIj09BwE = $_obfuscate_DQM8DxU0KRoHGDAHLwckXAVcDDsQNyI . '&key=' . $_obfuscate_DREfIwMJAiMWAyYuQCU0Pz8lJDsLDQE['apikey'];
			$_obfuscate_DTw3MC4GFT8yNyFbGxU2MBYoIS8hOxE['sign'] = strtoupper(md5($_obfuscate_DTxcETcJiISOShAIjQxNjkQIj09BwE));
			$_obfuscate_DRg0JTsxCB4sESYHy8WISkVIgsxHRE = array2xml($_obfuscate_DTw3MC4GFT8yNyFbGxU2MBYoIS8hOxE);
			$_obfuscate_DT0TDDEqKlwaNQEeXBwjCzImKyhcJyI = m('common')->getSec();
			$_obfuscate_DT4_Ezc8OSkLAw0dWyMjGisxOxYjCRE = iunserializer($_obfuscate_DT0TDDEqKlwaNQEeXBwjCzImKyhcJyI['sec']);
			if (is_array($_obfuscate_DT4_Ezc8OSkLAw0dWyMjGisxOxYjCRE)) 
			{
				if (empty($_obfuscate_DT4_Ezc8OSkLAw0dWyMjGisxOxYjCRE['cert']) || empty($_obfuscate_DT4_Ezc8OSkLAw0dWyMjGisxOxYjCRE['key']) || empty($_obfuscate_DT4_Ezc8OSkLAw0dWyMjGisxOxYjCRE['root'])) 
				{
					message('未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!', '', 'error');
				}
				$_obfuscate_DQIFPTYcAxkOORsBPiUfLRAeAgg_OSI = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
				file_put_contents($_obfuscate_DQIFPTYcAxkOORsBPiUfLRAeAgg_OSI, $_obfuscate_DT4_Ezc8OSkLAw0dWyMjGisxOxYjCRE['cert']);
				$_obfuscate_DScTFxI7PQ4vOTYGCUA7KgIwFCgrOAE = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
				file_put_contents($_obfuscate_DScTFxI7PQ4vOTYGCUA7KgIwFCgrOAE, $_obfuscate_DT4_Ezc8OSkLAw0dWyMjGisxOxYjCRE['key']);
				$_obfuscate_DSkqPBgwDh5AGgkkCxUUHQgTEyYULwE = IA_ROOT . '/addons/sz_yi/cert/' . random(128);
				file_put_contents($_obfuscate_DSkqPBgwDh5AGgkkCxUUHQgTEyYULwE, $_obfuscate_DT4_Ezc8OSkLAw0dWyMjGisxOxYjCRE['root']);
				$_obfuscate_DQUCFQQFBxoKLxwKPxERHBlcGh0rMzI = array('CURLOPT_SSLCERT' => $_obfuscate_DQIFPTYcAxkOORsBPiUfLRAeAgg_OSI, 'CURLOPT_SSLKEY' => $_obfuscate_DScTFxI7PQ4vOTYGCUA7KgIwFCgrOAE, 'CURLOPT_CAINFO' => $_obfuscate_DSkqPBgwDh5AGgkkCxUUHQgTEyYULwE);
			}
			else 
			{
				message('未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!', '', 'error');
			}
			load()->func('communication');
			$_obfuscate_DRQlLhUiOS4vAjYbKCsnNRI4Gg0aNCI = ihttp_request($_obfuscate_DS4zHycKOScZFQQKh0tNBwOXD4lKhE, $_obfuscate_DRg0JTsxCB4sESYHy8WISkVIgsxHRE, $_obfuscate_DQUCFQQFBxoKLxwKPxERHBlcGh0rMzI);
			@unlink($_obfuscate_DQIFPTYcAxkOORsBPiUfLRAeAgg_OSI);
			@unlink($_obfuscate_DScTFxI7PQ4vOTYGCUA7KgIwFCgrOAE);
			@unlink($_obfuscate_DSkqPBgwDh5AGgkkCxUUHQgTEyYULwE);
			if (is_error($_obfuscate_DRQlLhUiOS4vAjYbKCsnNRI4Gg0aNCI)) 
			{
				return error(-2, $_obfuscate_DRQlLhUiOS4vAjYbKCsnNRI4Gg0aNCI['message']);
			}
			if (empty($_obfuscate_DRQlLhUiOS4vAjYbKCsnNRI4Gg0aNCI['content'])) 
			{
				return error(-2, '网络错误');
			}
			$_obfuscate_DRkiMh4XJDc8FT00KAYDMREPMQkbHDI = json_decode(json_encode((array) simplexml_load_string($_obfuscate_DRQlLhUiOS4vAjYbKCsnNRI4Gg0aNCI['content'])), true);
			$_obfuscate_DScGEyxbFQo5DyYdKRgQBxo3Ci0cFhE = '<?xml version="1.0" encoding="utf-8"?>' . $_obfuscate_DRQlLhUiOS4vAjYbKCsnNRI4Gg0aNCI['content'];
			$_obfuscate_DT0yFA8WKDQ_DzEoEA8wJhI4EAImGyI = new DOMDocument();
			if ($_obfuscate_DT0yFA8WKDQ_DzEoEA8wJhI4EAImGyI->loadXML($_obfuscate_DScGEyxbFQo5DyYdKRgQBxo3Ci0cFhE)) 
			{
				$_obfuscate_DQ00GiQkIVsMAjsKIT8PDx0ONx0EFCI = new DOMXPath($_obfuscate_DT0yFA8WKDQ_DzEoEA8wJhI4EAImGyI);
				$_obfuscate_DRweBFwyPyJAAwIpNyEzAVsjESkhKyI = $_obfuscate_DQ00GiQkIVsMAjsKIT8PDx0ONx0EFCI->evaluate('string(//xml/return_code)');
				$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI = $_obfuscate_DQ00GiQkIVsMAjsKIT8PDx0ONx0EFCI->evaluate('string(//xml/result_code)');
				if ((strtolower($_obfuscate_DRweBFwyPyJAAwIpNyEzAVsjESkhKyI) == 'success') && (strtolower($_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI) == 'success')) 
				{
					return true;
				}
				if ($_obfuscate_DQ00GiQkIVsMAjsKIT8PDx0ONx0EFCI->evaluate('string(//xml/return_msg)') == $_obfuscate_DQ00GiQkIVsMAjsKIT8PDx0ONx0EFCI->evaluate('string(//xml/err_code_des)')) 
				{
					$_obfuscate_DRULGyNcGyw5JB41Wz0oBj8zFCsrNDI = $_obfuscate_DQ00GiQkIVsMAjsKIT8PDx0ONx0EFCI->evaluate('string(//xml/return_msg)');
				}
				else 
				{
					$_obfuscate_DRULGyNcGyw5JB41Wz0oBj8zFCsrNDI = $_obfuscate_DQ00GiQkIVsMAjsKIT8PDx0ONx0EFCI->evaluate('string(//xml/return_msg)') . '<br/>' . $_obfuscate_DQ00GiQkIVsMAjsKIT8PDx0ONx0EFCI->evaluate('string(//xml/err_code_des)');
				}
				if (!empty($orderid)) 
				{
					$_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI = 'SELECT `ordersn` FROM ' . tablename('sz_yi_order') . ' WHERE `id`=:orderid limit 1';
					$_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI = pdo_fetch($_obfuscate_DUAvPB9ADzQrNzICGzYhIQkWGRFcKiI, array(':orderid' => $orderid));
					$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => '收银台收款发送红包失败', 'color' => '#73a68d'), 'keyword2' => array('value' => '【订单编号】' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['ordersn'], 'color' => '#73a68d'), 'remark' => array('value' => '收银台收款红包发送失败！失败原因：' . $_obfuscate_DRULGyNcGyw5JB41Wz0oBj8zFCsrNDI) );
					pdo_update('sz_yi_order', array('redstatus' => $_obfuscate_DRULGyNcGyw5JB41Wz0oBj8zFCsrNDI), array('id' => $orderid));
					m('message')->sendCustomNotice($openid, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
				}
				return error(-2, $_obfuscate_DRULGyNcGyw5JB41Wz0oBj8zFCsrNDI);
			}
			return error(-1, '未知错误');
		}
	}
}
?>