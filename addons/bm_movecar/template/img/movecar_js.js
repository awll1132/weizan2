var Lib = {

	opacity0 : function(el,de){
	
	/**
	 * @de		【0】删除，默认，【1】关闭后不删除		
	 * **/
	
	var _el =  $(el);
	
     _el.animate({
		 opacity:0
	  },200,'ease-out',function () {
		
		  if ( !de) {
		  	_el.remove();
		  }else{
		  	_el.hide();
		  }

	  });	
  }, 
  opacity1:function (el){
  	
    $(el).show().animate({
		 opacity:1
		},200);
		
   },
   city_name:function (){
   

   	 var data = {};
   	 data.city_list = ["京", "津", "冀", "晋", "蒙", "辽", "吉", "黑", "沪", "苏", "浙", "皖", "闽", "赣", "鲁", "豫", "鄂", "湘", "粤", "桂", "琼", "渝", "川", "贵", "云", "藏", "陕", "甘", "青", "宁", "新", "港", "澳"];
   
 
   	 var dataHtml = template("city_list_tpl",data);
   	 
   	 $("body").append(dataHtml);
   
   }
   
  
 }


var common_event = function () {
	
	this.main = function () {
		
		//选择城市名称
		$(document).on("click",".dialog_city_list span",function(){  
		   
		   var This = $(this),
		       city = This.text();
		       
		       $("#bindprovince").val(city);
		       $("#city_name").text(city);
		       Lib.opacity0("#dialog_city");
		   
		});
		
		//弹出选择城市
		$(".city_name").click(function(){
			
			Lib.city_name();
			 Lib.opacity1("#dialog_city");
		});
		
		
		//关闭弹出层
		$(document).on("click","#close_dialog",function(){  
		    Lib.opacity0("#dialog2",1);
		    Lib.opacity0("#dialog_city");
		});
		
	}
	
}



//呼叫车主
var root_event = function () {

    this.main = function () {

        var That = this;
       
		//提交
		$("#call_carer_button").click(function(){
			
			That.call_carer_ahax();
		
		});
		
		
			
		
		

    }

   
    this.call_carer_ahax = function (){
        var That = this;
        var postdata = {
        	'who':Init.who,
        	'calltypes':Init.calltypes,
        	'bindprovince':''
        };
        
        $(".form_box .post_class").each(function (){
        	
        	var This = $(this),
        	    Name = This.attr('name'),
        	     Val = This.val();
        	
        	if ( !Val ) {
        		postdata.error = This.attr("placeholder") ;
        		return false;
        	}
        	
        	postdata[Name] = Val;
        	
        });
        
        if ( postdata.error ) {
        	alert(postdata.error);
        	return false;
        }
 		
        $.ajax({
                 type: 'POST',
                 url: Init.appurl+'/movecar/callmove',
                 data: postdata,
                 dataType: 'json',
                 timeout: 50000,
                 beforeSend:function() {},
                 success: function(data){
                   
                   if ( data.status  ) {
                   		$("#succ_info").text(data.info);
                   		Lib.opacity1("#dialog2");
                   		
                   }else{
                   	alert(data.info);
                   }
                   
                   
                   
                 },
                 complete:function() {},
                 error: function(xhr, type){

					alert('呼叫车主过来挪车失败，请重新再试试哦！timeout');
	
                 }
            });

    }


}


//绑定车主
var bindcarnum_event = function () {
	
	this.main = function () {
		
		var That = this;
		
		//提交
		$("#bindcarnum").click(function(){
			
			That.bindcarnum_ajax();
		
		});
		
		//选择绑定的方式
		$(".active_way_click").click(function(){
		
			var This = $(this),
		        way = This.attr("way");
		        
		        if ( way == '0' ) {
		        	$(".act_way_0").show();
		        }else if(  way == '1' ){
		        	$(".act_way_0").hide();
		        }
		        
		        $("#bind_type").val(way);
		       
		       
		       Lib.opacity0('#dialog2',1);
		}); 
		
		//重新选择
		$("#reset_way_click").click(function(){
		
			 Lib.opacity1('#dialog2');
		
		});
		
	}
	
	this.bindcarnum_ajax = function (){
        var That = this;
        var postdata = {
        	'who':Init.who
        };
        
        $(".form_box .post_class").each(function (){
        	
        	var This = $(this),
        	    Name = This.attr('name'),
        	     Val = This.val(),
          _weui_cell = This.closest(".weui_cell");
        	
        	if ( !Val && _weui_cell.css('display') != 'none' ) {
        		postdata.error = This.attr("placeholder") ;
        		return false;
        	}
        	
        	postdata[Name] = Val;
        	
        });
        
        if ( postdata.error ) {
        	alert(postdata.error);
        	return false;
        }
 
 

        $.ajax({
                 type: 'POST',
                 url: Init.appurl+'/movecar/bindcaradddata',
                 data: postdata,
                 dataType: 'json',
                 timeout: 50000,
                 beforeSend:function() {},
                 success: function(data){
                   
                
                   	//alert(data.info);
                   
                    if ( data.status  ) {
                    	$("#infocontent").toggle();
                    	
                    	var dataHtml = template("bind_succ_tpl",data);
                    	$("body").append(dataHtml);
                    	
                    }else{
                    	alert(data.info);
                    }
                   
                   
                 },
                 complete:function() {},
                 error: function(xhr, type){

					alert('绑定车主信息失败，请重新再试试哦！timeout');
	
                 }
            });

    }
	
}



$(function(){
	
	var common_new = new common_event();
	common_new.main();
	
});
















