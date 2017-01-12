<?php
/**
 *源码来自易福源码网 www.efwww.com 其他网址下载均为盗用本站
 *淘宝唯一店铺：https://shop33554379.taobao.com
 */
if (!defined('IN_IA')) 
{
	exit('Access Denied');
}
class Sz_DYi_Message 
{
	public function sendTplNotice($touser, $template_id, $postdata, $url = '', $account = NULL) 
	{
		if (!$account) 
		{
			$account = m('common')->getAccount();
		}
		if (!$account) 
		{
			return NULL;
		}
		return $account->sendTplNotice($touser, $template_id, $postdata, $url);
	}
	public function sendCustomNotice($openid, $msg, $url = '', $account = NULL) 
	{
		if (!$account) 
		{
			$account = m('common')->getAccount();
		}
		if (!$account) 
		{
			return NULL;
		}
		$_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI = '';
		if (is_array($msg)) 
		{
			foreach ($msg as $_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE => $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE ) 
			{
				if (!empty($_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['title'])) 
				{
					$_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI .= $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['title'] . ':' . $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['value'] . "\n";
				}
				else 
				{
					$_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI .= $_obfuscate_DTwXATAoJyEuNxgMEigwLBUdNQU7KwE['value'] . "\n";
					if ($_obfuscate_DVwGNB01JAkkBwYUKTYTCj4dEh0iGhE == 0) 
					{
						$_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI .= "\n";
					}
				}
			}
		}
		else 
		{
			$_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI = $msg;
		}
		if (is_app()) 
		{
			pdo_insert('sz_yi_message', array('openid' => $openid, 'title' => $msg['first']['value'], 'contents' => $_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI));
			sent_message(array($openid), $msg['first']['value']);
		}
		if (!empty($url)) 
		{
			$_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI .= '<a href=\'' . $url . '\'>点击查看详情</a>';
		}
		return $account->sendCustomNotice(array( 'touser' => $openid, 'msgtype' => 'text', 'text' => array('content' => urlencode($_obfuscate_DTkmAyQHKT0iOwMSDxMqGgwtDTYiKyI)) ));
	}
	public function sendImage($openid, $mediaid) 
	{
		$_obfuscate_DR0eNwo3CAksFBQ9HjIMISYLCxkiMgE = m('common')->getAccount();
		return $_obfuscate_DR0eNwo3CAksFBQ9HjIMISYLCxkiMgE->sendCustomNotice(array( 'touser' => $openid, 'msgtype' => 'image', 'image' => array('media_id' => $mediaid) ));
	}
	public function sendNews($openid, $_var_11, $account = NULL) 
	{
		if (!$account) 
		{
			$account = m('common')->getAccount();
		}
		return $account->sendCustomNotice(array( 'touser' => $openid, 'msgtype' => 'news', 'news' => array('articles' => $_var_11) ));
	}
}
?>