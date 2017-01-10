<?php
/**
 * 趣味测试模块微站定义
 *
 * @author 冯齐跃
 * @url http://fengqiyue.com/
 */
defined('IN_IA') or exit('Access Denied');
define('MODULE_ROOT', str_replace("\\",'/', dirname(__FILE__)).'/');
define('APP_PUBLIC', str_replace(IA_ROOT,'', MODULE_ROOT));
load()->func('communication');
class Qiyue_testingModuleSite extends WeModuleSite {


	public function doWebQuery() {
		global $_W, $_GPC;
		$kwd = $_GPC['keyword'];
		$sql = 'SELECT id,title,photo,smalltext FROM '.tablename('qiyue_testing').' WHERE `weid`=:weid AND `title` LIKE :title ORDER BY id DESC LIMIT 0,8';
		$params = array();
		$params[':weid'] = $_W['weid'];
		$params[':title'] = "%{$kwd}%";
		$ds = pdo_fetchall($sql, $params);
		foreach($ds as &$row) {
			$r = array();
			$r['id'] = $row['id'];
			$r['title'] = $row['title'];
			$r['description'] = cutstr(strip_tags($row['smalltext']), 100);
			$r['thumb'] = toimage($row['photo']);
			$row['entry'] = $r;
		}
		include $this->template('query');
	}

