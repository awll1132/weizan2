<?php
//引用自动化
require_once dirname(__FILE__) . "/../../core/bootstrap.php";
//手机端自动化
require_once dirname(__FILE__) . "/../../core/mobilebootstrap.php";
$openid=$_GPC['openid'];

$order_no=$_GPC['order_no'];

$order_res=pdo_fetchall('select count(ti_id) as dati_shu from '.tablename('d1sj_yuanxiao_correct')." where eid=:eid and openid=:openid and order_no=:order_no ",array(':eid'=>$_W['uniacid'],':openid'=>$openid,':order_no'=>$order_no));
if(empty($order_res)){
	$dati_shu=0;
}else{
	$dati_shu=$order_res['0']['dati_shu'];

}


if($dati_shu>10){
	$bg_id=3;
}else if($dati_shu>5 && $dati_shu <=10){
	$bg_id=2;
}else{
	$bg_id=1;
}
$path = createpicture($bg_id,$dati_shu);


function createpicture($bg_id="1",$ti=""){
    	$save_path =IA_ROOT . "/addons/d1sj_yuanxiao/static/image/";//例如d://php
	    $bg = IA_ROOT . "/addons/d1sj_yuanxiao/static/bg/bg_".$bg_id.".png";
	    $font =  IA_ROOT . "/addons/d1sj_yuanxiao/static/bg/huakang.otf";
	    $image = imagecreatefrompng($bg);

	    $color = imagecolorallocate($image, 114, 32, 37);
	    //加入名字
	    imagettftext($image, 30, 0, 385, 307, $color, $font, $ti);//20大小，角度0水平90上下，150，70字坐标，
	   
	   
	    //header("Content-type:image/png");imagepng($image);
	    $time = date("ymdhis",time());
	    $time = $time.rand(0,10000);
	    $save_path = $save_path.$time.".png";
	   	imagepng($image,$save_path);
	    return 'd1sj_yuanxiao/static/image/'.$time.".png";
    }


include $this->template($settings["themes"] . "/wancheng");die;




?>