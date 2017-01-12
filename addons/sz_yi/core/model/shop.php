<?php
/**

 *源码来自易福源码网 www.efwww.com 其他网址下载均为盗用本站
 *淘宝唯一店铺：https://shop33554379.taobao.com

 */
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Sz_DYi_Shop 
{
	public function getCategory() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DTEEMhIOC1sXHhMyFTAFNhgyPgI7HgE = m('common')->getSysset('shop');
		$_obfuscate_DS0PFhoTHgU3KxYzKDMhIRYpPhAkIhE = array();
		$_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE = pdo_fetchall('SELECT * FROM ' . tablename('sz_yi_category') . ' WHERE uniacid=:uniacid and enabled=1 ORDER BY parentid ASC, displayorder DESC', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
		$_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE = set_medias($_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE, array('thumb', 'advimg'));
		foreach ($_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE as $_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI ) 
		{
			if (empty($_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI['parentid'])) 
			{
				$_obfuscate_DTMNMw4dPxcELwExCDccMCQ7MhIYPBE = array();
				foreach ($_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE as $_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI ) 
				{
					if ($_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI['parentid'] == $_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI['id']) 
					{
						if (intval($_obfuscate_DTEEMhIOC1sXHhMyFTAFNhgyPgI7HgE['catlevel']) == 3) 
						{
							$_obfuscate_DQEuKhQSFQcqLjVbGjYqCh08KVwiPjI = array();
							foreach ($_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE as $_obfuscate_DRkmBhIaPCsyW0AnJxECHhYRIUAjDDI ) 
							{
								if ($_obfuscate_DRkmBhIaPCsyW0AnJxECHhYRIUAjDDI['parentid'] == $_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI['id']) 
								{
									$_obfuscate_DQEuKhQSFQcqLjVbGjYqCh08KVwiPjI[] = $_obfuscate_DRkmBhIaPCsyW0AnJxECHhYRIUAjDDI;
								}
							}
							$_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI['children'] = $_obfuscate_DQEuKhQSFQcqLjVbGjYqCh08KVwiPjI;
						}
						$_obfuscate_DTMNMw4dPxcELwExCDccMCQ7MhIYPBE[] = $_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI;
					}
				}
				$_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI['children'] = $_obfuscate_DTMNMw4dPxcELwExCDccMCQ7MhIYPBE;
				$_obfuscate_DS0PFhoTHgU3KxYzKDMhIRYpPhAkIhE[] = $_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI;
			}
		}
		return $_obfuscate_DS0PFhoTHgU3KxYzKDMhIRYpPhAkIhE;
	}
	public function getCategory2() 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DTEEMhIOC1sXHhMyFTAFNhgyPgI7HgE = m('common')->getSysset('shop');
		$_obfuscate_DS0PFhoTHgU3KxYzKDMhIRYpPhAkIhE = array();
		$_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE = pdo_fetchall('SELECT * FROM ' . tablename('sz_yi_category2') . ' WHERE uniacid=:uniacid and enabled=1 ORDER BY parentid ASC, displayorder DESC', array(':uniacid' => $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid']));
		$_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE = set_medias($_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE, array('thumb', 'advimg'));
		foreach ($_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE as $_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI ) 
		{
			if (empty($_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI['parentid'])) 
			{
				$_obfuscate_DTMNMw4dPxcELwExCDccMCQ7MhIYPBE = array();
				foreach ($_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE as $_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI ) 
				{
					if ($_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI['parentid'] == $_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI['id']) 
					{
						if (intval($_obfuscate_DTEEMhIOC1sXHhMyFTAFNhgyPgI7HgE['catlevel']) == 3) 
						{
							$_obfuscate_DQEuKhQSFQcqLjVbGjYqCh08KVwiPjI = array();
							foreach ($_obfuscate_DQsrIj4DECkdATc0GUA7MSMxGxYYFBE as $_obfuscate_DRkmBhIaPCsyW0AnJxECHhYRIUAjDDI ) 
							{
								if ($_obfuscate_DRkmBhIaPCsyW0AnJxECHhYRIUAjDDI['parentid'] == $_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI['id']) 
								{
									$_obfuscate_DQEuKhQSFQcqLjVbGjYqCh08KVwiPjI[] = $_obfuscate_DRkmBhIaPCsyW0AnJxECHhYRIUAjDDI;
								}
							}
							$_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI['children'] = $_obfuscate_DQEuKhQSFQcqLjVbGjYqCh08KVwiPjI;
						}
						$_obfuscate_DTMNMw4dPxcELwExCDccMCQ7MhIYPBE[] = $_obfuscate_DQxbBBIYGCIoCzA5CAhAWzM0QC8xJzI;
					}
				}
				$_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI['children'] = $_obfuscate_DTMNMw4dPxcELwExCDccMCQ7MhIYPBE;
				$_obfuscate_DS0PFhoTHgU3KxYzKDMhIRYpPhAkIhE[] = $_obfuscate_DTcpCBw1Az0MFQ41BQ87Ag8VJBsOECI;
			}
		}
		return $_obfuscate_DS0PFhoTHgU3KxYzKDMhIRYpPhAkIhE;
	}
}
?>