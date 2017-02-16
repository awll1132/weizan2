<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";
//手机端自动化
require_once dirname(__FILE__) . "/../../core/mobilebootstrap.php";

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

// //灯谜
 //$dengmilist = $DBUtil->getDms("`uniacid`=:uniacid", array(":uniacid" => $_W["uniacid"]), "`createtime` DESC", 1, $yuanxiao["dengmi"] * 2);
// //打乱
//shuffle($dengmilist);

// //截取指定长度
// $dengmilist = array_slice($dengmilist, 0, $yuanxiao["dengmi"]);
// //转换
// $data = array();
// foreach ($dengmilist as $key => $value) {
// 	$data[] = array(
// 		"q" => $value["question"],
// 		"a" => json_decode($value["answer"]),
// 		"r" => $value["correct"],
// 	);
// }

// //我的记录
// $record = $DBUtil->getRecord("`uniacid`=:uniacid AND `yid`=:yid AND `openid`=:openid", array(":uniacid" => $_W["uniacid"], ":yid" => $yuanxiao["id"], ":openid" => $_W["fans"]["from_user"]));
//唯一标识的随机数



$only=make_nonce_str();


$yuanxiao["sharelink"]=$yuanxiao["sharelink"]."&px_openid=".$_W['openid']."&only=".$only;



//分享设置
$sharedata = array(
	"title" => $yuanxiao["sharetitle"],
	"imgUrl" => empty($yuanxiao["shareimage"]) ? $_W["fans"]["tag"]["avatar"] : tomedia($yuanxiao["shareimage"]),
	"desc" => $yuanxiao["sharedesc"],
	"link" => empty($yuanxiao["sharelink"]) ? $_W["siteroot"] . "app/" . substr($this->createMobileUrl("index", array("id" => $yuanxiao["id"], "fromid" => $record["id"])), 2) : $yuanxiao["sharelink"],
);

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


// //转换
// $sharedata["title"] = str_replace("#粉丝昵称#", $_W["fans"]["tag"]["nickname"], $yuanxiao["sharetitle"]);

// //页面标题
// $_W["page"]["title"] = $i18n["page_title_index"];

// //助力加分
// if (!empty($_GPC["fromid"])) {
// 	$DBUtil->updateRecord(array("share" => 1), array("uniacid" => $_W["uniacid"], "id" => intval($_GPC["fromid"])));
// }

//加载页面
include $this->template($settings["themes"] . "/index");
//随机字符串
function make_nonce_str(){
    $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $strs=substr($str,0,16);
    return md5(str_shuffle($strs));
}
?>
