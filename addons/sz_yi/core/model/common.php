<?php
class Sz_DYi_Common
{
	public function dataMove()
	{
		$_yl_var_0 = 'ewei_shop';
		$_yl_var_1 = 'sz_yi';
		$_yl_var_2 = pdo_fetchall('SHOW TABLES LIKE \'%' . $_yl_var_1 . '%\'');

		if (!$_yl_var_2) {
			return false;
		}

		foreach ($_yl_var_2 as $_yl_var_3) {
			foreach ($_yl_var_3 as $_yl_var_4) {
				$_yl_var_5 = 'drop table `' . $_yl_var_4 . '`';
				pdo_query($_yl_var_5);
			}
		}

		$_yl_var_2 = pdo_fetchall('SHOW TABLES LIKE \'%' . $_yl_var_0 . '%\'');

		if (!$_yl_var_2) {
			return false;
		}

		foreach ($_yl_var_2 as $_yl_var_3) {
			foreach ($_yl_var_3 as $_yl_var_4) {
				$_yl_var_5 = 'rename table `' . $_yl_var_4 . '` to `' . str_replace($_yl_var_0, $_yl_var_1, $_yl_var_4) . '`';
				pdo_query($_yl_var_5);
			}
		}

		if (!pdo_fieldexists('sz_yi_member', 'regtype')) {
			pdo_query('ALTER TABLE ' . tablename('sz_yi_member') . ' ADD    `regtype` tinyint(3) DEFAULT \'1\';');
		}

		if (!pdo_fieldexists('sz_yi_member', 'isbindmobile')) {
			pdo_query('ALTER TABLE ' . tablename('sz_yi_member') . ' ADD    `isbindmobile` tinyint(3) DEFAULT \'0\';');
		}

		if (!pdo_fieldexists('sz_yi_member', 'isjumpbind')) {
			pdo_query('ALTER TABLE ' . tablename('sz_yi_member') . ' ADD    `isjumpbind` tinyint(3) DEFAULT \'0\';');
		}

		if (!pdo_fieldexists('sz_yi_member', 'pwd')) {
			pdo_query('ALTER TABLE  ' . tablename('sz_yi_member') . ' CHANGE  `pwd`  `pwd` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;');
		}

		pdo_query('UPDATE `ims_sz_yi_plugin` SET `name` = \'芸众分销\' WHERE `identity` = \'commission\'');

		if (!pdo_fieldexists('sz_yi_goods', 'cates')) {
			pdo_query('ALTER TABLE ' . tablename('sz_yi_goods') . ' ADD     `cates` text;');
		}
	}

