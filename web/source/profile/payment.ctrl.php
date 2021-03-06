<?php
/**
 * 鬼狐源码社区 www.guifox.com
 */
defined('IN_IA') or exit('Access Denied');
uni_user_permission_check('profile_payment');
$_W['page']['title'] = '支付参数 - 公众号选项';
$setting = uni_setting($_W['uniacid'], array('payment', 'recharge', 'oauth'));
$pay = $setting['payment'];
$recharge =  $setting['recharge'];
if(!is_array($pay)) {
	$pay = array();
}
$params = array();
if(empty($_W['isfounder'])) {
	$where = " WHERE `uniacid` IN (SELECT `uniacid` FROM " . tablename('uni_account_users') . " WHERE `uid`=:uid)";
	$params[':uid'] = $_W['uid'];
}
$sql = "SELECT * FROM " . tablename('uni_account') . $where;
$uniaccounts = pdo_fetchall($sql, $params);
$borrow = array();
$service = array();
if(!empty($uniaccounts)) {
	foreach($uniaccounts as $uniaccount) {
		$account = account_fetch($uniaccount['default_acid']);
		$account_setting = pdo_get('uni_settings', array('uniacid' => $account['uniacid']));
		$payment = iunserializer($account_setting['payment']);
		if (!empty($account['key']) && !empty($account['secret']) && in_array($account['level'], array(4)) && !empty($payment) && intval($payment['wechat']['switch']) == 1 ) {
			if ((!is_bool($payment['wechat']['switch']) && $payment['wechat']['switch'] != 4) || (is_bool($payment['wechat']['switch']) && !empty($payment['wechat']['switch']))) {
				$borrow[$account['uniacid']] = $account['name'];
			}
		}
		if (!empty($payment['wechat_facilitator']['switch'])) {
			$service[$account['uniacid']] = $account['name'];
		}
	}
}
if($_W['ispost']) {
	$credit = array_elements(array('switch'), $_GPC['credit']);
	$credit['switch'] = $credit['switch'] == 'true';
	$alipay = array_elements(array('switch', 'account', 'partner', 'secret'), $_GPC['alipay']);
	$alipay['switch'] = $alipay['switch'] == 'true';
	$alipay['account'] = trim($alipay['account']);
	$alipay['partner'] = trim($alipay['partner']);
	$alipay['secret'] = trim($alipay['secret']);
	$delivery = array_elements(array('switch'), $_GPC['delivery']);
	$delivery['switch'] = $delivery['switch'] == 'true';
	$line = array_elements(array('switch'),$_GPC['line']);
	$line['switch'] = $line['switch'] == 'true';
	if($alipay['switch'] && (empty($alipay['account']) || empty($alipay['partner']) || empty($alipay['secret']))) {
		message('请输入完整的支付宝接口信息.');
	}
	if($_GPC['alipay']['test'] == 'true') {
		$params = array();
		$params['tid'] = md5(uniqid());
		$params['user'] = '测试用户';
		$params['fee'] = '0.01';
		$params['title'] = '测试支付接口';
		load()->model('payment');
		load()->func('communication');
		$ret = alipay_build($params, $alipay);
		if($ret['url']) {
			header("location: {$ret['url']}");
		}
		exit();
	}
	$wechat = array_elements(array('switch', 'account', 'signkey', 'partner', 'key', 'version', 'mchid', 'apikey', 'version', 'service', 'borrow', 'sub_mch_id'), $_GPC['wechat']);
	$wechat['signkey'] = $wechat['version'] == 2 ? trim($wechat['apikey']) : trim($wechat['signkey']);
	$wechat['partner'] = trim($wechat['partner']);
	$wechat['key'] = trim($wechat['key']);
	$wechat['sub_mch_id'] = trim($wechat['sub_mch_id']);
	if($wechat['switch'] && empty($wechat['account'])) {
		message('请输入完整的微信支付接口信息.');
	}
	$wechat_facilitator['mchid'] = intval($_GPC['wechat_facilitator']['mchid']);
	$wechat_facilitator['signkey'] = trim($_GPC['wechat_facilitator']['signkey']);
	$wechat_facilitator['switch'] = trim($_GPC['wechat_facilitator']['switch']) == 'true' ? true : false;
	if (!empty($wechat_facilitator['switch']) && empty($wechat_facilitator['mchid'])) {
		message('请填写完整微信服务商信息', referer(), 'info');
	}
	$unionpay = array_elements(array('switch', 'signcertpwd', 'merid'), $_GPC['unionpay']);
	$unionpay['switch'] = $unionpay['switch'] == 'true';
	if($unionpay['switch'] && (empty($unionpay['merid']) || empty($unionpay['signcertpwd']))) {
		message('请输入完整的银联支付接口信息.');
	}
	if ($unionpay['switch'] && empty($_FILES['unionpay']['tmp_name']['signcertpath']) && !file_exists(IA_ROOT . '/attachment/unionpay/PM_'.$_W['uniacid'].'_acp.pfx')) {
		message('请上联银商户私钥证书.');
	}
	$baifubao = array_elements(array('switch', 'signkey', 'mchid'), $_GPC['baifubao']);
	$baifubao['switch'] = $baifubao['switch'] == 'true';
	if($baifubao['switch'] && (empty($baifubao['signkey']) || empty($baifubao['mchid']))) {
		message('请输入完整的百付宝支付接口信息.');
	}
	$line = array_elements(array('switch','message'),$_GPC['line']);
	$line['switch'] = $line['switch'] == 'true';
	if(!is_array($pay)) {
		$pay = array();
	}
	$pay['credit'] = $credit;
	$pay['alipay'] = $alipay;
	$pay['wechat'] = $wechat;
	$pay['wechat_facilitator'] = $wechat_facilitator;
	$pay['delivery'] = $delivery;
	$pay['unionpay'] = $unionpay;
	$pay['baifubao'] = $baifubao;
	$pay['line'] = $line;
	if ($unionpay['switch'] && !empty($_FILES['unionpay']['tmp_name']['signcertpath'])) {
		load()->func('file');
		mkdirs(IA_ROOT . '/attachment/unionpay/');
		file_put_contents(IA_ROOT . '/attachment/unionpay/PM_'.$_W['uniacid'].'_acp.pfx', file_get_contents($_FILES['unionpay']['tmp_name']['signcertpath']));
		$public_rsa = '-----BEGIN CERTIFICATE-----
MIIEIDCCAwigAwIBAgIFEDRVM3AwDQYJKoZIhvcNAQEFBQAwITELMAkGA1UEBhMC
Q04xEjAQBgNVBAoTCUNGQ0EgT0NBMTAeFw0xNTEwMjcwOTA2MjlaFw0yMDEwMjIw
OTU4MjJaMIGWMQswCQYDVQQGEwJjbjESMBAGA1UEChMJQ0ZDQSBPQ0ExMRYwFAYD
VQQLEw1Mb2NhbCBSQSBPQ0ExMRQwEgYDVQQLEwtFbnRlcnByaXNlczFFMEMGA1UE
Aww8MDQxQDgzMTAwMDAwMDAwODMwNDBA5Lit5Zu96ZO26IGU6IKh5Lu95pyJ6ZmQ
5YWs5Y+4QDAwMDE2NDkzMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA
tXclo3H4pB+Wi4wSd0DGwnyZWni7+22Tkk6lbXQErMNHPk84c8DnjT8CW8jIfv3z
d5NBpvG3O3jQ/YHFlad39DdgUvqDd0WY8/C4Lf2xyo0+gQRZckMKEAId8Fl6/rPN
HsbPRGNIZgE6AByvCRbriiFNFtuXzP4ogG7vilqBckGWfAYaJ5zJpaGlMBOW1Ti3
MVjKg5x8t1/oFBkpFVsBnAeSGPJYrBn0irfnXDhOz7hcIWPbNDoq2bJ9VwbkKhJq
Vz7j7116pziUcLSFJasnWMnp8CrISj52cXzS/Y1kuaIMPP/1B0pcjVqMNJjowooD
OxID3TZGfk5V7S++4FowVwIDAQABo4HoMIHlMB8GA1UdIwQYMBaAFNHb6YiC5d0a
j0yqAIy+fPKrG/bZMEgGA1UdIARBMD8wPQYIYIEchu8qAQEwMTAvBggrBgEFBQcC
ARYjaHR0cDovL3d3dy5jZmNhLmNvbS5jbi91cy91cy0xNC5odG0wNwYDVR0fBDAw
LjAsoCqgKIYmaHR0cDovL2NybC5jZmNhLmNvbS5jbi9SU0EvY3JsMjI3Mi5jcmww
CwYDVR0PBAQDAgPoMB0GA1UdDgQWBBTEIzenf3VR6CZRS61ARrWMto0GODATBgNV
HSUEDDAKBggrBgEFBQcDAjANBgkqhkiG9w0BAQUFAAOCAQEAHMgTi+4Y9g0yvsUA
p7MkdnPtWLS6XwL3IQuXoPInmBSbg2NP8jNhlq8tGL/WJXjycme/8BKu+Hht6lgN
Zhv9STnA59UFo9vxwSQy88bbyui5fKXVliZEiTUhjKM6SOod2Pnp5oWMVjLxujkk
WKjSakPvV6N6H66xhJSCk+Ref59HuFZY4/LqyZysiMua4qyYfEfdKk5h27+z1MWy
nadnxA5QexHHck9Y4ZyisbUubW7wTaaWFd+cZ3P/zmIUskE/dAG0/HEvmOR6CGlM
55BFCVmJEufHtike3shu7lZGVm2adKNFFTqLoEFkfBO6Y/N6ViraBilcXjmWBJNE
MFF/yA==
-----END CERTIFICATE-----';
		file_put_contents(IA_ROOT . '/attachment/unionpay/UpopRsaCert.cer', trim($public_rsa));
	}
	$dat = iserializer($pay);
	if(pdo_update('uni_settings', array('payment' => $dat), array('uniacid' => $_W['uniacid'])) !== false) {
		cache_delete("unisetting:{$_W['uniacid']}");
		message('保存支付信息成功. ', 'refresh');
	} else {
		message('保存支付信息失败, 请稍后重试. ');
	}
	exit();
}
$pay['unionpay']['signcertexists'] = file_exists(IA_ROOT . '/attachment/unionpay/PM_'.$_W['uniacid'].'_acp.pfx');
$accounts = array();
$accounts[$_W['acid']] = array_elements(array('name', 'acid', 'key', 'secret', 'level'), $_W['account']);
template('profile/payment');
