<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<div class="main">
    <ul class="nav nav-tabs">
        <li<?php  if($_GPC['do'] == 'manage' || $_GPC['do'] == '' ) { ?> class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('manage');?>">活动管理</a></li>
        <li<?php  if($_GPC['do'] == 'post') { ?> class="active"<?php  } ?>><a href="<?php  echo url('platform/reply/post',array('m'=>'tyzm_pintu'));?>">添加活动规则</a></li>

    </ul>
    
 
    <div class="panel panel-info">
	<div class="panel-heading">筛选</div>
	<div class="panel-body">
		<form action="./index.php" method="get" class="form-horizontal" role="form">
			<input type="hidden" name="c" value="site" />
			<input type="hidden" name="a" value="entry" />
        	<input type="hidden" name="m" value="tyzm_pintu" />
        	<input type="hidden" name="do" value="manage" />
			<div class="form-group">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键字</label>
				<div class="col-sm-8 col-lg-9">
					<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
				</div>
                                <div class=" col-xs-12 col-sm-2 col-lg-2">
					<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
				</div>
			</div>
 			<div class="form-group">
			</div>
		</form>
	</div>
 
    </div>
 
    <div style="padding:15px;">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr><th class='with-checkbox' style="width:20px;">
                    <input type="checkbox" class="check_all" /></th>
                    <th>活动名称</th>
					<th width="120">活动链接</th>
                    <th width="90">参与人次</th>
                    <th width="90">已完成人数</th>
                    <th width="160">开始时间/结束时间</th>
                    <th width="70">状态</th>  
                    <th width="230">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>

                    <td class="with-checkbox">
                        <input type="checkbox" name="check" value="<?php  echo $row['id'];?>"></td>	 <td><?php  echo $row['title'];?> </td>
						<td class="js-url"> <a href="<?php  echo $_W['siteroot'].'app/' ?><?php  echo $this->createMobileUrl('index',array('id'=>$row['rid']))?>" data-url="<?php  echo $_W['siteroot'].'app/' ?><?php  echo $this->createMobileUrl('index',array('id'=>$row['rid']))?>" class="btn  btn-default " rel="tooltip" title="" target="_blank"><i class="fa fa-cog"></i>活动链接</a></td>
                    <td><?php  echo $row['jointotal'];?></td>
                    <td><span class="label label-success"><?php  echo $row['finish'];?></span></td>
                    <td><?php  echo date('Y-m-d H:i:s',$row['starttime'])?><br>
                        <?php  echo date('Y-m-d H:i:s',$row['endtime'])?></td>
                    <td>
					    <?php  if($row['status']==1) { ?>
						  <span class="label label-success">开始</span>
						<?php  } else if($row['status']==3) { ?>
						  <span class="label label-warning">未开始</span>
						<?php  } else if($row['status']==4) { ?>
						  <span class="label label-default">已结束</span>
						<?php  } else { ?>
						  <span class="label label-danger">已关闭</span>
						<?php  } ?>
					
					</td>
                    <td >
                   
                    <a href="<?php  echo $this->createWebUrl('joinlist',array('rid'=>$row['rid']))?>" class="btn  btn-default" rel="tooltip" title="参与用户"><i class="fa fa-cog"></i>参与用户</a>
                        <a class="btn btn-default" rel="tooltip" href="<?php  echo url('platform/reply/post',array('m'=>'tyzm_pintu','rid'=>$row['rid']));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        <?php  if($row['status']==0) { ?>
                        <a class="btn   btn-default" title="开始活动" href="#" onclick="drop_confirm('您确定要开始活动吗!', '<?php  echo $this->createWebUrl('setstatus',array('rid'=>$row['rid'],'status'=>1))?>');"><i class="fa fa-play"></i></a>
                        <?php  } else { ?>
                        <a class="btn   btn-default" title="关闭活动" href="#" onclick="drop_confirm('您确定要暂停活动吗？', '<?php  echo $this->createWebUrl('setstatus',array('rid'=>$row['rid'],'status'=>0))?>');"><i class="fa fa-stop"></i></a>
                        <?php  } ?>
           
						
						<a class="btn  btn-default" rel="tooltip" href="#" onclick="drop_confirm('您确定要删除吗?删除不可恢复。', '<?php  echo url('platform/reply/delete',array('m'=>'tyzm_pintu','rid'=>$row['rid']));?>');" title="删除"><i class="fa fa-times"></i></a> 
                  
                       
                    </td>
                </tr>
                <?php  } } ?>
                <tr>
                    <td colspan="8">

                        <input type="button" class="btn btn-primary" name="deleteall" value="删除选择的" />
                    </td>
                </tr>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>

</div>
<script>
            $(function(){

            $(".check_all").click(function(){
            var checked = $(this).get(0).checked;
                    $("input[type=checkbox]").attr("checked", checked);
            });
                    $("input[name=deleteall]").click(function(){

            var check = $("input:checked");
                    if (check.length < 1){
            err('请选择要删除的记录!');
                    return false;
            }
            if (confirm("确认要删除选择的记录?")){
            var id = new Array();
                    check.each(function(i){
                    id[i] = $(this).val();
                    });
                    $.post('<?php  echo create_url('site/module', array('do' => 'deleteAll', 'name' => 'tyzm_pintu'))?>', {idArr:id}, function(data){
                    if (data.errno == 0)
                    {
                    location.reload();
                    } else {
                    alert(data.error);
                    }


                    }, 'json');
            }

            });
                    });</script>
<script>
            function drop_confirm(msg, url){
            if (confirm(msg)){
            window.location = url;
            }
            }
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>