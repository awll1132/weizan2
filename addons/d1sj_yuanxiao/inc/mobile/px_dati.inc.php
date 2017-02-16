<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";
//手机端自动化
require_once dirname(__FILE__) . "/../../core/mobilebootstrap.php";

global $_W,$_GPC;

//先判断时间是否过期
$dingshi=$_GPC['dingshi'];
if($_W['isajax']&&!empty($dingshi)){
	$openid=$_W['openid'];
	$order_no=$_GPC['order_no'];
	$pks_openid=$_GPC['pks_openid'];
	$only=$_GPC['only'];
	
	$px_list=$_GPC['px_list'];

	
	$order_res=pdo_fetchall('select count(ti_id) as dati_shu from '.tablename('d1sj_yuanxiao_correct')." where eid=:eid and openid=:openid and order_no=:order_no and status = 1 ",array(':eid'=>$_W['uniacid'],':openid'=>$openid,':order_no'=>$order_no));

	if($order_res){
		//答题结束将匹对关系改为
	

		$pd_res=pdo_fetch('select * from '.tablename('d1sj_yuanxiao_px')." where only=:only",array(':only'=>$only));
		
		if(!empty($pd_res)){
			if($pd_res['too_openid']==$_W['openid']){
				$data=array(
					'status'    =>2,
					);
				$uo_res_ss=pdo_update('d1sj_yuanxiao_px',$data,array('id'=>$pd_res['id']));
			}else{
				pdo_update('d1sj_yuanxiao_px',array('pks_status'=>2),array('id'=>$pd_res['id']));
			}
		}


		die(json_encode(array('infos'=>1,'msg'=>'时间到','ti_shuju'=>$order_res['0']['dati_shu'],'px_list'=>$px_list)));

	}else{
		die(json_encode(array('infos'=>2,'msg'=>'时间到','ti_shuju'=>0,'px_list'=>$px_list)));
		
	}


}


