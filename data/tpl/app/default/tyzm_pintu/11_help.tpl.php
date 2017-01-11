<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('header', TEMPLATE_INCLUDEPATH)) : (include template('header', TEMPLATE_INCLUDEPATH));?>
	<link href="<?php echo MODULE_URL;?>/template/static/css/frame.css?a=100" rel="stylesheet" type="text/css">
<style>
html,body{}
body{  padding-top:50px; background:<?php  echo $reply['bgcolor'];?> url(<?php  echo tomedia($reply['bgimg']);?>) center 0 no-repeat;filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale')";  
-moz-background-size:100%;  
    background-size:100%;  
}  


.pintu{ margin:0px 20px; }
.pintu.t2{ margin:0; }
.pintu p{ max-width:320px; margin:0 auto; position:relative; }
.pintu i{ position:absolute; top:0; left:0; width:100%; height:100%; background:url(<?php  echo tomedia($reply['pingtubig1']);?>) 0 0 no-repeat; background-size:100%; }
.pintu .pt2{ background-image:url(<?php  echo tomedia($reply['pingtubig2']);?>); }
.pintu .pt3{ background-image:url(<?php  echo tomedia($reply['pingtubig3']);?>); }
.pintu .pt4{ background-image:url(<?php  echo tomedia($reply['pingtubig4']);?>); }
.pintu .pt5{ background-image:url(<?php  echo tomedia($reply['pingtubig5']);?>); }
.pintu .pt6{ background-image:url(<?php  echo tomedia($reply['pingtubig6']);?>); }
.pintuD1{ display:inline-block; width:147px; height:97px; background:url(<?php  echo tomedia($reply['pingtubig1']);?>) 0 0 no-repeat;}
.pintuD1.t2{ width:73px; height:48px; background-size:217.7%; }
.pintuD2{ display:inline-block; width:147px; height:97px; background:url(<?php  echo tomedia($reply['pingtubig2']);?>) 61.2%/*-106px=(147-320)*61.2%*/ 0 no-repeat;}
.pintuD2.t2{ width:73px; height:48px; background-size:217.7%; }
.pintuD3{ display:inline-block; width:109px; height:137px; background:url(<?php  echo tomedia($reply['pingtubig3']);?>) right 0 no-repeat;}
.pintuD3.t2{ width:54px; height:68px; background-size:293%; }
.pintuD4{ display:inline-block; width:107px; height:137px; background:url(<?php  echo tomedia($reply['pingtubig4']);?>) 0 bottom no-repeat;}
.pintuD4.t2{ width:53px; height:68px; background-size:299%; }
.pintuD5{ display:inline-block; width:147px; height:97px; background:url(<?php  echo tomedia($reply['pingtubig5']);?>) 38.7%/*-67px = (147-320)*38.7%*/ bottom no-repeat;}
.pintuD5.t2{ width:73px; height:48px; background-size:217.7%; }
.pintuD6{ display:inline-block; width:147px; height:97px; background:url(<?php  echo tomedia($reply['pingtubig6']);?>) right bottom no-repeat; }
.pintuD6.t2{ width:73px; height:48px; background-size:217.7%; }

.btnT2{ border:2px solid <?php  echo $reply['ptdata']['buttoncolor'];?>; color:<?php  echo $reply['ptdata']['buttoncolor'];?>;}


