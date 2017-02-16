<?php
/**
 * 数据库类
 * @author 	healer
 */
class DBUtil {
	const TB_YUANXIAO = "d1sj_yuanxiao";
	const TB_DENGMI = "d1sj_yuanxiao_dm";
	const TB_RECORD = "d1sj_yuanxiao_record";
	const TB_FANS = "mc_mapping_fans";
	const TB_RULE_KEYWORD = "rule_keyword";
	const TB_USERS = "users";
	const TB_MODULES = "uni_account_modules";

	/**
	 * 各个公众号的模块配置
	 */
	public function getModules($where, $params, $order = "", $page = 1, $pagesize = 0, $op = "AND") {
		return self::getMany(self::TB_MODULES, $where, $params, $order, $page, $pagesize, $op);
	}

	/**
	 * 关键词
	 */
	public function getRuleKW($where, $params) {
		return self::getOne(self::TB_RULE_KEYWORD, $where, $params);
	}

	/**
	 * 粉丝
	 */
	public function getFans($where, $params) {
		return self::getOne(self::TB_FANS, $where, $params);
	}

	/**
	 * 参与记录
	 */
	public function updateRecord($data, $params) {
		return self::update(self::TB_RECORD, $data, $params);
	}
	public function saveRecord($data) {
		return self::save(self::TB_RECORD, $data);
	}
	public function getRecordsCount($where, $params) {
		return self::getCount(self::TB_RECORD, $where, $params);
	}
	public function getRecords($where, $params, $order = "", $page = 1, $pagesize = 0, $op = "AND") {
		return self::getMany(self::TB_RECORD, $where, $params, $order, $page, $pagesize, $op);
	}
	public function getRecord($where, $params) {
		return self::getOne(self::TB_RECORD, $where, $params);
	}
	public function deleteRecord($params) {
		return self::delete(self::TB_RECORD, $params);
	}

	/**
	 * 灯谜
	 */
	public function updateDm($data, $params) {
		return self::update(self::TB_DENGMI, $data, $params);
	}
	public function saveDm($data) {
		return self::save(self::TB_DENGMI, $data);
	}
	public function getDmsCount($where, $params) {
		return self::getCount(self::TB_DENGMI, $where, $params);
	}
	public function getDms($where, $params, $order = "", $page = 1, $pagesize = 0, $op = "AND") {
		return self::getMany(self::TB_DENGMI, $where, $params, $order, $page, $pagesize, $op);
	}
	public function getDm($where, $params) {
		return self::getOne(self::TB_DENGMI, $where, $params);
	}
	public function deleteDm($params) {
		return self::delete(self::TB_DENGMI, $params);
	}

	/**
	 * 活动
	 */
	public function updateYxJoin($rid = 0, $uniacid = 0) {
		return pdo_query("UPDATE " . tablename(self::TB_YUANXIAO) . " SET `join`=`join`+1 WHERE id=:id AND uniacid=:uniacid", array(":id" => $id, ":uniacid" => $uniacid));
	}
	public function updateYx($data, $params) {
		return self::update(self::TB_YUANXIAO, $data, $params);
	}
	public function saveYx($data) {
		return self::save(self::TB_YUANXIAO, $data);
	}
	public function getYxsCount($where, $params) {
		return self::getCount(self::TB_YUANXIAO, $where, $params);
	}
	public function getYxs($where, $params, $order = "", $page = 1, $pagesize = 0, $op = "AND") {
		return self::getMany(self::TB_YUANXIAO, $where, $params, $order, $page, $pagesize, $op);
	}
	public function getYx($where, $params) {
		return self::getOne(self::TB_YUANXIAO, $where, $params);
	}
	public function deleteYx($params) {
		return self::delete(self::TB_YUANXIAO, $params);
	}
	/**
	 * 核心
	 */
	//总数
	private function getCount($table, $where, $params) {
		return pdo_fetchcolumn("SELECT COUNT(*) AS `number` FROM " . tablename($table) . " WHERE $where ", $params);
	}
	//列表
	private function getMany($table, $where, $params, $order = "", $page = 1, $pagesize = 0, $op = "AND") {
		$sql = "SELECT * FROM " . tablename($table) . " WHERE $where";
		if (!empty($order)) {
			$sql .= " ORDER BY " . $order;
		}
		if (!empty($pagesize)) {
			$sql .= " LIMIT " . ($page - 1) * $pagesize . "," . $pagesize;
		}
		return pdo_fetchall($sql, $params, $op);
	}
	//单个
	private function getOne($table, $where, $params, $op = "AND") {
		return pdo_fetch("SELECT * FROM " . tablename($table) . " WHERE $where", $params, $op);
	}
	//修改
	private function update($table, $data, $params, $op = "AND") {
		return pdo_update($table, $data, $params, $op);
	}
	//新增
	private function save($table, $data) {
		return pdo_insert($table, $data);
	}
	//删除
	private function delete($table, $params, $op = "AND") {
		return pdo_delete($table, $params, $op);
	}
}
?>
