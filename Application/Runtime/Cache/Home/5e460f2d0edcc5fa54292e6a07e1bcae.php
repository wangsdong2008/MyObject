<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>修改密码-会员中心-<?php echo ($sys_sitename); ?></title>
    <meta content="xxxxxxxxx" name="Keywords" />
    <meta content="xxxxxx" name="Description" />
    <link href="<?php echo ($css_model_path); ?>/css/default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ($css_model_path); ?>/css/model.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/jquery.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo ($css_model_path); ?>/css/Validform_style.css" />
    <script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/Validform_v5.3.2_min.js"></script>
</head>
<body>
<script>
    s = 1;
</script>
<div class="wrapper">
    <!--网站内容开始-->
    <div class="user_main_all">
        <!--会员中心顶部菜单导航开始-->
        <div class="user_header">
    <!--菜单定义开始-->
    <div class="user_menu">
    <ul>
        <li class="current"><span><a href="<?php echo U('index');?>"><img src="<?php echo ($img_model_path); ?>/images/ico_home.gif" alt="会员首页" align="absmiddle"/>会员首页</a></span></li>
        <li><span><a href=""><img src="<?php echo ($img_model_path); ?>/images/ico_content_manage.gif" alt="信息管理" align="absmiddle"/>信息管理</a></span></li>
        <li><span><a href=""><img src="<?php echo ($img_model_path); ?>/images/ico_friend.gif" alt="好友管理" align="absmiddle"/>好友管理</a></span></li>
        <li><span><a href=""><img src="<?php echo ($img_model_path); ?>/images/ico_promotion_manage.gif" alt="推广管理" align="absmiddle"/>推广管理</a></span></li>
    </ul>
</div>
    <!--菜单定义结束-->
    <!--快捷导航开始-->
    <div class="user_header_guild">
        <div class="user_header_link"> <a href="/" target="_blank"><img src="<?php echo ($img_model_path); ?>/images/Home.gif" border="0" title="网站首页"/></a> </div>
        <div class="user_guild"> <span class="user_header_photo"><a href=""> <img class="smallAvatar" src="<?php echo ($sys_url); ?>/<?php echo ($sys_upload_img); ?>/<?php echo ($users["face"]); ?>" align="absmiddle" /></a> <a href="<?php echo U('User/index');?>" class="rank"><?php echo ($users["username"]); ?></a> </span><span><a href="#" class="sms">短消息<em>(0)</em></a></span> <span><a href="<?php echo U('loginout');?>" class="loginout">退出</a></span> </div>

        <!--快捷导航结束-->
    </div>
</div>

        <!--会员中心顶部菜单导航结束-->
        <!--会员主体定义开始-->
        <div class="user_main">
            <!--会员信息侧边栏目开始-->
            <!--会员信息侧边栏目开始-->
<div class="user_sidebar">
    <div>
        <h3><span>个人信息</span></h3>
        <ul>
            <li id="f2"><a href="<?php echo U('user_info');?>" title="修改个人信息">修改个人信息</a></li>
            <li id="f3"><a href="<?php echo U('modifypass');?>" title="修改密码">修改密码</a></li>
            <li id="f4"><a href="<?php echo U('myintegralrecord');?>" title="我的积分">我的积分</a></li>
            <li id="f5"><a href="<?php echo U('yqm');?>" title="我的邀请码">我的邀请码</a></li>
            <!--<li id="f15"><a href="user_message.asp" title="短信中心">短信中心</a></li>-->
        </ul>
    </div>
    <div>
        <h3> <span>编程教程管理</span></h3>
        <ul>
            <li id="f6"><a href="<?php echo U('newslist');?>">编程教程管理</a></li>
            <li id="f7"><a href="<?php echo U('newsadd');?>">添加编程教程</a></li>
        </ul>
    </div>
   <!-- <div>
        <h3> <span>新闻管理</span></h3>
        <ul>
            <li id="f8"><a href="user_article.asp?act=list&amp;uid=2">新闻管理</a></li>
            <li id="f9"><a href="user_article.asp?uid=2">添加新闻</a></li>
        </ul>
    </div>
    <div>
        <h3> <span>源码管理</span></h3>
        <ul>
            <li id="f10"><a href="user_soft.asp?act=list&uid=3">源码管理</a></li>
            <li id="f11"><a href="user_soft.asp?uid=3">添加源码</a></li>
        </ul>
    </div>
    <div>
        <h3> <span>软件管理</span></h3>
        <ul>
            <li id="f12"><a href="user_soft.asp?act=list&uid=4">软件管理</a></li>
            <li id="f13"><a href="user_soft.asp?uid=4">添加软件</a></li>
        </ul>
    </div>
    <div>
        <h3> <span>帖子管理</span></h3>
        <ul id="left_f">
            <li id="f14"><a href="user_threads.asp?act=list">帖子管理</a></li>
        </ul>
    </div>-->
