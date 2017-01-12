<?php
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
load()->func('tpl');
$my_scenfiles = array();
if (!function_exists('tpl_form_field_category_3level')) 
{
	function tpl_form_field_category_3level($name, $parents, $children, $parentid, $childid, $thirdid) 
	{
		return tpl_form_field_category_level3($name, $parents, $children, $parentid, $childid, $thirdid);
	}
}
if (function_exists('tpl_form_field_category_2level') == false) 
{
	function tpl_form_field_category_2level($name, $parents, $children, $parentid, $childid, $thirdid) 
	{
		return tpl_form_field_category_level2($name, $parents, $children, $parentid, $childid, $thirdid);
	}
}
function sz_tpl_form_field_date($name, $value = '', $withtime = false) 
{
	$_obfuscate_DSITK1wTOS8UBgouEBYhQAcpOzcfDCI = '';
	if (!defined('TPL_INIT_DATA')) 
	{
		$_obfuscate_DSITK1wTOS8UBgouEBYhQAcpOzcfDCI = "\r\n\t\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t\t" . 'require(["datetimepicker"], function(){' . "\r\n\t\t\t\t\t" . '$(function(){' . "\r\n\t\t\t\t\t\t" . '$(".datetimepicker").each(function(){' . "\r\n\t\t\t\t\t\t\t" . 'var option = {' . "\r\n\t\t\t\t\t\t\t\t" . 'lang : "zh",' . "\r\n\t\t\t\t\t\t\t\t" . 'step : "30",' . "\r\n\t\t\t\t\t\t\t\t" . 'timepicker : ' . ((!empty($withtime) ? 'true' : 'false')) . ',closeOnDateSelect : true,' . "\r\n\t\t\t" . 'format : "Y-m-d' . ((!empty($withtime) ? ' H:i:s"' : '"')) . '};' . "\r\n\t\t\t" . '$(this).datetimepicker(option);' . "\r\n\t\t" . '});' . "\r\n\t" . '});' . "\r\n" . '});' . "\r\n" . '</script>';
		define('TPL_INIT_DATA', true);
	}
	$withtime = ((empty($withtime) ? false : true));
	if (!empty($value)) 
	{
		$value = ((strexists($value, '-') ? strtotime($value) : $value));
	}
	else 
	{
		$value = TIMESTAMP;
	}
	$value = (($withtime ? date('Y-m-d H:i:s', $value) : date('Y-m-d', $value)));
	$_obfuscate_DSITK1wTOS8UBgouEBYhQAcpOzcfDCI .= '<input type="text" name="' . $name . '"  value="' . $value . '" placeholder="请选择日期时间" class="datetimepicker form-control" style="padding-left:12px;" />';
	return $_obfuscate_DSITK1wTOS8UBgouEBYhQAcpOzcfDCI;
}
function isMobile() 
{
	if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) 
	{
		return true;
	}
	if (isset($_SERVER['HTTP_VIA'])) 
	{
		if (stristr($_SERVER['HTTP_VIA'], 'wap')) 
		{
			return true;
		}
	}
	if (isset($_SERVER['HTTP_USER_AGENT'])) 
	{
		$_obfuscate_DT0ZOQcnKS4CJT8NHgYYMRI0AysPJCI = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile', 'WindowsWechat');
		if (preg_match('/(' . implode('|', $_obfuscate_DT0ZOQcnKS4CJT8NHgYYMRI0AysPJCI) . ')/i', strtolower($_SERVER['HTTP_USER_AGENT']))) 
		{
			return true;
		}
	}
	if (isset($_SERVER['HTTP_ACCEPT'])) 
	{
		if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && ((strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false) || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) 
		{
			return true;
		}
	}
	return false;
}
function chmod_dir($dir, $chmod = '') 
{
	if (is_dir($dir)) 
	{
		if ($_obfuscate_DQUnDhMcMRA7JA0rCjU4JR8mKRZAGyI = opendir($dir)) 
		{
			while (false !== $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI = readdir($_obfuscate_DQUnDhMcMRA7JA0rCjU4JR8mKRZAGyI)) 
			{
				if (is_dir($dir . '/' . $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI)) 
				{
					if (($_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI != '.') && ($_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI != '..')) 
					{
						$_obfuscate_DQkCOxc8MRYBNQgPBiwtFAMQATAuIgE = $dir . '/' . $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI;
						($chmod ? chmod($_obfuscate_DQkCOxc8MRYBNQgPBiwtFAMQATAuIgE, $chmod) : false);
						chmod_dir($_obfuscate_DQkCOxc8MRYBNQgPBiwtFAMQATAuIgE);
					}
				}
				else 
				{
					$_obfuscate_DQkCOxc8MRYBNQgPBiwtFAMQATAuIgE = $dir . '/' . $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI;
					($chmod ? chmod($_obfuscate_DQkCOxc8MRYBNQgPBiwtFAMQATAuIgE, $chmod) : false);
				}
			}
		}
		closedir($_obfuscate_DQUnDhMcMRA7JA0rCjU4JR8mKRZAGyI);
	}
}
function curl_download($url, $dir) 
{
	$_obfuscate_DR8mNBAdFxstPhIKDjYhJQkmKBUxAwE = curl_init($url);
	$_obfuscate_DSwTMwcrPw8zMQcZLwEDBQpACCUoIwE = fopen($dir, 'wb');
	curl_setopt($_obfuscate_DR8mNBAdFxstPhIKDjYhJQkmKBUxAwE, CURLOPT_FILE, $_obfuscate_DSwTMwcrPw8zMQcZLwEDBQpACCUoIwE);
	curl_setopt($_obfuscate_DR8mNBAdFxstPhIKDjYhJQkmKBUxAwE, CURLOPT_HEADER, 0);
	$_obfuscate_DQwDNyY7KSglLhc1Bz8nFicoIRQCKAE = curl_exec($_obfuscate_DR8mNBAdFxstPhIKDjYhJQkmKBUxAwE);
	curl_close($_obfuscate_DR8mNBAdFxstPhIKDjYhJQkmKBUxAwE);
	fclose($_obfuscate_DSwTMwcrPw8zMQcZLwEDBQpACCUoIwE);
	return $_obfuscate_DQwDNyY7KSglLhc1Bz8nFicoIRQCKAE;
}
function send_sms($account, $pwd, $mobile, $code)
{
    $content = "您的验证码是：". $code ."。请不要把验证码泄露给其他人。如非本人操作，可不用理会！";
    $smsrs = file_get_contents('http://106.ihuyi.cn/webservice/sms.php?method=Submit&account='.$account.'&password='.$pwd.'&mobile=' . $mobile . '&content='.urldecode($content));

   return xml_to_array($smsrs);
}

