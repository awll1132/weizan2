<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";

$ops = array("list", "del");
$op = in_array($_GPC["op"], $ops) ? $_GPC["op"] : $ops[0];

if ($op == "list") {
	//分页
	$page = max(1, intval($_GPC["page"]));
	$pagesize = 15;

	$where = "`uniacid`=:uniacid AND `yid`=:yid";
	$params = array(":uniacid" => $_W["uniacid"], ":yid" => intval($_GPC["id"]));

	//昵称
	if (!empty($_GPC["nickname"])) {
		$where .= " AND `nickname` LIKE :nickname";
		$params[":nickname"] = "%" . trim($_GPC["nickname"]) . "%";
	}

	//编号
	if (!empty($_GPC["openid"])) {
		$where .= " AND `openid` = :openid";
		$params[":openid"] = trim($_GPC["openid"]);
	}

	//总行
	$total = $DBUtil->getRecordsCount($where, $params);
	//生成分页HTML
	$pager = pagination($total, $page, $pagesize);

	//记录列表
	$list = $DBUtil->getRecords($where, $params, "`number` DESC,`createtime` ASC", $page, $pagesize);
	foreach ($list as $key => &$value) {
		$value["fans"] = $DBUtil->getFans("`uniacid`=:uniacid AND `openid`=:openid", array(":uniacid" => $_W["uniacid"], ":openid" => $value["openid"]));
	}
	unset($value);

	//导出表格
	if (checksubmit("submit", 1)) {
		$list = $DBUtil->getRecords($where, $params, "`number` DESC,`createtime` ASC");
		//导出操作
		$html = "\xEF\xBB\xBF";
		$header = array("#", "昵称", "粉丝编号", "猜中灯谜/题", "参与时间", "邀请好友参与", "IP");
		foreach ($header as $key => $value) {
			$html .= $value . "\t,";
		}
		$html .= "\n";
		foreach ($list as $key => $value) {
			$html .= ++$key . "\t,";
			$html .= trim($value["nickname"]) . "\t,";
			$html .= $value["openid"] . "\t,";
			$html .= $value["number"] . "\t,";
			$html .= date("Y-m-d H:i:s", $value["createtime"]) . "\t,";
			$html .= empty($value["share"]) ? "否" . "\t," : "是" . "\t,";
			$html .= $value["ip"] . "\t,";
			$html .= "\n";
		}

		header("Content-type:application/vnd.ms-excel;charset=UTF-8");
		header("Content-Disposition:attachment; filename=" . urlencode("参与记录" . date("Y-m-d H:i:s", TIMESTAMP)) . ".csv");
		echo $html;
		exit;
	}

} elseif ($op == "del") {
	//执行
	if ($DBUtil->deleteRecord(array("uniacid" => $_W["uniacid"], "id" => intval($_GPC["id"])))) {
		message($i18n["pdo_success"], referer(), "success");
	}
	message($i18n["pdo_error"], "", "error");
}

load()->func("tpl");
include $this->template("record");
?>