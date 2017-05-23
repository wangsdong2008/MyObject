// JavaScript Document
/*
 功能：jquery无刷新修改商品的数量和价格
 来自：www.aspprogram.cn（asp编程网）
 作者：wangsdong
 原创文件，请保留此信息
*/
/*
id为要修改的记录ID
v是当前默认值
tablename表名
fname为字段名
gname为id的字段名
*/
function forder(id,v,tablename,fname,gname,str5)
{
	str='<input type="text" size="3" value="'+id+'">';
	
	str2='<input id="kk'+id+'" type="text" size="5" value="'+v+'" onblur="fchangeorder('+id+',this.value,\''+v+'\',\''+tablename+'\',\''+fname+'\',\''+gname+'\',\''+str5+'\');">';
	
	$("#"+str5+id).html(str2);		
	$("#kk"+id).focus();
	$("#kk"+id).select();
}
/*
id为记录ID
v1为默认值
v为修改后的值
fname为字段名
gname为ID字段名，自动编号的那个字段的字段名
str5为页面上那个span的ID
*/
function fchangeorder(id,v,v1,t1,fname,gname,str5)
{	
	 $.post("modify.asp",{id:id,v:v,t1:t1,fname:fname,gname:gname},
		 function(data){			 	
			if(data==1)
			{
				
				str='<input type="text" size="5" value="'+v+'" maxlength="20"  style="border:1px solid #FFFFFF; ime-mode:Disabled; color:#800000; font-weight:bold; padding-left:4px; padding-right:4px; padding-top:1px; padding-bottom:1px; background-color:#FFFFFF; cursor:hand;" onClick="forder(\''+id+'\',\''+v+'\',\''+t1+'\',\''+fname+'\',\''+gname+'\',\''+str5+'\');">'
				$("#"+str5+id).html(str);
			}
			else
			{
				$("#"+str5+id).html(v1);
			}			
		 }   
	 );  
}