</div>
<script type="text/javascript">
   $(function(){
       $(".user_sidebar h3").each(function(){
          $(this).click(function(){
              $(this).next().show().parent().siblings("div").find("ul").hide();
          })
       })
       $(".user_sidebar h3").eq(s*1-1).click();
   })

</script>
<!--会员信息侧边栏目结束-->
            <!--会员信息侧边栏目结束-->
            <!--右侧定义框架开始 -->
            <div class="user_summary">
                <div class="user_sitepath"> 您现在的位置：<a title="<?php echo ($sys_sitename); ?>" href="<?php echo ($sys_url); ?>"><?php echo ($sys_sitename); ?></a></span><span> &gt; </span><span><a title="会员中心" href="<?php echo U('index');?>">会员中心</a></span><span> &gt; </span><span><a title="个人信息">个人信息</a></span><span> &gt; </span><span>修改密码</span><a id="YourPosition_SkipLink"></a></span></div>
                <div class="model_info_list">
                    <form name="MainForm" id="theForm" method="post" action="<?php echo U('savepassword');?>">
                        <div class="model_info_sate mtop10">
                            <ul>
                                <li class="hover" id="TabTitle0"><span><a href="javascript:void(0)">修改密码</a></span></li>
                            </ul>
                        </div>
                        <div class="model_info_content">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="width: 100%; padding-left: 0;" valign="top"><table style="width: 100%; table-layout: fixed;" cellspacing="1" cellpadding="0" class="table_style" id="Tabs0">
                                        <tr class="first">
                                            <td style="width: 16%;" class="ok_tab"> 旧 密 码： </td>
                                            <td style="width: 38%;"><input name="old_password" id="old_password" value="" maxlength="20" type="password" style="width:200px;" class="inputxt" errormsg="旧密码不能为空" datatype="*" /><a class="Validform_checktip Validform_wrong">*</a></td>
                                        </tr>

                                        <tr>
                                            <td class="ok_tab"> 新 密 码： </td>
                                            <td><span id="LblUserName"><input name="new_password" id="new_password" value="" maxlength="20" type="password" style="width:200px;"  class="inputxt" errormsg="密码范围在6~18位之间！"  datatype="*6-18" /><a class="Validform_checktip Validform_wrong">*</a></span></td>
                                        </tr>
                                        <tr>
                                            <td class="ok_tab">确认密码： </td>
                                            <td><input name="again_password" id="again_password" value="" maxlength="20" type="password" style="width:200px;" class="inputxt"  datatype="*" recheck="new_password" errormsg="您两次输入的账号密码不一致！" /><a class="Validform_checktip Validform_wrong">*</a></td>
                                        </tr>
                                    </table></td>
                                </tr>
                            </table>
                            <div class="ok_bottom">
                                <input class="submit_button_six" type="submit" name="EBtnSubmit" value="修改密码" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--右侧定义框架结束 -->
            <div class="clear"> </div>
        </div>
        <!--会员主体定义结束-->
        <!--网站内容结束-->
    </div>
</div>
<!--网站底部开始-->
<!--网站底部开始-->
<div class="foot">
    <div class="wrapper">
        <div class="usercopyright"> <a href="http://www.aspbc.com" title="asp编程网" target="_blank">asp编程网 版权所有-</a>Copyright 2003-2010</div>
    </div>
</div>
<div style="display:none;">
    <?php echo ($sys_cnzz); ?>
</div>
<!--网站底部结束-->
<script>
    $("#theForm").Validform({
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
<!--网站底部结束-->
</body>
</html>