<?php
defined('IN_IA') or exit('Access Denied');

class D1sj_yuanxiaoModuleSite extends WeModuleSite {
	public function sendred($money,$openid)
    {
       global $_W,$_GPC;
 		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		$pars = array();
		$pars['mch_id']=$this->module['config']['mch_id'];//商户号;
		$pars['nonce_str'] =$this->make_nonce_str();//随机字符串;
		$pars['mch_billno'] =time().rand(10000,99999);//编号
		$pars['wxappid'] = $this->module['config']['wei_id']; //设置公众号appid;
		$pars['send_name'] ='公众号名称';
		$pars['re_openid'] =$openid;//用户openid
		$pars['total_amount'] =$money*100;//金额
		$pars['total_num'] =1;
		$pars['wishing'] ='感谢参与本次活动';
		$pars['client_ip'] =$_SERVER['REMOTE_ADDR'];  //终端ip;
		$pars['act_name'] ='活动名称';
		$pars['remark'] ='描述';
		$pars['sign'] = $this->make_sign($pars); //生成签名
 		$payData = $this->ToXml($pars);//转成XML数据
        $uniacid=$_W['uniacid'];
     	$extras = array();
				$extras['CURLOPT_SSLCERT'] = IA_ROOT . '/addons/d1sj_yuanxiao/static/cert/apiclient_cert.pem';
				$extras['CURLOPT_SSLKEY'] =IA_ROOT . '/addons/d1sj_yuanxiao/static/cert/apiclient_key.pem';
		$resp=ihttp_request($url,$payData,$extras);
		
		if (is_error($resp)) {
					$procResult = $resp;
			} else {
				$arr=json_decode(json_encode((array) simplexml_load_string($resp['content'])), true);
			 	$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
				$dom = new \DOMDocument();
				if ($dom->loadXML($xml)) {
					$xpath = new \DOMXPath($dom);
					$code = $xpath->evaluate('string(//xml/return_code)');
					$ret = $xpath->evaluate('string(//xml/result_code)');
					if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
						$procResult =  array('errno'=>0,'error'=>'success');;
					} else {
						$error = $xpath->evaluate('string(//xml/err_code_des)');
						$procResult = array('errno'=>-2,'error'=>$error);
					}
				} else {
					$procResult = array('errno'=>-1,'error'=>'未知错误');
				}
			}
		return $procResult;

    }
    //随机字符串
    public function make_nonce_str(){
        $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return md5(str_shuffle($str));
    }
    //生成签名,按照签名生成算法
    public function make_sign($data){
    	$key = $this->module['config']['key_api'];
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string = urldecode(http_build_query($data));
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    public function curl($url,$type=1,$data=null){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        if ($type == 2):
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        endif;
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            return 'Error' . curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
        return $tmpInfo; // 返回数据
    }
    function ToXml($data){
        $xml = "<xml>";
        foreach ($data as $key=>$val){
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
    function FromXml($xml)
    {
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }


 //发送模板消息
 // public function mubanxiaoxi($toopenid,$template_id,$link){

 //        $access_token = $this->getAccessToken();
 //        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
 //        $arr = array(
 //            "touser"=>$toopenid,
 //            "template_id"=>$template_id,
 //            "url"=>$link,
 //            "data"=>array(
 //                "first"=> array(
 //                   "value"=>"元宵PK结果",
 //                   "color"=>"#173177",
 //                ),
 //                "keyword1"=>array(
 //                   "value"=>"元宵灯谜",
 //                   "color"=>"#173177",
 //                ),
 //                "keyword2"=>array(
 //                   "value"=>"元宵灯谜",
 //                   "color"=>"#173177",
 //                ),
 //                "keyword3"=>array(
 //                   "value"=>"元宵灯谜",
 //                   "color"=>"#173177",
 //                ),
 //            )
 //        );

 //        $json = urldecode(json_encode($arr));
 //        $res = $this->curl($url,2,$json);
 //        return  $res;

 //    }


    public function getAccessToken(){
        load()->classs('weixin.account');
        $accObj= WeixinAccount::create(37);
        $access_token = $accObj->fetch_token();
        return  $access_token;
    }




}