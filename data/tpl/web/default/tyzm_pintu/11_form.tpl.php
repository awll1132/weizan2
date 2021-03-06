<?php defined('IN_IA') or exit('Access Denied');?><style>
.nav_1,.nav_2,.nav_3,.nav_4{display:none}
</style>
  <div class="panel panel-heading">
<ul class="nav nav-pills">
  <li role="presentation" data-tab="nav_0" class="active"><a href="javascript:;">活动设置</a></li>
  <li role="presentation" data-tab="nav_1"><a href="javascript:;">参数设置</a></li>
  <li role="presentation" data-tab="nav_2"><a href="javascript:;">拼图设置</a></li>
  <li role="presentation" data-tab="nav_3"><a href="javascript:;">广告设置</a></li>
  <li role="presentation" data-tab="nav_4"><a href="javascript:;">分享设置</a></li> 
</ul>
 </div>


<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default  nav_tab nav_0">
    <div class="panel-heading" role="tab" id="headingOne">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">基本参数</a>
      </h5>
    </div>

      <div class="panel-body">
        <input type="hidden" name="reply_id" value="<?php  echo $reply['id'];?>" />
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动标题</label>
          <div class="col-sm-9">
            <input class="form-control" type="text" value="<?php  echo $reply['title'];?>" class="span2" name="title">
            <div class="help-block">活动的标题</div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">缩略图</label>
          <div class="col-sm-9">
            <?php  echo tpl_form_field_image('thumb',$reply['thumb'],'', $options);?>
            <div class="help-block">图文消息的缩略图</div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动简介</label>
          <div class="col-sm-9">
            <textarea class="form-control" name="description"><?php  echo $reply['description'];?></textarea>
            <div class="help-block">图文消息的简介</div>
          </div>
        </div>
        	  <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动时间</label>
          <div class="col-sm-4">
            <?php  echo tpl_form_field_daterange('time', array('start'=>date('Y-m-d H:i:s',$reply['starttime']),'end'=>date('Y-m-d H:i:s',$reply['endtime'])), true)?>
            <div class="help-block">输入活动的起止时间</div>
          </div>
      </div>
	          <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动状态</label>
          <div class="col-sm-2">
             <label><input type="radio" value="1" name="status" <?php  if($reply['status'] == 1 ) { ?>checked<?php  } ?>>正常</label>
			 <label><input type="radio" value="0" name="status" <?php  if($reply['status'] == 0 ) { ?>checked<?php  } ?>>禁用</label>
          </div>
        </div>
      </div>

  </div>
  <div class="panel panel-default  nav_tab nav_1">
      <div class="panel-heading" role="tab" id="headingOne">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">活动设置</a>
      </h5>
    </div>

      <div class="panel-body">

        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">参加是否要求关注</label>
          <div class="col-sm-2">
             <label><input type="radio" value="0" name="follow" <?php  if($reply['follow'] == 0 ) { ?>checked<?php  } ?>>否</label>
             <label><input type="radio" value="1" name="follow" <?php  if($reply['follow'] == 1 ) { ?>checked<?php  } ?>>是</label>
          </div>

          <label class="col-xs-12 col-sm-3 col-md-2 control-label">助力是否要求关注</label>
          <div class="col-sm-4">
             <label><input type="radio" value="0" name="followjoin" <?php  if($reply['followjoin'] == 0 ) { ?>checked<?php  } ?>>否</label>
             <label><input type="radio" value="1" name="followjoin" <?php  if($reply['followjoin'] == 1 ) { ?>checked<?php  } ?>>是</label>
          </div>
		  
        </div>
		<div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">报名信息</label>
          <div class="col-sm-9">
             <label><input type="radio" value="0" name="isreg" <?php  if($reply['isreg'] == 0 ) { ?>checked<?php  } ?>>是</label>
             <label><input type="radio" value="1" name="isreg" <?php  if($reply['isreg'] == 1 ) { ?>checked<?php  } ?>>否</label>
			 <div class="help-block">选择“否”时，参加活动不需要填写个人信息！</div>
          </div>

         
		  
        </div>
		<div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">奖品数量</label>
          <div class="col-sm-9">
            <input class="form-control" type="text" value="<?php  echo $reply['awardtotal'];?>" class="span2" name="awardtotal">
            <div class="help-block">请输入最多活动奖品人数</div>
          </div>
        </div>
		<div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示排行数量</label>
          <div class="col-sm-9">
            <input class="form-control" type="text" value="<?php  echo $reply['rankingnum'];?>" class="span2" name="rankingnum">
            <div class="help-block">请输入最多显示多少排行人数</div>
          </div>
        </div>
		<div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">拼图概率</label>
          <div class="col-sm-9">
            <div class="input-group">
			 <span class="input-group-addon">第二张</span>
              <input class="form-control" type="text" value="<?php  echo $reply['ptdata']['pr']['0'];?>" class="span2" name="pr[]">
              <span class="input-group-addon">倍，第三张</span>
              <input class="form-control" type="text" value="<?php  echo $reply['ptdata']['pr']['1'];?>" class="span2" name="pr[]">
              <span class="input-group-addon">倍，第四张</span>
              <input class="form-control" type="text" value="<?php  echo $reply['ptdata']['pr']['2'];?>" class="span2" name="pr[]">
              <span class="input-group-addon">倍，第五张</span>
              <input class="form-control" type="text" value="<?php  echo $reply['ptdata']['pr']['3'];?>" class="span2" name="pr[]">
              <span class="input-group-addon">倍，</span>
			  <span class="input-group-addon">倍，第六张</span>
              <input class="form-control" type="text" value="<?php  echo $reply['ptdata']['pr']['4'];?>" class="span2" name="pr[]">
              <span class="input-group-addon">倍</span>
            </div> 
			<div class="help-block">用户获得第二，第三，第四，第五，第六张的概率默认为5/6,4/6,3/6,2/6,1/6。可以通过设置概率倍数，让后面的拼图出现的概率成倍增长。当第二张概率设置为2倍时，概率变为5/6*2=10/12。</div>
          </div>
        </div>
		<div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">前台核销密码</label>
          <div class="col-sm-9">
            <input class="form-control" type="text" value="<?php  echo $reply['usepwd'];?>" class="span2" name="usepwd">
            <div class="help-block">拼图完成后，可以直接在用户手机进行核销！</div>
          </div>
        </div>
		<div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">地区限制</label>
          <div class="col-sm-9">
            <input class="form-control" type="text" value="<?php  echo $reply['area'];?>" class="span2" name="area">
            <div class="help-block">请填写开发活动地区城市，例如：北京,上海,广州,海口。为空则不限制地区。多个地区用“,”分割。
			<?php  if($baiduapikey=="") { ?>
			<div class="alert alert-danger" role="alert">正确设置百度api市场apikey才能正常使用地区限制，<a href="<?php  echo url('profile/module/setting', array('m' => 'tyzm_pintu'));?>" target="_blank" >点击设置</a>。</div>
			<?php  } ?>
			
			</div>
          </div>
        </div>
		<div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">未关注引导提示</label>
          <div class="col-sm-9">
            <input class="form-control" type="text" value="<?php  echo $reply['ptdata']['followguide'];?>" class="span2" name="followguide">
			<div class="help-block">设置关注投票或参加时，未关注用户可见。</div>
          </div>
        </div>
		<div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">禁用相互助力</label>
          <div class="col-sm-9">
             <label><input type="radio" value="0" name="mutualjoin" <?php  if($reply['mutualjoin'] == 0 ) { ?>checked<?php  } ?>>否</label>
			 <label><input type="radio" value="1" name="mutualjoin" <?php  if($reply['mutualjoin'] == 1 ) { ?>checked<?php  } ?>>是</label>
			 <div class="help-block">选择“是”，则一个用户在一个活动中，仅能给一个人助力，“否”则可以给多个人助力。</div>
          </div>
        </div>

	  
	  </div>