.btnT1{  background:<?php  echo $reply['ptdata']['bbuttoncolor'];?>; }
.btnT1:after{background:<?php  echo $reply['ptdata']['bbuttonycolor'];?>; }
.admodel{width: 90%;  margin: 0 auto;  overflow: hidden;  text-align: left;}
</style>





    <div class="figure">
		<i><img src="<?php  echo $userhelp['avatar'];?>" width="60" height="60"></i>
		<p class="s12em"><?php  echo $userhelp['nickname'];?></p>
	</div>

	<div class="mt20 mb20 ml20 mr20 s12em">
		<p class="hr1"></p>
		    <?php  if($residue==0) { ?>
			    <?php  if($ismyself!=1) { ?>
				    <p class="fb" style="color:#fdd000;padding:10px 0;font-size:1.5em;">好友拼图已完成！</p>
				<?php  } else { ?>
					   <p class="fb">拼图成功，可以召唤神龙了！</p>
					   <?php  if($userhelp['isexchange']==0) { ?>
					   <p class="fb" style="color:#fdd000">未领礼品</p>
					   <br/>
					   <p class="btnT1" onclick="show('cover3','xx5_pop');">现场核销</p>
					   <br/>
					   <?php  } else { ?>
					   <p class="fb" style="color:#fdd000">已领礼品</p>
					   <?php  } ?>
				<?php  } ?>
			<?php  } else { ?>
			<p class="fb">离拼图成功只差<span class="yellow s14em"><?php  echo $residue;?></span>张拼图，革命还需努力！</p>
			
			<?php  } ?>
			<p class="fb" style="padding:10px 0;">排第 <span style="color:#fdd000;font-size:2em;"><?php  echo $mypm;?></span> 名</p>
		<p class="hr1 mt10"></p>
	</div>
	
	<div class="pintu">
		<p>
		<img src="<?php echo MODULE_URL;?>/template/static/images/pintuBg.png" class="scale">
		
		    <?php  if(is_array($zlarray)) { foreach($zlarray as $row) { ?>
			<i class="pt<?php  echo $row;?>"></i>
			<?php  } } ?>    

		
		</p>
	</div>
	
		    <?php  if($ismyself==1) { ?>
			    <?php  if($residue!=0) { ?>
			       <a href="javascript:show('cover2','tipTishi')" class="btnT1 mt10">快叫小伙伴帮忙抽吧！</a>
				<?php  } ?>
		    <?php  } else { ?> 
			    <?php  if($iszl==1 || $residue==0) { ?>
			     <a href="<?php  echo $this->createMobileUrl('index', array('id' => $reply['rid']))?>" class="btnT1 mt10">我也要参与拼图</a>
				 <?php  } else { ?>
				 <a href="javascript:open()" class="btnT1 mt10">助力TA抽拼图</a>
				 <?php  } ?>
			<?php  } ?>
		<p class="barT1">已有<span class="yellow s14em"><?php  echo $zlcount;?></span>个好友助力凑拼图了<?php  if($ismyself==1) { ?> <a href="javascript:void(0)" onclick="detail();">详情</a><?php  } ?></p>
	
	<p class="s14em mt20 mb10 gray1"><a href="<?php  echo $this->createMobileUrl('index', array('id' => $reply['rid']))?>" class="btnT2">我的拼图</a> <a href="<?php  echo $this->createMobileUrl('rule', array('id' => $reply['rid']))?>" class="btnT2">活动规则</a> <a href="<?php  echo $this->createMobileUrl('award', array('id' => $reply['rid']))?>" class="btnT2">奖品介绍</a> <a style="margin-top:10px;" href="<?php  echo $this->createMobileUrl('Ranking', array('rid' => $reply['rid']))?>" class="btnT2">排行榜</a></p>
<div class="admodel">
  
  <?php  echo $reply['admodel'];?>

</div>
<!--提示层-->
<div id="cover"></div>
<div id="cover2"></div>
<div id="cover3"></div>
<!--抽奖中-->
<div id="xx4_pop" class="xx4_pop">
	<p class="iconClose" onclick="hide('cover','xx4_pop');">×</p>
	<div class="xx4_pop_cont">
		<div class="pintu t2">
			<p>
			<img src="<?php echo MODULE_URL;?>/template/static/images/pintuBg.png" class="scale">
			<i class="pt1"></i>
			<i class="pt2"></i>
			<i class="pt3"></i>
			<i class="pt4"></i>
			<i class="pt5"></i>
			<i class="pt6"></i>
			</p>
		</div>
	</div>
	<a href="javascript:void();" class="btnT4 mtb10">运气聚集中......</a>
</div>
<!--号码状态异常-->
<div id="xx6_pop" class="xx4_pop">
	<p class="iconClose"onclick="hide('cover','xx6_pop');">×</p>
	<div class="xx4_pop_cont">
		<p class="mtb20">发生错误，请刷新后再试！</p>
	</div>
	<a href="javascript:hide('cover','xx6_pop');" onclick="hide('cover','xx6_pop');"class="btnT3_2 mb10">我知道了</a>
