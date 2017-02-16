<?php
//引入需要的核心方法
require_once dirname(__FILE__) . "/i18n.php";
require_once dirname(__FILE__) . "/db.class.php";

//版本
$VERSION = "0.0.1";

//初始化对象
$DBUtil = new DBUtil();

//全局变量
global $_W, $_GPC;

?>