</div>
  <div class="panel panel-default  nav_tab nav_2">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">拼图设置</a>
      </h5>
    </div>

      <div class="panel-body">
	    <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>拼图背景图片</label>
            <div class="col-sm-9 col-xs-12">
               	<?php  echo tpl_form_field_image('bgimg',$reply['bgimg']);?>
				<div class="help-block">全局背景</div>
            </div>
        </div>
	    <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">背景色</label>
            <div class="col-sm-9 col-xs-12">
               	<?php  echo tpl_form_field_color('bgcolor', $reply['bgcolor'])?>
				<div class="help-block">全局背景颜色</div>
            </div>
        </div>
				<div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">助力按钮颜色</label>
            <div class="col-sm-9 col-xs-12">
               	<?php  echo tpl_form_field_color('bbuttoncolor', $reply['ptdata']['bbuttoncolor'])?>
				<div class="help-block">助力按钮主颜色</div>
            </div>
        </div>
		<div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">助力按钮阴影颜色</label>
            <div class="col-sm-9 col-xs-12">
               	<?php  echo tpl_form_field_color('bbuttonycolor', $reply['ptdata']['bbuttonycolor'])?>
				<div class="help-block">助力按钮阴影颜色</div>
            </div>
        </div>
		<div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">小按钮颜色</label>
            <div class="col-sm-9 col-xs-12">
               	<?php  echo tpl_form_field_color('buttoncolor', $reply['ptdata']['buttoncolor'])?>
				<div class="help-block">按钮主颜色</div>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>首页图片</label>
            <div class="col-sm-9 col-xs-12">
               	<?php  echo tpl_form_field_image('startimg',$reply['startimg']);?>
				<div class="help-block">拼图首页图片，要求png格式，融入背景中。</div>
            </div>
        </div>
		<div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">拼图对应图片</label>
          <div class="col-sm-9">
				
				<div class="row">
				  <div class="col-xs-6 col-md-4">
					<a href="javascript:;" class="thumbnail">
					  <img src="<?php  echo $reply['pingtubig1'];?>" width="100%" >
					  <input type="hidden" value="<?php  echo $reply['pingtubig1'];?>" name="pingtubig1">
					  <span>图1</span>
					</a>
				  </div>
				  <div class="col-xs-6 col-md-4">
					<a href="javascript:;"  class="thumbnail">
					  <img src="<?php  echo $reply['pingtubig2'];?>" width="100%" >
					  <input type="hidden" value="<?php  echo $reply['pingtubig2'];?>" name="pingtubig2">
					  <span>图2</span>
					  
					</a>
				  </div>
				  <div class="col-xs-6 col-md-4">
					<a href="javascript:;"  class="thumbnail">
					  <img src="<?php  echo $reply['pingtubig3'];?>" width="100%" >
					  <input type="hidden" value="<?php  echo $reply['pingtubig3'];?>" name="pingtubig3">
					  <span>图3</span>
					</a>
				  </div>
				  <div class="col-xs-6 col-md-4">
					<a href="javascript:;"  class="thumbnail">
					  <img src="<?php  echo $reply['pingtubig4'];?>" width="100%" >
					  <input type="hidden" value="<?php  echo $reply['pingtubig4'];?>" name="pingtubig4">
					  <span>图4</span>
					</a>
				  </div>
				  <div class="col-xs-6 col-md-4">
					<a href="javascript:;"  class="thumbnail">
					  <img src="<?php  echo $reply['pingtubig5'];?>" width="100%" >
					  <input type="hidden" value="<?php  echo $reply['pingtubig5'];?>" name="pingtubig5">
					  <span>图5</span>
					</a>
				  </div>
				  <div class="col-xs-6 col-md-4">
					<a href="javascript:;"  class="thumbnail">
					  <img src="<?php  echo $reply['pingtubig6'];?>" width="100%" >
					  <input type="hidden" value="<?php  echo $reply['pingtubig6'];?>" name="pingtubig6">
					  <span>图6</span>
					</a>
				  </div>
				  <script type="text/javascript">
				require(['jquery', 'util'], function($, util){
					$(function(){
						// 对象绑定点击事件
						$('.thumbnail img').click(function(){
						    thimg=$(this);
							util.image('',function(data){
								thimg.attr("src",data['url']);
								thimg.next().val(data['url']);
							});
						});
					});
				});
               </script>
				</div>
                <div class="help-block">点击图片上传6张对应拼图的图片，顺序不能变。其他部分为透明，仅支持png格式。制图PSD请下载拼图PSD文件, <a href="<?php echo MODULE_URL;?>/template/static/file/pintu.psd">点击下载</a> ，原则上，拼图可以是任何形式，尺寸需保持320*192比例。可以是640*384。</div>
				<div class="help-block">上传的六张图片需要拼成完整的一张图，没有内容的部分为透明。PNG格式图片。</div>
		  </div>
        </div>
	    <div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2  control-label">活动详情</label>
			<div class="col-sm-8">
				<?php  echo tpl_ueditor('eventrule', $reply['eventrule']);?>						
				<div class="help-block">活动详细说明</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2  control-label">活动奖品</label>
			<div class="col-sm-8">
                <?php  echo tpl_ueditor('awardmsg', $reply['awardmsg']);?>					
				<div class="help-block">活动详细说明</div>
			</div>
		</div>

		
		
      </div>

  </div>
    <div class="panel panel-default  nav_tab nav_3">
    <div class="panel-heading" role="tab" id="headingThree">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">广告设置</a>
      </h5>
    </div>
	<div class="panel-body">
	    <div class="form-group">
			<label class="col-xs-12 col-sm-2 col-md-2  control-label">广告（赞助商）区域</label>
			<div class="col-sm-8">
				<?php  echo tpl_ueditor('admodel', $reply['admodel']);?>						
				<div class="help-block">广告区域内容，填写则显示，为空则不显示，可以添加图文信息，样式可随意编辑，支持HTML。仅显示在主页和助力页面！</div>
			</div>
		</div>
	</div>
  </div>
  
  <div class="panel panel-default  nav_tab nav_4">
    <div class="panel-heading" role="tab" id="headingThree">
      <h5 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">分享信息</a>
      </h5>
    </div>

      <div class="panel-body">
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
          <div class="col-sm-9">
            <input class="form-control" type="text" value="<?php  echo $reply['sharetitle'];?>" class="span2" name="sharetitle">
            <div class="help-block">分享给好友或朋友圈时的标题</div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图片</label>
          <div class="col-sm-9">
            <?php  echo tpl_form_field_image('shareimg',$reply['shareimg'],'', $options);?>
            <div class="help-block">分享给好友或朋友圈时的图片</div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
          <div class="col-sm-9">
            <textarea class="form-control" name="sharedesc"><?php  echo $reply['sharedesc'];?></textarea>
            <div class="help-block">分享给好友或朋友圈时的描述</div>
          </div>
        </div>
      </div>

  </div>
</div>

<script>
$(document).ready(function() {  
  
    //Default Action  
    $(".nav_tab").hide(); //Hide all content  
    $(".nav-pills li:first").addClass("active").show(); //Activate first tab  
    $(".nav_tab:first").show(); //Show first tab content  
      
    //On Click Event  
    $(".nav-pills li").click(function() {  
        $(".nav-pills li").removeClass("active"); //Remove any "active" class  
        $(this).addClass("active"); //Add "active" class to selected tab  
        $(".nav_tab").hide(); //Hide all tab content  
        var activeTab = $(this).attr("data-tab"); //Find the rel attribute value to identify the active tab + content  
        $("."+activeTab).show(); //Fade in the active content  
        return false;  
    });  
  
});  
  window.initReplyController = function($scope) {
    
  };
  window.validateReplyForm = function(form, $, _, util, $scope) {
    
    return true;
  };
</script>
