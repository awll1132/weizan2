<?php
defined('IN_IA') or exit('Access Denied');

class D1sj_yuanxiaoModuleProcessor extends WeModuleProcessor {
	public function respond() {
		//$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
		//引用自动化
		require_once dirname(__FILE__) . "/core/bootstrap.php";

		$yuanxiao = $DBUtil->getYx("`uniacid`=:uniacid AND `rid`=:rid", array(":uniacid" => $_W["uniacid"], ":rid" => $this->rule));

		if (!empty($yuanxiao)) {
			if (empty($yuanxiao["shareimage"]) || empty($yuanxiao["sharedesc"])) {
				return $this->respText('<a href="' . $_W["siteroot"] . "app/" . $this->createMobileUrl("index", array("id" => $yuanxiao["id"])) . '">点击参与' . $yuanxiao["title"] . '</a>');
			} else {
				return $this->respNews(
					array(
						"title" => $yuanxiao["title"],
						"description" => $yuanxiao["sharedesc"],
						"picurl" => tomedia($yuanxiao["shareimage"]),
						"url" => $_W["siteroot"] . "app/" . $this->createMobileUrl("index", array("id" => $yuanxiao["id"])),
					)
				);
			}
		}
	}
}