function send_sms_alidayu($mobile, $code, $templateType){
    $set = m('common')->getSysset();
    include IA_ROOT . "/addons/SZ_YI/alifish/TopSdk.php";
    switch ($templateType) {
        case 'reg':
            $templateCode = $set['sms']['templateCode'];
            break;
        case 'forget':
            $templateCode = $set['sms']['templateCodeForget'];
            break;
        default:
            $templateCode = $set['sms']['templateCode'];
            break;
    }

    $c = new TopClient;
    $c->appkey = $set['sms']['appkey'];
    $c->secretKey = $set['sms']['secret'];
    $req = new AlibabaAliqinFcSmsNumSendRequest;
    $req->setExtend("123456");
    $req->setSmsType("normal");
    $req->setSmsFreeSignName($set['sms']['signname']);
    $req->setSmsParam("{\"code\":\"{$code}\",\"product\":\"{$set['sms']['product']}\"}");
    $req->setRecNum($mobile);
    $req->setSmsTemplateCode($templateCode);
    $resp = $c->execute($req);
    return objectArray($resp);
}

function xml_to_array($xml)
{
    $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
            $subxml= $matches[2][$i];
            $key = $matches[1][$i];
                    if(preg_match( $reg, $subxml )){
                            $arr[$key] = xml_to_array( $subxml );
                    }else{
                            $arr[$key] = $subxml;
                    }
            }
    }
    return $arr;
}

