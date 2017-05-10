<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员登录-会员中心-<?php echo ($sys_sitename); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo ($css_model_path); ?>/css/login.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo ($css_model_path); ?>/css/Validform_style.css" />
<script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/Validform_v5.3.2_min.js"></script>
</head>
<body id="userlogin_body">

<!--网站顶部开始-->
<div id="header">
  <div class="wrapper">
    <div id="logo" style="float:left;"> <a href="/"> <img src="<?php echo ($img_model_path); ?>/images/logo.gif" alt="asp编程网" style="width:152px;height:78px;"/></a></div>
    <div class="top_tool" style="float:right;"> <a href="/" title="返回首页">返回首页</a><a href="<?php echo U('User/login');?>" title="会员登录">会员登录</a><a href="<?php echo U('User/reg');?>" title="会员注册">会员注册</a></div>
    <div class="clear"> </div>
  </div>
</div>
<!--网站顶部结束-->
<div class="wrapper">
  <div class="user_login_contant">
    <form name="myform" method="post" action="<?php echo U('dl');?>" id="Login">
      <div id="siteFactoryLogin">
        <div id="user_login">
          <dl>
            <dd id="user_main">
              <ul>
                <li class="user_main_name">
                  <label> 用户名：</label>
                  <input name="username" type="text" maxlength="20" id="username" tabindex="1" class="username" datatype="*" /><a class="Validform_checktip Validform_wrong">*</a>
                </li>
                <li class="user_password">
                  <label> 密 码：</label>
                  <input name="password" type="password" id="password" tabindex="2" class="userpass" datatype="*" /><a class="Validform_checktip Validform_wrong" style="color: #f00">*</a>
                </li>
                <li class="user_time">
                  <label>验证码：</label>
                  <input name="validationCode" type="text" value="" maxLength="4" size="1" class="username" tabindex="3" datatype="n4-4" style="width:86px;"><img src="<?php echo U('Index/verify');?>" style="width:60px; height:25px; vertical-align: middle" onclick="this.src='<?php echo U('Index/verify');?>';" alt="验证码"/><a class="Validform_checktip Validform_wrong">*</a>
                </li>
                <li class="login">
                	<input type="hidden" name="act" id="act" value="login" />
                    <input type="hidden" name="fromurl" id="fromurl" value="<?php echo ($fromurl); ?>" />
                    <input type="submit" class="btn_login" value="" />&nbsp;<a href="<?php echo U('getpassword');?>s" title="忘记密码？请点击" target="_blank" tabindex="6" style="font-size: 12px;">忘记密码？</a>
                </li>
              </ul>
            </dd>
          </dl>
        </div>
        <div class="user_login_info"> 如果您尚未在本站注册为会员，请先点此<a href="<?php echo U('User/reg');?>">注册</a>。 </div>
        <span id="ValrUserName" style="color:Red;display:none;"></span> <span id="ValrPassword" style="color:Red;display:none;"></span> <span id="ValrValidateCode" style="color:Red;display:none;"></span>
        <div id="ValidationSummary1" style="color:Red;display:none;"> </div>
      </div>
    </form>

  </div>
</div>
<div style="display:none;"><?php echo ($sys_cnzz); ?></div>
<script>
  $("#Login").Validform({
    tiptype:function(msg,o,cssctl){
      //msg：提示信息;
      //o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
      //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
      if(!o.obj.is("form")){
        var objtip=o.obj.siblings(".Validform_checktip");
        cssctl(objtip,o.type);
        objtip.text(msg);
      }
    }
  })
</script>
</body>
</html>