<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";
//手机端自动化
require_once dirname(__FILE__) . "/../../core/mobilebootstrap.php";
global $_W,$_GPC;
$openid=$_GPC['openid'];
$only=$_GPC['only'];
$pks_openid=$_GPC['pks_openid'];
$order_no=$_GPC['order_no'];
// if(!empty($pks_openid)){
// 	//发送模板消息
// 	$link="http://wfh.weixingzpt.com/app/index.php?i=38&c=entry&do=pk_wangcheng&id=4&m=d1sj_yuanxiao&openid=".$openid."&pks_openid=".$pks_openid."&only=".$only;

// 	$resw=$this->mubanxiaoxi($pks_openid,'3-s5jjb9R9w_xa2gNORvY0_RAaeVws0MSBbsWNFh0S0',$link);

	
// }
//判断分享者是否答完题

$pk_share_pk=pdo_fetchall('select * from '.tablename('d1sj_yuanxiao_px')." where pks_openid=:pks_openid and eid=:eid and pks_status=1 and only=:only ",array(':pks_openid'=>$pks_openid,':eid'=>$_W['uniacid'],':only'=>$only));

if(!empty($pk_share_pk)){
	//$order_no = pdo_fetch("select order_no from ".tablename('d1sj_yuanxiao_correct')." where only=:only limit 1",array(':only'=>$only));
	//跳转完成页面		
	$link="http://wfh.weixingzpt.com/app/index.php?i=38&c=entry&do=wancheng&id=4&m=d1sj_yuanxiao&openid=".$openid."&order_no=".$order_no;
 	header("Location:" . $link);

}
//查询
$pks_shu=pdo_fetchall('select count(ti_id) as dati_shu from '.tablename('d1sj_yuanxiao_correct')
			." as co left join ".tablename('d1sj_yuanxiao_member')
			." as me on co.openid=me.openid "
			." where co.eid=:eid and co.openid=:openid and co.only=:only ",array(':eid'=>$_W['uniacid'],':openid'=>$pks_openid,":only"=>$only));



$pks_list=pdo_fetch("select * from ".tablename('d1sj_yuanxiao_member')." where openid=:openid and eid=:eid ",array(':openid'=>$pks_openid,':eid'=>$_W['uniacid']));


$share_list=pdo_fetch("select * from ".tablename('d1sj_yuanxiao_member')." where openid=:openid and eid=:eid ",array(':openid'=>$openid,':eid'=>$_W['uniacid']));


$share_shu=pdo_fetchall('select count(ti_id) as dati_shu,me.nickname,me.headimgurl from '.tablename('d1sj_yuanxiao_correct')
			." as co left join ".tablename('d1sj_yuanxiao_member')
			." as me on co.openid=me.openid "
			." where co.eid=:eid and co.openid=:openid and co.only=:only ",array(':eid'=>$_W['uniacid'],':openid'=>$openid,":only"=>$only));


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

//获胜者得到抽奖机会
if($share_shus>$pks_shus){

	$data=array(
		'frequency'=>$share_list['frequency']+1,
		);
	pdo_update('d1sj_yuanxiao_member',$data,array('id'=>$share_list['id']));

}
//获胜者得到抽奖机会
if($pks_shus>$share_shus){

	$data=array(
		'frequency'=>$pks_list['frequency']+1,
		);
	pdo_update('d1sj_yuanxiao_member',$data,array('id'=>$pks_list['id']));

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

if($_W['isajax']&&!empty($_GPC['share_openid'])){
	$share_openid=$_GPC['share_openid'];
	
	$only=$_GPC['only'];

	if(!empty($share_openid)){

		$share_lists=pdo_fetch("select * from ".tablename('d1sj_yuanxiao_member')." where openid=:openid and eid=:eid ",array(':openid'=>$share_openid,':eid'=>$_W['uniacid']));
		
		if($share_lists){
			//调发红包函数
			$money=1;
		
			//查询对应订单是否已经发过红包
			$sha_lise=pdo_fetchall('select * from '.tablename('d1sj_yuanxiao_correct')." where openid=:openid and eid=:eid and status=1 and only =:only ",array(':openid'=>$share_openid,':eid'=>$_W['uniacid'],'only'=>$only));
		
			if(!empty($sha_lise)){
				//判断分享者是否打完
				$is_pks_over = pdo_fetchcolumn("select pks_status from ".tablename('d1sj_yuanxiao_px')." where only=:only",array(':only'=>$only));
				if($is_pks_over==1){
					die(json_encode(array('infos'=>101,'msg'=>'您的好友没有答完哦，请稍后刷新页面')));
				}
				//将对应订单状态改为2
					$share_correct=array(
							'status'=>2,

						);
					$correct_upd=pdo_update('d1sj_yuanxiao_correct',$share_correct,array('openid'=>$share_openid,'only'=>$only,'eid'=>$_W['uniacid']));
						
				//添加概率
				$res_red = Get_rand(array('1'=>3,'2'=>97));
				if($res_red!=1){
					die(json_encode(array('infos'=>101,'msg'=>'很遗憾，您没有中奖,再接再厉!')));
				}
				
				$res_hongbao=$this->sendred($money,$share_openid);
				$res_hongbao['errno']==0;
				if($res_hongbao['errno']==0){
					$data1=array(
						'frequency'=>$share_lists['$share_list']-1,
						'balance'=>$share_lists['balance']+$money,
						);
					$me_res=pdo_update('d1sj_yuanxiao_member',$data1,array('id'=>$share_lists['id']));
					$data2=array(
						'time'=>time(),
						'openid'=>$share_lists['openid'],
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
//var_dump($share_shu);

include $this->template($settings["themes"] . "/pkjieguo");die;





?>