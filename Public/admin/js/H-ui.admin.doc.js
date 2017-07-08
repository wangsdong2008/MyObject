/*H-ui.admin.doc.js date:15:42 2015-04-29 by:guojunhui*/
/* 关闭窗口 */
function closeWin()
{
	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    parent.layer.close(index);
}

/*-------------公用函数开始--------------------*/
//添加窗口
function WinAdd(w,h,title,url){
	layer_show(w,h,title,url);
}
//编辑窗口
function WinEdit(w,h,title,url){
	layer_show(w,h,title,url);
}
//批量导入窗口
function WinExpro(id,name,url){//name为提示文字,url为要导入的页面
	var result = new Array();
	$("input[name="+id+"]:checked").each(function(){
		result.push($(this).val());
	});
	var str = result.join(',');
	if(result.length > 0){
		layer.confirm('确认要导入此'+name+'吗？',function(index){
			$.post(url,{id:str,t:Math.random()},function(data){
				if(data*1 == 1){
					for(i=0;i<result.length;i++){
						id = result[i];
						$("#u_"+id).parent("tr").remove();
					}
					layer.msg('已导入!',1);
				}
			});
		});
	}
	else{
		layer.msg('请选择要导入的'+name+'!',1,3);
	}
}

//批量删除窗口
function WinDelAll(id,name,url){//name为提示文字,url为要删除的页面
	var result = new Array();
	$("input[name="+id+"]:checked").each(function(){
		result.push($(this).val());
	});
	var str = result.join(',');
	if(result.length > 0){
	  layer.confirm('确认要删除此'+name+'吗？',function(index){		  
		  $.post(url,{id:str,t:Math.random()},function(data){			  
			  if(data*1 == 1){
				 for(i=0;i<result.length;i++){
					id = result[i];			
					$("#u_"+id).parent("tr").remove();	  
				} 
				layer.msg('已删除!',1); 
			  }
		  });		   
	  });	  
	}
	else{
	   layer.msg('请选择要删除的'+name+'!',1,3);
	}
}
/*-------------公用函数结束--------------------*/


/*----------用户管理------------------*/
/*用户-添加*/
function user_add(w,h,title,url){
	layer_show(w,h,title,url);
}
/*用户-查看*/
function user_show(id,w,h,title,url){
	layer_show(w,h,title,url);
}
/*用户-密码-修改*/
function user_password_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}

/*用户-编辑*/
function user_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}

/*用户-编辑-保存*/
function user_edit_save(obj,id){
	var i = parent.layer.getFrameIndex();
	parent.layer.close(i);
}

/*删除的用户恢复*/
function user_recovery(obj,id){
	layer.confirm('确认要恢复此用户吗？',function(index){
		$.post("userrecovery",{id:id,t:Math.random()},function(data){
		  if(data=="1"){
			$(obj).parents("tr").remove();
			layer.msg('已恢复!',1);
		  }	
		});	
	});
}

/*彻底删除*/
function datadeltrue(){
	var result = new Array();
	$("input[name=userid]:checked").each(function(){
		result.push($(this).val());
	});
	var str = result.join(',');
	if(result.length > 0){
	  layer.confirm('确认要删除吗？此操作将彻底删除掉此用户',function(index){		  
		  $.post('userdeltrueAll',{id:str,t:Math.random()},function(data){
			  if(data*1 == 1){
				 for(i=0;i<result.length;i++){
					id = result[i];			
					$("#u_"+id).parents("tr").remove();	  
				} 
				layer.msg('已删除!',1); 
			  }
			  else{
				  layer.msg('删除失败，请检查你的权限!',1);
			  }
		  });		   
	  });	  
	}
	else{
	   layer.msg('请选择要删除的用户!',1,3);
	}
}

/*批量删除*/
function datadel(){
	var result = new Array();
	$("input[name=userid]:checked").each(function(){
		result.push($(this).val());
	});
	var str = result.join(',');
	if(result.length > 0){
	  layer.confirm('确认要删除吗？',function(index){		  
		  $.post('userdelAll',{id:str,t:Math.random()},function(data){
			  if(data*1 == 1){
				 for(i=0;i<result.length;i++){
					id = result[i];			
					$("#u_"+id).parents("tr").remove();	  
				} 
				layer.msg('已删除!',1); 
			  }
			  else{
				  layer.msg('删除失败，请检查你的权限!',1);
			  }
		  });		   
	  });	  
	}
	else{
	   layer.msg('请选择要删除的用户!',1,3);
	}
}
/*用户-删除*/
function user_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.post("userdel",{id:id,t:Math.random()},function(data){
		  if(data=="1"){
			  $(obj).parents("tr").remove();
			  layer.msg('已删除!',1);
		  }	
		  else{
			  layer.msg('删除失败，请检查你的权限!',1);
		  }
		});	
	});
}

/*用户-停用*/
function user_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		 $.post("updateuserstatus",{id:id,status:1,t:Math.random()},function(data){
			if(data=="1"){
				$(obj).parents("tr").find(".user-manage").prepend('<a style="text-decoration:none" onClick="user_start(this,\''+id+'\')" href="javascript:;" title="启用"><i class="icon-hand-up"></i></a>');
				$(obj).parents("tr").find(".user-status").html('<span class="label">已停用</span>');
				$(obj).remove();
				layer.msg('已停用!',1,5);
			}else{
				layer.msg('停用失败!',1,2);
			}
		 });
		
	});
}
/*用户-启用*/
function user_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		$.post("updateuserstatus",{id:id,status:0,t:Math.random()},function(data){
			  if(data=="1"){
				$(obj).parents("tr").find(".user-manage").prepend('<a style="text-decoration:none" onClick="user_stop(this,\''+id+'\')" href="javascript:;" title="停用"><i class="icon-hand-down"></i></a>');
				$(obj).parents("tr").find(".user-status").html('<span class="label label-success">已启用</span>');
				$(obj).remove();
				layer.msg('已启用!',1,6);
			  }
		   });
	});
}

