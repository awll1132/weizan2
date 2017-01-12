<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Core extends WeModuleSite 
{
	public $footer = array();
	public $header;
	public $yzShopSet = array();
	public $yzImages = array();
	public function __construct() 
	{
		global $_W;
		global $_GPC;
		m('common')->checkClose();
		if (empty($_W['uniacid'])) 
		{
			if (!empty($_W['uid'])) 
			{
				$_W['uniacid'] = pdo_fetchcolumn('select uniacid from ' . tablename('sz_yi_perm_user') . ' where uid=' . $_W['uid']);
				$_W['issupplier'] = 1;
			}
		}
		if (is_weixin()) 
		{
			m('member')->checkMember();
		}
		else 
		{
			$noLoginList = array('poster', 'postera');
			if (p('commission') && !in_array($_GPC['p'], $noLoginList) && !strpos($_SERVER['SCRIPT_NAME'], 'notify')) 
			{
				if (strexists($_SERVER['REQUEST_URI'], '/web/')) 
				{
					return NULL;
				}
				p('commission')->checkAgent();
			}
		}
		$this->yzShopSet = m('common')->getSysset('shop');
		$this->yzImages = set_medias(m('common')->getSysset('shop'), array('logo', 'img', 'pclogo'));
		if (is_app()) 
		{
			$_W['template'] = 'app';
			require IA_ROOT . '/addons/sz_yi/core/inc/plugin/vendor/leancloud/src/autoload.php';
			$setdata = m('cache')->get('sysset');
			$set = unserialize($setdata['sets']);
			$app = $set['app']['base'];
			LeanCloud\LeanClient::initialize($app['leancloud']['id'], $app['leancloud']['key'], $app['leancloud']['master'] . ',master');
		}
	}
	public function sendSms($mobile, $code, $templateType = 'reg') 
	{
		$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = m('common')->getSysset();
		if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['sms']['type'] == 1) 
		{
			return send_sms($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['sms']['account'], $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['sms']['password'], $mobile, $code);
		}
		return send_sms_alidayu($mobile, $code, $templateType);
	}
	public function runTasks() 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		load()->func('communication');
		$_obfuscate_DR4nNi8wBjEwCxUFLSIRKxU3OB8yESI = strtotime(m('cache')->getString('receive', 'global'));
		$_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI = intval(m('cache')->getString('receive_time', 'global'));
		if (empty($_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI)) 
		{
			$_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI = 60;
		}
		$_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI *= 60;
		$_obfuscate_DR8bNTgdJi8YLSokGQQFCxEHFSNAEwE = time();
		if (($_obfuscate_DR4nNi8wBjEwCxUFLSIRKxU3OB8yESI + $_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI) <= $_obfuscate_DR8bNTgdJi8YLSokGQQFCxEHFSNAEwE) 
		{
			m('cache')->set('receive', date('Y-m-d H:i:s', $_obfuscate_DR8bNTgdJi8YLSokGQQFCxEHFSNAEwE), 'global');
			$_obfuscate_DQknLjQpGi42GRItFxgBPigRNx8MGyI = $this->createMobileUrl('order/receive');
			ihttp_request($_obfuscate_DQknLjQpGi42GRItFxgBPigRNx8MGyI, NULL, NULL, 1);
		}
		$_obfuscate_DR4nNi8wBjEwCxUFLSIRKxU3OB8yESI = strtotime(m('cache')->getString('closeorder', 'global'));
		$_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI = intval(m('cache')->getString('closeorder_time', 'global'));
		if (empty($_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI)) 
		{
			$_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI = 60;
		}
		$_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI *= 60;
		$_obfuscate_DR8bNTgdJi8YLSokGQQFCxEHFSNAEwE = time();
		if (($_obfuscate_DR4nNi8wBjEwCxUFLSIRKxU3OB8yESI + $_obfuscate_DQ8aDDgCDjMaGw0vGTUcGwFALj8hGCI) <= $_obfuscate_DR8bNTgdJi8YLSokGQQFCxEHFSNAEwE) 
		{
			m('cache')->set('closeorder', date('Y-m-d H:i:s', $_obfuscate_DR8bNTgdJi8YLSokGQQFCxEHFSNAEwE), 'global');
			$_obfuscate_DQsmARwNWykJHAsXGRIjMBYEDkAlORE = $this->createMobileUrl('order/close');
			ihttp_request($_obfuscate_DQsmARwNWykJHAsXGRIjMBYEDkAlORE, NULL, NULL, 1);
		}
		if (p('coupon')) 
		{
			$_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE = strtotime(m('cache')->getString('couponbacktime', 'global'));
			$_obfuscate_DTMWExMFKSc2IiEuAh05DBAaNiVAGzI = p('coupon')->getSet();
			$_obfuscate_DQQXCzQtGC0wJigiLQgQDjInKxEHSI = intval($_obfuscate_DTMWExMFKSc2IiEuAh05DBAaNiVAGzI['backruntime']);
			if (empty($_obfuscate_DQQXCzQtGC0wJigiLQgQDjInKxEHSI)) 
			{
				$_obfuscate_DQQXCzQtGC0wJigiLQgQDjInKxEHSI = 60;
			}
			$_obfuscate_DQQXCzQtGC0wJigiLQgQDjInKxEHSI *= 60;
			$_obfuscate_DTYjJz0NGylcAyk3Ey4nNhwJIjY7CjI = time();
			if (($_obfuscate_DRYBGSgZIw8TFwE9FiE8KwcTIRhcGgE + $_obfuscate_DQQXCzQtGC0wJigiLQgQDjInKxEHSI) <= $_obfuscate_DTYjJz0NGylcAyk3Ey4nNhwJIjY7CjI) 
			{
				m('cache')->set('couponbacktime', date('Y-m-d H:i:s', $_obfuscate_DTYjJz0NGylcAyk3Ey4nNhwJIjY7CjI), 'global');
				$_obfuscate_DRQLLlw7KhZcLj8XPA0HEyIMCAgaMAE = $this->createPluginMobileUrl('coupon/back');
				ihttp_request($_obfuscate_DRQLLlw7KhZcLj8XPA0HEyIMCAgaMAE, NULL, NULL, 1);
			}
		}
		exit('run finished.');
	}
	public function setHeader() 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
		$_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE = m('user')->getOpenid();
		$_obfuscate_DRE7NS44KSUKBsmKxIvGCIQAiYiCzI = m('user')->followed($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE);
		$_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI = intval($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['mid']);
		$_obfuscate_DTgrPTcGNikvLxsaCjQ3NQgoPCMpPRE = m('member')->getMid();
		$this->setFooter();
		@session_start();
		if (!$_obfuscate_DRE7NS44KSUKBsmKxIvGCIQAiYiCzI && ($_obfuscate_DTgrPTcGNikvLxsaCjQ3NQgoPCMpPRE != $_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI) && isMobile()) 
		{
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = m('common')->getSysset();
			$this->header = array('url' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['share']['followurl']);
			$_obfuscate_DQQSHAQLGQoBMS1cDi4dGRw9Oz0OIzI = false;
			if (!empty($_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI)) 
			{
				if (!empty($_SESSION[SZ_YI_PREFIX . '_shareid']) && ($_SESSION[SZ_YI_PREFIX . '_shareid'] == $_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI)) 
				{
					$_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI = $_SESSION[SZ_YI_PREFIX . '_shareid'];
				}
				$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = m('member')->getMember($_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI);
				if (!empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI)) 
				{
					$_SESSION[SZ_YI_PREFIX . '_shareid'] = $_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI;
					$_obfuscate_DQQSHAQLGQoBMS1cDi4dGRw9Oz0OIzI = true;
					$this->header['icon'] = $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['avatar'];
					$this->header['text'] = '来自好友 <span>' . $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['nickname'] . '</span> 的推荐';
				}
			}
			if (!$_obfuscate_DQQSHAQLGQoBMS1cDi4dGRw9Oz0OIzI) 
			{
				$this->header['icon'] = tomedia($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['shop']['logo']);
				$this->header['text'] = '欢迎进入 <span>' . $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['shop']['name'] . '</span>';
			}
		}
	}
	public function setFooter() 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
		$_obfuscate_DQsbPDQZCgULMRRALBEdLwNbBzUeJhE = strtolower(trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['p']));
		$_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE = strtolower(trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['method']));
		if (strexists($_obfuscate_DQsbPDQZCgULMRRALBEdLwNbBzUeJhE, 'poster') && ($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE == 'build')) 
		{
			return NULL;
		}
		if (strexists($_obfuscate_DQsbPDQZCgULMRRALBEdLwNbBzUeJhE, 'designer') && (($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE == 'index') || empty($_obfuscate_DRU2IwsvPRAIKwIXJSkZQBQ1ESwJChE)) && ($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['preview'] == 1)) 
		{
			return NULL;
		}
		$_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE = m('user')->getOpenid();
		$_obfuscate_DSIMGigCCwcnAiguCgENMigPLyo5LjI = p('designer');
		if ($_obfuscate_DSIMGigCCwcnAiguCgENMigPLyo5LjI && ($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['p'] != 'designer')) 
		{
			$_obfuscate_DTIaHT4NCA8tIx4VL0AXMi8rKCQTBRE = $_obfuscate_DSIMGigCCwcnAiguCgENMigPLyo5LjI->getDefaultMenu();
			if (!empty($_obfuscate_DTIaHT4NCA8tIx4VL0AXMi8rKCQTBRE)) 
			{
				$this->footer['diymenu'] = true;
				$this->footer['diymenus'] = $_obfuscate_DTIaHT4NCA8tIx4VL0AXMi8rKCQTBRE['menus'];
				$this->footer['diyparams'] = $_obfuscate_DTIaHT4NCA8tIx4VL0AXMi8rKCQTBRE['params'];
				return NULL;
			}
		}
		$_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI = intval($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['mid']);
		$this->footer['first'] = array('text' => '首页', 'ico' => 'home', 'url' => $this->createMobileUrl('shop'));
		$this->footer['second'] = array('text' => '分类', 'ico' => 'list', 'url' => $this->createMobileUrl('shop/category'));
		$this->footer['commission'] = false;
		$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = m('member')->getMember($_obfuscate_DTIPDiIiAiMxEzUsLC8oGh89LjImHQE);
		if (!empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['isblack'])) 
		{
			if ($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['op'] != 'black') 
			{
				header('Location: ' . $this->createMobileUrl('member/login', array('op' => 'black')));
			}
		}
		if (p('commission')) 
		{
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = p('commission')->getSet();
			if (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
			{
				return NULL;
			}
			$_obfuscate_DSUTPBIcFi0fFA8MExUwJiYVHTglMiI = ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['isagent'] == 1) && ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['status'] == 1);
			if ($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['do'] == 'plugin') 
			{
				$this->footer['first'] = array('text' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['closemyshop']) ? $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['shop'] : '首页'), 'ico' => 'home', 'url' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['closemyshop']) ? $this->createPluginMobileUrl('commission/myshop', array('mid' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id'])) : $this->createMobileUrl('shop')));
				if ($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['method'] == '') 
				{
					$this->footer['first']['text'] = (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['closemyshop']) ? $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['myshop'] : '首页');
				}
				if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentblack'])) 
				{
					$this->footer['commission'] = array('text' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['center'], 'ico' => 'sitemap', 'url' => $this->createPluginMobileUrl('commission'));
				}
			}
			else if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['agentblack'])) 
			{
				if (!$_obfuscate_DSUTPBIcFi0fFA8MExUwJiYVHTglMiI) 
				{
					$this->footer['commission'] = array('text' => $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['become'], 'ico' => 'sitemap', 'url' => $this->createPluginMobileUrl('commission/register'));
				}
				else 
				{
					$this->footer['commission'] = array('text' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['closemyshop']) ? $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['shop'] : $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['texts']['center']), 'ico' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['closemyshop']) ? 'heart' : 'sitemap'), 'url' => (empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['closemyshop']) ? $this->createPluginMobileUrl('commission/myshop', array('mid' => $_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['id'])) : $this->createPluginMobileUrl('commission')));
				}
			}
		}
		if (strstr($_SERVER['REQUEST_URI'], 'app')) 
		{
			if (!isMobile()) 
			{
				if ($this->yzShopSet['ispc'] == 0) 
				{
				}
			}
		}
		if (is_weixin()) 
		{
			if (!empty($this->yzShopSet['isbindmobile'])) 
			{
				if (empty($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI) || ($_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI['isbindmobile'] == 0)) 
				{
					if (($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['p'] != 'bindmobile') && ($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['p'] != 'sendcode')) 
					{
						$_obfuscate_DTABFDgsDTMPExdADxg5IjMhNCFABDI = $this->createMobileUrl('member/bindmobile');
						redirect($_obfuscate_DTABFDgsDTMPExdADxg5IjMhNCFABDI);
						exit();
					}
				}
			}
		}
	}
	public function createMobileUrl($do, $query = array(), $noredirect = true) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
		$do = explode('/', $do);
		if (isset($do[1])) 
		{
			$query = array_merge(array('p' => $do[1]), $query);
		}
		if (empty($query['mid'])) 
		{
			$_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI = intval($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['mid']);
			if (!empty($_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI)) 
			{
				$query['mid'] = $_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI;
			}
		}
		return $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['siteroot'] . 'app/' . substr(parent::createMobileUrl($do[0], $query, true), 2);
	}
	public function createWebUrl($do, $query = array()) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$do = explode('/', $do);
		if ((1 < count($do)) && isset($do[1])) 
		{
			$query = array_merge(array('p' => $do[1]), $query);
		}
		return $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['siteroot'] . 'web/' . substr(parent::createWebUrl($do[0], $query, true), 2);
	}
	public function createPluginMobileUrl($do, $query = array()) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
		$do = explode('/', $do);
		$query = array_merge(array('p' => $do[0]), $query);
		$query['m'] = 'sz_yi';
		if (isset($do[1])) 
		{
			$query = array_merge(array('method' => $do[1]), $query);
		}
		if (isset($do[2])) 
		{
			$query = array_merge(array('op' => $do[2]), $query);
		}
		if (empty($query['mid'])) 
		{
			$_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI = intval($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['mid']);
			if (!empty($_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI)) 
			{
				$query['mid'] = $_obfuscate_DS8VBQMYNh8eXDE2GwUOCAs0HlwlMiI;
			}
		}
		return $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['siteroot'] . 'app/' . substr(parent::createMobileUrl('plugin', $query, true), 2);
	}
	public function createPluginWebUrl($do, $query = array()) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$do = explode('/', $do);
		$query = array_merge(array('p' => $do[0]), $query);
		if (isset($do[1])) 
		{
			$query = array_merge(array('method' => $do[1]), $query);
		}
		if (isset($do[2])) 
		{
			$query = array_merge(array('op' => $do[2]), $query);
		}
		return $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['siteroot'] . 'web/' . substr(parent::createWebUrl('plugin', $query, true), 2);
	}
	public function _exec($do, $default = '', $web = true) 
	{
		$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
		$do = strtolower(substr($do, ($web ? 5 : 8)));
		$_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE = trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['p']);
		empty($_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE) && ($_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE = $default);
		if ($web) 
		{
			$_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI = IA_ROOT . '/addons/sz_yi/core/web/' . $do . '/' . $_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE . '.php';
		}
		else 
		{
			$this->setFooter();
			$_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI = IA_ROOT . '/addons/sz_yi/core/mobile/' . $do . '/' . $_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE . '.php';
		}
		if (!is_file($_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI)) 
		{
			message('未找到 控制器文件 ' . $do . '::' . $_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE . ' : ' . $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI);
		}
		include $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI;
		exit();
	}
	public function _execFront($do, $default = '', $web = true) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
		define('IN_SYS', true);
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['templateType'] = 'web';
		$do = strtolower(substr($do, 5));
		$_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE = trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['p']);
		empty($_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE) && ($_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE = $default);
		$_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI = IA_ROOT . '/addons/sz_yi/core/web/' . $do . '/' . $_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE . '.php';
		if (!is_file($_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI)) 
		{
			message('未找到 控制器文件 ' . $do . '::' . $_obfuscate_DQoCKzsfDDxbJhwPEiQBPgUsBDk7GAE . ' : ' . $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI);
		}
		include $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI;
		exit();
	}
	public function template($filename, $type = TEMPLATE_INCLUDEPATH) 
	{
		$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
		if (is_app()) 
		{
			m('cache')->set('app_template_shop', $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['template']);
		}
		$_obfuscate_DT4BMDMYLz4eNQgIDxcOWxEvKD4YHyI = ((isMobile() ? 'mobile' : 'pc'));
		$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = m('common')->getSysset('shop');
		if (strstr($_SERVER['REQUEST_URI'], 'app')) 
		{
			if (!isMobile()) 
			{
				if ($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['ispc'] == 0) 
				{
					$_obfuscate_DT4BMDMYLz4eNQgIDxcOWxEvKD4YHyI = 'mobile';
				}
			}
		}
		$_obfuscate_DSgHCiEeFgMyATJbKSY5JA0xEkAWKDI = strtolower($this->modulename);
		if (defined('IN_SYS')) 
		{
			$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/web/themes/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['template'] . '/' . $_obfuscate_DSgHCiEeFgMyATJbKSY5JA0xEkAWKDI . '/' . $filename . '.html';
			$_obfuscate_DVwpNCUIPQYoQBoCIxYzFCsIAwo9JCI = IA_ROOT . '/data/tpl/web/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['template'] . '/' . $_obfuscate_DSgHCiEeFgMyATJbKSY5JA0xEkAWKDI . '/' . $filename . '.tpl.php';
			if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
			{
				$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/web/themes/default/' . $_obfuscate_DSgHCiEeFgMyATJbKSY5JA0xEkAWKDI . '/' . $filename . '.html';
			}
			if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
			{
				$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/addons/' . $_obfuscate_DSgHCiEeFgMyATJbKSY5JA0xEkAWKDI . '/template/' . $filename . '.html';
			}
			if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
			{
				$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/web/themes/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['template'] . '/' . $filename . '.html';
			}
			if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
			{
				$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/web/themes/default/' . $filename . '.html';
			}
			if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
			{
				$_obfuscate_DR82DzYOCicMP1wVNSI0IgkrLzcbKxE = explode('/', $filename);
				$_obfuscate_DRImBysPGVskGD4tDAk0GhMNSMNXBE = array_slice($_obfuscate_DR82DzYOCicMP1wVNSI0IgkrLzcbKxE, 1);
				$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/addons/' . $_obfuscate_DSgHCiEeFgMyATJbKSY5JA0xEkAWKDI . '/plugin/' . $_obfuscate_DR82DzYOCicMP1wVNSI0IgkrLzcbKxE[0] . '/template/' . implode('/', $_obfuscate_DRImBysPGVskGD4tDAk0GhMNSMNXBE) . '.html';
			}
		}
		else 
		{
			if (is_app()) 
			{
				$_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE = m('cache')->getString('app_template_shop');
			}
			else if (!isMobile() && $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['ispc']) 
			{
				$_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE = m('cache')->getString('template_shop_pc');
			}
			else 
			{
				$_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE = m('cache')->getString('template_shop');
			}
			if (empty($_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE)) 
			{
				$_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE = 'default';
			}
			if (!is_dir(IA_ROOT . '/addons/sz_yi/template/' . $_obfuscate_DT4BMDMYLz4eNQgIDxcOWxEvKD4YHyI . '/' . $_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE)) 
			{
				$_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE = 'default';
			}
			$_obfuscate_DVwpNCUIPQYoQBoCIxYzFCsIAwo9JCI = IA_ROOT . '/data/tpl/app/sz_yi/' . $_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE . '/' . $_obfuscate_DT4BMDMYLz4eNQgIDxcOWxEvKD4YHyI . '/' . $filename . '.tpl.php';
			$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/addons/' . $_obfuscate_DSgHCiEeFgMyATJbKSY5JA0xEkAWKDI . '/template/' . $_obfuscate_DT4BMDMYLz4eNQgIDxcOWxEvKD4YHyI . '/' . $_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE . '/' . $filename . '.html';
			if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
			{
				$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/addons/' . $_obfuscate_DSgHCiEeFgMyATJbKSY5JA0xEkAWKDI . '/template/' . $_obfuscate_DT4BMDMYLz4eNQgIDxcOWxEvKD4YHyI . '/default/' . $filename . '.html';
			}
			if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
			{
				$_obfuscate_DRcuDAQ_HCU2ASk8LQ8mGBQkNgIVBRE = explode('/', $filename);
				$_obfuscate_DQw7JigQGgMGODkaCh4LKjwIXBIiKDI = $_obfuscate_DRcuDAQ_HCU2ASk8LQ8mGBQkNgIVBRE[0];
				if ($_obfuscate_DQw7JigQGgMGODkaCh4LKjwIXBIiKDI == 'designer') 
				{
					$_obfuscate_DQIiAS0vDQ1bBBYqAygXAhUWODsdCwE = $_obfuscate_DSEQJyEpB0AVLjM2MxQLLzkOFhJAGQE;
				}
				else 
				{
					$_obfuscate_DQIiAS0vDQ1bBBYqAygXAhUWODsdCwE = m('cache')->getString('template_' . $_obfuscate_DQw7JigQGgMGODkaCh4LKjwIXBIiKDI);
				}
				if (empty($_obfuscate_DQIiAS0vDQ1bBBYqAygXAhUWODsdCwE)) 
				{
					$_obfuscate_DQIiAS0vDQ1bBBYqAygXAhUWODsdCwE = 'default';
				}
				if (!is_dir(IA_ROOT . '/addons/sz_yi/plugin/' . $_obfuscate_DQw7JigQGgMGODkaCh4LKjwIXBIiKDI . '/template/' . $_obfuscate_DT4BMDMYLz4eNQgIDxcOWxEvKD4YHyI . '/' . $_obfuscate_DQIiAS0vDQ1bBBYqAygXAhUWODsdCwE)) 
				{
					$_obfuscate_DQIiAS0vDQ1bBBYqAygXAhUWODsdCwE = 'default';
				}
				$_obfuscate_DTAmOzQmGwsbPhoaGSs_KjASIR8QNBE = $_obfuscate_DRcuDAQ_HCU2ASk8LQ8mGBQkNgIVBRE[1];
				$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/addons/sz_yi/plugin/' . $_obfuscate_DQw7JigQGgMGODkaCh4LKjwIXBIiKDI . '/template/' . $_obfuscate_DT4BMDMYLz4eNQgIDxcOWxEvKD4YHyI . '/' . $_obfuscate_DQIiAS0vDQ1bBBYqAygXAhUWODsdCwE . '/' . $_obfuscate_DTAmOzQmGwsbPhoaGSs_KjASIR8QNBE . '.html';
			}
			if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
			{
				$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/app/themes/' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['template'] . '/' . $filename . '.html';
			}
			if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
			{
				$_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE = IA_ROOT . '/app/themes/default/' . $filename . '.html';
			}
		}
		if (!is_file($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE)) 
		{
			exit('Error: template source \'' . $filename . '\' is not exist!');
		}
		if (DEVELOPMENT || !is_file($_obfuscate_DVwpNCUIPQYoQBoCIxYzFCsIAwo9JCI) || (filemtime($_obfuscate_DVwpNCUIPQYoQBoCIxYzFCsIAwo9JCI) < filemtime($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE))) 
		{
			shop_template_compile($_obfuscate_DRMyGzMXPzQjJz4BNBwoIx0qNgUpDRE, $_obfuscate_DVwpNCUIPQYoQBoCIxYzFCsIAwo9JCI, true);
		}
		return $_obfuscate_DVwpNCUIPQYoQBoCIxYzFCsIAwo9JCI;
	}
	public function getUrl() 
	{
		if (p('commission')) 
		{
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = p('commission')->getSet();
			if (!empty($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['level'])) 
			{
				return $this->createPluginMobileUrl('commission/myshop');
			}
		}
		return $this->createMobileUrl('shop');
	}
}
?>