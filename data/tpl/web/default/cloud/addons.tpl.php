<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/header-gw', TEMPLATE_INCLUDEPATH));?>
<ol class="breadcrumb">
	<li><a href="./?refresh"><i class="fa fa-home"></i></a></li>
	<li><a href="<?php  echo url('system/welcome');?>">系统</a></li>
	<li class="active">切换应用商城</li>
</ol>
<div class="clearfix">
	<h5 class="page-header">切换应用商城</h5>
	<form action="" method="post"  class="form-horizontal" role="form" enctype="multipart/form-data" id="form1">
		
	<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">切换应用商城<br></label>
					<div class="col-sm-9">
						<label class="radio-inline">
					<input type="radio" name="addons_site"  value="0" <?php  if($settings['addons_site'] == 0) { ?> checked="checked" <?php  } ?> onclick="$('#app').hide();$('#appimg').hide();$('#apphelp').hide();$('#appsys').hide();" /> 系统官网
					    </label>
						<label class="radio-inline">
					<input type="radio" name="addons_site"  value="1" <?php  if($settings['addons_site'] == 1) { ?> checked="checked" <?php  } ?> onclick="$('#app').hide();$('#appimg').hide();$('#apphelp').hide();$('#appsys').show();" /> 微动力商城
					    </label>
						
						<label class="radio-inline">
					<input type="radio" name="addons_site"  value="3" <?php  if($settings['addons_site'] == 3) { ?> checked="checked" <?php  } ?> onclick="$('#app').show();$('#appimg').show();$('#apphelp').show();$('#appsys').hide();"/>其他应用商城
					    </label>
					    <div class="help-block"><span style="color:#F00;"><b>第一次使用应用商城，需先保存设置！</b></span></div>
					    <div class="help-block" id="apphelp" <?php  if($settings['addons_site'] == 0 || $settings['addons_site'] == 1 ||$settings['addons_site'] == 2) { ?> style="display: none;"<?php  } ?>><strong>其他应用商城：</strong>请填写你要切换的应用商城地址 <a href="http://bbs.012wz.com/forum.php?mod=viewthread&tid=4324&extra=page%3D1">查看说明</a></div>
					</div>
				</div>
	</div>
	<div class="panel-body">
				<div id="app" <?php  if($settings['addons_site'] == 0 || $settings['addons_site'] == 1 || $settings['addons_site'] == 2) { ?> style="display: none;"<?php  } ?>>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">应用商城地址</label>
					<div class="col-sm-3">
					    <input type="text" name="addons_url" class="form-control" value="<?php  echo $settings['addons_url'];?>" />
					</div>
				</div>
				<!--<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">应用xmlns网址</label>
					<div class="col-sm-3">
					    <input type="text" name="c_url" class="form-control" value="<?php  echo $settings['c_url'];?>" />
					</div>
				</div>-->
				</div>				
	</div>
	<div class="form-group">
			<div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-10 col-md-10 col-lg-11">
				<input name="submit" type="submit" value="提交" class="btn btn-primary span3" />
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
			</div>
		</div>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer-gw', TEMPLATE_INCLUDEPATH)) : (include template('common/footer-gw', TEMPLATE_INCLUDEPATH));?>
