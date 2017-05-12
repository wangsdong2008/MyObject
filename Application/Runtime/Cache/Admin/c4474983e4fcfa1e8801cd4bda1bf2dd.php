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
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/icheck/icheck.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/font-awesome/font-awesome-ie7.min.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link href="<?php echo ($DEFAULT_PATH); ?>/lib/iconfont/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>添加广告</title>
  <style>
    .adstyle{display: none;}
  </style>
</head>
<body>
<div class="pd-20">
  <form action="<?php echo U('adsave');?>" method="post" class="form form-horizontal" id="form-ad-add">
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>所属分类： </label>
      <div class="formControls col-5">      
        <select class="select" id="cat_id" name="cat_id" datatype="*" nullmsg="请选择所属分类！">
          <option value="">请选择所属分类</option>      
          <?php if(is_array($category_list)): $i = 0; $__LIST__ = $category_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$categorylist): $mod = ($i % 2 );++$i;?><option value="<?php echo ($categorylist["cat_id"]); ?>" <?php if($categorylist["cat_id"] == $cat_id): ?>selected<?php endif; ?>><?php echo ($categorylist["spacenum"]); echo ($categorylist["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </div>
      <div class="col-4"> </div>
    </div>    
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>广告名称：</label>
      <div class="formControls col-5">      
        <input type="text" class="input-text" placeholder="请填写广告名称" id="ad_name" name="ad_name" datatype="*2-50" nullmsg="广告名称不能为空" value="<?php echo ($ad_name); ?>" ><input type="hidden" name="ad_id" id="ad_id" value="<?php echo ($ad_id); ?>">
      </div>
      <div class="col-4"> </div>
    </div>
    
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>广告类型：</label>
      <div class="formControls col-5 skin-minimal">
        <div class="radio-box">
          <label>
                <input type="radio" name="ad_style" id="ad_style_1" value="1" >
           </label>
          <label for="ad_style-1">图片</label>
        </div>
        <div class="radio-box">
          <input type="radio" name="ad_style" value="2" id="ad_style_2" >
          <label for="ad_style-2">产品</label>
        </div>
        <div class="radio-box">
          <input type="radio" name="ad_style" value="3" id="ad_style3" >
          <label for="ad_style-3">其它</label>
        </div>
      </div>
      <div class="col-4"> </div>
    </div>
    <div id="content">
    <div class="adstyle">
      <div class="row cl">
        <label class="form-label col-3">图片：</label>
        <div class="formControls col-5"><input type="text" class="input-text" placeholder="请上传图片！" id="ad_logo" name="ad_logo" ignore="ignore" datatype="*" value="<?php echo ($ad_logo); ?>" style="width:150px;">&nbsp;<input class="btn btn-default radius btn-upload1" id="uploads" type="buttom" value="浏览..." onclick="upload(500,50,'上传广告图片','ad','ad_logo')" />        </div>
         <div class="col-4"> </div>
      </div>
       <div class="row cl">
         <label class="form-label col-3"><span class="c-red">*</span>链接：</label>
         <div class="formControls col-5"><input type="text" class="input-text" placeholder="请填写链接" ignore="ignore"  id="ad_url" name="ad_url" datatype="*" nullmsg="广告链接不能为空" value="<?php echo ($ad_url); ?>" ></div>
         <div class="col-4"> </div>
       </div>
    </div>
    <div class="adstyle">
      <div class="row cl">
        <label class="form-label col-3"><span class="c-red">*</span>产品ID：</label>
        <div class="formControls col-5">
          <input type="text" class="input-text" ignore="ignore"  placeholder="请填写产品ID" id="goods_id" name="goods_id" datatype="n" nullmsg="产品ID" value="<?php echo ($goods_id); ?>" >
        </div>
        <div class="col-4"> </div>
      </div>
    </div>
      <div class="adstyle">
        <div class="row cl">
          <label class="form-label col-3"><span class="c-red">*</span>代码：</label>
          <div class="formControls col-5">
            <textarea name="ad_code" id="ad_code" cols="30" rows="6" ignore="ignore" style="width:230px;" placeholder="请填写广告代码" datatype="*" ><?php echo ($ad_code); ?></textarea>
          </div>
          <div class="col-4"> </div>
        </div>
      </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>描述：</label>
      <div class="formControls col-5">
        <textarea name="intro" id="intro" cols="30" rows="6" style="width:230px;" placeholder="请填写描述" datatype="*2-255" ><?php echo ($intro); ?></textarea>
      </div>
      <div class="col-4"> </div>
    </div>
    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>开始时间：</label>
      <div class="formControls col-5">
        <input type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="input-text" placeholder="请填写开始时间" id="ad_starttime" name="ad_starttime" datatype="*" value="<?php echo (date('Y-m-d H:i:s',$ad_starttime)); ?>" >
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>结束时间：</label>
      <div class="formControls col-5">
        <input type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="input-text" placeholder="请填写结束时间" id="ad_endtime" name="ad_endtime" datatype="*" value="<?php echo (date('Y-m-d H:i:s',$ad_endtime)); ?>" >
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>顺序：</label>
      <div class="formControls col-5">
        <input type="text" class="input-text" placeholder="请填写顺序" id="ad_order" name="ad_order" datatype="n" value="<?php echo ($ad_order); ?>" >
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-3"><span class="c-red">*</span>状态：</label>
      <div class="formControls col-5 skin-minimal">
        <div class="radio-box">
          <label>
                <input name="is_show" type="radio" id="is_show_1" value="1" <?php if($is_show == 1): ?>checked<?php endif; ?> >
           </label>
          <label for="is_show-1">显示</label>
        </div>
        <div class="radio-box">
          <input type="radio" name="is_show" value="0" id="is_show_0" <?php if($is_show == 0): ?>checked<?php endif; ?> >
          <label for="is_show-2">隐藏</label>
        </div>
      </div>
      <div class="col-4"> </div>
    </div>

    <div class="row cl">
      <div class="col-9 col-offset-3">
        <input type="submit" class="btn btn-primary radius" value="  提交  ">
        <input type="buttom" class="btn btn-default radius width_60" value="关闭" onclick="closeWin()" >
      </div>
    </div>
  </form>
</div>
</div>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/layer1.8/layer.min.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/laypage/laypage.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/icheck/jquery.icheck.min.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/Validform_v5.3.2.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.js"></script>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.doc.js"></script>
<script type="text/javascript">
$(function(){
	$("#form-ad-add").Validform({
		tiptype:2,
        ignore: ":hidden"
	});
  $("input[name=ad_style]").each(function(index){
    $(this).click(function(){
      $(".adstyle").eq(index).show().siblings(".adstyle").hide();
    });
  });

  $("input[name='ad_style']").eq(<?php echo ($ad_style-1); ?>).click();
});
</script>

</body>
</html>