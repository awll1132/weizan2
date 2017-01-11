<?php
defined('IN_IA') or exit('Access Denied');
class Weisrc_dish extends WeModuleSite{
	public function Main() {
		global $_GPC, $_W;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$_W['uniacid']= $_W['uniacid'] ? $_W['uniacid'] : $_GPC['siteuniacid'];
		
		if($operation=="getalltable"){
			//获取桌面数
			//weisrc_dish_tablezones,weisrc_dish_tables
			$tablezones=pdo_fetchall("SELECT * FROM ".tablename('weisrc_dish_tablezones')." WHERE weid='{$_W['uniacid']}' order by id asc ");
			$tableType=array();
			$strhmtl=array();
			foreach($tablezones as $row){
				$tableType[$row['id']]=$row;
				$strhmtl[$row['id']]="";
			}
			$tables=pdo_fetchall("SELECT * FROM ".tablename('weisrc_dish_tables')." WHERE weid='{$_W['uniacid']}' order by tablezonesid asc,id asc ");
			$type=0;
			$strhtml="<ul>";
			foreach($tables as $row){
				$temphtml='<li '; 
				$status=$row['status'];
				if($status==1){
					$temphtml.=' style="background:#428bca;color:#FFF" onclick="gettableorder('.$row['id'].')"';
				}else if($status==2){
					$temphtml.=' style="background:#ef4437;color:#FFF" onclick="gettableorder('.$row['id'].')"';
				}
				$temphtml.='>'; 
				$temphtml.='<div><span class="label label-info">'.$tableType[$row['tablezonesid']]['title'].'</span> ';
				$temphtml.='<span class="label label-warning">'.$row['title'].'</span></div>';
				
				if($status==0){
					$temphtml.='<h3>空闲</h3>';
				}else if($status==1){
					$temphtml.='<h3>已开台</h3>'; 
				}else if($status==2){
					$temphtml.='<h3>已下单</h3>';
				}
				$temphtml.='<span class="label label-success">'.$row['user_count'].'人</span>';
				$temphtml.='</li>';
				if($type>0 && $type!=$row['tablezonesid']){
					$strhtml.="</ul><ul>".$temphtml;
					
				}else{
					$strhtml.=$temphtml;
				}
				$type=$row['tablezonesid'];
			}
			$strhtml.="</ul>";
			$str='<div class="weisrc_dish_tablelist">'.$strhtml.'</div>';
			die(json_encode(array("success"=>true,"tablelist"=>$str,"tabletpye"=>$tableType)));
		
		
		}elseif($operation=="gettableorder"){
			//获取订单列表
			$id=$_GPC['id'];
			if(!$id)die(json_encode(array("success"=>false,"msg"=>"parma error")));
			$table=pdo_fetch("SELECT * FROM ".tablename('weisrc_dish_tables')." WHERE id=:a ",array(":a"=>$id));
			$list=pdo_fetchall("SELECT from_user FROM ".tablename('weisrc_dish_tables_order')." WHERE tablesid=:a and from_user<>'' group by from_user order by id asc",array(":a"=>$id));
			if(!count($list))die(json_encode(array("success"=>false,"msg"=>"该餐桌没有订单")));
			$userlist=array();
			foreach($list as $row){
				$userlist[]=$row['from_user'];
			}
			$list=pdo_fetchall("SELECT * FROM ".tablename('weisrc_dish_order')." WHERE from_user in ('".implode("','",$userlist)."') and tables=:a and ispay=0 and paytype=3 and status>-1 and status<3 order by id desc",array(":a"=>$id));
			
			$strhtml='<h3 style="font-size:16px; font-weight:bold; border-bottom:1px solid dashed; margin:10px;">'.$table['title'].'</h3><table class="table table-hover"><thead class="navbar-inner"><tr><th style="width:14%;">订单号</th><th style="width:12%;">订单总额</th><th style="width:18%;">联系信息</th><th style="width:10%;">类型</th><th style="width:10%;">状态</th><th style="width:10%;">支付状态</th><th style="width:14%;">下单时间</th><th style="width:12%; text-align:right;"></th></tr></thead><tbody>';
			$temphtml="";
			foreach($list as $row){
				$temphtml.='<tr><td>'.$row['ordersn'].'</td><td>￥'.$row['totalprice'].'</td>';
				$temphtml.='<td>'.$row['username'].'<br/>'.$row['tel'].''.(!empty($row['address']) ?  '<br/>'.$row['address'] :'').' </td>';
				$temphtml.='<td>';
				if($row['dining_mode']==1){
					$temphtml.='<span class="btn btn-info btn-sm" title="堂点" style="background-color: #9585bf;border-color:#9585bf;"><i class="fa fa-cutlery"></i></span>';
				}elseif($row['dining_mode']==2){
					$temphtml.='<span class="btn btn-info btn-sm" title="外卖"  style="background-color: #4f99c6;border-color:#4f99c6;"><i class="fa fa-truck"></i></span>';
				}elseif($row['dining_mode']==3){
					$temphtml.='<span class="btn btn-info btn-sm" title="预定" style="background-color: #fee188;border-color: #fee188;"><i class="fa fa-calendar"></i></span>';
				}elseif($row['dining_mode']==4){
					$temphtml.='<span class="btn btn-info btn-sm" title="快餐" style="background-color: #be386a;border-color: #be386a;"><i class="fa fa-delicious"></i></span>';
				}
				$temphtml.='</td>';
				$temphtml.='<td>';
				if($row['status']==0){
					$temphtml.='<span class="label label-info">待处理</span>';
				}elseif($row['status']==1){
					$temphtml.='<span class="label label-warning">已确认</span>';
				}elseif($row['status']==2){
					$temphtml.='<span class="label label-success">已并台</span>';
				}elseif($row['status']==3){
					$temphtml.='<span class="label label-success">已完成</span>';
				}elseif($row['status']==-1){
					$temphtml.='<span class="label label-danger">已取消</span>';
				}
				$temphtml.='</td>';
				$temphtml.='<td>';
				if($row['paytype']==0){
					$temphtml.='未确认';
				}elseif($row['paytype']==1){
					$temphtml.='余额支付';
				}elseif($row['paytype']==2){
					$temphtml.='在线支付';
				}elseif($row['paytype']==3){
					$temphtml.='现金付款';
				}
				$temphtml.='<br>';
				if($row['ispay']==0){
					$temphtml.='<span class="label label-default">未支付</span>';
				}elseif($row['ispay']==1){
					$temphtml.='<span class="label label-success">已支付</span>';
				}
				$temphtml.='</td>';
				$temphtml.='<td>'.date("Y-m-d", $row['dateline']).'<br/>'.date("H:i:s", $row['dateline']).'</td>';
				$temphtml.='<td><button type="button" onclick="weisrc_dish_pay(\''.$row['ordersn'].'\',\''.($row['totalprice']).'\',\''.($row['totalprice']*100).'\')" class="btn btn-danger">收款</button></td>';
			}
			$temphtml.='</tbody></table>';
			$strhtml=$strhtml.$temphtml;
			die($strhtml);
			//die(json_encode(array("success"=>true,"orderlist"=>$list,"table"=>$table)));
		}elseif($operation=="getdeliveryorder"){
			
			
		}elseif($operation=="paysuccess"){
			//支付成功后回调执行
			$orderid=$_GPC['orderid'];
			pdo_update("weisrc_dish_order",array("ispay"=>1),array("ordersn"=>$orderid));
		}
		
		die(json_encode(array("success"=>false,"msg"=>"error")));
	}
}
