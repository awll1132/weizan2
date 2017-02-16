<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";

//分页
$page = max(1, intval($_GPC["page"]));
$pagesize = 20;

//条件
$where = "`uniacid`=:uniacid";
$params = array(":uniacid" => $_W["uniacid"]);

//标题
if (!empty($_GPC["title"])) {
	$where .= " AND `title` LIKE :title";
	$params[":title"] = "%" . trim($_GPC["title"]) . "%";
}

//排序
$order = "`createtime` DESC";

//总行
$total = $DBUtil->getYxsCount($where, $params);
//生成分页HTML
$pager = pagination($total, $page, $pagesize);

//列表
$list = $DBUtil->getYxs($where, $params, $order, $page, $pagesize);

load()->func("tpl");
include $this->template("hd");
?>
