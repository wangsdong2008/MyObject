<?php if (!defined('THINK_PATH')) exit();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>教程信息-会员中心-<?php echo ($sys_sitename); ?></title>
    <link href="<?php echo ($css_model_path); ?>/css/default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ($css_model_path); ?>/css/model.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo ($js_model_path); ?>/js/jquery.js"></script>
    <style type="text/css">
        .fclick {
            cursor:pointer;
            text-decoration:underline;
        }
    </style>
</head>
<body>
<script>
    s = 2;
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
                <div class="user_sitepath"> 您现在的位置：<a title="<?php echo ($sys_sitename); ?>" href="<?php echo ($sys_url); ?>"><?php echo ($sys_sitename); ?></a></span><span> &gt; </span><span><a title="会员中心" href="<?php echo U('index');?>">会员中心</a></span><span> &gt; </span><span><a title="教程信息">教程信息</a></span><span> &gt; </span><span>我的教程信息</span><a id="YourPosition_SkipLink"></a></span></div>
                <div class="model_info_list">
                    <div class="model_info_sate mtop10">
                        <ul>
                            <!-- CSS Tabs -->
                            <li id="EliteContentList"<?php if($flg == '1'): ?>class="hover"<?php endif; ?>><span> <a id="LinkContentList" href="<?php echo U('newslist',array('flg'=>1));?>">已通过的教程信息</a></span> </li>
                            <li id="ElitePending"<?php if($flg == '0'): ?>class="hover"<?php endif; ?>><span> <a id="LinkPending" href="<?php echo U('newslist',array('flg'=>0));?>">待审核的教程信息</a></span> </li>
                            <li id="EliteAudited2"<?php if($flg == '-1'): ?>class="hover"<?php endif; ?>><span> <a id="LinkAudited2" href="<?php echo U('newslist',array('flg'=>-1));?>">未通过的教程信息</a></span> </li>
                        </ul>
                    </div>
                    <!--模型内容列表开始-->
                    <div class="model_info_content">
                        <!--列表开始-->
                        <form name="form1" method="post" action="?act=del&uid=1" onSubmit="return fdel('删除','教程信息')">
                            <div>
                                <table id="EgvContent" cellpadding="0" cellspacing="0" width="100%" class="model_info_table">
                                    <thead>
                                    <tr class="model_info_title">
                                        <th scope="col" style="width:3%;">&nbsp;</th>
                                        <th scope="col" style="width:6%;">ID</th>
                                        <th scope="col">标题</th>
                                        <th scope="col" style="width:8%;">点击数</th>
                                        <th scope="col" style="width:16%;">分类</th>
                                        <th scope="col" style="width:12%;">状态</th>
                                        <!--<th scope="col" style="width:10%;">作者</th>-->
                                        <th class="operate" scope="col" style="width:13%;">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($newslist['list'])): $i = 0; $__LIST__ = $newslist['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$newslist): $mod = ($i % 2 );++$i;?><tr class="listbg1">
                                        <td align="center"><input name="d" type="checkbox" id="d" value="<?php echo ($newslist["news_id"]); ?>"></td>
                                        <td><?php echo ($newslist["news_id"]); ?></td>
                                        <td class="content_left"><div class="linkType"><a href="<?php echo U('newsedit',array('id'=>$newslist['news_id']));?>" target="_blank" title="<?php echo ($newslist["news_title"]); ?>"><?php echo ($newslist["news_title"]); ?></a></div></td>
                                        <td><?php echo ($newslist["news_hits"]); ?></td>
                                        <td><?php echo ($newslist["cat_name"]); echo ($data); ?></td>
                                        <td>
                                            <?php if($newslist["is_show"] == '1'): ?><span style="color:green">通过</span>
                                                <?php elseif($newslist["is_show"] == '0'): ?>待审核
                                                <?php else: ?><span style="color:red">不通过</span><?php endif; ?></td>
                                       <!-- <td>佚名</td>
                                        <td>网络</td>-->
                                        <td><a href="<?php echo U('newsedit',array('id'=>$newslist['news_id']));?>">修改</a></td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    <tr>
                                        <td colspan="7" style="text-align:left; padding-left: 5px;"><label class="checkbox"><input id="ChkAll" type="checkbox"  onClick="CheckAll('d')"/>
                                            全选</label>
                                            <input type="submit" name="EBtnBatchDelete" value="批量删除"  id="EBtnBatchDelete" class="input_button" /></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="list_page">
                                    <?php echo ($pagefooter); ?>
                                </div>
                            </div>
                        </form>
                        <!--列表结束-->
                    </div>
                    <!--模型内容列表结束-->
                </div>
                <div class="clear"> </div>
                <div class="model_list_manage">
                    <form name="search" action="<?php echo U('newslist');?>" method="post">
                        &nbsp;&nbsp;搜索标题：
                        <select name="cat_id" id="cat_id">
                            <option value="0">选择所属分类</option>
                            <?php if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$categorylist): $mod = ($i % 2 );++$i;?><option value="<?php echo ($categorylist["cat_id"]); ?>" <?php if($categorylist["cat_id"] == $cat_id): ?>selected<?php endif; ?>><?php echo ($categorylist["cat_name"]); echo ($data); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <input name="keyword" type="text" id="keyword" class="inputxt" value="<?php echo ($keyword); ?>" />
                        <input type="submit" name="BtnSearch" value="搜索" id="BtnSearch" class="input_button" />
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
<!--网站底部结束-->
</body>
</html>