<?php
//限制下客户端浏览器
// if ($_W["container"] != "wechat") {
// 	die("该页面为微信认证页面，非微信APP不能访问！");
// }

//参数设置
$settings = $this->module["config"];
if (empty($settings["themes"])) {
	$settings["themes"] = "default";
}


//分享设置
$sharedata = array(
	"title" => $settings["sharetitle"],
	"imgUrl" => tomedia($settings["shareimg"]),
	"desc" => $settings["sharedesc"],
	"link" => $settings["sharelink"],
);

//加载会员相关函数
load()->model("mc");

//会员 | 积分 | 余额
$user_credits = mc_credit_fetch($_W["member"]["uid"]);
//格式转化
$user_credits["credit1"] = floatval($user_credits["credit1"]);
$user_credits["credit2"] = floatval($user_credits["credit2"]);

//服务号 | 订阅号借用授权
if ($_W["account"]["level"] >= 3) {
	$_W["fans"]["tag"] = mc_oauth_userinfo($_W["account"]["acid"]);
}
?>