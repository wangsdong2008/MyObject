<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/html5.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/respond.min.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/PIE_IE678.js"></script>
<![endif]-->
<link href="<?php echo ($DEFAULT_PATH); ?>/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome-ie7.min.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/iconfont/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>分类<?php echo ($u_name); ?>编辑</title>
</head>
<body>
<div class="pd-20">  
  <form class="form form-horizontal" action="savecategory" method="post" id="form-article-class">
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>上级栏目： </label>
      <div class="formControls col-5"><input type="hidden" name="cat_id" id="cat_id" value="<?php echo ($cat_id); ?>"> 
      <input type="hidden" name="uid" id="uid" value="<?php echo ($uid); ?>">        
        <select class="select" id="cat_path" name="cat_path" datatype="*" nullmsg="请选择父分类！">
          <option value="0">顶级分类</option>      
          <?php if(is_array($category_list)): $i = 0; $__LIST__ = $category_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$categorylist): $mod = ($i % 2 );++$i;?><option value="<?php echo ($categorylist["bpath"]); ?>" <?php echo ($categorylist["current_status"]); ?>><?php echo ($categorylist["spacenum"]); echo ($categorylist["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>分类名：</label>
      <div class="formControls col-5">        
        <input type="text" class="input-text" placeholder="输入分类名" id="cat_name" name="cat_name" datatype="*" nullmsg="分类名不能为空"  value="<?php echo ($cat_name); ?>" >
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>标题：</label>
      <div class="formControls col-5">        
        <input type="text" class="input-text" placeholder="输入标题" id="cat_title" name="cat_title" datatype="*"  value="<?php echo ($cat_title); ?>" <?php if($cat_id == 0): ?>onBlur="tdk(this,'cat_keyword','cat_description')"<?php endif; ?> >
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>关键词：</label>
      <div class="formControls col-5">      
        <input type="text" class="input-text" placeholder="请填写关键词" id="cat_keyword" name="cat_keyword" datatype="*" value="<?php echo ($cat_keyword); ?>" >
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>描述：</label>
      <div class="formControls col-5">  
        <textarea name="cat_description" id="cat_description" cols="30" rows="6" style="width:230px;" placeholder="请填写描述" datatype="*" ><?php echo ($cat_description); ?></textarea>
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>排序：</label>
      <div class="formControls col-5">        
        <input type="text" style="width:200px" class="input-text" placeholder="排序" id="cat_order" name="cat_order" datatype="n" nullmsg="排序不能为空"  value="<?php echo ($cat_order); ?>" >
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>状态：</label>
      <div class="formControls col-5 skin-minimal">
        <div class="radio-box">
          <label>
                <input name="cat_status" type="radio" id="cat_status_1" value="1" <?php if($cat_status == 1): ?>checked<?php endif; ?> >
           </label>
          <label for="cat_status-1">显示</label>
        </div>
        <div class="radio-box">
          <input type="radio" name="cat_status" value="0" id="cat_status_0" <?php if($cat_status == 0): ?>checked<?php endif; ?> >
          <label for="cat_status-2">隐藏</label>
        </div>        
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <div class="col-9 col-offset-3">
        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        <input class="btn btn-default radius width_60" type="buttom" value="关闭" onclick="closeWin()" >
      </div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/Validform_v5.3.2.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.doc.js"></script>
<script type="text/javascript">
$(function(){
	$("#form-article-class").Validform({
		tiptype:2,
	});	
});
</script>
</body>
</html>