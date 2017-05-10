// JavaScript Document
function checksearch()
{
	if($("#keyword").val()=="")
	{
		alert('请输入您要查询的内容！');
		return false;
	}
}

function addcomment()
{	
	comment_txt=$("#comment_txt").val();
	channel_id=$("#channel_id").val();
	news_id=$("#news_id").val();
	cat_id=$("#cat_id").val();
	title=$("#title").val();
	yzm=$("#getcode").val();
	if(comment_txt=="")
	{
		alert('请输入你的评论内容');
		$("#comment_txt").focus();
		return false;
	}	
	if(isNaN(channel_id)||channel_id=="")
	{
		alert('数据不正确，请检查');
		return false;
	}
	if(isNaN(cat_id)||cat_id=="")
	{
		alert('数据不正确，请检');
		return false;
	}	
	if(isNaN(news_id)||news_id=="")
	{
		alert('数据不正确，请检');
		return false;
	}	
	if(isNaN(yzm)||yzm.length!=4)
	{
		alert('验证码不正确，请重新输入');
		$("#getcode").focus();
		return false;
	}	
	//alert('aaa');
	$.get("/include/addcomment.asp", { channel_id: channel_id, news_id: news_id,cat_id:cat_id,comment_txt:escape(comment_txt),yzm:yzm,title:escape(title) },
	   function(data){ 
	     //alert(data);
		 data=parseInt(data);	
		 //case 1: alert('请登录');break;
		 switch(data){	
		 	 case 1: alert('请登录');break;
			 case 2: alert('请输入评论内容');break;
			 case 3: alert('请不要输入非法信息');break;
			 case 4: {				 
				 $("#comment_txt").val("");
				 $("#getcode").val("");
				 $("#myzm").src="/include/getcode.asp";	
				 alert('评论成功，等待管理审核中...');			 
				 /*  var date = new Date(); 
					var h = date.getHours(); 
					var m = date.getMinutes(); 
					var s = date.getSeconds();
					var t = date.getMilliseconds(); 
					var timeStr = date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + '  '; 
					timeStr += (h % 12 < 10 ? '0' : '') + (h < 12 ? h : (h - 12)) + ':';
					timeStr += (m < 10 ? '0' : '') + m + ':'; 
					timeStr += (s < 10 ? '0' : '') + s + '.'; 
					timeStr += (s < 10 ? '0' : '') + t + '';
					getcomment("commentid","commentsnum",news_id,channel_id,cat_id,timeStr);	*/			 
				 
				 break;
			 }
			 case 5: alert('验证码错误，请重新输入');break;
			 default:alert('出错！');break;
		 }
	   } 
	); 
}

$(document).ready(function(){
   $("#test2_li_now").find('li').each(function(){
	  	$(this).click(
		   function(){	
		       act=0;		  
		       for(i=0;i<$("#test2_li_now").find('li').length;i++)
			   {				   
				   o=$("#test2_li_now").find('li')[i].innerHTML;
				   p=$(this).html();
				   if(o==p)
				   {
					   $(this).addClass("now");
					   act=i;
				   }
				   else
				   {
				   		$("#test2_li_now").find('li')[i].className='';
				   }
			   }
			   var acturl="";
			   switch(act){
				   case 0:acturl="/tech/search_tech.asp";break;
				   case 1:acturl="/bbs/search_bbs.asp";break;
				   case 2:acturl="/code/search_code.asp";break;
				   case 3:acturl="/soft/search_soft.asp";break;
				   case 4:acturl="/news/search_news.asp";	break;
			   }			   
			   searchform.action=acturl;
		   });
	});
});

function fcheck()
 {
	 if($("#userid").val()=="")
	 {
		 alert('请登录！');
		 return false;
	 }	 
/*	 if($("#content").val()=="")
	 {
		 alert('请输入回复内容！');
		 return false;
	 }*/
 }
