<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo ($categorylist["cat_title"]); ?>-软件下载-<?php echo ($sys_sitename); ?></title>
  <meta name="Keywords" content="<?php echo ($categorylist["cat_keyword"]); ?>">
  <meta name="Description" content="<?php echo ($categorylist["cat_description"]); ?>">
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
  <div class="container m10">
    <div class="con_left">
      <!--  左侧正文内容部分  -->
      <div class="position">当前位置：<a href="<?php echo ($sys_url); ?>"><?php echo ($sys_sitename); ?></a>><a href="<?php echo U('soft');?>">软件下载</a>>&nbsp;&nbsp;<?php echo ($categorylist["cat_name"]); ?></div>
      <div class="techlist border">
        <ul class="techlistul">
          <?php if(is_array($goodslist["list"])): $i = 0; $__LIST__ = $goodslist["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goodslist): $mod = ($i % 2 );++$i;?><li><span><?php echo (date("Y-m-d",$goodslist["goods_time"])); ?></span><a href="<?php echo U('showsoft',array('id'=>$goodslist['goods_id']));?>" target="_blank" title="<?php echo ($goodslist["goods_name"]); ?>"><?php echo ($goodslist["goods_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="fy"><strong>1</strong>&nbsp;</div>
      </div>
    </div>
    <div class="con_right">

  <div class="r_link border">
    <!--  热门教程  -->
    <div class="title2">
      <h4>热门软件</h4>
    </div>
    <ul class="hourul">
      <?php if(is_array($hotgoodslist)): $i = 0; $__LIST__ = $hotgoodslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hotgoodslist): $mod = ($i % 2 );++$i;?><li class="onlink"><a href="<?php echo U('showsoft',array('id'=>$hotgoodslist['goods_id']));?>" target="_blank" title="<?php echo ($hotgoodslist["goods_name"]); ?>"><?php echo ($hotgoodslist["goods_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  </div>
  <div class="black"></div>
  <div class="r_link border">
    <!--  下载排行榜  -->
    <div class="title2">
      <h4>下载排行榜</h4>
    </div>
    <ul class="hourul">
      <li class="onlink"><a href="http://www.aspbc.com/soft/showsoft.asp?id=208" target="_blank" title="AdminLTE bootstrap 后台框架">AdminLTE&nbsp;bootstrap&nbsp;后台框架</a></li>
    </ul>
  </div>
</div>

    <div class="clearit"></div>
    <div class="shownewsbuttom"></div>
  </div>
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