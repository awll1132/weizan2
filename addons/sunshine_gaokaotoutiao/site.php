<?php
 defined('IN_IA')or exit('Access Denied');class Sunshine_GaokaotoutiaoModuleSite extends WeModuleSite {public function doMobileIndex(){global $_W,$_GPC;$list =pdo_fetchall("select id from ".tablename('sunshine_gaokaotoutiao_sucai'). " where is_del = '0' ");$key =array_rand($list);$info =$list[$key];include $this->template('index');}public function doWebManage(){global $_W,$_GPC;$list =pdo_fetchall("select * from ".tablename('sunshine_gaokaotoutiao_sucai'). " where is_del = '0' order by add_time desc ");include $this->template('manage_list');}public function doWebManageAdd(){global $_W,$_GPC;$data =array();$data['title'] =$_GPC['title'];$data['content'] ="<p>".str_replace('<br />','<br/><p>',nl2br($_GPC['content']))."</p>";$data['add_time'] =date("Y-m-d H:i:s");$data['is_del'] ='0';$r =pdo_insert("sunshine_gaokaotoutiao_sucai",$data);header('content-type:text/json');if($r){echo json_encode(array('res'=>'100','msg'=>'insert ok'));exit;}else {echo json_encode(array('res'=>'101','msg'=>'insert error'));exit;}}public function doWebManageDelete(){global $_W,$_GPC;$updateData =array();$updateData['is_del'] ='1';$r =pdo_update('sunshine_gaokaotoutiao_sucai',$updateData,array('id'=>$_GPC['id']));header('content-type:text/json');if($r === false){echo json_encode(array('res'=>'101','msg'=>'update error'));exit;}else {echo json_encode(array('res'=>'100','msg'=>'update success'));exit;}}public function doWebManageDetail(){global $_W,$_GPC;$info =pdo_fetch("select * from ".tablename('sunshine_gaokaotoutiao_sucai')." where id=:id",array(":id"=>$_GPC['id']));header('content-type:text/json');if($info['img_url']){$info['img_url'] =$_W['siteroot']."/addons/sunshine_gaokaotoutiao/upload/".$info['img_url'];}if($info === false){echo json_encode(array('res'=>'101','msg'=>'detail error'));exit;}else {echo json_encode(array('res'=>'100','msg'=>'detail ok','detail'=>$info));exit;}}public function doWebManageUpload(){global $_W,$_GPC;error_reporting(E_ALL);if(!isset($_FILES['ad_img'])|| !isset($_GPC['id'])){header("HTTP/1.1 500 Internal Server Error");header('Content-type:text/json');echo json_encode(array('res'=>'101','msg'=>'upload failure'));exit;}if($_FILES['ad_img']['size'] > 1024*1024){header("HTTP/1.1 500 Internal Server Error");header('Content-type:text/json');echo json_encode(array('res'=>'101','msg'=>'upload failure'));exit;}$prefix =substr($_FILES['ad_img']['name'], strpos($_FILES['ad_img']['name'],'.'));$filename =date('YmdHis').$prefix;if(file_exists('../addons/sunshine_gaokaotoutiao/upload/'.$filename)){$filename =date('YmdHis').'_'.rand(0,9).$prefix;}$r =move_uploaded_file($_FILES['ad_img']['tmp_name'], '../addons/sunshine_gaokaotoutiao/upload/'.$filename);if($r){$updateData =array();$updateData['img_url'] =$filename;$r =pdo_update('sunshine_gaokaotoutiao_sucai',$updateData,array('id'=>$_GPC['id']));header('content-type:text/json');if($r === false){echo json_encode(array('res'=>'101','msg'=>'update error'));exit;}else {echo json_encode(array('res'=>'100','msg'=>'update success'));exit;}}else {header('HTTP/1.1 500 Internal Server Error');header('Content-type:text/json');echo json_encode(array('res'=>'101','msg'=>'upload failure'));exit;}}public function doMobileArticle(){global $_W,$_GPC;$realname =empty($_GPC['realname'])? 'xxx' : $_GPC['realname'];$place =empty($_GPC['place'])? '北京' : $_GPC['place'];$data =array();$data['openid'] =$_W['openid'];$data['realname'] =$_GPC['realname'];$data['place'] =$_GPC['place'];$data['add_time'] =date("Y-m-d H:i:s");$data['type_id'] =$_GPC['typeid'];pdo_insert('sunshine_gaokaotoutiao_member',$data);$sucai =pdo_fetch("select * from ".tablename('sunshine_gaokaotoutiao_sucai')." where id=:id",array(":id"=>$_GPC['typeid']));if(!$sucai){$sucai =pdo_fetch("select * from ".tablename('sunshine_gaokaotoutiao_sucai')." where is_del=0 order by add_time desc limit 1");}if($sucai['img_url']){$sucai['img_url'] =$_W['siteroot']."/addons/sunshine_gaokaotoutiao/upload/".$sucai['img_url'];}$sucai['title'] =str_replace("{%姓名%}", $_GPC['realname'],$sucai['title']);$sucai['title'] =str_replace("{%地区%}", $_GPC['place'],$sucai['title']);$sucai['content'] =str_replace("{%姓名%}", $_GPC['realname'],$sucai['content']);$sucai['content'] =str_replace("{%地区%}", $_GPC['place'],$sucai['content']);include $this->template('article');}}