</div>
<!--报名活动-->
<div id="xx5_pop" class="xx4_pop">
	<p class="iconClose"onclick="hide('cover','xx5_pop');">×</p>
	<div class="xx4_pop_cont">
	    <div class="joininfo">核销</div>
		<ul class="layout3">
		<li><p><input id="usepwd" name="usepwd" type="tel" class="inputT3" placeholder="输入核销密码"></p></li>
        <p style="text-align: left;color: #555;margin-left: 10px;font-size: 0.8em;">非核销员谨慎操作，后果自负！</p>
		</ul>

	</div>
	<a href="javascript:;" onclick="ajaxsetuse()"style="margin-bottom:10px;" class="btnT3_2 mb10">核销</a>
</div>

<!--提示层结束-->

<!--你抽到的拼图-->
<div id="xx4_pop2_other" class="xx4_pop">
	<p class="iconClose" onclick="window.location.reload();">×</p>
	<div class="xx4_pop_tit">你帮TA抽到了这张拼图</div>
	<div class="xx4_pop_cont">
		<p id="xx4_pop2_other_image"></p>
		<p id="xx4_pop2_other_content" class="mt10 gray1">(TA已经有这张拼图了）</p>
	</div>
	<a href="javascript:hide('cover','xx4_pop2_other');" onclick="window.location.reload();" class="btnT3_2 mb10">确定</a>
</div>

<div id="xx4_pop_error" class="xx4_pop">
	<p class="iconClose" onclick="window.location.reload();">×</p>
	<div class="xx4_pop_cont">
		<p class="mtb20">助力错误，请刷新后再试！</p>
	</div>
	<a href="javascript:hide('cover','xx4_pop_error');" onclick="window.location.reload();" class="btnT3_2 mb10">我知道了</a>
</div>

<!--帮你抽到了-->
<div id="xx4_pop3" class="xx4_pop">
	<p class="iconClose" onclick="hide('cover','xx4_pop3');">×</p>
	<div class="xx4_pop_tit">&nbsp;</div>
	<div class="xx4_pop_cont">
		<ul class="box2" id="detailui">
		</ul>
	</div>
	<a href="javascript:hide('cover','xx4_pop3');" class="btnT3_2 mb10">我知道了</a>
</div>

<!--分享-->
<div class="tipBox2" id="tipTishi">
	<div class="popT1">
		<p class="iconClose" onclick="hide('cover2','tipTishi');">×</p>
		<p class="arrTopR"></p>
		<div class="pintu">
			<p>
			<img src="<?php echo MODULE_URL;?>/template/static/images/pintuBg.png" class="scale">
			<i class="pt1"></i>
			<i class="pt2"></i>
			<i class="pt3"></i>
			<i class="pt4"></i>
			<i class="pt5"></i>
			<i class="pt6"></i>
			</p>
		</div>
		<div class="s14em">凑齐<b class="yellow s14em">6</b>张拼图<br>领取惊奇大奖~</div>
		<img src="<?php echo MODULE_URL;?>/template/static/images/imgTxt1.gif">
	</div>
</div>


<!--关注-->
<div class="tipBox2" id="tipTishi2" onclick="hide('cover2','tipTishi2');">
	<div class="popT1">
		<p class="iconClose">×</p>
		<div>
			<p class="yellow fb">你要先关注“<?php  echo $_W['uniaccount']['name'];?>”<br>才能帮他抽拼图哦！</p>
		</div>
		<p><img src="<?php  echo $_W['account']['qrcode'];?>" width="160" height="160"></p>
		
		<ul class="list3"  style="line-height:23px; margin-top:10px">
		<li>长按二维码或微信<br>搜索关注“<?php  echo $_W['uniaccount']['name'];?>”</li>
		<?php  if($_W['uniaccount']['level']<4) { ?>
		<li>点开系统推送的活动链接</li>
		<?php  } ?>
		<li>重新点击好友分享的链接<br>帮TA抽拼图</li>
		</ul>
	</div>
</div>

<div class="tipBox2" id="tipTishi_time" onclick="hide('cover2','tipTishi_time');">
	<div class="popT1">
		<p class="iconClose">×</p>
		<div><p class="s16em yellow fb" id="msg">活动已结束！</p>
			<p>已成功参加活动的小伙伴们<br>请在关注官方公众号或活动页面领奖信息。</p>
		</div>
		<p><img src="<?php  echo $_W['account']['qrcode'];?>" width="160" height="160"></p>
		
		<ul class="list3">
		<li>长按二维码或微信<br>搜索关注“<?php  echo $_W['uniaccount']['name'];?>”</li>
		<li>公众号内回复<br>关键词“拼图”进入活动</li>
		</ul>
	</div>
</div>

<script type="text/javascript" src="<?php echo MODULE_URL;?>/template/static/js/public.js"></script>
<script type="text/javascript">
	

	function open(){
		show('cover','xx4_pop');
		var openurl = "<?php  echo $this->createMobileUrl('join', array('rid' => $reply['rid'],'id' => $userhelp['id']))?>";
		
		$.ajax({
			type: "POST",
			url: openurl,
			data: {},
	        dataType: "json",
	        success: function(str){
				if(str!=null && str!=''){
					if(str.status =="success"){
						if(str.tid == null || str.tid == ""){//开通
						    var pintuclass = "pintuD1";
							pintuclass = "pintuD"+str.pttype;
							$("#xx4_pop2_image").removeClass().addClass(pintuclass);
							hide('cover','xx4_pop');
							show('cover','xx4_pop2');
						}else{//助力TA抽拼图
							var pintuclass = "pintuD1";
							var zlarray=[<?php  if(is_array($zlarray)) { foreach($zlarray as $row) { ?>
<?php  echo $row;?>,<?php  } } ?>0];
							pintuclass = "pintuD"+str.pttype;
							
							$("#xx4_pop2_other_image").removeClass().addClass(pintuclass);
							if(zlarray.indexOf(str.pttype) != -1){
								$("#xx4_pop2_other_content").html("(TA已经有这张拼图了）");
							}else{
								$("#xx4_pop2_other_content").html(""); 
							}
							hide('cover','xx4_pop');
							show('cover','xx4_pop2_other');
						}
					}else if(str.status =="nofollow"){//用户未关注
						hide('cover','xx4_pop');
						show('cover2','tipTishi2');
					}else if(str.status =="endtime"){//活动不在进行中
						hide('cover','xx4_pop');
						show('cover2','tipTishi_time');
					}else{
						hide('cover','xx4_pop');
						$('.mtb20').html(str.errmsg);
						show('cover','xx4_pop_error');
						
					}
				}
	        },
	        error: function(err) {
	        	
	        }
		});
		
	}
	
	function detail(){
			//
			
			
			detailui="";
            <?php  if(is_array($helplist)) { foreach($helplist as $row) { ?>
			   
			     detailui+= "<li><img src='<?php  echo $row['avatar'];?>' width='30' height='30'><span> <?php  echo htmlspecialchars($row['nickname']);?></span></br><?php  echo date('m-d H:i:s', $row['createtime']);?><div><p class='pintuD<?php  echo $row['pttype'];?> t2'></p></div></li>";

	           
	        <?php  } } ?>
			$("#detailui").html(detailui);
	        show('cover','xx4_pop3',1);
	}
	
	function ajaxsetuse(){
	var usepwd=$("#usepwd").val();
	if(usepwd==''){
	    alert("请填写核销密码");
		return false;
	}

	$.ajax({
		type: "POST",
		url: "<?php  echo $this->createMobileUrl('setuse', array('rid' => $reply['rid'],'id' => $userhelp['id']))?>",
		data: {usepwd:usepwd},
	    dataType: "json",
	    success: function(str) {
			if(str!=null && str!=''){
				if(str.status == "success"){
					hide('cover','xx5_pop');
					$('.mtb20').html(str.errmsg);
					show('cover','xx4_pop_error');
					
				}else{
				    hide('cover','xx5_pop');
					$('.mtb20').html(str.errmsg);
					show('cover','xx4_pop_error');
				}
			}
	    },
	    error: function(err) {
	    	
	    }
	});
}

</script>


<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>