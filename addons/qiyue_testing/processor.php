<?php
/**
 * 趣味测试模块处理程序
 *
 * @author 冯齐跃
 * @url http://fengqiyue.com/
 */
defined('IN_IA') or exit('Access Denied');

class Qiyue_testingModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微赞文档来编写你的代码
	}
}