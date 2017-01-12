<?php
/**

 *源码来自易福源码网 www.efwww.com 其他网址下载均为盗用本站
 *淘宝唯一店铺：https://shop33554379.taobao.com

 */
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Sz_DYi_Cache 
{
	public function get_key($key = '', $uniacid = '') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		if (empty($uniacid)) 
		{
			$uniacid = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'];
		}
		return SZ_YI_PREFIX . '_' . $GLOBALS['_W']['config']['setting']['authkey'] . '_' . $uniacid . '_' . $key;
	}
	public function getArray($key = '', $uniacid = '') 
	{
		return $this->get($key, true, $uniacid);
	}
	public function getString($key = '', $uniacid = '') 
	{
		return $this->get($key, false, $uniacid);
	}
	public function get($key = '', $isArray = true, $uniacid = '') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		if (empty($key)) 
		{
			return false;
		}
		if (empty($uniacid)) 
		{
			$uniacid = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'];
		}
		$_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE = false;
		if ($_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['config']['setting']['cache'] == 'memcache') 
		{
			if (extension_loaded('memcache')) 
			{
				$_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE = $this->memcache_read($key, $uniacid);
			}
		}
		if (empty($_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE)) 
		{
			return $this->file_read($key, $isArray, $uniacid);
		}
		return $_obfuscate_DTUUKz8tBCwZDx00GgUqLxIdHB80GQE;
	}
	public function set($key = '', $value = NULL, $uniacid = '') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		if (empty($key)) 
		{
			return false;
		}
		if (empty($uniacid)) 
		{
			$uniacid = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'];
		}
		$_obfuscate_DQopMkAtMisRFyEXBjc4EjsuDSUBIgE = false;
		if ($_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['config']['setting']['cache'] == 'memcache') 
		{
			if (extension_loaded('memcache')) 
			{
				$_obfuscate_DQopMkAtMisRFyEXBjc4EjsuDSUBIgE = $this->memcache_write($key, $value, $uniacid);
			}
		}
		if (empty($_obfuscate_DQopMkAtMisRFyEXBjc4EjsuDSUBIgE)) 
		{
			$this->file_set($key, $value, $uniacid);
		}
	}
	public function file_read($key = '', $isArray = true, $uniacid = '') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		if (empty($key)) 
		{
			return false;
		}
		$_obfuscate_DTY2FTY1NR0PO1saWy0PJykSLj8KPCI = @file_get_contents(IA_ROOT . '/addons/sz_yi/data/cache/' . $uniacid . '/' . $key);
		if (empty($_obfuscate_DTY2FTY1NR0PO1saWy0PJykSLj8KPCI)) 
		{
			return false;
		}
		return ($isArray ? iunserializer($_obfuscate_DTY2FTY1NR0PO1saWy0PJykSLj8KPCI) : $_obfuscate_DTY2FTY1NR0PO1saWy0PJykSLj8KPCI);
	}
	public function file_set($key = '', $value = NULL, $uniacid = '') 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		if (empty($key)) 
		{
			return false;
		}
		$_obfuscate_DTY2FTY1NR0PO1saWy0PJykSLj8KPCI = ((is_array($value) ? iserializer($value) : $value));
		$_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI = IA_ROOT . '/addons/sz_yi/data/cache/' . $uniacid;
		if (!is_dir($_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI)) 
		{
			load()->func('file');
			@mkdirs($_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI);
		}
		file_put_contents($_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI . '/' . $key, $_obfuscate_DTY2FTY1NR0PO1saWy0PJykSLj8KPCI);
	}
	public function get_memcache() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		static $memcacheobj;
		if (!extension_loaded('memcache')) 
		{
			return error(1, 'Class Memcache is not found');
		}
		if (empty($_obfuscate_DQ8XDgo5BxwkBhwRIScQMRsQKwoaKCI)) 
		{
			$_obfuscate_DSQrEhQbGjMIJxcxLgQBJRIbIjUsDTI = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['config']['setting']['memcache'];
			$_obfuscate_DQ8XDgo5BxwkBhwRIScQMRsQKwoaKCI = new Memcache();
			if ($_obfuscate_DSQrEhQbGjMIJxcxLgQBJRIbIjUsDTI['pconnect']) 
			{
				$_obfuscate_DRoJBQIoIjI4PRsbOyoxDiY5CwEQHDI = $_obfuscate_DQ8XDgo5BxwkBhwRIScQMRsQKwoaKCI->pconnect($_obfuscate_DSQrEhQbGjMIJxcxLgQBJRIbIjUsDTI['server'], $_obfuscate_DSQrEhQbGjMIJxcxLgQBJRIbIjUsDTI['port']);
			}
			else 
			{
				$_obfuscate_DRoJBQIoIjI4PRsbOyoxDiY5CwEQHDI = $_obfuscate_DQ8XDgo5BxwkBhwRIScQMRsQKwoaKCI->connect($_obfuscate_DSQrEhQbGjMIJxcxLgQBJRIbIjUsDTI['server'], $_obfuscate_DSQrEhQbGjMIJxcxLgQBJRIbIjUsDTI['port']);
			}
			if (!$_obfuscate_DRoJBQIoIjI4PRsbOyoxDiY5CwEQHDI) 
			{
				return error(-1, 'Memcache is not in work');
			}
		}
		return $_obfuscate_DQ8XDgo5BxwkBhwRIScQMRsQKwoaKCI;
	}
	public function memcache_read($key, $uniacid) 
	{
		$_obfuscate_DRMUPTkpFBchKyUHCycvFT0uEyUDDBE = $this->get_memcache();
		if (is_error($_obfuscate_DRMUPTkpFBchKyUHCycvFT0uEyUDDBE)) 
		{
			return false;
		}
		return $_obfuscate_DRMUPTkpFBchKyUHCycvFT0uEyUDDBE->get($this->get_key($key, $uniacid));
	}
	public function memcache_write($key, $value, $uniacid = 0, $ttl = 0) 
	{
		$_obfuscate_DRMUPTkpFBchKyUHCycvFT0uEyUDDBE = $this->get_memcache();
		if (is_error($_obfuscate_DRMUPTkpFBchKyUHCycvFT0uEyUDDBE)) 
		{
			return false;
		}
		return $_obfuscate_DRMUPTkpFBchKyUHCycvFT0uEyUDDBE->set($this->get_key($key, $uniacid), $value, MEMCACHE_COMPRESSED, $ttl);
	}
	public function memcache_delete($key, $uniacid = 0) 
	{
		$_obfuscate_DRMUPTkpFBchKyUHCycvFT0uEyUDDBE = $this->get_memcache();
		if (is_error($_obfuscate_DRMUPTkpFBchKyUHCycvFT0uEyUDDBE)) 
		{
			return false;
		}
		return $_obfuscate_DRMUPTkpFBchKyUHCycvFT0uEyUDDBE->delete($this->get_key($key, $uniacid));
	}
}
?>