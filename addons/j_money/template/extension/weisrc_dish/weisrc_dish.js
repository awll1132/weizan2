//呼出所有餐桌
//siteuniacid,islogin
function weisrc_dish_tabel(){
	$("#extendBtn_box").show();
	var _h=$(document).height();
	var _w=$(window).width();
	$('#extendBtn_box').css('height',_h);
	$('#extendBtn_box .panel-body').empty().css({'height':(_h-280),'overflow-y':'scroll'});
	$('#extendBtn_box .panel-footer').html('<button type="button" onclick="weisrc_dish_delivery()" class="btn btn-info">外卖订单</button>');
	$('#extendBtn_box .panel-heading b').text("餐桌管理");
	$.ajax({
	   type: "POST",
	   url: "./index.php?c=entry&do=extension&m=j_money&extend_modal=weisrc_dish&op=getalltable",
	   data: {},
	   success: function(msg){
		   var result=eval("("+msg+")");
		   if(result.success){
			   $('#extendBtn_box .panel-body').html(result.tablelist);
		   }else{
			   swal(result.msg);
		   }
	   }
	});
}
function gettableorder(tableid){
	$.ajax({
		type: "POST",
		url: "./index.php?c=entry&do=extension&m=j_money&extend_modal=weisrc_dish&op=gettableorder",
		data: {"id":tableid},
		success: function(msg){
			$('#extendBtn_box .panel-body').html(msg);
			$('#extendBtn_box .panel-footer').html('<button type="button" onclick="weisrc_dish_tabel()" class="btn btn-info">返回餐桌列表</button>');
			//console.log(msg);
		}
	});
}
function weisrc_dish_delivery(){
	$.ajax({
		type: "POST",
		url: "./index.php?c=entry&do=extension&m=j_money&extend_modal=weisrc_dish&op=getdeliveryorder",
		data: {"id":tableid},
		success: function(msg){
			$('#extendBtn_box .panel-body').html(msg);
			$('#extendBtn_box .panel-footer').html('<button type="button" onclick="weisrc_dish_tabel()" class="btn btn-info">返回餐桌列表</button>');
		}
	});
}

function weisrc_dish_pay(orderid,total,price){
	isPaying=true;
	swal({
		title: orderid+"是否确认进行收款？",   
		text: "收款金额：￥"+total+"元",
		html: true,
		showCancelButton:true,
		closeOnConfirm: false,
		confirmButtonText: "确认",
		cancelButtonText: "关闭",
		}, function(isConfirm){
			isPaying=false;
			if (isConfirm) {
				extendPay(orderid,total,function(){weisrc_dish_paysuccess(orderid)},0);
			}
		}
	);
}


function weisrc_dish_paysuccess(osn){
	$.ajax({
		type: "POST",
		url: "./index.php?c=entry&do=extension&m=j_money&extend_modal=weisrc_dish&op=paysuccess",
		data: {"orderid":osn},
		success: function(msg){
			weisrc_dish_tabel();
		}
	});
}