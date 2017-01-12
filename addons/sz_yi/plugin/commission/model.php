<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
define('TM_COMMISSION_AGENT_NEW', 'commission_agent_new');
define('TM_COMMISSION_ORDER_PAY', 'commission_order_pay');
define('TM_COMMISSION_ORDER_FINISH', 'commission_order_finish');
define('TM_COMMISSION_APPLY', 'commission_apply');
define('TM_COMMISSION_CHECK', 'commission_check');
define('TM_COMMISSION_PAY', 'commission_pay');
define('TM_COMMISSION_UPGRADE', 'commission_upgrade');
define('TM_COMMISSION_BECOME', 'commission_become');
if (!class_exists('CommissionModel')) 
{
	class CommissionModel extends PluginModel 
	{
		public function getSet() 
		{
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = parent::getSet();
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts'] = array('agent' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['agent']) ? '分销商' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['agent']), 'shop' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['shop']) ? '小店' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['shop']), 'myshop' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['myshop']) ? '我的小店' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['myshop']), 'center' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['center']) ? '分销中心' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['center']), 'become' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['become']) ? '成为分销商' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['become']), 'withdraw' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['withdraw']) ? '提现' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['withdraw']), 'commission' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission']) ? '佣金' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission']), 'commission1' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission1']) ? '分销佣金' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission1']), 'commission_total' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_total']) ? '累计佣金' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_total']), 'commission_ok' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_ok']) ? '可提现佣金' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_ok']), 'commission_apply' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_apply']) ? '已申请佣金' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_apply']), 'commission_check' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_check']) ? '待打款佣金' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_check']), 'commission_lock' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_lock']) ? '未结算佣金' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_lock']), 'commission_detail' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_detail']) ? '佣金明细' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_detail']), 'commission_pay' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_pay']) ? '成功提现佣金' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['commission_pay']), 'order' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['order']) ? '分销订单' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['order']), 'myteam' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['myteam']) ? '我的团队' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['myteam']), 'c1' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['c1']) ? '一级' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['c1']), 'c2' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['c2']) ? '二级' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['c2']), 'c3' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['c3']) ? '三级' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['c3']), 'mycustomer' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['mycustomer']) ? '我的客户' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['mycustomer']));
			return $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI;
		}
		public function calculate($orderid = 0, $update = true) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			$_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE = $this->getLevels();
			$_obfuscate_DS0TBSoIFAsoCCojOSsLKBEZCywmFQE = pdo_fetchcolumn('select agentid from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $orderid));
			$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = pdo_fetchall('select og.id,og.realprice,og.total,g.hascommission,g.nocommission, g.commission1_rate,g.commission1_pay,g.commission2_rate,g.commission2_pay,g.commission3_rate,g.commission3_pay,og.commissions,og.optionid,g.productprice,g.marketprice,g.costprice from ' . tablename('sz_yi_order_goods') . '  og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id = og.goodsid' . ' where og.orderid=:orderid and og.uniacid=:uniacid', array(':orderid' => $orderid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			if (0 < $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level']) 
			{
				foreach ($_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE as $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE ) 
				{
					$_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE = $this->calculate_method($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE);
					if (empty($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['nocommission']) && (0 < $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE)) 
					{
						if ($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['hascommission'] == 1) 
						{
							$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1'] = array('default' => (1 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? ((0 < $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1_rate'] ? round(($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1_rate'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1_pay'] * $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['total'], 2))) : 0));
							$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2'] = array('default' => (2 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? ((0 < $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2_rate'] ? round(($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2_rate'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2_pay'] * $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['total'], 2))) : 0));
							$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3'] = array('default' => (3 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? ((0 < $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3_rate'] ? round(($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3_rate'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3_pay'] * $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['total'], 2))) : 0));
							foreach ($_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE as $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI ) 
							{
								$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1']['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id']] = (0 < $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1_rate'] ? round(($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1_rate'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1_pay'] * $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['total'], 2));
								$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2']['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id']] = (0 < $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2_rate'] ? round(($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2_rate'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2_pay'] * $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['total'], 2));
								$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3']['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id']] = (0 < $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3_rate'] ? round(($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3_rate'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3_pay'] * $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['total'], 2));
							}
						}
						else 
						{
							$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1'] = array('default' => (1 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? round(($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission1'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : 0));
							$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2'] = array('default' => (2 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? round(($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission2'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : 0));
							$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3'] = array('default' => (3 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? round(($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission3'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : 0));
							foreach ($_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE as $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI ) 
							{
								$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1']['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id']] = (1 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? round(($_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['commission1'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : 0);
								$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2']['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id']] = (2 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? round(($_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['commission2'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : 0);
								$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3']['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id']] = (3 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? round(($_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['commission3'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) . '' : 0);
							}
						}
					}
					else 
					{
						$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1'] = array('default' => 0);
						$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2'] = array('default' => 0);
						$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3'] = array('default' => 0);
						foreach ($_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE as $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI ) 
						{
							$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1']['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id']] = 0;
							$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2']['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id']] = 0;
							$_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3']['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id']] = 0;
						}
					}
					if ($update) 
					{
						$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI = array('level1' => 0, 'level2' => 0, 'level3' => 0);
						if (!empty($_obfuscate_DS0TBSoIFAsoCCojOSsLKBEZCywmFQE)) 
						{
							$_obfuscate_DQsYKz0EMjQQDTsUIgETEB9cFiYDCSI = m('member')->getMember($_obfuscate_DS0TBSoIFAsoCCojOSsLKBEZCywmFQE);
							if (($_obfuscate_DQsYKz0EMjQQDTsUIgETEB9cFiYDCSI['isagent'] == 1) && ($_obfuscate_DQsYKz0EMjQQDTsUIgETEB9cFiYDCSI['status'] == 1)) 
							{
								$_obfuscate_DTQsARgZAlsHBT8cEzkCMB8XLDA_EiI = $this->getLevel($_obfuscate_DQsYKz0EMjQQDTsUIgETEB9cFiYDCSI['openid']);
								$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['level1'] = (empty($_obfuscate_DTQsARgZAlsHBT8cEzkCMB8XLDA_EiI) ? round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1']['default'], 2) : round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1']['level' . $_obfuscate_DTQsARgZAlsHBT8cEzkCMB8XLDA_EiI['id']], 2));
								if (!empty($_obfuscate_DQsYKz0EMjQQDTsUIgETEB9cFiYDCSI['agentid'])) 
								{
									$_obfuscate_DRgfHj8dLA0uNwUmEFs4MSYWJz0ZFBE = m('member')->getMember($_obfuscate_DQsYKz0EMjQQDTsUIgETEB9cFiYDCSI['agentid']);
									$_obfuscate_DRENIxYbCjAKExEoHCcWJT85NT4jMDI = $this->getLevel($_obfuscate_DRgfHj8dLA0uNwUmEFs4MSYWJz0ZFBE['openid']);
									$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['level2'] = (empty($_obfuscate_DRENIxYbCjAKExEoHCcWJT85NT4jMDI) ? round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2']['default'], 2) : round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2']['level' . $_obfuscate_DRENIxYbCjAKExEoHCcWJT85NT4jMDI['id']], 2));
									if (!empty($_obfuscate_DRgfHj8dLA0uNwUmEFs4MSYWJz0ZFBE['agentid'])) 
									{
										$_obfuscate_DQkXBSEwE1wVLCwhLh1cFh4WDQQ_ECI = m('member')->getMember($_obfuscate_DRgfHj8dLA0uNwUmEFs4MSYWJz0ZFBE['agentid']);
										$_obfuscate_DUAlARgaJiwyFjQ2GAtcDzIYPyYpNgE = $this->getLevel($_obfuscate_DQkXBSEwE1wVLCwhLh1cFh4WDQQ_ECI['openid']);
										$_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI['level3'] = (empty($_obfuscate_DUAlARgaJiwyFjQ2GAtcDzIYPyYpNgE) ? round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3']['default'], 2) : round($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3']['level' . $_obfuscate_DUAlARgaJiwyFjQ2GAtcDzIYPyYpNgE['id']], 2));
									}
								}
							}
						}
						pdo_update('sz_yi_order_goods', array('commission1' => iserializer($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission1']), 'commission2' => iserializer($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission2']), 'commission3' => iserializer($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['commission3']), 'commissions' => iserializer($_obfuscate_DQVcJQICHA88JTEQKwEuJDwRQC8RDjI), 'nocommission' => $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['nocommission']), array('id' => $_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE['id']));
					}
				}
				unset($_obfuscate_DSsaFwY9BzYcPztbHAo2FRMNQDI8IxE);
			}
			return $_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE;
		}
		public function calculate_method($order_goods) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			$_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE = $order_goods['realprice'];
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'])) 
			{
				return $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE;
			}
			if ($order_goods['optionid'] != 0) 
			{
				$_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI = pdo_fetch('select productprice,marketprice,costprice from ' . tablename('sz_yi_goods_option') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $order_goods['optionid'], ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
				$_obfuscate_DRwuER0jBkAdNAg8HSURHSwhAQUpQDI = $_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI['productprice'] * $order_goods['total'];
				$_obfuscate_DRMQBBoWJVseNS8MESUESoDJj9ANTI = $_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI['marketprice'] * $order_goods['total'];
				$_obfuscate_DSctGhsIEDUOIzUUHxwlPhUYFBMyFyI = $_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI['costprice'] * $order_goods['total'];
			}
			else 
			{
				$_obfuscate_DRwuER0jBkAdNAg8HSURHSwhAQUpQDI = $order_goods['productprice'] * $order_goods['total'];
				$_obfuscate_DRMQBBoWJVseNS8MESUESoDJj9ANTI = $order_goods['marketprice'] * $order_goods['total'];
				$_obfuscate_DSctGhsIEDUOIzUUHxwlPhUYFBMyFyI = $order_goods['costprice'] * $order_goods['total'];
			}
			if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'] == 1) 
			{
				return $_obfuscate_DRwuER0jBkAdNAg8HSURHSwhAQUpQDI;
			}
			if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'] == 2) 
			{
				return $_obfuscate_DRMQBBoWJVseNS8MESUESoDJj9ANTI;
			}
			if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'] == 3) 
			{
				return $_obfuscate_DSctGhsIEDUOIzUUHxwlPhUYFBMyFyI;
			}
			if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'] == 4) 
			{
				$_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE = $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE - $_obfuscate_DSctGhsIEDUOIzUUHxwlPhUYFBMyFyI;
				return (0 < $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE ? $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE : 0);
			}
		}
		public function getOrderCommissions($_var_1 = 0, $_var_16 = 0) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			$_obfuscate_DSM_BA49ARIbCSoHGTk7GxoSBxwPBE = pdo_fetchcolumn('select agentid from ' . tablename('sz_yi_order') . ' where id=:id limit 1', array(':id' => $_var_1));
			$_obfuscate_DSYtMxMJFAUMCBk_E0A3ED4HGiY5PgE = pdo_fetch('select commission1,commission2,commission3 from ' . tablename('sz_yi_order_goods') . ' where id=:id and orderid=:orderid and uniacid=:uniacid and nocommission=0 limit 1', array(':id' => $_var_16, ':orderid' => $_var_1, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = array('level1' => 0, 'level2' => 0, 'level3' => 0);
			if (0 < $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level']) 
			{
				$_obfuscate_DTQaEQQdOAcCJTUBBCQ2Gg4WNDAoEDI = iunserializer($_obfuscate_DSYtMxMJFAUMCBk_E0A3ED4HGiY5PgE['commission1']);
				$_obfuscate_DSRbHQ0iHTg8DD8QDSQyWwwmJSoxPSI = iunserializer($_obfuscate_DSYtMxMJFAUMCBk_E0A3ED4HGiY5PgE['commission2']);
				$_obfuscate_DT4FMTgCBBwlEho5QA8GCScMKUAtGxE = iunserializer($_obfuscate_DSYtMxMJFAUMCBk_E0A3ED4HGiY5PgE['commission3']);
				if (!empty($_obfuscate_DSM_BA49ARIbCSoHGTk7GxoSBxwPBE)) 
				{
					$_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE = m('member')->getMember($_obfuscate_DSM_BA49ARIbCSoHGTk7GxoSBxwPBE);
					if (($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['isagent'] == 1) && ($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['status'] == 1)) 
					{
						$_obfuscate_DQsbPDQZCgULMRRALBEdLwNbBzUeJhE = $this->getLevel($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['openid']);
						$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1'] = (empty($_obfuscate_DQsbPDQZCgULMRRALBEdLwNbBzUeJhE) ? round($_obfuscate_DTQaEQQdOAcCJTUBBCQ2Gg4WNDAoEDI['default'], 2) : round($_obfuscate_DTQaEQQdOAcCJTUBBCQ2Gg4WNDAoEDI['level' . $_obfuscate_DQsbPDQZCgULMRRALBEdLwNbBzUeJhE['id']], 2));
						if (!empty($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['agentid'])) 
						{
							$_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE = m('member')->getMember($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['agentid']);
							$_obfuscate_DSkxAjwnEiYNJyUmOBEfDjguNRMGGyI = $this->getLevel($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['openid']);
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2'] = (empty($_obfuscate_DSkxAjwnEiYNJyUmOBEfDjguNRMGGyI) ? round($_obfuscate_DSRbHQ0iHTg8DD8QDSQyWwwmJSoxPSI['default'], 2) : round($_obfuscate_DSRbHQ0iHTg8DD8QDSQyWwwmJSoxPSI['level' . $_obfuscate_DSkxAjwnEiYNJyUmOBEfDjguNRMGGyI['id']], 2));
							if (!empty($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['agentid'])) 
							{
								$_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE = m('member')->getMember($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['agentid']);
								$_obfuscate_DQ42FBMdFz8bHAY2JAMbFBsOIwomEhE = $this->getLevel($_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE['openid']);
								$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3'] = (empty($_obfuscate_DQ42FBMdFz8bHAY2JAMbFBsOIwomEhE) ? round($_obfuscate_DT4FMTgCBBwlEho5QA8GCScMKUAtGxE['default'], 2) : round($_obfuscate_DT4FMTgCBBwlEho5QA8GCScMKUAtGxE['level' . $_obfuscate_DQ42FBMdFz8bHAY2JAMbFBsOIwomEhE['id']], 2));
							}
						}
					}
				}
			}
			return $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE;
		}
		public function getInfo($_var_20, $_var_21 = NULL) 
		{
			if (empty($_var_21) || !is_array($_var_21)) 
			{
				$_var_21 = array();
			}
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			$_obfuscate_DRA8ETkUKzAOEj00FDUeNRIfNCcdJjI = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level']);
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE = m('member')->getMember($_var_20);
			$_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE = $this->getLevel($_var_20);
			$_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI = time();
			$_obfuscate_DSgQBhUlLTIGFS4dOwoJFA5cByITFyI = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['settledays']) * 3600 * 24;
			$_obfuscate_DR0bCDMNMiU1BhEnAQwELwEHDwEIMyI = 0;
			$_obfuscate_DQsSIhwlJBkaHRIkDjYhCQ4qAwYbDTI = 0;
			$_obfuscate_DShAJzghPTUyLR48BAUOGzEmFR43CBE = 0;
			$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI = 0;
			$_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI = 0;
			$_obfuscate_DRUvMDBbGA8QQCYmJSEeAzsaJyQaIiI = 0;
			$_obfuscate_DSkMLjEfEwoCBiUPJx8LFjlAPQVcGQE = 0;
			$_obfuscate_DTMGhsjHjcFHgs5HT0jCTcnCCsiPBE = 0;
			$_obfuscate_DVwsIzUoBjM8GCMsLjMIFjQ7CC8fIiI = 0;
			$_obfuscate_DR4rDQgfNAsKMAQkIz43WwcvBz4kEQE = 0;
			$_obfuscate_DTgwOR42Cz4YPR9bIyIeKUAMNyUsKBE = 0;
			$_obfuscate_DTsPWyUlFSgFDBgFNB8iG1sZBw42CCI = 0;
			$_obfuscate_DTsFEhMSPjkuNEAcCRoXKCYTJjM8FDI = 0;
			$_obfuscate_DSgMECsIMR0_LhQwHDgBDhkFJTkDHAE = 0;
			$_obfuscate_DRobOCcVFRQLATdcPDwmXD8BKjEOAxE = 0;
			$_obfuscate_DQkfOBYFIR0GLTwjEjItMyobJgsRDSI = 0;
			$_obfuscate_DS8JJzAWPAMGIhY1FCwwPhIxHBMSHRE = 0;
			$_obfuscate_DTkTGiI9FDELFiI7LCYuPQQoGBEKHiI = 0;
			$_obfuscate_DRk_OBg7IxIkOTwCGkAeMwEaOyMzDTI = 0;
			$_obfuscate_DTQ_BA0OJTcYMhgkHScTFisMJQgRMwE = 0;
			$_obfuscate_DR0mLQs7ASsjGTcdPx8wIwQ0PzMJDzI = 0;
			$_obfuscate_DQEMDTg2Gh48EQkhEwwMPREKLwUtAwE = 0;
			$_obfuscate_DQ4vHBcZGBY_MBtbA1w9AQ9AEDJbFyI = 0;
			$_obfuscate_DRoyNgMOLR8PMRMYAg44MgsPFUAWOSI = 0;
			$_obfuscate_DTgBFwyGBcFKCIPJDMyEAQnPDMQPAE = 0;
			$_obfuscate_DR8KITUWOS4YCBMDPh0fIx0yNVwqCyI = 0;
			$_obfuscate_DVwkNR4vDgEsHCsCFBYjFhwIIQMOJBE = 0;
			$_obfuscate_DRg9FD0jJQEbPh0RCR0RCwcUPhYeAyI = 0;
			$_obfuscate_DRk3Bh4kHAISHEBcCggZBx0cKjMCJyI = 0;
			$_obfuscate_DSQQFiwQHDspLgYCNSg0OS8VWy44FgE = 0;
			if (1 <= $_obfuscate_DRA8ETkUKzAOEj00FDUeNRIfNCcdJjI) 
			{
				if (in_array('ordercount0', $_var_21)) 
				{
					$_obfuscate_DSkmPS4pMRoLHRkuPy89Gy4hFysPAyI = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid=:agentid and o.status>=0 and og.status1>=0 and og.nocommission=0 and o.uniacid=:uniacid  limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					$_obfuscate_DS8JJzAWPAMGIhY1FCwwPhIxHBMSHRE += $_obfuscate_DSkmPS4pMRoLHRkuPy89Gy4hFysPAyI['ordercount'];
					$_obfuscate_DQsSIhwlJBkaHRIkDjYhCQ4qAwYbDTI += $_obfuscate_DSkmPS4pMRoLHRkuPy89Gy4hFysPAyI['ordercount'];
					$_obfuscate_DShAJzghPTUyLR48BAUOGzEmFR43CBE += $_obfuscate_DSkmPS4pMRoLHRkuPy89Gy4hFysPAyI['ordermoney'];
				}
				if (in_array('ordercount', $_var_21)) 
				{
					$_obfuscate_DSkmPS4pMRoLHRkuPy89Gy4hFysPAyI = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid=:agentid and o.status>=1 and og.status1>=0 and og.nocommission=0 and o.uniacid=:uniacid  limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					$_obfuscate_DTQ_BA0OJTcYMhgkHScTFisMJQgRMwE += $_obfuscate_DSkmPS4pMRoLHRkuPy89Gy4hFysPAyI['ordercount'];
					$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI += $_obfuscate_DSkmPS4pMRoLHRkuPy89Gy4hFysPAyI['ordercount'];
					$_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI += $_obfuscate_DSkmPS4pMRoLHRkuPy89Gy4hFysPAyI['ordermoney'];
				}
				if (in_array('ordercount3', $_var_21)) 
				{
					$_obfuscate_DSklIyYTHSwJNzUFGjMUECsiNhkBCCI = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid=:agentid and o.status>=3 and og.status1>=0 and og.nocommission=0 and o.uniacid=:uniacid  limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					$_obfuscate_DQ4vHBcZGBY_MBtbA1w9AQ9AEDJbFyI += $_obfuscate_DSklIyYTHSwJNzUFGjMUECsiNhkBCCI['ordercount'];
					$_obfuscate_DRUvMDBbGA8QQCYmJSEeAzsaJyQaIiI += $_obfuscate_DSklIyYTHSwJNzUFGjMUECsiNhkBCCI['ordercount'];
					$_obfuscate_DSkMLjEfEwoCBiUPJx8LFjlAPQVcGQE += $_obfuscate_DSklIyYTHSwJNzUFGjMUECsiNhkBCCI['ordermoney'];
					$_obfuscate_DR8KITUWOS4YCBMDPh0fIx0yNVwqCyI += $_obfuscate_DSklIyYTHSwJNzUFGjMUECsiNhkBCCI['ordermoney'];
				}
				if (in_array('total', $_var_21)) 
				{
					$_obfuscate_DTQ8ClsdEwQwMjc4PjspPBAwBVwVFxE = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					foreach ($_obfuscate_DTQ8ClsdEwQwMjc4PjspPBAwBVwVFxE as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
					{
						$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
						$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission1']);
						if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
						{
							$_obfuscate_DTMGhsjHjcFHgs5HT0jCTcnCCsiPBE += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
						}
						else 
						{
							$_obfuscate_DTMGhsjHjcFHgs5HT0jCTcnCCsiPBE += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1']) ? floatval($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1']) : 0));
						}
					}
				}
				if (in_array('ok', $_var_21)) 
				{
					$_obfuscate_DTQ8ClsdEwQwMjc4PjspPBAwBVwVFxE = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=3 and og.nocommission=0 and (' . $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI . ' - o.createtime > ' . $_obfuscate_DSgQBhUlLTIGFS4dOwoJFA5cByITFyI . ') and og.status1=0  and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					foreach ($_obfuscate_DTQ8ClsdEwQwMjc4PjspPBAwBVwVFxE as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
					{
						$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
						$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission1']);
						if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
						{
							$_obfuscate_DVwsIzUoBjM8GCMsLjMIFjQ7CC8fIiI += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
						}
						else 
						{
							$_obfuscate_DVwsIzUoBjM8GCMsLjMIFjQ7CC8fIiI += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1'] : 0));
						}
					}
				}
				if (in_array('lock', $_var_21)) 
				{
					$_obfuscate_DQhAHjQWQB8XCA0HHTcBOCgQJj5bDjI = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=3 and og.nocommission=0 and (' . $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI . ' - o.createtime <= ' . $_obfuscate_DSgQBhUlLTIGFS4dOwoJFA5cByITFyI . ')  and og.status1=0  and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					foreach ($_obfuscate_DQhAHjQWQB8XCA0HHTcBOCgQJj5bDjI as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
					{
						$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
						$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission1']);
						if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
						{
							$_obfuscate_DTsPWyUlFSgFDBgFNB8iG1sZBw42CCI += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
						}
						else 
						{
							$_obfuscate_DTsPWyUlFSgFDBgFNB8iG1sZBw42CCI += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1'] : 0));
						}
					}
				}
				if (in_array('apply', $_var_21)) 
				{
					$_obfuscate_DQU5DQ8aPj4fKysOKCwSNiMuKgYXDzI = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=3 and og.status1=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					foreach ($_obfuscate_DQU5DQ8aPj4fKysOKCwSNiMuKgYXDzI as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
					{
						$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
						$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission1']);
						if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
						{
							$_obfuscate_DR4rDQgfNAsKMAQkIz43WwcvBz4kEQE += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
						}
						else 
						{
							$_obfuscate_DR4rDQgfNAsKMAQkIz43WwcvBz4kEQE += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1'] : 0));
						}
					}
				}
				if (in_array('check', $_var_21)) 
				{
					$_obfuscate_DQU5DQ8aPj4fKysOKCwSNiMuKgYXDzI = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=3 and og.status1=2 and og.nocommission=0 and o.uniacid=:uniacid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					foreach ($_obfuscate_DQU5DQ8aPj4fKysOKCwSNiMuKgYXDzI as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
					{
						$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
						$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission1']);
						if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
						{
							$_obfuscate_DTgwOR42Cz4YPR9bIyIeKUAMNyUsKBE += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
						}
						else 
						{
							$_obfuscate_DTgwOR42Cz4YPR9bIyIeKUAMNyUsKBE += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1'] : 0));
						}
					}
				}
				if (in_array('pay', $_var_21)) 
				{
					$_obfuscate_DQU5DQ8aPj4fKysOKCwSNiMuKgYXDzI = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=3 and og.status1=3 and og.nocommission=0 and o.uniacid=:uniacid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					foreach ($_obfuscate_DQU5DQ8aPj4fKysOKCwSNiMuKgYXDzI as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
					{
						$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
						$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission1']);
						if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
						{
							$_obfuscate_DTsFEhMSPjkuNEAcCRoXKCYTJjM8FDI += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
						}
						else 
						{
							$_obfuscate_DTsFEhMSPjkuNEAcCRoXKCYTJjM8FDI += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level1'] : 0));
						}
					}
				}
				$_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI = pdo_fetchall('select id from ' . tablename('sz_yi_member') . ' where agentid=:agentid and isagent=1 and status=1 and uniacid=:uniacid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':agentid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']), 'id');
				$_obfuscate_DSgMECsIMR0_LhQwHDgBDhkFJTkDHAE = count($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI);
				$_obfuscate_DR0bCDMNMiU1BhEnAQwELwEHDwEIMyI += $_obfuscate_DSgMECsIMR0_LhQwHDgBDhkFJTkDHAE;
			}
			if (2 <= $_obfuscate_DRA8ETkUKzAOEj00FDUeNRIfNCcdJjI) 
			{
				if (0 < $_obfuscate_DSgMECsIMR0_LhQwHDgBDhkFJTkDHAE) 
				{
					if (in_array('ordercount0', $_var_21)) 
					{
						$_obfuscate_DTQvBBcGB8WXDwaIh4IHjguFTExPQE = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ')  and o.status>=0 and og.status2>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						$_obfuscate_DTkTGiI9FDELFiI7LCYuPQQoGBEKHiI += $_obfuscate_DTQvBBcGB8WXDwaIh4IHjguFTExPQE['ordercount'];
						$_obfuscate_DQsSIhwlJBkaHRIkDjYhCQ4qAwYbDTI += $_obfuscate_DTQvBBcGB8WXDwaIh4IHjguFTExPQE['ordercount'];
						$_obfuscate_DShAJzghPTUyLR48BAUOGzEmFR43CBE += $_obfuscate_DTQvBBcGB8WXDwaIh4IHjguFTExPQE['ordermoney'];
					}
					if (in_array('ordercount', $_var_21)) 
					{
						$_obfuscate_DTQvBBcGB8WXDwaIh4IHjguFTExPQE = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ')  and o.status>=1 and og.status2>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						$_obfuscate_DR0mLQs7ASsjGTcdPx8wIwQ0PzMJDzI += $_obfuscate_DTQvBBcGB8WXDwaIh4IHjguFTExPQE['ordercount'];
						$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI += $_obfuscate_DTQvBBcGB8WXDwaIh4IHjguFTExPQE['ordercount'];
						$_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI += $_obfuscate_DTQvBBcGB8WXDwaIh4IHjguFTExPQE['ordermoney'];
					}
					if (in_array('ordercount3', $_var_21)) 
					{
						$_obfuscate_DSwnCiQeCg8iFQsPLg4SBh49KQIBLQE = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ')  and o.status>=3 and og.status2>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						$_obfuscate_DRoyNgMOLR8PMRMYAg44MgsPFUAWOSI += $_obfuscate_DSwnCiQeCg8iFQsPLg4SBh49KQIBLQE['ordercount'];
						$_obfuscate_DRUvMDBbGA8QQCYmJSEeAzsaJyQaIiI += $_obfuscate_DSwnCiQeCg8iFQsPLg4SBh49KQIBLQE['ordercount'];
						$_obfuscate_DSkMLjEfEwoCBiUPJx8LFjlAPQVcGQE += $_obfuscate_DSwnCiQeCg8iFQsPLg4SBh49KQIBLQE['ordermoney'];
						$_obfuscate_DVwkNR4vDgEsHCsCFBYjFhwIIQMOJBE += $_obfuscate_DSwnCiQeCg8iFQsPLg4SBh49KQIBLQE['ordermoney'];
					}
					if (in_array('total', $_var_21)) 
					{
						$_obfuscate_DSQeIT4jEhkjBkA5OT5bFhEaXDYsITI = pdo_fetchall('select og.commission2,og.commissions from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ')  and o.status>=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DSQeIT4jEhkjBkA5OT5bFhEaXDYsITI as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission2']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DTMGhsjHjcFHgs5HT0jCTcnCCsiPBE += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DTMGhsjHjcFHgs5HT0jCTcnCCsiPBE += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2'] : 0));
							}
						}
					}
					if (in_array('ok', $_var_21)) 
					{
						$_obfuscate_DSQeIT4jEhkjBkA5OT5bFhEaXDYsITI = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ')  and (' . $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI . ' - o.createtime > ' . $_obfuscate_DSgQBhUlLTIGFS4dOwoJFA5cByITFyI . ') and o.status>=3 and og.status2=0 and og.nocommission=0  and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DSQeIT4jEhkjBkA5OT5bFhEaXDYsITI as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission2']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DVwsIzUoBjM8GCMsLjMIFjQ7CC8fIiI += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DVwsIzUoBjM8GCMsLjMIFjQ7CC8fIiI += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2'] : 0));
							}
						}
					}
					if (in_array('lock', $_var_21)) 
					{
						$_obfuscate_DR0KjIhPSgsMS0RGS03FgwPDcNFgE = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ')  and (' . $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI . ' - o.createtime <= ' . $_obfuscate_DSgQBhUlLTIGFS4dOwoJFA5cByITFyI . ') and og.status2=0 and o.status>=3 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DR0KjIhPSgsMS0RGS03FgwPDcNFgE as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission2']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DTsPWyUlFSgFDBgFNB8iG1sZBw42CCI += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DTsPWyUlFSgFDBgFNB8iG1sZBw42CCI += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2'] : 0));
							}
						}
					}
					if (in_array('apply', $_var_21)) 
					{
						$_obfuscate_DRUvFzwFWwM0QChbIxUNSUYAhgqBRE = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ')  and o.status>=3 and og.status2=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DRUvFzwFWwM0QChbIxUNSUYAhgqBRE as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission2']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DR4rDQgfNAsKMAQkIz43WwcvBz4kEQE += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DR4rDQgfNAsKMAQkIz43WwcvBz4kEQE += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2'] : 0));
							}
						}
					}
					if (in_array('check', $_var_21)) 
					{
						$_obfuscate_DQUMAg8cNTk5MzIbMlw5EygfJx8NAiI = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ')  and o.status>=3 and og.status2=2 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DQUMAg8cNTk5MzIbMlw5EygfJx8NAiI as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission2']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DTgwOR42Cz4YPR9bIyIeKUAMNyUsKBE += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DTgwOR42Cz4YPR9bIyIeKUAMNyUsKBE += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2'] : 0));
							}
						}
					}
					if (in_array('pay', $_var_21)) 
					{
						$_obfuscate_DQUMAg8cNTk5MzIbMlw5EygfJx8NAiI = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ')  and o.status>=3 and og.status2=3 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DQUMAg8cNTk5MzIbMlw5EygfJx8NAiI as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission2']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DTsFEhMSPjkuNEAcCRoXKCYTJjM8FDI += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DTsFEhMSPjkuNEAcCRoXKCYTJjM8FDI += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level2'] : 0));
							}
						}
					}
					$_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI = pdo_fetchall('select id from ' . tablename('sz_yi_member') . ' where agentid in( ' . implode(',', array_keys($_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI)) . ') and isagent=1 and status=1 and uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']), 'id');
					$_obfuscate_DRobOCcVFRQLATdcPDwmXD8BKjEOAxE = count($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI);
					$_obfuscate_DR0bCDMNMiU1BhEnAQwELwEHDwEIMyI += $_obfuscate_DRobOCcVFRQLATdcPDwmXD8BKjEOAxE;
				}
			}
			if (3 <= $_obfuscate_DRA8ETkUKzAOEj00FDUeNRIfNCcdJjI) 
			{
				if (0 < $_obfuscate_DRobOCcVFRQLATdcPDwmXD8BKjEOAxE) 
				{
					if (in_array('ordercount0', $_var_21)) 
					{
						$_obfuscate_DSYiFx4lESQ5NEACATIaIRMLLT84ORE = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ')  and o.status>=0 and og.status3>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						$_obfuscate_DRk_OBg7IxIkOTwCGkAeMwEaOyMzDTI += $_obfuscate_DSYiFx4lESQ5NEACATIaIRMLLT84ORE['ordercount'];
						$_obfuscate_DQsSIhwlJBkaHRIkDjYhCQ4qAwYbDTI += $_obfuscate_DSYiFx4lESQ5NEACATIaIRMLLT84ORE['ordercount'];
						$_obfuscate_DShAJzghPTUyLR48BAUOGzEmFR43CBE += $_obfuscate_DSYiFx4lESQ5NEACATIaIRMLLT84ORE['ordermoney'];
					}
					if (in_array('ordercount', $_var_21)) 
					{
						$_obfuscate_DSYiFx4lESQ5NEACATIaIRMLLT84ORE = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ')  and o.status>=1 and og.status3>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						$_obfuscate_DQEMDTg2Gh48EQkhEwwMPREKLwUtAwE += $_obfuscate_DSYiFx4lESQ5NEACATIaIRMLLT84ORE['ordercount'];
						$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI += $_obfuscate_DSYiFx4lESQ5NEACATIaIRMLLT84ORE['ordercount'];
						$_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI += $_obfuscate_DSYiFx4lESQ5NEACATIaIRMLLT84ORE['ordermoney'];
					}
					if (in_array('ordercount3', $_var_21)) 
					{
						$_obfuscate_DR8REScaAS4vDgUqNAUIHDRAGTsaMRE = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ')  and o.status>=3 and og.status3>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						$_obfuscate_DTgBFwyGBcFKCIPJDMyEAQnPDMQPAE += $_obfuscate_DR8REScaAS4vDgUqNAUIHDRAGTsaMRE['ordercount'];
						$_obfuscate_DRUvMDBbGA8QQCYmJSEeAzsaJyQaIiI += $_obfuscate_DR8REScaAS4vDgUqNAUIHDRAGTsaMRE['ordercount'];
						$_obfuscate_DSkMLjEfEwoCBiUPJx8LFjlAPQVcGQE += $_obfuscate_DR8REScaAS4vDgUqNAUIHDRAGTsaMRE['ordermoney'];
						$_obfuscate_DRg9FD0jJQEbPh0RCR0RCwcUPhYeAyI += $_obfuscate_DSYiFx4lESQ5NEACATIaIRMLLT84ORE['ordermoney'];
					}
					if (in_array('total', $_var_21)) 
					{
						$_obfuscate_DSkIESc9DVwjGxciPjUcFigkISk2PxE = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ')  and o.status>=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DSkIESc9DVwjGxciPjUcFigkISk2PxE as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission3']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DTMGhsjHjcFHgs5HT0jCTcnCCsiPBE += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DTMGhsjHjcFHgs5HT0jCTcnCCsiPBE += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3'] : 0));
							}
						}
					}
					if (in_array('ok', $_var_21)) 
					{
						$_obfuscate_DSkIESc9DVwjGxciPjUcFigkISk2PxE = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ')  and (' . $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI . ' - o.createtime > ' . $_obfuscate_DSgQBhUlLTIGFS4dOwoJFA5cByITFyI . ') and o.status>=3 and og.status3=0  and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DSkIESc9DVwjGxciPjUcFigkISk2PxE as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission3']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DVwsIzUoBjM8GCMsLjMIFjQ7CC8fIiI += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DVwsIzUoBjM8GCMsLjMIFjQ7CC8fIiI += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3'] : 0));
							}
						}
					}
					if (in_array('lock', $_var_21)) 
					{
						$_obfuscate_DQkiPRFcJgc9QCoPNQsxMyU3QCYcBCI = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ')  and o.status>=3 and (' . $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI . ' - o.createtime > ' . $_obfuscate_DSgQBhUlLTIGFS4dOwoJFA5cByITFyI . ') and og.status3=0  and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DQkiPRFcJgc9QCoPNQsxMyU3QCYcBCI as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission3']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DTsPWyUlFSgFDBgFNB8iG1sZBw42CCI += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DTsPWyUlFSgFDBgFNB8iG1sZBw42CCI += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3'] : 0));
							}
						}
					}
					if (in_array('apply', $_var_21)) 
					{
						$_obfuscate_DQgeNgM_NjIkLw8VNicLKR4FIQ0NJQE = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ')  and o.status>=3 and og.status3=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DQgeNgM_NjIkLw8VNicLKR4FIQ0NJQE as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission3']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DR4rDQgfNAsKMAQkIz43WwcvBz4kEQE += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DR4rDQgfNAsKMAQkIz43WwcvBz4kEQE += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3'] : 0));
							}
						}
					}
					if (in_array('check', $_var_21)) 
					{
						$_obfuscate_DSIDKRkTHiMNBgsVXCsuDB0ZNCkbIgE = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ')  and o.status>=3 and og.status3=2 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DSIDKRkTHiMNBgsVXCsuDB0ZNCkbIgE as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission3']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DTgwOR42Cz4YPR9bIyIeKUAMNyUsKBE += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DTgwOR42Cz4YPR9bIyIeKUAMNyUsKBE += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3'] : 0));
							}
						}
					}
					if (in_array('pay', $_var_21)) 
					{
						$_obfuscate_DSIDKRkTHiMNBgsVXCsuDB0ZNCkbIgE = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ')  and o.status>=3 and og.status3=3 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						foreach ($_obfuscate_DSIDKRkTHiMNBgsVXCsuDB0ZNCkbIgE as $_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI ) 
						{
							$_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commissions']);
							$_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI = iunserializer($_obfuscate_DS4_JgoIDQUYPAYFLBMGBwoGDIaETI['commission3']);
							if (empty($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE)) 
							{
								$_obfuscate_DTsFEhMSPjkuNEAcCRoXKCYTJjM8FDI += ((isset($_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']]) ? $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['level' . $_obfuscate_DTcEhgECTg1Cj4KATg1EDU1PSo4PQE['id']] : $_obfuscate_DVsuNBMRLTk5JCghEQQBOSMdODcbAiI['default']));
							}
							else 
							{
								$_obfuscate_DTsFEhMSPjkuNEAcCRoXKCYTJjM8FDI += ((isset($_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3']) ? $_obfuscate_DQ0qFQY5CA0wNyUsIiwnECpAEUAmJhE['level3'] : 0));
							}
						}
					}
					$_obfuscate_DT0PKik0GQFbAQcyHxsEHCsfLB0MMgE = pdo_fetchall('select id from ' . tablename('sz_yi_member') . ' where uniacid=:uniacid and agentid in( ' . implode(',', array_keys($_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI)) . ') and isagent=1 and status=1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']), 'id');
					$_obfuscate_DQkfOBYFIR0GLTwjEjItMyobJgsRDSI = count($_obfuscate_DT0PKik0GQFbAQcyHxsEHCsfLB0MMgE);
					$_obfuscate_DR0bCDMNMiU1BhEnAQwELwEHDwEIMyI += $_obfuscate_DQkfOBYFIR0GLTwjEjItMyobJgsRDSI;
				}
			}
			if (in_array('myorder', $_var_21)) 
			{
				$_obfuscate_DQYsGD8zCBwFCT0pBykuPRMwMSomXAE = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.openid=:openid and o.status>=3 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':openid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['openid']));
				$_obfuscate_DRk3Bh4kHAISHEBcCggZBx0cKjMCJyI = $_obfuscate_DQYsGD8zCBwFCT0pBykuPRMwMSomXAE['ordermoney'];
				$_obfuscate_DSQQFiwQHDspLgYCNSg0OS8VWy44FgE = $_obfuscate_DQYsGD8zCBwFCT0pBykuPRMwMSomXAE['ordercount'];
			}
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['agentcount'] = $_obfuscate_DR0bCDMNMiU1BhEnAQwELwEHDwEIMyI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['ordercount'] = $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['ordermoney'] = $_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order1'] = $_obfuscate_DTQ_BA0OJTcYMhgkHScTFisMJQgRMwE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order2'] = $_obfuscate_DR0mLQs7ASsjGTcdPx8wIwQ0PzMJDzI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order3'] = $_obfuscate_DQEMDTg2Gh48EQkhEwwMPREKLwUtAwE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['ordercount3'] = $_obfuscate_DRUvMDBbGA8QQCYmJSEeAzsaJyQaIiI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['ordermoney3'] = $_obfuscate_DSkMLjEfEwoCBiUPJx8LFjlAPQVcGQE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order13'] = $_obfuscate_DQ4vHBcZGBY_MBtbA1w9AQ9AEDJbFyI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order23'] = $_obfuscate_DRoyNgMOLR8PMRMYAg44MgsPFUAWOSI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order33'] = $_obfuscate_DTgBFwyGBcFKCIPJDMyEAQnPDMQPAE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order13money'] = $_obfuscate_DR8KITUWOS4YCBMDPh0fIx0yNVwqCyI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order23money'] = $_obfuscate_DVwkNR4vDgEsHCsCFBYjFhwIIQMOJBE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order33money'] = $_obfuscate_DRg9FD0jJQEbPh0RCR0RCwcUPhYeAyI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['ordercount0'] = $_obfuscate_DQsSIhwlJBkaHRIkDjYhCQ4qAwYbDTI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['ordermoney0'] = $_obfuscate_DShAJzghPTUyLR48BAUOGzEmFR43CBE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order10'] = $_obfuscate_DS8JJzAWPAMGIhY1FCwwPhIxHBMSHRE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order20'] = $_obfuscate_DTkTGiI9FDELFiI7LCYuPQQoGBEKHiI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['order30'] = $_obfuscate_DRk_OBg7IxIkOTwCGkAeMwEaOyMzDTI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['commission_total'] = round($_obfuscate_DTMGhsjHjcFHgs5HT0jCTcnCCsiPBE, 2);
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['commission_ok'] = round($_obfuscate_DVwsIzUoBjM8GCMsLjMIFjQ7CC8fIiI, 2);
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['commission_lock'] = round($_obfuscate_DTsPWyUlFSgFDBgFNB8iG1sZBw42CCI, 2);
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['commission_apply'] = round($_obfuscate_DR4rDQgfNAsKMAQkIz43WwcvBz4kEQE, 2);
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['commission_check'] = round($_obfuscate_DTgwOR42Cz4YPR9bIyIeKUAMNyUsKBE, 2);
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['commission_pay'] = round($_obfuscate_DTsFEhMSPjkuNEAcCRoXKCYTJjM8FDI, 2);
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['level1'] = $_obfuscate_DSgMECsIMR0_LhQwHDgBDhkFJTkDHAE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['level1_agentids'] = $_obfuscate_DQ4cMREFNjYHBCQPDRwyPwovJkAFBiI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['level2'] = $_obfuscate_DRobOCcVFRQLATdcPDwmXD8BKjEOAxE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['level2_agentids'] = $_obfuscate_DQ8hNFwTAi8hGiYrMwkJEg8TMy49KzI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['level3'] = $_obfuscate_DQkfOBYFIR0GLTwjEjItMyobJgsRDSI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['level3_agentids'] = $_obfuscate_DT0PKik0GQFbAQcyHxsEHCsfLB0MMgE;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['agenttime'] = date('Y-m-d H:i', $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['agenttime']);
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['myoedermoney'] = $_obfuscate_DRk3Bh4kHAISHEBcCggZBx0cKjMCJyI;
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['myordercount'] = $_obfuscate_DSQQFiwQHDspLgYCNSg0OS8VWy44FgE;
			return $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE;
		}
		public function getAgents($_var_1 = 0) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE = array();
			$_obfuscate_DT4uEhIPOzw3GhkTNDQEGwoZA0BbDhE = pdo_fetch('select id,agentid,openid from ' . tablename('sz_yi_order') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $_var_1, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			if (empty($_obfuscate_DT4uEhIPOzw3GhkTNDQEGwoZA0BbDhE)) 
			{
				return $_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE;
			}
			$_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE = m('member')->getMember($_obfuscate_DT4uEhIPOzw3GhkTNDQEGwoZA0BbDhE['agentid']);
			if (!empty($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE) && ($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['isagent'] == 1) && ($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['status'] == 1)) 
			{
				$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE[] = $_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE;
				if (!empty($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['agentid'])) 
				{
					$_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE = m('member')->getMember($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['agentid']);
					if (!empty($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE) && ($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['isagent'] == 1) && ($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['status'] == 1)) 
					{
						$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE[] = $_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE;
						if (!empty($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['agentid'])) 
						{
							$_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE = m('member')->getMember($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['agentid']);
							if (!empty($_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE) && ($_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE['isagent'] == 1) && ($_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE['status'] == 1)) 
							{
								$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE[] = $_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE;
							}
						}
					}
				}
			}
			return $_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE;
		}
		public function isAgent($_var_20) 
		{
			if (empty($_var_20)) 
			{
				return false;
			}
			if (is_array($_var_20)) 
			{
				return ($_var_20['isagent'] == 1) && ($_var_20['status'] == 1);
			}
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE = m('member')->getMember($_var_20);
			return ($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['isagent'] == 1) && ($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['status'] == 1);
		}
		public function calculate_goods_method($goods) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			$_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE = $goods['marketprice'];
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'])) 
			{
				return $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE;
			}
			if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'] == 1) 
			{
				return $goods['productprice'];
			}
			if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'] == 2) 
			{
				return $goods['marketprice'];
			}
			if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'] == 3) 
			{
				return $goods['costprice'];
			}
			if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['culate_method'] == 4) 
			{
				$_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE = $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE - $goods['costprice'];
				return (0 < $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE ? $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE : 0);
			}
		}
		public function getCommission($goods) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = 0;
			if ($goods['hascommission'] == 1) 
			{
				$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = ((1 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? ((0 < $goods['commission1_rate'] ? ($goods['commission1_rate'] * $goods['marketprice']) / 100 : $goods['commission1_pay'])) : 0));
			}
			else 
			{
				$_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE = m('user')->getOpenid();
				$_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI = $this->getLevel($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE);
				$_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE = $this->calculate_goods_method($goods);
				if (!empty($_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI)) 
				{
					$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = ((1 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? round(($_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['commission1'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) : 0));
				}
				else 
				{
					$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = ((1 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'] ? round(($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission1'] * $_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE) / 100, 2) : 0));
				}
			}
			return $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE;
		}
		public function createMyShopQrcode($_var_78 = 0, $_var_79 = 0) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE = IA_ROOT . '/addons/sz_yi/data/qrcode/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'];
			if (!is_dir($_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE)) 
			{
				load()->func('file');
				mkdirs($_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE);
			}
			$_obfuscate_DQwJECZAOTAUBjsPHiMxHDcoNSwHEAE = $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['siteroot'] . 'app/index.php?i=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . '&c=entry&m=sz_yi&do=plugin&p=commission&method=myshop&mid=' . $_var_78;
			if (!empty($_var_79)) 
			{
				$_obfuscate_DQwJECZAOTAUBjsPHiMxHDcoNSwHEAE .= '&posterid=' . $_var_79;
			}
			$_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE = 'myshop_' . $_var_79 . '_' . $_var_78 . '.png';
			$_obfuscate_DRoXQDc_Bg8hDQ4JHQQ7HzwhDjEXIyI = $_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE . '/' . $_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE;
			if (!is_file($_obfuscate_DRoXQDc_Bg8hDQ4JHQQ7HzwhDjEXIyI)) 
			{
				require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
				QRcode::png($_obfuscate_DQwJECZAOTAUBjsPHiMxHDcoNSwHEAE, $_obfuscate_DRoXQDc_Bg8hDQ4JHQQ7HzwhDjEXIyI, QR_ECLEVEL_H, 4);
			}
			return $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['siteroot'] . 'addons/sz_yi/data/qrcode/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . '/' . $_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE;
		}
		private function createImage($_var_81) 
		{
			load()->func('communication');
			$_obfuscate_DQ0wGBQvMzgsPxcpJh8cMzYMT8YPiI = ihttp_request($_var_81);
			return imagecreatefromstring($_obfuscate_DQ0wGBQvMzgsPxcpJh8cMzYMT8YPiI['content']);
		}
		public function createGoodsImage($_var_5, $_var_85) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_var_5 = set_medias($_var_5, 'thumb');
			$_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE = m('user')->getOpenid();
			$_obfuscate_DSkmLycwDykCJDU0DigxHjFcATQYBBE = m('member')->getMember($_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE);
			if (($_obfuscate_DSkmLycwDykCJDU0DigxHjFcATQYBBE['isagent'] == 1) && ($_obfuscate_DSkmLycwDykCJDU0DigxHjFcATQYBBE['status'] == 1)) 
			{
				$_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI = $_obfuscate_DSkmLycwDykCJDU0DigxHjFcATQYBBE;
				goto label48;
				$_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI = intval($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['mid']);
				if (!empty($_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI)) 
				{
					$_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI = m('member')->getMember($_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI);
				}
			}
			label48: $_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE = IA_ROOT . '/addons/sz_yi/data/poster/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . '/';
			if (!is_dir($_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE)) 
			{
				load()->func('file');
				mkdirs($_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE);
			}
			$_obfuscate_DSQqMQk1EgYlOTIiDicOKz0vLR0uLRE = ((empty($_var_5['commission_thumb']) ? $_var_5['thumb'] : tomedia($_var_5['commission_thumb'])));
			$_obfuscate_DTcZIRAPC0AEDjsjGkApCBwQHigBMyI = md5(json_encode(array('id' => $_var_5['id'], 'marketprice' => $_var_5['marketprice'], 'productprice' => $_var_5['productprice'], 'img' => $_obfuscate_DSQqMQk1EgYlOTIiDicOKz0vLR0uLRE, 'openid' => $_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE, 'version' => 4)));
			$_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE = $_obfuscate_DTcZIRAPC0AEDjsjGkApCBwQHigBMyI . '.jpg';
			if (!is_file($_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE . $_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE)) 
			{
				set_time_limit(0);
				$_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE = IA_ROOT . '/addons/sz_yi/static/fonts/msyh.ttf';
				$_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE = imagecreatetruecolor(640, 1225);
				if (!is_weixin()) 
				{
					$_obfuscate_DQkzGikKNQQ3CTVAHBM3HgsvFQE5XCI = 196;
					$_obfuscate_DT00AVwwEAkwF0BAAjITAiVAERIoMzI = imagecreatefromjpeg(IA_ROOT . '/addons/sz_yi/plugin/commission/images/poster_pc.jpg');
				}
				else 
				{
					$_obfuscate_DQkzGikKNQQ3CTVAHBM3HgsvFQE5XCI = 50;
					$_obfuscate_DT00AVwwEAkwF0BAAjITAiVAERIoMzI = imagecreatefromjpeg(IA_ROOT . '/addons/sz_yi/plugin/commission/images/poster.jpg');
				}
				$_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI = (($_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['nickname'] ? $_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['nickname'] : $_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['realname']));
				$_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI = (($_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI ? $_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI : $_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['mobile']));
				imagecopy($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DT00AVwwEAkwF0BAAjITAiVAERIoMzI, 0, 0, 0, 0, 640, 1225);
				imagedestroy($_obfuscate_DT00AVwwEAkwF0BAAjITAiVAERIoMzI);
				$_obfuscate_DSYPhEIERwyDRsOOAVAPgMnXA0bNjI = preg_replace('/\\/0$/i', '/96', $_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['avatar']);
				$_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE = $this->createImage($_obfuscate_DSYPhEIERwyDRsOOAVAPgMnXA0bNjI);
				$_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE = imagesx($_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE);
				$_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI = imagesy($_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE);
				imagecopyresized($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE, 24, 32, 0, 0, 88, 88, $_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE, $_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI);
				imagedestroy($_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE);
				$_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE = $this->createImage($_obfuscate_DSQqMQk1EgYlOTIiDicOKz0vLR0uLRE);
				$_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE = imagesx($_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE);
				$_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI = imagesy($_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE);
				imagecopyresized($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE, 0, 160, 0, 0, 640, 640, $_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE, $_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI);
				imagedestroy($_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE);
				$_obfuscate_DRQpPDADIgodNBIEP1tcASMYEiIXATI = imagecreatetruecolor(640, 127);
				imagealphablending($_obfuscate_DRQpPDADIgodNBIEP1tcASMYEiIXATI, false);
				imagesavealpha($_obfuscate_DRQpPDADIgodNBIEP1tcASMYEiIXATI, true);
				$_obfuscate_DS0cPyINKzgBNS0HOSwuEgo1AkAVHCI = imagecolorallocatealpha($_obfuscate_DRQpPDADIgodNBIEP1tcASMYEiIXATI, 0, 0, 0, 25);
				imagefill($_obfuscate_DRQpPDADIgodNBIEP1tcASMYEiIXATI, 0, 0, $_obfuscate_DS0cPyINKzgBNS0HOSwuEgo1AkAVHCI);
				imagecopy($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DRQpPDADIgodNBIEP1tcASMYEiIXATI, 0, 678, 0, 0, 640, 127);
				imagedestroy($_obfuscate_DRQpPDADIgodNBIEP1tcASMYEiIXATI);
				$_obfuscate_DT4GCAMLBkA2AQISFC8qLTsdQFwINTI = tomedia(m('qrcode')->createGoodsQrcode($_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['id'], $_var_5['id']));
				$_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE = $this->createImage($_obfuscate_DT4GCAMLBkA2AQISFC8qLTsdQFwINTI);
				$_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE = imagesx($_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE);
				$_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI = imagesy($_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE);
				imagecopyresized($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE, $_obfuscate_DQkzGikKNQQ3CTVAHBM3HgsvFQE5XCI, 835, 0, 0, 250, 250, $_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE, $_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI);
				imagedestroy($_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE);
				$_obfuscate_DRcyHzcBBTsZOTEiWz8IGQ0IJjIoFAE = imagecolorallocate($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 0, 3, 51);
				$_obfuscate_DRccNiwDCx0FMyNcDTwbJCgLxsFPCI = imagecolorallocate($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 240, 102, 0);
				$_obfuscate_DSMnOw8dMjIkFD0vECIUARwSBDYsDhE = imagecolorallocate($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 255, 255, 255);
				$_obfuscate_DRUFMwIkLSYTKQ4CFxMeKT5AMBgWFhE = imagecolorallocate($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 255, 255, 0);
				$_obfuscate_DRcGAiUzPTYRBSwvBCoqDzw7HS03ARE = '我是';
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 150, 70, $_obfuscate_DRcyHzcBBTsZOTEiWz8IGQ0IJjIoFAE, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DRcGAiUzPTYRBSwvBCoqDzw7HS03ARE);
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 210, 70, $_obfuscate_DRccNiwDCx0FMyNcDTwbJCgLxsFPCI, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI);
				$_obfuscate_DQEsETsaBxcCGxgOPhgLJBdANBA_MiI = '我要为';
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 150, 105, $_obfuscate_DRcyHzcBBTsZOTEiWz8IGQ0IJjIoFAE, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DQEsETsaBxcCGxgOPhgLJBdANBA_MiI);
				$_obfuscate_DSkMKAoiCT4xBQ8cED8MLRwxCxE4GBE = $_var_85['name'];
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 240, 105, $_obfuscate_DRccNiwDCx0FMyNcDTwbJCgLxsFPCI, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DSkMKAoiCT4xBQ8cED8MLRwxCxE4GBE);
				$_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE = imagettfbbox(20, 0, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DSkMKAoiCT4xBQ8cED8MLRwxCxE4GBE);
				$_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE = $_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE[4] - $_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE[6];
				$_obfuscate_DRYoPx8IOzYEDAgHHSg3FxkUPCQyGRE = '代言';
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 240 + $_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE + 10, 105, $_obfuscate_DRcyHzcBBTsZOTEiWz8IGQ0IJjIoFAE, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DRYoPx8IOzYEDAgHHSg3FxkUPCQyGRE);
				$_obfuscate_DR8sBFwnNhkPITgPEAYnExQiQD8LOzI = mb_substr($_var_5['title'], 0, 50, 'utf-8');
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 30, 730, $_obfuscate_DSMnOw8dMjIkFD0vECIUARwSBDYsDhE, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DR8sBFwnNhkPITgPEAYnExQiQD8LOzI);
				$_obfuscate_DRgvLQgqKhEKBxQyB1s1QDtbAgMWKCI = '￥' . number_format($_var_5['marketprice'], 2);
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 25, 0, 25, 780, $_obfuscate_DRUFMwIkLSYTKQ4CFxMeKT5AMBgWFhE, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DRgvLQgqKhEKBxQyB1s1QDtbAgMWKCI);
				$_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE = imagettfbbox(26, 0, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DRgvLQgqKhEKBxQyB1s1QDtbAgMWKCI);
				$_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE = $_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE[4] - $_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE[6];
				if (0 < $_var_5['productprice']) 
				{
					$_obfuscate_DS44LFwuNA0HEQ8lLz8wHBYOHDIHOAE = '￥' . number_format($_var_5['productprice'], 2);
					imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 22, 0, 25 + $_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE + 10, 780, $_obfuscate_DSMnOw8dMjIkFD0vECIUARwSBDYsDhE, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DS44LFwuNA0HEQ8lLz8wHBYOHDIHOAE);
					$_obfuscate_DTM7JDc5EiEQDwkpIQ5AJRZbGBIlJDI = 25 + $_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE + 10;
					$_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE = imagettfbbox(22, 0, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DS44LFwuNA0HEQ8lLz8wHBYOHDIHOAE);
					$_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE = $_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE[4] - $_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE[6];
					imageline($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DTM7JDc5EiEQDwkpIQ5AJRZbGBIlJDI, 770, $_obfuscate_DTM7JDc5EiEQDwkpIQ5AJRZbGBIlJDI + $_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE + 20, 770, $_obfuscate_DSMnOw8dMjIkFD0vECIUARwSBDYsDhE);
					imageline($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DTM7JDc5EiEQDwkpIQ5AJRZbGBIlJDI, 771.5, $_obfuscate_DTM7JDc5EiEQDwkpIQ5AJRZbGBIlJDI + $_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE + 20, 771, $_obfuscate_DSMnOw8dMjIkFD0vECIUARwSBDYsDhE);
				}
				imagejpeg($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE . $_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE);
				imagedestroy($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE);
			}
			return $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['siteroot'] . 'addons/sz_yi/data/poster/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . '/' . $_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE;
		}
		public function createShopImage($_var_85) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_var_85 = set_medias($_var_85, 'signimg');
			$_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE = IA_ROOT . '/addons/sz_yi/data/poster/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . '/';
			if (!is_dir($_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE)) 
			{
				load()->func('file');
				mkdirs($_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE);
			}
			$_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI = intval($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['mid']);
			$_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE = m('user')->getOpenid();
			$_obfuscate_DSkmLycwDykCJDU0DigxHjFcATQYBBE = m('member')->getMember($_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE);
			if (($_obfuscate_DSkmLycwDykCJDU0DigxHjFcATQYBBE['isagent'] == 1) && ($_obfuscate_DSkmLycwDykCJDU0DigxHjFcATQYBBE['status'] == 1)) 
			{
				$_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI = $_obfuscate_DSkmLycwDykCJDU0DigxHjFcATQYBBE;
				goto label71;
				$_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI = intval($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['mid']);
				if (!empty($_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI)) 
				{
					$_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI = m('member')->getMember($_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI);
				}
			}
			label71: $_obfuscate_DTcZIRAPC0AEDjsjGkApCBwQHigBMyI = md5(json_encode(array('openid' => $_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE, 'signimg' => $_var_85['signimg'], 'version' => 4)));
			$_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE = $_obfuscate_DTcZIRAPC0AEDjsjGkApCBwQHigBMyI . '.jpg';
			if (!is_file($_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE . $_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE)) 
			{
				set_time_limit(0);
				@ini_set('memory_limit', '256M');
				$_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE = IA_ROOT . '/addons/sz_yi/static/fonts/msyh.ttf';
				$_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE = imagecreatetruecolor(640, 1225);
				$_obfuscate_DRcyHzcBBTsZOTEiWz8IGQ0IJjIoFAE = imagecolorallocate($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 0, 3, 51);
				$_obfuscate_DRccNiwDCx0FMyNcDTwbJCgLxsFPCI = imagecolorallocate($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 240, 102, 0);
				$_obfuscate_DSMnOw8dMjIkFD0vECIUARwSBDYsDhE = imagecolorallocate($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 255, 255, 255);
				$_obfuscate_DRUFMwIkLSYTKQ4CFxMeKT5AMBgWFhE = imagecolorallocate($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 255, 255, 0);
				if (!is_weixin()) 
				{
					$_obfuscate_DT00AVwwEAkwF0BAAjITAiVAERIoMzI = imagecreatefromjpeg(IA_ROOT . '/addons/sz_yi/plugin/commission/images/poster_pc.jpg');
					$_obfuscate_DQkzGikKNQQ3CTVAHBM3HgsvFQE5XCI = 196;
				}
				else 
				{
					$_obfuscate_DT00AVwwEAkwF0BAAjITAiVAERIoMzI = imagecreatefromjpeg(IA_ROOT . '/addons/sz_yi/plugin/commission/images/poster.jpg');
					$_obfuscate_DQkzGikKNQQ3CTVAHBM3HgsvFQE5XCI = 50;
				}
				$_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI = (($_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['nickname'] ? $_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['nickname'] : $_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['realname']));
				$_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI = (($_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI ? $_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI : $_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['mobile']));
				imagecopy($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DT00AVwwEAkwF0BAAjITAiVAERIoMzI, 0, 0, 0, 0, 640, 1225);
				imagedestroy($_obfuscate_DT00AVwwEAkwF0BAAjITAiVAERIoMzI);
				$_obfuscate_DSYPhEIERwyDRsOOAVAPgMnXA0bNjI = preg_replace('/\\/0$/i', '/96', $_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['avatar']);
				$_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE = $this->createImage($_obfuscate_DSYPhEIERwyDRsOOAVAPgMnXA0bNjI);
				$_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE = imagesx($_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE);
				$_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI = imagesy($_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE);
				imagecopyresized($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE, 24, 32, 0, 0, 88, 88, $_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE, $_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI);
				imagedestroy($_obfuscate_DVxbDjRAHxkXKw8fPAsPKD5AGRMnNQE);
				$_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE = $this->createImage($_var_85['signimg']);
				$_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE = imagesx($_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE);
				$_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI = imagesy($_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE);
				imagecopyresized($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE, 0, 160, 0, 0, 640, 640, $_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE, $_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI);
				imagedestroy($_obfuscate_DSgFMSgKHTILFRsYCishNRcnLSYbHQE);
				$_obfuscate_DSUtFwkIDC4dIz03LzAMKAdcLx4pJCI = tomedia($this->createMyShopQrcode($_obfuscate_DTM5MCgCKBMYOzMXLygRKzEqLD0RGjI['id']));
				$_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE = $this->createImage($_obfuscate_DSUtFwkIDC4dIz03LzAMKAdcLx4pJCI);
				$_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE = imagesx($_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE);
				$_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI = imagesy($_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE);
				imagecopyresized($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE, $_obfuscate_DQkzGikKNQQ3CTVAHBM3HgsvFQE5XCI, 835, 0, 0, 250, 250, $_obfuscate_DVwBNxYcJB0kNzMxER8QLQc1KwwsAQE, $_obfuscate_DR4vIi0NPSUlNwkIKx4XITcSGyQ4BCI);
				imagedestroy($_obfuscate_DTE8GBQHHS88Ni5AGwkIMQMeLSk5FQE);
				$_obfuscate_DRcGAiUzPTYRBSwvBCoqDzw7HS03ARE = '我是';
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 150, 70, $_obfuscate_DRcyHzcBBTsZOTEiWz8IGQ0IJjIoFAE, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DRcGAiUzPTYRBSwvBCoqDzw7HS03ARE);
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 210, 70, $_obfuscate_DRccNiwDCx0FMyNcDTwbJCgLxsFPCI, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DQkSHD5bXAQaLFwFJFsZKzkeKC8GATI);
				$_obfuscate_DQEsETsaBxcCGxgOPhgLJBdANBA_MiI = '我要为';
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 150, 105, $_obfuscate_DRcyHzcBBTsZOTEiWz8IGQ0IJjIoFAE, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DQEsETsaBxcCGxgOPhgLJBdANBA_MiI);
				$_obfuscate_DSkMKAoiCT4xBQ8cED8MLRwxCxE4GBE = $_var_85['name'];
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 240, 105, $_obfuscate_DRccNiwDCx0FMyNcDTwbJCgLxsFPCI, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DSkMKAoiCT4xBQ8cED8MLRwxCxE4GBE);
				$_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE = imagettfbbox(20, 0, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DSkMKAoiCT4xBQ8cED8MLRwxCxE4GBE);
				$_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE = $_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE[4] - $_obfuscate_DTYFGgoQDEXMBg8DgMMFRovNxk7KRE[6];
				$_obfuscate_DRYoPx8IOzYEDAgHHSg3FxkUPCQyGRE = '代言';
				imagettftext($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, 20, 0, 240 + $_obfuscate_DRtbATUjPD04WzcXCAMBOzcHKEAOEgE + 10, 105, $_obfuscate_DRcyHzcBBTsZOTEiWz8IGQ0IJjIoFAE, $_obfuscate_DT07DhwjEQUzKQIIPR8FgMYEyQVIgE, $_obfuscate_DRYoPx8IOzYEDAgHHSg3FxkUPCQyGRE);
				imagejpeg($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE, $_obfuscate_DR00NhA5GTcjGCUjCwMuGwo2AwcTNQE . $_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE);
				imagedestroy($_obfuscate_DQEBCAwZJTUNOA8SWxg2PyIJFwcmLhE);
			}
			return $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['siteroot'] . 'addons/sz_yi/data/poster/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . '/' . $_obfuscate_DTALGyEsMycUMCQmNisNERMiNxIFLAE;
		}
		public function checkAgent() 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
			{
				return NULL;
			}
			$_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE = m('user')->getOpenid();
			if (empty($_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE)) 
			{
				return NULL;
			}
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE = m('member')->getMember($_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE);
			if (empty($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE)) 
			{
				return NULL;
			}
			$_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE = false;
			$_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI = intval($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['mid']);
			if (!empty($_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI)) 
			{
				$_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE = m('member')->getMember($_obfuscate_DTQIOBIsMQQtOxoaXC8xDiNbDzYfBTI);
			}
			$_obfuscate_DS0rCRw1FCskDiIJBxUxNiolHhIFJzI = !empty($_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE) && ($_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['isagent'] == 1) && ($_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['status'] == 1);
			if ($_obfuscate_DS0rCRw1FCskDiIJBxUxNiolHhIFJzI) 
			{
				if ($_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['openid'] != $_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE) 
				{
					$_obfuscate_DTckMlwsKhA0Ah47DzITATAkPRAkJyI = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_commission_clickcount') . ' where uniacid=:uniacid and openid=:openid and from_openid=:from_openid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':openid' => $_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE, ':from_openid' => $_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['openid']));
					if ($_obfuscate_DTckMlwsKhA0Ah47DzITATAkPRAkJyI <= 0) 
					{
						$_obfuscate_DQcVARIBDzIuDTQNCBkPI0A0BT8iGDI = array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'openid' => $_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE, 'from_openid' => $_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['openid'], 'clicktime' => time());
						pdo_insert('sz_yi_commission_clickcount', $_obfuscate_DQcVARIBDzIuDTQNCBkPI0A0BT8iGDI);
						pdo_update('sz_yi_member', array('clickcount' => $_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['clickcount'] + 1), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['id']));
					}
				}
			}
			if ($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['isagent'] == 1) 
			{
				return NULL;
			}
			if ($_obfuscate_DRBcLQYPPCEMGjI4PB4MFDMfPkAJGzI == 0) 
			{
				$_obfuscate_DS1cJDcrIiszHAYpAS8EISEtPhgsOBE = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_member') . ' where id<:id and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':id' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
				if ($_obfuscate_DS1cJDcrIiszHAYpAS8EISEtPhgsOBE <= 0) 
				{
					pdo_update('sz_yi_member', array('isagent' => 1, 'status' => 1, 'agenttime' => time(), 'agentblack' => 0), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					return NULL;
				}
			}
			$_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI = time();
			$_obfuscate_DQk2KAI7AzAfMwo8Mlw9DwghFDUsEQE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_child']);
			if ($_obfuscate_DS0rCRw1FCskDiIJBxUxNiolHhIFJzI && empty($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['agentid'])) 
			{
				if ($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id'] != $_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['id']) 
				{
					if (empty($_obfuscate_DQk2KAI7AzAfMwo8Mlw9DwghFDUsEQE)) 
					{
						if (empty($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['fixagentid'])) 
						{
							pdo_update('sz_yi_member', array('agentid' => $_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['id'], 'childtime' => $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
							$this->sendMessage($_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['openid'], array('nickname' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['nickname'], 'childtime' => $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI), TM_COMMISSION_AGENT_NEW);
							$this->upgradeLevelByAgent($_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['id']);
						}
					}
					else 
					{
						pdo_update('sz_yi_member', array('inviter' => $_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['id']), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					}
				}
			}
			$_obfuscate_DRs0MyISDjNcKCgGNjIGNiQjPR4PGzI = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_check']);
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become'])) 
			{
				if (empty($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['agentblack'])) 
				{
					pdo_update('sz_yi_member', array('isagent' => 1, 'status' => $_obfuscate_DRs0MyISDjNcKCgGNjIGNiQjPR4PGzI, 'agenttime' => ($_obfuscate_DRs0MyISDjNcKCgGNjIGNiQjPR4PGzI == 1 ? $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI : 0)), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
					if ($_obfuscate_DRs0MyISDjNcKCgGNjIGNiQjPR4PGzI == 1) 
					{
						$this->sendMessage($_obfuscate_DTgYLxAMMicbKQsMJBcbNRoRNgIsNBE, array('nickname' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['nickname'], 'agenttime' => $_obfuscate_DTkEikbDC1cETsTJw8LMQQaHQ8_OSI), TM_COMMISSION_BECOME);
						if ($_obfuscate_DS0rCRw1FCskDiIJBxUxNiolHhIFJzI) 
						{
							$this->upgradeLevelByAgent($_obfuscate_DVsDLDsOHSoTHDYbJxIXDTgyIwYiXAE['id']);
						}
					}
				}
			}
		}
		public function checkOrderConfirm($orderid = '0') 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			if (empty($orderid)) 
			{
				return NULL;
			}
			$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE = p('bonus');
			if (!empty($_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE)) 
			{
				$_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI = $_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->getSet();
				if (!empty($_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI['start'])) 
				{
					$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->checkOrderConfirm($orderid);
				}
			}
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
			{
				return NULL;
			}
			$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select id,openid,ordersn,goodsprice,agentid,paytime from ' . tablename('sz_yi_order') . ' where id=:id and status>=0 and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			if (empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE)) 
			{
				return NULL;
			}
			$_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE = $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'];
			$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = m('member')->getMember($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE);
			if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI)) 
			{
				return NULL;
			}
			$_obfuscate_DQsLHD0UJ1sPIwlcHjEyNgUTAyJbXBE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_child']);
			$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = false;
			if (empty($_obfuscate_DQsLHD0UJ1sPIwlcHjEyNgUTAyJbXBE)) 
			{
				$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid']);
			}
			else 
			{
				$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['inviter']);
			}
			$_obfuscate_DRwcJSgIJxA0HBUkBiIeHDg1MCw_KSI = !empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] == 1) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] == 1);
			$_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE = time();
			$_obfuscate_DQsLHD0UJ1sPIwlcHjEyNgUTAyJbXBE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_child']);
			if ($_obfuscate_DRwcJSgIJxA0HBUkBiIeHDg1MCw_KSI) 
			{
				if ($_obfuscate_DQsLHD0UJ1sPIwlcHjEyNgUTAyJbXBE == 1) 
				{
					if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid']) && ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id'] != $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id'])) 
					{
						if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['fixagentid'])) 
						{
							$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid'] = $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id'];
							pdo_update('sz_yi_member', array('agentid' => $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id'], 'childtime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id']));
							$this->sendMessage($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['openid'], array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'childtime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), TM_COMMISSION_AGENT_NEW);
							$this->upgradeLevelByAgent($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']);
						}
					}
				}
			}
			$_obfuscate_DS0TBSoIFAsoCCojOSsLKBEZCywmFQE = $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid'];
			if (($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['isagent'] == 1) && ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['status'] == 1)) 
			{
				if (!empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['selfbuy'])) 
				{
					$_obfuscate_DS0TBSoIFAsoCCojOSsLKBEZCywmFQE = $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id'];
				}
			}
			if (!empty($_obfuscate_DS0TBSoIFAsoCCojOSsLKBEZCywmFQE)) 
			{
				pdo_update('sz_yi_order', array('agentid' => $_obfuscate_DS0TBSoIFAsoCCojOSsLKBEZCywmFQE), array('id' => $orderid));
			}
			$this->calculate($orderid);
		}
		public function checkOrderPay($orderid = '0') 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			if (empty($orderid)) 
			{
				return NULL;
			}
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
			{
				return NULL;
			}
			$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select id,openid,ordersn,goodsprice,agentid,paytime from ' . tablename('sz_yi_order') . ' where id=:id and status>=1 and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			if (empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE)) 
			{
				return NULL;
			}
			$_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE = $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'];
			$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = m('member')->getMember($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE);
			if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI)) 
			{
				return NULL;
			}
			$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE = p('bonus');
			if (!empty($_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE)) 
			{
				$_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI = $_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->getSet();
				if (!empty($_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI['start'])) 
				{
					$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->checkOrderPay($orderid);
				}
			}
			$_obfuscate_DQsLHD0UJ1sPIwlcHjEyNgUTAyJbXBE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_child']);
			$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = false;
			if (empty($_obfuscate_DQsLHD0UJ1sPIwlcHjEyNgUTAyJbXBE)) 
			{
				$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid']);
			}
			else 
			{
				$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['inviter']);
			}
			$_obfuscate_DRwcJSgIJxA0HBUkBiIeHDg1MCw_KSI = !empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] == 1) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] == 1);
			$_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE = time();
			$_obfuscate_DQsLHD0UJ1sPIwlcHjEyNgUTAyJbXBE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_child']);
			if ($_obfuscate_DRwcJSgIJxA0HBUkBiIeHDg1MCw_KSI) 
			{
				if ($_obfuscate_DQsLHD0UJ1sPIwlcHjEyNgUTAyJbXBE == 2) 
				{
					if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid']) && ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id'] != $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id'])) 
					{
						if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['fixagentid'])) 
						{
							$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid'] = $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id'];
							pdo_update('sz_yi_member', array('agentid' => $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id'], 'childtime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id']));
							$this->sendMessage($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['openid'], array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'childtime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), TM_COMMISSION_AGENT_NEW);
							$this->upgradeLevelByAgent($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']);
							if (empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'])) 
							{
								$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'] = $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id'];
								pdo_update('sz_yi_order', array('agentid' => $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']), array('id' => $orderid));
								$this->calculate($orderid);
							}
						}
					}
				}
			}
			$_obfuscate_DSUTPBIcFi0fFA8MExUwJiYVHTglMiI = ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['isagent'] == 1) && ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['status'] == 1);
			if (!$_obfuscate_DSUTPBIcFi0fFA8MExUwJiYVHTglMiI) 
			{
				if ((intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become']) == 4) && !empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_goodsid'])) 
				{
					$_obfuscate_DREoLUAqLT8kGjgGHBsYEAQkNhIlQCI = pdo_fetchall('select goodsid from ' . tablename('sz_yi_order_goods') . ' where orderid=:orderid and uniacid=:uniacid  ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']), 'goodsid');
					if (in_array($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_goodsid'], array_keys($_obfuscate_DREoLUAqLT8kGjgGHBsYEAQkNhIlQCI))) 
					{
						if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentblack'])) 
						{
							pdo_update('sz_yi_member', array('status' => 1, 'isagent' => 1, 'agenttime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id']));
							$this->sendMessage($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE, array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'agenttime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), TM_COMMISSION_BECOME);
							if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE)) 
							{
								$this->upgradeLevelByAgent($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']);
							}
						}
					}
				}
			}
			if (!$_obfuscate_DSUTPBIcFi0fFA8MExUwJiYVHTglMiI && empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_order'])) 
			{
				$_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE = time();
				if (($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become'] == 2) || ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become'] == 3)) 
				{
					$_obfuscate_DQhAMjUrQAMwMxAxJz0RNQceKhk0IiI = true;
					if (!empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid'])) 
					{
						$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid']);
						if (empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) || ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] != 1) || ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] != 1)) 
						{
							$_obfuscate_DQhAMjUrQAMwMxAxJz0RNQceKhk0IiI = false;
						}
					}
					if ($_obfuscate_DQhAMjUrQAMwMxAxJz0RNQceKhk0IiI) 
					{
						$_obfuscate_DTIPDQMNKDQwKQM8Lz4FBCkdCQMiPQE = false;
						if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become'] == '2') 
						{
							$_obfuscate_DR4VGSw4JhwXCSkoCQMtMzcJDD8xFhE = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_order') . ' where openid=:openid and status>=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':openid' => $_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE));
							$_obfuscate_DTIPDQMNKDQwKQM8Lz4FBCkdCQMiPQE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_ordercount']) <= $_obfuscate_DR4VGSw4JhwXCSkoCQMtMzcJDD8xFhE;
						}
						else if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become'] == '3') 
						{
							$_obfuscate_DTMLDjYHPygnJDwGIyQeEQsmJRU1ERE = pdo_fetchcolumn('select sum(og.realprice) from ' . tablename('sz_yi_order_goods') . ' og left join ' . tablename('sz_yi_order') . ' o on og.orderid=o.id  where o.openid=:openid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':openid' => $_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE));
							$_obfuscate_DTIPDQMNKDQwKQM8Lz4FBCkdCQMiPQE = floatval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_moneycount']) <= $_obfuscate_DTMLDjYHPygnJDwGIyQeEQsmJRU1ERE;
						}
						if ($_obfuscate_DTIPDQMNKDQwKQM8Lz4FBCkdCQMiPQE) 
						{
							if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentblack'])) 
							{
								$_obfuscate_DREdIxoPKzcJKwMkLDQ7LSsbDCQQHSI = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_check']);
								pdo_update('sz_yi_member', array('status' => $_obfuscate_DREdIxoPKzcJKwMkLDQ7LSsbDCQQHSI, 'isagent' => 1, 'agenttime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id']));
								if ($_obfuscate_DREdIxoPKzcJKwMkLDQ7LSsbDCQQHSI == 1) 
								{
									$this->sendMessage($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE, array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'agenttime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), TM_COMMISSION_BECOME);
									if ($_obfuscate_DQhAMjUrQAMwMxAxJz0RNQceKhk0IiI) 
									{
										$this->upgradeLevelByAgent($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']);
									}
								}
							}
						}
					}
				}
			}
			if (!empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'])) 
			{
				$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid']);
				if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] == 1) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] == 1)) 
				{
					if ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'] == $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']) 
					{
						$_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI = pdo_fetchall('select g.id,g.title,og.total,og.price,og.realprice, og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1 from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']));
						$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = '';
						$_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI = $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentlevel'];
						$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE = 0;
						$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE = 0;
						foreach ($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI as $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI ) 
						{
							$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= '' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['title'] . '( ';
							if (!empty($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'])) 
							{
								$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 规格: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'];
							}
							$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 单价: ' . ($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] / $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total']) . ' 数量: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total'] . ' 总价: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] . '); ';
							$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = iunserializer($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['commission1']);
							$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE += ((isset($_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI]) ? $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI] : $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['default']));
							$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE += $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'];
						}
						$this->sendMessage($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['openid'], array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'ordersn' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn'], 'price' => $_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE, 'goods' => $_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE, 'commission' => $_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE, 'paytime' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['paytime']), TM_COMMISSION_ORDER_PAY);
					}
				}
				if (!empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['remind_message']) && (2 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
				{
					if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentid'])) 
					{
						$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentid']);
						if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] == 1) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] == 1)) 
						{
							if ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'] != $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']) 
							{
								$_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI = pdo_fetchall('select g.id,g.title,og.total,og.price,og.realprice, og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission2 from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']));
								$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = '';
								$_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI = $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentlevel'];
								$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE = 0;
								$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE = 0;
								foreach ($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI as $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI ) 
								{
									$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= '' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['title'] . '( ';
									if (!empty($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'])) 
									{
										$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 规格: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'];
									}
									$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 单价: ' . ($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] / $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total']) . ' 数量: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total'] . ' 总价: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] . '); ';
									$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = iunserializer($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['commission2']);
									$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE += ((isset($_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI]) ? $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI] : $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['default']));
									$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE += $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'];
								}
								$this->sendMessage($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['openid'], array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'ordersn' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn'], 'price' => $_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE, 'goods' => $_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE, 'commission' => $_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE, 'paytime' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['paytime']), TM_COMMISSION_ORDER_PAY);
							}
						}
						if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentid']) && (3 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
						{
							$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentid']);
							if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] == 1) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] == 1)) 
							{
								if ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'] != $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']) 
								{
									$_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI = pdo_fetchall('select g.id,g.title,og.total,og.price,og.realprice, og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission3 from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']));
									$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = '';
									$_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI = $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentlevel'];
									$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE = 0;
									$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE = 0;
									foreach ($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI as $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI ) 
									{
										$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= '' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['title'] . '( ';
										if (!empty($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'])) 
										{
											$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 规格: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'];
										}
										$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 单价: ' . ($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] / $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total']) . ' 数量: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total'] . ' 总价: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] . '); ';
										$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = iunserializer($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['commission3']);
										$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE += ((isset($_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI]) ? $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI] : $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['default']));
										$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE += $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'];
									}
									$this->sendMessage($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['openid'], array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'ordersn' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn'], 'price' => $_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE, 'goods' => $_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE, 'commission' => $_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE, 'paytime' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['paytime']), TM_COMMISSION_ORDER_PAY);
								}
							}
						}
					}
				}
			}
		}
		public function checkOrderFinish($orderid = '') 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			if (empty($orderid)) 
			{
				return NULL;
			}
			$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = pdo_fetch('select id,openid, ordersn,goodsprice,agentid,finishtime from ' . tablename('sz_yi_order') . ' where id=:id and status>=3 and uniacid=:uniacid limit 1', array(':id' => $orderid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			if (empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE)) 
			{
				return NULL;
			}
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
			{
				return NULL;
			}
			$_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE = $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['openid'];
			$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = m('member')->getMember($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE);
			if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI)) 
			{
				return NULL;
			}
			$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE = p('bonus');
			if (!empty($_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE)) 
			{
				$_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI = $_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->getSet();
				if (!empty($_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI['start'])) 
				{
					$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->checkOrderFinish($orderid);
				}
			}
			$_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE = time();
			$_obfuscate_DSUTPBIcFi0fFA8MExUwJiYVHTglMiI = ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['isagent'] == 1) && ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['status'] == 1);
			if (!$_obfuscate_DSUTPBIcFi0fFA8MExUwJiYVHTglMiI && ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_order'] == 1)) 
			{
				if (($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become'] == 2) || ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become'] == 3)) 
				{
					$_obfuscate_DQhAMjUrQAMwMxAxJz0RNQceKhk0IiI = true;
					if (!empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid'])) 
					{
						$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentid']);
						if (empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) || ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] != 1) || ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] != 1)) 
						{
							$_obfuscate_DQhAMjUrQAMwMxAxJz0RNQceKhk0IiI = false;
						}
					}
					if ($_obfuscate_DQhAMjUrQAMwMxAxJz0RNQceKhk0IiI) 
					{
						$_obfuscate_DTIPDQMNKDQwKQM8Lz4FBCkdCQMiPQE = false;
						if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become'] == '2') 
						{
							$_obfuscate_DR4VGSw4JhwXCSkoCQMtMzcJDD8xFhE = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':openid' => $_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE));
							$_obfuscate_DTIPDQMNKDQwKQM8Lz4FBCkdCQMiPQE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_ordercount']) <= $_obfuscate_DR4VGSw4JhwXCSkoCQMtMzcJDD8xFhE;
						}
						else if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become'] == '3') 
						{
							$_obfuscate_DTMLDjYHPygnJDwGIyQeEQsmJRU1ERE = pdo_fetchcolumn('select sum(goodsprice) from ' . tablename('sz_yi_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':openid' => $_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE));
							$_obfuscate_DTIPDQMNKDQwKQM8Lz4FBCkdCQMiPQE = floatval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_moneycount']) <= $_obfuscate_DTMLDjYHPygnJDwGIyQeEQsmJRU1ERE;
						}
						if ($_obfuscate_DTIPDQMNKDQwKQM8Lz4FBCkdCQMiPQE) 
						{
							if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentblack'])) 
							{
								$_obfuscate_DREdIxoPKzcJKwMkLDQ7LSsbDCQQHSI = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['become_check']);
								pdo_update('sz_yi_member', array('status' => $_obfuscate_DREdIxoPKzcJKwMkLDQ7LSsbDCQQHSI, 'isagent' => 1, 'agenttime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id']));
								if ($_obfuscate_DREdIxoPKzcJKwMkLDQ7LSsbDCQQHSI == 1) 
								{
									$this->sendMessage($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['openid'], array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'agenttime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), TM_COMMISSION_BECOME);
									if ($_obfuscate_DQhAMjUrQAMwMxAxJz0RNQceKhk0IiI) 
									{
										$this->upgradeLevelByAgent($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']);
									}
								}
							}
						}
					}
				}
			}
			if (!empty($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'])) 
			{
				$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid']);
				if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] == 1) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] == 1)) 
				{
					if ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'] == $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']) 
					{
						$_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI = pdo_fetchall('select g.id,g.title,og.total,og.realprice,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1 from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']));
						$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = '';
						$_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI = $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentlevel'];
						$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE = 0;
						$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE = 0;
						foreach ($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI as $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI ) 
						{
							$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= '' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['title'] . '( ';
							if (!empty($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'])) 
							{
								$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 规格: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'];
							}
							$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 单价: ' . ($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] / $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total']) . ' 数量: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total'] . ' 总价: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] . '); ';
							$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = iunserializer($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['commission1']);
							$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE += ((isset($_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI]) ? $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI] : $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['default']));
							$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE += $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'];
						}
						$this->sendMessage($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['openid'], array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'ordersn' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn'], 'price' => $_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE, 'goods' => $_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE, 'commission' => $_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE, 'finishtime' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['finishtime']), TM_COMMISSION_ORDER_FINISH);
					}
				}
				if (!empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['remind_message']) && (2 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
				{
					if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentid'])) 
					{
						$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentid']);
						if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] == 1) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] == 1)) 
						{
							if ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'] != $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']) 
							{
								$_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI = pdo_fetchall('select g.id,g.title,og.total,og.realprice,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission2 from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']));
								$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = '';
								$_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI = $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentlevel'];
								$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE = 0;
								$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE = 0;
								foreach ($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI as $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI ) 
								{
									$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= '' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['title'] . '( ';
									if (!empty($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'])) 
									{
										$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 规格: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'];
									}
									$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 单价: ' . ($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] / $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total']) . ' 数量: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total'] . ' 总价: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] . '); ';
									$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = iunserializer($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['commission2']);
									$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE += ((isset($_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI]) ? $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI] : $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['default']));
									$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE += $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'];
								}
								$this->sendMessage($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['openid'], array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'ordersn' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn'], 'price' => $_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE, 'goods' => $_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE, 'commission' => $_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE, 'finishtime' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['finishtime']), TM_COMMISSION_ORDER_FINISH);
							}
						}
						if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentid']) && (3 <= $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
						{
							$_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE = m('member')->getMember($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentid']);
							if (!empty($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['isagent'] == 1) && ($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['status'] == 1)) 
							{
								if ($_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['agentid'] != $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['id']) 
								{
									$_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI = pdo_fetchall('select g.id,g.title,og.total,og.realprice,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission3 from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['id']));
									$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = '';
									$_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI = $_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['agentlevel'];
									$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE = 0;
									$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE = 0;
									foreach ($_obfuscate_DTQpMywSXAsHXC04XBkOPAsPPywDCI as $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI ) 
									{
										$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= '' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['title'] . '( ';
										if (!empty($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'])) 
										{
											$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 规格: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['optiontitle'];
										}
										$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE .= ' 单价: ' . ($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] / $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total']) . ' 数量: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['total'] . ' 总价: ' . $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'] . '); ';
										$_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE = iunserializer($_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['commission3']);
										$_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE += ((isset($_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI]) ? $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['level' . $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI] : $_obfuscate_DVxcBRwzFDEtJCQxNj0eDi8IFUA7MBE['default']));
										$_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE += $_obfuscate_DQ0CPR48Iw82FRY3MFwDNi0BGCQfWyI['realprice'];
									}
									$this->sendMessage($_obfuscate_DRgrNA0KNwcKNh4VGDMeGjgCMzMHPBE['openid'], array('nickname' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'], 'ordersn' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn'], 'price' => $_obfuscate_DRsMGAkINwQYFAYVHD4_XAQrPQ8rNgE, 'goods' => $_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE, 'commission' => $_obfuscate_DQQtXCc2ClsYFjICCCQIKh0jNiYqIgE, 'finishtime' => $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['finishtime']), TM_COMMISSION_ORDER_FINISH);
								}
							}
						}
					}
				}
			}
			$this->upgradeLevelByOrder($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE);
			$this->upgradeLevelByGood($orderid);
		}
		public function getShop($_var_132) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE = m('member')->getMember($_var_132);
			$_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE = pdo_fetch('select * from ' . tablename('sz_yi_commission_shop') . ' where uniacid=:uniacid and mid=:mid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':mid' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['id']));
			$_obfuscate_DQYBMDUwAT82BDIFGCg9BzQqKxwwHxE = m('common')->getSysset(array('shop', 'share'));
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $_obfuscate_DQYBMDUwAT82BDIFGCg9BzQqKxwwHxE['shop'];
			$_obfuscate_DQMYNQsvAREoEzISFDQDJhgKAycjCwE = $_obfuscate_DQYBMDUwAT82BDIFGCg9BzQqKxwwHxE['share'];
			$_obfuscate_DRcJHgskOBcsMiwuJxI3WwQrHg8lChE = $_obfuscate_DQMYNQsvAREoEzISFDQDJhgKAycjCwE['desc'];
			if (empty($_obfuscate_DRcJHgskOBcsMiwuJxI3WwQrHg8lChE)) 
			{
				$_obfuscate_DRcJHgskOBcsMiwuJxI3WwQrHg8lChE = $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['description'];
			}
			if (empty($_obfuscate_DRcJHgskOBcsMiwuJxI3WwQrHg8lChE)) 
			{
				$_obfuscate_DRcJHgskOBcsMiwuJxI3WwQrHg8lChE = $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['name'];
			}
			$_obfuscate_DTgXORwcBBcjMCUWAj5AKwEsORYGExE = $this->getSet();
			if (empty($_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE)) 
			{
				$_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE = array('name' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['nickname'] . '的' . $_obfuscate_DTgXORwcBBcjMCUWAj5AKwEsORYGExE['texts']['shop'], 'logo' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['avatar'], 'desc' => $_obfuscate_DRcJHgskOBcsMiwuJxI3WwQrHg8lChE, 'img' => tomedia($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['img']));
			}
			else 
			{
				if (empty($_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE['name'])) 
				{
					$_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE['name'] = $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['nickname'] . '的' . $_obfuscate_DTgXORwcBBcjMCUWAj5AKwEsORYGExE['texts']['shop'];
				}
				if (empty($_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE['logo'])) 
				{
					$_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE['logo'] = tomedia($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['avatar']);
				}
				if (empty($_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE['img'])) 
				{
					$_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE['img'] = tomedia($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['img']);
				}
				if (empty($_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE['desc'])) 
				{
					$_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE['desc'] = $_obfuscate_DRcJHgskOBcsMiwuJxI3WwQrHg8lChE;
				}
			}
			return $_obfuscate_DQw8NiNcMgowNBg5EVs7ND8CHA0tDwE;
		}
		public function getLevels($_var_138 = true) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			if ($_var_138) 
			{
				return pdo_fetchall('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid order by commission1 asc', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			}
			return pdo_fetchall('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid and (ordermoney>0 or commissionmoney>0) order by commission1 asc', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
		}
		public function getLevel($_var_20) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			if (empty($_var_20)) 
			{
				return false;
			}
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE = m('member')->getMember($_var_20);
			if (empty($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['agentlevel'])) 
			{
				return false;
			}
			$_obfuscate_DRA8ETkUKzAOEj00FDUeNRIfNCcdJjI = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':id' => $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['agentlevel']));
			return $_obfuscate_DRA8ETkUKzAOEj00FDUeNRIfNCcdJjI;
		}
		public function upgradeLevelByOrder($_var_20) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			if (empty($_var_20)) 
			{
				return false;
			}
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
			{
				return false;
			}
			$_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE = m('member')->getMember($_var_20);
			if (empty($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE)) 
			{
				return NULL;
			}
			$_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['leveltype']);
			if (($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 4) || ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 5)) 
			{
				if (!empty($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['agentnotupgrade'])) 
				{
					return NULL;
				}
				$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = $this->getLevel($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['openid']);
				if (empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
				{
					$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = array('levelname' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']) ? '普通等级' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']), 'commission1' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission1'], 'commission2' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission2'], 'commission3' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission3']);
				}
				$_obfuscate_DSYbBgM0HDw2Dgw_LB8VBjcPKA8VAhE = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('sz_yi_order') . ' o ' . ' left join  ' . tablename('sz_yi_order_goods') . ' og on og.orderid=o.id ' . ' where o.openid=:openid and o.status>=3 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':openid' => $_var_20));
				$_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI = $_obfuscate_DSYbBgM0HDw2Dgw_LB8VBjcPKA8VAhE['ordermoney'];
				$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI = $_obfuscate_DSYbBgM0HDw2Dgw_LB8VBjcPKA8VAhE['ordercount'];
				if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 4) 
				{
					$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI . ' >= ordermoney and ordermoney>0  order by ordermoney desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
					if (empty($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE)) 
					{
						return NULL;
					}
					if (!empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
					{
						if ($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'] == $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']) 
						{
							return NULL;
						}
						if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['ordermoney'] < $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['ordermoney']) 
						{
							return NULL;
							if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 5) 
							{
								$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI . ' >= ordercount and ordercount>0  order by ordercount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
								if (empty($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE)) 
								{
									return NULL;
								}
								if (!empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
								{
									if ($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'] == $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']) 
									{
										return NULL;
									}
									if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['ordercount'] < $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['ordercount']) 
									{
										return NULL;
									}
								}
							}
						}
					}
				}
				else 
				{
					$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI . ' >= ordercount and ordercount>0  order by ordercount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
					return NULL;
					return NULL;
					return NULL;
				}
				pdo_update('sz_yi_member', array('agentlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']), array('id' => $_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['id']));
				$this->sendMessage($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['openid'], array('nickname' => $_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['nickname'], 'oldlevel' => $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE, 'newlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE), TM_COMMISSION_UPGRADE);
				return NULL;
			}
			if ((0 <= $_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE) && ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE <= 3)) 
			{
				$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE = array();
				if (!empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['selfbuy'])) 
				{
					$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE[] = $_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE;
				}
				if (!empty($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['agentid'])) 
				{
					$_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE = m('member')->getMember($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['agentid']);
					if (!empty($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE)) 
					{
						$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE[] = $_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE;
						if (!empty($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['agentid']) && ($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['isagent'] == 1) && ($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['status'] == 1)) 
						{
							$_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE = m('member')->getMember($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['agentid']);
							if (!empty($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE) && ($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['isagent'] == 1) && ($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['status'] == 1)) 
							{
								$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE[] = $_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE;
								if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['selfbuy'])) 
								{
									if (!empty($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['agentid']) && ($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['isagent'] == 1) && ($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['status'] == 1)) 
									{
										$_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE = m('member')->getMember($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['agentid']);
										if (!empty($_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE) && ($_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE['isagent'] == 1) && ($_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE['status'] == 1)) 
										{
											$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE[] = $_obfuscate_DQc1CQIQETwnExQcMSksCwM_IiQPJBE;
										}
									}
								}
							}
						}
					}
				}
				if (empty($_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE)) 
				{
					return NULL;
				}
				foreach ($_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE as $_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE ) 
				{
					$_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE = $this->getInfo($_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['id'], array('ordercount3', 'ordermoney3', 'order13money', 'order13'));
					if (!empty($_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['agentnotupgrade'])) 
					{
						continue;
					}
					$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = $this->getLevel($_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['openid']);
					if (empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
					{
						$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = array('levelname' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']) ? '普通等级' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']), 'commission1' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission1'], 'commission2' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission2'], 'commission3' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission3']);
					}
					if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 0) 
					{
						$_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['ordermoney3'];
						$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid and ' . $_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI . ' >= ordermoney and ordermoney>0  order by ordermoney desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						if (empty($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE)) 
						{
							continue;
						}
						if (!empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
						{
							if ($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'] == $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']) 
							{
								continue;
							}
							if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['ordermoney'] < $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['ordermoney']) 
							{
								continue;
								if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 1) 
								{
									$_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['order13money'];
									$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid and ' . $_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI . ' >= ordermoney and ordermoney>0  order by ordermoney desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
									if (empty($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE)) 
									{
										continue;
									}
									if (!empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
									{
										if ($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'] == $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']) 
										{
											continue;
										}
										if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['ordermoney'] < $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['ordermoney']) 
										{
											continue;
											if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 2) 
											{
												$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['ordercount3'];
												$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI . ' >= ordercount and ordercount>0  order by ordercount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
												if (empty($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE)) 
												{
													continue;
												}
												if (!empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
												{
													if ($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'] == $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']) 
													{
														continue;
													}
													if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['ordercount'] < $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['ordercount']) 
													{
														continue;
														if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 3) 
														{
															$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['order13'];
															$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI . ' >= ordercount and ordercount>0  order by ordercount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
															if (empty($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE)) 
															{
																continue;
															}
															if (!empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
															{
																if ($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'] == $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']) 
																{
																	continue;
																}
																if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['ordercount'] < $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['ordercount']) 
																{
																	continue;
																}
															}
														}
													}
												}
											}
											else 
											{
												$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['order13'];
												$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI . ' >= ordercount and ordercount>0  order by ordercount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
												continue;
												continue;
												continue;
											}
										}
									}
								}
								else 
								{
									$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['ordercount3'];
									$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI . ' >= ordercount and ordercount>0  order by ordercount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
									continue;
									continue;
									continue;
									$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['order13'];
									$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI . ' >= ordercount and ordercount>0  order by ordercount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
									continue;
									continue;
									continue;
								}
							}
						}
					}
					else 
					{
						$_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['order13money'];
						$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid and ' . $_obfuscate_DSwlOD09MT42CQYvOQcFMBUZJD0NPTI . ' >= ordermoney and ordermoney>0  order by ordermoney desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						continue;
						continue;
						continue;
						$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['ordercount3'];
						$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI . ' >= ordercount and ordercount>0  order by ordercount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						continue;
						continue;
						continue;
						$_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['order13'];
						$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DSclNUA5JBcyMQQBIgUmWxM3LhwhGiI . ' >= ordercount and ordercount>0  order by ordercount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						continue;
						continue;
						continue;
					}
					pdo_update('sz_yi_member', array('agentlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']), array('id' => $_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['id']));
					$this->sendMessage($_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['openid'], array('nickname' => $_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['nickname'], 'oldlevel' => $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE, 'newlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE), TM_COMMISSION_UPGRADE);
				}
			}
		}
		public function upgradeLevelByAgent($_var_20) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			if (empty($_var_20)) 
			{
				return false;
			}
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
			{
				return false;
			}
			$_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE = m('member')->getMember($_var_20);
			if (empty($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE)) 
			{
				return NULL;
			}
			$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE = p('bonus');
			if (!empty($_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE)) 
			{
				$_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI = $_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->getSet();
				if (!empty($_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI['start'])) 
				{
					$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->upgradeLevelByAgent($_var_20);
				}
			}
			$_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['leveltype']);
			if (($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE < 6) || (9 < $_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE)) 
			{
				return NULL;
			}
			$_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE = $this->getInfo($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['id'], array());
			if (($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 6) || ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 8)) 
			{
				$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE = array($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE);
				if (!empty($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['agentid'])) 
				{
					$_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE = m('member')->getMember($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['agentid']);
					if (!empty($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE)) 
					{
						$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE[] = $_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE;
						if (!empty($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['agentid']) && ($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['isagent'] == 1) && ($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['status'] == 1)) 
						{
							$_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE = m('member')->getMember($_obfuscate_DRg4FwsYB0BcKiQ4Ww8mAxFAAkAQBxE['agentid']);
							if (!empty($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE) && ($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['isagent'] == 1) && ($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE['status'] == 1)) 
							{
								$_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE[] = $_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE;
							}
						}
					}
				}
				if (empty($_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE)) 
				{
					return NULL;
				}
				foreach ($_obfuscate_DRY4GjIcKw4mMRBADAkVLhcuKj08NBE as $_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE ) 
				{
					$_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE = $this->getInfo($_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['id'], array());
					if (!empty($_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['agentnotupgrade'])) 
					{
						continue;
					}
					$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = $this->getLevel($_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['openid']);
					if (empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
					{
						$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = array('levelname' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']) ? '普通等级' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']), 'commission1' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission1'], 'commission2' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission2'], 'commission3' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission3']);
					}
					if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 6) 
					{
						$_obfuscate_DT0DHRYmGg4TJggpMRMhJyI0ERAGAgE = pdo_fetchall('select id from ' . tablename('sz_yi_member') . ' where agentid=:agentid and uniacid=:uniacid ', array(':agentid' => $_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['id'], ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']), 'id');
						$_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE += count($_obfuscate_DT0DHRYmGg4TJggpMRMhJyI0ERAGAgE);
						if (!empty($_obfuscate_DT0DHRYmGg4TJggpMRMhJyI0ERAGAgE)) 
						{
							$_obfuscate_DRcdEDAFHQkPLCs7PzUyCxkXFSknIiI = pdo_fetchall('select id from ' . tablename('sz_yi_member') . ' where agentid in( ' . implode(',', array_keys($_obfuscate_DT0DHRYmGg4TJggpMRMhJyI0ERAGAgE)) . ') and uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']), 'id');
							$_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE += count($_obfuscate_DRcdEDAFHQkPLCs7PzUyCxkXFSknIiI);
							if (!empty($_obfuscate_DRcdEDAFHQkPLCs7PzUyCxkXFSknIiI)) 
							{
								$_obfuscate_DR44NysXPh4GJi8sXDgyCQwOPBUPDI = pdo_fetchall('select id from ' . tablename('sz_yi_member') . ' where agentid in( ' . implode(',', array_keys($_obfuscate_DRcdEDAFHQkPLCs7PzUyCxkXFSknIiI)) . ') and uniacid=:uniacid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']), 'id');
								$_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE += count($_obfuscate_DR44NysXPh4GJi8sXDgyCQwOPBUPDI);
							}
						}
						$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE . ' >= downcount and downcount>0  order by downcount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
					}
					else if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 8) 
					{
						$_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['level1'] + $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['level2'] + $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['level3'];
						$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE . ' >= downcount and downcount>0  order by downcount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
					}
					if (empty($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE)) 
					{
						continue;
					}
					if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id'] == $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id']) 
					{
						continue;
					}
					if (!empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
					{
						if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['downcount'] < $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['downcount']) 
						{
							continue;
						}
					}
					pdo_update('sz_yi_member', array('agentlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']), array('id' => $_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['id']));
					$this->sendMessage($_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['openid'], array('nickname' => $_obfuscate_DTAiFBYYIis1LgYHXD8EPygaHx4cKxE['nickname'], 'oldlevel' => $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE, 'newlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE), TM_COMMISSION_UPGRADE);
				}
				return NULL;
			}
			if (!empty($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['agentnotupgrade'])) 
			{
				return NULL;
			}
			$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = $this->getLevel($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['openid']);
			if (empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
			{
				$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = array('levelname' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']) ? '普通等级' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']), 'commission1' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission1'], 'commission2' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission2'], 'commission3' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission3']);
			}
			if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 7) 
			{
				$_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_member') . ' where agentid=:agentid and uniacid=:uniacid ', array(':agentid' => $_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['id'], ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
				$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE . ' >= downcount and downcount>0  order by downcount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			}
			else if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE == 9) 
			{
				$_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['level1'];
				$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DUAHD0qLBsjQFwvBj0PLAIYCxsbMwE . ' >= downcount and downcount>0  order by downcount desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			}
			if (empty($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE)) 
			{
				return NULL;
			}
			if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id'] == $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id']) 
			{
				return NULL;
			}
			if (!empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
			{
				if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['downcount'] < $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['downcount']) 
				{
					return NULL;
				}
			}
			pdo_update('sz_yi_member', array('agentlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']), array('id' => $_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['id']));
			$this->sendMessage($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['openid'], array('nickname' => $_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['nickname'], 'oldlevel' => $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE, 'newlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE), TM_COMMISSION_UPGRADE);
		}
		public function upgradeLevelByCommissionOK($_var_20) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			if (empty($_var_20)) 
			{
				return false;
			}
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
			{
				return false;
			}
			$_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE = m('member')->getMember($_var_20);
			if (empty($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE)) 
			{
				return NULL;
			}
			$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE = p('bonus');
			if (!empty($_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE)) 
			{
				$_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI = $_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->getSet();
				if (!empty($_obfuscate_DSsEHjANATMNFSMDECUVEAMqBgYfQCI['start'])) 
				{
					$_obfuscate_DTMDE1wTLxAZBCcQHCgfPQIlXAgJPhE->upgradeLevelByAgent($_var_20);
				}
			}
			$_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE = intval($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['leveltype']);
			if ($_obfuscate_DSwDHjMFHBEFzkDPxQkLTIvM1wBQE != 10) 
			{
				return NULL;
			}
			if (!empty($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['agentnotupgrade'])) 
			{
				return NULL;
			}
			$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = $this->getLevel($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['openid']);
			if (empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
			{
				$_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE = array('levelname' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']) ? '普通等级' : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['levelname']), 'commission1' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission1'], 'commission2' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission2'], 'commission3' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['commission3']);
			}
			$_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE = $this->getInfo($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['id'], array('pay'));
			$_obfuscate_DTs7LDQ5ETBbDCxAFywLBS1AFhIhNyI = $_obfuscate_DR8yEB8eMzwtDBcaXCIbLTw_Px4iNwE['commission_pay'];
			$_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE = pdo_fetch('select * from ' . tablename('sz_yi_commission_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DTs7LDQ5ETBbDCxAFywLBS1AFhIhNyI . ' >= commissionmoney and commissionmoney>0  order by commissionmoney desc limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			if (empty($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE)) 
			{
				return NULL;
			}
			if ($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'] == $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']) 
			{
				return NULL;
			}
			if (!empty($_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['id'])) 
			{
				if ($_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['commissionmoney'] < $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE['commissionmoney']) 
				{
					return NULL;
				}
			}
			pdo_update('sz_yi_member', array('agentlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE['id']), array('id' => $_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['id']));
			$this->sendMessage($_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['openid'], array('nickname' => $_obfuscate_DRQUPzQxPB0yMgoVHhpcJAI9HB0KJwE['nickname'], 'oldlevel' => $_obfuscate_DQI8GBACOQsKGz8VMTA0WwE1LTI7MwE, 'newlevel' => $_obfuscate_DSgUPzUGBiwdPyc9DS8PJg8SKyomWxE), TM_COMMISSION_UPGRADE);
		}
		public function sendMessage($_var_20 = '', $_var_150 = array(), $_var_151 = '') 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			$_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI = $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['tm'];
			$_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['templateid'];
			$_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE = m('member')->getMember($_var_20);
			$_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE = unserialize($_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['noticeset']);
			if (!is_array($_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE)) 
			{
				$_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE = array();
			}
			if (($_var_151 == TM_COMMISSION_AGENT_NEW) && !empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_agent_new']) && empty($_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE['commission_agent_new'])) 
			{
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_agent_new'];
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[昵称]', $_var_150['nickname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i:s', $_var_150['childtime']), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => (!empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_agent_newtitle']) ? $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_agent_newtitle'] : '新增下线通知'), 'color' => '#73a68d'), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI, 'color' => '#73a68d') );
				if (!empty($_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI)) 
				{
					m('message')->sendTplNotice($_var_20, $_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
					return NULL;
				}
				m('message')->sendCustomNotice($_var_20, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
				return NULL;
			}
			if (($_var_151 == TM_COMMISSION_ORDER_PAY) && !empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_order_pay']) && empty($_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE['commission_order_pay'])) 
			{
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_order_pay'];
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[昵称]', $_var_150['nickname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i:s', $_var_150['paytime']), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[订单编号]', $_var_150['ordersn'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[订单金额]', $_var_150['price'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[佣金金额]', $_var_150['commission'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[商品详情]', $_var_150['goods'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => (!empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_order_paytitle']) ? $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_order_paytitle'] : '下线付款通知')), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI) );
				if (!empty($_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI)) 
				{
					m('message')->sendTplNotice($_var_20, $_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
					return NULL;
				}
				m('message')->sendCustomNotice($_var_20, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
				return NULL;
			}
			if (($_var_151 == TM_COMMISSION_ORDER_FINISH) && !empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_order_finish']) && empty($_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE['commission_order_finish'])) 
			{
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_order_finish'];
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[昵称]', $_var_150['nickname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i:s', $_var_150['finishtime']), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[订单编号]', $_var_150['ordersn'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[订单金额]', $_var_150['price'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[佣金金额]', $_var_150['commission'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[商品详情]', $_var_150['goods'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => (!empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_order_finishtitle']) ? $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_order_finishtitle'] : '下线确认收货通知'), 'color' => '#73a68d'), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI, 'color' => '#73a68d') );
				if (!empty($_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI)) 
				{
					m('message')->sendTplNotice($_var_20, $_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
					return NULL;
				}
				m('message')->sendCustomNotice($_var_20, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
				return NULL;
			}
			if (($_var_151 == TM_COMMISSION_APPLY) && !empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_apply']) && empty($_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE['commission_apply'])) 
			{
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_apply'];
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[昵称]', $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['nickname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[金额]', $_var_150['commission'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[提现方式]', $_var_150['type'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => (!empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_applytitle']) ? $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_applytitle'] : '提现申请提交成功'), 'color' => '#73a68d'), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI, 'color' => '#73a68d') );
				if (!empty($_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI)) 
				{
					m('message')->sendTplNotice($_var_20, $_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
					return NULL;
				}
				m('message')->sendCustomNotice($_var_20, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
				return NULL;
			}
			if (($_var_151 == TM_COMMISSION_CHECK) && !empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_check']) && empty($_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE['commission_check'])) 
			{
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_check'];
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[昵称]', $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['nickname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[金额]', $_var_150['commission'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[提现方式]', $_var_150['type'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => (!empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_checktitle']) ? $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_checktitle'] : '提现申请审核处理完成'), 'color' => '#73a68d'), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI, 'color' => '#73a68d') );
				if (!empty($_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI)) 
				{
					m('message')->sendTplNotice($_var_20, $_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
					return NULL;
				}
				m('message')->sendCustomNotice($_var_20, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
				return NULL;
			}
			if (($_var_151 == TM_COMMISSION_PAY) && !empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_pay']) && empty($_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE['commission_pay'])) 
			{
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_pay'];
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[昵称]', $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['nickname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[金额]', $_var_150['commission'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[提现方式]', $_var_150['type'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[微信比例]', $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['withdraw_wechat'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[商城余额比例]', $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['withdraw_balance'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[税费和服务费比例]', $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['withdraw_factorage'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => (!empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_paytitle']) ? $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_paytitle'] : '佣金打款通知'), 'color' => '#73a68d'), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI, 'color' => '#73a68d') );
				if (!empty($_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI)) 
				{
					m('message')->sendTplNotice($_var_20, $_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
					return NULL;
				}
				m('message')->sendCustomNotice($_var_20, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
				return NULL;
			}
			if (($_var_151 == TM_COMMISSION_UPGRADE) && !empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_upgrade']) && empty($_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE['commission_upgrade'])) 
			{
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_upgrade'];
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[昵称]', $_obfuscate_DQUXPCMWNgQOJyQ_Axk4PjkrFBY8JhE['nickname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[旧等级]', $_var_150['oldlevel']['levelname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[旧一级分销比例]', $_var_150['oldlevel']['commission1'] . '%', $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[旧二级分销比例]', $_var_150['oldlevel']['commission2'] . '%', $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[旧三级分销比例]', $_var_150['oldlevel']['commission3'] . '%', $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[新等级]', $_var_150['newlevel']['levelname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[新一级分销比例]', $_var_150['newlevel']['commission1'] . '%', $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[新二级分销比例]', $_var_150['newlevel']['commission2'] . '%', $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[新三级分销比例]', $_var_150['newlevel']['commission3'] . '%', $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => (!empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_upgradetitle']) ? $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_upgradetitle'] : '分销等级升级通知'), 'color' => '#73a68d'), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI, 'color' => '#73a68d') );
				if (!empty($_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI)) 
				{
					m('message')->sendTplNotice($_var_20, $_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
					return NULL;
				}
				m('message')->sendCustomNotice($_var_20, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
				return NULL;
			}
			if (($_var_151 == TM_COMMISSION_BECOME) && !empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_become']) && empty($_obfuscate_DR4OAQkCCxAtASI4LQ0KBSwVOC4FJQE['commission_become'])) 
			{
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_become'];
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[昵称]', $_var_150['nickname'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i:s', $_var_150['agenttime']), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => (!empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_becometitle']) ? $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_becometitle'] : '成为分销商通知'), 'color' => '#73a68d'), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI, 'color' => '#73a68d') );
				if (!empty($_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI)) 
				{
					m('message')->sendTplNotice($_var_20, $_obfuscate_DScjMjQyAw8WNRskNDsbBBMULhg1IyI, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
					return NULL;
				}
				m('message')->sendCustomNotice($_var_20, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
			}
		}
		public function perms() 
		{
			return array( 'commission' => array( 'text' => $this->getName(), 'isplugin' => true, 'child' => array( 'cover' => array('text' => '入口设置'), 'agent' => array('text' => '分销商', 'view' => '浏览', 'check' => '审核-log', 'edit' => '修改-log', 'agentblack' => '黑名单操作-log', 'delete' => '删除-log', 'user' => '查看下线', 'order' => '查看推广订单(还需有订单权限)', 'changeagent' => '设置分销商'), 'level' => array('text' => '分销商等级', 'view' => '浏览', 'add' => '添加-log', 'edit' => '修改-log', 'delete' => '删除-log'), 'apply' => array('text' => '佣金审核', 'view1' => '浏览待审核', 'view2' => '浏览已审核', 'view3' => '浏览已打款', 'view_1' => '浏览无效', 'export1' => '导出待审核-log', 'export2' => '导出已审核-log', 'export3' => '导出已打款-log', 'export_1' => '导出无效-log', 'check' => '审核-log', 'pay' => '打款-log', 'cancel' => '重新审核-log'), 'notice' => array('text' => '通知设置-log'), 'increase' => array('text' => '分销商趋势图'), 'changecommission' => array('text' => '修改佣金-log'), 'set' => array('text' => '基础设置-log') ) ) );
		}
		public function upgradeLevelByGood($orderid) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			if (!$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['upgrade_by_good']) 
			{
				return NULL;
			}
			$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = pdo_fetch('select g.commission_level_id from ' . tablename('sz_yi_order_goods') . ' AS og, ' . tablename('sz_yi_goods') . ' AS g WHERE og.goodsid = g.id AND og.orderid=:orderid AND og.uniacid=:uniacid LIMIT 1', array(':orderid' => $orderid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			$_obfuscate_DQMsPigWBzY8GRFAJDgrFh0TAhEhGTI = $_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE['commission_level_id'];
			if ($_obfuscate_DQMsPigWBzY8GRFAJDgrFh0TAhEhGTI) 
			{
				$_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE = $this->getLevels();
				foreach ($_obfuscate_DTE3IwkaOzFAPy8KCzMeCjs9FzUCCQE as $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI ) 
				{
					if ($_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['id'] == $_obfuscate_DQMsPigWBzY8GRFAJDgrFh0TAhEhGTI) 
					{
						$_obfuscate_DTM1CEAuKDAZLgYoCSwtHR0FRUBPhE = $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['commission1'];
						$_obfuscate_DR8kDzUEByY2AxgdJCYvGQ0mHj8pIxE = $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['commission2'];
						$_obfuscate_DRsVHFwBHgkCGyEsKQUvCxY3LR8WOxE = $_obfuscate_DSgHNAMSPwIeHjIaODc3BRVbLRs4HjI['commission3'];
					}
				}
				$_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE = pdo_fetchcolumn('select openid from ' . tablename('sz_yi_order') . ' where uniacid=:uniacid and id=:orderid', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':orderid' => $orderid));
				$_obfuscate_DRgKKRIRMzc5KiUnKSUiDD8rAycdEyI = $this->getLevel($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE);
				if (!$_obfuscate_DRgKKRIRMzc5KiUnKSUiDD8rAycdEyI || ($_obfuscate_DRgKKRIRMzc5KiUnKSUiDD8rAycdEyI['commission1'] < $_obfuscate_DTM1CEAuKDAZLgYoCSwtHR0FRUBPhE) || ($_obfuscate_DRgKKRIRMzc5KiUnKSUiDD8rAycdEyI['commission2'] < $_obfuscate_DR8kDzUEByY2AxgdJCYvGQ0mHj8pIxE) || ($_obfuscate_DRgKKRIRMzc5KiUnKSUiDD8rAycdEyI['commission3'] < $_obfuscate_DRsVHFwBHgkCGyEsKQUvCxY3LR8WOxE)) 
				{
					pdo_update('sz_yi_member', array('agentlevel' => $_obfuscate_DQMsPigWBzY8GRFAJDgrFh0TAhEhGTI), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'openid' => $_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE));
				}
			}
		}
	}
}
?>