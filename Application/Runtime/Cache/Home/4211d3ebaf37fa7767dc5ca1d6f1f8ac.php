<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>贴吧-<?php echo ($sys_sitename); ?></title>
    <meta name="Description" content="贴吧，asp编程网技术讨论区域">
    <meta name="Keywords" content="贴吧，asp编程网技术讨论区域">
    <link href="<?php echo ($model_path); ?>/css/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="wrapper">
    <!--  顶部链接  -->

<div class="top_link">
  <div class="t_l" id="login_status"><?php echo ($loginstatus); ?></div>
  <div class="t_r" style="padding-right: 10px;"><a href="<?php echo U('flow');?>">购物车</a> <a href="javascript:void(0)" onclick="javascript:try{this.style.behavior='url(#default#homepage)';this.setHomePage('<?php echo ($sys_url); ?>');}catch(e){return false;}">设为首页</a> <a href="javascript:void(0)" onclick="javascript:try{window.external.AddFavorite('<?php echo ($sys_url); ?>','<?php echo ($sys_title); ?>');}catch(e){return false;}">加入收藏</a></div>
</div>
<!--  logo部分  -->
<div class="logo">
  <div class="asplogo"><a href="/"><img src="<?php echo ($img_model_path); ?>/images/logo.gif" alt="<?php echo ($sys_sitename); ?>" width="152" height="78" border="0" /></a></div>
  <div class="search_btn">
    <div class="tab2">
      <ul id="test2_li_now">
        <li class="now">教程</li>
        <li>帖子</li>
        <li>源码</li>
        <li>软件</li>
        <li>资讯</li>
      </ul>
    </div>
    <form method="get" name="searchform" id="searchform" action="http://www.aspbc.com/tech/search_tech.asp" onsubmit="return checksearch()" style="margin:0px;">
      <div class="tab_bottom">
        <div id="test2_1" class="tablist bloc">
          <div class="searchkeyword">
            <input type="text" name="keyword" id="keyword" class="w350" value="" />
            <input type="submit" name="" value="搜索" class="search_submit"/>
          </div>
          <div class="hot_keyword"><span style="font-weight:bold; color:red;">热门关键字：</span><a title="asp代码生成器" href="http://www.aspbc.com/soft/showsoft.asp?id=196" target="_blank">asp代码生成器</a>&nbsp;&nbsp;<a title="asp简单的采集代码教程" href="http://www.aspbc.com/tech/showtech.asp?id=274" target="_blank">asp采集</a>&nbsp;&nbsp;<a href="http://www.aspbc.com/tech/search_tech.asp?keyword=asp.net%E4%B8%89%E5%B1%82%E6%9E%B6%E6%9E%84" target="_blank">三层架构</a></div>
        </div>
      </div>
    </form>
  </div>
</div>
<!--  导航链接  -->
<div class="nav_link border">
  <ul>
    <?php if(is_array($navlist)): $i = 0; $__LIST__ = $navlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$navlist): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($navlist["nav_url"]); ?>"><?php echo ($navlist["nav_title"]); ?></a>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  <div class="clear"></div>
</div>
<!--  导航  -->
<div class="nav m10">
  <ul>
    <li class="onlink"><a href="<?php echo ($sys_url); ?>">首页</a></li>
    <li><a href="<?php echo U('tech');?>">技术教程</a></li>
    <li><a href="<?php echo U('soft');?>">软件下载</a></li>
    <li><a href="<?php echo U('code');?>">源码下载</a></li>
    <li><a href="<?php echo U('bbs');?>">贴吧</a></li>
    <li><a href="<?php echo U('about');?>">关于我们</a></li>
  </ul>
  <div style="float:right; width:160px; color:#FFF;">本站QQ交流群：41991607</div>
</div>
<script src="<?php echo ($js_model_path); ?>/js/jquery.js"></script>
    <!--  正文  -->
    <table class="tahoma" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td height="50" class="cheng"><img src="<?php echo ($model_path); ?>/images/notice.gif" alt="ASP编程网全面上线了，欢迎大家一起学习交流！！！" width="9" height="9"><b> ASP编程网全面上线了，欢迎大家一起学习交流！！！</b></td>

        </tr>
        </tbody></table>

    <!------------------------------------------------------------------- 教程 Strat -->
    <table border="0" cellpadding="3" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td height="8"></td>
        </tr>
        <tr>
            <td class="white" style="padding-left: 8px;" background="<?php echo ($model_path); ?>/images/bg1.gif" bgcolor="#5D9BDF" height="25">◎ <b>教程版块</b></td>
        </tr>
        <tr>
            <td bgcolor="#D0E5F5" height="4"></td>
        </tr>
        </tbody>
    </table>
    <table style="border: 1px solid #D3E0EB;" border="0" cellpadding="3" cellspacing="0" width="100%">
        <tbody>
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tahoma">
                    <tbody>
                    <?php if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$categorylist): $mod = ($i % 2 );++$i;?><!--------------------------------------- <?php echo ($categorylist["cat_name"]); echo ($data); ?> Strat -->
                    <tr>
                        <td width="6%" height="110" align="center"><img src="<?php echo ($model_path); ?>/images/new.gif" width="38" height="38" alt="新贴"></td>
                        <td style="line-height: 150%;">
                            <a href="<?php echo U('showbbsclass',array('id'=>$categorylist['cat_id']));?>">『<b><?php echo ($categorylist["cat_name"]); ?>吧</b> 』</a>（<?php echo ($categorylist["num"]); ?>篇）<br>
                            此区域只可以发布跟<?php echo ($categorylist["cat_name"]); echo ($data); ?>相关的主题帖~~，禁止灌水！<br>
                        </td>
                        <td width="36%" style="line-height: 150%;">
                            新帖：<a href="<?php echo U('showbbs',array('id'=>$categorylist['list']['threadid']));?>"><?php echo ($categorylist["list"]["topic"]); ?></a><br>
                            发帖：<?php echo ($categorylist["list"]["postname"]); ?><br>
                            发帖时间：<span class="time"><?php echo (date("Y-m-d H:i:s",$categorylist["list"]["posttime"])); ?></span><br>
                            主题：<span class="heise"><?php echo ($categorylist["num"]); ?></span>　
                            帖子：<span class="heise"><?php echo ($categorylist["postsnum"]); ?></span>　
                            今日：<span class="heise"><?php echo ($categorylist["daypostsnum"]); ?></span>
                        </td>
                    </tr>
                    <!--------------------------------------- <?php echo ($categorylist["cat_name"]); echo ($data); ?> End --><?php endforeach; endif; else: echo "" ;endif; ?>

                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <!------------------------------------------------------------------- 教程 End -->


    <div class="foot_nav m10 border">
<p><a href="/about/">关于我们</a>-网站帮助-广告合作-诚聘英才-下载声明-<a href="http://www.aspbc.com/sitemap.xml">网站地图</a></p>
</div>
<div class="bottom">
<?php echo ($sys_copyright); ?>--
</div>
<div style="display:none;"><?php echo ($sys_cnzz); ?></div>

</div>

</body>
</html>