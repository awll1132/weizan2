<?php defined('IN_IA') or exit('Access Denied');?><?php  if($moudles) { ?>
<?php  if($enable_modules) { ?>
<div class="page-header">
	<h4><i class="fa fa-cubes"></i> 已购买的应用</h4>
</div>
<style type="text/css">	
html,body,h1,h2,h3{font-family:arial, 'Hiragino Sans GB', 'Microsoft Yahei', '微软雅黑', '宋体', \5b8b\4f53, Tahoma, Arial, Helvetica, STHeiti}
.nav2{height:50px;padding-left:0;margin-bottom:0;list-style:none}
.nav2>li{height:50px;padding-top:6px;position:relative;display:block}
.nav2>li>a{position:relative;display:block;padding:10px 8px}
.nav2>li>a:hover,.nav2>li>a:focus{text-decoration:none;background-color:#eee}
.nav2>li.disabled>a{color:#777}
.nav2>li.disabled>a:hover,.nav2>li.disabled>a:focus{color:#777;text-decoration:none;cursor:not-allowed;background-color:transparent}
.nav2 .open>a,.nav2 .open>a:hover,.nav .open>a:focus{background-color:#eee;border-color:#428bca}
.nav2 .nav2-divider{height:1px;margin:9px 0;overflow:hidden;background-color:#e5e5e5}
.nav2>li>a>img{max-width:none}.nav-tabs{border-bottom:1px solid #ddd}
/*模块*/
.module .content .biz-module{margin:0 0 40px 0;}
.module .content .biz-module .col-sm-4{padding-left:0px;}
.item2{height:100px; float:left; margin:5px 0;width: 33.33333333%;}
.item2:hover .biz-div{overflow:hidden; border:1px #CCC solid; box-shadow:0 5px 10px rgba(0, 0, 0, 0.1); height:225px; z-index:20;}
.item2:hover .biz-info-1{display:block;}
.item2 a:not(.btn){color:#333;}
.biz-div{width:100%; padding:5px; border:1px #FFF solid; position:relative;}
.biz-div .biz-icon{margin-right:10px; width:48px; height:48px;}
.biz-div .biz-info-0 .biz-div-0 ,.templet .items .buy{overflow:hidden; line-height:30px;}
.biz-div .biz-info-0 .biz-div-1,.templet .items .infos{margin-top:10px; font-size:14px;}
.biz-div .biz-info-0 .biz-div-1 em,.templet .items .infos em{font-style:normal; color:#999;}
.biz-div .biz-info-0 .biz-name{font-size:16px;}
.biz-div .biz-info-0 .biz-price,.templet .items .price{color:#F60;}
.biz-div .biz-info-1{display:none; overflow:hidden; position:absolute; z-index:10; width:100%; background:#F9F9F9; color:#999;  border-top:1px solid #EEE; height:140px; padding:5px; margin:5px 0 0 -5px; font-size:12px; line-height:18px;}
</style>
<div class="neirong">
<div class="clearfix" style="width:100%;margin:0 auto">
		<nav role="navigation" class="navbar navbar-default" style="margin-bottom:20px;">
		<div class="container-fluid">
			<div class="navbar-header"><a href="" class="navbar-brand">功能类型</a></div>
			<ul class="nav2 navbar-nav nav-btns">
				<li class="active"><a href="">全部</a></li>
				<?php  if(is_array($modtypes)) { foreach($modtypes as $type) { ?>
				<li><a href="#" data-type=<?php  echo $type['name'];?> class="type"><?php  echo $type['title'];?></a></li>
				<?php  } } ?>
				<div class="navbar-form navbar-right" role="search">
						<div id="search-menu">
							<input type="text" name="keyword" class="form-control" placeholder="搜索模块">
					</div>
				</div>
			</ul>
		</div>
	</nav>

<div class="tab-pane module active">
		<div class="content clearfix">
			<div class="biz-module clearfix">
				<!-- 模块列表 -->
				<?php  if(is_array($enable_modules)) { foreach($enable_modules as $key => $row) { ?>
					<div class="item2" data-title=<?php  echo $row['title'];?> data-type=<?php  echo $row['type'];?>>
						<div class="biz-div">
							<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" class="pull-left biz-icon">
								<img src="<?php  echo $row['icon'];?>" class="img-rounded" title="<?php  echo $row['title'];?>" height="48" width="48" onerror="this.src='../web/resource/images/nopic-small.jpg'">
							</a>
							<div class="biz-info-0">
								<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" title="<?php  echo $row['title'];?>">
									<span class="biz-name"><?php  echo cutstr($row['title'], 8, true);?></span>
								</a>
								<div class="biz-div-0">
										<span class="biz-price pull-left"><?php  echo $row['price'];?>元/年</span>
										<button class="pull-right biz-buy-btn btn btn-info btn-sm">已购买</button>
								</div>
								<div class="biz-div-1">
									<span class="pull-right"><em>版本号 : </em><?php  echo $row['version'];?></span>
									<span>
										<em>简介 : </em><a href="#"><?php  echo cutstr($row['ability'], 12, true);?></a>
									</span>
								</div>
							</div>
							<div class="biz-info-1">
								<a href="#" class="pull-left" style="width:200px">
								<?php  echo cutstr($row['description'], 58, 1)?>
								</br>
								【查看功能演示】
								</br>
								扫描右侧二维码 >></br>
								回复关键词：“<font color="red"><?php  echo $row['title'];?></font>”
								</a>
								
								<a href="#" class="pull-right">
								<img src="<?php  if(!empty($_W['setting']['copyright']['ewm'])) { ?><?php  echo tomedia($_W['setting']['copyright']['ewm']);?><?php  } else { ?>./resource/weidongli/images/ewm.jpg<?php  } ?>" class="img-rounded" title="<?php  echo $row['title'];?>" height="118" width="118">
								</a>
							</div>
						</div>
					</div>
				<?php  } } ?>
			</div>
		</div>
	</div>
</div>
	<?php  echo $pager;?>
	<script type="text/javascript">
		require(['bootstrap'],function(){
		$('#search-menu input').keyup(function() {
			var a = $(this).val();
			$('.item2').hide();
			$('.item2').each(function() {
				if(a.length > 0 && $(this).attr('data-title').indexOf(a) >= 0) {
					$(this).show();
				}
			});
			if(a.length ==0) {
				$('.item2').show();
			}
		});
		$('.type').click(function() {
			var b = $(this).attr('data-type');
			$('.active').attr('class','');
			$(this).parent('li').attr('class','active');
			$('.item2').hide();
			$('.item2').each(function() {
				if($(this).attr('data-type')==b) {
					$(this).show();
				}
			});
		});
		})
	</script>
<?php  } ?>
<?php  if($unenable_modules) { ?>
<div class="page-header">
	<h4><i class="fa fa-cubes"></i> 未启用的模块</h4>
</div>
<style type="text/css">	
html,body,h1,h2,h3{font-family:arial, 'Hiragino Sans GB', 'Microsoft Yahei', '微软雅黑', '宋体', \5b8b\4f53, Tahoma, Arial, Helvetica, STHeiti}
.nav2{height:50px;padding-left:0;margin-bottom:0;list-style:none}
.nav2>li{height:50px;padding-top:6px;position:relative;display:block}
.nav2>li>a{position:relative;display:block;padding:10px 8px}
.nav2>li>a:hover,.nav2>li>a:focus{text-decoration:none;background-color:#eee}
.nav2>li.disabled>a{color:#777}
.nav2>li.disabled>a:hover,.nav2>li.disabled>a:focus{color:#777;text-decoration:none;cursor:not-allowed;background-color:transparent}
.nav2 .open>a,.nav2 .open>a:hover,.nav .open>a:focus{background-color:#eee;border-color:#428bca}
.nav2 .nav2-divider{height:1px;margin:9px 0;overflow:hidden;background-color:#e5e5e5}
.nav2>li>a>img{max-width:none}.nav-tabs{border-bottom:1px solid #ddd}
/*模块*/
.module .content .biz-module{margin:0 0 40px 0;}
.module .content .biz-module .col-sm-4{padding-left:0px;}
.item2{height:100px; float:left; margin:5px 0;width: 33.33333333%;}
.item2:hover .biz-div{overflow:hidden; border:1px #CCC solid; box-shadow:0 5px 10px rgba(0, 0, 0, 0.1); height:225px; z-index:20;}
.item2:hover .biz-info-1{display:block;}
.item2 a:not(.btn){color:#333;}
.biz-div{width:100%; padding:5px; border:1px #FFF solid; position:relative;}
.biz-div .biz-icon{margin-right:10px; width:48px; height:48px;}
.biz-div .biz-info-0 .biz-div-0 ,.templet .items .buy{overflow:hidden; line-height:30px;}
.biz-div .biz-info-0 .biz-div-1,.templet .items .infos{margin-top:10px; font-size:14px;}
.biz-div .biz-info-0 .biz-div-1 em,.templet .items .infos em{font-style:normal; color:#999;}
.biz-div .biz-info-0 .biz-name{font-size:16px;}
.biz-div .biz-info-0 .biz-price,.templet .items .price{color:#F60;}
.biz-div .biz-info-1{display:none; overflow:hidden; position:absolute; z-index:10; width:100%; background:#F9F9F9; color:#999;  border-top:1px solid #EEE; height:140px; padding:5px; margin:5px 0 0 -5px; font-size:12px; line-height:18px;}
</style>
<div class="neirong">
<div class="clearfix" style="width:100%;margin:0 auto">

<div class="tab-pane module active">
		<div class="content clearfix">
			<div class="biz-module clearfix">
				<!-- 模块列表 -->
				<?php  if(is_array($unenable_modules)) { foreach($unenable_modules as $key => $row) { ?>
					<div class="item2" data-title=<?php  echo $row['title'];?> data-type=<?php  echo $row['type'];?>>
						<div class="biz-div">
							<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" class="pull-left biz-icon">
								<img src="<?php  echo $row['icon'];?>" class="img-rounded" title="<?php  echo $row['title'];?>" height="48" width="48" onerror="this.src='../web/resource/images/nopic-small.jpg'">
							</a>
							<div class="biz-info-0">
								<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" title="<?php  echo $row['title'];?>">
									<span class="biz-name"><?php  echo cutstr($row['title'], 8, true);?></span>
								</a>
								<div class="biz-div-0">
										<span class="biz-price pull-left"><?php  echo $row['price'];?>元/年</span>
										<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" class="pull-right biz-buy-btn btn btn-warning btn-sm">购买</a>
								</div>
								<div class="biz-div-1">
									<span class="pull-right"><em>版本号 : </em><?php  echo $row['version'];?></span>
									<span>
										<em>简介 : </em><a href="#"><?php  echo cutstr($row['ability'], 12, true);?></a>
									</span>
								</div>
							</div>
							<div class="biz-info-1">
								<a href="#" class="pull-left" style="width:200px">
								<?php  echo cutstr($row['description'], 58, 1)?>
								</br>
								【查看功能演示】
								</br>
								扫描右侧二维码 >></br>
								回复关键词：“<font color="red"><?php  echo $row['title'];?></font>”
								</a>
								
								<a href="#" class="pull-right">
								<img src="<?php  if(!empty($_W['setting']['copyright']['ewm'])) { ?><?php  echo tomedia($_W['setting']['copyright']['ewm']);?><?php  } else { ?>./resource/weidongli/images/ewm.jpg<?php  } ?>" class="img-rounded" title="<?php  echo $row['title'];?>" height="118" width="118">
								</a>
							</div>
						</div>
					</div>
				<?php  } } ?>
			</div>
		</div>
	</div>
</div>
	<?php  echo $pager;?>
	<script type="text/javascript">
		require(['bootstrap'],function(){
		$('#search-menu input').keyup(function() {
			var a = $(this).val();
			$('.item2').hide();
			$('.item2').each(function() {
				if(a.length > 0 && $(this).attr('data-title').indexOf(a) >= 0) {
					$(this).show();
				}
			});
			if(a.length ==0) {
				$('.item2').show();
			}
		});
		$('.type').click(function() {
			var b = $(this).attr('data-type');
			$('.active').attr('class','');
			$(this).parent('li').attr('class','active');
			$('.item2').hide();
			$('.item2').each(function() {
				if($(this).attr('data-type')==b) {
					$(this).show();
				}
			});
		});
		})
	</script>
<?php  } ?>
<?php  } else { ?>
	<div class="page-header">
		<h4><i class="fa fa-plane"></i> 核心功能设置</h4>
	</div>
	<div class="shortcut clearfix">
		<?php  if($entries['cover']) { ?>
			<?php  if(is_array($entries['cover'])) { foreach($entries['cover'] as $cover) { ?>
			<a href="<?php  echo $cover['url'];?>" title="<?php  echo $cover['title'];?>">
				<i class="fa fa-external-link-square"></i>
				<span><?php  echo $cover['title'];?></span>
			</a>
			<?php  } } ?>
		<?php  } ?>
		<?php  if($module['isrulefields']) { ?>
			<a href="<?php  echo url('platform/reply', array('m' => $m))?>">
				<i class="fa fa-comments"></i>
				<span>回复规则列表</span>
			</a>
		<?php  } ?>
		<?php  if($entries['home'] || $entries['profile'] || $entries['shortcut']) { ?>
			<?php  if($entries['home']) { ?>
				<a href="<?php  echo url('site/nav/home', array('m' => $m))?>">
					<i class="fa fa-home"></i>
					<span>微站首页导航</span>
				</a>
			<?php  } ?>
			<?php  if($entries['profile']) { ?>
				<a href="<?php  echo url('site/nav/profile', array('m' => $m))?>">
					<i class="fa fa-user"></i>
					<span>个人中心导航</span>
				</a>
			<?php  } ?>
			<?php  if($entries['shortcut']) { ?>
				<a href="<?php  echo url('site/nav/shortcut', array('m' => $m))?>">
					<i class="fa fa-plane"></i>
					<span>快捷菜单</span>
				</a>
			<?php  } ?>
		<?php  } ?>
		<?php  if($module['settings']) { ?>
			<a href="<?php  echo url('profile/module/setting', array('m' => $m));?>">
				<i class="fa fa-cog"></i>
				<span title="参数设置">参数设置</span>
			</a>
		<?php  } ?>
	</div>
	<?php  if($entries['menu']) { ?>
	<div class="page-header">
		<h4><i class="fa fa-plane"></i> 业务功能菜单</h4>
	</div>
	<div class="shortcut clearfix">
		<?php  if(is_array($entries['menu'])) { foreach($entries['menu'] as $menu) { ?>
		<a href="<?php  echo $menu['url'];?>" title="<?php  echo $menu['title'];?>">
			<i class="<?php  echo $menu['icon'];?>"></i>
			<span><?php  echo $menu['title'];?></span>
		</a>
		<?php  } } ?>
	</div>
	<?php  } ?>
	<?php  if($entries['mine']) { ?>
	<div class="page-header">
		<h4><i class="fa fa-plane"></i> 自定义菜单</h4>
	</div>
	<div class="shortcut clearfix">
		<?php  if(is_array($entries['mine'])) { foreach($entries['mine'] as $mine) { ?>
		<a href="<?php  echo $mine['url'];?>" title="<?php  echo $mine['title'];?>">
			<i class="<?php  echo $mine['icon'];?>"></i>
			<span><?php  echo $mine['title'];?></span>
		</a>
		<?php  } } ?>
	</div>
	<?php  } ?>
<?php  } ?>
<script type="text/javascript">
<!--
	<?php  if($_W['isfounder']) { ?>
	function checkupgradeModule() {
		require(['util'], function(util) {
			if (util.cookie.get('checkupgrade_<?php  echo $m;?>')) {
				return;
			}
			$.getJSON("<?php  echo url('utility/checkupgrade/module', array('m' => $m));?>", function(ret){
				if (ret && ret.message && ret.message.upgrade == '1') {
					$('body').prepend('<div id="upgrade-tips-module" class="upgrade-tips"><a class="module" href="./index.php?c=cloud&a=upgrade&">【'+ret.message.name+'】检测到新版本'+ret.message.version+'，请尽快更新！</a><span class="tips-close" onclick="checkupgradeModule_hide()"><i class="fa fa-times-circle"></i></span></div>');
					if ($('#upgrade-tips').size()) {
						$('#upgrade-tips-module').css('top', '25px');
					}
				}
			});
		});
	}
	function checkupgradeModule_hide() {
		require(['util'], function(util) {
			util.cookie.set('checkupgrade_<?php  echo $m;?>', 1, 3600);
			$('#upgrade-tips-module').hide();
		});
	}
	$(function(){
		checkupgradeModule();
	});
	<?php  } ?>
//-->
</script>
