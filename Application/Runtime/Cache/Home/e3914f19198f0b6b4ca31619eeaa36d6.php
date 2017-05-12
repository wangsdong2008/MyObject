<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AdminLTE bootstrap 后台框架-开发软件-软件下载-asp编程网</title>
<meta name="Description" content="超级漂亮的AdminLTE bootstrap 后台框架">
<meta name="Keywords" content="AdminLTE">
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
      <div class="position">当前位置：<a href="<?php echo ($sys_url); ?>"><?php echo ($sys_sitename); ?></a>><a href="<?php echo U('soft');?>">软件下载</a>><a href="<?php echo U('softlist',array('id'=>$GoodsDetail['cat_id']));?>"><?php echo ($GoodsDetail["cat_name"]); ?></a>>&nbsp;&nbsp;正文</div>
      <div class="techlist border">
        <div class="con_main">
          <h1><?php echo ($GoodsDetail["goods_name"]); ?></h1>
          <div class="software-summary" style="margin-top:20px;">
                <div class="image">
                    <span>
                       <img src="<?php echo ($sys_url); ?>/<?php echo ($sys_upload_img); ?>/<?php echo ($GoodsDetail["goods_img"]); ?>" onerror="this.src='<?php echo ($img_model_path); ?>/images/noimage.gif'" alt="<?php echo ($GoodsDetail["goods_name"]); ?>"  />
                    </span>
                </div>
              <form action="<?php echo U('addflow');?>" method="post">
                <ul class="clearfix software-infolist">
                    <li>
                        <strong>软件作者:</strong>
                        <span class="author">&nbsp;</span>
                    </li>
                    <li class="right monials">感谢<?php echo ($GoodsDetail["true_name"]); ?>对本软件的更新 </li>
                    <li><strong>软件大小:</strong>  </li>
                    <li class="right"><strong>软件类别:</strong> 国产软件</li>
                    <li><strong>软件评级:</strong> <img src="<?php echo ($img_model_path); ?>/images/5star.gif" alt="5星级" /></li>
                    <li class="right"><strong>更新时间:</strong><?php echo (date("Y-m-d H:i:s",$GoodsDetail["goods_time"])); ?></li>
                    <li><strong>下载积分:</strong> <em><?php echo ($GoodsDetail["goods_price"]); ?></em></li>
                    <li class="right"><strong>插件情况:</strong> <img src="<?php echo ($img_model_path); ?>/images/plugin1.gif" alt="插件情况" /></li>
                    <li><strong>相关链接:</strong> <a title="<?php echo ($GoodsDetail["goods_name"]); ?>" target="_blank">Home Page</a> </li>
                    <li class="right"><strong>演示地址:</strong> <a>Demo Url</a> </li>
                    <li style="height: 25px;"><input type="hidden" id="goods_id" name="goods_id" value="<?php echo ($goods_id); ?>"><input type="submit" value="加入购物车"></li>
                    <li class="right"> </li>
                </ul>
              </form>
          </div>
          <div style=" margin:0 auto; display:inline-block; width:620px; margin-top:10px;" class="border">
          	<div class="title">
              <h4>详细介绍</h4>
            </div>
          	<div style="padding:10px; line-height:22px;"><?php echo (htmlspecialchars_decode($GoodsDetail["goods_content"])); ?></div>
          </div>
          <div class="lastnext" style="margin-top: 0px;">
                <?php if(is_array($goods_about)): $k = 0; $__LIST__ = $goods_about;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_about): $mod = ($k % 2 );++$k;?><p><?php if($k == 1): ?>上一篇<?php else: ?>下一篇<?php endif; ?>：
                        <?php if($goods_about["goods_id"] == 0): echo ($goods_about["goods_name"]); ?>
                            <?php else: ?>
                            <a href="<?php echo U('showsoft',array('id'=>$goods_about['goods_id']));?>" title="<?php echo ($goods_about["goods_name"]); ?>"><?php echo ($goods_about["goods_name"]); ?></a><?php endif; ?>
                    </p><?php endforeach; endif; else: echo "" ;endif; ?>

            </div>
        </div>
      </div>
      <div class="black"></div>
      <div class="tech_news border">
        <!--  最新相关教程-->
        <div class="title">
            <h4>最新<?php echo ($GoodsDetail["cat_name"]); ?></h4>
        </div>
        <ul class="technewsul">
            <?php if(is_array($codelist)): $i = 0; $__LIST__ = $codelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$codelist): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('showsoft',array('id'=>$codelist['goods_id']));?>" target="_blank" title="<?php echo ($codelist["goods_name"]); ?>"><?php echo ($codelist["goods_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="clearit"></div>
      </div>
    </div>
    <div class="con_right">
        <!--  右侧广告链接部分  -->
<div class="r_link border">
    <!--  热门教程  -->
    <div class="title2">
        <h4>热门下载</h4>
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
  <!--  底部导航  -->
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