<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";
//手机端自动化
require_once dirname(__FILE__) . "/../../core/mobilebootstrap.php";

$openid=$_W['openid'];


$only=$_GPC['only'];

$too_openid=$_GPC['pks_openid'];

//查询
$pks_shu=pdo_fetchall('select count(ti_id) as dati_shu from '.tablename('d1sj_yuanxiao_correct')
			." as co left join ".tablename('d1sj_yuanxiao_member')
			." as me on co.openid=me.openid "
			." where co.eid=:eid and co.openid=:openid and co.only=:only ",array(':eid'=>$_W['uniacid'],':openid'=>$openid,":only"=>$only));



$pks_list=pdo_fetch("select * from ".tablename('d1sj_yuanxiao_member')." where openid=:openid and eid=:eid ",array(':openid'=>$openid,':eid'=>$_W['uniacid']));


$share_list=pdo_fetch("select * from ".tablename('d1sj_yuanxiao_member')." where openid=:openid and eid=:eid ",array(':openid'=>$too_openid,':eid'=>$_W['uniacid']));


$share_shu=pdo_fetchall('select count(ti_id) as dati_shu,me.nickname,me.headimgurl from '.tablename('d1sj_yuanxiao_correct')
			." as co left join ".tablename('d1sj_yuanxiao_member')
			." as me on co.openid=me.openid "
			." where co.eid=:eid and co.openid=:openid and co.only=:only ",array(':eid'=>$_W['uniacid'],':openid'=>$too_openid,":only"=>$only));


if(empty($share_shu)){

	$share_shus=0;
}else{
	$share_shus=$share_shu['0']['dati_shu'];

}
if(empty($pks_shu)){

	$pks_shus=0;
}else{
	$pks_shus=$pks_shu['0']['dati_shu'];

}
function Get_rand($proArr) {
        $result = '';
        //概率数组的总概率精度   
        $proSum = array_sum($proArr);

        //概率数组循环   
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset($proArr);
        return $result;
    }
if($_W['isajax']&&!empty($_GPC['pks_openid'])){
	$pks_openid=$_GPC['pks_openid'];


	
	$only=$_GPC['only'];



	if(!empty($pks_openid)){

		$share_lists=pdo_fetch("select * from ".tablename('d1sj_yuanxiao_member')." where openid=:openid and eid=:eid ",array(':openid'=>$pks_openid,':eid'=>$_W['uniacid']));
		
		if($share_lists){
			//调发红包函数
			$money=1;
		
			//查询对应订单是否已经发过红包
			$sha_lise=pdo_fetchall('select * from '.tablename('d1sj_yuanxiao_correct')." where openid=:openid and eid=:eid and status=1 and only =:only ",array(':openid'=>$pks_openid,':eid'=>$_W['uniacid'],'only'=>$only));
	
	
			if(!empty($sha_lise)){
					// /将对应订单状态改为2
					$share_correct=array(
							'status'=>2,

						);

					$correct_upd=pdo_update('d1sj_yuanxiao_correct',$share_correct,array('openid'=>$pks_openid,'only'=>$only,'eid'=>$_W['uniacid']));
						
				//添加概率
				$res_red = Get_rand(array('1'=>3,'2'=>97));
				if($res_red!=1){
					die(json_encode(array('infos'=>101,'msg'=>'很遗憾，您没有中奖,再接再厉!')));
				}
				$res_hongbao=$this->sendred($money,$share_openid);
				//$res_hongbao['errno']==0;
				if($res_hongbao['errno']==0){
					$data1=array(
						'frequency'=>$share_lists['$share_list']-1,
						'balance'=>$share_lists['balance']+$money,
						);
					$me_res=pdo_update('d1sj_yuanxiao_member',$data1,array('id'=>$share_lists['id']));
					$data2=array(
						'time'=>time(),
						'openid'=>$pks_openid,
						'jine'  =>$money,
						);
					$zhongjiang_res=pdo_insert('d1sj_yuanxiao_zhongjiang',$data2);
					
				

					if($me_res&&$zhongjiang_res){
						die(json_encode(array('infos'=>1,'msg'=>'提现成功')));
					}
				}else{
					die(json_encode(array('infos'=>4,'msg'=>'数据错误请重新提交')));

				}

				}else{
					die(json_encode(array('infos'=>5,'msg'=>'您已经抽过奖了哦')));

				}

		}else{
			die(json_encode(array('infos'=>3,'msg'=>'数据错误请重新提交')));


		}
		

	}else{
			die(json_encode(array('infos'=>2,'msg'=>'数据错误请重新提交')));

	}



}

include $this->template($settings["themes"] . "/pk_wangcheng");die;
















?>