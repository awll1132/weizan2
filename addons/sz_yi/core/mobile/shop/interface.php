<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
global $_W;
global $_GPC;
$operation = ((!empty($_GPC['op']) ? $_GPC['op'] : 'index'));
if ($operation == 'result') 
{
	$url = array('success' => $this->createMobileUrl('shop/message', array('op' => 'success')), 'fail' => $this->createMobileUrl('shop/message', array('op' => 'fail')));
	echo json_encode($url);
	return 1;
}
if ($operation == 'adv') 
{
	$banner = pdo_fetchall('SELECT * FROM ' . tablename('sz_yi_banner') . '  ORDER BY `id` DESC');
	$adv_img = array('android_src' => 'http://' . $_SERVER['HTTP_HOST'] . '/attachment/' . $banner[0]['thumb'], 'ios_src' => 'http://' . $_SERVER['HTTP_HOST'] . '/attachment/' . $banner[0]['thumb']);
	echo json_encode($adv_img);
}
?>