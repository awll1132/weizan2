<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
define('TM_SUPPLIER_PAY', 'supplier_pay');
if (!class_exists('SupplierModel')) 
{
	class SupplierModel extends PluginModel 
	{
		public function getSupplierMerchants($uid) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			if (empty($uid)) 
			{
				return '';
			}
			$_obfuscate_DSNAEQw1OyI_FicjLDkrPw07ETEbPxE = pdo_fetchall('select * from ' . tablename('sz_yi_merchants') . ' where uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . ' and supplier_uid=' . $uid);
			foreach ($_obfuscate_DSNAEQw1OyI_FicjLDkrPw07ETEbPxE as &$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
			{
				$_obfuscate_DRNANQcmHg0TLi0MKRMDHREoERciMiI = m('member')->getMember($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['openid']);
				$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['avatar'] = $_obfuscate_DRNANQcmHg0TLi0MKRMDHREoERciMiI['avatar'];
				$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['nickname'] = $_obfuscate_DRNANQcmHg0TLi0MKRMDHREoERciMiI['nickname'];
				$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['realname'] = $_obfuscate_DRNANQcmHg0TLi0MKRMDHREoERciMiI['realname'];
				$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['mobile'] = $_obfuscate_DRNANQcmHg0TLi0MKRMDHREoERciMiI['mobile'];
			}
			unset($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE);
			return $_obfuscate_DSNAEQw1OyI_FicjLDkrPw07ETEbPxE;
		}
		public function getRoleId() 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DQQMLAk_MicbMj4jOyICOQwlKT4BDiI = pdo_fetchcolumn('select id from ' . tablename('sz_yi_perm_role') . ' where status1=1');
			return $_obfuscate_DQQMLAk_MicbMj4jOyICOQwlKT4BDiI;
		}
		public function getSupplierInfo($uid) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE = array();
			$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['ordercount'] = 0;
			$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['commission_total'] = 0;
			$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['costmoney'] = 0;
			$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['totalmoney'] = 0;
			$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['ordercount'] = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_order') . ' where supplier_uid=' . $uid . ' and userdeleted=0 and deleted=0 and uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . ' ');
			$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['commission_total'] = number_format(pdo_fetchcolumn('select sum(apply_money) from ' . tablename('sz_yi_supplier_apply') . ' where uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . ' and uid=' . $uid . ' and status=1'), 2);
			$_obfuscate_DTMTDxAwEBkUMR4uMSsLBQoICC8FGTI = pdo_fetchall('select og.* from ' . tablename('sz_yi_order_goods') . ' og left join ' . tablename('sz_yi_order') . ' o on (o.id=og.orderid) where og.uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . ' and og.supplier_uid=' . $uid . ' and o.status=3 and og.supplier_apply_status=0');
			foreach ($_obfuscate_DTMTDxAwEBkUMR4uMSsLBQoICC8FGTI as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
			{
				if (0 < $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['goods_op_cost_price']) 
				{
					$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['costmoney'] += $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['goods_op_cost_price'] * $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['total'];
				}
				else 
				{
					$_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI = pdo_fetch('select * from ' . tablename('sz_yi_goods_option') . ' where uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . ' and goodsid=' . $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['goodsid'] . ' and id=' . $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['optionid']);
					if (0 < $_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI['costprice']) 
					{
						$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['costmoney'] += $_obfuscate_DRAaGyhcHRkSJAwnKCkRDxAIEyoWHjI['costprice'] * $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['total'];
					}
					else 
					{
						$_obfuscate_DSY8HQUyMRcoMjkwKj0tLjMsJiQyMgE = pdo_fetch('select * from' . tablename('sz_yi_goods') . ' where uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . ' and id=' . $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['goodsid']);
						$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['costmoney'] += $_obfuscate_DSY8HQUyMRcoMjkwKj0tLjMsJiQyMgE['costprice'] * $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['total'];
					}
				}
			}
			$_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE['totalmoney'] = pdo_fetchcolumn('select sum(apply_money) from ' . tablename('sz_yi_supplier_apply') . ' where uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . ' and uid=' . $uid);
			return $_obfuscate_DTQvFjcrLh4lWxAhETYVCRslMAszDAE;
		}
		public function getSupplierUidAndUsername($openid) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DT4QPzQRNTsnITMcDDshBSozIzgdCTI = pdo_fetch('select uid,username from ' . tablename('sz_yi_perm_user') . ' where openid=\'' . $openid . '\' and uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
			return $_obfuscate_DT4QPzQRNTsnITMcDDshBSozIzgdCTI;
		}
		public function isSupplier($openid) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DVwxGDlAJwwGGFs9Mj09PA8KLyYaEwE = pdo_fetch('select * from ' . tablename('sz_yi_perm_user') . ' where openid=\'' . $openid . '\' and uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'] . ' and roleid=(select id from ' . tablename('sz_yi_perm_role') . ' where status1=1)');
			return $_obfuscate_DVwxGDlAJwwGGFs9Mj09PA8KLyYaEwE;
		}
		public function getSupplierPermId() 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DRYEgMBIxAFCxsDOxEfDxAyLxs5KAE = pdo_fetch('select * from ' . tablename('sz_yi_perm_role') . ' where status1 = 1');
			$_obfuscate_DS08CDcrOzcfHh8wHg8PEgcHECUYDCI = 'shop,shop.goods,shop.goods.view,shop.goods.add,shop.goods.edit,shop.goods.delete,order,order.view,order.view.status_1,order.view.status0,order.view.status1,order.view.status2,order.view.status3,order.view.status4,order.view.status5,order.view.status9,order.op,order.op.pay,order.op.send,order.op.sendcancel,order.op.finish,order.op.verify,order.op.fetch,order.op.close,order.op.refund,order.op.export,order.op.changeprice,exhelper,exhelper.print,exhelper.print.single,exhelper.print.more,exhelper.exptemp1,exhelper.exptemp1.view,exhelper.exptemp1.add,exhelper.exptemp1.edit,exhelper.exptemp1.delete,exhelper.exptemp1.setdefault,exhelper.exptemp2,exhelper.exptemp2.view,exhelper.exptemp2.add,exhelper.exptemp2.edit,exhelper.exptemp2.delete,exhelper.exptemp2.setdefault,exhelper.senduser,exhelper.senduser.view,exhelper.senduser.add,exhelper.senduser.edit,exhelper.senduser.delete,exhelper.senduser.setdefault,exhelper.short,exhelper.short.view,exhelper.short.save,exhelper.printset,exhelper.printset.view,exhelper.printset.save,exhelper.dosen,taobao,taobao.fetch';
			if (empty($_obfuscate_DRYEgMBIxAFCxsDOxEfDxAyLxs5KAE)) 
			{
				$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = array('rolename' => '供应商', 'status' => 1, 'status1' => 1, 'perms' => $_obfuscate_DS08CDcrOzcfHh8wHg8PEgcHECUYDCI, 'deleted' => 0);
				pdo_insert('sz_yi_perm_role', $_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI);
				$_obfuscate_DRBcKgwaCh0_IxchGC0lKB4pXDMnNzI = pdo_insertid();
			}
			else 
			{
				$_obfuscate_DRBcKgwaCh0_IxchGC0lKB4pXDMnNzI = $_obfuscate_DRYEgMBIxAFCxsDOxEfDxAyLxs5KAE['id'];
			}
			return $_obfuscate_DRBcKgwaCh0_IxchGC0lKB4pXDMnNzI;
		}
		public function verifyUserIsSupplier($uid) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DQQMLAk_MicbMj4jOyICOQwlKT4BDiI = pdo_fetchcolumn('select roleid from' . tablename('sz_yi_perm_user') . ' where uid=' . $uid . ' and uniacid=' . $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']);
			if ($_obfuscate_DQQMLAk_MicbMj4jOyICOQwlKT4BDiI != 0) 
			{
				$_obfuscate_DRwXJQ01JyUhOyEGOR4PNAkyBz8LPxE = pdo_fetchcolumn('select status1 from' . tablename('sz_yi_perm_role') . ' where id=' . $_obfuscate_DQQMLAk_MicbMj4jOyICOQwlKT4BDiI);
				return $_obfuscate_DRwXJQ01JyUhOyEGOR4PNAkyBz8LPxE;
			}
		}
		public function getSet() 
		{
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = parent::getSet();
			return $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI;
		}
		public function sendMessage($openid = '', $data = array(), $becometitle = '') 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			$_obfuscate_DQ00FjUiFCcUEA0rNTA2HhgpJD0LKSI = m('member')->getMember($openid);
			if ($becometitle == TM_SUPPLIER_PAY) 
			{
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = '恭喜您，您的提现将通过 [提现方式] 转账提现金额为[金额]已在[时间]转账到您的账号，敬请查看';
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[金额]', $data['money'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[提现方式]', $data['type'], $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
				$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => '供应商打款通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI, 'color' => '#73a68d') );
				m('message')->sendCustomNotice($openid, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
			}
		}
		public function sendSupplierInform($openid = '', $status = '') 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
			if ($status == 1) 
			{
				$_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI = '驳回';
			}
			else 
			{
				$_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI = '通过';
			}
			$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = $this->getSet();
			$_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI = $_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['tm'];
			$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_become'];
			$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[状态]', $_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI, $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
			$_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI = str_replace('[时间]', date('Y-m-d H:i', time()), $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI);
			if (!empty($_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_becometitle'])) 
			{
				$_obfuscate_DSc1DTc_DjsGKQ01NwNcGC4eCQovJBE = $_obfuscate_DTgGDQUKATIFBBw1IxQrHywLLiwlPyI['commission_becometitle'];
			}
			else 
			{
				$_obfuscate_DSc1DTc_DjsGKQ01NwNcGC4eCQovJBE = '会员申请供应商通知';
			}
			$_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI = array( 'keyword1' => array('value' => $_obfuscate_DSc1DTc_DjsGKQ01NwNcGC4eCQovJBE, 'color' => '#73a68d'), 'keyword2' => array('value' => $_obfuscate_DSsiGx0FHhIjIg8aBywNOx0PSoHJyI, 'color' => '#73a68d') );
			m('message')->sendCustomNotice($openid, $_obfuscate_DQ8DOwYFKS8tLT4eKzQcHDYGBiovHDI);
		}
		public function order_split($orderid) 
		{
			$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
			if (empty($orderid)) 
			{
				return NULL;
			}
			$_obfuscate_DTgDKAcdFDYmIhsuIyIEXCocA0A_DCI = pdo_fetchall('select distinct supplier_uid from ' . tablename('sz_yi_order_goods') . ' where orderid=:orderid and uniacid=:uniacid', array(':orderid' => $orderid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			if (count($_obfuscate_DTgDKAcdFDYmIhsuIyIEXCocA0A_DCI) == 1) 
			{
				pdo_update('sz_yi_order', array('supplier_uid' => $_obfuscate_DTgDKAcdFDYmIhsuIyIEXCocA0A_DCI[0]['supplier_uid']), array('id' => $orderid, 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
				return NULL;
			}
			$_obfuscate_DSgNBAwLARsxNQwLLwYSECk4Jh4zLTI = pdo_fetchall('select supplier_uid, id from ' . tablename('sz_yi_order_goods') . ' where orderid=:orderid and uniacid=:uniacid ', array(':orderid' => $orderid, ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
			$_obfuscate_DScbKBwVCwYJLhFABxU7CBYPNR8IAwE = pdo_fetch('select * from ' . tablename('sz_yi_order') . ' where  id=:id and uniacid=:uniacid limit 1', array(':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'], ':id' => $orderid));
			$_obfuscate_DTMREhIzEx8VLyIYKyQlDj8vA0AeCwE = ture;
			$_obfuscate_DSY0OzgEDxsCMD4bPz8sCCMZNjUdHyI = array();
			foreach ($_obfuscate_DSgNBAwLARsxNQwLLwYSECk4Jh4zLTI as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
			{
				$_obfuscate_DSY0OzgEDxsCMD4bPz8sCCMZNjUdHyI[$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['supplier_uid']][]['id'] = $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['id'];
			}
			$_obfuscate_DS9cWyEzFT4KNhIiCiEvMi8vW1woMCI = false;
			unset($_obfuscate_DScbKBwVCwYJLhFABxU7CBYPNR8IAwE['id']);
			unset($_obfuscate_DScbKBwVCwYJLhFABxU7CBYPNR8IAwE['uniacid']);
			$_obfuscate_DT0tKAsGHhcjNScSCTU5JCMLChwNGjI = $_obfuscate_DScbKBwVCwYJLhFABxU7CBYPNR8IAwE['dispatchprice'];
			$_obfuscate_DRIbBkABgUqMRwDFio2Dy4hIyY5JDI = $_obfuscate_DScbKBwVCwYJLhFABxU7CBYPNR8IAwE['olddispatchprice'];
			$_obfuscate_DTg_DDkQOAMkCh4TIjY4GVwGPh0wOSI = $_obfuscate_DScbKBwVCwYJLhFABxU7CBYPNR8IAwE['changedispatchprice'];
			if (!empty($_obfuscate_DSY0OzgEDxsCMD4bPz8sCCMZNjUdHyI)) 
			{
				foreach ($_obfuscate_DSY0OzgEDxsCMD4bPz8sCCMZNjUdHyI as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
				{
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE = $_obfuscate_DScbKBwVCwYJLhFABxU7CBYPNR8IAwE;
					$_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE = 0;
					$_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE = 0;
					$_obfuscate_DRg7NRoVIg8wOBkvPBM3AzIFCRIxWyI = 0;
					$_obfuscate_DTQWPT8XMwIYDCYMPDMSLj8MyE3NiI = 0;
					$_obfuscate_DRYNLSgwF1sGMRI9FC4RATACJAIyBTI = 0;
					$_obfuscate_DTAwAT4pKC8BFTcXOwEbBjkdITAuJTI = 0;
					$_obfuscate_DTsxAwIfKiseHw8LOx89A0A4BzgOJCI = 0;
					$_obfuscate_DTYnPxgjNwgsMxUqAScfIxBcBzYvHSI = 0;
					$_obfuscate_DQETKAU8HB8vQB0oClsuKSwwGTwzFxE = 0;
					foreach ($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE as $_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE ) 
					{
						$_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI = pdo_fetch('select price,realprice,oldprice,supplier_uid from ' . tablename('sz_yi_order_goods') . ' where id=:id and uniacid=:uniacid ', array(':id' => $_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE['id'], ':uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						$_obfuscate_DTMWPgUMIg4kH1snPyEcFSo8WzQdDAE += $_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI['price'];
						$_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE += $_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI['realprice'];
						$_obfuscate_DRg7NRoVIg8wOBkvPBM3AzIFCRIxWyI += $_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI['oldprice'];
						$_obfuscate_DRYNLSgwF1sGMRI9FC4RATACJAIyBTI += $_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI['price'];
						$_obfuscate_DSceISgdPBYCFg4cCAkOFkA2OyMBDI = $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE;
						$_obfuscate_DTQWPT8XMwIYDCYMPDMSLj8MyE3NiI += $_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI['changeprice'];
						$_obfuscate_DSUYGg0JCzQeHVwNECcaLikyEBYuGSI = $_obfuscate_DRgxLhErPDMEGhUOJSoJXB0NHwIsMCI['price'] / $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['goodsprice'];
						$_obfuscate_DTAwAT4pKC8BFTcXOwEbBjkdITAuJTI += round($_obfuscate_DSUYGg0JCzQeHVwNECcaLikyEBYuGSI * $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['couponprice'], 2);
						$_obfuscate_DTsxAwIfKiseHw8LOx89A0A4BzgOJCI += round($_obfuscate_DSUYGg0JCzQeHVwNECcaLikyEBYuGSI * $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['discountprice'], 2);
						$_obfuscate_DTYnPxgjNwgsMxUqAScfIxBcBzYvHSI += round($_obfuscate_DSUYGg0JCzQeHVwNECcaLikyEBYuGSI * $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductprice'], 2);
						$_obfuscate_DQETKAU8HB8vQB0oClsuKSwwGTwzFxE += round($_obfuscate_DSUYGg0JCzQeHVwNECcaLikyEBYuGSI * $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductcredit2'], 2);
					}
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['oldprice'] = $_obfuscate_DRg7NRoVIg8wOBkvPBM3AzIFCRIxWyI;
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['goodsprice'] = $_obfuscate_DRYNLSgwF1sGMRI9FC4RATACJAIyBTI;
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['supplier_uid'] = $_obfuscate_DSceISgdPBYCFg4cCAkOFkA2OyMBDI;
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['couponprice'] = $_obfuscate_DTAwAT4pKC8BFTcXOwEbBjkdITAuJTI;
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['discountprice'] = $_obfuscate_DTsxAwIfKiseHw8LOx89A0A4BzgOJCI;
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductprice'] = $_obfuscate_DTYnPxgjNwgsMxUqAScfIxBcBzYvHSI;
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['deductcredit2'] = $_obfuscate_DQETKAU8HB8vQB0oClsuKSwwGTwzFxE;
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['changeprice'] = $_obfuscate_DTQWPT8XMwIYDCYMPDMSLj8MyE3NiI;
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['dispatchprice'] = round($_obfuscate_DT0tKAsGHhcjNScSCTU5JCMLChwNGjI / count($_obfuscate_DSgNBAwLARsxNQwLLwYSECk4Jh4zLTI), 2);
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['olddispatchprice'] = round($_obfuscate_DRIbBkABgUqMRwDFio2Dy4hIyY5JDI / count($_obfuscate_DSgNBAwLARsxNQwLLwYSECk4Jh4zLTI), 2);
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['changedispatchprice'] = round($_obfuscate_DTg_DDkQOAMkCh4TIjY4GVwGPh0wOSI / count($_obfuscate_DSgNBAwLARsxNQwLLwYSECk4Jh4zLTI), 2);
					$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['price'] = ($_obfuscate_DSY0BwEJLQRcNjcQFAwOGTAtFyNAFgE - $_obfuscate_DTAwAT4pKC8BFTcXOwEbBjkdITAuJTI - $_obfuscate_DTsxAwIfKiseHw8LOx89A0A4BzgOJCI - $_obfuscate_DTYnPxgjNwgsMxUqAScfIxBcBzYvHSI - $_obfuscate_DQETKAU8HB8vQB0oClsuKSwwGTwzFxE) + $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['dispatchprice'];
					if ($_obfuscate_DS9cWyEzFT4KNhIiCiEvMi8vW1woMCI == false) 
					{
						pdo_update('sz_yi_order', $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE, array('id' => $orderid, 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						$_obfuscate_DS9cWyEzFT4KNhIiCiEvMi8vW1woMCI = ture;
					}
					else 
					{
						$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['uniacid'] = $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid'];
						$_obfuscate_DTUQOSQNKRoLOR0lEhQwKRQ5AiE9NRE = m('common')->createNO('order', 'ordersn', 'SH');
						$_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE['ordersn'] = $_obfuscate_DTUQOSQNKRoLOR0lEhQwKRQ5AiE9NRE;
						pdo_insert('sz_yi_order', $_obfuscate_DTMcAwcPKScmIgYKyJbDyYjGRMuHhE);
						$_obfuscate_DQEAywIg4XODwKHjQGNDk4ElwcASI = pdo_insertid();
						$_obfuscate_DVw5Gw4ZBjgcMTUvKEASHREFGRICByI = array('orderid' => $_obfuscate_DQEAywIg4XODwKHjQGNDk4ElwcASI);
						foreach ($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE as $_obfuscate_DRU4BCk5K1sSPjE1BxcLKS0UJy0JEBE ) 
						{
							pdo_update('sz_yi_order_goods', $_obfuscate_DVw5Gw4ZBjgcMTUvKEASHREFGRICByI, array('id' => $_obfuscate_DRU4BCk5K1sSPjE1BxcLKS0UJy0JEBE['id'], 'uniacid' => $_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['uniacid']));
						}
					}
				}
			}
		}
	}
}
?>