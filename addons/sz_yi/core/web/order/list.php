<?php
global $_W;
global $_GPC;
$operation = ((!empty($_GPC['op']) ? $_GPC['op'] : 'display'));
$plugin_diyform = p('diyform');
$totals = array();
$r_type = array('退款', '退货退款', '换货');
if ($operation == 'display') 
{
	ca('order.view.status_1|order.view.status0|order.view.status1|order.view.status2|order.view.status3|order.view.status4|order.view.status5');
	if (p('supplier')) 
	{
		$perm_role = p('supplier')->verifyUserIsSupplier($_W['uid']);
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$status = $_GPC['status'];
	$sendtype = ((!isset($_GPC['sendtype']) ? 0 : $_GPC['sendtype']));
	$condition = ' o.uniacid = :uniacid and o.deleted=0';
	$paras = $paras1 = array(':uniacid' => $_W['uniacid']);
	if (empty($starttime) || empty($endtime)) 
	{
		$starttime = strtotime('-1 month');
		$endtime = time();
	}
	if (!empty($_GPC['time'])) 
	{
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		if ($_GPC['searchtime'] == '1') 
		{
			$condition .= ' AND o.createtime >= :starttime AND o.createtime <= :endtime ';
			$paras[':starttime'] = $starttime;
			$paras[':endtime'] = $endtime;
		}
	}
	if (empty($pstarttime) || empty($pendtime)) 
	{
		$pstarttime = strtotime('-1 month');
		$pendtime = time();
	}
	if (!empty($_GPC['ptime'])) 
	{
		$pstarttime = strtotime($_GPC['ptime']['start']);
		$pendtime = strtotime($_GPC['ptime']['end']);
		if ($_GPC['psearchtime'] == '1') 
		{
			$condition .= ' AND o.paytime >= :pstarttime AND o.paytime <= :pendtime ';
			$paras[':pstarttime'] = $pstarttime;
			$paras[':pendtime'] = $pendtime;
		}
	}
	if (empty($fstarttime) || empty($fendtime)) 
	{
		$fstarttime = strtotime('-1 month');
		$fendtime = time();
	}
	if (!empty($_GPC['ftime'])) 
	{
		$fstarttime = strtotime($_GPC['ftime']['start']);
		$fendtime = strtotime($_GPC['ftime']['end']);
		if ($_GPC['fsearchtime'] == '1') 
		{
			$condition .= ' AND o.finishtime >= :fstarttime AND o.finishtime <= :fendtime ';
			$paras[':fstarttime'] = $fstarttime;
			$paras[':fendtime'] = $fendtime;
		}
	}
	if (empty($sstarttime) || empty($sendtime)) 
	{
		$sstarttime = strtotime('-1 month');
		$sendtime = time();
	}
	if (!empty($_GPC['stime'])) 
	{
		$sstarttime = strtotime($_GPC['stime']['start']);
		$sendtime = strtotime($_GPC['stime']['end']);
		if ($_GPC['ssearchtime'] == '1') 
		{
			$condition .= ' AND o.sendtime >= :sstarttime AND o.sendtime <= :sendtime ';
			$paras[':sstarttime'] = $sstarttime;
			$paras[':sendtime'] = $sendtime;
		}
	}
	if ($_GPC['paytype'] != '') 
	{
		if ($_GPC['paytype'] == '2') 
		{
			$condition .= ' AND ( o.paytype =21 or o.paytype=22 or o.paytype=23 )';
		}
		else 
		{
			$condition .= ' AND o.paytype =' . intval($_GPC['paytype']);
		}
	}
	if (!empty($_GPC['keyword'])) 
	{
		$_GPC['keyword'] = trim($_GPC['keyword']);
		$condition .= ' AND o.ordersn LIKE \'%' . $_GPC['keyword'] . '%\'';
	}
	if (!empty($_GPC['expresssn'])) 
	{
		$_GPC['expresssn'] = trim($_GPC['expresssn']);
		$condition .= ' AND o.expresssn LIKE \'%' . $_GPC['expresssn'] . '%\'';
	}
	if (!empty($_GPC['member'])) 
	{
		$_GPC['member'] = trim($_GPC['member']);
		$condition .= ' AND (m.realname LIKE \'%' . $_GPC['member'] . '%\' or m.mobile LIKE \'%' . $_GPC['member'] . '%\' or m.nickname LIKE \'%' . $_GPC['member'] . '%\' ' . ' or a.realname LIKE \'%' . $_GPC['member'] . '%\' or a.mobile LIKE \'%' . $_GPC['member'] . '%\' or o.carrier LIKE \'%' . $_GPC['member'] . '%\')';
	}
	if (!empty($_GPC['saler'])) 
	{
		$_GPC['saler'] = trim($_GPC['saler']);
		$condition .= ' AND (sm.realname LIKE \'%' . $_GPC['saler'] . '%\' or sm.mobile LIKE \'%' . $_GPC['saler'] . '%\' or sm.nickname LIKE \'%' . $_GPC['saler'] . '%\' ' . ' or s.salername LIKE \'%' . $_GPC['saler'] . '%\' )';
	}
	if (!empty($_GPC['storeid'])) 
	{
		$_GPC['storeid'] = trim($_GPC['storeid']);
		$condition .= ' AND o.verifystoreid=' . intval($_GPC['storeid']);
	}
	if (!empty($_GPC['csid'])) 
	{
		$_GPC['csid'] = trim($_GPC['csid']);
		$condition .= ' AND o.cashierid=' . intval($_GPC['csid']);
	}
	$statuscondition = '';
	if ($status != '') 
	{
		if ($status == -1) 
		{
			ca('order.view.status_1');
		}
		else 
		{
			ca('order.view.status' . intval($status));
		}
		if ($status == '-1') 
		{
			$statuscondition = ' AND o.status=-1 and o.refundtime=0';
		}
		else if ($status == '4') 
		{
			$statuscondition = ' AND o.refundstate>=0 AND o.refundid<>0';
		}
		else if ($status == '5') 
		{
			$statuscondition = ' AND o.refundtime<>0';
		}
		else if ($status == '1') 
		{
			$statuscondition = ' AND ( o.status = 1 or (o.status=0 and o.paytype=3) )';
		}
		else if ($status == '0') 
		{
			$statuscondition = ' AND o.status = 0 and o.paytype<>3';
		}
		else 
		{
			$statuscondition = ' AND o.status = ' . intval($status);
		}
	}
	$bonusagentid = intval($_GPC['bonusagentid']);
	if (!empty($bonusagentid)) 
	{
		$sql = 'select distinct orderid from ' . tablename('sz_yi_bonus_goods') . ' where mid=' . $bonusagentid . ' ORDER BY id DESC';
		$bonusoderids = pdo_fetchall($sql);
		$inorderids = '';
		if (!empty($bonusoderids)) 
		{
			foreach ($bonusoderids as $key => $value ) 
			{
				if ($key != 0) 
				{
					$inorderids .= ',';
				}
				$inorderids = $value['orderid'];
			}
			$condition .= ' and  o.id in(' . $inorderids . ')';
		}
		else 
		{
			$condition .= ' and  o.id=0';
		}
	}
	$agentid = intval($_GPC['agentid']);
	$p = p('commission');
	$level = 0;
	if ($p) 
	{
		$cset = $p->getSet();
		$level = intval($cset['level']);
	}
	$olevel = intval($_GPC['olevel']);
	if (!empty($agentid) && (0 < $level)) 
	{
		$agent = $p->getInfo($agentid, array());
		if (!empty($agent)) 
		{
			$agentLevel = $p->getLevel($agentid);
		}
		if (empty($olevel)) 
		{
			if (1 <= $level) 
			{
				$condition .= ' and  ( o.agentid=' . intval($_GPC['agentid']);
			}
			if ((2 <= $level) && (0 < $agent['level2'])) 
			{
				$condition .= ' or o.agentid in( ' . implode(',', array_keys($agent['level1_agentids'])) . ')';
			}
			if ((3 <= $level) && (0 < $agent['level3'])) 
			{
				$condition .= ' or o.agentid in( ' . implode(',', array_keys($agent['level2_agentids'])) . ')';
			}
			if (1 <= $level) 
			{
				$condition .= ')';
			}
		}
		else if ($olevel == 1) 
		{
			$condition .= ' and  o.agentid=' . intval($_GPC['agentid']);
		}
		else if ($olevel == 2) 
		{
			if (0 < $agent['level2']) 
			{
				$condition .= ' and o.agentid in( ' . implode(',', array_keys($agent['level1_agentids'])) . ')';
			}
			else 
			{
				$condition .= ' and o.agentid in( 0 )';
			}
		}
		else if ($olevel == 3) 
		{
			if (0 < $agent['level3']) 
			{
				$condition .= ' and o.agentid in( ' . implode(',', array_keys($agent['level2_agentids'])) . ')';
			}
			else 
			{
				$condition .= ' and o.agentid in( 0 )';
			}
		}
	}
	if (p('supplier')) 
	{
		$cond = '';
		if ($perm_role == 1) 
		{
			$cond .= ' and o.supplier_uid=' . $_W['uid'] . ' ';
			$supplierapply = pdo_fetchall('select a.id,u.uid,p.realname,p.mobile,p.banknumber,p.accountname,p.accountbank,a.applysn,a.apply_money,a.apply_time,a.type,a.finish_time,a.status from ' . tablename('sz_yi_supplier_apply') . ' a ' . ' left join' . tablename('sz_yi_perm_user') . ' p on p.uid=a.uid ' . 'left join' . tablename('users') . ' u on a.uid=u.uid where u.uid=' . $_W['uid']);
			$totals['status9'] = count($supplierapply);
			$costmoney = 0;
			$sp_goods = pdo_fetchall('select og.* from ' . tablename('sz_yi_order_goods') . ' og left join ' . tablename('sz_yi_order') . ' o on (o.id=og.orderid) where og.uniacid=' . $_W['uniacid'] . ' and og.supplier_uid=' . $_W['uid'] . ' and o.status=3 and og.supplier_apply_status=0');
			foreach ($sp_goods as $key => $value ) 
			{
				if (0 < $value['goods_op_cost_price']) 
				{
					$costmoney += $value['goods_op_cost_price'] * $value['total'];
				}
				else 
				{
					$option = pdo_fetch('select * from ' . tablename('sz_yi_goods_option') . ' where uniacid=' . $_W['uniacid'] . ' and goodsid=' . $value['goodsid'] . ' and id=' . $value['optionid']);
					if (0 < $option['costprice']) 
					{
						$costmoney += $option['costprice'] * $value['total'];
					}
					else 
					{
						$goods_info = pdo_fetch('select * from' . tablename('sz_yi_goods') . ' where uniacid=' . $_W['uniacid'] . ' and id=' . $value['goodsid']);
						$costmoney += $goods_info['costprice'] * $value['total'];
					}
				}
			}
			$openid = pdo_fetchcolumn('select openid from ' . tablename('sz_yi_perm_user') . ' where uid=:uid and uniacid=:uniacid', array(':uid' => $_W['uid'], ':uniacid' => $_W['uniacid']));
			if (empty($openid)) 
			{
				message('暂未绑定微信，请联系管理员', '', 'error');
			}
			$applytype = intval($_GPC['applytype']);
			$apply_ordergoods_ids = '';
			foreach ($sp_goods as $key => $value ) 
			{
				if ($key == 0) 
				{
					$apply_ordergoods_ids .= $value['id'];
				}
				else 
				{
					$apply_ordergoods_ids .= ',' . $value['id'];
				}
			}
			if (!empty($applytype)) 
			{
				$applysn = m('common')->createNO('commission_apply', 'applyno', 'CA');
				$data = array('uid' => $_W['uid'], 'apply_money' => $costmoney, 'apply_time' => time(), 'status' => 0, 'type' => $applytype, 'applysn' => $applysn, 'uniacid' => $_W['uniacid'], 'apply_ordergoods_ids' => $apply_ordergoods_ids);
				pdo_insert('sz_yi_supplier_apply', $data);
				@file_put_contents(IA_ROOT . '/addons/sz_yi/data/apply.log', print_r($data, 1), FILE_APPEND);
				if (pdo_insertid()) 
				{
					foreach ($sp_goods as $ids ) 
					{
						$arr = array('supplier_apply_status' => 2);
						pdo_update('sz_yi_order_goods', $arr, array('id' => $ids['id']));
					}
					$tmp_sp_goods = $sp_goods;
					$tmp_sp_goods['applyno'] = $applysn;
					@file_put_contents(IA_ROOT . '/addons/sz_yi/data/sp_goods.log', print_r($tmp_sp_goods, 1), FILE_APPEND);
				}
				message('提现申请已提交，请耐心等待!', $this->createWebUrl('order/list'), 'success');
			}
		}
	}
	$sql = 'select o.* , a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity , a.area as aarea,a.address as aaddress, d.dispatchname,m.nickname,m.id as mid,m.realname as mrealname,m.mobile as mmobile,sm.id as salerid,sm.nickname as salernickname,s.salername,r.rtype,r.status as rstatus from ' . tablename('sz_yi_order') . ' o' . ' left join ' . tablename('sz_yi_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid ' . ' left join ' . tablename('sz_yi_member_address') . ' a on a.id=o.addressid ' . ' left join ' . tablename('sz_yi_dispatch') . ' d on d.id = o.dispatchid ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . '  where ' . $condition . ' ' . $statuscondition . ' ' . $cond . ' ORDER BY o.createtime DESC,o.status DESC  ';
	if (empty($_GPC['export'])) 
	{
		$sql .= 'LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
	}
	$list = pdo_fetchall($sql, $paras);
	if (p('supplier')) 
	{
		foreach ($list as &$value ) 
		{
			if ($value['supplier_uid'] == 0) 
			{
				$value['vendor'] = '总店';
			}
			else 
			{
				$sup_username = pdo_fetchcolumn('select username from ' . tablename('sz_yi_perm_user') . ' where uniacid=' . $_W['uniacid'] . ' and uid=' . $value['supplier_uid']);
				$value['vendor'] = '供应商：' . $sup_username;
			}
		}
	}
	$paytype = array( 0 => array('css' => 'default', 'name' => '未支付'), 1 => array('css' => 'danger', 'name' => '余额支付'), 11 => array('css' => 'default', 'name' => '后台付款'), 2 => array('css' => 'danger', 'name' => '在线支付'), 21 => array('css' => 'success', 'name' => '微信支付'), 22 => array('css' => 'warning', 'name' => '支付宝支付'), 23 => array('css' => 'warning', 'name' => '银联支付'), 3 => array('css' => 'primary', 'name' => '货到付款') );
	$orderstatus = array( -1 => array('css' => 'default', 'name' => '已关闭'), 0 => array('css' => 'danger', 'name' => '待付款'), 1 => array('css' => 'info', 'name' => '待发货'), 2 => array('css' => 'warning', 'name' => '待收货'), 3 => array('css' => 'success', 'name' => '已完成') );
	foreach ($list as &$value ) 
	{
		$s = $value['status'];
		$pt = $value['paytype'];
		$value['statusvalue'] = $s;
		$value['statuscss'] = $orderstatus[$value['status']]['css'];
		$value['status'] = $orderstatus[$value['status']]['name'];
		if (($pt == 3) && empty($value['statusvalue'])) 
		{
			$value['statuscss'] = $orderstatus[1]['css'];
			$value['status'] = $orderstatus[1]['name'];
		}
		if ($s == 1) 
		{
			if ($value['isverify'] == 1) 
			{
				$value['status'] = '待使用';
			}
			else if (empty($value['addressid'])) 
			{
				$value['status'] = '待取货';
			}
		}
		if ($s == -1) 
		{
			$value['status'] = $value['rstatus'];
			if (!empty($value['refundtime'])) 
			{
				if ($value['rstatus'] == 1) 
				{
					$value['status'] = '已' . $r_type[$value['rtype']];
				}
			}
		}
		$value['paytypevalue'] = $pt;
		$value['css'] = $paytype[$pt]['css'];
		$value['paytype'] = $paytype[$pt]['name'];
		$value['dispatchname'] = (empty($value['addressid']) ? '自提' : $value['dispatchname']);
		if (empty($value['dispatchname'])) 
		{
			$value['dispatchname'] = '快递';
		}
		if ($value['isverify'] == 1) 
		{
			$value['dispatchname'] = '线下核销';
		}
		else if ($value['isvirtual'] == 1) 
		{
			$value['dispatchname'] = '虚拟物品';
		}
		else if (!empty($value['virtual'])) 
		{
			$value['dispatchname'] = '虚拟物品(卡密)<br/>自动发货';
		}
		else if ($value['cashier'] == 1) 
		{
			$value['dispatchname'] = '收银台支付';
		}
		if (p('cashier') && ($value['cashier'] == 1)) 
		{
			$value['name'] = set_medias(pdo_fetch('select cs.name,cs.thumb from ' . tablename('sz_yi_cashier_store') . 'cs ' . 'left join ' . tablename('sz_yi_cashier_order') . ' co on cs.id = co.cashier_store_id where co.order_id=:orderid and co.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $_W['uniacid'])), 'thumb');
		}
		if (($value['dispatchtype'] == 1) || !empty($value['isverify']) || !empty($value['virtual']) || !empty($value['isvirtual']) || ($value['cashier'] == 1)) 
		{
			$value['address'] = '';
			$carrier = iunserializer($value['carrier']);
			if (is_array($carrier)) 
			{
				$value['addressdata']['realname'] = $value['realname'] = $carrier['carrier_realname'];
				$value['addressdata']['mobile'] = $value['mobile'] = $carrier['carrier_mobile'];
			}
		}
		else 
		{
			$address = iunserializer($value['address']);
			$isarray = is_array($address);
			$value['realname'] = ($isarray ? $address['realname'] : $value['arealname']);
			$value['mobile'] = ($isarray ? $address['mobile'] : $value['amobile']);
			$value['province'] = ($isarray ? $address['province'] : $value['aprovince']);
			$value['city'] = ($isarray ? $address['city'] : $value['acity']);
			$value['area'] = ($isarray ? $address['area'] : $value['aarea']);
			$value['address'] = ($isarray ? $address['address'] : $value['aaddress']);
			$value['address_province'] = $value['province'];
			$value['address_city'] = $value['city'];
			$value['address_area'] = $value['area'];
			$value['address_address'] = $value['address'];
			$value['address'] = $value['province'] . ' ' . $value['city'] . ' ' . $value['area'] . ' ' . $value['address'];
			$value['addressdata'] = array('realname' => $value['realname'], 'mobile' => $value['mobile'], 'address' => $value['address']);
		}
		$commission1 = -1;
		$commission2 = -1;
		$commission3 = -1;
		$m1 = false;
		$m2 = false;
		$m3 = false;
		if (!empty($level) && empty($agentid)) 
		{
			if (!empty($value['agentid'])) 
			{
				$m1 = m('member')->getMember($value['agentid']);
				$commission1 = 0;
				if (!empty($m1['agentid'])) 
				{
					$m2 = m('member')->getMember($m1['agentid']);
					$commission2 = 0;
					if (!empty($m2['agentid'])) 
					{
						$m3 = m('member')->getMember($m2['agentid']);
						$commission3 = 0;
					}
				}
			}
		}
		$order_goods = pdo_fetchall('select g.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,og.price,og.optionname as optiontitle, og.realprice,og.changeprice,og.oldprice,og.commission1,og.commission2,og.commission3,og.commissions,og.diyformdata,og.diyformfields from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $value['id']));
		$goods = '';
		foreach ($order_goods as &$og ) 
		{
			if (!empty($level) && empty($agentid)) 
			{
				$commissions = iunserializer($og['commissions']);
				if (!empty($m1)) 
				{
					if (is_array($commissions)) 
					{
						$commission1 += ((isset($commissions['level1']) ? floatval($commissions['level1']) : 0));
					}
					else 
					{
						$c1 = iunserializer($og['commission1']);
						$l1 = $p->getLevel($m1['openid']);
						$commission1 += ((isset($c1['level' . $l1['id']]) ? $c1['level' . $l1['id']] : $c1['default']));
					}
				}
				if (!empty($m2)) 
				{
					if (is_array($commissions)) 
					{
						$commission2 += ((isset($commissions['level2']) ? floatval($commissions['level2']) : 0));
					}
					else 
					{
						$c2 = iunserializer($og['commission2']);
						$l2 = $p->getLevel($m2['openid']);
						$commission2 += ((isset($c2['level' . $l2['id']]) ? $c2['level' . $l2['id']] : $c2['default']));
					}
				}
				if (!empty($m3)) 
				{
					if (is_array($commissions)) 
					{
						$commission3 += ((isset($commissions['level3']) ? floatval($commissions['level3']) : 0));
					}
					else 
					{
						$c3 = iunserializer($og['commission3']);
						$l3 = $p->getLevel($m3['openid']);
						$commission3 += ((isset($c3['level' . $l3['id']]) ? $c3['level' . $l3['id']] : $c3['default']));
					}
				}
			}
			$goods .= '' . $og['title'] . '';
			if (!empty($og['optiontitle'])) 
			{
				$goods .= ' 规格: ' . $og['optiontitle'];
			}
			if (!empty($og['option_goodssn'])) 
			{
				$og['goodssn'] = $og['option_goodssn'];
			}
			if (!empty($og['option_productsn'])) 
			{
				$og['productsn'] = $og['option_productsn'];
			}
			if (!empty($og['goodssn'])) 
			{
				$goods .= ' 商品编号: ' . $og['goodssn'];
			}
			if (!empty($og['productsn'])) 
			{
				$goods .= ' 商品条码: ' . $og['productsn'];
			}
			$goods .= ' 单价: ' . ($og['price'] / $og['total']) . ' 折扣后: ' . ($og['realprice'] / $og['total']) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . ' 折扣后: ' . $og['realprice'] . '';
			if ($plugin_diyform && !empty($og['diyformfields']) && !empty($og['diyformdata'])) 
			{
				$diyformdata_array = $plugin_diyform->getDatas(iunserializer($og['diyformfields']), iunserializer($og['diyformdata']));
				$diyformdata = '';
				foreach ($diyformdata_array as $da ) 
				{
					$diyformdata .= $da['name'] . ': ' . $da['value'] . '';
				}
				$og['goods_diyformdata'] = $diyformdata;
			}
		}
		unset($og);
		if (!empty($level) && empty($agentid)) 
		{
			$value['commission1'] = $commission1;
			$value['commission2'] = $commission2;
			$value['commission3'] = $commission3;
		}
		$value['goods'] = set_medias($order_goods, 'thumb');
		$value['goods_str'] = $goods;
		if (!empty($agentid) && (0 < $level)) 
		{
			$commission_level = 0;
			if ($value['agentid'] == $agentid) 
			{
				$value['level'] = 1;
				$level1_commissions = pdo_fetchall('select commission1,commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and o.agentid= ' . $agentid . '  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $_W['uniacid']));
				foreach ($level1_commissions as $c ) 
				{
					$commission = iunserializer($c['commission1']);
					$commissions = iunserializer($c['commissions']);
					if (empty($commissions)) 
					{
						$commission_level += ((isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default']));
					}
					else 
					{
						$commission_level += ((isset($commissions['level1']) ? floatval($commissions['level1']) : 0));
					}
				}
			}
			else if (in_array($value['agentid'], array_keys($agent['level1_agentids']))) 
			{
				$value['level'] = 2;
				if (0 < $agent['level2']) 
				{
					$level2_commissions = pdo_fetchall('select commission2,commissions  from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and  o.agentid in ( ' . implode(',', array_keys($agent['level1_agentids'])) . ')  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $_W['uniacid']));
					foreach ($level2_commissions as $c ) 
					{
						$commission = iunserializer($c['commission2']);
						$commissions = iunserializer($c['commissions']);
						if (empty($commissions)) 
						{
							$commission_level += ((isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default']));
						}
						else 
						{
							$commission_level += ((isset($commissions['level2']) ? floatval($commissions['level2']) : 0));
						}
					}
				}
			}
			else if (in_array($value['agentid'], array_keys($agent['level2_agentids']))) 
			{
				$value['level'] = 3;
				if (0 < $agent['level3']) 
				{
					$level3_commissions = pdo_fetchall('select commission3,commissions from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join  ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and  o.agentid in ( ' . implode(',', array_keys($agent['level2_agentids'])) . ')  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $_W['uniacid']));
					foreach ($level3_commissions as $c ) 
					{
						$commission = iunserializer($c['commission3']);
						$commissions = iunserializer($c['commissions']);
						if (empty($commissions)) 
						{
							$commission_level += ((isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default']));
						}
						else 
						{
							$commission_level += ((isset($commissions['level3']) ? floatval($commissions['level3']) : 0));
						}
					}
				}
			}
			$value['commission'] = $commission_level;
		}
	}
	unset($value);
	if ($_GPC['export'] == 1) 
	{
		ca('order.op.export');
		plog('order.op.export', '导出订单');
		$columns = array( array('title' => '订单编号', 'field' => 'ordersn', 'width' => 24), array('title' => '粉丝昵称', 'field' => 'nickname', 'width' => 12), array('title' => '会员姓名', 'field' => 'mrealname', 'width' => 12), array('title' => '会员手机手机号', 'field' => 'mmobile', 'width' => 12), array('title' => '收货姓名(或自提人)', 'field' => 'realname', 'width' => 12), array('title' => '联系电话', 'field' => 'mobile', 'width' => 12), array('title' => '收货地址', 'field' => 'address_province', 'width' => 12), array('title' => '', 'field' => 'address_city', 'width' => 12), array('title' => '', 'field' => 'address_area', 'width' => 12), array('title' => '', 'field' => 'address_address', 'width' => 12), array('title' => '商品名称', 'field' => 'goods_title', 'width' => 24), array('title' => '商品编码', 'field' => 'goods_goodssn', 'width' => 12), array('title' => '商品规格', 'field' => 'goods_optiontitle', 'width' => 12), array('title' => '商品数量', 'field' => 'goods_total', 'width' => 12), array('title' => '商品单价(折扣前)', 'field' => 'goods_price1', 'width' => 12), array('title' => '商品单价(折扣后)', 'field' => 'goods_price2', 'width' => 12), array('title' => '商品价格(折扣后)', 'field' => 'goods_rprice1', 'width' => 12), array('title' => '商品价格(折扣后)', 'field' => 'goods_rprice2', 'width' => 12), array('title' => '支付方式', 'field' => 'paytype', 'width' => 12), array('title' => '配送方式', 'field' => 'dispatchname', 'width' => 12), array('title' => '商品小计', 'field' => 'goodsprice', 'width' => 12), array('title' => '运费', 'field' => 'dispatchprice', 'width' => 12), array('title' => '积分抵扣', 'field' => 'deductprice', 'width' => 12), array('title' => '余额抵扣', 'field' => 'deductcredit2', 'width' => 12), array('title' => '满额立减', 'field' => 'deductenough', 'width' => 12), array('title' => '优惠券优惠', 'field' => 'couponprice', 'width' => 12), array('title' => '订单改价', 'field' => 'changeprice', 'width' => 12), array('title' => '运费改价', 'field' => 'changedispatchprice', 'width' => 12), array('title' => '应收款', 'field' => 'price', 'width' => 12), array('title' => '状态', 'field' => 'status', 'width' => 12), array('title' => '下单时间', 'field' => 'createtime', 'width' => 24), array('title' => '付款时间', 'field' => 'paytime', 'width' => 24), array('title' => '发货时间', 'field' => 'sendtime', 'width' => 24), array('title' => '完成时间', 'field' => 'finishtime', 'width' => 24), array('title' => '快递公司', 'field' => 'expresscom', 'width' => 24), array('title' => '快递单号', 'field' => 'expresssn', 'width' => 24), array('title' => '订单备注', 'field' => 'remark', 'width' => 36), array('title' => '核销员', 'field' => 'salerinfo', 'width' => 24), array('title' => '核销门店', 'field' => 'storeinfo', 'width' => 36), array('title' => '订单自定义信息', 'field' => 'order_diyformdata', 'width' => 36), array('title' => '商品自定义信息', 'field' => 'goods_diyformdata', 'width' => 36) );
		if (!empty($agentid) && (0 < $level)) 
		{
			$columns[] = array('title' => '分销级别', 'field' => 'level', 'width' => 24);
			$columns[] = array('title' => '分销佣金', 'field' => 'commission', 'width' => 24);
		}
		foreach ($list as &$row ) 
		{
			$row['ordersn'] = $row['ordersn'] . ' ';
			if (0 < $row['deductprice']) 
			{
				$row['deductprice'] = '-' . $row['deductprice'];
			}
			if (0 < $row['deductcredit2']) 
			{
				$row['deductcredit2'] = '-' . $row['deductcredit2'];
			}
			if (0 < $row['deductenough']) 
			{
				$row['deductenough'] = '-' . $row['deductenough'];
			}
			if ($row['changeprice'] < 0) 
			{
				$row['changeprice'] = '-' . $row['changeprice'];
			}
			else if (0 < $row['changeprice']) 
			{
				$row['changeprice'] = '+' . $row['changeprice'];
			}
			if ($row['changedispatchprice'] < 0) 
			{
				$row['changedispatchprice'] = '-' . $row['changedispatchprice'];
			}
			else if (0 < $row['changedispatchprice']) 
			{
				$row['changedispatchprice'] = '+' . $row['changedispatchprice'];
			}
			if (0 < $row['couponprice']) 
			{
				$row['couponprice'] = '-' . $row['couponprice'];
			}
			$row['expresssn'] = $row['expresssn'] . ' ';
			$row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
			$row['paytime'] = (!empty($row['paytime']) ? date('Y-m-d H:i:s', $row['paytime']) : '');
			$row['sendtime'] = (!empty($row['sendtime']) ? date('Y-m-d H:i:s', $row['sendtime']) : '');
			$row['finishtime'] = (!empty($row['finishtime']) ? date('Y-m-d H:i:s', $row['finishtime']) : '');
			$row['salerinfo'] = '';
			$row['storeinfo'] = '';
			if (!empty($row['verifyopenid'])) 
			{
				$row['salerinfo'] = '[' . $row['salerid'] . ']' . $row['salername'] . '(' . $row['salernickname'] . ')';
			}
			if (!empty($row['verifystoreid'])) 
			{
				$row['storeinfo'] = pdo_fetchcolumn('select storename from ' . tablename('sz_yi_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['verifystoreid']));
			}
			if ($plugin_diyform && !empty($row['diyformfields']) && !empty($row['diyformdata'])) 
			{
				$diyformdata_array = p('diyform')->getDatas(iunserializer($row['diyformfields']), iunserializer($row['diyformdata']));
				$diyformdata = '';
				foreach ($diyformdata_array as $da ) 
				{
					$diyformdata .= $da['name'] . ': ' . $da['value'] . '';
				}
				$row['order_diyformdata'] = $diyformdata;
			}
		}
		unset($row);
		$exportlist = array();
		foreach ($list as &$r ) 
		{
			$ogoods = $r['goods'];
			unset($r['goods']);
			foreach ($ogoods as $k => $g ) 
			{
				if (0 < $k) 
				{
					$r['ordersn'] = '';
					$r['realname'] = '';
					$r['mobile'] = '';
					$r['nickname'] = '';
					$r['mrealname'] = '';
					$r['mmobile'] = '';
					$r['address'] = '';
					$r['address_province'] = '';
					$r['address_city'] = '';
					$r['address_area'] = '';
					$r['address_address'] = '';
					$r['paytype'] = '';
					$r['dispatchname'] = '';
					$r['dispatchprice'] = '';
					$r['goodsprice'] = '';
					$r['status'] = '';
					$r['createtime'] = '';
					$r['sendtime'] = '';
					$r['finishtime'] = '';
					$r['expresscom'] = '';
					$r['expresssn'] = '';
					$r['deductprice'] = '';
					$r['deductcredit2'] = '';
					$r['deductenough'] = '';
					$r['changeprice'] = '';
					$r['changedispatchprice'] = '';
					$r['price'] = '';
					$r['order_diyformdata'] = '';
				}
				$r['goods_title'] = $g['title'];
				$r['goods_goodssn'] = $g['goodssn'];
				$r['goods_optiontitle'] = $g['optiontitle'];
				$r['goods_total'] = $g['total'];
				$r['goods_price1'] = $g['price'] / $g['total'];
				$r['goods_price2'] = $g['realprice'] / $g['total'];
				$r['goods_rprice1'] = $g['price'];
				$r['goods_rprice2'] = $g['realprice'];
				$r['goods_diyformdata'] = $g['goods_diyformdata'];
				$exportlist[] = $r;
			}
		}
		unset($r);
		m('excel')->export($exportlist, array('title' => '订单数据-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' ' . $statuscondition . ' ' . $cond, $paras);
	$totalmoney = pdo_fetchcolumn('SELECT ifnull(sum(o.price),0) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' ' . $statuscondition . ' ' . $cond . ' ', $paras);
	$totals['all'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE o.uniacid = :uniacid and o.deleted=0 ' . $cond . ' ', $paras);
	$totals['status_1'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.status=-1 and o.refundtime=0 ' . $cond . ' ', $paras);
	$totals['status0'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.status=0 and o.paytype<>3 ' . $cond . ' ', $paras);
	$totals['status1'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and ( o.status=1 or ( o.status=0 and o.paytype=3) ) ' . $cond . ' ', $paras);
	$totals['status2'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.status=2 ' . $cond . ' ', $paras);
	$totals['status3'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.status=3 ' . $cond . ' ', $paras);
	$totals['status4'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.refundid<>0 and o.refundstate>=0 ' . $cond . ' ', $paras);
	$totals['status5'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id  order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.refundtime<>0 ' . $cond . ' ', $paras);
	$pager = pagination($total, $pindex, $psize);
	$stores = pdo_fetchall('select id,storename from ' . tablename('sz_yi_store') . ' where uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
	if (p('cashier')) 
	{
		$cashier_stores = pdo_fetchall('select id,name from ' . tablename('sz_yi_cashier_store') . ' where uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
	}
	load()->func('tpl');
	include $this->template('web/order/list');
	exit();
	return 1;
}
if ($operation == 'detail') 
{
	$id = intval($_GPC['id']);
	$p = p('commission');
	$item = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
	$item['statusvalue'] = $item['status'];
	$shopset = m('common')->getSysset('shop');
	if (empty($item)) 
	{
		message('抱歉，订单不存在!', referer(), 'error');
	}
	if (!empty($item['refundid'])) 
	{
		ca('order.view.status4');
	}
	else if ($item['status'] == -1) 
	{
		ca('order.view.status_1');
	}
	else 
	{
		ca('order.view.status' . $item['status']);
	}
	if ($_W['ispost']) 
	{
		pdo_update('sz_yi_order', array('remark' => trim($_GPC['remark'])), array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
		plog('order.op.saveremark', '订单保存备注  ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
		message('订单备注保存成功！', $this->createWebUrl('order', array('op' => 'detail', 'id' => $item['id'])), 'success');
	}
	$member = m('member')->getMember($item['openid']);
	$dispatch = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_dispatch') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['dispatchid'], ':uniacid' => $_W['uniacid']));
	if (empty($item['addressid'])) 
	{
		$user = unserialize($item['carrier']);
	}
	else 
	{
		$user = iunserializer($item['address']);
		if (!is_array($user)) 
		{
			$user = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
		}
		$address_info = $user['address'];
		$user['address'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['area'] . ' ' . $user['address'];
		$item['addressdata'] = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address']);
	}
	$refund = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_order_refund') . ' WHERE orderid = :orderid and uniacid=:uniacid order by id desc', array(':orderid' => $item['id'], ':uniacid' => $_W['uniacid']));
	if (!empty($refund)) 
	{
		if (!empty($refund['imgs'])) 
		{
			$refund['imgs'] = iunserializer($refund['imgs']);
		}
	}
	$diyformfields = '';
	$plugin_diyform = p('diyform');
	if ($plugin_diyform) 
	{
		$diyformfields = ',diyformfields,diyformdata';
	}
	$goods = pdo_fetchall('SELECT g.*, o.goodssn as option_goodssn, o.productsn as option_productsn,o.total,g.type,o.optionname,o.optionid,o.price as orderprice,o.realprice,o.changeprice,o.oldprice,o.commission1,o.commission2,o.commission3,o.commissions' . $diyformfields . ' FROM ' . tablename('sz_yi_order_goods') . ' o left join ' . tablename('sz_yi_goods') . ' g on o.goodsid=g.id ' . ' WHERE o.orderid=:orderid and o.uniacid=:uniacid', array(':orderid' => $id, ':uniacid' => $_W['uniacid']));
	if (p('cashier') && ($item['cashier'] == 1)) 
	{
		$cashier_stores = set_medias(pdo_fetch('select * from ' . tablename('sz_yi_cashier_store') . ' where id = ' . $item['cashierid'] . ' and uniacid=' . $_W['uniacid']), 'thumb');
	}
	foreach ($goods as &$r ) 
	{
		if (!empty($r['option_goodssn'])) 
		{
			$r['goodssn'] = $r['option_goodssn'];
		}
		if (!empty($r['option_productsn'])) 
		{
			$r['productsn'] = $r['option_productsn'];
		}
		if ($plugin_diyform) 
		{
			$r['diyformfields'] = iunserializer($r['diyformfields']);
			$r['diyformdata'] = iunserializer($r['diyformdata']);
		}
	}
	unset($r);
	$item['goods'] = $goods;
	$agents = array();
	if ($p) 
	{
		$agents = $p->getAgents($id);
		$m1 = ((isset($agents[0]) ? $agents[0] : false));
		$m2 = ((isset($agents[1]) ? $agents[1] : false));
		$m3 = ((isset($agents[2]) ? $agents[2] : false));
		$commission1 = 0;
		$commission2 = 0;
		$commission3 = 0;
		foreach ($goods as &$og ) 
		{
			$oc1 = 0;
			$oc2 = 0;
			$oc3 = 0;
			$commissions = iunserializer($og['commissions']);
			if (!empty($m1)) 
			{
				if (is_array($commissions)) 
				{
					$oc1 = ((isset($commissions['level1']) ? floatval($commissions['level1']) : 0));
				}
				else 
				{
					$c1 = iunserializer($og['commission1']);
					$l1 = $p->getLevel($m1['openid']);
					$oc1 = ((isset($c1['level' . $l1['id']]) ? $c1['level' . $l1['id']] : $c1['default']));
				}
				$og['oc1'] = $oc1;
				$commission1 += $oc1;
			}
			if (!empty($m2)) 
			{
				if (is_array($commissions)) 
				{
					$oc2 = ((isset($commissions['level2']) ? floatval($commissions['level2']) : 0));
				}
				else 
				{
					$c2 = iunserializer($og['commission2']);
					$l2 = $p->getLevel($m2['openid']);
					$oc2 = ((isset($c2['level' . $l2['id']]) ? $c2['level' . $l2['id']] : $c2['default']));
				}
				$og['oc2'] = $oc2;
				$commission2 += $oc2;
			}
			if (!empty($m3)) 
			{
				if (is_array($commissions)) 
				{
					$oc3 = ((isset($commissions['level3']) ? floatval($commissions['level3']) : 0));
				}
				else 
				{
					$c3 = iunserializer($og['commission3']);
					$l3 = $p->getLevel($m3['openid']);
					$oc3 = ((isset($c3['level' . $l3['id']]) ? $c3['level' . $l3['id']] : $c3['default']));
				}
				$og['oc3'] = $oc3;
				$commission3 += $oc3;
			}
		}
		unset($og);
	}
	$condition = ' o.uniacid=:uniacid and o.deleted=0';
	$paras = array(':uniacid' => $_W['uniacid']);
	$totals = array();
	$totals['all'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition, $paras);
	$totals['status_1'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.status=-1 and o.refundtime=0', $paras);
	$totals['status0'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.status=0 and o.paytype<>3', $paras);
	$totals['status1'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and ( o.status=1 or ( o.status=0 and o.paytype=3) )', $paras);
	$totals['status2'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.status=2', $paras);
	$totals['status3'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.status=3', $paras);
	$totals['status4'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.refundid<>0  and o.refundstate>=0', $paras);
	$totals['status5'] = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('sz_yi_order') . ' o ' . ' left join ( select rr.id,rr.orderid,rr.status from ' . tablename('sz_yi_order_refund') . ' rr left join ' . tablename('sz_yi_order') . ' ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id' . ' left join ' . tablename('sz_yi_member') . ' m on m.openid=o.openid  and m.uniacid =  o.uniacid' . ' left join ' . tablename('sz_yi_member_address') . ' a on o.addressid = a.id ' . ' left join ' . tablename('sz_yi_member') . ' sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid' . ' left join ' . tablename('sz_yi_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' WHERE ' . $condition . ' and o.refundtime<>0', $paras);
	$coupon = false;
	if (p('coupon') && !empty($item['couponid'])) 
	{
		$coupon = p('coupon')->getCouponByDataID($item['couponid']);
	}
	if (p('verify')) 
	{
		if (!empty($item['verifyopenid'])) 
		{
			$saler = m('member')->getMember($item['verifyopenid']);
			$saler['salername'] = pdo_fetchcolumn('select salername from ' . tablename('sz_yi_saler') . ' where openid=:openid and uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid'], ':openid' => $item['verifyopenid']));
		}
		if (!empty($item['verifystoreid'])) 
		{
			$store = pdo_fetch('select * from ' . tablename('sz_yi_store') . ' where id=:storeid limit 1 ', array(':storeid' => $item['verifystoreid']));
		}
	}
	$show = 1;
	$diyform_flag = 0;
	$diyform_plugin = p('diyform');
	$order_fields = false;
	$order_data = false;
	if ($diyform_plugin) 
	{
		$diyform_set = $diyform_plugin->getSet();
		foreach ($goods as $g ) 
		{
			if (empty($g['diyformdata'])) 
			{
				continue;
			}
			$diyform_flag = 1;
			break;
		}
		if (!empty($item['diyformid'])) 
		{
			$orderdiyformid = $item['diyformid'];
			if (!empty($orderdiyformid)) 
			{
				$diyform_flag = 1;
				$order_fields = iunserializer($item['diyformfields']);
				$order_data = iunserializer($item['diyformdata']);
			}
		}
	}
	$refund_address = pdo_fetchall('select * from ' . tablename('sz_yi_refund_address') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
	load()->func('tpl');
	include $this->template('web/order/detail');
	exit();
	return 1;
}
if ($operation == 'saveexpress') 
{
	$id = intval($_GPC['id']);
	$express = $_GPC['express'];
	$expresscom = $_GPC['expresscom'];
	$expresssn = trim($_GPC['expresssn']);
	if (empty($id)) 
	{
		$ret = 'Url参数错误！请重试！';
		show_json(0, $ret);
	}
	if (!empty($expresssn)) 
	{
		$change_data = array();
		$change_data['express'] = $express;
		$change_data['expresscom'] = $expresscom;
		$change_data['expresssn'] = $expresssn;
		pdo_update('sz_yi_order', $change_data, array('id' => $id, 'uniacid' => $_W['uniacid']));
		$ret = '修改成功';
		show_json(1, $ret);
		return 1;
	}
	$ret = '请填写快递单号！';
	show_json(0, $ret);
	return 1;
}
if ($operation == 'saveaddress') 
{
	$province = $_GPC['province'];
	$realname = $_GPC['realname'];
	$mobile = $_GPC['mobile'];
	$city = $_GPC['city'];
	$area = $_GPC['area'];
	$address = trim($_GPC['address']);
	$id = intval($_GPC['id']);
	if (!empty($id)) 
	{
		if (empty($realname)) 
		{
			$ret = '请填写收件人姓名！';
			show_json(0, $ret);
		}
		if (empty($mobile)) 
		{
			$ret = '请填写收件人手机！';
			show_json(0, $ret);
		}
		if ($province == '请选择省份') 
		{
			$ret = '请选择省份！';
			show_json(0, $ret);
		}
		if (empty($address)) 
		{
			$ret = '请填写详细地址！';
			show_json(0, $ret);
		}
		$item = pdo_fetch('SELECT address FROM ' . tablename('sz_yi_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$address_array = iunserializer($item['address']);
		$address_array['realname'] = $realname;
		$address_array['mobile'] = $mobile;
		$address_array['province'] = $province;
		$address_array['city'] = $city;
		$address_array['area'] = $area;
		$address_array['address'] = $address;
		$address_array = iserializer($address_array);
		pdo_update('sz_yi_order', array('address' => $address_array), array('id' => $id, 'uniacid' => $_W['uniacid']));
		$ret = '修改成功';
		show_json(1, $ret);
		return 1;
	}
	$ret = 'Url参数错误！请重试！';
	show_json(0, $ret);
	return 1;
}
if ($operation == 'delete') 
{
	ca('order.op.delete');
	$orderid = intval($_GPC['id']);
	pdo_update('sz_yi_order', array('deleted' => 1), array('id' => $orderid, 'uniacid' => $_W['uniacid']));
	plog('order.op.delete', '订单删除 ID: ' . $id);
	message('订单删除成功', $this->createWebUrl('order', array('op' => 'display')), 'success');
	return 1;
}
if ($operation == 'deal') 
{
	$id = intval($_GPC['id']);
	$item = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_order') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
	$shopset = m('common')->getSysset('shop');
	if (empty($item)) 
	{
		message('抱歉，订单不存在!', referer(), 'error');
	}
	if (!empty($item['refundid'])) 
	{
		ca('order.view.status4');
	}
	else if ($item['status'] == -1) 
	{
		ca('order.view.status_1');
	}
	else 
	{
		ca('order.view.status' . $item['status']);
	}
	$to = trim($_GPC['to']);
	if ($to == 'confirmpay') 
	{
		order_list_confirmpay($item);
	}
	else if ($to == 'cancelpay') 
	{
		order_list_cancelpay($item);
	}
	else if ($to == 'confirmsend') 
	{
		order_list_confirmsend($item);
	}
	else if ($to == 'cancelsend') 
	{
		order_list_cancelsend($item);
	}
	else if ($to == 'confirmsend1') 
	{
		order_list_confirmsend1($item);
	}
	else if ($to == 'cancelsend1') 
	{
		order_list_cancelsend1($item);
	}
	else if ($to == 'finish') 
	{
		order_list_finish($item);
	}
	else if ($to == 'close') 
	{
		order_list_close($item);
	}
	else if ($to == 'refund') 
	{
		order_list_refund($item);
	}
	else if ($to == 'redpack') 
	{
		order_list_redpack($item);
	}
	else if ($to == 'changepricemodal') 
	{
		if (!empty($item['status'])) 
		{
			exit('-1');
		}
		$order_goods = pdo_fetchall('select og.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,og.price,og.optionname as optiontitle, og.realprice,og.oldprice from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $item['id']));
		if (empty($item['addressid'])) 
		{
			$user = unserialize($item['carrier']);
			$item['addressdata'] = array('realname' => $user['carrier_realname'], 'mobile' => $user['carrier_mobile']);
		}
		else 
		{
			$user = iunserializer($item['address']);
			if (!is_array($user)) 
			{
				$user = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_member_address') . ' WHERE id = :id and uniacid=:uniacid', array(':id' => $item['addressid'], ':uniacid' => $_W['uniacid']));
			}
			$user['address'] = $user['province'] . ' ' . $user['city'] . ' ' . $user['area'] . ' ' . $user['address'];
			$item['addressdata'] = array('realname' => $user['realname'], 'mobile' => $user['mobile'], 'address' => $user['address']);
		}
		load()->func('tpl');
		include $this->template('web/order/changeprice');
		exit();
	}
	else if ($to == 'confirmchangeprice') 
	{
		$changegoodsprice = $_GPC['changegoodsprice'];
		if (!is_array($changegoodsprice)) 
		{
			message('未找到改价内容!', '', 'error');
		}
		$changeprice = 0;
		foreach ($changegoodsprice as $ogid => $change ) 
		{
			$changeprice += floatval($change);
		}
		$dispatchprice = floatval($_GPC['changedispatchprice']);
		if ($dispatchprice < 0) 
		{
			$dispatchprice = 0;
		}
		$orderprice = $item['price'] + $changeprice;
		$changedispatchprice = 0;
		if ($dispatchprice != $item['dispatchprice']) 
		{
			$changedispatchprice = $dispatchprice - $item['dispatchprice'];
			$orderprice += $changedispatchprice;
		}
		if ($orderprice < 0) 
		{
			message('订单实际支付价格不能小于0元！', '', 'error');
		}
		foreach ($changegoodsprice as $ogid => $change ) 
		{
			$og = pdo_fetch('select price,realprice from ' . tablename('sz_yi_order_goods') . ' where id=:ogid and uniacid=:uniacid limit 1', array(':ogid' => $ogid, ':uniacid' => $_W['uniacid']));
			if (!empty($og)) 
			{
				$realprice = $og['realprice'] + $change;
				if ($realprice < 0) 
				{
					message('单个商品不能优惠到负数', '', 'error');
				}
			}
		}
		$ordersn2 = $item['ordersn2'] + 1;
		if (99 < $ordersn2) 
		{
			message('超过改价次数限额', '', 'error');
		}
		$orderupdate = array();
		if ($orderprice != $item['price']) 
		{
			$orderupdate['price'] = $orderprice;
			$orderupdate['ordersn2'] = $item['ordersn2'] + 1;
		}
		$orderupdate['changeprice'] = $item['changeprice'] + $changeprice;
		if ($dispatchprice != $item['dispatchprice']) 
		{
			$orderupdate['dispatchprice'] = $dispatchprice;
			$orderupdate['changedispatchprice'] += $changedispatchprice;
		}
		if (!empty($orderupdate)) 
		{
			pdo_update('sz_yi_order', $orderupdate, array('id' => $item['id'], 'uniacid' => $_W['uniacid']));
		}
		foreach ($changegoodsprice as $ogid => $change ) 
		{
			$og = pdo_fetch('select price,realprice,changeprice from ' . tablename('sz_yi_order_goods') . ' where id=:ogid and uniacid=:uniacid limit 1', array(':ogid' => $ogid, ':uniacid' => $_W['uniacid']));
			if (!empty($og)) 
			{
				$realprice = $og['realprice'] + $change;
				$changeprice = $og['changeprice'] + $change;
				pdo_update('sz_yi_order_goods', array('realprice' => $realprice, 'changeprice' => $changeprice), array('id' => $ogid));
			}
		}
		if (0 < abs($changeprice)) 
		{
			$pluginc = p('commission');
			if ($pluginc) 
			{
				$pluginc->calculate($item['id'], true);
			}
		}
		plog('order.op.changeprice', '订单号： ' . $item['ordersn'] . ' <br/> 价格： ' . $item['price'] . ' -> ' . $orderprice);
		message('订单改价成功!', referer(), 'success');
	}
	else if ($to == 'refundexpress') 
	{
		$flag = intval($_GPC['flag']);
		$refundid = $item['refundid'];
		if (!empty($refundid)) 
		{
			$refund = pdo_fetch('select * from ' . tablename('sz_yi_order_refund') . ' where id=:id and uniacid=:uniacid  limit 1', array(':id' => $refundid, ':uniacid' => $_W['uniacid']));
		}
		else 
		{
			exit('未找到退款申请.');
			exit();
		}
		if ($flag == 1) 
		{
			$express = trim($refund['express']);
			$expresssn = trim($refund['expresssn']);
		}
		else if ($flag == 2) 
		{
			$express = trim($refund['rexpress']);
			$expresssn = trim($refund['rexpresssn']);
		}
		$arr = getList($express, $expresssn);
		if (!$arr) 
		{
			$arr = getList($express, $expresssn);
			if (!$arr) 
			{
				exit('未找到物流信息.');
			}
		}
		$len = count($arr);
		$step1 = explode('<br />', str_replace('&middot;', '', $arr[0]));
		$step2 = explode('<br />', str_replace('&middot;', '', $arr[$len - 1]));
		$i = 0;
		while ($i < $len) 
		{
			if (strtotime(trim($step2[0])) < strtotime(trim($step1[0]))) 
			{
				$row = $arr[$i];
			}
			else 
			{
				$row = $arr[$len - $i - 1];
			}
			$step = explode('<br />', str_replace('&middot;', '', $row));
			$list[] = array('time' => trim($step[0]), 'step' => trim($step[1]), 'ts' => strtotime(trim($step[0])));
			++$i;
		}
		load()->func('tpl');
		include $this->template('web/order/express');
		exit();
	}
	else if ($to == 'express') 
	{
		$express = trim($item['express']);
		$expresssn = trim($item['expresssn']);
		$arr = getList($express, $expresssn);
		if (!$arr) 
		{
			$arr = getList($express, $expresssn);
			if (!$arr) 
			{
				exit('未找到物流信息.');
			}
		}
		$len = count($arr);
		$step1 = explode('<br />', str_replace('&middot;', '', $arr[0]));
		$step2 = explode('<br />', str_replace('&middot;', '', $arr[$len - 1]));
		$i = 0;
		while ($i < $len) 
		{
			if (strtotime(trim($step2[0])) < strtotime(trim($step1[0]))) 
			{
				$row = $arr[$i];
			}
			else 
			{
				$row = $arr[$len - $i - 1];
			}
			$step = explode('<br />', str_replace('&middot;', '', $row));
			$list[] = array('time' => trim($step[0]), 'step' => trim($step[1]), 'ts' => strtotime(trim($step[0])));
			++$i;
		}
		load()->func('tpl');
		include $this->template('web/order/express');
		exit();
	}
	exit();
}
function sortByTime($zym_var_10, $zym_var_11) 
{
	if ($zym_var_10['ts'] == $zym_var_11['ts']) 
	{
		return 0;
	}
	return ($zym_var_11['ts'] < $zym_var_10['ts'] ? 1 : -1);
}
function getList($zym_var_12, $zym_var_15) 
{
	$_obfuscate_DVsTGRsUAjwaFwUCKA0yJgQSPDgYJQE = 'http://wap.kuaidi100.com/wap_result.jsp?rand=' . time() . '&id=' . $zym_var_12 . '&fromWeb=null&postid=' . $zym_var_15;
	load()->func('communication');
	$_obfuscate_DSoHwczCA8IDRUoPwwqFz49Hi0qHQE = ihttp_request($_obfuscate_DVsTGRsUAjwaFwUCKA0yJgQSPDgYJQE);
	$_obfuscate_DQg2GyUoNgYQMggONSUaP1sbGhBcCiI = $_obfuscate_DSoHwczCA8IDRUoPwwqFz49Hi0qHQE['content'];
	if (empty($_obfuscate_DQg2GyUoNgYQMggONSUaP1sbGhBcCiI)) 
	{
		return array();
	}
	preg_match_all('/\\<p\\>&middot;(.*)\\<\\/p\\>/U', $_obfuscate_DQg2GyUoNgYQMggONSUaP1sbGhBcCiI, $_obfuscate_DSoMCC8Gy8KBC4NOzYsBRIfDhkvFiI);
	if (!isset($_obfuscate_DSoMCC8Gy8KBC4NOzYsBRIfDhkvFiI[1])) 
	{
		return false;
	}
	return $_obfuscate_DSoMCC8Gy8KBC4NOzYsBRIfDhkvFiI[1];
}
function changeWechatSend($zym_var_2, $zym_var_4, $zym_var_1 = '') 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ4wDCcXLQoUJCUaESgQJB8XMzAXMiI = pdo_fetch('SELECT plid, openid, tag FROM ' . tablename('core_paylog') . ' WHERE tid = \'' . $zym_var_2 . '\' AND status = 1 AND type = \'wechat\'');
	if (!empty($_obfuscate_DQ4wDCcXLQoUJCUaESgQJB8XMzAXMiI['openid'])) 
	{
		$_obfuscate_DQ4wDCcXLQoUJCUaESgQJB8XMzAXMiI['tag'] = iunserializer($_obfuscate_DQ4wDCcXLQoUJCUaESgQJB8XMzAXMiI['tag']);
		$_obfuscate_DRQbQDUbMx8SPSMcH0AGWzsjOzAhBTI = $_obfuscate_DQ4wDCcXLQoUJCUaESgQJB8XMzAXMiI['tag']['acid'];
		load()->model('account');
		$_obfuscate_DQ0LFAsoFAkLBTQDEQECgoQES8FDDI = account_fetch($_obfuscate_DRQbQDUbMx8SPSMcH0AGWzsjOzAhBTI);
		$_obfuscate_DTg9JkAEOSUJIkAfFD0CGSU3L1wWBjI = uni_setting($_obfuscate_DQ0LFAsoFAkLBTQDEQECgoQES8FDDI['uniacid'], 'payment');
		if ($_obfuscate_DTg9JkAEOSUJIkAfFD0CGSU3L1wWBjI['payment']['wechat']['version'] == '2') 
		{
			return true;
		}
		$_obfuscate_DQguFj8eCQkMAMqEQJbJzYVMBsDPQE = array('appid' => $_obfuscate_DQ0LFAsoFAkLBTQDEQECgoQES8FDDI['key'], 'openid' => $_obfuscate_DQ4wDCcXLQoUJCUaESgQJB8XMzAXMiI['openid'], 'transid' => $_obfuscate_DQ4wDCcXLQoUJCUaESgQJB8XMzAXMiI['tag']['transaction_id'], 'out_trade_no' => $_obfuscate_DQ4wDCcXLQoUJCUaESgQJB8XMzAXMiI['plid'], 'deliver_timestamp' => TIMESTAMP, 'deliver_status' => $zym_var_4, 'deliver_msg' => $zym_var_1);
		$_obfuscate_DQsUDjMmPS0iEh0XHQQ3CgEiKQU_JhE = $_obfuscate_DQguFj8eCQkMAMqEQJbJzYVMBsDPQE;
		$_obfuscate_DQsUDjMmPS0iEh0XHQQ3CgEiKQU_JhE['appkey'] = $_obfuscate_DTg9JkAEOSUJIkAfFD0CGSU3L1wWBjI['payment']['wechat']['signkey'];
		ksort($_obfuscate_DQsUDjMmPS0iEh0XHQQ3CgEiKQU_JhE);
		$_obfuscate_DQE4NDcPJisTWyo3QAc8Kh8MPg4fOwE = '';
		foreach ($_obfuscate_DQsUDjMmPS0iEh0XHQQ3CgEiKQU_JhE as $_obfuscate_DRU9Jh8hIgYdJhIJPgkTHVs8JAc8DBE => $_obfuscate_DRMeFzIDNDJbFj05Fy00BBQTFDY0LwE ) 
		{
			$_obfuscate_DRU9Jh8hIgYdJhIJPgkTHVs8JAc8DBE = strtolower($_obfuscate_DRU9Jh8hIgYdJhIJPgkTHVs8JAc8DBE);
			$_obfuscate_DQE4NDcPJisTWyo3QAc8Kh8MPg4fOwE .= $_obfuscate_DRU9Jh8hIgYdJhIJPgkTHVs8JAc8DBE . '=' . $_obfuscate_DRMeFzIDNDJbFj05Fy00BBQTFDY0LwE . '&';
		}
		$_obfuscate_DQguFj8eCQkMAMqEQJbJzYVMBsDPQE['app_signature'] = sha1(rtrim($_obfuscate_DQE4NDcPJisTWyo3QAc8Kh8MPg4fOwE, '&'));
		$_obfuscate_DQguFj8eCQkMAMqEQJbJzYVMBsDPQE['sign_method'] = 'sha1';
		$_obfuscate_DQ0LFAsoFAkLBTQDEQECgoQES8FDDI = WeAccount::create($_obfuscate_DRQbQDUbMx8SPSMcH0AGWzsjOzAhBTI);
		$_obfuscate_DR02FBsnORceKCgiKD8WJCcxJjY4HwE = $_obfuscate_DQ0LFAsoFAkLBTQDEQECgoQES8FDDI->changeOrderStatus($_obfuscate_DQguFj8eCQkMAMqEQJbJzYVMBsDPQE);
		if (is_error($_obfuscate_DR02FBsnORceKCgiKD8WJCcxJjY4HwE)) 
		{
			message($_obfuscate_DR02FBsnORceKCgiKD8WJCcxJjY4HwE['message']);
		}
	}
}
function order_list_backurl() 
{
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	return ($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['op'] == 'detail' ? $this->createWebUrl('order') : referer());
}
function order_list_confirmsend($order) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	ca('order.op.send');
	if (empty($order['addressid'])) 
	{
		message('无收货地址，无法发货！');
	}
	if ($order['paytype'] != 3) 
	{
		if ($order['status'] != 1) 
		{
			message('订单未付款，无法发货！');
		}
	}
	if (!empty($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['isexpress']) && empty($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['expresssn'])) 
	{
		message('请输入快递单号！');
	}
	if (!empty($order['transid'])) 
	{
		changewechatsend($order['ordersn'], 1);
	}
	pdo_update('sz_yi_order', array('status' => 2, 'express' => trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['express']), 'expresscom' => trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['expresscom']), 'expresssn' => trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['expresssn']), 'sendtime' => time()), array('id' => $order['id'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
	if (!empty($order['refundid'])) 
	{
		$_obfuscate_DSMHBy0aBDwtCz4ZCDgPJiwbEhAjMAE = pdo_fetch('select * from ' . tablename('sz_yi_order_refund') . ' where id=:id limit 1', array(':id' => $order['refundid']));
		if (!empty($_obfuscate_DSMHBy0aBDwtCz4ZCDgPJiwbEhAjMAE)) 
		{
			pdo_update('sz_yi_order_refund', array('status' => -1), array('id' => $order['refundid']));
			pdo_update('sz_yi_order', array('refundid' => 0), array('id' => $order['id']));
		}
	}
	m('notice')->sendOrderMessage($order['id']);
	plog('order.op.send', '订单发货 ID: ' . $order['id'] . ' 订单号: ' . $order['ordersn'] . ' <br/>快递公司: ' . $_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['expresscom'] . ' 快递单号: ' . $_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['expresssn']);
	message('发货操作成功！', order_list_backurl(), 'success');
}
function order_list_confirmsend1($order) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	ca('order.op.fetch');
	if ($order['status'] != 1) 
	{
		message('订单未付款，无法确认取货！');
	}
	$_obfuscate_DTksBiEXAQUTJiQ9HxkMJwo7PwEGDTI = time();
	$_obfuscate_DQQ8EQEHXAIoGB0uCDwoBjEZFighMQE = array('status' => 3, 'sendtime' => $_obfuscate_DTksBiEXAQUTJiQ9HxkMJwo7PwEGDTI, 'finishtime' => $_obfuscate_DTksBiEXAQUTJiQ9HxkMJwo7PwEGDTI);
	if ($order['isverify'] == 1) 
	{
		$_obfuscate_DQQ8EQEHXAIoGB0uCDwoBjEZFighMQE['verified'] = 1;
		$_obfuscate_DQQ8EQEHXAIoGB0uCDwoBjEZFighMQE['verifytime'] = $_obfuscate_DTksBiEXAQUTJiQ9HxkMJwo7PwEGDTI;
		$_obfuscate_DQQ8EQEHXAIoGB0uCDwoBjEZFighMQE['verifyopenid'] = '';
	}
	pdo_update('sz_yi_order', $_obfuscate_DQQ8EQEHXAIoGB0uCDwoBjEZFighMQE, array('id' => $order['id'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
	if (!empty($order['refundid'])) 
	{
		$_obfuscate_DSMHBy0aBDwtCz4ZCDgPJiwbEhAjMAE = pdo_fetch('select * from ' . tablename('sz_yi_order_refund') . ' where id=:id limit 1', array(':id' => $order['refundid']));
		if (!empty($_obfuscate_DSMHBy0aBDwtCz4ZCDgPJiwbEhAjMAE)) 
		{
			pdo_update('sz_yi_order_refund', array('status' => -1), array('id' => $order['refundid']));
			pdo_update('sz_yi_order', array('refundid' => 0), array('id' => $order['id']));
		}
	}
	m('member')->upgradeLevel($order['openid']);
	m('notice')->sendOrderMessage($order['id']);
	if (p('commission')) 
	{
		p('commission')->checkOrderFinish($order['id']);
	}
	if (p('return')) 
	{
		p('return')->cumulative_order_amount($order['id']);
	}
	plog('order.op.fetch', '订单确认取货 ID: ' . $order['id'] . ' 订单号: ' . $order['ordersn']);
	message('发货操作成功！', order_list_backurl(), 'success');
}
function order_list_cancelsend($order) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	ca('order.op.sendcancel');
	if ($order['status'] != 2) 
	{
		message('订单未发货，不需取消发货！');
	}
	if (!empty($order['transid'])) 
	{
		changewechatsend($order['ordersn'], 0, $_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['cancelreson']);
	}
	pdo_update('sz_yi_order', array('status' => 1, 'sendtime' => 0), array('id' => $order['id'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
	plog('order.op.sencancel', '订单取消发货 ID: ' . $order['id'] . ' 订单号: ' . $order['ordersn']);
	message('取消发货操作成功！', order_list_backurl(), 'success');
}
function order_list_cancelsend1($order) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	ca('order.op.fetchcancel');
	if ($order['status'] != 3) 
	{
		message('订单未取货，不需取消！');
	}
	pdo_update('sz_yi_order', array('status' => 1, 'finishtime' => 0), array('id' => $order['id'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
	plog('order.op.fetchcancel', '订单取消取货 ID: ' . $order['id'] . ' 订单号: ' . $order['ordersn']);
	message('取消发货操作成功！', order_list_backurl(), 'success');
}
function order_list_finish($order) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	ca('order.op.finish');
	pdo_update('sz_yi_order', array('status' => 3, 'finishtime' => time()), array('id' => $order['id'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
	m('member')->upgradeLevel($order['openid']);
	m('notice')->sendOrderMessage($order['id']);
	if (p('coupon') && !empty($order['couponid'])) 
	{
		p('coupon')->backConsumeCoupon($order['id']);
	}
	if (p('commission')) 
	{
		p('commission')->checkOrderFinish($order['id']);
	}
	if (p('return')) 
	{
		p('return')->cumulative_order_amount($order['id']);
	}
	if (0 < $order['redprice']) 
	{
		m('finance')->sendredpack($order['openid'], $order['redprice'] * 100, $order['id'], $_obfuscate_DSoNKCMJIgdAOCQuDgM8BDgBDQsfAhE = '购买商品赠送红包', $_obfuscate_DRYbDzAGCCgpGCIYAw0tLAwbNQ43KSI = '购买商品赠送红包', $_obfuscate_DRsVCx0cQBEcFjUbFAwhBQUCFz0pLQE = '购买商品确认收货发送红包');
	}
	plog('order.op.finish', '订单完成 ID: ' . $order['id'] . ' 订单号: ' . $order['ordersn']);
	message('订单操作成功！', order_list_backurl(), 'success');
}
function order_list_redpack($order) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	if (empty($order['redstatus'])) 
	{
		message('红包已发送，不可重复发送！');
	}
	if (0 < $order['redprice']) 
	{
		if ((1 <= $order['redprice']) && ($order['redprice'] <= 200)) 
		{
			$_obfuscate_DRAPiQUHAwKLT0XKT0bMQwSAjguOTI = m('finance')->sendredpack($order['openid'], $order['redprice'] * 100, $order['id'], $_obfuscate_DSoNKCMJIgdAOCQuDgM8BDgBDQsfAhE = '购买商品赠送红包', $_obfuscate_DRYbDzAGCCgpGCIYAw0tLAwbNQ43KSI = '购买商品赠送红包', $_obfuscate_DRsVCx0cQBEcFjUbFAwhBQUCFz0pLQE = '购买商品确认收货发送红包');
			if (is_error($_obfuscate_DRAPiQUHAwKLT0XKT0bMQwSAjguOTI)) 
			{
				message($_obfuscate_DRAPiQUHAwKLT0XKT0bMQwSAjguOTI['message'], '', 'error');
				return NULL;
			}
			pdo_update('sz_yi_order', array('redstatus' => ''), array('id' => $order['id']));
			message('红包补发成功！', order_list_backurl(), 'success');
			return NULL;
		}
		message('红包金额错误！发送失败！红包金额在1-200元之间！');
	}
}
function order_list_cancelpay($order) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	ca('order.op.paycancel');
	if ($order['status'] != 1) 
	{
		message('订单未付款，不需取消！');
	}
	m('order')->setStocksAndCredits($order['id'], 2);
	pdo_update('sz_yi_order', array('status' => 0, 'cancelpaytime' => time()), array('id' => $order['id'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
	plog('order.op.paycancel', '订单取消付款 ID: ' . $order['id'] . ' 订单号: ' . $order['ordersn']);
	message('取消订单付款操作成功！', order_list_backurl(), 'success');
}
function order_list_confirmpay($order) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	ca('order.op.pay');
	if (1 < $order['status']) 
	{
		message('订单已付款，不需重复付款！');
	}
	$_obfuscate_DQUyKycfFAoJPx0LIw4KCT01JR82NjI = p('virtual');
	if (!empty($order['virtual']) && $_obfuscate_DQUyKycfFAoJPx0LIw4KCT01JR82NjI) 
	{
		$_obfuscate_DQUyKycfFAoJPx0LIw4KCT01JR82NjI->pay($order);
	}
	else 
	{
		$_obfuscate_DT0fPQwrPT0_BTIVKA4wOwM9BBMRBCI = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':module' => 'sz_yi', ':tid' => $order['ordersn']));
		pdo_update('sz_yi_order', array('paytype' => '11'), array('uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], 'id' => $order['id']));
		$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI = array();
		$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI['result'] = 'success';
		$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI['from'] = 'return';
		$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI['tid'] = $_obfuscate_DT0fPQwrPT0_BTIVKA4wOwM9BBMRBCI['tid'];
		$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI['user'] = $order['openid'];
		$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI['fee'] = $order['price'];
		$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI['weid'] = $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'];
		$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI['uniacid'] = $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'];
		$_obfuscate_DSsvGUARDgsBNDIzOD8sM1wSGQsQHAE = m('order')->payResult($_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI);
	}
	plog('order.op.pay', '订单确认付款 ID: ' . $order['id'] . ' 订单号: ' . $order['ordersn']);
	message('确认订单付款操作成功！', order_list_backurl(), 'success');
}
function order_list_close($order) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	ca('order.op.close');
	if ($order['status'] == -1) 
	{
		message('订单已关闭，无需重复关闭！');
	}
	else if (1 <= $order['status']) 
	{
		message('订单已付款，不能关闭！');
	}
	if (!empty($order['transid'])) 
	{
		changewechatsend($order['ordersn'], 0, $_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['reson']);
	}
	$_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE = time();
	if ((0 < $order['refundstate']) && !empty($order['refundid'])) 
	{
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array();
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['status'] = -1;
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['refundtime'] = $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE;
		pdo_update('sz_yi_order_refund', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI, array('id' => $order['refundid'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
	}
	pdo_update('sz_yi_order', array('status' => -1, 'refundstate' => 0, 'canceltime' => time(), 'remark' => $order['remark'] . '' . $_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['remark']), array('id' => $order['id'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
	if (0 < $order['deductcredit']) 
	{
		$_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE = m('common')->getSysset('shop');
		m('member')->setCredit($order['openid'], 'credit1', $order['deductcredit'], array('0', $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '购物返还抵扣积分 积分: ' . $order['deductcredit'] . ' 抵扣金额: ' . $order['deductprice'] . ' 订单号: ' . $order['ordersn']));
	}
	if (p('coupon') && !empty($order['couponid'])) 
	{
		p('coupon')->returnConsumeCoupon($order['id']);
	}
	plog('order.op.close', '订单关闭 ID: ' . $order['id'] . ' 订单号: ' . $order['ordersn']);
	message('订单关闭操作成功！', order_list_backurl(), 'success');
}
function order_list_refund($item) 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	ca('order.op.refund');
	$_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE = m('common')->getSysset('shop');
	if (empty($item['refundstate'])) 
	{
		message('订单未申请退款，不需处理！');
	}
	$_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE = pdo_fetch('select * from ' . tablename('sz_yi_order_refund') . ' where id=:id and (status=0 or status>1) order by id desc limit 1', array(':id' => $item['refundid']));
	if (empty($_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE)) 
	{
		pdo_update('sz_yi_order', array('refundstate' => 0), array('id' => $item['id'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
		message('未找到退款申请，不需处理！');
	}
	if (empty($_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['refundno'])) 
	{
		$_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['refundno'] = m('common')->createNO('order_refund', 'refundno', 'SR');
		pdo_update('sz_yi_order_refund', array('refundno' => $_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['refundno']), array('id' => $_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['id']));
	}
	$_obfuscate_DRo5ARo7ECY0JBgOFQ5cBRAYAyMXKRE = intval($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['refundstatus']);
	$_obfuscate_DQgRFgQHPiwSPAg5NQsiFyEtGQc0OQE = trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['refundcontent']);
	$_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE = time();
	$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array();
	$_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE = $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'];
	if ($_obfuscate_DRo5ARo7ECY0JBgOFQ5cBRAYAyMXKRE == 0) 
	{
		message('暂不处理', referer());
	}
	else if ($_obfuscate_DRo5ARo7ECY0JBgOFQ5cBRAYAyMXKRE == 3) 
	{
		$_obfuscate_DQw4GiI8PA1bNSEGz87HA8fHDwYOQE = $_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['raid'];
		$_obfuscate_DRw2Cxk1JTkaQBQjMSEHEyIZGCYbNyI = trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['message']);
		if ($_obfuscate_DQw4GiI8PA1bNSEGz87HA8fHDwYOQE == 0) 
		{
			$_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI = pdo_fetch('select * from ' . tablename('sz_yi_refund_address') . ' where isdefault=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
		}
		else 
		{
			$_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI = pdo_fetch('select * from ' . tablename('sz_yi_refund_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $_obfuscate_DQw4GiI8PA1bNSEGz87HA8fHDwYOQE, ':uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
		}
		if (empty($_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI)) 
		{
			$_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI = pdo_fetch('select * from ' . tablename('sz_yi_refund_address') . ' where uniacid=:uniacid order by id desc limit 1', array(':uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
		}
		unset($_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI['uniacid']);
		unset($_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI['openid']);
		unset($_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI['isdefault']);
		unset($_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI['deleted']);
		$_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI = iserializer($_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI);
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['reply'] = '';
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['refundaddress'] = $_obfuscate_DRwHKB8cCg49Kg0eFy0cGwYdHD5bPDI;
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['refundaddressid'] = $_obfuscate_DQw4GiI8PA1bNSEGz87HA8fHDwYOQE;
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['message'] = $_obfuscate_DRw2Cxk1JTkaQBQjMSEHEyIZGCYbNyI;
		if (empty($_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['operatetime'])) 
		{
			$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['operatetime'] = $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE;
		}
		if ($_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['status'] != 4) 
		{
			$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['status'] = 3;
		}
		pdo_update('sz_yi_order_refund', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI, array('id' => $item['refundid']));
		m('notice')->sendOrderMessage($item['id'], true);
	}
	else if ($_obfuscate_DRo5ARo7ECY0JBgOFQ5cBRAYAyMXKRE == 5) 
	{
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['rexpress'] = $_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['rexpress'];
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['rexpresscom'] = $_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['rexpresscom'];
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['rexpresssn'] = trim($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['rexpresssn']);
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['status'] = 5;
		if (($_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['status'] != 5) && empty($_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['returntime'])) 
		{
			$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['returntime'] = $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE;
		}
		pdo_update('sz_yi_order_refund', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI, array('id' => $item['refundid']));
		m('notice')->sendOrderMessage($item['id'], true);
	}
	else if ($_obfuscate_DRo5ARo7ECY0JBgOFQ5cBRAYAyMXKRE == 10) 
	{
		$_obfuscate_DT8QMTIwBzImAiIRB1wRGC4MBwcqBwE['status'] = 1;
		$_obfuscate_DT8QMTIwBzImAiIRB1wRGC4MBwcqBwE['refundtime'] = $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE;
		pdo_update('sz_yi_order_refund', $_obfuscate_DT8QMTIwBzImAiIRB1wRGC4MBwcqBwE, array('id' => $item['refundid'], 'uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
		$_obfuscate_DSsvGzkOQD4eCyoMTgELxsiOz4HMCI = array();
		$_obfuscate_DSsvGzkOQD4eCyoMTgELxsiOz4HMCI['refundstate'] = 0;
		$_obfuscate_DSsvGzkOQD4eCyoMTgELxsiOz4HMCI['status'] = 1;
		$_obfuscate_DSsvGzkOQD4eCyoMTgELxsiOz4HMCI['refundtime'] = $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE;
		pdo_update('sz_yi_order', $_obfuscate_DSsvGzkOQD4eCyoMTgELxsiOz4HMCI, array('id' => $item['id'], 'uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
		m('notice')->sendOrderMessage($item['id'], true);
	}
	else if ($_obfuscate_DRo5ARo7ECY0JBgOFQ5cBRAYAyMXKRE == 1) 
	{
		$_obfuscate_DTUQOSQNKRoLOR0lEhQwKRQ5AiE9NRE = $item['ordersn'];
		if (!empty($item['ordersn2'])) 
		{
			$_obfuscate_DR8xNCo2NhsqJRQ5AikNNC0vAz0BEhE = sprintf('%02d', $item['ordersn2']);
			$_obfuscate_DTUQOSQNKRoLOR0lEhQwKRQ5AiE9NRE .= 'GJ' . $_obfuscate_DR8xNCo2NhsqJRQ5AikNNC0vAz0BEhE;
		}
		$_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE = $_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['applyprice'];
		$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = pdo_fetchall('SELECT g.id,g.credit, o.total,o.realprice FROM ' . tablename('sz_yi_order_goods') . ' o left join ' . tablename('sz_yi_goods') . ' g on o.goodsid=g.id ' . ' WHERE o.orderid=:orderid and o.uniacid=:uniacid', array(':orderid' => $item['id'], ':uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
		$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE = 0;
		foreach ($_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE as $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE ) 
		{
			$_obfuscate_DSo0Ajw4Mi4EKwwZXAw_GAkrDwhcGhE = trim($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['credit']);
			if (!empty($_obfuscate_DSo0Ajw4Mi4EKwwZXAw_GAkrDwhcGhE)) 
			{
				if (strexists($_obfuscate_DSo0Ajw4Mi4EKwwZXAw_GAkrDwhcGhE, '%')) 
				{
					$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE += intval((floatval(str_replace('%', '', $_obfuscate_DSo0Ajw4Mi4EKwwZXAw_GAkrDwhcGhE)) / 100) * $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['realprice']);
				}
				else 
				{
					$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE += intval($_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['credit']) * $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['total'];
				}
			}
		}
		$_obfuscate_DRELHhYuAj43XDsONB0XAScPEAgFKDI = 0;
		if ($item['paytype'] == 1) 
		{
			m('member')->setCredit($item['openid'], 'credit2', $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE, array(0, $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '退款: ' . $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE . '元 订单号: ' . $item['ordersn']));
			$_obfuscate_DRAPiQUHAwKLT0XKT0bMQwSAjguOTI = true;
		}
		else if ($item['paytype'] == 21) 
		{
			$_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE = round($_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE - $item['deductcredit2'], 2);
			$_obfuscate_DRAPiQUHAwKLT0XKT0bMQwSAjguOTI = m('finance')->refund($item['openid'], $_obfuscate_DTUQOSQNKRoLOR0lEhQwKRQ5AiE9NRE, $_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['refundno'], $item['price'] * 100, $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE * 100);
			$_obfuscate_DRELHhYuAj43XDsONB0XAScPEAgFKDI = 2;
		}
		else 
		{
			if ($_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE < 1) 
			{
				message('退款金额必须大于1元，才能使用微信企业付款退款!', '', 'error');
			}
			$_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE = round($_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE - $item['deductcredit2'], 2);
			$_obfuscate_DRAPiQUHAwKLT0XKT0bMQwSAjguOTI = m('finance')->pay($item['openid'], 1, $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE * 100, $_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['refundno'], $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '退款: ' . $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE . '元 订单号: ' . $item['ordersn']);
			$_obfuscate_DRELHhYuAj43XDsONB0XAScPEAgFKDI = 1;
		}
		if (is_error($_obfuscate_DRAPiQUHAwKLT0XKT0bMQwSAjguOTI)) 
		{
			message($_obfuscate_DRAPiQUHAwKLT0XKT0bMQwSAjguOTI['message'], '', 'error');
		}
		if (0 < $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE) 
		{
			m('member')->setCredit($item['openid'], 'credit1', -$_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE, array(0, $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '退款扣除积分: ' . $_obfuscate_DTgkLSMFNg4YMRYDNCETBxQHgk9JgE . ' 订单号: ' . $item['ordersn']));
		}
		if (0 < $item['deductcredit']) 
		{
			m('member')->setCredit($item['openid'], 'credit1', $item['deductcredit'], array('0', $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '购物返还抵扣积分 积分: ' . $item['deductcredit'] . ' 抵扣金额: ' . $item['deductprice'] . ' 订单号: ' . $item['ordersn']));
		}
		if (!empty($_obfuscate_DRELHhYuAj43XDsONB0XAScPEAgFKDI)) 
		{
			if (0 < $item['deductcredit2']) 
			{
				m('member')->setCredit($item['openid'], 'credit2', $item['deductcredit2'], array('0', $_obfuscate_DScFCikkIiU7AhUiByYIFFwFMB0lCAE['name'] . '购物返还抵扣余额 积分: ' . $item['deductcredit2'] . ' 订单号: ' . $item['ordersn']));
			}
		}
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['reply'] = '';
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['status'] = 1;
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['refundtype'] = $_obfuscate_DRELHhYuAj43XDsONB0XAScPEAgFKDI;
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['price'] = $_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE;
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['refundtime'] = $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE;
		pdo_update('sz_yi_order_refund', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI, array('id' => $item['refundid']));
		m('notice')->sendOrderMessage($item['id'], true);
		pdo_update('sz_yi_order', array('refundstate' => 0, 'status' => -1, 'refundtime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), array('id' => $item['id'], 'uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
		foreach ($_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE as $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE ) 
		{
			$_obfuscate_DQEhPDkIAxgLPwoQOy8YW1wvMjErCTI = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where og.goodsid=:goodsid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':goodsid' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['id'], ':uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
			pdo_update('sz_yi_goods', array('salesreal' => $_obfuscate_DQEhPDkIAxgLPwoQOy8YW1wvMjErCTI), array('id' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['id']));
		}
		plog('order.op.refund', '订单退款 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn']);
	}
	else if ($_obfuscate_DRo5ARo7ECY0JBgOFQ5cBRAYAyMXKRE == -1) 
	{
		pdo_update('sz_yi_order_refund', array('reply' => $_obfuscate_DQgRFgQHPiwSPAg5NQsiFyEtGQc0OQE, 'status' => -1), array('id' => $item['refundid']));
		m('notice')->sendOrderMessage($item['id'], true);
		plog('order.op.refund', '订单退款拒绝 ID: ' . $item['id'] . ' 订单号: ' . $item['ordersn'] . ' 原因: ' . $_obfuscate_DQgRFgQHPiwSPAg5NQsiFyEtGQc0OQE);
		pdo_update('sz_yi_order', array('refundstate' => 0), array('id' => $item['id'], 'uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
	}
	else if ($_obfuscate_DRo5ARo7ECY0JBgOFQ5cBRAYAyMXKRE == 2) 
	{
		$_obfuscate_DRELHhYuAj43XDsONB0XAScPEAgFKDI = 2;
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['reply'] = '';
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['status'] = 1;
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['refundtype'] = $_obfuscate_DRELHhYuAj43XDsONB0XAScPEAgFKDI;
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['price'] = $_obfuscate_DSM9BRoMBRkRHhYbBhEVHRYpJSIpMQE['applyprice'];
		$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI['refundtime'] = $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE;
		pdo_update('sz_yi_order_refund', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI, array('id' => $item['refundid']));
		m('notice')->sendOrderMessage($item['id'], true);
		pdo_update('sz_yi_order', array('refundstate' => 0, 'status' => -1, 'refundtime' => $_obfuscate_DS4ZBg8YNxwUCRQBHAkGQMILjEaIxE), array('id' => $item['id'], 'uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
		$_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE = pdo_fetchall('SELECT g.id,g.credit, o.total,o.realprice FROM ' . tablename('sz_yi_order_goods') . ' o left join ' . tablename('sz_yi_goods') . ' g on o.goodsid=g.id ' . ' WHERE o.orderid=:orderid and o.uniacid=:uniacid', array(':orderid' => $item['id'], ':uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
		foreach ($_obfuscate_DSMmAg4LMFs5IQM0MzQvJhgPKzQaKxE as $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE ) 
		{
			$_obfuscate_DQEhPDkIAxgLPwoQOy8YW1wvMjErCTI = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('sz_yi_order_goods') . ' og ' . ' left join ' . tablename('sz_yi_order') . ' o on o.id = og.orderid ' . ' where og.goodsid=:goodsid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':goodsid' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['id'], ':uniacid' => $_obfuscate_DSQbODQUQC8LI0ASLSgMWyMoPQ9cGwE));
			pdo_update('sz_yi_goods', array('salesreal' => $_obfuscate_DQEhPDkIAxgLPwoQOy8YW1wvMjErCTI), array('id' => $_obfuscate_DQ0tJj4RMzAGFh0sIx49GzMyITIyGAE['id']));
		}
	}
	message('退款申请处理成功!', order_list_backurl(), 'success');
}
?>