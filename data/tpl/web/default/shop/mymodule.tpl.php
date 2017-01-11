<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/header-gw', TEMPLATE_INCLUDEPATH));?>
<div class="main">
<ul class="nav nav-tabs">
	<li class="active"><a href="<?php  echo url('shop/mymodule');?>">应用商店</a></li>
</ul>
<style type="text/css">
    .panel-body > ul{list-style:none;margin: 0px;padding: 0px}
    .panel-body > ul li{display: inline-block}
</style>
<style type="text/css">	
html,body,h1,h2,h3{font-family:arial, 'Hiragino Sans GB', 'Microsoft Yahei', '微软雅黑', '宋体', \5b8b\4f53, Tahoma, Arial, Helvetica, STHeiti}
.nav2{height:50px;padding-left:0;margin-bottom:0;list-style:none}
.nav2>li{height:50px;padding-top:6px;position:relative;display:block}
.nav2>li>a{position:relative;padding:10px 8px}
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
				<?php  if(is_array($modules)) { foreach($modules as $row) { ?>
					<div class="item2" data-title=<?php  echo $row['title'];?> data-type=<?php  echo $row['type'];?>>
						<div class="biz-div">
							<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" class="pull-left biz-icon">
								<img src="<?php  echo $row['imgsrc'];?>" class="img-rounded" title="<?php  echo $row['title'];?>" height="48" width="48" onerror="this.src='../web/resource/images/nopic-small.jpg'">
							</a>
							<div class="biz-info-0">
								<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" title="<?php  echo $row['title'];?>">
									<span class="biz-name"><?php  echo cutstr($row['title'], 8, true);?></span>
								</a>
								<div class="biz-div-0">
										<span class="biz-price pull-left"><?php  echo $row['price'];?>元/年</span>
										<?php  if(in_array($row['name'],$taocmd)) { ?>
										<button class="pull-right biz-buy-btn btn btn-info btn-sm">套餐内置</button>
										<?php  } ?>
										<?php  if(!in_array($row['name'],$taocmd) && empty($moduletime[$row['name']])) { ?>
										<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" class="pull-right biz-buy-btn btn btn-warning btn-sm">购买</a>
										<?php  } ?>
				<!--						<?php  if(!in_array($row['name'],$taocmd) && $moduletime[$row['name']]) { ?>
										<button class="pull-right biz-buy-btn btn btn-info btn-sm">已购买</button>
										<?php  } ?>-->
										<?php  if(!in_array($row['name'],$taocmd) && $moduletime[$row['name']]) { ?>
										
										  <?php  if($moduletime[$row['name']]<TIMESTAMP) { ?>
										  <span class="biz-price pull-left">&nbsp;&nbsp;已过期,请尽快续费</span>
										  <?php  } else { ?>
										  <span class="biz-price pull-left">&nbsp;&nbsp;有效期至<?php  echo date('Y-m-d',$moduletime[$row['name']])?></span>
										  <?php  } ?>
										<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" class="pull-right biz-buy-btn btn btn-success btn-sm">续费</a>
										<?php  } ?>
				<!--						<?php  if($itemzt['status']=='2') { ?>
										<a href="<?php  echo url('members/morder/post', array('module' =>$row['name']))?>" class="pull-right biz-buy-btn btn btn-warning btn-sm">到期禁用</a>
										<?php  } ?>-->
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

<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>