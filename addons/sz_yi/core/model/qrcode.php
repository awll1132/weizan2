<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Sz_DYi_Qrcode 
{
	public function createShopQrcode($mid = 0, $posterid = 0) 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
		$_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI = IA_ROOT . '/addons/sz_yi/data/qrcode/' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '/';
		if (!is_dir($_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI)) 
		{
			load()->func('file');
			mkdirs($_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI);
		}
		$_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteroot'] . 'app/index.php?i=' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '&c=entry&m=sz_yi&do=shop&mid=' . $mid;
		if (!empty($posterid)) 
		{
			$_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE .= '&posterid=' . $posterid;
		}
		$_obfuscate_DSgxFSstKygJHTkoLQcVHSgQAy4QOBE = 'shop_qrcode_' . $posterid . '_' . $mid . '.png';
		$_obfuscate_DTQrAQcZLyYCDB0uBiwTMFs4BTRbEAE = $_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI . $_obfuscate_DSgxFSstKygJHTkoLQcVHSgQAy4QOBE;
		if (!is_file($_obfuscate_DTQrAQcZLyYCDB0uBiwTMFs4BTRbEAE)) 
		{
			require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
			QRcode::png($_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE, $_obfuscate_DTQrAQcZLyYCDB0uBiwTMFs4BTRbEAE, QR_ECLEVEL_L, 4);
		}
		return $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteroot'] . 'addons/sz_yi/data/qrcode/' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '/' . $_obfuscate_DSgxFSstKygJHTkoLQcVHSgQAy4QOBE;
	}
	public function createGoodsQrcode($mid = 0, $goodsid = 0, $posterid = 0) 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
		$_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI = IA_ROOT . '/addons/sz_yi/data/qrcode/' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'];
		if (!is_dir($_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI)) 
		{
			load()->func('file');
			mkdirs($_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI);
		}
		$_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE = $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteroot'] . 'app/index.php?i=' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '&c=entry&m=sz_yi&do=shop&p=detail&id=' . $goodsid . '&mid=' . $mid;
		if (!empty($posterid)) 
		{
			$_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE .= '&posterid=' . $posterid;
		}
		$_obfuscate_DSgxFSstKygJHTkoLQcVHSgQAy4QOBE = 'goods_qrcode_' . $posterid . '_' . $mid . '_' . $goodsid . '.png';
		$_obfuscate_DTQrAQcZLyYCDB0uBiwTMFs4BTRbEAE = $_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI . '/' . $_obfuscate_DSgxFSstKygJHTkoLQcVHSgQAy4QOBE;
		if (!is_file($_obfuscate_DTQrAQcZLyYCDB0uBiwTMFs4BTRbEAE)) 
		{
			require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
			QRcode::png($_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE, $_obfuscate_DTQrAQcZLyYCDB0uBiwTMFs4BTRbEAE, QR_ECLEVEL_L, 4);
		}
		return $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteroot'] . 'addons/sz_yi/data/qrcode/' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '/' . $_obfuscate_DSgxFSstKygJHTkoLQcVHSgQAy4QOBE;
	}
	public function createWechatQrcode($data) 
	{
		$_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE = &$GLOBALS['_W'];
		$_obfuscate_DRMRDBMEDj4RXAkQKCoHLRQNIj0mBBE = &$GLOBALS['_GPC'];
		$_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE = urldecode($data);
		$_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI = IA_ROOT . '/addons/sz_yi/data/qrcode/' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'];
		if (!is_dir($_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI)) 
		{
			load()->func('file');
			mkdirs($_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI);
		}
		$_obfuscate_DSgxFSstKygJHTkoLQcVHSgQAy4QOBE = 'wechat_qrcode_' . time() . '.png';
		$_obfuscate_DTQrAQcZLyYCDB0uBiwTMFs4BTRbEAE = $_obfuscate_DQ1AFSYLGiQIATQ3DTQDODU5Nh41JDI . '/' . $_obfuscate_DSgxFSstKygJHTkoLQcVHSgQAy4QOBE;
		if (!is_file($_obfuscate_DTQrAQcZLyYCDB0uBiwTMFs4BTRbEAE)) 
		{
			require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
			QRcode::png($_obfuscate_DTgYWy4ZHCkyFhwlEz04GCIDHCsXHgE, $_obfuscate_DTQrAQcZLyYCDB0uBiwTMFs4BTRbEAE, QR_ECLEVEL_L, 4);
		}
		return $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['siteroot'] . 'addons/sz_yi/data/qrcode/' . $_obfuscate_DSIqPiwPPyI2LQcdCAQhKAk8Gxg7AhE['uniacid'] . '/' . $_obfuscate_DSgxFSstKygJHTkoLQcVHSgQAy4QOBE;
	}
}
?>