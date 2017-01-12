<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Sz_DYi_Member 
{
	public function getInfo($openid = '') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = intval($openid);
		if ($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI == 0) 
		{
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':openid' => $openid));
		}
		else 
		{
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where id=:id  and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':id' => $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI));
		}
		if (!empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['uid'])) 
		{
			load()->model('mc');
			$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = mc_openid2uid($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['openid']);
			$_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE = mc_fetch($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI, array('credit1', 'credit2', 'birthyear', 'birthmonth', 'birthday', 'gender', 'avatar', 'resideprovince', 'residecity', 'nickname'));
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['credit1'] = $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['credit1'];
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['credit2'] = $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['credit2'];
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthyear'] = (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthyear']) ? $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['birthyear'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthyear']);
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthmonth'] = (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthmonth']) ? $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['birthmonth'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthmonth']);
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday'] = (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday']) ? $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['birthday'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday']);
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['nickname'] = (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['nickname']) ? $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['nickname'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['nickname']);
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['gender'] = (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['gender']) ? $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['gender'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['gender']);
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['sex'] = $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['gender'];
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['avatar'] = (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['avatar']) ? $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['avatar'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['avatar']);
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['headimgurl'] = $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['avatar'];
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['province'] = (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['province']) ? $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['resideprovince'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['province']);
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['city'] = (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['city']) ? $_obfuscate_DQsxLxkiEwMNBRAxLAkyCjQZWxQWExE['residecity'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['city']);
		}
		if (!empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthyear']) && !empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthmonth']) && !empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday'])) 
		{
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday'] = $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthyear'] . '-' . ((strlen($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthmonth']) <= 1 ? '0' . $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthmonth'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthmonth'])) . '-' . ((strlen($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday']) <= 1 ? '0' . $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday'] : $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday']));
		}
		if (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday'])) 
		{
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['birthday'] = '';
		}
		return $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE;
	}
	public function getMember($openid = '') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = intval($openid);
		if (empty($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI)) 
		{
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where  openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':openid' => $openid));
		}
		else 
		{
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':id' => $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI));
		}
		if (!empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE)) 
		{
			$openid = $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['openid'];
			if (empty($_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['uid'])) 
			{
				$_obfuscate_DRMSOTIOQklKwQyIysMChofExcFNzI = m('user')->followed($openid);
				if ($_obfuscate_DRMSOTIOQklKwQyIysMChofExcFNzI) 
				{
					load()->model('mc');
					$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = mc_openid2uid($openid);
					if (!empty($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI)) 
					{
						$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['uid'] = $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI;
						$_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE = array('uid' => $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI);
						if (0 < $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['credit1']) 
						{
							mc_credit_update($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI, 'credit1', $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['credit1']);
							$_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE['credit1'] = 0;
						}
						if (0 < $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['credit2']) 
						{
							mc_credit_update($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI, 'credit2', $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['credit2']);
							$_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE['credit2'] = 0;
						}
						if (!empty($_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE)) 
						{
							pdo_update('sz_yi_member', $_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE, array('id' => $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['id']));
						}
					}
				}
			}
			$_obfuscate_DQgrQBo3KyglCy4FCT0NMhQmMTgUMwE = $this->getCredits($openid);
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['credit1'] = $_obfuscate_DQgrQBo3KyglCy4FCT0NMhQmMTgUMwE['credit1'];
			$_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE['credit2'] = $_obfuscate_DQgrQBo3KyglCy4FCT0NMhQmMTgUMwE['credit2'];
		}
		return $_obfuscate_DTYnJgwRNzU9Jgw7CwkeNDsqLDYSGxE;
	}
	public function getMid() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE = m('user')->getOpenid();
		$_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE = $this->getMember($_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE);
		return $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['id'];
	}
	public function responseReferral($set, $referral, $member) 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRgTHBY_ER0WJRMpJTA0JwQMAIbKjI = $set['subpaycontent'];
		if (empty($_obfuscate_DRgTHBY_ER0WJRMpJTA0JwQMAIbKjI)) 
		{
			$_obfuscate_DRgTHBY_ER0WJRMpJTA0JwQMAIbKjI = '您通过 [nickname]的推荐码注册账号的奖励';
		}
		$_obfuscate_DRgTHBY_ER0WJRMpJTA0JwQMAIbKjI = str_replace('[nickname]', $referral['mobile'], $_obfuscate_DRgTHBY_ER0WJRMpJTA0JwQMAIbKjI);
		$_obfuscate_DTszLR4ICQoZLSEuHi0wMTQyFRBbLjI = $set['recpaycontent'];
		if (empty($_obfuscate_DTszLR4ICQoZLSEuHi0wMTQyFRBbLjI)) 
		{
			$_obfuscate_DTszLR4ICQoZLSEuHi0wMTQyFRBbLjI = '推荐 [nickname] 使用推荐码注册账号的奖励';
		}
		$_obfuscate_DTszLR4ICQoZLSEuHi0wMTQyFRBbLjI = str_replace('[nickname]', $member['mobile'], $_obfuscate_DTszLR4ICQoZLSEuHi0wMTQyFRBbLjI);
		if (0 < $set['subcredit']) 
		{
			m('member')->setCredit($member['openid'], 'credit1', $set['subcredit'], array(0, '推荐码注册积分+' . $set['subcredit']));
		}
		if (0 < $set['submoney']) 
		{
			$_obfuscate_DRwxFgUFHkAyIjEVFAkZNBAaMAsQORE = $set['submoney'];
			if ($set['paytype'] == 1) 
			{
				$_obfuscate_DRwxFgUFHkAyIjEVFAkZNBAaMAsQORE *= 100;
			}
			m('finance')->pay($member['openid'], $set['paytype'], $_obfuscate_DRwxFgUFHkAyIjEVFAkZNBAaMAsQORE, '', $_obfuscate_DRgTHBY_ER0WJRMpJTA0JwQMAIbKjI);
		}
		if (0 < $set['reccredit']) 
		{
			m('member')->setCredit($referral['openid'], 'credit1', $set['reccredit'], array(0, '分享推荐码注册积分+' . $set['reccredit']));
		}
		if (0 < $set['recmoney']) 
		{
			$_obfuscate_DRwxFgUFHkAyIjEVFAkZNBAaMAsQORE = $set['recmoney'];
			if ($set['paytype'] == 1) 
			{
				$_obfuscate_DRwxFgUFHkAyIjEVFAkZNBAaMAsQORE *= 100;
			}
			m('finance')->pay($referral['openid'], $set['paytype'], $_obfuscate_DRwxFgUFHkAyIjEVFAkZNBAaMAsQORE, '', $_obfuscate_DTszLR4ICQoZLSEuHi0wMTQyFRBbLjI);
		}
		if (!empty($set['subtext'])) 
		{
			$_obfuscate_DR4tAgwcITY9KBYGycfARcuPQEUExE = $set['subtext'];
			$_obfuscate_DR4tAgwcITY9KBYGycfARcuPQEUExE = str_replace('[nickname]', $member['mobile'], $_obfuscate_DR4tAgwcITY9KBYGycfARcuPQEUExE);
			$_obfuscate_DR4tAgwcITY9KBYGycfARcuPQEUExE = str_replace('[credit]', $set['reccredit'], $_obfuscate_DR4tAgwcITY9KBYGycfARcuPQEUExE);
			$_obfuscate_DR4tAgwcITY9KBYGycfARcuPQEUExE = str_replace('[money]', $set['recmoney'], $_obfuscate_DR4tAgwcITY9KBYGycfARcuPQEUExE);
			if (!empty($set['templateid'])) 
			{
				m('message')->sendTplNotice($referral['openid'], $set['templateid'], array( 'first' => array('value' => '推荐注册奖励到账通知', 'color' => '#4a5077'), 'keyword1' => array('value' => '推荐奖励', 'color' => '#4a5077'), 'keyword2' => array('value' => $_obfuscate_DR4tAgwcITY9KBYGycfARcuPQEUExE, 'color' => '#4a5077'), 'remark' => array('value' => "\r\n" . '谢谢您对我们的支持！', 'color' => '#4a5077') ), '');
			}
			else 
			{
				m('message')->sendCustomNotice($referral['openid'], $_obfuscate_DR4tAgwcITY9KBYGycfARcuPQEUExE);
			}
		}
		if (!empty($set['entrytext'])) 
		{
			$_obfuscate_DQIYFh0qEwICEA8VWxEUEDc3LDYZCAE = $set['entrytext'];
			$_obfuscate_DQIYFh0qEwICEA8VWxEUEDc3LDYZCAE = str_replace('[nickname]', $member['mobile'], $_obfuscate_DQIYFh0qEwICEA8VWxEUEDc3LDYZCAE);
			$_obfuscate_DQIYFh0qEwICEA8VWxEUEDc3LDYZCAE = str_replace('[credit]', $set['subcredit'], $_obfuscate_DQIYFh0qEwICEA8VWxEUEDc3LDYZCAE);
			$_obfuscate_DQIYFh0qEwICEA8VWxEUEDc3LDYZCAE = str_replace('[money]', $set['submoney'], $_obfuscate_DQIYFh0qEwICEA8VWxEUEDc3LDYZCAE);
			if (!empty($set['templateid'])) 
			{
				m('message')->sendTplNotice($member['openid'], $set['templateid'], array( 'first' => array('value' => '使用推荐码奖励到账通知', 'color' => '#4a5077'), 'keyword1' => array('value' => '使用推荐码奖励', 'color' => '#4a5077'), 'keyword2' => array('value' => $_obfuscate_DQIYFh0qEwICEA8VWxEUEDc3LDYZCAE, 'color' => '#4a5077'), 'remark' => array('value' => "\r\n" . '谢谢您对我们的支持！', 'color' => '#4a5077') ), '');
				return NULL;
			}
			m('message')->sendCustomNotice($_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE, $_obfuscate_DQIYFh0qEwICEA8VWxEUEDc3LDYZCAE);
		}
	}
	public function setCredit($openid = '', $credittype = 'credit1', $credits = 0, $log = array()) 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		load()->model('mc');
		$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = mc_openid2uid($openid);
		if (!empty($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI)) 
		{
			$_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE = pdo_fetchcolumn('SELECT ' . $credittype . ' FROM ' . tablename('mc_members') . ' WHERE `uid` = :uid', array(':uid' => $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI));
			$_obfuscate_DRY8EDgcOQktMx8LKj8XOwocMxMdJDI = $credits + $_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE;
			if ($_obfuscate_DRY8EDgcOQktMx8LKj8XOwocMxMdJDI <= 0) 
			{
				$_obfuscate_DRY8EDgcOQktMx8LKj8XOwocMxMdJDI = 0;
			}
			pdo_update('mc_members', array($credittype => $_obfuscate_DRY8EDgcOQktMx8LKj8XOwocMxMdJDI), array('uid' => $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI));
			if (empty($log) || !is_array($log)) 
			{
				$log = array($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI, '未记录');
			}
			$_obfuscate_DQ0SCDgzIyoiBEADLjIENyE4Nx0vKzI = array('uid' => $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI, 'credittype' => $credittype, 'uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], 'num' => $credits, 'createtime' => TIMESTAMP, 'operator' => intval($log[0]), 'remark' => $log[1]);
			pdo_insert('mc_credits_record', $_obfuscate_DQ0SCDgzIyoiBEADLjIENyE4Nx0vKzI);
			return NULL;
		}
		$_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE = pdo_fetchcolumn('SELECT ' . $credittype . ' FROM ' . tablename('sz_yi_member') . ' WHERE  uniacid=:uniacid and openid=:openid limit 1', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':openid' => $openid));
		$_obfuscate_DRY8EDgcOQktMx8LKj8XOwocMxMdJDI = $credits + $_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE;
		if ($_obfuscate_DRY8EDgcOQktMx8LKj8XOwocMxMdJDI <= 0) 
		{
			$_obfuscate_DRY8EDgcOQktMx8LKj8XOwocMxMdJDI = 0;
		}
		pdo_update('sz_yi_member', array($credittype => $_obfuscate_DRY8EDgcOQktMx8LKj8XOwocMxMdJDI), array('uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], 'openid' => $openid));
	}
	public function getCredit($openid = '', $credittype = 'credit1') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		load()->model('mc');
		$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = mc_openid2uid($openid);
		if (!empty($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI)) 
		{
			return pdo_fetchcolumn('SELECT ' . $credittype . ' FROM ' . tablename('mc_members') . ' WHERE `uid` = :uid', array(':uid' => $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI));
		}
		return pdo_fetchcolumn('SELECT ' . $credittype . ' FROM ' . tablename('sz_yi_member') . ' WHERE  openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':openid' => $openid));
	}
	public function getCredits($openid = '', $type = array('credit1', 'credit2')) 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		load()->model('mc');
		$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = mc_openid2uid($openid);
		$_obfuscate_DVs8OCcnASkyOyEpMz0eAQQIGS8HODI = implode(',', $type);
		if (!empty($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI)) 
		{
			return pdo_fetch('SELECT ' . $_obfuscate_DVs8OCcnASkyOyEpMz0eAQQIGS8HODI . ' FROM ' . tablename('mc_members') . ' WHERE `uid` = :uid limit 1', array(':uid' => $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI));
		}
		return pdo_fetch('SELECT ' . $_obfuscate_DVs8OCcnASkyOyEpMz0eAQQIGS8HODI . ' FROM ' . tablename('sz_yi_member') . ' WHERE  openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':openid' => $openid));
	}
	public function checkMember($openid = '') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
		if (strexists($_SERVER['REQUEST_URI'], '/web/')) 
		{
			return NULL;
		}
		if (empty($openid)) 
		{
			$openid = m('user')->getOpenid();
		}
		if (empty($openid)) 
		{
			return NULL;
		}
		$_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE = m('member')->getMember($openid);
		$_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI = m('user')->getInfo();
		$_obfuscate_DRMSOTIOQklKwQyIysMChofExcFNzI = m('user')->followed($openid);
		$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = 0;
		$_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE = array();
		load()->model('mc');
		if ($_obfuscate_DRMSOTIOQklKwQyIysMChofExcFNzI) 
		{
			$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = mc_openid2uid($openid);
			$_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE = mc_fetch($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI, array('realname', 'mobile', 'avatar', 'resideprovince', 'residecity', 'residedist'));
		}
		$_obfuscate_DT8eIRwhEBQDGgw2NAMcPhEkBRUxLzI = false;
		if (empty($_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE)) 
		{
			if ($_obfuscate_DRMSOTIOQklKwQyIysMChofExcFNzI) 
			{
				$_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI = mc_openid2uid($openid);
				$_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE = mc_fetch($_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI, array('realname', 'mobile', 'avatar', 'resideprovince', 'residecity', 'residedist'));
			}
			$_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE = array('uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], 'uid' => $_obfuscate_DTRAMCg5JhoUGh88LDEbBxUwLRUDOSI, 'openid' => $openid, 'realname' => (!empty($_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['realname']) ? $_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['realname'] : ''), 'mobile' => (!empty($_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['mobile']) ? $_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['mobile'] : ''), 'nickname' => (!empty($_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['nickname']) ? $_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['nickname'] : $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['nickname']), 'avatar' => (!empty($_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['avatar']) ? $_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['avatar'] : $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['avatar']), 'gender' => (!empty($_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['gender']) ? $_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['gender'] : $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['sex']), 'province' => (!empty($_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['residecity']) ? $_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['resideprovince'] : $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['province']), 'city' => (!empty($_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['residecity']) ? $_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['residecity'] : $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['city']), 'area' => (!empty($_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['residedist']) ? $_obfuscate_DTEWOTlbCx8IJjtcJCchHRAMNycEHAE['residedist'] : ''), 'createtime' => time(), 'status' => 0);
			$_obfuscate_DT8eIRwhEBQDGgw2NAMcPhEkBRUxLzI = true;
			pdo_insert('sz_yi_member', $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE);
		}
		else 
		{
			$_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE = array();
			if ($_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['nickname'] != $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['nickname']) 
			{
				$_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE['nickname'] = $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['nickname'];
			}
			if ($_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['avatar'] != $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['avatar']) 
			{
				$_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE['avatar'] = $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['avatar'];
			}
			if (!empty($_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE)) 
			{
				pdo_update('sz_yi_member', $_obfuscate_DRYYAicVHSESFVwbHg0aLQ4MNzUuOAE, array('id' => $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['id']));
			}
		}
		if (p('commission')) 
		{
			p('commission')->checkAgent();
		}
		if (p('poster')) 
		{
			p('poster')->checkScan();
		}
		if ($_obfuscate_DT8eIRwhEBQDGgw2NAMcPhEkBRUxLzI && is_weixin()) 
		{
		}
	}
	public function getLevels() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		return pdo_fetchall('select * from ' . tablename('sz_yi_member_level') . ' where uniacid=:uniacid order by level asc', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
	}
	public function getLevel($openid) 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		if (empty($openid)) 
		{
			return false;
		}
		$_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE = m('member')->getMember($openid);
		if (empty($_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['level'])) 
		{
			return array('discount' => 10);
		}
		$_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE = pdo_fetch('select * from ' . tablename('sz_yi_member_level') . ' where id=:id and uniacid=:uniacid order by level asc', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':id' => $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['level']));
		if (empty($_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE)) 
		{
			return array('discount' => 10);
		}
		return $_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE;
	}
	public function upgradeLevel($openid) 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		if (empty($openid)) 
		{
			return NULL;
		}
		$_obfuscate_DTEEMhIOC1sXHhMyFTAFNhgyPgI7HgE = m('common')->getSysset('shop');
		$_obfuscate_DQkJPAQUL1wJNRYYLyE2WxUfFz88GxE = intval($_obfuscate_DTEEMhIOC1sXHhMyFTAFNhgyPgI7HgE['leveltype']);
		$_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE = m('member')->getMember($openid);
		if (empty($_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE)) 
		{
			return NULL;
		}
		$_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE = false;
		if (empty($_obfuscate_DQkJPAQUL1wJNRYYLyE2WxUfFz88GxE)) 
		{
			$_obfuscate_DQEjIhM0XCoiBiMbIzQZH0AbJygLIiI = pdo_fetchcolumn('select ifnull( sum(og.realprice),0) from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_order') . ' o on o.id=og.orderid ' . ' where o.openid=:openid and o.status=3 and o.uniacid=:uniacid ', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':openid' => $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['openid']));
			$_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE = pdo_fetch('select * from ' . tablename('sz_yi_member_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DQEjIhM0XCoiBiMbIzQZH0AbJygLIiI . ' >= ordermoney and ordermoney>0  order by level desc limit 1', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
		}
		else if ($_obfuscate_DQkJPAQUL1wJNRYYLyE2WxUfFz88GxE == 1) 
		{
			$_obfuscate_DQULJRw0MTIfXCUiGzQaIy0XOBVAXCI = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_order') . ' where openid=:openid and status=3 and uniacid=:uniacid ', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'], ':openid' => $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['openid']));
			$_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE = pdo_fetch('select * from ' . tablename('sz_yi_member_level') . ' where uniacid=:uniacid  and ' . $_obfuscate_DQULJRw0MTIfXCUiGzQaIy0XOBVAXCI . ' >= ordercount and ordercount>0  order by level desc limit 1', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
		}
		if (empty($_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE)) 
		{
			return NULL;
		}
		if ($_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE['id'] == $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['level']) 
		{
			return NULL;
		}
		$_obfuscate_DS8DAxg0KBcEEkA8JQ89KAwNLjUrLQE = $this->getLevel($openid);
		$_obfuscate_DQEfNyEONjc8EDIqJCQaCjsWCxYLHiI = false;
		if (empty($_obfuscate_DS8DAxg0KBcEEkA8JQ89KAwNLjUrLQE['id'])) 
		{
			$_obfuscate_DQEfNyEONjc8EDIqJCQaCjsWCxYLHiI = true;
		}
		else if ($_obfuscate_DS8DAxg0KBcEEkA8JQ89KAwNLjUrLQE['level'] < $_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE['level']) 
		{
			$_obfuscate_DQEfNyEONjc8EDIqJCQaCjsWCxYLHiI = true;
		}
		if ($_obfuscate_DQEfNyEONjc8EDIqJCQaCjsWCxYLHiI) 
		{
			pdo_update('sz_yi_member', array('level' => $_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE['id']), array('id' => $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['id']));
			m('notice')->sendMemberUpgradeMessage($openid, $_obfuscate_DS8DAxg0KBcEEkA8JQ89KAwNLjUrLQE, $_obfuscate_DRYWIx4HLzYDSkTAhAjXBMuOTESBgE);
		}
	}
	public function getGroups() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		return pdo_fetchall('select * from ' . tablename('sz_yi_member_group') . ' where uniacid=:uniacid order by id asc', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
	}
	public function getGroup($openid) 
	{
		if (empty($openid)) 
		{
			return false;
		}
		$_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE = m('member')->getMember($openid);
		return $_obfuscate_DQkbLipcKjk9EB9ACg1AKjAlNBkoCwE['groupid'];
	}
	public function setRechargeCredit($openid = '', $money = 0) 
	{
		if (empty($openid)) 
		{
			return NULL;
		}
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DTs2AzYkGSEeBBYFHRMhAjMCAlsRLSI = 0;
		$_obfuscate_DTYdNwg8Dw0ZJD4wHBRAPiQbHCofKhE = m('common')->getSysset(array('trade', 'shop'));
		if ($_obfuscate_DTYdNwg8Dw0ZJD4wHBRAPiQbHCofKhE['trade']) 
		{
			$_obfuscate_DS8iHRUsGB0lCR83BxQVLxgiPCRbFjI = floatval($_obfuscate_DTYdNwg8Dw0ZJD4wHBRAPiQbHCofKhE['trade']['money']);
			$_obfuscate_DS0HMw0iCQwBNxcaFyIoIR0KHy8KESI = intval($_obfuscate_DTYdNwg8Dw0ZJD4wHBRAPiQbHCofKhE['trade']['credit']);
			if (0 < $_obfuscate_DS8iHRUsGB0lCR83BxQVLxgiPCRbFjI) 
			{
				if (($money % $_obfuscate_DS8iHRUsGB0lCR83BxQVLxgiPCRbFjI) == 0) 
				{
					$_obfuscate_DTs2AzYkGSEeBBYFHRMhAjMCAlsRLSI = intval($money / $_obfuscate_DS8iHRUsGB0lCR83BxQVLxgiPCRbFjI) * $_obfuscate_DS0HMw0iCQwBNxcaFyIoIR0KHy8KESI;
				}
				else 
				{
					$_obfuscate_DTs2AzYkGSEeBBYFHRMhAjMCAlsRLSI = (intval($money / $_obfuscate_DS8iHRUsGB0lCR83BxQVLxgiPCRbFjI) + 1) * $_obfuscate_DS0HMw0iCQwBNxcaFyIoIR0KHy8KESI;
				}
			}
		}
		if (0 < $_obfuscate_DTs2AzYkGSEeBBYFHRMhAjMCAlsRLSI) 
		{
			$this->setCredit($openid, 'credit1', $_obfuscate_DTs2AzYkGSEeBBYFHRMhAjMCAlsRLSI, array(0, $_obfuscate_DTYdNwg8Dw0ZJD4wHBRAPiQbHCofKhE['shop']['name'] . '会员充值积分:credit2:' . $_obfuscate_DTs2AzYkGSEeBBYFHRMhAjMCAlsRLSI));
		}
	}
	public function writelog($str, $title = 'Error') 
	{
		$_obfuscate_DUASCjMpGTYMKhYECBI2WwYFMBMzDDI = fopen($title . '.txt', 'a');
		fwrite($_obfuscate_DUASCjMpGTYMKhYECBI2WwYFMBMzDDI, $str);
		fclose($_obfuscate_DUASCjMpGTYMKhYECBI2WwYFMBMzDDI);
	}
}
?>