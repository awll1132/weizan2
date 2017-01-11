<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('nickname', array('op' => 'display'))?>">昵称库管理管理</a></li>
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('nickname', array('op' => 'post'))?>"><?php  if($id==0) { ?>添加昵称库管理<?php  } else { ?>修改昵称库管理<?php  } ?></a></li>

</ul>
<style>
.panel-body {
padding: 10px;
}
</style>
<?php  if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<div class="panel panel-default">
			<div class="panel-heading">
				添加昵称库管理
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">排序</label>
					<div class="col-sm-5">
						<input type="text" name="displayorder" class="form-control" value="<?php  echo $category['displayorder'];?>" />
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">昵称库管理名称</label>
					<div class="col-sm-5">
						<input type="text" name="catename" class="form-control" value="<?php  echo $category['name'];?>" />
					</div>
				</div>
			</div>
			
			
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">昵称库管理描述</label>
					<div class="col-sm-5">
						<?php  echo tpl_ueditor('description',$category['description'])?>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">是否显示</label>
					<div class="col-sm-5">
						<label for="enabled1" class="radio-inline"><input type="radio" name="enabled" value="1" id="enabled1" <?php  if(!empty($category['enabled']) && $category['enabled'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
	                    &nbsp;&nbsp;&nbsp;
	                    <label for="enabled2" class="radio-inline"><input type="radio" name="enabled" value="0" id="enabled2"  <?php  if(empty($category['enabled']) || $category['enabled'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>	           
					</div>
				</div>
			</div>
			<div class="form-group col-sm-12">
				<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				<input type="hidden" name="id" value="<?php  echo $category['id'];?>" />
				<input type="submit" class="btn btn-primary col-lg-1" name="submit" value="提交" />
			</div>
		</div>
	</form>
</div>


<?php  } else if($operation == 'display') { ?>

<div class="main">
	<div class="category">
		
			<div class="panel panel-default">
				<div class="panel-heading">
					管理昵称库管理  <span style="font-weight:bold;color:#F78AA9;float:right"> [ 系统已经默认拥有470个昵称 ]</span><span style="font-weight:bold;color:#53a93f;float:right">[ 自己添加昵称拥有<?php  echo $total;?>个昵称 ]   </span>
				</div>
				<div class="panel-body table-responsive">
					<form action="" method="post" class="form-horizontal form" onsubmit="return formcheck(this)">
					<table class="table table-hover">

					<thead class="navbar-inner">
						<tr>
							<th style="width:10px;"></th>
							<th style="width:100px;">显示顺序</th>
							<th style="width:200px;">昵称库管理名称</th>
							<th style="width:100px;">是否显示</th>
							<th style="width:180px;">操作</th>
						</tr>
					</thead>

					<tbody id="main">
						<?php  if(is_array($category)) { foreach($category as $row) { ?>
						<tr>
							<td>
								<?php  if(count($children[$row['id']]) > 0) { ?>
									<a href="javascript:;" >
										
									</a>
								<?php  } ?>
							</td>
							<td class="text-center">
								<input type="text" name="displayorder[<?php  echo $row['id'];?>]" value="<?php  echo $row['displayorder'];?>">
							</td>

							<td class="text-left">
								<div style="height:30px;line-height:30px;"><?php  echo $row['name'];?>&nbsp;&nbsp;
								</div>
							</td>

							<td><?php  if(!empty($row['enabled']) && $row['enabled'] == 1) { ?><div class="btn btn-success btn-sm">显示</div><?php  } else { ?><div class="btn btn-default btn-sm">不显示</div><?php  } ?>
							</td>

							<td>
								<a href="<?php  echo $this->createWebUrl('nickname', array('op' => 'post', 'id' => $row['id']))?>" title="编辑" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit">编辑</i></a>

								<a href="<?php  echo $this->createWebUrl('nickname', array('op' => 'delete','id' => $row['id']))?>" onclick="return confirm('确认删除此分类吗？');return false;" title="删除" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top"><i class="fa fa-times">删除</i></a>

							</td>
						</tr>	
					<?php  } } ?>

					<tr>
						<td></td>
						<td colspan="4">
							<input name="submit" type="submit" class="btn btn-primary" value="提交">
							<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
						</td>
					</tr>
					</tbody>
					</table>
					<?php  echo $pager;?>
					</form>
					<tr>
            				<td colspan="3">
            					<form method="post" action="<?php  echo $this->CreateWebUrl('import');?>" enctype="multipart/form-data">
            					请选择要导入的XLS文件：<input type="file" name="file"  /> <input type="submit" value="导入昵称" />
            					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            					</form>
            				</td>
            			</tr>
				</div>
			</div>
	</div>
</div>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>