function redirect($url, $sec=0){
    echo "<meta http-equiv=refresh content='{$sec}; url={$url}'>";
    exit;
}
function m($name = '')
{
    static $_modules = array();
    if (isset($_modules[$name])) {
        return $_modules[$name];
    }
    $model = SZ_YI_CORE . "model/" . strtolower($name) . '.php';
    if (!is_file($model)) {
        die(' Model ' . $name . ' Not Found!');
    }
    require $model;
    $class_name      = 'Sz_DYi_' . ucfirst($name);
    $_modules[$name] = new $class_name();
    return $_modules[$name];
}
function isEnablePlugin($name){
    $plugins = m("cache")->getArray("plugins", "global");
    if($plugins){
        foreach($plugins as $p){
            if($p['identity'] == $name){
                if($p['status']){
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }
}
function p($name = '')
{
    if(!isEnablePlugin($name)){
        return false;
    }
    if ($name != 'perm' && !IN_MOBILE) {
        static $_perm_model;
        if (!$_perm_model) {
            $perm_model_file = SZ_YI_PLUGIN . 'perm/model.php';
            if (is_file($perm_model_file)) {
                require $perm_model_file;
                $perm_class_name = 'PermModel';
                $_perm_model     = new $perm_class_name('perm');
            }
        }
        if ($_perm_model) {
            if (!$_perm_model->check_plugin($name)) {
                return false;
            }
        }
    }
    static $_plugins = array();
    if (isset($_plugins[$name])) {
        return $_plugins[$name];
    }
    $model = SZ_YI_PLUGIN . strtolower($name) . '/model.php';
    if (!is_file($model)) {
        return false;
    }
    require $model;
    $class_name      = ucfirst($name) . 'Model';
    $_plugins[$name] = new $class_name($name);
    return $_plugins[$name];
}
function byte_format($input, $dec = 0) 
{
	$_obfuscate_DRQhAzYwEScFJx4GNlsuFBEUKB4ZDyI = array(' B', 'K', 'M', 'G', 'T');
	$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE = round($input, $dec);
	$_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI = 0;
	while (1024 < $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE) 
	{
		$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE /= 1024;
		++$_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI;
	}
	$_obfuscate_DRcKWyQnHSM2OxE0OyMoEgMoQCRbMDI = round($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE, $dec) . $_obfuscate_DRQhAzYwEScFJx4GNlsuFBEUKB4ZDyI[$_obfuscate_DREnNQgnJhg7CTgdLDE9Gh8wMRsaAjI];
	return $_obfuscate_DRcKWyQnHSM2OxE0OyMoEgMoQCRbMDI;
}
function save_media($url) 
{
	load()->func('file');
	$_obfuscate_DTAMHjJbHg0aQDkBLgQSCCY8XCYfNxE = array('qiniu' => false);
	$_obfuscate_DTUtMgQpPh09EztcHywoDgUaGRU0BjI = p('qiniu');
	if ($_obfuscate_DTUtMgQpPh09EztcHywoDgUaGRU0BjI) 
	{
		$_obfuscate_DTAMHjJbHg0aQDkBLgQSCCY8XCYfNxE = $_obfuscate_DTUtMgQpPh09EztcHywoDgUaGRU0BjI->getConfig();
		if ($_obfuscate_DTAMHjJbHg0aQDkBLgQSCCY8XCYfNxE) 
		{
			if (strexists($url, $_obfuscate_DTAMHjJbHg0aQDkBLgQSCCY8XCYfNxE['url'])) 
			{
				return $url;
			}
			$_obfuscate_DTMHARIyIzYoLQ8KPAw7FEAjFwIhEyI = $_obfuscate_DTUtMgQpPh09EztcHywoDgUaGRU0BjI->save(tomedia($url), $_obfuscate_DTAMHjJbHg0aQDkBLgQSCCY8XCYfNxE);
			if (empty($_obfuscate_DTMHARIyIzYoLQ8KPAw7FEAjFwIhEyI)) 
			{
				return $url;
			}
			return $_obfuscate_DTMHARIyIzYoLQ8KPAw7FEAjFwIhEyI;
		}
		return $url;
	}
	return $url;
}
function save_remote($url) 
{
}
function is_array2($array) 
{
	if (is_array($array)) 
	{
		foreach ($array as $_obfuscate_DT0HPAMVLDs9DlsQXAoROA0yHwMzHAE => $_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE ) 
		{
			return is_array($_obfuscate_DRgjWyESMTs3QB4_ITgbJAImBxQ7GgE);
		}
		return false;
	}
	return false;
}
function set_medias($list = array(), $fields = NULL) 
{
	if (empty($fields)) 
	{
		foreach ($list as &$_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI ) 
		{
			$_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI = tomedia($_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI);
		}
		return $list;
	}
	if (!is_array($fields)) 
	{
		$fields = explode(',', $fields);
	}
	if (is_array2($list)) 
	{
		foreach ($list as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => &$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
		{
			foreach ($fields as $_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE ) 
			{
				if (isset($list[$_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE])) 
				{
					$list[$_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE] = tomedia($list[$_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE]);
				}
				if (is_array($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE) && isset($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE[$_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE])) 
				{
					$_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE[$_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE] = tomedia($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE[$_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE]);
				}
			}
		}
		return $list;
	}
	foreach ($fields as $_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE ) 
	{
		if (isset($list[$_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE])) 
		{
			$list[$_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE] = tomedia($list[$_obfuscate_DUAIOC0WHzM0Ai02GRQcATIMWxg7AxE]);
		}
	}
	return $list;
}
function get_last_day($year, $month) 
{
	return date('t', strtotime($year . '-' . $month . ' -1'));
}
function show_message($msg = '', $url = '', $type = 'success') 
{
	$_obfuscate_DTwEKy0ENTMVMhMaXCQmAS0xFBocEhE = '<script language=\'javascript\'>require([\'core\'],function(core){ core.message(\'' . $msg . '\',\'' . $url . '\',\'' . $type . '\')})</script>';
	exit($_obfuscate_DTwEKy0ENTMVMhMaXCQmAS0xFBocEhE);
}
function show_json($status = 1, $return = NULL) 
{
	$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI = array('status' => $status);
	if ($return) 
	{
		$_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI['result'] = $return;
	}
	exit(json_encode($_obfuscate_DUAnIScsNRMpChcFHzAQAwIHARk7IzI));
}
function is_weixin() 
{
	if (empty($_SERVER['HTTP_USER_AGENT']) || ((strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows Phone') === false))) 
	{
		return false;
	}
	return true;
}
function b64_encode($obj) 
{
	if (is_array($obj)) 
	{
		return urlencode(base64_encode(json_encode($obj)));
	}
	return urlencode(base64_encode($obj));
}
function b64_decode($str, $is_array = true) 
{
	$str = base64_decode(urldecode($str));
	if ($is_array) 
	{
		return json_decode($str, true);
	}
	return $str;
}
function create_image($img) 
{
	$_obfuscate_DTYhJRkhBUADKCgjGRAnDDUvOVsQETI = strtolower(substr($img, strrpos($img, '.')));
	if ($_obfuscate_DTYhJRkhBUADKCgjGRAnDDUvOVsQETI == '.png') 
	{
		$_obfuscate_DQY4BgwbCB4bNRUPB0A8WykRBjsdOzI = imagecreatefrompng($img);
	}
	else if ($_obfuscate_DTYhJRkhBUADKCgjGRAnDDUvOVsQETI == '.gif') 
	{
		$_obfuscate_DQY4BgwbCB4bNRUPB0A8WykRBjsdOzI = imagecreatefromgif($img);
	}
	else 
	{
		$_obfuscate_DQY4BgwbCB4bNRUPB0A8WykRBjsdOzI = imagecreatefromjpeg($img);
	}
	return $_obfuscate_DQY4BgwbCB4bNRUPB0A8WykRBjsdOzI;
}
function get_authcode() 
{
	$_obfuscate_DTYZLyQ_Lz0VHiM5BjMZKR8oHyYhHxE = get_auth();
	return (empty($_obfuscate_DTYZLyQ_Lz0VHiM5BjMZKR8oHyYhHxE['code']) ? '' : $_obfuscate_DTYZLyQ_Lz0VHiM5BjMZKR8oHyYhHxE['code']);
}
function get_auth() 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI = pdo_fetch('select sets from ' . tablename('sz_yi_sysset') . ' order by id asc limit 1');
	$_obfuscate_DQoSWx82CxYCNBgTLB0sWwwDzkvHyI = iunserializer($_obfuscate_DRs1Ni8MNh0eNxkQLFsNJTwOATYZHTI['sets']);
	if (is_array($_obfuscate_DQoSWx82CxYCNBgTLB0sWwwDzkvHyI)) 
	{
		return (is_array($_obfuscate_DQoSWx82CxYCNBgTLB0sWwwDzkvHyI['auth']) ? $_obfuscate_DQoSWx82CxYCNBgTLB0sWwwDzkvHyI['auth'] : array());
	}
	return array();
}
function check_shop_auth($url = '', $type = 's') 
{
	$_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE = &$GLOBALS['_W'];
	$_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI = &$GLOBALS['_GPC'];
	if ($_obfuscate_DS0fLhYTNQ8PMx8tLCM8Ch9cNEAwEhE['ispost'] && ($_obfuscate_DQ0EGycpMQIlND0aGAMnBSM7XAQGOTI['do'] != 'auth')) 
	{
		$_obfuscate_DTYZLyQ_Lz0VHiM5BjMZKR8oHyYhHxE = get_auth();
		load()->func('communication');
		$_obfuscate_DQUBLRoDQC4rARECCDgCQCQCLCxbPgE = $_SERVER['HTTP_HOST'];
		$_obfuscate_DUAzBhsMMT8wHC4pMi8XDx8EMVwzGTI = gethostbyname($_obfuscate_DQUBLRoDQC4rARECCDgCQCQCLCxbPgE);
		$_obfuscate_DR8GIywTBBEGKjwFDykVQD4nAhwnMyI = setting_load('site');
		$_obfuscate_DVs0JycKQAkeNTgVJSoZOCo0KzguFTI = ((isset($_obfuscate_DR8GIywTBBEGKjwFDykVQD4nAhwnMyI['site']['key']) ? $_obfuscate_DR8GIywTBBEGKjwFDykVQD4nAhwnMyI['site']['key'] : '0'));
		if (empty($type) || ($type == 's')) 
		{
			$_obfuscate_DSMuMgQaHCcsGx0GPTw3MwkqAjIRNRE = array('type' => $type, 'ip' => $_obfuscate_DUAzBhsMMT8wHC4pMi8XDx8EMVwzGTI, 'id' => $_obfuscate_DVs0JycKQAkeNTgVJSoZOCo0KzguFTI, 'code' => $_obfuscate_DTYZLyQ_Lz0VHiM5BjMZKR8oHyYhHxE['code'], 'domain' => $_obfuscate_DQUBLRoDQC4rARECCDgCQCQCLCxbPgE);
		}
		else 
		{
			$_obfuscate_DSMuMgQaHCcsGx0GPTw3MwkqAjIRNRE = array('type' => 'm', 'm' => $type, 'ip' => $_obfuscate_DUAzBhsMMT8wHC4pMi8XDx8EMVwzGTI, 'id' => $_obfuscate_DVs0JycKQAkeNTgVJSoZOCo0KzguFTI, 'code' => $_obfuscate_DTYZLyQ_Lz0VHiM5BjMZKR8oHyYhHxE['code'], 'domain' => $_obfuscate_DQUBLRoDQC4rARECCDgCQCQCLCxbPgE);
		}
		$_obfuscate_DRQlLhUiOS4vAjYbKCsnNRI4Gg0aNCI = ihttp_post($url, $_obfuscate_DSMuMgQaHCcsGx0GPTw3MwkqAjIRNRE);
		$_obfuscate_DTUKIiICHhELKBsNOBwRGyI8HA44KBE = $_obfuscate_DRQlLhUiOS4vAjYbKCsnNRI4Gg0aNCI['content'];
		if ($_obfuscate_DTUKIiICHhELKBsNOBwRGyI8HA44KBE != '1') 
		{
			message(base64_decode('6K+35Yiw5b6u6LWe5a6Y5pa56LSt5LmwLeS6uuS6uuWVhuWfjuaooeWdly1iYnMuMDEyd3ouY29tIQ=='), '', 'error');
		}
	}
}
function my_scandir($dir) 
{
	$_obfuscate_DRslWxs0KwgXMDkZCCQvKTANjwHCBE = &$GLOBALS['my_scenfiles'];
	if ($_obfuscate_DQUnDhMcMRA7JA0rCjU4JR8mKRZAGyI = opendir($dir)) 
	{
		while (($_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI = readdir($_obfuscate_DQUnDhMcMRA7JA0rCjU4JR8mKRZAGyI)) !== false) 
		{
			if (($_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI != '..') && ($_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI != '.') && ($_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI != '.git') && ($_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI != 'tmp')) 
			{
				if (is_dir($dir . '/' . $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI)) 
				{
					my_scandir($dir . '/' . $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI);
				}
				else 
				{
					$_obfuscate_DRslWxs0KwgXMDkZCCQvKTANjwHCBE[] = $dir . '/' . $_obfuscate_DSsSHC0DLj0pKitcWx8iWzITCyMaXDI;
				}
			}
		}
		closedir($_obfuscate_DQUnDhMcMRA7JA0rCjU4JR8mKRZAGyI);
	}
}
function shop_template_compile($from, $to, $inmodule = false) 
{
	$_obfuscate_DQkCOxc8MRYBNQgPBiwtFAMQATAuIgE = dirname($to);
	if (!is_dir($_obfuscate_DQkCOxc8MRYBNQgPBiwtFAMQATAuIgE)) 
	{
		load()->func('file');
		mkdirs($_obfuscate_DQkCOxc8MRYBNQgPBiwtFAMQATAuIgE);
	}
	$_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI = shop_template_parse(file_get_contents($from), $inmodule);
	if ((IMS_FAMILY == 'x') && !preg_match('/(footer|header|account\\/welcome|login|register)+/', $from)) 
	{
		$_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI = str_replace('微赞', '系统', $_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI);
	}
	file_put_contents($to, $_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI);
}
function shop_template_parse($str, $inmodule = false) 
{
	$str = template_parse($str, $inmodule);
	$str = preg_replace('/{ifp\\s+(.+?)}/', '<?php if(cv($1)) { ?>', $str);
	$str = preg_replace('/{ifpp\\s+(.+?)}/', '<?php if(cp($1)) { ?>', $str);
	$str = preg_replace('/{ife\\s+(\\S+)\\s+(\\S+)}/', '<?php if( ce($1 ,$2) ) { ?>', $str);
	return $str;
}
function ce($permtype = '', $item = NULL) 
{
	$_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI = p('perm');
	if ($_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI) 
	{
		return $_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI->check_edit($permtype, $item);
	}
	return true;
}
function cv($permtypes = '') 
{
	$_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI = p('perm');
	if ($_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI) 
	{
		return $_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI->check_perm($permtypes);
	}
	return true;
}
function ca($permtypes = '') 
{
	if (!cv($permtypes)) 
	{
		message('您没有权限操作，请联系管理员!', '', 'error');
	}
}
function cp($pluginname = '') 
{
	$_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI = p('perm');
	if ($_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI) 
	{
		return $_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI->check_plugin($pluginname);
	}
	return true;
}
function cpa($pluginname = '') 
{
	if (!cp($pluginname)) 
	{
		message('您没有权限操作，请联系管理员!', '', 'error');
	}
}
function plog($type = '', $op = '') 
{
	$_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI = p('perm');
	if ($_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI) 
	{
		$_obfuscate_DTUXERk1DiI7BwkOFx0xORYDJjUOLiI->log($type, $op);
	}
}
function objectArray($array) 
{
	if (is_object($array)) 
	{
		$array = (array) $array;
	}
	if (is_array($array)) 
	{
		foreach ($array as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
		{
			$array[$_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE] = objectArray($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE);
		}
	}
	return $array;
}
function tpl_form_field_category_level3($name, $parents, $children, $parentid, $childid, $thirdid) 
{
	$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI = "\r\n" . '<script type="text/javascript">' . "\r\n\t" . 'window._' . $name . ' = ' . json_encode($children) . ';' . "\r\n" . '</script>';
	if (!defined('TPL_INIT_CATEGORY_THIRD')) 
	{
		$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n" . '<script type="text/javascript">' . "\r\n\t" . 'function renderCategoryThird(obj, name){' . "\r\n\t\t" . 'var index = obj.options[obj.selectedIndex].value;' . "\r\n\t\t" . 'require([\'jquery\', \'util\'], function($, u){' . "\r\n\t\t\t" . '$selectChild = $(\'#\'+name+\'_child\');' . "\r\n" . '                                                      $selectThird = $(\'#\'+name+\'_third\');' . "\r\n\t\t\t" . 'var html = \'<option value="0">请选择二级分类</option>\';' . "\r\n" . '                                                      var html1 = \'<option value="0">请选择三级分类</option>\';' . "\r\n\t\t\t" . 'if (!window[\'_\'+name] || !window[\'_\'+name][index]) {' . "\r\n\t\t\t\t" . '$selectChild.html(html);' . "\r\n" . '                                                                        $selectThird.html(html1);' . "\r\n\t\t\t\t" . 'return false;' . "\r\n\t\t\t" . '}' . "\r\n\t\t\t" . 'for(var i=0; i< window[\'_\'+name][index].length; i++){' . "\r\n\t\t\t\t" . 'html += \'<option value="\'+window[\'_\'+name][index][i][\'id\']+\'">\'+window[\'_\'+name][index][i][\'name\']+\'</option>\';' . "\r\n\t\t\t" . '}' . "\r\n\t\t\t" . '$selectChild.html(html);' . "\r\n" . '                                                    $selectThird.html(html1);' . "\r\n\t\t" . '});' . "\r\n\t" . '}' . "\r\n" . '        function renderCategoryThird1(obj, name){' . "\r\n\t\t" . 'var index = obj.options[obj.selectedIndex].value;' . "\r\n\t\t" . 'require([\'jquery\', \'util\'], function($, u){' . "\r\n\t\t\t" . '$selectChild = $(\'#\'+name+\'_third\');' . "\r\n\t\t\t" . 'var html = \'<option value="0">请选择三级分类</option>\';' . "\r\n\t\t\t" . 'if (!window[\'_\'+name] || !window[\'_\'+name][index]) {' . "\r\n\t\t\t\t" . '$selectChild.html(html);' . "\r\n\t\t\t\t" . 'return false;' . "\r\n\t\t\t" . '}' . "\r\n\t\t\t" . 'for(var i=0; i< window[\'_\'+name][index].length; i++){' . "\r\n\t\t\t\t" . 'html += \'<option value="\'+window[\'_\'+name][index][i][\'id\']+\'">\'+window[\'_\'+name][index][i][\'name\']+\'</option>\';' . "\r\n\t\t\t" . '}' . "\r\n\t\t\t" . '$selectChild.html(html);' . "\r\n\t\t" . '});' . "\r\n\t" . '}' . "\r\n" . '</script>' . "\r\n\t\t\t";
		define('TPL_INIT_CATEGORY_THIRD', true);
	}
	$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= '<div class="row row-fix tpl-category-container">' . "\r\n\t" . '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">' . "\r\n\t\t" . '<select class="form-control tpl-category-parent" id="' . $name . '_parent" name="' . $name . '[parentid]" onchange="renderCategoryThird(this,\'' . $name . '\')">' . "\r\n\t\t\t" . '<option value="0">请选择一级分类</option>';
	$_obfuscate_DTcLEikbCSQTLCMMGR4XLictBiwMCjI = '';
	foreach ($parents as $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI ) 
	{
		$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n\t\t\t" . '<option value="' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] . '" ' . (($_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] == $parentid ? 'selected="selected"' : '')) . '>' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['name'] . '</option>';
	}
	$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n\t\t" . '</select>' . "\r\n\t" . '</div>' . "\r\n\t" . '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">' . "\r\n\t\t" . '<select class="form-control tpl-category-child" id="' . $name . '_child" name="' . $name . '[childid]" onchange="renderCategoryThird1(this,\'' . $name . '\')">' . "\r\n\t\t\t" . '<option value="0">请选择二级分类</option>';
	if (!empty($parentid) && !empty($children[$parentid])) 
	{
		foreach ($children[$parentid] as $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI ) 
		{
			$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n\t\t\t" . '<option value="' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] . '"' . (($_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] == $childid ? 'selected="selected"' : '')) . '>' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['name'] . '</option>';
		}
	}
	$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n\t\t" . '</select>' . "\r\n\t" . '</div>' . "\r\n" . '                  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">' . "\r\n\t\t" . '<select class="form-control tpl-category-child" id="' . $name . '_third" name="' . $name . '[thirdid]">' . "\r\n\t\t\t" . '<option value="0">请选择三级分类</option>';
	if (!empty($childid) && !empty($children[$childid])) 
	{
		foreach ($children[$childid] as $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI ) 
		{
			$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n\t\t\t" . '<option value="' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] . '"' . (($_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] == $thirdid ? 'selected="selected"' : '')) . '>' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['name'] . '</option>';
		}
	}
	$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= '</select>' . "\r\n\t" . '</div>' . "\r\n" . '</div>';
	return $_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI;
}
function tpl_form_field_category_level2($name, $parents, $children, $parentid, $childid) 
{
	$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI = "\r\n" . '        <script type="text/javascript">' . "\r\n" . '            window._' . $name . ' = ' . json_encode($children) . ';' . "\r\n" . '        </script>';
	if (!defined('TPL_INIT_CATEGORY')) 
	{
		$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n" . '        <script type="text/javascript">' . "\r\n" . '            function renderCategory(obj, name){' . "\r\n" . '                var index = obj.options[obj.selectedIndex].value;' . "\r\n" . '                require([\'jquery\', \'util\'], function($, u){' . "\r\n" . '                    $selectChild = $(\'#\'+name+\'_child\');' . "\r\n" . '                    var html = \'<option value="0">请选择二级分类</option>\';' . "\r\n" . '                    if (!window[\'_\'+name] || !window[\'_\'+name][index]) {' . "\r\n" . '                        $selectChild.html(html);' . "\r\n" . '                        return false;' . "\r\n" . '                    }' . "\r\n" . '                    for(var i=0; i< window[\'_\'+name][index].length; i++){' . "\r\n" . '                        html += \'<option value="\'+window[\'_\'+name][index][i][\'id\']+\'">\'+window[\'_\'+name][index][i][\'name\']+\'</option>\';' . "\r\n" . '                    }' . "\r\n" . '                    $selectChild.html(html);' . "\r\n" . '                });' . "\r\n" . '            }' . "\r\n" . '        </script>' . "\r\n" . '                    ';
		define('TPL_INIT_CATEGORY', true);
	}
	$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= '<div class="row row-fix tpl-category-container">' . "\r\n" . '            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">' . "\r\n" . '                <select class="form-control tpl-category-parent" id="' . $name . '_parent" name="' . $name . '[parentid]" onchange="renderCategory(this,\'' . $name . '\')">' . "\r\n" . '                    <option value="0">请选择一级分类</option>';
	$_obfuscate_DTcLEikbCSQTLCMMGR4XLictBiwMCjI = '';
	foreach ($parents as $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI ) 
	{
		$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n" . '                    <option value="' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] . '" ' . (($_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] == $parentid ? 'selected="selected"' : '')) . '>' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['name'] . '</option>';
	}
	$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n" . '                </select>' . "\r\n" . '            </div>' . "\r\n" . '            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">' . "\r\n" . '                <select class="form-control tpl-category-child" id="' . $name . '_child" name="' . $name . '[childid]">' . "\r\n" . '                    <option value="0">请选择二级分类</option>';
	if (!empty($parentid) && !empty($children[$parentid])) 
	{
		foreach ($children[$parentid] as $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI ) 
		{
			$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n" . '                    <option value="' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] . '"' . (($_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['id'] == $childid ? 'selected="selected"' : '')) . '>' . $_obfuscate_DTs3PS4XEhIWLRYwBCciAS8CMx0xMiI['name'] . '</option>';
		}
	}
	$_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI .= "\r\n" . '                </select>' . "\r\n" . '            </div>' . "\r\n" . '        </div>' . "\r\n" . '    ';
	return $_obfuscate_DRBACxgRHiICGjMXFBkjJzAUKAQiLCI;
}
function sent_message($customer_id_array, $message) 
{
	$_obfuscate_DT8QCR1bKiUfPjwJGA8pCiIuAQ42IRE = json_encode($customer_id_array, JSON_UNESCAPED_UNICODE);
	$_obfuscate_DSMuMgQaHCcsGx0GPTw3MwkqAjIRNRE = '{"from_peer": "58",' . "\r\n" . '                "to_peers": ' . $_obfuscate_DT8QCR1bKiUfPjwJGA8pCiIuAQ42IRE . ',' . "\r\n" . '                "message": "{\\"_lctype\\":-1,\\"_lctext\\":\\"' . $message . '\\", \\"_lcattrs\\":{ \\"clientId\\":\\"58\\", \\"clientName\\":\\"商城助手\\", \\"clientIcon\\":\\"http://192.168.1.108/image/icon.png\\" }}"' . "\r\n" . '                , "conv_id": "5721da8b71cfe4006b3f362b", "transient": false}';
	$_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI = json_decode($_obfuscate_DSMuMgQaHCcsGx0GPTw3MwkqAjIRNRE, true);
	$_obfuscate_DT8fKxIVKVsbIQ0yECQTBjkiCw8jNyI = new LeanCloud\LeanMessage($_obfuscate_DQo7GQk1OykmEC8RFT4zCSYPJSEGKDI);
	$_obfuscate_DREPBiQcLy8JNAk8AT07KBENGwojDhE = $_obfuscate_DT8fKxIVKVsbIQ0yECQTBjkiCw8jNyI->send();
	return $_obfuscate_DREPBiQcLy8JNAk8AT07KBENGwojDhE;
}
function is_app() 
{
	$_obfuscate_DR8rIkA_CBhcIhsbGxsREBo0OBcrGRE = strtolower($_SERVER['HTTP_USER_AGENT']);
	$_obfuscate_DSYEChctDCUeKBcZI0ATJCYxIjMkOxE = ((strpos($_obfuscate_DR8rIkA_CBhcIhsbGxsREBo0OBcrGRE, 'yunzhong') ? true : false));
	if ($_obfuscate_DSYEChctDCUeKBcZI0ATJCYxIjMkOxE) 
	{
		return true;
	}
	return false;
}
?>