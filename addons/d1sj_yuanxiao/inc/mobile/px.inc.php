<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";
//手机端自动化
require_once dirname(__FILE__) . "/../../core/mobilebootstrap.php";

//接收分享人的openid
$px_openid=$_GPC['px_openid'];




//接收唯一标识
$jie_only=$_GPC['only'];




//判断pk人的openid跟接收的人opendi是是否一样一样不让进去答题
if($px_openid==$_W['openid']){
	$psk="pxjieshu";

}


//接收过来的唯一标识跟pk人的openid不为空先查询该对pk时是否结束，如结束直接跳转到自己答题页

if(!empty($px_openid)&&!empty($jie_only)){

	$pxs_res=pdo_fetchall('select * from '.tablename('d1sj_yuanxiao_px')." where pks_openid=:pks_openid and  eid=:eid and only=:only and status=2 and pks_status=2 ",array(':pks_openid'=>$px_openid,':eid'=>$_W['uniacid'],':only'=>$jie_only));
	$only_px = pdo_fetch("select * from ".tablename('d1sj_yuanxiao_px')." where only=:only",array(':only'=>$jie_only));
	
	//pk未完成
	//$pxwei_res=pdo_fetchall('select * from '.tablename('d1sj_yuanxiao_px')." where pks_openid=:pks_openid and  eid=:eid and only=:only and status=1 ",array(':pks_openid'=>$px_openid,':eid'=>$_W['uniacid'],':only'=>$jie_only));


	
	if(!empty($pxs_res)){		
		if($_GPC['px_openid'] == $_W['openid']){
	  		$link="http://wfh.weixingzpt.com/app/index.php?i=38&c=entry&do=pk_wangcheng&id=4&m=d1sj_yuanxiao&pks_openid=".$pxs_res['0']['too_openid']."&only=".$jie_only;
	  	 	header("Location:" . $link);

	  	}else{	  	
	  		$link="http://wfh.weixingzpt.com/app/index.php?i=38&c=entry&do=pk_wangcheng&id=4&m=d1sj_yuanxiao&pks_openid=".$pxs_res['0']['pks_openid']."&only=".$jie_only;
	  	 	header("Location:" . $link);
	  	}
	}else if(!empty($only_px['too_openid'])){
		//判断当前openid是否跟pk的openid相同
		if($_GPC['px_openid'] == $_W['openid']){
			$only_px['order_no_pks']=pdo_fetchcolumn("select order_no from ".tablename('d1sj_yuanxiao_correct')." where only=:only and openid=:openid",array(':only'=>$only_px['only'],':openid'=>$only_px['pks_openid']));

			//跳转index页面		
	  		//$link="http://wfh.weixingzpt.com/app/index.php?i=38&c=entry&do=index&id=4&m=d1sj_yuanxiao";
	  	 	$link="http://wfh.weixingzpt.com/app/index.php?i=38&c=entry&do=wancheng&id=4&m=d1sj_yuanxiao&openid=".$only_px['pks_openid']."&order_no=".$only_px['order_no_pks'];
	  	 	header("Location:" . $link);
	  	 	exit;
		}else{
			$only_px['order_no_too']=pdo_fetchcolumn("select order_no from ".tablename('d1sj_yuanxiao_correct')." where only=:only and openid=:openid",array(':only'=>$only_px['only'],':openid'=>$only_px['too_openid']));

			$link="http://wfh.weixingzpt.com/app/index.php?i=38&c=entry&do=wancheng&id=4&m=d1sj_yuanxiao&openid=".$only_px['too_openid']."&order_no=".$only_px['order_no_too'];
			header("Location:" . $link);
			exit;
		}
	}

	

}






//随机一个唯一标识用于分享
$only=make_nonce_str();

//活动查询
$yuanxiao = $DBUtil->getYx("`uniacid`=:uniacid AND `id`=:id", array(":uniacid" => $_W["uniacid"], ":id" => intval($_GPC["id"])));
$yuanxiao["content"] = htmlspecialchars_decode(htmlspecialchars_decode($yuanxiao["content"]));

//活动不存在
if (empty($yuanxiao)) {
	message($i18n["yuanxiao_empty"], "", "success");
}

//强制关注
if ($yuanxiao["followjoin"] && $_W["account"]["level"] == 4 && empty($_W["fans"]["follow"])) {
	header("Location:" . $yuanxiao["followurl"]);
	exit();
}
$yuanxiao["sharelink"]=$yuanxiao["sharelink"]."&px_openid=".$_W['openid']."&only=".$only;


//分享设置
$sharedata = array(
	"title" => $yuanxiao["sharetitle"],
	"imgUrl" => empty($yuanxiao["shareimage"]) ? $_W["fans"]["tag"]["avatar"] : tomedia($yuanxiao["shareimage"]),
	"desc" => $yuanxiao["sharedesc"],
	"link" => empty($yuanxiao["sharelink"]) ? $_W["siteroot"] . "app/" . substr($this->createMobileUrl("index", array("id" => $yuanxiao["id"], "fromid" => $record["id"])), 2) : $yuanxiao["sharelink"],
);
//分享添加数据
if($_W['isajax']&&!empty($_GPC['share'])){
	$openid=$_W['openid'];
	//判断是否分享10次
	$t = time();
	$starttime=mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
	$endtime = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
	$is_over = pdo_fetchcolumn("select count(id) from ".tablename('d1sj_yuanxiao_px')." where pks_openid=:openid and time>:starttime and time<:endtime",array(':openid'=>$_W['openid'],':starttime'=>$starttime,':endtime'=>$endtime));
	if($is_over>=10){
		die(json_encode(array('infos'=>2,'msg'=>'今日超过分享次数')));
	}
	$data=array(
		'pks_openid'=>$openid,
		'eid'       =>$_W['uniacid'],
		'time'      =>time(),
		'only'		=>$_GPC['only'],
		);
	$res=pdo_insert('d1sj_yuanxiao_px',$data);
	if($res){
		die(json_encode(array('infos'=>1,'msg'=>'分享成功','only'=>$_GPC['only'])));

	}

}







include $this->template($settings["themes"] . "/px");

//随机字符串
function make_nonce_str(){
    $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $strs=substr($str,0,16);
    return md5(str_shuffle($strs));
}





?>

	