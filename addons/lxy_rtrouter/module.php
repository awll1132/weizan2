<?php
/**
 * 微路由
 *
 * @author 大路货 QQ:792454007
 * @url 
 */
defined('IN_IA') or exit('Access Denied');
class Lxy_rtrouterModule extends WeModule {

	public $table_router = 'lxy_rtrouter_info';
	public $table_reply = 'lxy_rtrouter_reply';

	
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0
		global $_W;
		$weid=$_W['uniacid'];
		$routerlist = pdo_fetchall("SELECT id,rname FROM ".tablename($this->table_router)." WHERE weid = :weid ORDER BY `id` DESC", array(':weid' => $weid));
		if (!empty($rid)) {
			$reply = pdo_fetch("SELECT * FROM ".tablename($this->table_reply)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
		}
		include $this->template('form');	
	}
	
	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}
	
	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
		global $_GPC, $_W;
		$id = intval($_GPC['reply_id']);
		$insert = array(
				'rid' => $rid,
				'routerid' => $_GPC['routerid'],
				'oktip' => $_GPC['oktip'],				
		);
		if (empty($id)) {
			pdo_insert($this->table_reply, $insert);
		} else {		
			pdo_update($this->table_reply, $insert, array('id' => $id));
		}
	
	}
	
	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		global $_W;
		$replies = pdo_fetchall("SELECT id  FROM ".tablename($this->table_reply)." WHERE rid = '$rid'");
		$deleteid = array();
		if (!empty($replies)) {
			foreach ($replies as $index => $row) {
				$deleteid[] = $row['id'];
			}
		}
		pdo_delete($this->table_reply, "id IN ('".implode("','", $deleteid)."')");
		return true;
	}
	
	public function settingsDisplay($settings) {
		global $_GPC, $_W;
		if(checksubmit()) {
			$cfg = array(
					'appid' =>trim($_GPC['appid']),
					'appkey' => trim($_GPC['appkey']),
					'authid' => trim($_GPC['authid']),
					'authkey' => trim($_GPC['authkey']),
			);
	

	
			if($this->saveSettings($cfg)) {
				message('保存成功', 'refresh');
			}
			else
			{
				message('保存失败！');
			}
		}
	
		include $this->template('setting');
	}
}