	public function getSetData($uniacid = 0)
	{
		global $_W;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$_yl_var_6 = m('cache')->getArray('sysset', $uniacid);

		if (empty($_yl_var_6)) {
			$_yl_var_6 = pdo_fetch('select * from ' . tablename('sz_yi_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

			if (empty($_yl_var_6)) {
				$_yl_var_6 = array();
			}

			m('cache')->set('sysset', $_yl_var_6, $uniacid);
		}

		return $_yl_var_6;
	}

	public function getSysset($key = '', $uniacid = 0)
	{
		global $_W;
		global $_GPC;
		$_yl_var_6 = $this->getSetData($uniacid);
		$_yl_var_7 = unserialize($_yl_var_6['sets']);
		$_yl_var_8 = array();

		if (!empty($key)) {
			if (is_array($key)) {
				foreach ($key as $_yl_var_9) {
					$_yl_var_8[$_yl_var_9] = isset($_yl_var_7[$_yl_var_9]) ? $_yl_var_7[$_yl_var_9] : array();
				}
			}
			else {
				$_yl_var_8 = (isset($_yl_var_7[$key]) ? $_yl_var_7[$key] : array());
			}

			return $_yl_var_8;
		}

		return $_yl_var_7;
	}

	public function alipay_build($params, $alipay = array(), $type = 0, $openid = '')
	{
		global $_W;
		$_yl_var_10 = $params['tid'];
		$_yl_var_6 = array();
		$_yl_var_6['service'] = 'alipay.wap.create.direct.pay.by.user';
		$_yl_var_6['partner'] = $alipay['partner'];
		$_yl_var_6['_input_charset'] = 'utf-8';
		$_yl_var_6['sign_type'] = 'MD5';

		if (empty($type)) {
			$_yl_var_6['notify_url'] = $_W['siteroot'] . 'addons/sz_yi/payment/alipay/notify.php';
			$_yl_var_6['return_url'] = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=sz_yi&do=order&p=pay&op=return&openid=' . $openid;
		}
		else {
			$_yl_var_6['notify_url'] = $_W['siteroot'] . 'addons/sz_yi/payment/alipay/notify.php';
			$_yl_var_6['return_url'] = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=sz_yi&do=member&p=recharge&op=return&openid=' . $openid;
		}

		$_yl_var_6['out_trade_no'] = $_yl_var_10;
		$_yl_var_6['subject'] = $params['title'];
		$_yl_var_6['total_fee'] = $params['fee'];
		$_yl_var_6['seller_id'] = $alipay['account'];
		$_yl_var_6['payment_type'] = 1;
		$_yl_var_6['body'] = $_W['uniacid'] . ':' . $type;
		$_yl_var_11 = array();

		foreach ($_yl_var_6 as $_yl_var_12 => $_yl_var_13) {
			if (($_yl_var_12 != 'sign') && ($_yl_var_12 != 'sign_type')) {
				$_yl_var_11[] = $_yl_var_12 . '=' . $_yl_var_13;
			}
		}

		sort($_yl_var_11);
		$_yl_var_14 = implode($_yl_var_11, '&');
		$_yl_var_14 .= $alipay['secret'];
		$_yl_var_6['sign'] = md5($_yl_var_14);
		return array('url' => ALIPAY_GATEWAY . '?' . http_build_query($_yl_var_6, '', '&'));
	}

	public function wechat_build($params, $wechat, $type = 0)
	{
		global $_W;
		load()->func('communication');
		if (empty($wechat['version']) && !empty($wechat['signkey'])) {
			$wechat['version'] = 1;
		}

		$_yl_var_15 = array();

		if ($wechat['version'] == 1) {
			$_yl_var_15['appId'] = $wechat['appid'];
			$_yl_var_15['timeStamp'] = TIMESTAMP . '';
			$_yl_var_15['nonceStr'] = random(8) . '';
			$_yl_var_16 = array();
			$_yl_var_16['bank_type'] = 'WX';
			$_yl_var_16['body'] = urlencode($params['title']);
			$_yl_var_16['attach'] = $_W['uniacid'] . ':' . $type;
			$_yl_var_16['partner'] = $wechat['partner'];
			$_yl_var_16['device_info'] = 'sz_yi';
			$_yl_var_16['out_trade_no'] = $params['tid'];
			$_yl_var_16['total_fee'] = $params['fee'] * 100;
			$_yl_var_16['fee_type'] = '1';
			$_yl_var_16['notify_url'] = $_W['siteroot'] . 'addons/sz_yi/payment/wechat/notify.php';
			$_yl_var_16['spbill_create_ip'] = CLIENT_IP;
			$_yl_var_16['input_charset'] = 'UTF-8';
			ksort($_yl_var_16);
			$_yl_var_17 = '';

			foreach ($_yl_var_16 as $_yl_var_12 => $_yl_var_18) {
				if (empty($_yl_var_18)) {
					continue;
				}

				$_yl_var_17 .= $_yl_var_12 . '=' . $_yl_var_18 . '&';
			}

			$_yl_var_17 .= 'key=' . $wechat['key'];
			$_yl_var_19 = strtoupper(md5($_yl_var_17));
			$_yl_var_20 = '';

			foreach ($_yl_var_16 as $_yl_var_12 => $_yl_var_18) {
				$_yl_var_18 = urlencode($_yl_var_18);
				$_yl_var_20 .= $_yl_var_12 . '=' . $_yl_var_18 . '&';
			}

			$_yl_var_20 .= 'sign=' . $_yl_var_19;
			$_yl_var_15['package'] = $_yl_var_20;
			$_yl_var_14 = '';
			$_yl_var_21 = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
			sort($_yl_var_21);

			foreach ($_yl_var_21 as $_yl_var_12) {
				$_yl_var_18 = $_yl_var_15[$_yl_var_12];

				if ($_yl_var_12 == 'appKey') {
					$_yl_var_18 = $wechat['signkey'];
				}

				$_yl_var_12 = strtolower($_yl_var_12);
				$_yl_var_14 .= $_yl_var_12 . '=' . $_yl_var_18 . '&';
			}

			$_yl_var_14 = rtrim($_yl_var_14, '&');
			$_yl_var_15['signType'] = 'SHA1';
			$_yl_var_15['paySign'] = sha1($_yl_var_14);
			return $_yl_var_15;
		}

		$_yl_var_16 = array();
		$_yl_var_16['appid'] = $wechat['appid'];
		$_yl_var_16['mch_id'] = $wechat['mchid'];
		$_yl_var_16['nonce_str'] = random(8) . '';
		$_yl_var_16['body'] = $params['title'];
		$_yl_var_16['device_info'] = 'sz_yi';
		$_yl_var_16['attach'] = $_W['uniacid'] . ':' . $type;
		$_yl_var_16['out_trade_no'] = $params['tid'];
		$_yl_var_16['total_fee'] = $params['fee'] * 100;
		$_yl_var_16['spbill_create_ip'] = CLIENT_IP;
		$_yl_var_16['notify_url'] = $_W['siteroot'] . 'addons/sz_yi/payment/wechat/notify.php';
		$_yl_var_16['trade_type'] = $params['trade_type'] == 'NATIVE' ? 'NATIVE' : 'JSAPI';
		$_yl_var_16['openid'] = $_W['fans']['from_user'];
		ksort($_yl_var_16, SORT_STRING);
		$_yl_var_17 = '';

		foreach ($_yl_var_16 as $_yl_var_12 => $_yl_var_18) {
			if (empty($_yl_var_18)) {
				continue;
			}

			$_yl_var_17 .= $_yl_var_12 . '=' . $_yl_var_18 . '&';
		}

		$_yl_var_17 .= 'key=' . $wechat['signkey'];
		$_yl_var_16['sign'] = strtoupper(md5($_yl_var_17));
		$_yl_var_22 = array2xml($_yl_var_16);
		$_yl_var_23 = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $_yl_var_22);

		if (is_error($_yl_var_23)) {
			return $_yl_var_23;
		}

		$_yl_var_24 = @simplexml_load_string($_yl_var_23['content'], 'SimpleXMLElement', LIBXML_NOCDATA);

		if (strval($_yl_var_24->return_code) == 'FAIL') {
			return error(-1, strval($_yl_var_24->return_msg));
		}

		if (strval($_yl_var_24->result_code) == 'FAIL') {
			return error(-1, strval($_yl_var_24->err_code) . ': ' . strval($_yl_var_24->err_code_des));
		}

		$_yl_var_25 = $_yl_var_24->prepay_id;
		$_yl_var_15['appId'] = $wechat['appid'];
		$_yl_var_15['timeStamp'] = TIMESTAMP . '';
		$_yl_var_15['nonceStr'] = random(8) . '';
		$_yl_var_15['package'] = 'prepay_id=' . $_yl_var_25;
		$_yl_var_15['signType'] = 'MD5';

		if ($params['trade_type'] == 'NATIVE') {
			$_yl_var_26 = (array) $_yl_var_24->code_url;
			$_yl_var_15['code_url'] = $_yl_var_26[0];
		}

		ksort($_yl_var_15, SORT_STRING);

		foreach ($_yl_var_15 as $_yl_var_12 => $_yl_var_18) {
			$_yl_var_14 .= $_yl_var_12 . '=' . $_yl_var_18 . '&';
		}

		$_yl_var_14 .= 'key=' . $wechat['signkey'];
		$_yl_var_15['paySign'] = strtoupper(md5($_yl_var_14));
		return $_yl_var_15;
	}

	public function getAccount()
	{
		global $_W;
		load()->model('account');

		if (!empty($_W['acid'])) {
			return WeAccount::create($_W['acid']);
		}

		$_yl_var_27 = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		return WeAccount::create($_yl_var_27);
	}

	public function shareAddress()
	{
		global $_W;
		global $_GPC;
		$_yl_var_28 = $_W['account']['key'];
		$_yl_var_29 = $_W['account']['secret'];
		load()->func('communication');
		$_yl_var_30 = $_W['siteroot'] . 'app/index.php?' . $_SERVER['QUERY_STRING'];

		if (empty($_GPC['code'])) {
			$_yl_var_31 = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $_yl_var_28 . '&redirect_uri=' . urlencode($_yl_var_30) . '&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
			header('location: ' . $_yl_var_31);
			exit();
		}

		$_yl_var_32 = $_GPC['code'];
		$_yl_var_33 = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $_yl_var_28 . '&secret=' . $_yl_var_29 . '&code=' . $_yl_var_32 . '&grant_type=authorization_code';
		$_yl_var_34 = ihttp_get($_yl_var_33);
		$_yl_var_35 = @json_decode($_yl_var_34['content'], true);
		if (empty($_yl_var_35) || !is_array($_yl_var_35) || empty($_yl_var_35['access_token']) || empty($_yl_var_35['openid'])) {
			return false;
		}

		$_yl_var_16 = array('appid' => $_yl_var_28, 'url' => $_yl_var_30, 'timestamp' => time() . '', 'noncestr' => random(8, true) . '', 'accesstoken' => $_yl_var_35['access_token']);
		ksort($_yl_var_16, SORT_STRING);
		$_yl_var_36 = array();

		foreach ($_yl_var_16 as $_yl_var_9 => $_yl_var_18) {
			$_yl_var_36[] = $_yl_var_9 . '=' . $_yl_var_18;
		}

		$_yl_var_14 = implode('&', $_yl_var_36);
		$_yl_var_37 = strtolower(sha1(trim($_yl_var_14)));
		$_yl_var_38 = array('appId' => $_yl_var_28, 'scope' => 'jsapi_address', 'signType' => 'sha1', 'addrSign' => $_yl_var_37, 'timeStamp' => $_yl_var_16['timestamp'], 'nonceStr' => $_yl_var_16['noncestr']);
		return $_yl_var_38;
	}

	public function createNO($table, $field, $prefix)
	{
		$_yl_var_39 = date('YmdHis') . random(6, true);

		while (1) {
			$_yl_var_40 = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_' . $table) . ' where ' . $field . '=:billno limit 1', array(':billno' => $_yl_var_39));

			if ($_yl_var_40 <= 0) {
				break;
			}

			$_yl_var_39 = date('YmdHis') . random(6, true);
		}

		return $prefix . $_yl_var_39;
	}

	public function html_images($detail = '')
	{
		$detail = htmlspecialchars_decode($detail);
		preg_match_all('/<img.*?src=[\\\'| "](.*?(?:[\\.gif|\\.jpg|\\.png|\\.jpeg]?))[\\\'|"].*?[\\/]?>/', $detail, $_yl_var_41);
		$_yl_var_42 = array();

		if (isset($_yl_var_41[1])) {
			foreach ($_yl_var_41[1] as $_yl_var_43) {
				$_yl_var_44 = array('old' => $_yl_var_43, 'new' => save_media($_yl_var_43));
				$_yl_var_42[] = $_yl_var_44;
			}
		}

		foreach ($_yl_var_42 as $_yl_var_43) {
			$detail = str_replace($_yl_var_43['old'], $_yl_var_43['new'], $detail);
		}

		return $detail;
	}

	public function getSec($uniacid = 0)
	{
		global $_W;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$_yl_var_6 = pdo_fetch('select sec from ' . tablename('sz_yi_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

		if (empty($_yl_var_6)) {
			$_yl_var_6 = array();
		}

		return $_yl_var_6;
	}

	public function paylog($log = '')
	{
		global $_W;
		$_yl_var_45 = m('cache')->getString('paylog', 'global');

		if (!empty($_yl_var_45)) {
			$_yl_var_46 = IA_ROOT . '/addons/sz_yi/data/paylog/' . $_W['uniacid'] . '/' . date('Ymd');

			if (!is_dir($_yl_var_46)) {
				load()->func('file');
				@mkdirs($_yl_var_46, '0777');
			}

			$_yl_var_47 = $_yl_var_46 . '/' . date('H') . '.log';
			file_put_contents($_yl_var_47, $log, FILE_APPEND);
		}
	}

	public function checkClose()
	{
		if (strexists($_SERVER['REQUEST_URI'], '/web/')) {
			return NULL;
		}

		$_yl_var_48 = $this->getSysset('shop');

		if (!empty($_yl_var_48['close'])) {
			if (!empty($_yl_var_48['closeurl'])) {
				header('location: ' . $_yl_var_48['closeurl']);
				exit();
			}

			exit("<!DOCTYPE html>\n                    <html>\n                        <head>\n                            <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>\n                            <title>抱歉，商城暂时关闭</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>\n                        </head>\n                        <body>\n                        <style type='text/css'>\n                        body { background:#fbfbf2; color:#333;}\n                        img { display:block; width:100%;}\n                        .header {\n                        width:100%; padding:10px 0;text-align:center;font-weight:bold;}\n                        </style>\n                        <div class='page_msg'>\n                        \n                        <div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span>" . $_yl_var_48['closedetail'] . "</div></div>\n                        </body>\n                    </html>");
		}
	}

	public function mylink()
	{
		global $_W;
		$_yl_var_49['designer'] = p('designer');
		$_yl_var_49['categorys'] = pdo_fetchall('SELECT * FROM ' . tablename('sz_yi_article_category') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));

		if ($_yl_var_49['designer']) {
			$_yl_var_49['diypages'] = pdo_fetchall('SELECT id,pagetype,setdefault,pagename FROM ' . tablename('sz_yi_designer') . ' WHERE uniacid=:uniacid order by setdefault desc  ', array(':uniacid' => $_W['uniacid']));
		}

		$_yl_var_49['article_sys'] = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_article_sys') . ' WHERE uniacid=:uniacid limit 1 ', array(':uniacid' => $_W['uniacid']));
		$_yl_var_49['article_sys']['article_area'] = json_decode($_yl_var_49['article_sys']['article_area'], true);
		$_yl_var_49['area_count'] = sizeof($_yl_var_49['article_sys']['article_area']);

		if ($_yl_var_49['area_count'] == 0) {
			$_yl_var_49['article_sys']['article_area'][0]['province'] = '';
			$_yl_var_49['article_sys']['article_area'][0]['city'] = '';
			$_yl_var_49['area_count'] = 1;
		}

		$_yl_var_49['goodcates'] = pdo_fetchall('SELECT id,name,parentid FROM ' . tablename('sz_yi_category') . ' WHERE enabled=:enabled and uniacid= :uniacid  ', array(':uniacid' => $_W['uniacid'], ':enabled' => '1'));
		return $_yl_var_49;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
