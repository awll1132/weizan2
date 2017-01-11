<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
<link href="<?php echo MODULE_URL;?>/template/static/css/frame.css?a=<?php  echo $reply['rid'];?>" rel="stylesheet" type="text/css">
<style>
html,body{height:100%; }
body{ padding-top:10px; background:<?php  echo $reply['bgcolor'];?> url(<?php  echo tomedia($reply['bgimg']);?>) center 0 no-repeat;filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale')";  
-moz-background-size:100%;  
    background-size:100%;  }
.homefH a{margin:0 5px;}
.btnT2{ border:2px solid <?php  echo $reply['ptdata']['buttoncolor'];?>; color:<?php  echo $reply['ptdata']['buttoncolor'];?>;}
.btnT1{  background:<?php  echo $reply['ptdata']['bbuttoncolor'];?>; }
.btnT1:after{background:<?php  echo $reply['ptdata']['bbuttonycolor'];?>; }
.admodel{width: 90%;  margin: 0 auto;  overflow: hidden;  text-align: left;}
</style>

<div class="homefH">
	<p></p>
	<img src="<?php  echo tomedia($reply['startimg']);?>" style="width:80%; text-align:center;display:block"/>
	<br/>
	<a href="javascript:void(0);"
	 <?php  if($follow!=1) { ?>
		onclick="show('cover2','tipTishi2');"
		<?php  } else { ?>
		  <?php  if($reply['isreg']==1) { ?>
			  onclick="ajaxjoin()"
		  <?php  } else { ?>
		      onclick="show('cover3','xx5_pop');"
		  <?php  } ?>
	 <?php  } ?>
	 class="btnT1">马上参与</a>
	<p class="s14em mt20 mb10 gray1"><a href="<?php  echo $this->createMobileUrl('rule', array('id' => $reply['rid']))?>" class="btnT2">活动规则<?php  echo $ipcity;?></a><a href="<?php  echo $this->createMobileUrl('award', array('id' => $reply['rid']))?>" class="btnT2">奖品介绍</a><a href="<?php  echo $this->createMobileUrl('Ranking', array('rid' => $reply['rid']))?>" class="btnT2">排行榜</a></p>
</div>

<div class="admodel">
  
  <?php  echo $reply['admodel'];?>

</div>
<!--提示层-->
<div id="cover"></div>
<div id="cover2"></div>
<div id="cover3"></div>
<!--关注-->
<div class="tipBox2" id="tipTishi2" onclick="hide('cover2','tipTishi2');">
	<div class="popT1">
		<p class="iconClose">×</p>
		<div>
			<p class="yellow fb">你要先关注“<?php  echo $_W['uniaccount']['name'];?>”<br>才能参加拼图哦！</p>
		</div>
		<p><img src="<?php  echo $_W['account']['qrcode'];?>" width="160" height="160"></p>
		
		<ul class="list3"  style="line-height:23px; margin-top:10px">
		<li>长按二维码或微信<br>搜索关注“<?php  echo $_W['uniaccount']['name'];?>”</li>
		<li><?php  echo $reply['ptdata']['followguide'];?></li> 
		</ul>
	</div>
</div>
<div class="tipBox2" id="tipTishi" onclick="hide('cover2','tipTishi');">
	<div class="popT1">
		<p class="iconClose">×</p>
		<div><p class="s16em yellow fb" id="msg">活动已结束！</p>
			<p>已成功参加活动的小伙伴们<br>请在关注官方公众号或活动页面领奖信息。</p>
		</div>
		<p><img src="<?php  echo $_W['account']['qrcode'];?>" width="160" height="160"></p>
		
		<ul class="list3"  style="line-height:23px; margin-top:10px">
		<li>长按二维码或微信<br>搜索关注“<?php  echo $_W['uniaccount']['name'];?>”</li>
		<li><?php  echo $reply['ptdata']['followguide'];?></li>
		</ul>
	</div>
</div>

<!--号码状态异常-->
<div id="xx4_pop" class="xx4_pop">
	<p class="iconClose"onclick="window.location.reload();">×</p>
	<div class="xx4_pop_cont">
		<p class="mtb20">发生错误，请刷新后再试！</p>
	</div>
	<a href="javascript:hide('cover','xx4_pop');" onclick="window.location.reload();"class="btnT3_2 mb10">我知道了</a>
</div>

<!--提示层结束-->

<!--报名活动-->
<div id="xx5_pop" class="xx4_pop">
	<p class="iconClose"onclick="hide('cover','xx5_pop');">×</p>
	<div class="xx4_pop_cont">
	    <div class="joininfo">报名信息</div>
		<ul class="layout3">
		<li><p><input id="name" name="name" type="text" class="inputT3" maxlength="6" placeholder="输入姓名"></p></li>
		<li><p><input id="mobile" name="mobile" type="tel" class="inputT3" maxlength="11" placeholder="输入手机号码"></p></li>
        <p style="text-align: left;color: #555;margin-left: 10px;font-size: 0.8em;">请提交真实信息，作为领奖凭证！</p>
		</ul>

	</div>
	<a href="javascript:;" onclick="ajaxjoin()"style="margin-bottom:10px;" class="btnT3_2 mb10">提交参加</a>
</div>

<!--提示层结束-->

	
<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/static/js/public.js"></script>
<script>
function ajaxjoin(){
	<?php  if($reply['isreg']==1) { ?>
	  	var mobile="13700000000";
	    var name="匿名";
	<?php  } else { ?>
		var mobile=$("#mobile").val();
	    var name=$("#name").val();
	<?php  } ?>
	if(name==''){
	    alert("请填写真实姓名");
		return false;
	}
	if(mobile==''){
	    alert("请填写真实手机号");
		return false;
	}
	if(!(/^1[1|2|3|4|5|7|8|9]\d{9}$/.test(mobile))){ 
        alert("请填写正确手机号");  
        return false; 
    } 
	

	$.ajax({
		type: "POST",
		url: "<?php  echo $this->createMobileUrl('join', array('rid' => $reply['rid']))?>",
		data: {mobile:mobile,name:name},
	    dataType: "json",
	    success: function(str) {
			if(str!=null && str!=''){
				if(str.status == "success"){
					window.location.href="<?php  echo $this->createMobileUrl('help', array('rid' => $reply['rid']))?>&id="+str.id;
				}else if(str.status == "nofollow"){
					hide('cover','xx5_pop');
					show('cover2','tipTishi2');
				}else if(str.status =="endtime"){//活动不在进行中
						hide('cover','xx5_pop');
						show('cover2','tipTishi');
				}else if(str.status == "error"){
				    hide('cover','xx5_pop');
					$('.mtb20').html(str.errmsg);
					show('cover','xx4_pop');
				}else{
				    hide('cover','xx5_pop');
					$('.mtb20').html(str.errmsg);
					show('cover','xx4_pop');
				}
			}
	    },
	    error: function(err) {
	    	
	    }
	});
}

</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>