<?php
/**

 *源码来自易福源码网 www.efwww.com 其他网址下载均为盗用本站
 *淘宝唯一店铺：https://shop33554379.taobao.com

 */
global $_W;
global $_GPC;
$cond = '';
if (p('supplier')) 
{
	$perm_role = p('supplier')->verifyUserIsSupplier($_W['uid']);
	if ($perm_role != 0) 
	{
		$cond = ' and identity in (\'exhelper\',\'taobao\') ';
	}
}
$operation = ((!empty($_GPC['op']) ? $_GPC['op'] : 'display'));
$category = m('plugin')->getCategory();
foreach ($category as $ck => &$cv ) 
{
	$cv['plugins'] = pdo_fetchall('select * from ' . tablename('sz_yi_plugin') . ' where category=:category ' . $cond . ' order by displayorder asc', array(':category' => $ck));
}
unset($cv);
include $this->template('web/plugins/list');
exit();
?>