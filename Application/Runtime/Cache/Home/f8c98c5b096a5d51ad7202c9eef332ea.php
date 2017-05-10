<?php if (!defined('THINK_PATH')) exit();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>教程信息-会员中心-<?php echo ($sys_sitename); ?></title>
    <link href="<?php echo ($css_model_path); ?>/css/default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ($css_model_path); ?>/css/model.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/jquery.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo ($css_model_path); ?>/css/Validform_style.css" />
    <script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/Validform_v5.3.2_min.js"></script>
    <style type="text/css">
        .fclick {
            cursor:pointer;
            text-decoration:underline;
        }
    </style>
</head>
<body>
<script>
    s=2;
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
        <h3> <span>订单管理</span></h3>
        <ul>
            <li id="f8"><a href="<?php echo U('myorder');?>">我的订单</a></li>
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
                <script type="text/javascript" charset="utf-8" src="<?php echo ($js_model_path); ?>/kindeditor/kindeditor.js"></script>
                <script type="text/javascript" charset="utf-8" src="<?php echo ($js_model_path); ?>/kindeditor/lang/zh_CN.js"></script>
                <script type="text/javascript" charset="utf-8">
                    var editor;
                    KindEditor.ready(function(K) {
                        editor = K.create('textarea[name="news_content"]', {width:"80%",afterBlur: function(){this.sync();}});
                    });
                </script>
                <div class="user_sitepath"> 您现在的位置：<a title="<?php echo ($sys_sitename); ?>" href="<?php echo ($sys_url); ?>"><?php echo ($sys_sitename); ?></a></span><span> &gt; </span><span><a title="会员中心" href="<?php echo U('index');?>">会员中心</a></span><span> &gt; </span><span><a title="教程信息">教程信息</a></span><span> &gt; </span><span>添加教程信息</span><a id="YourPosition_SkipLink"></a></span></div>
                <form name="theForm" id="theForm" method="post" action="<?php echo U('newssave');?>">
                    <div class="model_content_wrap">
                        <div class="model_content_top">
                            <h3> 添加教程信息 </h3>
                        </div>
                        <div class="model_content_center">
                            <ul class="add_model_content">
                                <li>
                                    <label> 所属分类：</label>
                                    <select name="cat_id" id="cat_id" errormsg="请选择分类" datatype="*">
                                        <option value="">选择所属分类</option>
                                        <?php if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$categorylist): $mod = ($i % 2 );++$i;?><option value="<?php echo ($categorylist["cat_id"]); ?>" <?php if($categorylist["cat_id"] == $newslist['cat_id']): ?>selected<?php endif; ?>><?php echo ($categorylist["cat_name"]); echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                    <a class="Validform_checktip Validform_wrong">*</a>
                                </li>
                                <li>
                                    <label> 标题：</label>
                                    <input name="news_title" id="news_title" value="<?php echo ($newslist["news_title"]); ?>" size="80" maxlength="100" tyep="text" class="inputxt" errormsg="标题不能为空" datatype="*"><a class="Validform_checktip Validform_wrong">*</a>
                                    <input type="text" name="news_id" id="news_id" value="<?php echo ($newslist["news_id"]); ?>">
                                </li>
                                <li>
                                    <label> 来源：</label>
                                    <input name="news_from" id="news_from" value="<?php echo ($newslist["news_from"]); ?>" maxlength="40" size="40" tyep="text" class="inputxt">
                                    <span class="fclick" rel="网络">网络</span>
                                    <span class="fclick" rel="www.aspbc.com"><?php echo ($sys_sitename); ?></span></li>
                                <li>
                                    <label> 作者：</label>
                                    <input name="news_author" id="news_author" value="<?php echo ($newslist["news_author"]); ?>" size="40" maxlength="40" tyep="text" class="inputxt">
                                    <span class="fclick" rel="佚名">佚名</span>
                                    <span class="fclick" rel="<?php echo ($users["username"]); ?>"><?php echo ($users["username"]); ?></span>
                                </li>
                                <li>
                                    <label> 教程内容：</label>
                                    <textarea style="width:550px; height:350px;" id="news_content" rows="50" cols="10" name="news_content" errormsg="教程内容不能为空" datatype="*"><?php echo ($newslist["news_content"]); ?></textarea><a class="Validform_checktip Validform_wrong">*</a>
                                </li>
                            </ul>
                            <div class="submit_model_content">
                                <input type="submit" name="BtnSave" value="提交" class="submit_button" />
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <!--右侧定义框架结束 -->
            <div class="clear"> </div>
        </div>
        <!--会员主体定义结束-->
        <!--网站内容结束-->
    </div>
</div>
<!--网站底部开始-->
<script>
    $(function(){
        $(".fclick").each(function(){
            $(this).click(function(){
                $(this).parent().find("input").val($(this).attr("rel"));
            })
        })
    })
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