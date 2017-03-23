<?php

/**
 * 数钱数到手抽筋
 *
 * @author ewei 012wz.com
 * @url
 */
class JSSDK
{

    private $appId;
    private $appSecret;

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function getSignPackage()
    {

        global $_W;
        $jsapiTicket = $this->getJsApiTicket();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->createNonceStr();


        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId" => $this->appId,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket()
    {
        global $_W, $_GPC;
        load()->func('cache');

        /*
        $api = cache_load("ewei.money.api_share.json::" . $_W['uniacid'], true);
        $new = false;
        if (empty($api['appid']) || $api['appid'] !== $this->appId) {
            $new = true;
        }
        if (empty($api['appsecret']) || $api['appsecret'] !== $this->appSecret) {
            $new = true;
        }
        */

//        $data = cache_load("ewei.money.jsapi_ticket.json::".$_W['uniacid'], true);
        $data = json_decode(file_get_contents("jsapi_ticket.json"));

        if (empty($data->expire_time) || $data->expire_time < time()) {  // 重新获取access_token
//      if (empty($data['expire_time']) || $data['expire_time'] < time() || $new) {
            $accessToken = $this->getAccessToken();

            $url = "http://api.weixin.qq.com/cgi-bin/ticket/getticket?type=1&access_token=$accessToken";
//            $res = json_decode($this->httpGet($url));
            $res = ($this->get_curl($url));
//            $res = ($this->httpGet($url));
//            $ticket = $res->ticket;
            $ticket = $res["ticket"];
            if ($ticket) {
                $data['expire_time'] = time() + 7000;
                $data['jsapi_ticket'] = $ticket;
//                cache_write("ewei.money.jsapi_ticket.json::" . $_W['uniacid'], iserializer($data));
//                cache_write("ewei.money.api_share.json::" . $_W['uniacid'], iserializer(array("appid" => $this->appId, "appsecret" => $this->appSecret)));

                $fp = fopen("jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);

            }
        } else {
            $ticket = $data->jsapi_ticket;  // access_token 未过期
        }

        return $ticket;
    }

    private function getAccessToken()
    {
        global $_W, $_GPC;
        load()->func('cache');

        /*
        $api = cache_load("ewei.money.api_share.json::" . $_W['uniacid'], true);
        $new = false;
        if (empty($api['appid']) || $api['appid'] !== $this->appId) {
            $new = true;
        }
        if (empty($api['appsecret']) || $api['appsecret'] !== $this->appSecret) {
            $new = true;
        }
        */

//        $data = cache_load("ewei.money.access_token.json::" . $_W['uniacid'], true);
        $data = json_decode(file_get_contents("access_token.json"));

        if (empty($data->expire_time) || $data->expire_time < time()) {
//            if (empty($data['expire_time']) || $data['expire_time'] < time() || $new) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
//            $res = json_decode($this->httpGet($url));
            $res = ($this->get_curl($url));
//            $res = ($this->httpGet($url));
//            $access_token = $res->access_token;
            $access_token = $res["access_token"];
            if ($access_token) {
                $data['expire_time'] = time() + 7000;
                $data['access_token'] = $access_token;
//                cache_write("ewei.money.access_token.json::" . $_W['uniacid'], iserializer($data));
//                cache_write("ewei.money.api_share.json::" . $_W['uniacid'], iserializer(array("appid" => $this->appId, "appsecret" => $this->appSecret)));

                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data['access_token'];
        }
        return $access_token;
    }

    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }


    public function get_curl($url)
    {

        $file = 'access_ticket_log.txt';

        $content = date("Y-m-d H:i", time()) . " jsapi_ticket 过期 get_curl   " . time() . "    \n";
        if ($f = file_put_contents($file, $content, FILE_APPEND)) {
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // windows跳过SSL证书检查
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, 1);
    }
}
