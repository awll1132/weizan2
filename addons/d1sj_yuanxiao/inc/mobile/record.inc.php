<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";
//手机端自动化
require_once dirname(__FILE__) . "/../../core/mobilebootstrap.php";

//回复内容
$return["error_code"] = "0000";
$return["error_msg"] = "YUANXIAO_RECORD_ERROR";

if ($_W["ispost"]) {
	$yuanxiao = $DBUtil->getYx("`uniacid`=:uniacid AND `id`=:id", array(":uniacid" => $_W["uniacid"], ":id" => intval($_GPC["id"])));

	//我的记录
	$record = $DBUtil->getRecord("`uniacid`=:uniacid AND `yid`=:yid AND `openid`=:openid", array(":uniacid" => $_W["uniacid"], ":yid" => $yuanxiao["id"], ":openid" => $_W["fans"]["from_user"]));

	if (empty($_W["fans"]["from_user"])) {
		//粉丝openid 未获取到
		$return["error_code"] = "0001";
		$return["error_msg"] = "USER_FANSINFO_EMPTY";
	} elseif (empty($yuanxiao)) {
		//活动不存在
		$return["error_code"] = "0002";
		$return["error_msg"] = "YUANXIAO_EMPTY";
	} elseif ($yuanxiao["followjoin"] && $_W["account"]["level"] == 4 && empty($_W["fans"]["follow"])) {
		$return["error_code"] = "0003";
		$return["followurl"] = $yuanxiao["followurl"];
		$return["error_msg"] = "USER_FOLLOW_ERROR";
	} elseif ($yuanxiao["starttime"] > TIMESTAMP) {
		//活动未开始
		$return["error_code"] = "0004";
		$return["error_msg"] = "YUANXIAO_STARTTIME_ERROR";
	} elseif ($yuanxiao["endtime"] < TIMESTAMP) {
		//活动已结束
		$return["error_code"] = "0005";
		$return["error_msg"] = "YUANXIAO_ENDTIME_ERROR";
	} elseif (!empty($record)) {
		//已参与 | 防复写
		$return["error_code"] = "0006";
		$return["error_msg"] = "YUANXIAO_RECORD_ERROR";
	} elseif ($user_credits["credit1"] + $yuanxiao["joincredit"] < 0) {
		//积分不足 | 存在参与减积分
		$return["error_code"] = "0007";
		$return["joincredit"] = abs($yuanxiao["joincredit"]);
		$return["error_msg"] = "YUANXIAO_CREDIT1_ERROR";
	} else {
		//可执行
		//数据包
		$data = array(
			"uniacid" => $_W["uniacid"],
			"yid" => $yuanxiao["id"],
			"openid" => $_W["fans"]["from_user"],
			"nickname" => $_W["fans"]["tag"]["nickname"],
			"avatar" => $_W["fans"]["tag"]["avatar"],
			"number" => intval($_GPC["number"]),
			"ip" => CLIENT_IP,
			"createtime" => TIMESTAMP,
		);
		//写记录
		if ($DBUtil->saveRecord($data)) {
			//参与成功
			$return["error_code"] = "1000";
			$return["error_msg"] = "YUANXIAO_RECORD_SUCCESS";
			//操作积分
			load()->model("mc");
			mc_credit_update($_W["member"]["uid"], "credit1", $yuanxiao["joincredit"], array(0, "参与" . $yuanxiao["title"]));
			//更新砍价信息 | 参与+1
			$DBUtil->updateYxJoin($yuanxiao["id"], $_W["uniacid"]);
		}
	}
}

echo json_encode($return);exit;
?>