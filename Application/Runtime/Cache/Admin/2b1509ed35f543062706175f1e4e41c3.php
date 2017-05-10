<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
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
<![endif]--><title>基本设置</title>
</head>
<style>
.w1{ width: 390px; }
</style>
<body>
<nav class="breadcrumb"><i class="iconfont">&#xf012b;</i> 首页 <span class="c-gray en">&gt;</span> 系统管理 <span class="c-gray en">&gt;</span> 基本设置  <a class="btn btn-success radius r mr-20" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="icon-refresh"></i></a></nav>
<div class="pd-20">
<form action="saveconfig" method="post" id="theForm">
<table class="table table-border table-bordered table-hover table-bg">
  <tr>
      <th class="text-r" width="100"><span class="c-red">*</span>网站开关：</th><td>
      <div class="formControls col-5">
         <div class="radio-box">
          <label>
                <input name="sys_switch" onClick="$('#switch_content').hide();" type="radio" id="is_show_1" value="1" <?php if($sys_switch == 1): ?>checked<?php endif; ?> >
           </label>
          <label for="is_show-1">打开</label>
        </div>
         <div class="radio-box">
          <input type="radio" name="sys_switch" onClick="$('#switch_content').show();" value="0" id="is_show_0" <?php if($sys_switch == 0): ?>checked<?php endif; ?> >
          <label for="is_show-2">关闭</label>
        </div>         
      </div>
      <div class="col-4"> </div>
      </td>
    </tr>
    <tbody id="switch_content" <?php if($sys_switch == 1): ?>style="display:none;"<?php else: ?>style="display:;"<?php endif; ?>>
    <tr>
      <th class="text-r" width="100">关闭内容：</th><td>
      <div class="formControls col-5">
        <input type="text" id="sys_switch_content" name="sys_switch_content" placeholder="" class="input-text w1" value="<?php echo ($sys_switch_content); ?>">        
      </div>
      <div class="col-4"> </div>
      </td>
    </tr>
    </tbody>

  <tbody>
    <tr>
      <th class="text-r" width="100"><span class="c-red">*</span>网站名称：</th><td>
      <div class="formControls col-5">
        <input type="text" id="sys_sitename" name="sys_sitename" placeholder="控制在5个字、40个字节以内" class="input-text w1" datatype="*5-20" nullmsg="网站名称不能为空" value="<?php echo ($sys_sitename); ?>">
        
      </div>
      <div class="col-4"> </div>
      </td>
    </tr>
    
    <tr>
      <th class="text-r" width="100">网址：</th><td>
      <div class="formControls col-5">
        <input type="text" id="sys_url" name="sys_url" placeholder="http://"  value="<?php echo ($sys_url); ?>" class="input-text w1" ignore="ignore" datatype="url" errormsg="请输入网址！" nullmsg="网址不能为空">
      </div>
      <div class="col-4"> </div>      
      </td>
    </tr>
    <tr>
      <th class="text-r" width="100">图片服务器地址：</th><td>
      <div class="formControls col-5">
        <input type="text" id="sys_img_url" name="sys_img_url" placeholder="http://"  value="<?php echo ($sys_img_url); ?>" class="input-text w1" ignore="ignore" datatype="url" errormsg="请输入图片服务器地址！" nullmsg="图片服务器地址不能为空">
      </div>
      <div class="col-4"> </div>      
      </td>
    </tr>
    <tr>
      <th class="text-r" width="100">CSS服务器地址：</th><td>
      <div class="formControls col-5">
        <input type="text" id="sys_css_url" name="sys_css_url" placeholder="http://"  value="<?php echo ($sys_css_url); ?>" class="input-text w1" ignore="ignore" datatype="url" errormsg="请输入CSS服务器地址！" nullmsg="CSS服务器地址不能为空">
      </div>
      <div class="col-4"> </div>      
      </td>
    </tr>
    <tr>
      <th class="text-r" width="100">js服务器地址：</th><td>
      <div class="formControls col-5">
        <input type="text" id="sys_js_url" name="sys_js_url" placeholder="http://"  value="<?php echo ($sys_js_url); ?>" class="input-text w1" ignore="ignore" datatype="url" errormsg="请输入js服务器地址！" nullmsg="js服务器地址不能为空">
      </div>
      <div class="col-4"> </div>      
      </td>
    </tr>
    <tr>
      <th class="text-r"><span class="c-red">*</span>标题：</th><td>
       <div class="formControls col-5">
        <input type="text" id="sys_title" name="sys_title" placeholder="40字左右" value="<?php echo ($sys_title); ?>" class="input-text w1"  nullmsg="标题不能为空">
      </div>
      <div class="col-4"> </div> 
      </td>
    </tr>
    <tr>
      <th class="text-r"><span class="c-red">*</span>关键词：</th><td>
      <div class="formControls col-5">
        <input type="text" id="sys_keywords" name="sys_keywords" placeholder="5个左右,8汉字以内,用英文,隔开" value="<?php echo ($sys_keywords); ?>" class="input-text w1"  datatype="*5-40" nullmsg="关键词不能为空" >
      </div>
      <div class="col-4"> </div>      
      </td>
    </tr>
    <tr>
      <th class="text-r"><span class="c-red">*</span>描述：</th><td>
      <div class="formControls col-5">
        <textarea cols="" rows="" class="input-text w1" style="height:80px;"  placeholder=""  dragonfly="true" nullmsg="描述不能为空！" name="sys_description" id="sys_description" ><?php echo ($sys_description); ?></textarea>
        <p class="textarea-numberbar"><em class="textarea-length"><?php echo ($description_count); ?></em></p>
      </div>      
      <div class="col-4"> </div> 
      </td>
    </tr>
    <tr>
      <th class="text-r">Logo：</th><td><input type="text" id="sys_logo" name="sys_logo" placeholder=""  value="<?php echo ($sys_logo); ?>"  class="input-text w1" style="width:300px;">&nbsp;<input class="btn btn-default radius btn-upload1" id="uploads" type="buttom" value="浏览..." onClick="upload(400,200,'上传logo','logo','sys_logo')" >       </td>
    </tr>
    <tr>
      <th class="text-r"><span class="c-red">*</span>上传目录配置：</th><td>
      <div class="formControls col-5">        
        <input type="text" id="sys_upload_img" name="sys_upload_img" placeholder="默认为uploadfile" value="<?php echo ($sys_upload_img); ?>"  class="input-text w1" datatype="*" nullmsg="上传目录不能为空" errormsg="上传目录不能为空！">
      </div>      
      <div class="col-4"> </div>
      </td>
    </tr>
    <tr>
      <th class="text-r"><span class="c-red">*</span>模版：</th><td>
      <div class="formControls col-5">        
        <select class="input-text w1" id="sys_model" name="sys_model" datatype="*" nullmsg="请选择模版">
          <option value="">请选择模版</option>      
          <?php if(is_array($model_list)): $i = 0; $__LIST__ = $model_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$modellist): $mod = ($i % 2 );++$i;?><option value="<?php echo ($modellist["model_id"]); ?>" <?php if($modellist["model_id"] == $sys_model): ?>selected<?php endif; ?>><?php echo ($modellist["model_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </div>      
      <div class="col-4"> </div>
      </td>
    </tr>
    <tr>
      <th class="text-r"><span class="c-red"></span>用户兴趣标签：</th><td>
      <div class="formControls col-5">
        <textarea cols="" rows="" class="input-text w1" style="height:80px;"  name="sys_tag" id="sys_tag"><?php echo ($sys_tag); ?></textarea>
      </div>
      <div class="col-4"> </div>
    </td>
    </tr>
    <tr>
      <th class="text-r"><span class="c-red"></span>统计代码：</th><td>
      <div class="formControls col-5">
        <textarea cols="" rows="" class="input-text w1" style="height:80px;"  name="sys_cnzz" id="sys_cnzz"><?php echo ($sys_cnzz); ?></textarea>      
      </div>      
      <div class="col-4"> </div> 
      </td>
    </tr>
    <tr>
      <th class="text-r">底部版权信息：</th><td><input type="text" id="sys_copyright" name="sys_copyright" placeholder="&copy; 2014 H-ui.net"  value="<?php echo ($sys_copyright); ?>" class="input-text w1"></td>
    </tr>
    <tr>
      <th class="text-r">备案号：</th><td><input type="text" id="sys_beian" name="sys_beian" placeholder="" value="<?php echo ($sys_beian); ?>"  class="input-text w1"></td>
    </tr>
    <tr>
      <th class="text-r">推荐百度</th>
      <td> <div class="radio-box">
          <label>
                <input name="sys_baidu_send" onClick="$('#baiduapi').show();" type="radio" id="sys_baidu_send_1" value="1" <?php if($sys_baidu_send == 1): ?>checked<?php endif; ?> >
           </label>
          <label for="sys_baidu_send-1">需要</label>
        </div>
         <div class="radio-box">
          <input type="radio" name="sys_baidu_send" onClick="$('#baiduapi').hide();" value="0" id="sys_baidu_send_0" <?php if($sys_baidu_send == 0): ?>checked<?php endif; ?> >
          <label for="sys_baidu_send-2">不需要</label>
        </div>           
        </td>
    </tr>
    <tr id="baiduapi" <?php if($sys_baidu_send == 0): ?>style="display:none"<?php endif; ?>>
      <th class="text-r">百度推送API代码</th>
      <td><input type="text" id="sys_baidu_api" name="sys_baidu_api" placeholder="" value="<?php echo ($sys_baidu_api); ?>" class="input-text w1" nullmsg="" ></td>
    </tr>
    <tr>
      <th class="text-r"></th><td><button name="system-base-save" id="system-base-save" class="btn btn-success radius" type="submit"><i class="icon-ok"></i> 确定</button></td>
    </tr>
  </tbody>
</table>
</form>
</div>
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/Validform_v5.3.2.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/layer1.8/layer.min.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/lib/laypage/laypage.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo ($DEFAULT_PATH); ?>/js/H-ui.admin.doc.js"></script>
<script type="text/javascript">
$(function(){
	$("#theForm").Validform({
		tiptype:2,
	});	
});
</script>
</body>
</html>