//查询对应的题库表
$ti_id=$_GPC['ti_id'];
if($_W['isajax']&&!empty(intval($ti_id))){
	$pks_openid=$_GPC['pks_openid'];
	$order_no=$_GPC['order_no'];
	$correct=$_GPC['da'];
	$only=$_GPC['only'];
	$px_list=$_GPC['px_list'];
	//答题正确插入正确数据
	$correct_res=pdo_fetch('select * from '.tablename('d1sj_yuanxiao_dm').' where id= '.$ti_id);

	$res=pdo_fetch('select * from '.tablename('d1sj_yuanxiao_correct').' where ti_id= '.$ti_id.' and order_no ='.$order_no);
	if(empty($res)&&$correct_res['correct']==$correct){
			$data=array(
				'ti_id'  =>$ti_id,
				'openid' =>$_W['openid'],
				'time'   =>time(),//记录最新时间段的答题记录
				'eid'    =>$_W['uniacid'],
				'order_no'=>$order_no,
				'only'    =>$only,
				);
			$rs=pdo_insert("d1sj_yuanxiao_correct",$data);
		
	}

	$ti_list=pdo_fetchall('select * from '.tablename('d1sj_yuanxiao_dm').' where uniacid=:uniacid and id >'.$ti_id." limit 1 ",array(':uniacid'=>$_W['uniacid']));
	$timu_list=array();
	if($ti_list){
	
		foreach($ti_list as $k=>$va){
				if($va['answer']){
					$answer=json_decode($va['answer'],true);
					$timu_list['answer'][]=array_slice($answer,0,3);

				}

		}

		$xia='';
		foreach ($ti_list as $k=> $v) {
				$xia.='
				<div class="top_bg">
			        <div class="score"></div>
			        <div style="color: transparent">1</div>
			        <div class="ti">

			            <p class="title">第'.($ti_id+1).'题</p>
			            <span class="ti_detail">'.$v['question'].'</span>
			        </div>
			    </div>
			    <input type="hidden" name="ti_id" value="'.$v['id'].'">
        		<input type="hidden" name="correct" value="'.$v['correct'].'">
        		<input type="hidden" name="order_no" value="'.$order_no.'"/>
        		<input type="hidden" name="only" value="'.$only.'"/>
        		<input type="hidden" name="pks_openid" value="'.$pks_openid.'">
        		<input type="hidden" name="px_list" value="'.$px_list.'">
			    <div class="bottom_bg">
			        <h3 class="check">请选择正确的答案</h3>
			        <ul class="ti_list">';
			        foreach($timu_list["answer"] as $ka=>$va){
			            $xia .= '<li class="da_an" arr="'.$va['0'].'"><span>A.'.$va['0'].'</span><b></b></li>
			            <li class="da_an" arr="'.$va['1'].'"><span>B.'.$va['1'].'</span><b></b></li>
			            <li class="da_an" arr="'.$va['2'].'"><span>C.'.$va['2'].'</span><b></b></li>';
			        }
			        $xia .= '</ul>
			    </div>
			    ';
		}
		
		die(json_encode(array('shuju'=>1,'msg'=>'下一题','xia'=>$xia)));

	}else{
		//答题结束将匹对关系改为
		$pd_res=pdo_fetch('select * from '.tablename('d1sj_yuanxiao_px')." where pks_openid=:pks_openid and only=:only and eid=:eid ",array(':pks_openid'=>$pks_openid,':only'=>$only,':eid'=>$_W['uniacid']));
		
		if(!empty($pd_res)){
			if($pd_res['too_openid']==$_W['openid']){
				$data=array(
					'status'    =>2,
					);
				pdo_update('d1sj_yuanxiao_px',$data,array('id'=>$pd_res['id']));
			}else{
				pdo_update('d1sj_yuanxiao_px',array('pks_status'=>2),array('id'=>$pd_res['id']));
			}
		}
		$order_res=pdo_fetchall('select count(ti_id) as dati_shu from '.tablename('d1sj_yuanxiao_correct')." where eid=:eid and openid=:openid and order_no=:order_no ",array(':eid'=>$_W['uniacid'],':openid'=>$_W['openid'],':order_no'=>$order_no));
		
		die(json_encode(array('shuju'=>2,'msg'=>'答题结束','ti_shuju'=>$order_res['0']['dati_shu'])));
		
	}


}else{
// 获取用户头像和昵称
$userinfo = mc_oauth_userinfo();

$user_lisr=pdo_fetchall('select openid from '.tablename('d1sj_yuanxiao_member')." where openid =:openid and eid=:eid ",array(':openid'=>$_W['openid'],':eid'=>$_W['uniacid']));
if(empty($user_lisr)){
	  $row = array(
        'eid' => $_W['uniacid'],
        'headimgurl'=>$userinfo['headimgurl'],
        'nickname'=>$userinfo['nickname'],
        'openid' => $_W['openid'],
        'frequency'=>0,
        'balance'=>0,
        'city'=>$userinfo['city'],
    );
    pdo_insert('d1sj_yuanxiao_member', $row);
}
//判断当前用户是否发起pk

$only=$_GPC['only']?$_GPC['only']:'';
//发起px人的openid
$pks_openid=$_GPC['pks_openid'];

$px_list=pdo_fetch('select * from '.tablename('d1sj_yuanxiao_px')." where eid=:eid and pks_openid=:pks_openid and only=:only ",array(':eid'=>$_W['uniacid'],':pks_openid'=>$pks_openid,':only'=>$only));
$res_px=pdo_fetch('select * from '.tablename('d1sj_yuanxiao_px')." where eid=:eid and pks_openid=:pks_openid and only=:only and too_openid=:too_openid ",array(':eid'=>$_W['uniacid'],':pks_openid'=>$pks_openid,':only'=>$only,':too_openid'=>$_W['openid']));



if(empty($res_px)&&!empty($px_list)){
	$data=array(
	'pks_openid'=>$px_list['pks_openid'],
	'too_openid'=>$_W['openid'],
	'eid'       =>$_W['uniacid'],
	'only'		=>$px_list['only'],

	);
	pdo_update('d1sj_yuanxiao_px',$data,array('id'=>$px_list['id']));

}
if(!empty($only)&&!empty($pks_openid)){
	//修改px数据
	$px_list=$_GPC['only'];



}
$order_no=order();
$ti_list=pdo_fetchall('select * from '.tablename('d1sj_yuanxiao_dm').' where uniacid=:uniacid limit 1',array(':uniacid'=>$_W['uniacid']));
$timu_list=array();

if(!empty($ti_list)){
	foreach($ti_list as $k=>$va){
			if($va['answer']){
				$answer=json_decode($va['answer'],true);
				
				$timu_list['answer'][]=array_slice($answer,0,3);

			}

	}

}

include $this->template($settings["themes"] . "/pkdati");die;


}




function order(){
    //生成24位唯一订单号码，格式：YYYY-MMDD-HHII-SS-NNNN,NNNN-CC，其中：YYYY=年份，MM=月份，DD=日期，HH=24格式小时，II=分，SS=秒，NNNNNNNN=随机数，CC=检查码
      @date_default_timezone_set("PRC");
      //订购日期
      $order_date = date('Y-m-d');
      //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
      $order_id_main = date('YmdHis') . rand(10000000,99999999);
      //订单号码主体长度
      $order_id_len = strlen($order_id_main);
      $order_id_sum = 0;
      for($i=0; $i<$order_id_len; $i++){
        $order_id_sum += (int)(substr($order_id_main,$i,1));
      }
      //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
      $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);
     return $order_id;
  }
     


 function getAccessToken(){
        load()->classs('weixin.account');
        $accObj= WeixinAccount::create($_W['uniacid']);
        $access_token = $accObj->fetch_token();
        return  $access_token;
   }

 function curl($url,$type=1,$data=null)
{
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
//发送模板消息
function mubanxiaoxi($toopenid,$template_id,$link,$name){

    $access_token =getAccessToken();
    $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
    $arr = array(
        "touser"=>$toopenid,
        "template_id"=>$template_id,
        "url"=>$link,
        "data"=>array(
            "first"=> array(
               "value"=>$name."   ：恭喜您获得抽奖机会",
               "color"=>"#173177",
            ),
            "keyword1"=>array(
               "value"=>'彩灯迷',
               "color"=>"#173177",
            ),

            "keyword3"=>array(
               "value"=>"幸运大转盘",
               "color"=>"#173177",
            ),
        )
    );

    $json = urldecode(json_encode($arr));
    $res =curl($url,2,$json);
    return  $res;

}

?>