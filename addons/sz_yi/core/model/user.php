<?php
/**

 *源码来自易福源码网 www.efwww.com 其他网址下载均为盗用本站
 *淘宝唯一店铺：https://shop33554379.taobao.com

 */
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Sz_DYi_User 
{
	private $sessionid;
	public function __construct() 
	{
		global $_W;
		$this->sessionid = '__cookie_sz_yi_201507200000_' . $_W['uniacid'];
	}
	public function getOpenid() 
	{
		$_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI = $this->getInfo(false, true);
		return $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['openid'];
	}
	public function getPerOpenid() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
		$_obfuscate_DRQ3DR0_Pig5JzcfNAQmDysaGgMRPRE = 24 * 3600 * 3;
		session_set_cookie_params($_obfuscate_DRQ3DR0_Pig5JzcfNAQmDysaGgMRPRE);
		@session_start();
		$_obfuscate_DRsnXD4IBh02KRUZJT9cNgIxNjYETI = '__cookie_sz_yi_openid_' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'];
		$_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE = base64_decode($_COOKIE[$_obfuscate_DRsnXD4IBh02KRUZJT9cNgIxNjYETI]);
		if (!empty($_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE)) 
		{
			return $_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE;
		}
		load()->func('communication');
		$_obfuscate_DRALFytbCzUxDyI4Jw8qGBkVLj4BGSI = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['account']['key'];
		$_obfuscate_DTw4HiwoDhYmHA0LxQxKDdcFCwCAzI = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['account']['secret'];
		$_obfuscate_DRUZKCoKAScZHRUxHhA7KzcYNxo0KiI = '';
		$_obfuscate_DSsoLQsdOywXGi4yFSgdGg8aLjdbJxE = $_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['code'];
		$_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteroot'] . 'app/index.php?' . $_SERVER['QUERY_STRING'];
		if (empty($_obfuscate_DSsoLQsdOywXGi4yFSgdGg8aLjdbJxE)) 
		{
			$_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $_obfuscate_DRALFytbCzUxDyI4Jw8qGBkVLj4BGSI . '&redirect_uri=' . urlencode($_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE) . '&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
			header('location: ' . $_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI);
			exit();
		}
		else 
		{
			$_obfuscate_DQEYBw4zBy0zFyoaKB4oXBoIMhgoAwE = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $_obfuscate_DRALFytbCzUxDyI4Jw8qGBkVLj4BGSI . '&secret=' . $_obfuscate_DTw4HiwoDhYmHA0LxQxKDdcFCwCAzI . '&code=' . $_obfuscate_DSsoLQsdOywXGi4yFSgdGg8aLjdbJxE . '&grant_type=authorization_code';
			$_obfuscate_DR0ECztcGwU5MCU9GgM0HxAfDAMQFjI = ihttp_get($_obfuscate_DQEYBw4zBy0zFyoaKB4oXBoIMhgoAwE);
			$_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE = @json_decode($_obfuscate_DR0ECztcGwU5MCU9GgM0HxAfDAMQFjI['content'], true);
			if (!empty($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE) && is_array($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE) && ($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE['errmsg'] == 'invalid code')) 
			{
				$_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $_obfuscate_DRALFytbCzUxDyI4Jw8qGBkVLj4BGSI . '&redirect_uri=' . urlencode($_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE) . '&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
				header('location: ' . $_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI);
				exit();
			}
			if (is_array($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE) && !empty($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE['openid'])) 
			{
				$_obfuscate_DRUZKCoKAScZHRUxHhA7KzcYNxo0KiI = $_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE['access_token'];
				$_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE = $_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE['openid'];
				setcookie($_obfuscate_DRsnXD4IBh02KRUZJT9cNgIxNjYETI, base64_encode($_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE));
			}
			else 
			{
				$_obfuscate_DRcILykoJykaETk7KREZLj4JAjQqAgE = explode('&', $_SERVER['QUERY_STRING']);
				$_obfuscate_DRkFGBU2GAoXDSUJOxFcWxYBGB8NGAE = array();
				foreach ($_obfuscate_DRcILykoJykaETk7KREZLj4JAjQqAgE as $_obfuscate_DQ4SLgUUXDMRAw8xMCUVHCc0LAYsKBE ) 
				{
					if (!strexists($_obfuscate_DQ4SLgUUXDMRAw8xMCUVHCc0LAYsKBE, 'code=') && !strexists($_obfuscate_DQ4SLgUUXDMRAw8xMCUVHCc0LAYsKBE, 'state=') && !strexists($_obfuscate_DQ4SLgUUXDMRAw8xMCUVHCc0LAYsKBE, 'from=') && !strexists($_obfuscate_DQ4SLgUUXDMRAw8xMCUVHCc0LAYsKBE, 'isappinstalled=')) 
					{
						$_obfuscate_DRkFGBU2GAoXDSUJOxFcWxYBGB8NGAE[] = $_obfuscate_DQ4SLgUUXDMRAw8xMCUVHCc0LAYsKBE;
					}
				}
				$_obfuscate_DQ4ZNyYMHBIpJQYaDioFJxMwNiwOHCI = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteroot'] . 'app/index.php?' . implode('&', $_obfuscate_DRkFGBU2GAoXDSUJOxFcWxYBGB8NGAE);
				$_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $_obfuscate_DRALFytbCzUxDyI4Jw8qGBkVLj4BGSI . '&redirect_uri=' . urlencode($_obfuscate_DQ4ZNyYMHBIpJQYaDioFJxMwNiwOHCI) . '&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
				header('location: ' . $_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI);
				exit();
			}
		}
		return $_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE;
	}
	public function isLogin() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
		@session_start();
		$_obfuscate_DRsnXD4IBh02KRUZJT9cNgIxNjYETI = '__cookie_sz_yi_userid_' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'];
		$_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE = base64_decode($_COOKIE[$_obfuscate_DRsnXD4IBh02KRUZJT9cNgIxNjYETI]);
		if (empty($_SERVER['HTTP_USER_AGENT']) && empty($_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE) && $_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['token']) 
		{
			$_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE = $_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['token'];
		}
		if (!empty($_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE)) 
		{
			return $_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE;
		}
		return false;
	}
	public function getUserInfo() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
		if (($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'] == 'return') && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['method'] == 'task')) 
		{
			return NULL;
		}
		if (($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'] == 'ranking') && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['method'] == 'commission')) 
		{
			return NULL;
		}
		$_obfuscate_DRkyITk8NCkKIzgiBwIsBScVGA8SODI = array('address', 'commission', 'cart');
		$_obfuscate_DR8bODMsFREYGChAKTMPFkAIMjhcGwE = array('category', 'login', 'receive', 'close', 'designer', 'register', 'sendcode', 'bindmobile', 'forget');
		$_obfuscate_DQ4BKRk2Ly0qFzADKi0RJxM8KQskJSI = array('shop', 'login', 'register');
		if (!$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'] && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['do'] == 'shop')) 
		{
			return NULL;
		}
		if ((!in_array($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'], $_obfuscate_DR8bODMsFREYGChAKTMPFkAIMjhcGwE) && !in_array($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['do'], $_obfuscate_DQ4BKRk2Ly0qFzADKi0RJxM8KQskJSI)) || in_array($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'], $_obfuscate_DRkyITk8NCkKIzgiBwIsBScVGA8SODI)) 
		{
			if (($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['method'] != 'myshop') || ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['c'] != 'entry')) 
			{
				$_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE = $this->isLogin();
				if (!$_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'] != 'cart')) 
				{
					if ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['do'] != 'runtasks') 
					{
						setcookie('preUrl', $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteurl']);
					}
					$_obfuscate_DTMRHS0rDQMGFRcJNRUkLB4KIgE3LhE = (($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['mid'] ? '&mid=' . $_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['mid'] : ''));
					$_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE = '/app/index.php?i=' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '&c=entry&p=login&do=member&m=sz_yi' . $_obfuscate_DTMRHS0rDQMGFRcJNRUkLB4KIgE3LhE;
					redirect($_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE);
					return NULL;
				}
				$_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI = array('openid' => $_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE, 'headimgurl' => '');
				return $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI;
			}
		}
	}
	public function getInfo($base64 = false, $debug = false) 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
		if (!is_weixin()) 
		{
			return $this->getUserInfo();
		}
		$_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI = array();
		if (SZ_YI_DEBUG) 
		{
			$_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI = array('openid' => 'oVwSVuJXB7lGGc93d0gBXQ_h-czc', 'nickname' => '小萝莉', 'headimgurl' => '', 'province' => '香港', 'city' => '九龙');
		}
		else 
		{
			load()->model('mc');
			if (empty($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['directopenid'])) 
			{
				$_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI = mc_oauth_userinfo();
			}
			else 
			{
				$_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI = array('openid' => $this->getPerOpenid());
			}
			$_obfuscate_DRYRGVszDAgsKQIVPTs7DC8TQBYZMCI = false;
			if ($_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['container'] != 'wechat') 
			{
				if (($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['do'] == 'order') && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'] == 'pay')) 
				{
					$_obfuscate_DRYRGVszDAgsKQIVPTs7DC8TQBYZMCI = false;
				}
				if (($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['do'] == 'member') && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'] == 'recharge')) 
				{
					$_obfuscate_DRYRGVszDAgsKQIVPTs7DC8TQBYZMCI = false;
				}
				if (($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['do'] == 'plugin') && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'] == 'article') && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['preview'] == '1')) 
				{
					$_obfuscate_DRYRGVszDAgsKQIVPTs7DC8TQBYZMCI = false;
				}
			}
		}
		if ($base64) 
		{
			return urlencode(base64_encode(json_encode($_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI)));
		}
		return $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI;
	}
	public function oauth_info() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
		if ($_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['container'] != 'wechat') 
		{
			if (($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['do'] == 'order') && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'] == 'pay')) 
			{
				return array();
			}
			if (($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['do'] == 'member') && ($_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['p'] == 'recharge')) 
			{
				return array();
			}
		}
		$_obfuscate_DRQ3DR0_Pig5JzcfNAQmDysaGgMRPRE = 24 * 3600 * 3;
		session_set_cookie_params($_obfuscate_DRQ3DR0_Pig5JzcfNAQmDysaGgMRPRE);
		@session_start();
		$_obfuscate_DSUaFCQlISwOAxwCHBAtEAEhNgIMHSI = '__cookie_sz_yi_201507100000_' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'];
		$_obfuscate_DVsQHx4FFAg_DSUXFR9ACFwwXAUlIQE = json_decode(base64_decode($_SESSION[$_obfuscate_DSUaFCQlISwOAxwCHBAtEAEhNgIMHSI]), true);
		$_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE = ((is_array($_obfuscate_DVsQHx4FFAg_DSUXFR9ACFwwXAUlIQE) ? $_obfuscate_DVsQHx4FFAg_DSUXFR9ACFwwXAUlIQE['openid'] : ''));
		$_obfuscate_DQklDjsIPCEcFSMOERwtBTQfGBoWNRE = ((is_array($_obfuscate_DVsQHx4FFAg_DSUXFR9ACFwwXAUlIQE) ? $_obfuscate_DVsQHx4FFAg_DSUXFR9ACFwwXAUlIQE['openid'] : ''));
		if (!empty($_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE)) 
		{
			return $_obfuscate_DVsQHx4FFAg_DSUXFR9ACFwwXAUlIQE;
		}
		load()->func('communication');
		$_obfuscate_DRALFytbCzUxDyI4Jw8qGBkVLj4BGSI = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['account']['key'];
		$_obfuscate_DTw4HiwoDhYmHA0LxQxKDdcFCwCAzI = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['account']['secret'];
		$_obfuscate_DRUZKCoKAScZHRUxHhA7KzcYNxo0KiI = '';
		$_obfuscate_DSsoLQsdOywXGi4yFSgdGg8aLjdbJxE = $_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE['code'];
		$_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteroot'] . 'app/index.php?' . $_SERVER['QUERY_STRING'];
		if (empty($_obfuscate_DSsoLQsdOywXGi4yFSgdGg8aLjdbJxE)) 
		{
			$_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $_obfuscate_DRALFytbCzUxDyI4Jw8qGBkVLj4BGSI . '&redirect_uri=' . urlencode($_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE) . '&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
			header('location: ' . $_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI);
			exit();
		}
		else 
		{
			$_obfuscate_DQEYBw4zBy0zFyoaKB4oXBoIMhgoAwE = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $_obfuscate_DRALFytbCzUxDyI4Jw8qGBkVLj4BGSI . '&secret=' . $_obfuscate_DTw4HiwoDhYmHA0LxQxKDdcFCwCAzI . '&code=' . $_obfuscate_DSsoLQsdOywXGi4yFSgdGg8aLjdbJxE . '&grant_type=authorization_code';
			$_obfuscate_DR0ECztcGwU5MCU9GgM0HxAfDAMQFjI = ihttp_get($_obfuscate_DQEYBw4zBy0zFyoaKB4oXBoIMhgoAwE);
			$_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE = @json_decode($_obfuscate_DR0ECztcGwU5MCU9GgM0HxAfDAMQFjI['content'], true);
			if (!empty($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE) && is_array($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE) && ($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE['errmsg'] == 'invalid code')) 
			{
				$_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $_obfuscate_DRALFytbCzUxDyI4Jw8qGBkVLj4BGSI . '&redirect_uri=' . urlencode($_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE) . '&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
				header('location: ' . $_obfuscate_DQkwDDQzNhAQJDckKBgzAwY3NDceMTI);
				exit();
			}
			if (empty($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE) || !is_array($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE) || empty($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE['access_token']) || empty($_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE['openid'])) 
			{
				exit('获取token失败,请重新进入!');
			}
			else 
			{
				$_obfuscate_DRUZKCoKAScZHRUxHhA7KzcYNxo0KiI = $_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE['access_token'];
				$_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE = $_obfuscate_DT0jXA08BiM0NxAbCFwHXA4ZDBAXOxE['openid'];
			}
		}
		$_obfuscate_DSoUJyUVHgIECQoLPC8nCBI4FCMLKiI = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $_obfuscate_DRUZKCoKAScZHRUxHhA7KzcYNxo0KiI . '&openid=' . $_obfuscate_DS0aEy0uHTsQKFs0NiUBHxsTNgdbNhE . '&lang=zh_CN';
		$_obfuscate_DR0ECztcGwU5MCU9GgM0HxAfDAMQFjI = ihttp_get($_obfuscate_DSoUJyUVHgIECQoLPC8nCBI4FCMLKiI);
		$_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI = @json_decode($_obfuscate_DR0ECztcGwU5MCU9GgM0HxAfDAMQFjI['content'], true);
		if (isset($_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI['nickname'])) 
		{
			$_SESSION[$_obfuscate_DSUaFCQlISwOAxwCHBAtEAEhNgIMHSI] = base64_encode(json_encode($_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI));
			return $_obfuscate_DSM3ATMFPgQ0ESMiLh07MTwyBCIsITI;
		}
		exit('获取用户信息失败，请重新进入!');
	}
	public function followed($openid = '') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMSOTIOQklKwQyIysMChofExcFNzI = !empty($openid);
		if ($_obfuscate_DRMSOTIOQklKwQyIysMChofExcFNzI) 
		{
			$_obfuscate_DREWLRA5H0BABRg3LTweGSoHDiURMhE = pdo_fetch('select follow from ' . tablename('mc_mapping_fans') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $openid, ':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
			$_obfuscate_DRMSOTIOQklKwQyIysMChofExcFNzI = $_obfuscate_DREWLRA5H0BABRg3LTweGSoHDiURMhE['follow'] == 1;
		}
		return $_obfuscate_DRMSOTIOQklKwQyIysMChofExcFNzI;
	}
}
?>