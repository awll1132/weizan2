<?php

//鬼狐源码社区独家解密
defined('IN_IA') || die('Access Denied');
include '../addons/bm_movecar/phpqrcode.php';
class bm_movecarModule extends WeModule
{
	public $weid;
	public function __construct()
	{
		global $_W;
		$this->weid = IMS_VERSION < 0.6 ? $_W['weid'] : $_W['uniacid'];
	}
	public function fieldsFormDisplay($rid = 0)
	{
		global $_W;
		$weid = $_W['uniacid'];
		if (!empty($rid)) {
			$dir = '../attachment/images/bm_movecar';
			if (is_dir($dir)) {
			} else {
				mkdir('../attachment/images/bm_movecar');
			}
			$reply = pdo_fetch('SELECT * FROM ' . tablename('bm_movecar_reply') . ' WHERE rid = :rid ORDER BY `id` DESC', array(':rid' => $rid));
			if (empty($reply['qrcode'])) {
				$value = $_W['siteroot'] . 'app/' . $this->createmobileurl('home', array('rid' => $rid));
				$errorCorrectionLevel = 'H';
				$matrixPointSize = '16';
				$rand_file = rand() . '.png';
				$att_target_file = 'qr-' . $rand_file;
				$target_file = '../attachment/images/bm_movecar/' . $att_target_file;
				QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);
				$logo = $_W['attachurl'] . $reply['logo'];
				$QR = $target_file;
				if ($logo !== false) {
					$QR = imagecreatefromstring(file_get_contents($QR));
					$logo = imagecreatefromstring(file_get_contents($logo));
					$QR_width = imagesx($QR);
					$QR_height = imagesy($QR);
					$logo_width = imagesx($logo);
					$logo_height = imagesy($logo);
					$logo_qr_width = $QR_width / 5;
					$scale = $logo_width / $logo_qr_width;
					$logo_qr_height = $logo_height / $scale;
					$from_width = ($QR_width - $logo_qr_width) / 2;
					imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
				}
				imagepng($QR, $target_file);
				$reply['qrcode'] = $target_file;
			}
		}
		load()->func('tpl');
		include $this->template('form');
	}
	public function fieldsFormValidate($rid = 0)
	{
		return '';
	}
	public function fieldsFormSubmit($rid)
	{
		global $_W;
		global $_GPC;
		$weid = $_W['uniacid'];
		$data = array('rid' => $rid, 'weid' => $weid, 'title' => $_GPC['title'], 'desc' => $_GPC['desc'], 'tel' => $_GPC['tel'], 'picurl' => $_GPC['picurl'], 'qrcode' => $_GPC['qrcode'], 'logo' => $_GPC['logo'], 'pictype' => $_GPC['pictype'], 'urlx' => $_GPC['urlx'], 'memo' => $_GPC['memo'], 'urly' => $_GPC['urly'], 'starttime' => $_GPC['starttime'], 'memo1' => $_GPC['memo1'], 'url1' => $_GPC['url1'], 'endtime' => $_GPC['endtime'], 'memo2' => $_GPC['memo2'], 'url2' => $_GPC['url2'], 'templateid' => $_GPC['templateid'], 'openid' => $_GPC['openid'], 'templateid1' => $_GPC['templateid1'], 'templateid2' => $_GPC['templateid2'], 'banner' => $_GPC['banner'], 'is_sms' => $_GPC['is_sms'], 'corpid' => $_GPC['corpid'], 'pwd' => $_GPC['pwd'], 'pictype1' => $_GPC['pictype1'], 'province' => $_GPC['province'], 'advtitle1' => $_GPC['advtitle1'], 'advurl1' => $_GPC['advurl1'], 'appkey' => $_GPC['appkey'], 'secretKey' => $_GPC['secretKey'], 'smssignname' => $_GPC['smssignname'], 'smstemplate' => $_GPC['smstemplate'], 'smstype' => $_GPC['smstype'], 'is_sms_car' => $_GPC['is_sms_car'], 'is_sms_move' => $_GPC['is_sms_move'], 'sms_car' => $_GPC['sms_car'], 'sms_move' => $_GPC['sms_move'], 'sms_car_sign' => $_GPC['sms_car_sign'], 'is_voice_move' => $_GPC['is_voice_move'], 'voice_move' => $_GPC['voice_move'], 'voicenumber' => $_GPC['voicenumber'], 'headtitle' => $_GPC['headtitle'], 'car_enable' => intval($_GPC['car_enable']), 'storename' => $_GPC['storename'], 'is_thumb' => intval($_GPC['is_thumb']), 'is_name' => intval($_GPC['is_name']), 'is_lbs' => intval($_GPC['is_lbs']), 'ak' => $_GPC['ak'], 'verify_type' => intval($_GPC['verify_type']), 'int_times' => intval($_GPC['int_times']), 'int_minutes' => intval($_GPC['int_minutes']), 'is_qiniu' => intval($_GPC['is_qiniu']), 'qiniu_ak' => $_GPC['qiniu_ak'], 'qiniu_sk' => $_GPC['qiniu_sk'], 'qiniu_bt' => $_GPC['qiniu_bt'], 'qiniu_dm' => $_GPC['qiniu_dm'], 'is_call' => $_GPC['is_call'], 'subAccountSid' => $_GPC['subAccountSid'], 'subAccountToken' => $_GPC['subAccountToken'], 'voIPAccount' => $_GPC['voIPAccount'], 'voIPPassword' => $_GPC['voIPPassword'], 'appId' => $_GPC['appId'], 'serverIP' => $_GPC['serverIP'], 'serverPort' => $_GPC['serverPort'], 'is_check' => $_GPC['is_check'], 'is_carno' => $_GPC['is_carno'], 'is_mobile' => $_GPC['is_mobile']);
		if ($_W['ispost']) {
			if ($_GPC['recreate'] == '1') {
				$dir = '../attachment/images/bm_movecar';
				if (is_dir($dir)) {
				} else {
					mkdir('../attachment/images/bm_movecar');
				}
				$value = $_W['siteroot'] . 'app/' . $this->createmobileurl('home', array('rid' => $rid));
				$errorCorrectionLevel = 'L';
				$matrixPointSize = '16';
				$rand_file = rand() . '.png';
				$att_target_file = 'qr-' . $rand_file;
				$target_file = '../attachment/images/bm_movecar/' . $att_target_file;
				QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);
				$logo = $_W['attachurl'] . $data['logo'];
				$QR = $target_file;
				if ($logo !== false) {
					$QR = imagecreatefromstring(file_get_contents($QR));
					$logo = imagecreatefromstring(file_get_contents($logo));
					$QR_width = imagesx($QR);
					$QR_height = imagesy($QR);
					$logo_width = imagesx($logo);
					$logo_height = imagesy($logo);
					$logo_qr_width = $QR_width / 5;
					$scale = $logo_width / $logo_qr_width;
					$logo_qr_height = $logo_height / $scale;
					$from_width = ($QR_width - $logo_qr_width) / 2;
					imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
				}
				imagepng($QR, $target_file);
				$data['qrcode'] = $target_file;
			}
			if (empty($_GPC['reply_id'])) {
				pdo_insert('bm_movecar_reply', $data);
			} else {
				pdo_update('bm_movecar_reply', $data, array('id' => $_GPC['reply_id']));
			}
			message('更新成功', referer(), 'success');
		}
	}
	public function ruleDeleted($rid)
	{
		global $_W;
		$replies = pdo_fetchall('SELECT *  FROM ' . tablename('bm_movecar_reply') . ' WHERE rid = \'' . $rid . '\'');
		$deleteid = array();
		if (!empty($replies)) {
			foreach ($replies as $index => $row) {
				$deleteid[] = $row['id'];
			}
		}
		pdo_delete('bm_movecar_reply', 'id IN (\'' . implode('\',\'', $deleteid) . '\')');
		return true;
	}
	public function settingsDisplay($settings)
	{
		global $_W;
		global $_GPC;
		if (checksubmit()) {
		}
		load()->func('tpl');
		include $this->template('setting');
	}
}