<?php
/**
 * 助力平台模块定义
 *
 * @author 天涯织梦
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Tyzm_pintuModule extends WeModule {
	public $table_reply = 'tyzm_pintu_reply';
	public function fieldsFormDisplay($rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 $rid 为对应的规则编号，新增时为 0

		
		$baiduapikey=$this->module['config']['baiduapikey'];

		if(empty($rid)){
			$reply = array(
				'title'=> '你妈喊你来拼图了!',
				'thumb' => "../addons/tyzm_pintu/template/static/images/pintudemo.jpg",
				'description' => "全民拼图的时代，你怎么能错过，邀请好友一起来帮你吧。",
				'starttime' => time(),
				'endtime' => time() + 10 * 84400,
				'bgimg' => "../addons/tyzm_pintu/template/static/images/bgimg.jpg",
				'bgcolor' => "#7bba20",
				'startimg' => "../addons/tyzm_pintu/template/static/images/startimg.png",
				//'eventrule' => $_GPC['eventrule'],
				//'awardmsg' => $_GPC['awardmsg'],
				'pingtubig1' => "../addons/tyzm_pintu/template/static/images/pintu1.png",
				'pingtubig2' => "../addons/tyzm_pintu/template/static/images/pintu2.png",
				'pingtubig3' => "../addons/tyzm_pintu/template/static/images/pintu3.png",
				'pingtubig4' => "../addons/tyzm_pintu/template/static/images/pintu4.png",
				'pingtubig5' => "../addons/tyzm_pintu/template/static/images/pintu5.png",
				'pingtubig6' => "../addons/tyzm_pintu/template/static/images/pintu6.png",
				'area' => "",
				'usepwd' => rand(1000,9999),
				'status' => 1,

				
			);
			
			$reply['ptdata']=array('pr'=>array(1,1,1,1,1),'buttoncolor'=>"#fff100",'bbuttoncolor'=>"#fdd000",'bbuttonycolor'=>"##f08300",'followguide'=>"关注公众号后，点击菜单或回复“拼图”即可参加投票。");
			
		}else{
			$reply = pdo_fetch("SELECT * FROM ".tablename($this->table_reply)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
			// print_r($reply); exit;
			//print_r($reply);
			$reply['ptdata']=unserialize($reply['ptdata']);
			//$reply=array_merge ($reply,unserialize($reply['ptdata']));
			//$reply=array_merge ($reply,unserialize($reply['tpdata']));
			
		}
		include $this->template('form');
	}

	public function fieldsFormValidate($rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 $rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit($rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 $rid 为对应的规则编号
		global $_W,$_GPC;
		$id = intval($_GPC['reply_id']);
		
		/*
		pr  抽奖概率
		buttoncolor  按钮颜色
		followguide  关注提示
		
		bbuttoncolor
		*/
		$ptdata=iserializer(array('pr'=>$_GPC['pr'],'buttoncolor'=>$_GPC['buttoncolor'],'bbuttoncolor'=>$_GPC['bbuttoncolor'],'bbuttonycolor'=>$_GPC['bbuttonycolor'],'followguide'=>$_GPC['followguide']));
		
		$insert = array(
			'rid' => $rid,
			'uniacid' => $_W['uniacid'],
			'title' => $_GPC['title'],
			'thumb' => $_GPC['thumb'],
			'description' => $_GPC['description'],
			'starttime' => strtotime($_GPC['time'][start]),
			'endtime' => strtotime($_GPC['time'][end]),
			'bgimg' => $_GPC['bgimg'],
			'bgcolor' => $_GPC['bgcolor'],
			'startimg' => $_GPC['startimg'],
			'eventrule' => htmlspecialchars_decode($_GPC['eventrule']),
			'awardmsg' => htmlspecialchars_decode($_GPC['awardmsg']),
			'admodel'=>htmlspecialchars_decode($_GPC['admodel']),
			'pingtubig1' => $_GPC['pingtubig1'],
			'pingtubig2' => $_GPC['pingtubig2'],
			'pingtubig3' => $_GPC['pingtubig3'],
			'pingtubig4' => $_GPC['pingtubig4'],
			'pingtubig5' => $_GPC['pingtubig5'],
			'pingtubig6' => $_GPC['pingtubig6'],
			'follow' => intval($_GPC['follow']),
			'followjoin' => intval($_GPC['followjoin']),
			'awardtotal' => $_GPC['awardtotal'],
			'probability' => intval($_GPC['probability']),
			'mutualjoin' => $_GPC['mutualjoin'],
			'isreg' => $_GPC['isreg'],
			'rankingnum' => $_GPC['rankingnum'],
			'usepwd' => $_GPC['usepwd'],
			'area' => $_GPC['area'],
			'ptdata'=>$ptdata,
			'sharetitle' => $_GPC['sharetitle'],
			'shareimg' => $_GPC['shareimg'],
			'sharedesc' => $_GPC['sharedesc'],
			'status' => $_GPC['status'],
			'createtime' => time(),	
	    );
		if (empty($id)) {
			pdo_insert($this->table_reply, $insert);
		}else{
			unset($insert['createtime']);
			pdo_update($this->table_reply, $insert, array('id' => $id));
		}
	}

	public function ruleDeleted($rid) {
		//删除规则时调用，这里 $rid 为对应的规则编号
		$replies = pdo_fetchall("SELECT id  FROM ".tablename($this->table_reply)." WHERE rid = '$rid'");
		$deleteid = array();
		if (!empty($replies)) {
			foreach ($replies as $index => $row) {
				$deleteid[] = $row['id'];
			}
		}
		pdo_delete($this->table_reply, "id IN ('".implode("','", $deleteid)."')");
	}

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用$this->saveSettings()来实现）
		if(checksubmit()) {
			//字段验证, 并获得正确的数据$dat
			$dat=array(
			    'baiduapikey'=>$_GPC['baiduapikey'],
			);
			
			$this->saveSettings($dat);
		}
		//这里来展示设置项表单
		include $this->template('setting');
	}

}