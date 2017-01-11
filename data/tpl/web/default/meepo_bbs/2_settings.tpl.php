<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style>
.template .item{position:relative;display:block;float:left;border:1px #ddd solid;border-radius:5px;background-color:#fff;padding:5px;width:190px;margin:0 20px 20px 0; overflow:hidden;}
.template .title{margin:5px auto;line-height:2em;}
.template .title a{text-decoration:none;}
.template .item img{width:178px;height:270px; cursor:pointer;}
.template .active.item-style img, .template .item-style:hover img{width:178px;height:270px;border:3px #009cd6 solid;padding:1px; }
.template .title .fa{display:none}
.template .active .fa.fa-check{display:inline-block;position:absolute;bottom:33px;right:6px;color:#FFF;background:#009CD6;padding:5px;font-size:14px;border-radius:0 0 6px 0;}
.template .fa.fa-times{cursor:pointer;display:inline-block;position:absolute;top:10px;right:6px;color:#D9534F;background:#ffffff;padding:5px;font-size:14px;text-decoration:none;}
.template .fa.fa-times:hover{color:red;}
.template .item-bg{width:100%; height:342px; background:#000; position:absolute; z-index:1; opacity:0.5; margin:-5px 0 0 -5px;}
.template .item-build-div1{position:absolute; z-index:2; margin:-5px 10px 0 5px; width:168px;}
.template .item-build-div2{text-align:center; line-height:30px; padding-top:150px;}
</style>
<div class="clearfix template">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a class="btn btn-default" href="<?php  echo $this->createWebUrl('credit')?>">快捷操作</a>
		</div>
		<div class="panel-body">
			<?php  if(is_array($stylesResult)) { foreach($stylesResult as $item) { ?>
				<div class="item item-style<?php  if($setting['name'] == $item) { ?> active<?php  } ?>">
					<div class="title">
						<div style="overflow:hidden; height:28px;"><?php  echo $item;?></div>
						<a href="<?php echo './index.php?c=profile&a=module&do=setting&m=meepo_bbs&name='.$item?>">
							<img src="<?php  echo tomedia($_W['siteroot'].'addons/meepo_bbs/template/mobile/'.$item.'/preview.png')?>" class="img-rounded" />
						</a>
						<span class="fa fa-check"></span>
					</div>
				</div>
			<?php  } } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	require(['bootstrap'],function($){
		$('.item .item-build-btn').popover();
	});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>