	// 测试管理
	public function doWebManage() {
		global $_GPC, $_W, $do;

		load()->func('file');
		$op = $_GPC['op'];
		$id = intval($_GPC['id']);
		if($_W['isajax']){
			// 删除测试
			if( $op=='delete' ){
				if(!$id){
					message('测试ID为空！');
				}
				$item = $this->getTestinfo($id, array('cover', 'banner'));
				if (empty($item['id'])) {
					message('抱歉，信息不存在或是已经被删除！');
				}
				// 删除图片
				if($item['cover']){
					file_delete($item['cover']);
				}
				if($item['banner']){
					file_delete($item['banner']);
				}
				pdo_delete('qiyue_testing', array('id' => $item['id']));
				// 修改题量
				$this->setTitlenum($data['typeid']);
				message(array('state'=>0), '', 'ajax');
			}
			message('未知错误', referer(), 'ajax');
		}

		// 添加/编辑
		if($op=='add'){
			if($id){
				$item = $this->getTestinfo($id);
				if(empty($item['id'])){
					message('该测试不存在！');
				}
				if($item['setting']){
					$item['setting'] = iunserializer($item['setting']);
				}
			}
			// 表单提交验证
			if (checksubmit()) {
				$data = $_GPC['add'];
				$data['typeid'] = intval($data['typeid']);
				$data['isset'] = intval($data['isset']);
				$data['show_score'] = intval($data['show_score']);
				$data['setting'] = array();
				if($data['isset']){
					$data['setting'] = $_GPC['setting'];
					if (!empty($_GPC['cover'])) {
						$data['setting']['cover'] = $_GPC['cover'];
						file_delete($_GPC['cover-old']);
					}
					if (!empty($_GPC['banner'])) {
						$data['setting']['banner'] = $_GPC['banner'];
						file_delete($_GPC['banner-old']);
					}
					if (!empty($_GPC['button_img'])) {
						$data['setting']['button_img'] = $_GPC['button_img'];
						file_delete($_GPC['button_img-old']);
					}
					if (!empty($_GPC['share_icon'])) {
						$data['setting']['share_icon'] = $_GPC['share_icon'];
						file_delete($_GPC['share_icon-old']);
					}
				}
				$data['setting'] = serialize($data['setting']);
				if (!empty($item['id'])) 
				{
					if($item['weid']==0)
					{
						$data['weid'] = $_W['weid'];
					}
					pdo_update('qiyue_testing', $data, array('id' => $item['id']));
				}
				else
				{
					$data['weid'] = $_W['weid'];
					pdo_insert('qiyue_testing', $data);
					$id = pdo_insertid();
				}
				// 修改题量
				$this->setTitlenum($data['typeid']);
				message('更新成功，前往设置题库', $this->createWebUrl('subject',array('id'=>$id)));
			}
			// 分类
			$types = pdo_fetchall("SELECT * FROM ".tablename('qiyue_testingtype')." WHERE 1=1");
			load()->func('tpl');
			include $this->template('manage_add');
		}
		else{
			$_W['page']['title'] = '测试管理';
			$issys = intval($_GPC['issys']);
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;

			$paras = array();
			if($issys==1)
			{
				// 系统题库
				if($this->module['config']['istesting']!=1 && $_W['isfounder']!=1){
					message('没有开启系统题库！');
				}
				$where = " WHERE issys=:issys";
				$paras[':issys'] = 1;
			}
			else
			{
				// 我的测试
				$where = " WHERE weid=:weid";
				$paras[':weid'] = $_W['weid'];
			}
			if (!empty($_GPC['keyword'])) {
				$where .= " AND title LIKE :title";
				$paras[':title'] = $_GPC['keyword']; 
			}
			$sql="SELECT * FROM ".tablename('qiyue_testing')." $where ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
			$list = pdo_fetchall($sql, $paras);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('qiyue_testing') . " $where", $paras);
			$pager = pagination($total, $pindex, $psize);

			$setting = $this->module; // 参数设置
			include $this->template('manage');
		}
	}

	// 题库管理
	public function doWebSubject() {
		global $_GPC, $_W;

		$op = $_GPC['op'];
		$id = intval($_GPC['id']);
		if(empty($id)){
			message('测试ID为空！');
		}
		$item = pdo_fetch("SELECT id,title,subject FROM ".tablename('qiyue_testing')." WHERE id=:id", array(':id' => $id));
		if (empty($item['id'])) {
			message('抱歉，信息不存在或是已经被删除！');
		}
		if($item['issys']==1 && $_W['isfounder']!=1){
			message('系统题库不允许编辑！');
		}
		$item['subject'] = json_encode(iunserializer($item['subject']));
		// 提交
		if (checksubmit()) {

			$add = $_GPC['subject'];

			// 问题
			if(count($add['title'])==0){
				message('至少填写1道问题！');
			}

			// 答案
			foreach ($add['answer'] as &$answer) {
				$answer = explode("\r\n", $answer);
			}
			unset($answer);

			// 得分
			foreach ($add['score'] as &$score) {
				$score = explode("\r\n", $score);
			}
			unset($score);

			// 重组数据
			$subject = array();
			foreach ($add['title'] as $key => $value) {
				$subject[$key]['title'] = $value;
				$subject[$key]['desc'] = $add['desc'][$key];
				$subject[$key]['option'] = array();
				$answer = $add['answer'][$key];
				$score = $add['score'][$key];
				for ($i=0; $i < count($answer) ; $i++) { 
					$subject[$key]['option'][]=array(
						'title'=> $answer[$i],
						'score'=> $score[$i]
					);
				}
			}

			unset($add);
			$update['titlenum'] = count($subject); // 题量
			$update['subject'] = iserializer($subject);
			pdo_update('qiyue_testing', $update, array('id'=>$item['id']));
			message('题库更新成功，前往设置评分规则！', $this->createWebUrl('result',array('id'=>$id)));
		}
		include $this->template('manage_subject');
	}

	// 评分规则设置
	public function doWebResult(){
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$id = intval($_GPC['id']);
		if(empty($id)){
			message('测试ID为空！');
		}
		$item = $this->getTestinfo($id);
		if (empty($item['id'])) {
			message('抱歉，信息不存在或是已经被删除！');
		}
		$item['result'] = json_encode(iunserializer($item['result']));
		// 提交
		if (checksubmit())
		{
			$add = $_GPC['result'];
			// 评分
			if(count($add['range_end'])==0){
				message('至少填写1种评分规则！');
			}
			// 计算低分
			$range_start = array();
			$j=0;
			foreach ($add['range_end'] as $key => $value)
			{
				if($key==0)
				{
					$range_start[$key] = '0';
				}
				else
				{
					$range_start[$key] = $add['range_end'][$j];
					$j++;
				}
			}
			$add['range_start'] = $range_start;
			// 重组数据
			$result = array();
			foreach ($add['range_end'] as $key => $value)
			{
				$result[$key]['range_start'] = $add['range_start'][$key];
				$result[$key]['range_end'] = $value;
				$result[$key]['conclusion'] = $add['conclusion'][$key];
				$result[$key]['summary'] = $add['summary'][$key];
			}
			unset($add);
			// 入库
			$update['result'] = iserializer($result);
			pdo_update('qiyue_testing', $update, array('id'=>$item['id']));
			message('规则更新成功', $this->createWebUrl('manage',array('mytest'=>$_GPC['mytest'])));
		}
		include $this->template('manage_result');
	}

	// 分类管理
	public function doWebType(){
		global $_GPC, $_W, $do;
		if($_W['isfounder']!=1){
			message('分类不允许操作，请联系网站管理员！');
		}
		$op = $_GPC['op'];
		if($_W['isajax']){
			if($op=='delete')
			{
				$id = intval($_GPC['id']);
				if(empty($id))
				{
					message('分类ID为空！');
				}
				$delete_id = pdo_fetchcolumn("SELECT id FROM ".tablename('qiyue_testingtype')." WHERE id=:id", array(':id' => $id));
				if (empty($delete_id))
				{
					message('抱歉，分类不存在或是已经被删除！');
				}
				pdo_delete('qiyue_testingtype', array('id' => $delete_id));
				message(array('state'=>0), '', 'ajax');
			}
			message('未知错误', referer(), 'ajax');
		}
		if($op=='add'){
			$id = intval($_GPC['id']);
			if(!empty($id))
			{
				$item = pdo_fetch("SELECT * FROM ".tablename('qiyue_testingtype')." WHERE id=:id", array(':id' => $id));
				if (empty($item['id']))
				{
					message('抱歉，分类不存在或是已经被删除！');
				}
			}
			if (checksubmit())
			{
				$add = $_GPC['add'];
				if(empty($add['typename'])){
					message('类别名称不能为空');
				}
				if(empty($item['id'])){
					pdo_insert('qiyue_testingtype', $add);
					message('新增成功！', $this->createWeburl('type'), 'success');
				}
				else{
					pdo_update('qiyue_testingtype',$add,array('id'=>$item['id']));
					message('修改成功！', $this->createWeburl('type'), 'success');
				}
			}
			include $this->template('type_add');
		}
		else{
			$list = pdo_fetchall("SELECT * FROM ".tablename('qiyue_testingtype')." WHERE 1=1 ORDER BY myorder ASC,id DESC");
			include $this->template('type');
		}
	}

	// 采集
	public function doWebspider(){
		global $_GPC, $_W;
		$url = $_GPC['url'];
		$data = ihttp_get("http://api.admin9.com/spider/&q=".$_SERVER['HTTP_HOST']."&k=".$url);
		$data = json_decode($data['content'],true);
		unset($data['data']['fromurl']);
		$data['data']['weid'] = $_GPC['weid'];
		pdo_insert('qiyue_testing', $data['data']);
		$id = pdo_insertid();
		if($id){			
			message('更新成功，前往设置题库', $this->createWebUrl('subject',array('id'=>$id)));
		}
		else{
			message('未知错误！');
		}
	}

	public function doMobileIndex() {
		global $_GPC, $_W;
		// 分类
		$sql="SELECT * FROM ".tablename('qiyue_testingtype')." WHERE 1=1 ORDER BY id DESC";
		$type = pdo_fetchall($sql);

		$limit = '10';
		$where = " WHERE weid=:weid";
		$paras = array();
		$paras[':weid'] = $_W['weid'];
		// 开启系统题库
		if($this->module['config']['istesting']==1){
			$where .= " OR issys=1";
		}
		// 按分类查询
		$typeid = intval($_GPC['id']);
		if($typeid){
			$ttype = pdo_fetch("SELECT * FROM ".tablename('qiyue_testingtype')." WHERE id=".$typeid);
			if(empty($ttype['id'])){
				message('该分类不存在！');
			}
			$typeid = $ttype['id'];
			$where .= " AND typeid=:typeid";
			$paras[':typeid'] = $typeid;
			$limit = '100';
		}

		$topsql="SELECT * FROM ".tablename('qiyue_testing')." $where ORDER BY id DESC limit ".$limit;
		$toplist = pdo_fetchall($topsql, $paras);
		
		include $this->template('index');
	}

	// 主题
	public function doMobileDetail(){
		global $_GPC, $_W;

		//固定借用微瓦的
		if(empty($_W['account']['jssdkconfig'])){
			load()->classs('weixin.account');
			$accObj = WeiXinAccount::create('12'); 
			$_W['account']['jssdkconfig'] = $accObj->getJssdkConfig();
			unset($accObj);
		}

		$id = intval($_GPC['id']);
		if(empty($id)){
			message('测试ID为空！');
		}
		$item = pdo_fetch("SELECT * FROM ".tablename('qiyue_testing')." WHERE id=:id",array(':id'=>$id));
		if(empty($item['id'])){
			message('该测试不存在！');
		}

		// 没开启系统题库
		if(!$this->module['config']['istesting'] && $item['issys']==1){
			message('该测试不存在！');
		}

		// 栏目
		$type = pdo_fetch("SELECT * FROM ".tablename('qiyue_testingtype')." WHERE id=:typeid",array(':typeid'=>$item['typeid']));
		
		/*
			封面：cover
			广告：banner
		 	广告链接：banner_link
			关注链接：follow_url
			分享链接：share_url
			分享回调：share_back
		 */
		
		// setting
		if($item['setting'] && $item['isset']){
			$item['setting'] = iunserializer($item['setting']);
		}
		else{
			$item['setting'] = $this->module['config'];
		}
		$item['setting']['cover'] = toimage($item['setting']['cover']);
		$item['setting']['banner'] = toimage($item['setting']['banner']);
		$item['setting']['button_img'] = toimage($item['setting']['button_img']);

		// 是否关闭指数
		$item['show_score'] = intval($item['show_score']);

		// 问题
		$subject = iunserializer($item['subject']);
		if (count($subject) && is_array($subject)) {
			foreach ($subject as &$value) {
				$value['desc'] = htmlspecialchars_decode($value['desc']); // 处理问题描述html代码
			}
		}
		$item['subject'] = json_encode(iunserializer($subject));

		//评价
		$result = iunserializer($item['result']);
		if (count($result) && is_array($result)) {
			foreach ($result as &$value) {
				$value['summary'] = htmlspecialchars_decode($value['summary']); // 处理问题描述html代码
			}
		}
		$item['result'] = json_encode(iunserializer($result));

		// 上一题
		$where = 'WHERE weid=:weid AND id<:itemid AND typeid=:typeid';
		$paras = array();
		$paras[':weid'] = $_W['weid'];
		$paras[':itemid'] = $item['id'];
		$paras[':typeid'] = $item['typeid'];

		// 开启系统题库
		if($this->module['config']['istesting']==1){
			$where .= " OR issys=1 AND id!=:itemid";
		}
		$next = pdo_fetch("SELECT id,title FROM ".tablename('qiyue_testing')." $where ORDER BY id DESC", $paras);
		if($next['id']){
			$next['title'] = '上一期测试';
			$next['url'] = $this->createMobileUrl('detail', array('id'=>$next['id']), true);
			unset($next['id']);
		}
		$item['next'] = json_encode($next);

		// 风格设置
		$style = array(
			'color' => '#37b9a1' , 
			'cover' => '', 
			'color_action' => '#108872', 
			'color_result' => '#E84C36'
		);

		// 分享设置
        if(!empty($_W['acid'])) {
            $acidinfo = account_fetch($_W['acid']);
        }
        
		if(!empty($item['setting']['share_url'])){
			$share_url = $item['setting']['share_url'];
		}
		else{
            $query_string = $_SERVER['QUERY_STRING'];
            if(!empty($query_string)) {
                //加上分享人的uid
                parse_str($query_string, $query_arr);
                $query_arr['u'] = $_W['member']['uid'];
                $query_string = http_build_query($query_arr);
                $share_url = $_W['siteroot'].'app/index.php?'. $query_string;
            }
		}

		$_imgUrl = toimage($item['setting']['share_icon']);
		if( empty($_imgUrl) ){
			$_imgUrl = toimage('images/global/wechat_share.png');
		}

		$_share = array(
			'title' => $item['title'],
			'desc' => cutstr(ihtmlspecialchars(strip_tags($item['smalltext'])), 60, '…'),
			'url' => $share_url,
			'imgUrl' => $_imgUrl,
			'backUrl' => $item['setting']['share_back'] // 分享后跳转
		);
		include $this->template('detail');
	}

	// 浏览、分享、参与
	public function doMobileTools(){
		global $_GPC, $_W;
		$id = intval($_GPC['id']);
		$op = $_GPC['op'];
		if(!in_array($op, array('viewnum','sharenum','people')) || empty($id)){
			message('来路非法！');
		}
		if($_W['isajax']){
			if($op=='sharenum'){
				pdo_query("UPDATE ".tablename('qiyue_testing')." SET sharenum=sharenum+1 WHERE id=".$id);
			}
			elseif($op=='people'){
				pdo_query("UPDATE ".tablename('qiyue_testing')." SET people=people+1 WHERE id=".$id);
			}
			else{
				pdo_query("UPDATE ".tablename('qiyue_testing')." SET viewnum=viewnum+1 WHERE id=".$id);
			}
			message('操作成功！','','ajax');
		}
	}


	// ----------------------- 功能函数
	
	// 题量修改
	public function setTitlenum($typeid){
		global $_GPC, $_W;
		if(intval($typeid)){
			// 更改题量
			$sql = "SELECT COUNT(*) FROM " . tablename('qiyue_testing') . " WHERE typeid=:typeid";
			$update['titlenum'] = pdo_fetchcolumn($sql, array(':typeid'=>$typeid));
			pdo_update("qiyue_testingtype",$update,array('id'=>$typeid));
		}
	}

	// 返回测试信息
	public function getTestinfo($id, $field=array()){
		global $_W;
		if (empty($fields)) {
		    $select = '*';
		}
		else {
		    foreach ($fields as $field){
		        if (!in_array($field, $struct)) {
		            unset($fields[$field]);
		        }
		    }
		    $select = '`id`, `'.implode('`,`', $fields).'`';
		}
		if( intval($id) ){
			$sql = "SELECT $select FROM ".tablename('qiyue_testing')." WHERE id=:id AND weid=:weid";
			return pdo_fetch($sql, array(':id' => $id, ':weid'=>$_W['weid']));
		}
	}
}