var isMobile;
isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i) ? true : false;
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i) ? true : false;
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i) ? true : false;
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
	}
};
if(isMobile.any()){
	//alert("Is mobile- isAndroid:"+ isMobile.Android() + " isIOS:"+ isMobile.iOS());
	//$('.main_header').hide();
}

function initFocus(id) {
	var tag=$("#"+id);
	var sWidth = tag.width(); //获取焦点图的宽度（显示面积）
	var len = tag.find("ul li").length; //获取焦点图个数
	var index = 0;
	var picTimer;
	
	//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
	/*var btn = "<div class='btnBg'></div><div class='btn'>";
	for(var i=0; i < len; i++) {
		btn += "<span></span>";
	}
	btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";*/
	btn="<div class='preNext pre'></div><div class='preNext next'></div>";
	tag.append(btn);
	//$("#focus .btnBg").css("opacity",0.5);

	//为小按钮添加鼠标滑入事件，以显示相应的内容
	/*$("#focus .btn span").css("opacity",0.4).mouseover(function() {
		index = $("#focus .btn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseover");
	*/
	
	function resetBtnVis(){
		tag.find(".pre").css("display","");
		tag.find(".next").css("display","");
		if(index==0){
			tag.find(".pre").css("display","none");
		}else if(index==len-1){
			tag.find(".next").css("display","none");
		}
	}
	resetBtnVis();
	
	//上一页、下一页按钮透明度处理
	tag.find(".preNext").css("opacity",0.4).hover(function() {
		$(this).stop(true,false).animate({"opacity":"0.7"},300);
	},function() {
		$(this).stop(true,false).animate({"opacity":"0.4"},300);
	});
	
	if(isMobile.any()){
		//上一页按钮
		tag.find(".pre").on("tap",function() {
			swPic(-1);
		});
	
		//下一页按钮
		tag.find(".next").on("tap",function() {
			swPic(1);
		});
	}else{
		//上一页按钮
		tag.find(".pre").on("click",function() {
			swPic(-1);
		});
	
		//下一页按钮
		tag.find(".next").click(function() {
			swPic(1);
		});
	}
	
	function swPic(dir){ //left:-1; right:1;
		if(dir==-1){
			if(index==0)return;
			index-=1;
			if(index == -1) index = len - 1;
		}else{
			if(index==len-1)return;
			index += 1;
			if(index == len) index = 0;
		}
		showPics(index);
		resetBtnVis();
	}
	
	$(tag).on("swiperight",function(e){
		swPic(-1);
	}).on("swipeleft",function(e){
		swPic(1);
	});
	
	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
	tag.find("ul").css("width",sWidth * (len));
	
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	if(!isMobile.any()){ //手机上不需要这个
		tag.hover(function() {
			clearInterval(picTimer);
		},function() {
			run();
		});//.trigger("mouseleave");
	}
	run();
	function run(){
		picTimer = setInterval(function() {
			showPics(index);
			index++;
			if(index == len) {index = 0;}
		},4000); //此4000代表自动播放的间隔，单位：毫秒
	}
	
	//显示图片函数，根据接收的index值显示相应的内容
	function showPics(index) { //普通切换
		var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
		tag.find("ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
		//$("#focus .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
		tag.find(".btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
	}
}

/*初始化detail页中的更多按钮*/
function initDetailMore(showLines){
	var oriFocusHeight=$("#focus1").height();
	$("#focus1 em").each(function(index, element) {
		var tar=$(this);
		var tarOriH=tar.height();
		var lineH=tar.css("line-height").split("px")[0]; //alert(tarOriH+" "+ lineH);
		var moreLine=tarOriH/lineH-showLines; //alert(moreLine);
		
		if(tarOriH>lineH*showLines){
			tar.height(lineH*showLines).css("overflow","hidden");
			tar.parent().append("<b>活动详情&gt;&gt;</b>");
			tar.parent().children("b").click(function(e) {
				if($(this).html()!="&gt;&gt;收起"){
					tar.animate({height:tarOriH},200);
					$("#focus1").animate({height:oriFocusHeight+(moreLine*lineH)},200);
					$(this).html("&gt;&gt;收起");
				}else{
					tar.animate({height:lineH*showLines},200);
					$("#focus1").animate({height:oriFocusHeight},200);
					$(this).html("活动详情&gt;&gt;");
				}
			});
		}
	});
}


//折叠dl-------------------------start---
var currDt, dl, allDt, allDd;
var currIndex;//当前点击打开的项
var anima; //interval
var heightArr; //保存所有dd高度
var canStop, allStop;//canStop:每个项是否折叠完成；allStop：全部项是否都折叠完成；
var tempStr;
function initZheDie(tag, index){
	heightArr=[];
	dl=document.getElementById(tag);
	allDt=dl.getElementsByTagName("dt");
	allDd=dl.getElementsByTagName("dd");
	for(var i=0;i<allDd.length;i++){
		heightArr[i]=allDd[i].clientHeight;
		if(i+1 != parseInt(index)){
			allDd[i].style.height=0;
		}else{
			allDd[i].style.height=heightArr[i] +"px";
			allDt[i].firstChild.firstChild.className="open";
		}
	}
}

function openItem(tag){
	canStop=[];
	currDt=tag.parentNode;
	tempStr="";
	if(allDt.length!=allDd.length){ alert("dt,dd数目不同！"); return; }
	
	for(var i=0;i<allDt.length;i++){
		if(allDt[i]==currDt){
			currIndex=i;
			allDt[i].firstChild.firstChild.className="open";
		}else{
			allDt[i].firstChild.firstChild.className="";
		}
	}
	
	if(anima){
		clearInterval(anima);
	}
	anima=setInterval(menuAnimate, 100);
	
	//alert(dl.childNodes[3].style.height-= dl.childNodes[3].style.height * 0.5);
}

function menuAnimate(){
	var tempH;
	allStop=true;
	for(var i=0; i<allDd.length; i++){
		tempH=parseInt(allDd[i].style.height.replace("px",""));
		if(i==currIndex){ //alert("h: "+ allDd[i].style.height+ " "+ heightArr[i]);
			if(tempH < heightArr[i]){
				allDd[i].style.height = tempH + Math.ceil((heightArr[i]-tempH)*0.4) +"px";
			}else{
				canStop[i]=true;
			}
		}else{
			if(tempH > 0){ //tempStr+= "; H:"+ tempH+" "+Math.ceil(tempH*0.3)+" "+ allDd[i].style.height;
				allDd[i].style.height = tempH - Math.ceil(tempH*0.4) +"px";
			}else{
				canStop[i]=true;
			}
		}
	}

	for(var i=0;i<allDd.length;i++){
		allStop=allStop && canStop[i];
	}
	
	if(allStop){
		clearInterval(anima); //alert("in:"+ tempStr);
	}
}
//折叠dl-------------------------end---

function openmenu(sn_p,subnum_p,ttnum_p){
	var t1=document.getElementById("c"+sn_p+"_"+subnum_p);
	
	if(t1.style.display=="none"){
		for(i=1;i<=ttnum_p;i++){
			document.getElementById("c"+sn_p+"_"+i).style.display="none";
			$("#m"+sn_p+"_"+i).removeClass("on");
		}
		t1.style.display="block";
		$("#m"+sn_p+"_"+subnum_p).addClass("on");
	}
}

/*input、textarea设置默认文本 —— 例如：<input type="text" defaultTxt="不超30个字" defaultCol="#ff3333"/> isPwd="1" 时是密码登录输入框*/
function setDefaultTxt(){
	$("input[defaultTxt]").add($("textarea[defaultTxt]")).each(function(index, element) {
		var tag=$(this);
		var defTxt=tag.attr("defaultTxt"); //默认提示文字
		var defCol=tag.attr("defaultCol")? tag.attr("defaultCol") : "#ccc"; //默认提示文字时的颜色
		tag.css("color", defCol).val(defTxt);
		tag.focus(function(e) {
			if(tag.val()==defTxt){
				tag.val("").css("color","");
				if(tag.attr("isPwd")=="1"){
					tag.get(0).type="password";
				}
			}
		}).blur(function(e) {
			if(tag.val()==""){
				tag.val(defTxt).css("color",defCol);
				if(tag.attr("isPwd")=="1"){
					tag.get(0).type="text";
				}
			}
		});
	});
}

function initTab2(tagId){
	var tag=$("#"+tagId);
	var allLi=tag.children("li");
	allLi.click(function(e) {
		$(this).addClass("on").siblings().removeClass("on");
		$(tag).children("input").val($(this).attr("v"));
	});
}

/*弹出层*/
var useDispAll=0;
var openedLay=0;
function show(cover,id,isModal){
	var Sys = {};
	var ua = navigator.userAgent.toLowerCase();
	var s;
	(s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] : 
	(s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
	(s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;		
	//如果是ie6，隐藏页面select
	var objCover=document.getElementById(cover);
	if(Sys.ie=="6.0"){
		/*var n=document.getElementsByTagName("select").length;
		var m=document.getElementById(id).getElementsByTagName("select").length;
		for(var i=0;i<n;i++){
			document.getElementsByTagName("select")[i].style.display='none';}
		for(var j=0;j<m;j++){		
			document.getElementById(id).getElementsByTagName("select")[j].style.display='';}
		*/
		objCover.innerHTML='<iframe style="width:100%;height:100%;"></iframe>';
	}
	if(isModal){ $("body").addClass("amodal");}
	var objId=document.getElementById(id);
	if( $(objId).css("display")!="none" && $(objId).css("visibility")!="hidden") return;
	objId.style.display="block";
	objId.style.visibility="visible";
	var scrollW=document.documentElement.scrollWidth;
	var scrollH=document.documentElement.scrollHeight;
	if (Sys.safari || Sys.chrome){
		var scrollH=document.body.scrollHeight;
		if(document.documentElement.clientHeight<objId.clientHeight){
			var T=document.body.scrollTop;
		}else{
			var T=(document.documentElement.clientHeight-objId.clientHeight)/2+document.body.scrollTop;
		}
	}else{
		if(document.documentElement.clientHeight<objId.clientHeight){
			var T=document.documentElement.scrollTop;
		}else{
			var T=(document.documentElement.clientHeight-objId.clientHeight)/2+document.documentElement.scrollTop;
		}
	}
	var L=(document.documentElement.clientWidth-objId.clientWidth)/2+document.documentElement.scrollLeft;	
	
	objCover.style.visibility="visible";
	objCover.style.display="block";
	objId.style.top=T+"px";
	objId.style.left=L+"px";
	objCover.style.width=scrollW+"px";
	//objCover.style.height=scrollH+"px";
	objCover.style.height=(document.body.scrollHeight>document.documentElement.scrollHeight? document.body.scrollHeight:document.documentElement.scrollHeight)+"px"; //当弹出层出现，高度撑高后，要重新设置遮罩层高度
	
	if(openedLay>0){
		var newMask=$(objCover).clone(); //alert(newMask.html());
		newMask.css("z-index","2000");
		newMask.insertBefore($(objId));
	}
	openedLay++;
		
	window.onresize=function (){	
		var objCover=document.getElementById(cover);
		var objId=document.getElementById(id);
		var scrollW=document.documentElement.scrollWidth;
		if(document.documentElement.clientHeight >= document.documentElement.scrollHeight){
			var scrollH=document.documentElement.clientHeight;	
		}else{
			var scrollH=document.documentElement.scrollHeight;}
		if (Sys.safari || Sys.chrome) {
			if(document.documentElement.clientHeight<objId.clientHeight){
				var T=document.body.scrollTop;
			}else{
				var T=(document.documentElement.clientHeight-objId.clientHeight)/2+document.body.scrollTop;
			}
		}else{
			if(document.documentElement.clientHeight<objId.clientHeight){
				var T=document.documentElement.scrollTop;
			}else{
				var T=(document.documentElement.clientHeight-objId.clientHeight)/2+document.documentElement.scrollTop;
			}
		}
		var L=(document.documentElement.clientWidth-objId.clientWidth)/2+document.documentElement.scrollLeft;		
		objCover.style.width=scrollW+"px";
		objCover.style.height=scrollH+"px";
		objId.style.top=T+"px";
		objId.style.left=L+"px";
	}
}

function hide(cover,id){
	$("body").removeClass("modal");
	//将页面全部select换件设为可用状态
	var Sys = {};
	var ua = navigator.userAgent.toLowerCase();
	var s;    
	(s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] : 
	(s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;	
	if(Sys.ie=="6.0"){
		/*var n=document.getElementsByTagName("select").length;
		for(var i=0;i<n;i++){
			document.getElementsByTagName("select")[i].style.display= '';
		}*/
	}
	var objCover=document.getElementById(cover);
	var objId=document.getElementById(id);
	
	objId.style.visibility="hidden";
	//if(useDispAll==1){
		objId.style.display="none";
	//}
	if(openedLay>1){
		$(objId).prev().remove();
	}else{
		objCover.style.visibility="hidden";
		objCover.style.display="none";
	}	
	openedLay--;
}

//简单弹出层
function show2(cover,id){
	document.getElementById(cover).style.display="block";
	document.getElementById(id).style.display="block";
	$("html").add($("body")).css("overflow","hidden").css("height","100%");
}
function hide2(cover,id){
	document.getElementById(cover).style.display="";
	document.getElementById(id).style.display="none";
	$("html").add($("body")).css("overflow","").css("height","");
}