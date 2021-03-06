<?php
/**
 * 简单预约模块定义
 *
 * @author junsion
 * @url http://www.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

class boyhood_bookModule extends WeModule {
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
		global $_W,$_GPC;
		$cates = pdo_fetchall('select * from '.tablename($this->modulename."_cate")." where weid='{$_W['uniacid']}'");
		$rule = pdo_fetch('select * from '.tablename($this->modulename."_rule")." where rid='{$rid}'");
		include $this->template('form');
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
		global $_W,$_GPC;
		$data = array(
				'rid'=>$rid,
				'weid'=>$_W['weid'],
				'title'=>$_GPC['title'],
				'thumb'=>$_GPC['thumb'],
				'description'=>$_GPC['description'],
				'starttime'=>strtotime($_GPC['datelimit']['start']),
				'endtime'=>strtotime($_GPC['datelimit']['end']),
				'sharetitle'=>$_GPC['sharetitle'],
				'sharethumb'=>$_GPC['sharethumb'],
				'sharedesc'=>$_GPC['sharedesc'],
				'cate'=>$_GPC['cate'],
			);
		$rule = pdo_fetch('select * from '.tablename($this->modulename."_rule")." where rid='{$rid}'");
		if (!empty($rule)){
			pdo_update($this->modulename."_rule",$data,array('id'=>$rule['id']));
		}else{
			pdo_insert($this->modulename."_rule",$data);
		}
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		pdo_delete($this->modulename."_rule",array('rid'=>$rid));
		pdo_delete($this->modulename."_record",array('rid'=>$rid));
	}

}