/*------------资讯管理----------------*/
/*获取分类值*/
function SetSubID(obj) {
	$("#hid_ccid").val($(obj).val());
}
/*资讯-分类-添加*/
function article_class_add(obj){
	var v = $("#article-class-val").val();
	if(v==""||v==null){
		return false;
	}else{
		//ajax请求 添加分类
	}
}

/*资讯-分类-编辑*/
function article_class_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}
/*资讯-添加*/
function article_add(w,h,title,url){
	layer_show(w,h,title,url);
}
/*资讯-编辑*/
function article_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}
/*资讯-下架*/
function article_xiajia(obj,id){
	$(obj).parents("tr").find(".article-manage").prepend('<a style="text-decoration:none" onClick="article_fabu(this,\'10001\')" href="javascript:;" title="发布"><i class="icon-hand-up"></i></a>');
	$(obj).parents("tr").find(".article-status").html('<span class="label radius">已下架</span>');
	$(obj).remove();
}
/*资讯-发布*/
function article_fabu(obj,id){
	$(obj).parents("tr").find(".article-manage").prepend('<a style="text-decoration:none" onClick="article_xiajia(this,\'10001\')" href="javascript:;" title="下架"><i class="icon-hand-down"></i></a>');
	$(obj).parents("tr").find(".article-status").html('<span class="label label-success radius">已发布</span>');
	$(obj).remove();
}
/*管理员-删除*/
function article_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$(obj).parents("tr").remove();
		layer.msg('已删除!',1);
	});
}
/*------------图片库--------------*/
/*图片库-分类-添加*/
function picture_class_add(obj){
	var v = $("#picture-class-val").val();
	if(v==""||v==null){
		return false;
	}else{
		//ajax请求 添加分类
	}
}

/*图片库-分类-编辑*/
function picture_class_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}
/*图片库-添加*/
function picture_add(w,h,title,url){
	layer_show(w,h,title,url);
}
/*图片库-编辑*/
function picture_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}
/*图片库-下架*/
function picture_xiajia(obj,id){
	$(obj).parents("tr").find(".picture-manage").prepend('<a style="text-decoration:none" onClick="picture_fabu(this,\'10001\')" href="javascript:;" title="发布"><i class="icon-hand-up"></i></a>');
	$(obj).parents("tr").find(".picture-status").html('<span class="label radius">已下架</span>');
	$(obj).remove();
}
/*图片库-发布*/
function picture_fabu(obj,id){
	$(obj).parents("tr").find(".picture-manage").prepend('<a style="text-decoration:none" onClick="picture_xiajia(this,\'10001\')" href="javascript:;" title="下架"><i class="icon-hand-down"></i></a>');
	$(obj).parents("tr").find(".picture-status").html('<span class="label label-success radius">已发布</span>');
	$(obj).remove();
}
/*管理员-删除*/
function picture_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$(obj).parents("tr").remove();
		layer.msg('已删除!',1);
	});
}
/*------------产品库------------------*/
/*产品-品牌-编辑*/
function product_brand_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}

/*------------管理员管理--------------*/
/*管理员-角色-添加*/
function admin_role_add(w,h,title,url){
	layer_show(w,h,title,url);
}
/*管理员-角色-编辑*/
function admin_role_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}
/*管理员-角色-删除*/
function admin_role_del(obj,id){
	layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
		$(obj).parents("tr").remove();
		layer.msg('已删除!',1);
	});
}

/*管理员-权限-添加*/
function admin_permission_add(){
	
}
/*管理员-权限-编辑*/
function admin_permission_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}

/*管理员-权限-删除*/
function admin_permission_del(obj,id){
	layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
		$(obj).parents("tr").remove();
		layer.msg('已删除!',1);
	});
}

/*管理员-编辑-保存*/
function admin_edit_save(obj,id){
	var i = parent.layer.getFrameIndex();
	parent.layer.close(i);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$(obj).parents("tr").remove();
		layer.msg('已删除!',1);
	});
}
/*管理员-编辑*/
function admin_edit(id,w,h,title,url){
	layer_show(w,h,title,url);
}
/*管理员-停用*/
function admin_stop(obj,id){
	$(obj).parents("tr").find(".admin-manage").prepend('<a style="text-decoration:none" onClick="admin_start(this,\'10001\')" href="javascript:;" title="启用"><i class="icon-hand-up"></i></a>');
	$(obj).parents("tr").find(".admin-status").html('<span class="label radius">已停用</span>');
	$(obj).remove();
}
/*管理员-启用*/
function admin_start(obj,id){
	$(obj).parents("tr").find(".admin-manage").prepend('<a style="text-decoration:none" onClick="admin_stop(this,\'10001\')" href="javascript:;" title="停用"><i class="icon-hand-down"></i></a>');
	$(obj).parents("tr").find(".admin-status").html('<span class="label label-success radius">已启用</span>');
	$(obj).remove();
}
/*------------系统管理--------------*/
/*系统管理-日志-删除*/
function system_log_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$(obj).parents("tr").remove();
		layer.msg('已删除!',1);
	});
}
$(function(){
	/*返回顶部调用*/
	$(window).on("scroll",$backToTopFun);
	$backToTopFun();
});

//关键词和描述
function tdk(obj,k,d,t){
	var v = $(obj).val();
	$("#"+k).val(v);
	$("#"+d).val(v);
	if(t!=''){
	  $("#"+t).val(v);
	}	
}