<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>

<style>
body{
	text-align:center;
	font-size:14px; line-height:1.3;
	color:#fff;
	font-family:STHeiti-Light,'Hiragino Sans GB','Microsoft Yahei',Arial;
	background:#7bba20;
	 padding-top:50px; background:<?php  echo $reply['bgcolor'];?> url(<?php  echo tomedia($reply['bgimg']);?>) center 0 no-repeat;
	 filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale')";  
-moz-background-size:100%;  
    background-size:100%;  
}


body,ul,li,dl,dd,dt,p,h1,h2,h3{ margin:0; padding:0; list-style:none; }
h1{ font-size:18px; }
h2{ font-size:16px; }
h3{ font-size:14px; }
img{ display:inline-block; vertical-align:middle; margin:auto; border:none; }
input{ font-family:STHeiti-Light,'Hiragino Sans GB','Microsoft Yahei',Arial; cursor:pointer; }

/*链接*/
a{ color:#666;text-decoration:none; outline:none;hide-focus:expression(this.hideFocus = true);}
a:hover{ color:#666; text-decoration:none; }
.hand,label{ cursor:pointer; }

/*颜色*/
.blue1, a.blue1{ color:#77b7ec; }
.blue2, a.blue2{ color:#054da8; }
.gray1,a.gray1{ color:#999; }
.black1{ color:#666; }
#pagewrapper .orange1{ color:#ea5703; }
.pink{ color:#e40077; }
.red,a.red{ color:#e60012; }
.red2,a.red2{ color:#b60005; }
.yellow{ color:#fdd000; }
.yellow2{ color:#fff100; }
.green{ color:#6ba612; }

.homefH img{ width:100%;text-align:center;}

.btnT2 {
    display: block;
    line-height: 30px;
    padding:3px 1.6em;
    border: 2px solid <?php  echo $reply['ptdata']['buttoncolor'];?>;;
    color: <?php  echo $reply['ptdata']['buttoncolor'];?>;;
    font-size: 16px;
	font-weight:700;
    border-radius: 50px;
	margin:5px 0;
}
</style>



<div class="homefH" style="width: 90%;margin: 0 auto;color:#fff;">
     <div style="width:100%;overflow: hidden;"><?php  echo $reply['awardmsg'];?></div>
	
	<p></p>
	<a href="<?php  echo $this->createMobileUrl('index', array('id' => $reply['rid']))?>" class="btnT2">我的拼图</a>

	<a href="javascript:history.go(-1);" class="btnT2">返回</a> 
</div>




</body></html>