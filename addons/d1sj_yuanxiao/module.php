<?php
defined('IN_IA') or exit('Access Denied');

class D1sj_yuanxiaoModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
		//引入需要的核心方法
		require_once dirname(__FILE__) . "/core/i18n.php";
		require_once dirname(__FILE__) . "/core/db.class.php";

		//初始化对象
		$DBUtil = new DBUtil();

		//全局变量
		global $_W, $_GPC;

		//编辑 or 创建
		if (empty($_GPC["rid"])) {
			//灯谜 | 时间默认加1天
			$yuanxiao = array("starttime" => date("Y-m-d", TIMESTAMP), "endtime" => date("Y-m-d", TIMESTAMP + 86400));
		} else {
			//砍价
			$yuanxiao = $DBUtil->getYx("rid=:rid AND uniacid=:uniacid", array(":rid" => intval($_GPC["rid"]), ":uniacid" => $_W["uniacid"]));
			//转换
			$yuanxiao["content"] = htmlspecialchars_decode($yuanxiao["content"]);
			$yuanxiao["starttime"] = date("Y-m-d H:i:s", $yuanxiao["starttime"]);
			$yuanxiao["endtime"] = date("Y-m-d H:i:s", $yuanxiao["endtime"]);
		}

		load()->func("tpl");
		include $this->template("post");
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		//引入需要的核心方法
		require_once dirname(__FILE__) . "/core/i18n.php";
		require_once dirname(__FILE__) . "/core/db.class.php";

		//初始化对象
		$DBUtil = new DBUtil();

		//全局变量
		global $_W, $_GPC;

		//标题不可为空
		if (empty($_GPC['title'])) {
			return $i18n["yuanxiao_title_empty"];
		}
		//封面
		if (empty($_GPC['cover'])) {
			return $i18n["yuanxiao_cover_empty"];
		}
		//详情
		if (empty($_GPC['content'])) {
			return $i18n["yuanxiao_content_empty"];
		}
		//灯谜需要大于0
		if ($_GPC['dengmi'] < 1) {
			return $i18n["yuanxiao_dengmi_min_one"];
		}
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
		//引入需要的核心方法
		require_once dirname(__FILE__) . "/core/i18n.php";
		require_once dirname(__FILE__) . "/core/db.class.php";

		//初始化对象
		$DBUtil = new DBUtil();

		//全局变量
		global $_W, $_GPC;

		//数据包
		$data = array(
			"title" => trim($_GPC["title"]),
			"cover" => trim($_GPC["cover"]),
			"content" => htmlspecialchars($_GPC["content"]),
			"starttime" => strtotime(trim($_GPC["time"]["start"])),
			"endtime" => strtotime(trim($_GPC["time"]["end"])),
			"dengmi" => intval($_GPC["dengmi"]),
			"joincredit" => trim($_GPC["joincredit"]),
			"helpcredit" => trim($_GPC["helpcredit"]),
			"followjoin" => intval($_GPC["followjoin"]),
			"followhelp" => intval($_GPC["followhelp"]),
			"followurl" => trim($_GPC["followurl"]),
			"sharetitle" => trim($_GPC["sharetitle"]),
			"shareimage" => trim($_GPC["shareimage"]),
			"sharedesc" => trim($_GPC["sharedesc"]),
			"sharelink" => trim($_GPC["sharelink"]),
		);
		
		if (empty($_GPC["id"])) {
			//新增
			$data["rid"] = $rid;
			$data["uniacid"] = $_W["uniacid"];
			$data["createtime"] = TIMESTAMP;
			$DBUtil->saveYx($data);
		} else {
			//修改
			$DBUtil->updateYx($data, array("rid" => $rid, "uniacid" => $_W["uniacid"]));
		}
		return true;
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		//引入需要的核心方法
		require_once dirname(__FILE__) . "/core/i18n.php";
		require_once dirname(__FILE__) . "/core/db.class.php";

		//初始化对象
		$DBUtil = new DBUtil();

		//全局变量
		global $_W, $_GPC;
		if (!empty($rid)) {
			//删除
			$DBUtil->deleteYx(array("rid" => $rid, "uniacid" => $_W["uniacid"]));
			//删除其他记录
		}
	}

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		//引入需要的核心方法
		require_once dirname(__FILE__) . "/core/i18n.php";
		require_once dirname(__FILE__) . "/core/db.class.php";

		//初始化对象
		$DBUtil = new DBUtil();

		//全局变量
		global $_W, $_GPC;

		//文件夹列表
		$templates = array();
		$path = MODULE_ROOT . "/template/mobile/";
		if (is_dir($path)) {
			if ($handle = opendir($path)) {
				while (false !== ($templatepath = readdir($handle))) {
					if ($templatepath != "." && $templatepath != "..") {
						if (is_dir($path . $templatepath)) {
							$templates[] = $templatepath;
						}
					}
				}
			}
		}
		if (checksubmit()) {
			//字段验证, 并获得正确的数据$data
			$data = array(
				"themes" => trim($_GPC["themes"]),
				"key_api"=>$_GPC["key_api"],
				"mch_id"=>$_GPC["mch_id"],
				"wei_id"=>$_GPC["wei_id"],
			);
			//广告位end
			if ($this->saveSettings($data)) {
				message($i18n["pdo_success"], referer(), "success");
			} else {
				message($i18n["pdo_error"], "", "error");
			}
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}