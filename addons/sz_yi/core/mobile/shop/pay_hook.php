<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
global $_W;
global $_GPC;
$uniacid = $_W['uniacid'];
require_once '../addons/sz_yi/plugin/pingpp/init.php';
$input_data = json_decode(file_get_contents('php://input'), true);
do 
{
	if (!isset($input_data['id'])) 
	{
		$res['status'] = 500;
		$res['msg'] = 'Internal Server Error';
		echo '事件ID为空';
		break;
	}
	$pay_info = $input_data['data']['object'];
	if ($pay_info['paid'] == 1) 
	{
		$order_data['pay_time'] = $pay_info['time_paid'];
		$order_data['pay_id'] = $pay_info['id'];
		$order_data['order_id'] = $pay_info['order_no'];
		$order_info = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_order') . ' WHERE uniacid=:uniacid AND ordersn=:ordersn', array('uniacid' => $uniacid, 'ordersn' => $pay_info['order_no']));
		if ($order_info['status'] != 0) 
		{
			$res['status'] = 500;
			$res['msg'] = 'Internal Server Error';
			echo '支付状态不正确';
			break;
		}
		if (!pdo_update('sz_yi_order', array('status' => 1), array('ordersn' => $pay_info['order_no']))) 
		{
			echo '订单状态改变失败';
			$res['status'] = 500;
			$res['msg'] = 'Internal Server Error';
			break;
		}
		echo '成功';
		$res['status'] = 200;
		$res['msg'] = 'ok';
	}
}
while (0);
header('HTTP/1.1 ' . $res['status'] . ' ' . $res['msg']);
?>