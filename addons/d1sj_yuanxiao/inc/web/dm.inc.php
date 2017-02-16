<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";

$ops = array("list", "post", "del");
$op = in_array($_GPC["op"], $ops) ? $_GPC["op"] : $ops[0];

if ($op == "list") {
	//分页
	$page = max(1, intval($_GPC["page"]));
	$pagesize = 20;

	$where = "`uniacid`=:uniacid";
	$params = array(":uniacid" => $_W["uniacid"]);

	//灯谜
	if (!empty($_GPC["question"])) {
		$where .= " AND `question` LIKE :question";
		$params[":question"] = "%" . trim($_GPC["question"]) . "%";
	}

	//总行
	$total = $DBUtil->getDmsCount($where, $params);
	//生成分页HTML
	$pager = pagination($total, $page, $pagesize);

	//记录列表
	$list = $DBUtil->getDms($where, $params, "`createtime` DESC", $page, $pagesize);
	foreach ($list as $key => &$value) {
		$value["fans"] = $DBUtil->getFans("`uniacid`=:uniacid AND `openid`=:openid", array(":uniacid" => $_W["uniacid"], ":openid" => $value["openid"]));
	}
	unset($value);
} elseif ($op == "post") {
	//灯谜
	$dengmi = $DBUtil->getDm("id=:id AND uniacid=:uniacid", array(":id" => intval($_GPC["id"]), ":uniacid" => $_W["uniacid"]));

	if (empty($dengmi)) {
		//新增
		$dengmi["answer"] = array("", "", "");
	} else {
		$dengmi["answer"] = json_decode($dengmi["answer"]);
	}

	if ($_W["ispost"]) {
		shuffle($_GPC["answer"]);
		//数据包
		$data = array(
			"question" => trim($_GPC["question"]),
			"answer" => json_encode($_GPC["answer"]),
			"correct" => trim($_GPC["correct"]),
		);

		//校验
		if (empty($data["question"])) {
			message($i18n["dengmi_question_empty"], "", "error");
		}
		if (empty($data["answer"])) {
			message($i18n["dengmi_answer_empty"], "", "error");
		}
		if (empty($data["answer"])) {
			message($i18n["dengmi_correct_empty"], "", "error");
		}
		if (!in_array($data["correct"], $_GPC["answer"])) {
			message($i18n["dengmi_correct_notin_answer"], "", "error");
		}

		if (empty($dengmi["id"])) {
			//新增
			$data["uniacid"] = $_W["uniacid"];
			$data["createtime"] = TIMESTAMP;
			if ($DBUtil->saveDm($data)) {
				message($i18n["pdo_success"], referer(), "success");
			}
		} else {
			//编辑
			if ($DBUtil->updateDm($data, array("id" => $dengmi["id"], "uniacid" => $_W["uniacid"]))) {
				message($i18n["pdo_success"], referer(), "success");
			}
		}
		message($i18n["pdo_error"], "", "error");
	}
} elseif ($op == "del") {
	//执行
	if ($DBUtil->deleteDm(array("uniacid" => $_W["uniacid"], "id" => intval($_GPC["id"])))) {
		message($i18n["pdo_success"], referer(), "success");
	}
	message($i18n["pdo_error"], "", "error");
}

load()->func("tpl");
include $this->template("dm");
?>